import Vue from 'vue';
import { RouteConfig } from 'vue-router';
// Authenticated user routes
const DefaultPage = () => import(/* webpackChunkName: "DefaultPage" */ '../views/layouts/admin/DefaultPage.vue');
const Dashboard = () => import(/* webpackChunkName: "AdminDashboard" */ '../views/admin/Dashboard.vue');
const Users = () => import(/* webpackChunkName: "Users" */ '../views/admin/Users/Users.vue');
const PublicUsers = () => import(/* webpackChunkName: "PublicUsers" */ '../views/admin/Users/PublicUsers.vue');
const Posts = () => import(/* webpackChunkName: "PublicUsers" */ '../views/admin/Posts/Posts.vue');
const MyProfile = () => import(/* webpackChunkName: "MyProfile" */ '../views/admin/Users/MyProfile.vue');
// const AddUser = () => import(/* webpackChunkName: "AddUser" */ '../views/admin/Users/AddUser.vue');
// const EditUser = () => import(/* webpackChunkName: "EditUser" */ '../views/admin/Users/EditUser.vue');
const UserForm = () => import(/* webpackChunkName: "UserForm" */ '../features/Admin/UsersCrud/_components/UserForm.vue');
const PostForm = () => import(/* webpackChunkName: "UserForm" */ '../features/Admin/PostsCrud/_components/PostsForm.vue');
const NotFound = () => import(/* webpackChunkName: "AdminNotFound" */ '../components/Admin/NotFound.vue');
const StaticContent = () => import(/* webpackChunkName: "StaticContent" */ '../features/Admin/StaticContent.vue');
const Example = () =>  import('../features/Admin/Examples/Example.vue');
const Portlets = () => import(/* webpackChunkName: "Portlets" */ '../views/admin/Portlets/Portlets.vue');

/*INSERT NEW IMPORTS HERE*/

export let adminPaths: RouteConfig =
  {
    path: '/admin',
    component: DefaultPage,
    meta: {
      title: Vue.i18n.translate('strings.home', null),
      auth: {
        roles: ['user_view']
      }
    },
    children: [
      {
        path: '',
        name: 'dashboard',
        component: Dashboard,
        meta: {
          title: Vue.i18n.translate('strings.home', null),
          auth: {
            roles: ['user_view']
          }
        }
      },
      {
        path: '',
        name: 'initial_dashboard',
        component: Dashboard,
        meta: {
          title: Vue.i18n.translate('strings.home', null),
          auth: {
            roles: ['user_view']
          }
        }
      }, {
        path: 'myprofile',
        name: 'myprofile',
        component: MyProfile,
        meta: {
          title: Vue.i18n.translate('strings.myprofile', null),
          auth: {
            roles: ['user_view']
          }
        }
      }, {
        path: 'users',
        name: 'users',
        component: Users,
        meta: {
          title: Vue.i18n.translate('strings.users.admin', null),
          auth: {
            roles: ['user_view']
          }
        }
      }, {
        path: 'users/public',
        name: 'users.public',
        component: PublicUsers,
        meta: {
          title: Vue.i18n.translate('strings.users.public', null),
          auth: {
            roles: ['user_view']
          }
        }
      }, {
        path: 'usersadd',
        name: 'add.user',
        component: UserForm,
        meta: {
          title: Vue.i18n.translate('users.add', null),
          auth: {
            roles: ['user_write']
          }
        }
      }, {
        path: 'usersedit/:userId/edit',
        name: 'edit.user',
        component: UserForm,
        meta: {
          title: Vue.i18n.translate('users.edit_user', null),
          auth: {
            roles: ['user_write']
          }
        }
      }, {
        path: 'page-builder',
        name: 'page.builder',
        component: StaticContent,
        meta: {
          title: Vue.i18n.translate('pagebuilder.page.title', null),
          auth: {
            roles: ['user_write']
          }
        }
      },
      {
        path: 'example',
        name: 'example',
        component: Example,
        meta: {
          title: Vue.i18n.translate('example', null),
          auth: {
            roles: ['user_view'],
            forbiddenRedirect: '/'
          }
        }
      },
      {
        path: 'components/portlets',
        name: 'components.portlets',
        component: Portlets,
        meta: {
          title: Vue.i18n.translate('components.portlets.label', null),
          auth: {
            roles: ['user_view'],
            forbiddenRedirect: '/'
          }
        }
      },
      {
        path: '*',
        name: 'adminnotfound',
        component: NotFound,
        meta: {
          title: Vue.i18n.translate('page.not_found', null),
          auth: {
            roles: ['user_write']
          }
        }
      },
      {
        path: 'posts',
        name: 'posts.category_one',
        component: Posts,
        meta: {
          title: Vue.i18n.translate('posts.title', null),
          auth: {
            roles: ['user_view','user_write'],
            // forbiddenRedirect: '/'
          }
        }
      },
      {
        path: 'posts',
        name: 'posts.category_two',
        component: Posts,
        meta: {
          title: Vue.i18n.translate('posts.title', null),
          auth: {
            roles: ['user_view','user_write'],
            // forbiddenRedirect: '/'
          }
        }
      },
      {
        path: 'post/new',
        name: 'add.post',
        component: PostForm,
        meta: {
          title: Vue.i18n.translate('users.add.post', null),
          auth: {
            roles: ['user_write','user_view']
          }
        }
      }, {
        path: 'postedit/:postId/edit',
        name: 'edit.post',
        component: PostForm,
        meta: {
          title: Vue.i18n.translate('users.edit_post', null),
          auth: {
            roles: ['user_write']
          }
        }
      }
      /*INSERT NEW CONFIGURATOR OPTIONS HERE*/
    ]
  };
