import Vue from 'vue';
import { RouteConfig } from 'vue-router';

const DefaultPage = () => import(/* webpackChunkName: "DefaultPage" */ '../views/layouts/admin/DefaultPage.vue');
const Dashboard = () => import(/* webpackChunkName: "AdminDashboard" */ '../views/admin/Dashboard.vue');
const Users = () => import(/* webpackChunkName: "Users" */ '../views/admin/Users/Users.vue');
const PublicUsers = () => import(/* webpackChunkName: "PublicUsers" */ '../views/admin/Users/PublicUsers.vue');
const MyProfile = () => import(/* webpackChunkName: "MyProfile" */ '../views/admin/Users/MyProfile.vue');
const UserForm = () => import(/* webpackChunkName: "UserForm" */ '../features/Admin/UsersCrud/_components/UserForm.vue');
const NotFound = () => import(/* webpackChunkName: "AdminNotFound" */ '../components/Admin/NotFound.vue');
const StaticContent = () => import(/* webpackChunkName: "StaticContent" */ '../features/Admin/StaticContent.vue');
const Example = () =>  import('../features/Admin/Examples/Example.vue');
const Portlets = () => import(/* webpackChunkName: "Portlets" */ '../views/admin/Portlets/Portlets.vue');

// Organization Events
const OrganizationEvents = () => import(/* webpackChunkName: "OrganizationEvents" */ '../views/admin/OrganizationEvents/OrganizationEvents.vue'); 
const OrganizationEventsForm = () => import(/* webpackChunkName: "OrganizationEventsForm" */ '../features/Admin/OrganizationEvents/_components/OrganizationEventsForm.vue'); 
const OrganizationEventsFormTimeline = () => import(/* webpackChunkName: "OrganizationEventsFormTimeline" */ '../features/Admin/OrganizationEvents/_components/OrganizationEventsFormTimeline.vue'); 
const OrganizationEventsFormStatus = () => import(/* webpackChunkName: "OrganizationEventsFormStatus" */ '../features/Admin/OrganizationEvents/_components/OrganizationEventsFormStatus.vue'); 
const OrganizationEventsFormWrapper = () => import(/* webpackChunkName: "OrganizationEventsFormWrapper" */ '../features/Admin/OrganizationEvents/_components/OrganizationEventsFormWrapper.vue'); 

// Posts
const Posts = () => import(/* webpackChunkName: "Posts" */ '../views/admin/Posts/Posts.vue');
const PostsForm = () => import(/* webpackChunkName: "PostsForm" */ '../features/Admin/Posts/_components/PostsForm.vue'); 
const PostsFormWrapper = () => import(/* webpackChunkName: "PostsFormWrapper" */ '../features/Admin/Posts/_components/PostsFormWrapper.vue'); 
const PostsFormStatus = () => import(/* webpackChunkName: "PostsFormStatus" */ '../features/Admin/Posts/_components/PostsFormStatus.vue'); 

//Shorts Posts
const ShortsPosts = () => import(/* webpackChunkName: "ShortsPosts" */ '../views/admin/ShortsPosts/ShortsPosts.vue');
const ShortsPostsForm = () => import(/* webpackChunkName: "ShortsPostsForm" */ '../features/Admin/ShortsPosts/_components/ShortsPostsForm.vue'); 
const ShortsPostsFormWrapper = () => import(/* webpackChunkName: "ShortsPostsFormWrapper" */ '../features/Admin/ShortsPosts/_components/ShortsPostsFormWrapper.vue'); 
const ShortsPostsFormStatus = () => import(/* webpackChunkName: "ShortsPostsFormStatus" */ '../features/Admin/ShortsPosts/_components/ShortsPostsFormStatus.vue'); 


