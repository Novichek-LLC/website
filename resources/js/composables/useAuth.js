import axios from "axios"

axios.defaults.withCredentials = true
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"
axios.defaults.headers.common["Accept"] = "application/json"

export async function getCsrfCookie() {
  await axios.get("/sanctum/csrf-cookie")
}

export async function login(email, password, remember = true) {
  await getCsrfCookie()

  await axios.post("/login", {
    email,
    password,
    remember,
  })
}

export async function logout() {
  await axios.post("/logout")
}

export async function fetchCurrentUser() {
  const { data } = await axios.get("/api/user")
  return data
}