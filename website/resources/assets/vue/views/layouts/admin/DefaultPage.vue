<script setup lang="ts">
  import { ref, provide } from 'vue';
  import type { Ref } from 'vue'
  import DashboardHeader from '@/views/layouts/admin/DashboardHeader.vue';
  import DashboardSidebar from '@/views/layouts/admin/DashboardSidebar.vue';
  import { useStore } from '@/store';
  import { layoutConfigKey } from './DefaultPageTypes';

  const store = useStore();
  const sidebarState: Ref<object> = ref({});

  const layoutConfig = {
    hasFixedHeader: true,
    hasSubHeader: false,
    hasSubHeaderFixed: false
  }

  const setMenu = (url) => store.dispatch('Root/setMenu', url);

  const sidebarClass = (newState: object): void => {
    sidebarState.value = newState;
  }

  provide(layoutConfigKey, layoutConfig);
</script>

<template>
  <div
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right aside--enabled aside--fixed"
    :class="({
      'aside--minimize' : sidebarState.minimized && !sidebarState.minimizeHover,
      'aside--minimize-hover' : sidebarState.minimizeHover,
      'aside--minimizing' : sidebarState.minimizing,
    })"
  >
    <!-- begin:: Header Mobile -->

    <!-- end:: Header Mobile -->

    <div class="kt-grid kt-grid--hor kt-grid--root">
      <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <DashboardSidebar @sidebarHover="sidebarClass" />

        <div
          class="kt-wrapper kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor"
          :class="{
            'kt-wrapper--fixed-header': layoutConfig.hasFixedHeader,
            'kt-wrapper--has-subheader': layoutConfig.hasSubHeader,
            'kt-wrapper--fixed-subheader': layoutConfig.hasSubHeader && layoutConfig.hasSubHeaderFixed
          }">
          <DashboardHeader />

          <div class="kt-content  kt-grid__item kt-grid__item--fluid">
            <router-view :key="$route.fullPath" />
          </div>
        </div>
      </div>
    </div>

    <dialogs-wrapper wrapper-name="default" />
  </div>
</template>
