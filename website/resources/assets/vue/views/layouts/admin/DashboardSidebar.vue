<script lang="ts">
  import { defineComponent } from 'vue';
  import { mapState } from 'vuex';

  import BrandComponent from '@/features/Admin/_partials/Brand.vue';
  import FirstLevelMenuItem from '@/features/Admin/_partials/FirstLevelMenuItem.vue';

  import './DashboardSidebar.scss';

  export default defineComponent({
    name: 'DashboardSidebar',
    components: {
      BrandComponent,
      FirstLevelMenuItem
    },
    emits: ['sidebarHover'],
    data() {
      return {
        clearMinimizingTimeout: 0 as ReturnType<typeof setTimeout>,
        sidebarState: {
          minimized: false,
          minimizeHover: false,
          minimizing: false
        }
      }
    },
    computed: {
      ...mapState('Root', [
        'activeClasses'
      ]),
      menuItems() {
        const permissionsArray = this.$auth.user().permissions_array;
        return this.$store.state.Root.mainMenu?.filter(menuItem => permissionsArray.includes(menuItem.permission)) || []
      }
    },
    mounted() {
      this.$store.dispatch('Root/setMenu', []);
      this.sidebarHover();
    },
    methods: {
      setMinimizing() {
        clearTimeout(this.clearMinimizingTimeout);
        this.sidebarState.minimizing = true;
        this.clearMinimizingTimeout = setTimeout(()=>{
          this.sidebarHover(('minimizingOff'));
        },300);
      },
      sidebarHover(string: string = '') {
        if (this.sidebarState.minimized) {
          if (string === 'over' ) {
            this.sidebarState.minimizeHover = true;
            this.setMinimizing();
          }
          if (string === 'leave') {
            this.sidebarState.minimizeHover = false;
            this.setMinimizing();
          }
        }

        if (string === 'toggleSidebar'){
          this.sidebarState.minimized = !this.sidebarState.minimized;
          if (!this.sidebarState.minimized) {
            this.sidebarState.minimizeHover = false;
          }
          this.setMinimizing();
        }

        if (string === 'minimizingOff') {
          this.sidebarState.minimizing = false;
        }

        this.$emit('sidebarHover', this.sidebarState);
      }
    }
  })
</script>

<template>
  <!--<button class="aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>-->
  <div
    class="aside aside--fixed"
    @mouseover="sidebarHover('over')"
    @mouseleave="sidebarHover('leave')"
  >
    <brand-component @toggleSidebar="sidebarHover('toggleSidebar')" />

    <div class="aside-menu-wrapper">
      <div class="aside-menu">
        <ul class="kt-menu__nav">
          <li class="kt-menu__section ">
            <h4 class="kt-menu__section-text">
              Main
            </h4>
            <i class="kt-menu__section-icon flaticon-more-v2" />
          </li>

          <first-level-menu-item
            v-for="(item,key) in menuItems"
            :key="key"
            :item="item"
          />
        </ul>
      </div>
    </div>
  </div>
</template>
