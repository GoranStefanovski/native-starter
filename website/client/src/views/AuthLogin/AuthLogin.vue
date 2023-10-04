<script setup lang="ts">
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import { useAuth } from '@websanova/vue-auth/src/v3.js';
  import useAuthComp from "@/composables/useAuthComp";
  import formValidation from '@/utils/formValidation';

  import './AuthLogin.scss';

  const { login } = useAuthComp();

  const form = ref({});
  const authError = ref(false);
  const staySignedIn = ref(false);
  const auth = useAuth();
  const router = useRouter();

  const submitForm = (evt) => {
    if (!formValidation(evt)) return;

    login({
      data: form.value,
      redirect: false,
      remember: false,
      staySignedIn: staySignedIn.value,
    }).catch((error) => {
      authError.value = true;
      console.log(error);
    });
  }

</script>

<template>
  <div class="auth-login">
    <div class="auth-base__head">
      <h3 class="auth-base__title">{{ $t('auth.login.title') }}</h3>
    </div>
    <form class="kt-form auth-base__form" @submit="submitForm">
      <div class="input-group">
        <input
          v-model="form.email"
          class="form-control"
          type="text"
          :placeholder="$t('strings.email')"
          name="email"
          autocomplete="off"
          required
          autofocus
        >
      </div>
      <div class="input-group">
        <input
          v-model="form.password"
          class="form-control"
          type="password"
          :placeholder="$t('strings.password')"
          name="password"
          required
        >
      </div>
      <span v-if="authError" class="error invalid-feedback">
        {{ $t('auth.failed') }}
      </span>
      <div class="row auth-base__extra">
        <div class="col">
          <label class="kt-checkbox">
            <input v-model="staySignedIn" type="checkbox" name="remember">
            {{ $t('auth.keep_connected') }}
            <span></span>
          </label>
        </div>
        <div class="col kt-align-right">
          <router-link id="kt_login_forgot" to="/password/reset" class="auth-base__link">
            {{ $t('auth.login.forgot_your_password') }}
          </router-link>
        </div>
      </div>
      <div class="auth-base__actions">
        <input
          class="btn btn-brand btn-elevate auth-base__btn-primary"
          type="submit"
          value="Sign In"
        />
      </div>
    </form>
  </div>
</template>
