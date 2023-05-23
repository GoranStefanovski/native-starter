import { RouteConfig } from 'vue-router';
import Vue from "vue";

const BaseAuth = () => import(/* webpackChunkName: "BaseAuth" */'../views/auth/BaseAuth.vue');
const AuthLogin = () => import(/* webpackChunkName: "AuthLogin" */'../views/auth/AuthLogin.vue');
const AuthResetLink = () => import(/* webpackChunkName: "AuthResetLink" */'../views/auth/AuthResetLink.vue');
const AuthResetForm = () => import(/* webpackChunkName: "AuthResetForm" */'../views/auth/AuthResetForm.vue');
const UserActivation = () => import(/* webpackChunkName: "UserActivation" */'../views/auth/UserActivation.vue');
const AccessRestricted = () => import(/* webpackChunkName: "AccessRestricted" */'../views/auth/AccessRestricted.vue');

export const authPaths: RouteConfig = {
  path: '/',
  component: BaseAuth,
  meta: {
    title: Vue.i18n.translate('strings.home', null)
  },
  children: [
    {
      path: 'login',
      name: 'auth.login',
      component: AuthLogin,
      meta: {
        title: Vue.i18n.translate('login.login', null)
      }
    }, {
      path: 'password/reset',
      name: 'auth.reset',
      component: AuthResetLink,
      meta: {
        title: Vue.i18n.translate('login.reset_password', null)
      }
    }, {
      path: 'password/reset/:token',
      name: 'auth.reset.token',
      component: AuthResetForm,
      meta: {
        title: Vue.i18n.translate('login.reset_password', null)
      }
    }, {
      path: 'user/activate/:token',
      name: 'user.activate.token',
      component: UserActivation,
      meta: {
        title: Vue.i18n.translate('users.activation', null)
      }
    }, {
      path: 'access/restricted',
      name: 'access.restrricted',
      component: AccessRestricted,
      meta: {
        title: Vue.i18n.translate('users.activation', null)
      }
    },
  ]
}
