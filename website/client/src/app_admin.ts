// Here we import some global JS instances
import Vue from 'vue';
// Import the package used for authentication
import VueAuth from '@websanova/vue-auth';
// Here we import the Vuex store
// Import the i18 internationalization instance before vue-router because it uses i18n strings
import './utils/i18n';
// Import the AJAX request library Axios instance with some preset values
import './api/axios';
// Import the Vue Router instance
import router from './router';
// Import the encompassing App component

import App from './App.vue';

Vue.config.productionTip = false;

Vue.use(VueAuth, {
  auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
  http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
  router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
  rolesVar: 'permissions_array',
  parseUserData: user => user
});

// Finally create the Vue instance passing the defined routes, store and App component
new Vue({
  router,
  el: '#app',
  render: h => h(App),
  created: function () {
  }
});
