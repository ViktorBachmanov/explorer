import { createApp } from 'vue'
import { createPinia } from 'pinia'

import TheApp from './TheApp.vue'


const pinia = createPinia()

createApp(TheApp).use(pinia).mount('#app-vue');