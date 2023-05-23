<script lang="ts">
  import { defineComponent } from "vue";
  import { mapState , mapActions } from 'vuex';
  import { navMenu } from '@/data/navMenu';

  import { NavMenu, HeaderTopBar } from '@/components/Admin';

  import './DashboardHeader.scss';

  export default defineComponent({
    name: 'DashboardHeader',
    components: {
      NavMenu,
      HeaderTopBar
    },
    data() {
      return {
        navMenuData: navMenu
      }
    },
    computed: {
      ...mapState('Root', [
        'backUrl',
        'csrfToken',
        'menu',
        'activeClasses',
        'project'
      ]),
      ...mapState('Admin', [
        'activeTopSubmenu'
      ]),
      path() {
        return this.$route.path;
      }
    },
    methods: {
      ...mapActions('Admin', [
        'setActiveTopSubmenu'
      ]),
      logout() {
        //TODO: Check what makeRequest does when this is turned ON
        this.$auth.logout({
          makeRequest: true,
          redirect: { name: 'auth.login' }
        });
      }
    }
  })
</script>
<template>
  <!-- begin:: Header -->
  <div class="kt-header kt-grid__item kt-header--fixed">
    <!-- begin:: Header Menu -->
    <button
      id="kt_header_menu_mobile_close_btn"
      class="kt-header-menu-wrapper-close"
    >
      <i class="la la-close" />
    </button>
    <div
      id="kt_header_menu_wrapper"
      class="kt-header-menu-wrapper"
    >
      <div
        id="kt_header_menu"
        class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default "
      >
        <NavMenu :data="navMenuData" />
      </div>
    </div>

    <!-- end:: Header Menu -->

    <HeaderTopBar />
  </div>

  <!-- end:: Header -->
</template>
