<script setup lang="ts">
  import { ref } from 'vue';

  const form = ref({
    email: ''
  });
  const message = ref('');
  const messageClass = ref('') ;
  const isSending = ref(false);

  const onSubmit = () => {
      isSending.value = true;
      // TODO: Try to fix this form-backend-validation thing or find an alternative
      // this.form.post('../password/email')
      //   .then((response) => {
      //     this.isSending = false;
      //     this.displaySuccessMessage("A reset password email has been sent.")
      //   })
      //   .catch((error) => {
      //     this.displayErrorMessage(error.message[0]);
      //     this.isSending = false;
      //   });
  }

  const displaySuccessMessage = (newMessage: string) => {
    messageClass.value = 'alert alert-success';
    message.value = newMessage;
  }

  const displayErrorMessage = () => {
    messageClass.value = 'alert alert-danger';
    message.value = 'Validation failed';
  }
</script>

<template>
  <div class="auth-base__forgot">
    <div class="auth-base__head">
      <h3 class="auth-base__title">{{ $t('auth.reset_password') }}</h3>
      <div class="auth-base__desc">Enter your email to reset your password:</div>
    </div>
    <form
        class="kt-form auth-base__form"
        @submit.prevent="onSubmit"
        @keydown="form?.errors?.clear($event.target.name)"
    >
<!--            <div :class="messageClass">-->
<!--              {{ message }}-->
<!--            </div>-->
      <div class="input-group">
        <input
            v-model="form.email"
            class="form-control"
            type="text"
            :placeholder="$t('strings.email')"
            name="email"
            autocomplete="off"
            autofocus
        >
      </div>
<!--      <span v-if="form?.errors?.has('email')" class="error invalid-feedback">-->
<!--        {{ form?.errors?.errors?.email[0] }}-->
<!--      </span>-->
      <div class="auth-base__actions">
        <button
          type="submit"
          :class="{ disabled: isSending }"
          class="btn btn-brand btn-elevate auth-base__btn-primary"
        >
          {{ $t('auth.send_reset_link') }}
        </button>
        <router-link
          :to="{ name: 'auth.login' }"
          :title="$t('auth.forgot_password.go_back_login')"
          class="btn btn-light btn-elevate auth-base__btn-secondary"
        >
          {{ $t('auth.forgot_password.go_back_login') }}
        </router-link>
      </div>
    </form>
  </div>
</template>
