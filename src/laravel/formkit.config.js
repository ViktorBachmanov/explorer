import { ru } from '@formkit/i18n'
import { defaultConfig } from '@formkit/vue'
import { rootClasses } from './formkit.theme'

export default defaultConfig({
  locales: { ru },
  locale: 'ru',
  config: {
    rootClasses,
  },
})