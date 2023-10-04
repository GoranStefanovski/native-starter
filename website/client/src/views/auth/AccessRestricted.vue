<script setup lang="ts"></script>

<template>
  <div>
    <h3 class="text-center">
      {{ $t('auth.restricted_access') }}
    </h3>
    <p class="text-center">
      {{ $t('auth.dont_have_permissions') }}
    </p>
    <div class="text-center mt-4">
      <router-link
        :to="{ name: 'auth.login' }"
        :title="$t('login.login')"
        class="btn btn-primary"
      >
        {{ $t('auth.login.title') }}
      </router-link>
      <span class="d-inline-block mx-3">{{ $t('strings.or') }}</span>
      <router-link
        to="/"
        class="btn btn-light"
      >
        {{ $t('auth.go_back_home') }}
      </router-link>
    </div>
  </div>
</template>