// Locations
const Locations = () => import(/* webpackChunkName: "Locations" */ '../views/admin/Locations/Locations.vue');
const LocationsForm = () => import(/* webpackChunkName: "LocationsForm" */ '../features/Admin/Locations/_components/LocationsForm.vue'); 
const LocationsFormWrapper = () => import(/* webpackChunkName: "LocationsFormWrapper" */ '../features/Admin/Locations/_components/LocationsFormWrapper.vue'); 
const LocationsFormContact = () => import(/* webpackChunkName: "LocationsFormContact" */ '../features/Admin/Locations/_components/LocationsFormContact.vue'); 
const LocationsFormStatus = () => import(/* webpackChunkName: "LocationsFormStatus" */ '../features/Admin/Locations/_components/LocationsFormStatus.vue'); 
const LocationsFormWorkingHours = () => import(/* webpackChunkName: "LocationsFormWorkingHours" */ '../features/Admin/Locations/_components/LocationsFormWorkingHours.vue'); 

// Events
const Events = () => import(/* webpackChunkName: "Events" */ '../views/admin/Events/Events.vue');
const EventsForm = () => import(/* webpackChunkName: "EventsForm" */ '../features/Admin/Events/_components/EventsForm.vue'); 
const EventsFormWrapper = () => import(/* webpackChunkName: "EventsFormWrapper" */ '../features/Admin/Events/_components/EventsFormWrapper.vue'); 
const EventsFormTimeline = () => import(/* webpackChunkName: "EventsFormTimeline" */ '../features/Admin/Events/_components/EventsFormTimeline.vue'); 
const EventsFormStatus = () => import(/* webpackChunkName: "EventsFormStatus" */ '../features/Admin/Events/_components/EventsFormStatus.vue'); 

