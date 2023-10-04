<script setup lang="ts">
  // import Form from '../../../../../../../../node_modules/form-backend-validation';
  // import { SkModal } from "@/components";
  //
  // @Component({
  //   components: {
  //     SkModal
  //   }
  // })
  // export default class ResetLink extends Vue {
  //   form: Form;
  //   user: any;
  //   success: boolean;
  //   isSending: boolean;
  //
  //   constructor() {
  //     super();
  //     this.isSending = false;
  //     this.success = false;
  //     this.user = {
  //       email: ''
  //     };
  //     this.form = new Form(this.user);
  //   }
  //
  //   @Emit('close-auth')
  //   closeModal(): void {
  //   }
  //
  //   @Emit('set-active-section')
  //   setActiveSection(string: string): void {
  //   }
  //
  //   onSubmit() {
  //     this.isSending = true;
  //     this.form.post('../password/email')
  //       .then((response) => {
  //         this.isSending = false;
  //         this.success = true;
  //       })
  //       .catch((error) => {
  //         this.isSending = false;
  //       });
  //   }
  // }
</script>

<template>
  <p>ResetLink.vue</p>
<!--  <sk-modal-->
<!--    :title="'auth.forgot_password.title'"-->
<!--    name="reset-password-link"-->
<!--    @close-modal="closeModal"-->
<!--  >-->
<!--    <template #body>-->
<!--      <form-->
<!--        @submit.prevent="onSubmit"-->
<!--        @keydown="form.errors.clear($event.target.name)"-->
<!--      >-->
<!--        <div-->
<!--          v-if="success"-->
<!--          class="alert alert-success"-->
<!--          role="alert"-->
<!--        >-->
<!--          {{ $t('auth.forgot_password.reset_password_email') }}-->
<!--        </div>-->

<!--        <div-->
<!--          v-if="form.errors.any()"-->
<!--          class="alert alert-danger"-->
<!--          role="alert"-->
<!--        >-->
<!--          {{ (form.errors.has('email') ? $t(form.errors.get('email')[0]): $t('errors.generic_error')) }}-->
<!--        </div>-->

<!--        <FormulateInput-->
<!--          v-model="form.email"-->
<!--          type="text"-->
<!--          label="E-Mail"-->
<!--          name="email"-->
<!--          validation="required"-->
<!--          class="mb-4 formulate-input&#45;&#45;dark-bg"-->
<!--        />-->

<!--        <FormulateInput-->
<!--          type="submit"-->
<!--          value="Link zur Zurücksetzung zusenden"-->
<!--          class="formulate-input&#45;&#45;submit&#45;&#45;primary formulate-input&#45;&#45;submit&#45;&#45;block"-->
<!--          :disabled="isSending"-->
<!--        />-->

<!--        <a-->
<!--          class="link"-->
<!--          title="Login"-->
<!--          type="button"-->
<!--          @click="setActiveSection('login')"-->
<!--        >{{ $t('auth.login.title') }}</a>-->
<!--      </form>-->
<!--    </template>-->
<!--    <template #footer>-->
<!--      <span class="mr-2">{{ $t('auth.login.no_account_yet') }} ?</span>-->
<!--      <span-->
<!--        class="link"-->
<!--        @click="setActiveSection('register')"-->
<!--      >-->
<!--        {{ $t('auth.register') }}-->
<!--      </span>-->
<!--    </template>-->
<!--  </sk-modal>-->
</template>
