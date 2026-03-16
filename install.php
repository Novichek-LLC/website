<?php

const FOLDERS = [
    'bootstrap/cache',
    'public',
    'storage/app',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
];

const INFO = 'info';
const SUCCESS = 'success';
const WARNING = 'warning';
const ERROR = 'error';

if (!file_exists('.env')) {
    msg('PLEASE COPY .env.example TO .env AND CONFIGURE IT', ERROR);
}

msg_header('CHECK FOLDERS');
checkOrCreateFolders(FOLDERS);

msg_header('INSTALL PHP PACKAGES');
runCheckedCommand('composer install');

msg_header('INSTALL NPM PACKAGES');
runCheckedCommand('npm install --legacy-peer-deps');

msg_header('BUILD FRONTEND');
runCheckedCommand('npm run production');
msg('Frontend build success!', SUCCESS);

msg_header('BUILD ADMIN FRONTEND');
runCheckedCommand('cd admin && npm install --legacy-peer-deps && npm run production');
msg('Admin frontend build success!', SUCCESS);

msg_header('RUN MIGRATIONS');
runCheckedCommand('php artisan migrate');

msg_header('GENERATE SECRET KEYS');
runCheckedCommand('php artisan key:generate');
runCheckedCommand('php artisan jwt:secret --force');

msg_header('FINISHED', SUCCESS);
msg('Modernized DreamCMS baseline is ready.', SUCCESS);

function runCheckedCommand($cmd)
{
    $output = [];
    $exitCode = 1;
    exec($cmd, $output, $exitCode);

    if ($exitCode === 0) {
        msg('Command [' . $cmd . '] exit code: ' . $exitCode);
    } else {
        msg('Command [' . $cmd . '] failed, exit code: ' . $exitCode, ERROR);
        die(1);
    }
}

function checkOrCreateFolders($folders)
{
    foreach ($folders as $folder) {
        if (file_exists($folder)) {
            if (is_dir($folder)) {
                msg('Dir ' . $folder . ' is ok', SUCCESS);
            } else {
                msg($folder . ' is not directory, recreating', WARNING);
                exec('rm -rf "' . $folder . '"');
                createWritablePath($folder);
            }
        } else {
            msg('Dir ' . $folder . ' does not exist, creating...', INFO);
            createWritablePath($folder);
        }
    }
}

function createWritablePath($path)
{
    @mkdir($path, 0775, true);
    @exec('chmod -R 775 "' . $path . '"');
}

function msg_header($msg, $level = INFO)
{
    msg('------------------------- ' . $msg . ' -------------------------', $level);
}

function msg($msg, $level = INFO)
{
    echo $msg . PHP_EOL;
}