export let adminPaths: RouteConfig =
  {
    path: '/admin',
    component: DefaultPage,
    meta: {
      title: Vue.i18n.translate('strings.home', null),
      auth: {
        roles: ['admin_access']
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
            roles: ['admin_access']
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
            roles: ['admin_access']
          }
        }
      }, {
        path: 'myprofile/:userId',
        name: 'edit.myprofile',
        component: MyProfile,
        meta: {
          title: Vue.i18n.translate('strings.myprofile', null),
          auth: {
            roles: ['admin_access']
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
      // Locations
      {
        path: 'locations',
        name: 'locations',
        component: Locations,
        meta: {
          title: Vue.i18n.translate('locations.title', null),
          auth: {
            roles: ['locations_write','locations_view'],
            // forbiddenRedirect: '/'
          }
        }
      },
      {
        path: 'location/new',
        name: 'add.location',
        component: LocationsForm,
        meta: {
          title: Vue.i18n.translate('users.add.post', null),
          auth: {
            roles: ['locations_write']
          }
        }
      }, {
        path: 'location/:locationId/edit',
        name: 'edit.location',
        component: LocationsFormWrapper,
        meta: {
          title: Vue.i18n.translate('users.edit_post', null),
          auth: {
            roles: ['locations_write']
          }
        },
        children: 
          [
            {
              path: 'info',
              name: 'edit.location.info',
              component: LocationsForm,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['locations_write']
                }
              },
            },
            {
              path: 'contact',
              name: 'edit.location.contact',
              component: LocationsFormContact,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['locations_write']
                }
              },
            },
            {
              path: 'working_hours',
              name: 'edit.location.working_hours',
              component: LocationsFormWorkingHours,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['locations_write']
                }
              },
            },
            {
              path: 'status',
              name: 'edit.location.status',
              component: LocationsFormStatus,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['admin_access']
                }
              },
            },
          ],
      },
      // Events
      {
        path: 'events',
        name: 'events',
        component: Events,
        meta: {
          title: Vue.i18n.translate('events.title', null),
          auth: {
            roles: ['events_write','events_view'],
          }
        }
      },
      {
        path: 'event/new',
        name: 'add.event',
        component: EventsForm,
        meta: {
          title: Vue.i18n.translate('users.add.post', null),
          auth: {
            roles: ['events_write']
          }
        }
      }, {
        path: 'event/:eventId/edit',
        name: 'edit.event.wrapper',
        component: EventsFormWrapper,
        meta: {
          title: Vue.i18n.translate('users.edit_post', null),
          auth: {
            roles: ['events_write']
          }
        },
        children: 
          [
            {
              path: 'info',
              name: 'edit.event.info',
              component: EventsForm,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['events_write']
                }
              },
            },
            {
              path: 'timeline',
              name: 'edit.event.timeline',
              component: EventsFormTimeline,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['events_write']
                }
              },
            },
            {
              path: 'status',
              name: 'edit.event.status',
              component: EventsFormStatus,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['admin_access']
                }
              },
            },
          ],
      },
      // Blog Posts
      {
        path: 'posts',
        name: 'posts',
        component: Posts,
        meta: {
          title: Vue.i18n.translate('posts.title', null),
          auth: {
            roles: ['user_write'],
            // forbiddenRedirect: '/'
          }
        }
      },
      {
        path: 'post/new',
        name: 'add.post',
        component: PostsForm,
        meta: {
          title: Vue.i18n.translate('users.add.post', null),
          auth: {
            roles: ['user_write']
          }
        }
      }, {
        path: 'post/:postId/edit',
        name: 'edit.post',
        component: PostsFormWrapper,
        meta: {
          title: Vue.i18n.translate('users.edit_post', null),
          auth: {
            roles: ['user_write']
          }
        },
        children: 
          [
            {
              path: 'info',
              name: 'edit.post.info',
              component: PostsForm,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['user_write']
                }
              },
            },
            {
              path: 'status',
              name: 'edit.post.status',
              component: PostsFormStatus,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['user_write']
                }
              },
            },
          ],
      },
      // Shorts Posts
      {
        path: 'posts_short',
        name: 'posts_short',
        component: ShortsPosts,
        meta: {
          title: Vue.i18n.translate('posts.title', null),
          auth: {
            roles: ['user_write'],
          }
        }
      },
      {
        path: 'post_short/new',
        name: 'add.post_short',
        component: ShortsPostsForm,
        meta: {
          title: Vue.i18n.translate('users.add.post_short', null),
          auth: {
            roles: ['user_write']
          }
        }
      }, {
        path: 'post_short/:shortsPostId/edit',
        name: 'edit.post_short',
        component: ShortsPostsFormWrapper,
        meta: {
          title: Vue.i18n.translate('users.edit_post', null),
          auth: {
            roles: ['user_write']
          }
        },
        children: 
          [
            {
              path: 'info',
              name: 'edit.post_short.info',
              component: ShortsPostsForm,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['user_write']
                }
              },
            },
            {
              path: 'status',
              name: 'edit.post_short.status',
              component: ShortsPostsFormStatus,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['user_write']
                }
              },
            },
          ],
      },
      // Organization Events
      {
        path: 'organization_events',
        name: 'organization_events',
        component: OrganizationEvents,
        meta: {
          title: Vue.i18n.translate('events.title', null),
          auth: {
            roles: ['organization_write','organization_view'],
          }
        }
      },
      {
        path: 'organization_events/new',
        name: 'add.organization_events',
        component: OrganizationEventsForm,
        meta: {
          title: Vue.i18n.translate('users.add.post', null),
          auth: {
            roles: ['organization_write']
          }
        }
      }, 
      {
        path: 'organization_events/:organizationEventId/edit',
        name: 'edit.organization_events.wrapper',
        component: OrganizationEventsFormWrapper,
        meta: {
          title: Vue.i18n.translate('users.edit_post', null),
          auth: {
            roles: ['organization_write']
          }
        },
        children: 
          [
            {
              path: 'info',
              name: 'edit.organization_events.info',
              component: OrganizationEventsForm,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['organization_write']
                }
              },
            },
            {
              path: 'timeline',
              name: 'edit.organization_events.timeline',
              component: OrganizationEventsFormTimeline,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['organization_write']
                }
              },
            },
            {
              path: 'status',
              name: 'edit.organization_events.status',
              component: OrganizationEventsFormStatus,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['organization_write']
                }
              },
            },
          ],
      },
      // Artists
      {
        path: 'artist/:artistId/edit',
        name: 'edit.artist.wrapper',
        component: OrganizationEventsFormWrapper,
        meta: {
          title: Vue.i18n.translate('users.edit_post', null),
          auth: {
            roles: ['artist_write']
          }
        },
        children: 
          [
            {
              path: 'info',
              name: 'edit.artist.info',
              component: OrganizationEventsForm,
              meta: {
                title: Vue.i18n.translate('users.edit_post', null),
                auth: {
                roles: ['artist_write']
                }
              },
            },
          ],
      },
    ]
  };
