// CONFIG
const port = 3000;

// Initialization modules
const app = require('express')();
const http = require('http').Server(app);
const io = require('socket.io')(http, {
    path: '/nodejs'
});
const jwt = require('socketio-jwt');
require('dotenv').config({path: '.env'});
const axios = require('axios');
const { DateTime } = require('luxon');
const Datastore = require('nedb');

// Chat history
const db_history = new Datastore({filename : 'chat_history', autoload: true});

let online_users = [];
let banned_users = [];

//FORUM CHAT
let fchat_last = [];
const fchat_rps = [];

http.listen(port, function(){
    console.log('listening on *:' + port);
});

const mysql = require('mysql');
const pool = mysql.createPool({
    connectionLimit : 10,
    host     : process.env.DB_HOST,
    user     : process.env.DB_USERNAME,
    password : process.env.DB_PASSWORD,
    database : process.env.DB_DATABASE
});

function getDateTime() {
    return DateTime.local().setZone('Europe/Moscow');
}

function updateBans() {
    pool.query('SELECT bannable_id, expired_at, comment FROM bans WHERE expired_at > now() AND deleted_at IS NULL', [], function (error, results, fields) {
        if (error) throw error;

        banned_users = results;
    });
}

setInterval(function (){
    updateBans();
}, 5000);

setInterval(function (){
    io.emit('forum.online', online_users);
}, 15000);

function checkBan(id){
    return banned_users.find(ban => ban.bannable_id === id);
}

function isRateLimited(key, timeoutMs = 2000) {
    const now = Date.now();
    if (fchat_rps[key] && (now - fchat_rps[key]) < timeoutMs) {
        return true;
    }

    fchat_rps[key] = now;
    return false;
}

io.on('connection', function (socket) {
    socket.emit('forum.online', online_users);

    socket.on('forum.chat.load', function(){
        if (isRateLimited(socket.conn.id)) {
            return;
        }

        socket.emit('forum.chat.load', fchat_last);
    });
}).on('connection', jwt.authorize({
    secret: process.env.JWT_SECRET,
    timeout: 15000
})).on('authenticated', function(socket) {
    const user = socket.decoded_token;
    user.socket = socket.conn.id;
    user.time = getDateTime().toLocaleString(DateTime.TIME_24_WITH_SECONDS);

    if (typeof user.role === 'string' && user.role.toLowerCase().includes('игрок')){
        user.role = '';
    }

    socket.on('forum.chat.moder', function(){
        socket.emit('forum.chat.moder', {
            moder: user.moder ? true : false
        });
    });

    socket.on('forum.online', function(){
        online_users = online_users.filter(obj => obj.uuid !== user.uuid);

        user.time = getDateTime().toLocaleString(DateTime.TIME_24_WITH_SECONDS);
        online_users.unshift({login: user.login, uuid: user.uuid, moder: user.moder, role: user.role});
    });

    socket.on('forum.posts.new', function(){
        if (!user.moder && isRateLimited(user.id)) {
            return;
        }

        socket.emit('forum.posts.new');
    });

    socket.on('forum.chat.delete', function(text){
        if (user.moder){
            fchat_last = fchat_last.filter(function (msg) {
                return msg.text !== text;
            });

            io.emit('forum.chat.delete', text);
        }
    });

    socket.on('forum.chat.msg', function(text){
        if (typeof text !== 'string') {
            socket.emit('message', {type: 'error', title: 'Ошибка', msg: 'Некорректный формат сообщения!'});
            return;
        }

        const unix = Math.round(+new Date()/1000);
        if (user.reg_time > (unix - 43200)){
            socket.emit('message', {type: 'error', title: 'Ошибка', msg: 'Мы можете пользоваться чатом только спустя 12 часов после регистрации!'});
            return;
        }

        if (!user.moder && isRateLimited(user.id)) {
            socket.emit('message', {type: 'warn', title: 'Упс!', msg: 'Не так быстро! Попробуйте через 3 секунды!'});
            return;
        }

        text = text.trim();

        if (text.length > 500 && !user.moder){
            socket.emit('message', {type: 'error', title: 'Ошибка', msg: 'Не более 500 символов в одном сообщении!'});
            return;
        }

        text = text.replace(/<\/?[^>]+>/gi, '');

        if (checkBan(user.id)){
            socket.emit('message', {type: 'error', title: 'Ошибка', msg: 'Вам запрещено писать в чат!'});
            return;
        }

        axios.post(process.env.APP_URL + '/api/text/filter', new URLSearchParams({ t: text }).toString(), {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function (response) {
            const message = {
                user: {login: user.login, uuid: user.uuid, moder: user.moder, role: user.role},
                text: response.data.filtered,
                time: getDateTime().toLocaleString(DateTime.TIME_24_WITH_SECONDS)
            };

            if (message.text.length <= 0 || text.length <= 0){
                socket.emit('message', {type: 'error', title: 'Ошибка', msg: 'Нельзя отправлять пустые сообщения!'});
                return;
            }

            fchat_last.push(message);

            if (fchat_last.length >= 20){
                fchat_last.splice(0, 1);
            }

            db_history.insert({login: message.user.login, text: message.text});

            console.log('[' + user.login + ']: ' + text);

            io.emit('forum.chat.msg', message);
        }).catch(function (error) {
            console.error(error && error.message ? error.message : error);
        });
    });

    socket.on('disconnect', function() {
        online_users = online_users.filter(obj => obj.uuid !== user.uuid);
    });
});
