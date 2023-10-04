import Vue from 'vue';
import { RouteConfig } from 'vue-router';

// Not used
const PageNotFound = () => import(/* webpackChunkName: "PageNotFound" */ '../views/layouts/errors/PageNotFound.vue');

// Non authenticated user routes
const GuestDefaultPage = () => import(/* webpackChunkName: "GuestDefaultPage" */ '../views/layouts/front/GuestDefaultPage.vue');
const Homepage = () => import(/* webpackChunkName: "Homepage" */ '../views/front/Homepage.vue');
const VerifyRegistration = () => import(/* webpackChunkName: "VerifyRegistration" */'@/views/auth/VerifyRegistration.vue');
const VueFormulateExample = () => import(/* webpackChunkName: "VueFormulateExample" */'@/components/VueFormulate/VueFormulateExample.vue');
const Sitemap = () => import(/* webpackChunkName: "Sitemap" */ '@/views/front/Sitemap.vue');

export let frontRouteConfig: RouteConfig =
  {
    path: '/',
    component: GuestDefaultPage,
    meta: {
      title: Vue.i18n.translate('strings.home', null)
    },
    children: [
      {
        path: '',
        name: 'homepage',
        component: Homepage,
        meta: {
          title: Vue.i18n.translate('general.homepage', null)
        }
      },
      {
        path: 'user/verify_registration',
        name: 'verify_registration',
        component: VerifyRegistration,
        meta: {
          title: Vue.i18n.translate('users.verify.registration', null)
        }
      },
      {
        path: 'vue_formulate_example',
        name: 'vue.formulate.example',
        component: VueFormulateExample,
        meta: {
          title: Vue.i18n.translate('vue.formulate.example', null)
        }
      },
      {
        path: 'public_login',
        name: 'public_login',
        component: Homepage,
        meta: {
          title: Vue.i18n.translate('general.homepage', null)
        }
      },
      // {
      //   path: 'password/reset/:token',
      //   redirect: (to) => {
      //     const { hash, params, query } = to;
      //     return { name: 'homepage', query: { token: params.token } };
      //   }
      // },
      {
        path: 'notfound',
        name: 'notfound',
        component: PageNotFound,
        meta: {
          title: Vue.i18n.translate('general.page_not_found', null)
        }
      },
      {
        path: 'sitemap',
        name: 'sitemap',
        component: Sitemap,
        meta: {
          title: Vue.i18n.translate('pages.sitemap.title', null)
        }
      },
    ]
  };
