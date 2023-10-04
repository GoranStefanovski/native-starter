import { createAuth } from '@websanova/vue-auth';
import driverAuthBearer      from '@websanova/vue-auth/dist/drivers/auth/bearer.esm.js';
import driverHttpAxios       from '@websanova/vue-auth/dist/drivers/http/axios.1.x.esm.js';
import driverRouterVueRouter from '@websanova/vue-auth/dist/drivers/router/vue-router.2.x.esm.js';
import driverOAuth2Google    from '@websanova/vue-auth/dist/drivers/oauth2/google.esm.js';
import driverOAuth2Facebook  from '@websanova/vue-auth/dist/drivers/oauth2/facebook.esm.js';

driverOAuth2Google.params.client_id = '547886745924-4vrbhl09fr3t771drtupacct6f788566.apps.googleusercontent.com';
driverOAuth2Facebook.params.client_id = '196729390739201';

export default (app) => {
  app.use(createAuth({
    plugins: {
      http: app.axios, // Axios
      // http: Vue.http, // Vue Resource
      router: app.router,
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
  }));
}
