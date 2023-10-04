import { RouteConfig } from 'vue-router';
import { i18n } from '@/utils/i18n';
const { t } = i18n.global

const AuthBase = () => import(/* webpackChunkName: "AuthBase" */'../views/AuthBase/AuthBase.vue');
const AuthLogin = () => import(/* webpackChunkName: "AuthLogin" */'../views/AuthLogin/AuthLogin.vue');
const AuthResetPassword = () => import(/* webpackChunkName: "AuthResetPassword" */'../views/AuthResetPassword/AuthResetPassword.vue');
const AuthResetLink = () => import(/* webpackChunkName: "AuthResetLink" */'../views/AuthResetLink/AuthResetLink.vue');
const UserActivation = () => import(/* webpackChunkName: "UserActivation" */'../views/auth/UserActivation.vue');
const AccessRestricted = () => import(/* webpackChunkName: "AccessRestricted" */'../views/auth/AccessRestricted.vue');

export const authPaths: RouteConfig = {
  path: '/',
  component: AuthBase,
  meta: {
    title: t('strings.home', null)
  },
  children: [
    {
      path: 'login',
      name: 'auth.login',
      component: AuthLogin,
      meta: {
        title: t('login.login', null)
      }
    }, {
      path: 'password/reset',
      name: 'auth.reset',
      component: AuthResetPassword,
      meta: {
        title: t('login.reset_password', null)
      }
    }, {
      path: 'password/reset/:token',
      name: 'auth.reset.token',
      component: AuthResetLink,
      meta: {
        title: t('login.reset_password', null)
      }
    }, {
      path: 'user/activate/:token',
      name: 'user.activate.token',
      component: UserActivation,
      meta: {
        title: t('users.activation', null)
      }
    }, {
      path: 'access/restricted',
      name: 'access.restrricted',
      component: AccessRestricted,
      meta: {
        title: t('users.activation', null)
      }
    },
  ]
}
