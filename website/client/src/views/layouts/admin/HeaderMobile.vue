<script lang="ts">
  import { defineComponent } from 'vue';

  import './HeaderMobile.scss';
  
  export default defineComponent({
    name: 'HeaderMobile'
  })
</script>
<template>
  <div
    id="kt_header_mobile"
    class="kt-header-mobile  kt-header-mobile--fixed "
  >
    <div class="kt-header-mobile__logo">
      <a href="">
        <img
          alt="Logo"
          src=""
        >
      </a>
    </div>
    <div class="kt-header-mobile__toolbar">
      <button
        id="kt_aside_mobile_toggler"
        class="kt-header-mobile__toggler kt-header-mobile__toggler--left"
      >
        <span />
      </button>
      <button
        id="kt_header_mobile_toggler"
        class="kt-header-mobile__toggler"
      >
        <span />
      </button>
      <button
        id="kt_header_mobile_topbar_toggler"
        class="kt-header-mobile__topbar-toggler"
      >
        <i class="flaticon-more" />
      </button>
    </div>
  </div>
</template>