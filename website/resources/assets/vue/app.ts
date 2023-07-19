// Here we import some global JS instances
require('./bootstrap');
import Vue from 'vue';
// Import the package used for authentication
import auth                  from '@websanova/vue-auth/dist/v2/vue-auth.esm.js';
import driverAuthBearer      from '@websanova/vue-auth/dist/drivers/auth/bearer.esm.js';
import driverHttpAxios       from '@websanova/vue-auth/dist/drivers/http/axios.1.x.esm.js';
import driverRouterVueRouter from '@websanova/vue-auth/dist/drivers/router/vue-router.2.x.esm.js';
import driverOAuth2Google    from '@websanova/vue-auth/dist/drivers/oauth2/google.esm.js';
import driverOAuth2Facebook  from '@websanova/vue-auth/dist/drivers/oauth2/facebook.esm.js';
// Here we import the Vuex store
import store from './store';
// Import the i18 internationalization instance before vue-router because it uses i18n strings
import './utils/i18n';
// Import the AJAX request library Axios instance with some preset values
import './api/axios';
// Import the Vue Router instance
import router from './router';
// Import the encompassing App component
import vSelect from 'vue-select';

import App from './App.vue';
import ModalBaseDialogs from 'vue-modal-dialogs';

import VueFormulate from '@braid/vue-formulate';
import VueFormulateAutocomplete from '@/components/VueFormulate/VueFormulateAutocomplete.vue';
// import VueFormulateSwitch from '@/components/VueFormulate/VueFormulateSwitch.vue';

import MenuLink from '@/components/Admin/Menu/MenuLink/MenuLink.vue';
import SubMenu from '@/components/Admin/Menu/SubMenu/SubMenu.vue';
import { StripePlugin } from '@vue-stripe/vue-stripe';
// register your component with Vue
Vue.component('VueFormulateAutocomplete', VueFormulateAutocomplete);
// Vue.component('VueFormulateSwitch', VueFormulateSwitch);
Vue.component('v-select', vSelect);

Vue.config.productionTip = false;

Vue.component('MenuLink', MenuLink);
Vue.component('SubMenu', SubMenu);

Vue.use(ModalBaseDialogs);

// TODO: Update with actual keys, these are from the documentation
driverOAuth2Google.params.client_id = '547886745924-4vrbhl09fr3t771drtupacct6f788566.apps.googleusercontent.com';
driverOAuth2Facebook.params.client_id = '196729390739201';

Vue.use(auth, {
  plugins: {
    http: Vue.axios, // Axios
    // http: Vue.http, // Vue Resource
    router: Vue.router,
  },
  drivers: {
    auth: driverAuthBearer,
    http: driverHttpAxios,
    router: driverRouterVueRouter,
    oauth2: {
      google: driverOAuth2Google,
      facebook: driverOAuth2Facebook,
    }
  },
  options: {
    rolesKey: 'permissions_array',
    notFoundRedirect: { name: 'adminnotfound' },
    forbiddenRedirect: { path: '/access/restricted' },
    parseUserData: function(data) {
      return data;
    }
  },
});

Vue.use(VueFormulate, {
  rules: {
    // TODO these are laravel validation rules They need to be translated to
    // work correctly here since the names are not the same
    nullable: ({ value }) => true,
    same: ({ value }) => true,
    confirmed: ({ value }) => true,
    phone: ({ value }) => true,
    unique: ({ value }) => true,
    required_with: ({ password }) => true // TODO this rule cannot be set globally it needs to be set for the field that is using it (This should only be used with passwords)
  },
  library: {
    autocomplete: {
      classification: 'text',
      component: 'VueFormulateAutocomplete'
    }
    // switch: {
    //   classification: 'box',
    //   component: 'VueFormulateSwitch'
    // }
  }
});
const options = {
  pk: "pk_test_51KjLshCKJEL4uCt4pLkzi0GiXlRQE8raUG6GyPCu1JGesstjo5p45p3Gi7BTVUP8Ezjh5LuMcSy3W0LpojdlCPBX00GPLEf3ky",
  stripeAccount: process.env.STRIPE_ACCOUNT,
  apiVersion: process.env.API_VERSION,
  locale: process.env.LOCALE,
};

Vue.use(StripePlugin, options);

// Finally create the Vue instance passing the defined routes, store and App component
new Vue({
  store,
  router,
  el: '#app',
  render: h => h(App),
  created: function () {
  }
});
