import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { i18n } from './utils/i18n';
import { axios, auth, siteforge, globalComponents } from './plugins'
import router from './router';
import App from './App.vue';

// import VueFormulate from '@braid/vue-formulate';

const pinia = createPinia();
const app = createApp(App);
app.use(pinia);
app.use(router);
app.use(i18n);
app.use(axios);
app.use(auth);
app.use(siteforge);
app.use(globalComponents);

// app.config.productionTip = false; // This is defaulted to FALSE for production in Vue 3

// Vue.use(VueFormulate, {
//   rules: {
//     // TODO these are laravel validation rules They need to be translated to
//     // work correctly here since the names are not the same
//     nullable: ({ value }) => true,
//     same: ({ value }) => true,
//     confirmed: ({ value }) => true,
//     phone: ({ value }) => true,
//     unique: ({ value }) => true,
//     required_with: ({ password }) => true // TODO this rule cannot be set globally it needs to be set for the field that is using it (This should only be used with passwords)
//   },
//   // library: {
//     // autocomplete: {
//     //   classification: 'text',
//     //   component: 'VueFormulateAutocomplete'
//     // }
//     // switch: {
//     //   classification: 'box',
//     //   component: 'VueFormulateSwitch'
//     // }
//   // }
// });

// Finally create the Vue instance passing the defined routes, store and App component
app.mount('#app');
