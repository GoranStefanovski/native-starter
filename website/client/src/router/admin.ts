import { RouteConfig } from 'vue-router';
import { i18n } from '@/utils/i18n';

const { t } = i18n.global;
// Authenticated user routes
const WrapperPage = () => import(/* webpackChunkName: "WrapperPage" */ '../views/layouts/WrapperPage/WrapperPage.vue');
const Dashboard = () => import(/* webpackChunkName: "AdminDashboard" */ '../views/admin/Dashboard.vue');
const Users = () => import(/* webpackChunkName: "Users" */ '../views/admin/Users/Users.vue');
const PublicUsers = () => import(/* webpackChunkName: "PublicUsers" */ '../views/admin/Users/PublicUsers.vue');
const MyProfile = () => import(/* webpackChunkName: "MyProfile" */ '../views/admin/Users/MyProfile.vue');
// const AddUser = () => import(/* webpackChunkName: "AddUser" */ '../views/admin/Users/AddUser.vue');
// const EditUser = () => import(/* webpackChunkName: "EditUser" */ '../views/admin/Users/EditUser.vue');
const UserForm = () => import(/* webpackChunkName: "UserForm" */ '../features/Admin/UsersCrud/_components/UserForm.vue');
const NotFound = () => import(/* webpackChunkName: "AdminNotFound" */ '../components/Admin/NotFound.vue');
const StaticContent = () => import(/* webpackChunkName: "StaticContent" */ '../features/Admin/StaticContent.vue');
const Portlets = () => import(/* webpackChunkName: "Portlets" */ '../views/components/Portlets/Portlets.vue');
const Buttons = () => import(/* webpackChunkName: "Portlets" */ '../views/components/Buttons/Buttons.vue');
const Pages = () => import(/* webpackChunkName: "Pages" */ '../views/Pages/Pages.vue');
const PageCrud = () => import(/* webpackChunkName: "PageCrud" */ '../views/Pages/PagesCRUD.vue');

/*INSERT NEW IMPORTS HERE*/

export let adminPaths: RouteConfig =
  {
    path: '/admin',
    component: WrapperPage,
    meta: {
      title: t('strings.home', null),
      auth: {
        roles: ['read-users']
      }
    },
    children: [
      {
        path: '',
        name: 'dashboard',
        component: Dashboard,
        meta: {
          title: t('strings.home', null),
          auth: {
            roles: ['read-users']
          }
        }
      },
      {
        path: '',
        name: 'initial_dashboard',
        component: Dashboard,
        meta: {
          title: t('strings.home', null),
          auth: {
            roles: ['read-users']
          }
        }
      }, {
        path: 'myprofile',
        name: 'myprofile',
        component: MyProfile,
        meta: {
          title: t('strings.myprofile', null),
          auth: {
            roles: ['read-users']
          }
        }
      }, {
        path: 'users',
        name: 'users',
        component: Users,
        meta: {
          title: t('strings.users.admin', null),
          auth: {
            roles: ['read-users']
          }
        }
      }, {
        path: 'users/public',
        name: 'users.public',
        component: PublicUsers,
        meta: {
          title: t('strings.users.public', null),
          auth: {
            roles: ['read-users']
          }
        }
      }, {
        path: 'usersadd',
        name: 'add.user',
        component: UserForm,
        meta: {
          title: t('users.add', null),
          auth: {
            roles: ['create-users']
          }
        }
      }, {
        path: 'usersedit/:userId/edit',
        name: 'edit.user',
        component: UserForm,
        meta: {
          title: t('users.edit_user', null),
          auth: {
            roles: ['create-users']
          }
        }
      }, {
        path: 'pages/:id/edit',
        name: 'page.crud',
        component: PageCrud,
        meta: {
          title: t('pages.title', null),
          auth: {
            roles: ['create-users']
          }
        }
      },
      {
        path: 'pages/create',
        name: 'create-page',
        component: PageCrud,
        meta: {
          title: t('pages.title', null),
          auth: {
            roles: ['create-users']
          }
        }
      },
      {
        path: 'pages',
        name: 'pages',
        component: Pages,
        meta: {
          title: t('pages.title', null),
          auth: {
            roles: ['create-users']
          }
        }
      }, {
        path: 'components/portlets',
        name: 'components.portlets',
        component: Portlets,
        meta: {
          title: t('components.portlets.label', null),
          auth: {
            roles: ['read-users'],
            forbiddenRedirect: '/'
          }
        }
      }, {
        path: 'components/buttons',
        name: 'components.buttons',
        component: Buttons,
        meta: {
          title: t('components.portlets.label', null),
          auth: {
            roles: ['read-users'],
            forbiddenRedirect: '/'
          }
        }
      },
      {
        path:  "/:catchAll(.*)",
        name: 'adminnotfound',
        component: NotFound,
        meta: {
          title: t('page.not_found', null),
          auth: {
            roles: ['create-users']
          }
        }
      },
      /*INSERT NEW CONFIGURATOR OPTIONS HERE*/
    ]
  };
