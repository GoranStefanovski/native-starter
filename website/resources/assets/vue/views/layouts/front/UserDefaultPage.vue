<script setup lang="ts">
  import GuestHeader from '@/views/layouts/front/GuestHeader.vue';
  import GuestFooter from '@/views/layouts/front/GuestFooter.vue';
</script>

<template>
  <div>
    <guest-header />
    <router-view />
    <guest-footer />
    <dialogs-wrapper wrapper-name="default" />
  </div>
</template>
