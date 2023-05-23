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
  <form
    @submit.prevent="onSubmit"
    @keydown="form.errors.clear($event.target.name)"
  >
    <h3 class="text-center">
      {{ $t('auth.reset_password') }}
    </h3>
    <div class="form-group">
      <label for="user_email">
        {{ $t('strings.email') }}
      </label>
      <div :class="messageClass">
        {{ message }}
      </div>
      <input
        id="user_email"
        v-model="form.email"
        type="text"
        aria-describedby="Email"
        name="email"
        class="form-control"
      >
      <span
        v-if="form.errors.has('email')"
        class="help is-danger"
      >
        {{ form.errors.errors.email[0] }}
      </span>
    </div>
    <div class="form-row">
      <div class="form-group col-sm-6">
        <button
          type="submit"
          :class="{ disabled: isSending }"
          class="btn btn-success right-side"
        >
          {{ $t('auth.send_reset_link') }}
        </button>
      </div>

      <div class="form-group col-sm-6 text-right">
        <router-link
          :to="{ name: 'auth.login' }"
          :title="$t('auth.forgot_password.go_back_login')"
          class="reset text-secondary pt-0 pr-0"
        >
          {{ $t('auth.forgot_password.go_back_login') }}
        </router-link>
      </div>
    </div>
  </form>
</template>
