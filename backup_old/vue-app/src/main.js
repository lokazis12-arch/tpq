import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { createToast } from './composables/useToast'
import './style.css'

const app = createApp(App)

// Provide global toast
const toast = createToast()
app.provide('toast', toast)

app.use(router)
app.mount('#app')
