<script setup lang="ts">
  import { ref } from 'vue';
  import type { Ref } from 'vue'
  import { useRouter } from "vue-router";
  import Form from '../../../../../../../../node_modules/form-backend-validation';

  const props = defineProps(['product_id', 'offer_type', 'price', 'name']);
  const router = useRouter();

  const login_form: Ref = ref({
    email: '',
    password: ''
  });
  const user: Ref<MyProfileFormItem> = ref({
    email: '',
    first_name: '',
    last_name: '',
    password: '',
    password_confirmation: '',
    source: 'login'
  });
  const isSending: Ref<boolean> = ref(false);
  const showMessage: Ref<boolean> = ref(false);
  const authError: Ref<boolean> = ref(false);
  const form: Ref<Form> = ref(new Form(user));

  const onSubmit = () => {
    isSending.value = true;
    login_form.value = {
      email: form.value.email,
      password: form.value.password
    }
    if(form.value.password == ''){
      delete(form.value.password);
    }
    form.value.post('/guest/user/new')
      .then((response) => {
        isSending.value = false;
        // TODO: #26689 Upon successful registration redirect to new page with only the verify user message (new component, new route) HINT: similar to User Activate
        router.push({ name: 'verify_registration' });
        // try {
        //   this.showMessage = true;
        // } catch {
        //   this.authError = true;
        // }
      })
      .catch((error) => {
        authError.value = true;
        isSending.value = false;
      });
  }
</script>

<template>
  <div class="auth-inline">
    <p v-if="showMessage">
      You have been sent a verification email. Please verify the email address by visiting the link you have received.
    </p>

    <form
      v-else
      name="registration"
      @submit.prevent="onSubmit"
      @keydown="form.errors.clear($event.target.name)"
    >
      <FormulateInput
        v-model="form.first_name"
        type="text"
        label="Vorname"
        name="first_name"
        class="mb-4 formulate-input--dark-bg"
      />
      <FormulateInput
        v-model="form.last_name"
        type="text"
        label="Nachname"
        name="last_name"
        class="mb-4 formulate-input--dark-bg"
      />

      <FormulateInput
        v-model="form.email"
        type="text"
        label="E-Mail"
        name="email"
        validation="required"
        class="mb-4 formulate-input--dark-bg"
      />

      <FormulateInput
        v-model="form.password"
        type="password"
        label="Passwort"
        name="password"
        validation="required"
        class="mb-4 formulate-input--dark-bg"
      />

      <FormulateInput
        v-model="form.password_confirmation"
        type="password"
        label="Passwort wiederholen"
        name="password_confirmation"
        validation="required"
        class="mb-4 formulate-input--dark-bg"
      />

      <FormulateInput
        type="submit"
        value="Kostenlos registrieren"
        class="formulate-input--submit--primary formulate-input--submit--block"
        :disabled="isSending"
      />
    </form>
  </div>
</template>
