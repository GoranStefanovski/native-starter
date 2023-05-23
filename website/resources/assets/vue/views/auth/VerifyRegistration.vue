<script setup lang="ts">
  import { onMounted } from 'vue';
  import EventBus from '../../utils/event-bus';

  onMounted(() => {
    EventBus.$emit('resetPassswordShow');
  })
</script>

<template>
  <div class="container">
    <div class="row my-md-5">
      <div class="col-md-6 offset-md-3 py-md-5 py-2 text-center">
        <h1 class="mt-md-4">
          {{ $t('pages.verify_registration.title') }}
        </h1>
        <h4 class="mb-md-5">
          {{ $t('pages.verify_registration.verification_email_text') }}
        </h4>
      </div>
    </div>

    <!--    <div>-->
    <!--      <span class="mr-2">{{ $t('auth.registration.already_have_account') }} ?</span>-->
    <!--      <span-->
    <!--        @click="setActiveSection('login')"-->
    <!--        :class="(wizardLogin ? 'wizard_login' : '')"-->
    <!--        class="link">{{ $t('auth.login.title') }}</span>-->
    <!--    </div>-->
  </div>
</template>
