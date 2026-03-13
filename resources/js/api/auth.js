import axios from 'axios'

export async function getCsrfCookie() {
    return axios.get('/sanctum/csrf-cookie')
}

export async function login(payload) {
    await getCsrfCookie()

    return axios.post('/login', {
        email: payload.email,
        password: payload.password,
        remember: payload.remember ?? false,
    })
}

export async function register(payload) {
    await getCsrfCookie()

    return axios.post('/register', {
        name: payload.name,
        email: payload.email,
        password: payload.password,
        password_confirmation: payload.password_confirmation,
    })
}

export async function logout() {
    return axios.post('/logout')
}

export async function getCurrentUser() {
    return axios.get('/api/user')
}