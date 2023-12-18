import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { plugin, defaultConfig } from '@formkit/vue'
import config from '../../formkit.config.js'

import TheApp from './TheApp.vue'


const pinia = createPinia()

createApp(TheApp)
  .use(pinia)
  .use(plugin, defaultConfig(config))
  .mount('#app-vue');