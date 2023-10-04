import { createI18n } from 'vue-i18n'

import messages from '@/vue-i18n-locales.generated';

const htmlTag = document.documentElement;
const locale = htmlTag ? htmlTag.lang : 'mk';

export const i18n = createI18n({
  locale,
  fallbackLocale: 'en',
  messages
})
