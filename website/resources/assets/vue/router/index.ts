import Vue from 'vue';
import VueRouter from 'vue-router';

import { frontRouteConfig } from './front';
import { userDashboardRouteConfig } from './user-dashboard';
import { adminPaths } from './admin';
import { authPaths } from './auth';

const Error = () => import(/* webpackChunkName: "ErrorPage" */ '../views/front/Error/Error.vue');

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  scrollBehavior (to, from, savedPosition) {
    // if (savedPosition) {
    //   return savedPosition;
    // } else {
    //   if (to.hash) {
    //     return {
    //       selector: to.hash
    //     };
    //   }
    //   return { x: 0, y: 0 };
    // }
  },
  saveScrollPosition() {
    const el = document.getElementById('body');
    return { x: el.scrollLeft, y: el.scrollTop };
  },
  routes: [
    frontRouteConfig,
    userDashboardRouteConfig,
    authPaths,
    adminPaths,
    {
      path: '*',
      name: 'errorpage',
      component : Error
    },
  ]
});

// It's required for VueAuth
Vue.router = router;

export default router;
