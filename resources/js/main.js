import { createApp } from "vue"
import router from "./router"
import '../css/app.css'
import App from "./App.vue"
import "./echo"
createApp(App).use(router).mount("#app")
