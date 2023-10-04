<script setup lang="ts">
  import { useRouter } from 'vue-router';
  import GuestHeader from '@/views/layouts/front/GuestHeader.vue';
  import GuestFooter from '@/views/layouts/front/GuestFooter.vue';

  const router = useRouter();
</script>

<template>
  <div>
    <div
      role="main"
      :class="['main',{
        'main--fixed-header' : fixedHeader,
      }]"
    >
      <GuestHeader :fixed-header="fixedHeader" />
      <transition
        name="slide-fade"
        mode="out-in"
      >
        <RouterView :key="$route.fullPath" />
      </transition>
    </div>

    <GuestFooter />
  </div>
</template>
