<script setup lang="ts">
  import {ref, provide, onMounted, computed, reactive} from 'vue';
  import VueHeadful from 'vue-headful';
  import { useRouter } from 'vue-router/composables';
  import GuestHeader from '@/views/layouts/front/GuestHeader.vue';
  import GuestFooter from '@/views/layouts/front/GuestFooter.vue';
  import Stripe from '@/components/Stripe/Stripe.vue';
  import { seoDefaults } from '@/utils/seoDefaults.ts';

  const router = useRouter();
  const fixedHeader = ref(true);

  const headful = ref({
    url : `${seoDefaults.url}${router.currentRoute.path}`,
    title : seoDefaults.title,
    description : seoDefaults.description,
    keywords : seoDefaults.keywords,
    image : seoDefaults.image
  });

  onMounted(() => {
    console.log('test');
  })
</script>

<template>
  <div>
    <VueHeadful
      :title="headful.title"
      :description="headful.description"
      :keywords="headful.keywords"
      :image="headful.image"
      lang="en"
      :url="headful.url"
    />
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
    <Stripe></Stripe>

    <GuestFooter />
    waaw
  </div>
</template>
