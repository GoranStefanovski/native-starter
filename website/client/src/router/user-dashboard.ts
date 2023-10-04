import { i18n } from '@/utils/i18n';
import { RouteConfig } from 'vue-router';

const { t } = i18n.global;

const UserDefaultPage = () => import(/* webpackChunkName: "UserDefaultPage" */ '../views/layouts/front/UserDefaultPage.vue');
// const UserDashboard = () => import(/* webpackChunkName: "UserDashboard" */'../views/front/User/UserDashboard.vue');
// const UserProfile = () => import(/* webpackChunkName: "UserProfile" */'../views/front/User/UserProfile.vue');
// const MyProfileForm = () => import(/* webpackChunkName: "MyProfileForm" */'@/features/Front/Users/_components/MyProfileForm.vue');

export let userDashboardRouteConfig: RouteConfig =
  {
    path: '/user',
    component: UserDefaultPage,
    meta: {
      title: t('strings.home'),
      auth: {
        roles: ['public_user'],
        forbiddenRedirect: '/forbidden',
        redirect: '/public_login'
      }
    },
    children: [
      // {
      //   path: 'dashboard',
      //   // alias: ['dashboard/account_info', 'dashboard/my_orders', 'dashboard/my_bags', 'dashboard/shipping_info'],
      //   name: 'user.dashboard',
      //   component: UserDashboard,
      //   redirect: { name: 'user.dashboard.user-profile' },
      //   meta: {
      //     auth: {
      //       roles: ['public_user'],
      //       forbiddenRedirect: '/forbidden',
      //       redirect: '/public_login'
      //     }
      //   },
      //   children: [
      //     {
      //       path: 'user-profile',
      //       name: 'user.dashboard.user-profile',
      //       component: MyProfileForm
      //     }
      //   ]
      // },
      // {
      //   path: 'profile',
      //   name: 'user.profile',
      //   component: UserProfile
      // }
    ]
  };
