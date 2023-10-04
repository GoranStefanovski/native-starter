<script setup lang="ts">
  import { ref } from 'vue';
  import type { Ref } from 'vue'
  import 'reflect-metadata';
  import Login from './auth/Login.vue';
  import Register from './auth/Register.vue';
  import ResetLink from './auth/ResetLink.vue';

  const props = defineProps({
    redirect: {
      type: Boolean,
      default: true
    },
    activeSection: {
      type: String,
      default: 'login'
    }
  });
  const emit = defineEmits(['close-auth']);

  const activeSectionInner : Ref<String> = ref(props.activeSection);

  const setActiveSection = (section: string) : void => {
    activeSectionInner.value = section
  }
</script>

<template>
  <!-- Login -->
  <login
    v-if="activeSectionInner === 'login'"
    :redirect="redirect"
    @set-active-section="setActiveSection"
    @close-auth="emit('close-auth')"
  />

  <!-- Registration -->
  <register
    v-else-if="activeSectionInner === 'register'"
    @set-active-section="setActiveSection"
    @close-auth="emit('close-auth')"
  />

  <!-- Forgot your password? -->
  <reset-link
    v-else-if="activeSectionInner === 'reset'"
    @set-active-section="setActiveSection"
    @close-auth="emit('close-auth')"
  />
</template>
