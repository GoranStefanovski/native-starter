<script setup lang="ts">
  import { ref, onMounted } from 'vue';
  import { useRouter } from 'vue-router';
  import { post } from "@/services/HTTP";
  import formValidation from '../../utils/formValidation';

  const router = useRouter();

  const form = ref({
    token: ''
  });
  const isSending = ref(false);
  const validToken = ref(false);

  onMounted(() => {
    form.value.token = router.currentRoute.params.token;
  })

  const submitForm = async (evt) => {
    if (!formValidation(evt)) return;

    isSending.value = true;

    try {
      const response = await post('../password/reset', this.form);
      const { data, status } = response;

      if (status !== 200 || data.errors) {
        // dialog(find(data.errors)[0], false);
        console.log('passwords.passwords_not_match');

        return;
      }

      // dialog('passwords.reset', false);
      console.log('passwords.reset');

      router.push({ name: 'homepage' });
    } catch {
      // dialog('errors.generic_error', false);
      console.log('errors.generic_error');
    }

    isSending.value = false;
  }
</script>

<template>
  <div>Auth reset form</div>
<!--  <b-form @submit="submitForm">-->
<!--    <h3 class="text-center">-->
<!--      {{ $t('auth.reset_password') }}-->
<!--    </h3>-->
<!--    <b-form-group-->
<!--      :label="$t('strings.email')"-->
<!--      label-for="email"-->
<!--    >-->
<!--      <b-form-input-->
<!--        v-model="form.email"-->
<!--        type="email"-->
<!--        name="email"-->
<!--        required="required"-->
<!--        autofocus="autofocus"-->
<!--      />-->
<!--    </b-form-group>-->
<!--    <b-form-group-->
<!--      :label="$t('strings.password')"-->
<!--      label-for="password"-->
<!--    >-->
<!--      <b-form-input-->
<!--        v-model="form.password"-->
<!--        type="password"-->
<!--        required="required"-->
<!--      />-->
<!--    </b-form-group>-->
<!--    <b-form-group-->
<!--      :label="$t('passwords.password_confirmation')"-->
<!--      label-for="password_confirmation"-->
<!--    >-->
<!--      <b-form-input-->
<!--        v-model="form.password_confirmation"-->
<!--        type="password"-->
<!--        name="password_confirmation"-->
<!--        required="required"-->
<!--      />-->
<!--    </b-form-group>-->
<!--    <b-form-group>-->
<!--      <b-button-->
<!--        type="submit"-->
<!--        variant="primary"-->
<!--        :class="{ disabled: isSending }"-->
<!--      >-->
<!--        {{ $t('auth.reset_password') }}-->
<!--      </b-button>-->
<!--    </b-form-group>-->
<!--  </b-form>-->
</template>
