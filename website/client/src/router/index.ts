import { createRouter, createWebHistory } from 'vue-router';
import { useRootStore } from '@/store/root';

// import { frontRouteConfig } from './front';
// import { userDashboardRouteConfig } from './user-dashboard';
import { adminPaths } from './admin';
import { authPaths } from './auth';

const Error = () => import(/* webpackChunkName: "ErrorPage" */ '../views/front/Error/Error.vue');

const router = createRouter({
  history: createWebHistory(),
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
  // saveScrollPosition() {
  //   const el = document.getElementById('body');
  //   return { x: el.scrollLeft, y: el.scrollTop };
  // },
  routes: [
    // frontRouteConfig,
    authPaths,
    adminPaths,
    {
      path: "/:catchAll(.*)",
      name: 'errorpage',
      component : Error
    },
  ]
});

router.afterEach((to, from) => {
  const { setFrontActiveClass } = useRootStore();

  setTimeout(() => {
    window.scrollTo({
      top: 0,
      left: 0
    });
  }, 500);

  setFrontActiveClass(to.name);
})

export default (app) => {
  app.router = router;

  app.use(router);
}
