const axiosModule = require('axios');
window.axios = axiosModule.default || axiosModule;

window.axios.defaults = window.axios.defaults || {};
window.axios.defaults.headers = window.axios.defaults.headers || {};
window.axios.defaults.headers.common = window.axios.defaults.headers.common || {};

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

token = localStorage.getItem('api-token');
if (token) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
}
