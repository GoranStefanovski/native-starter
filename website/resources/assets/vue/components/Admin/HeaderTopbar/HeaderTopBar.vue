<script>
  import Vue, { defineComponent } from 'vue';
  import './HeaderTopBar.scss';
  import { navMenu } from "@/data/navMenu";
  import { mapActions, mapState } from "vuex";
  import axios from 'axios';
  export default defineComponent({
    name: 'HeaderTopBar',
    components: {
    },
    data() {
      return {
        user: {
          username: '',
          first_name: '',
          last_name: ''
        },
        dropdownOpen: false,
        backgroundImage: './assets/media/misc/bg-1.jpg', // Adjust the image URL
        username: 'Sean Stone',
        messagesBadge: '23 messages', // Change to your data
        navigationItems: [
          // Define your navigation items here
        ],
        customActions: [
          // Define your custom actions here
        ],
      };
    },  
    computed: {
      ...mapState('Root', [
        'csrfToken',
      ]),
    },
    methods: {
      toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
      },
      async fetchUser () {
        try {
          const response = await axios.get('/auth/user');
          this.user = response.data;
          console.log(user);
        } catch (error) {
          console.error(error);
        }
      },
      logOutUser () {
        try {
          const csrfToken = this.csrfToken;
          console.log(csrfToken);
          const response = axios.post('/usersanct/logout', null, {
            headers: {
              'X-CSRF-TOKEN': csrfToken,
            },
          });
          console.log(response);
        } catch (error) {
          console.error(error);
        }
      }
    },
    mounted() {
      this.fetchUser()
    },  
  })


</script>
<template>
  <div class="kt-header__topbar">

    <!--begin: User Bar -->
    <div @click="toggleDropdown()" class="kt-header__topbar-item kt-header__topbar-item--user">
      <div
        class="kt-header__topbar-wrapper"
        data-toggle="dropdown"
        data-offset="0px,0px"
      >
        <div class="kt-header__topbar-user">
          <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
          <span class="kt-header__topbar-username kt-hidden-mobile">{{ user.username !== '' ? user.username : user.first_name}}</span>
          <img
            class="kt-hidden"
            alt="Pic"
            src=""
          >

          <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
          <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">{{ user.first_name ? user.first_name.charAt(0) : user.username.charAt(0)}}</span>
        </div>
      </div>
      <div :style="dropdownOpen ? 'display: block' : ' '" class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
        <!--begin: Head -->
        <div
          class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
          style="background-image: url(./assets/media/misc/bg-1.jpg)">
          <div class="kt-user-card__avatar">
            <img
              class="kt-hidden"
              alt="Pic"
              src=""
            >

            <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
            <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{ user.first_name ? user.first_name.charAt(0) : user.username.charAt(0)}}</span>
          </div>
          <div class="kt-user-card__name">
            {{ user.first_name == '' || user.last_name == '' ? user.username : user.first_name + ' ' + user.last_name }}
          </div>
        </div>

        <!--end: Head -->

        <!--begin: Navigation -->
        <div class="kt-notification">
          <a
            href="#"
            class="kt-notification__item"
          >
            <div class="kt-notification__item-icon">
              <i class="flaticon2-calendar-3 kt-font-success" />
            </div>
            <div class="kt-notification__item-details">
              <div class="kt-notification__item-title kt-font-bold">
                My Profile
              </div>
              <div class="kt-notification__item-time">
                Account settings and more
              </div>
            </div>
          </a>

          <div class="kt-notification__custom kt-space-between">
            <span
              @click="logOutUser()"
              class="btn btn-label btn-label-brand btn-sm btn-bold"
            >Sign Out</span>
            <a
              href="demo1/custom/user/login-v2.html"
              target="_blank"
              class="btn btn-clean btn-sm btn-bold"
            >Upgrade Plan</a>
          </div>
        </div>

        <!--end: Navigation -->
      </div>
    </div>

    <!--end: User Bar -->
  </div>

<!-- end:: Header Topbar -->
</template>