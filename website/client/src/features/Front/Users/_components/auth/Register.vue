<script setup lang="ts">
  // import { namespace } from 'vuex-class';
  // import Form from '../../../../../../../../node_modules/form-backend-validation';
  // import { SkModal } from "@/components";
  // const { Action } = namespace('Root');
  // const { State } = namespace('Root');
  //
  // @Component({
  //   components: {
  //     SkModal
  //   }
  // })
  // export default class Register extends Vue {
  //   @Action('Root/setData') setData;
  //   @Prop() product_id;
  //   @Prop() offer_type;
  //   @Prop() price;
  //   @Prop() name;
  //
  //   login_form: any;
  //   showMessage = false;
  //   authError = false;
  //   isSending = false;
  //   user: MyProfileFormItem;
  //   form: Form;
  //
  //   constructor() {
  //     super();
  //     this.user = {
  //       email: '',
  //       first_name: '',
  //       last_name: '',
  //       password: '',
  //       password_confirmation: '',
  //       source: 'login'
  //     };
  //     this.login_form = {
  //       email: '',
  //       password: ''
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
  //     this.login_form.email = this.form.email;
  //     this.login_form.password = this.form.password;
  //     if(this.form.password == ''){
  //       delete(this.form.password);
  //     }
  //     this.form.post('/guest/user/new')
  //       .then((response) => {
  //         this.isSending = false;
  //         // TODO: #26689 Upon successful registration redirect to new page with only the verify user message (new component, new route) HINT: similar to User Activate
  //         this.$router.push({ name: 'verify_registration' });
  //         // try {
  //         //   this.showMessage = true;
  //         // } catch {
  //         //   this.authError = true;
  //         // }
  //       })
  //       .catch((error) => {
  //         this.authError = true;
  //         this.isSending = false;
  //       });
  //   }
  //
  //   async doLogin() {
  //     await this.$auth.login({
  //       data: this.login_form,
  //       success(response) {
  //         const { status } = response;
  //
  //         // this.setUser(this.$auth.user());
  //
  //         if (status === 401) {
  //           this.authError = true;
  //         }
  //         this.closeModal();
  //         this.setData();
  //       },
  //       error(error) {
  //         this.authError = true;
  //         if (error.response.status == 450) this.contentFreeze = true;
  //       }
  //       // redirect: (!this.wizardLogin ? { name: 'user.dashboard', params: { success: '1' }} : false)
  //     });
  //   }
  // }
</script>

<template>
  <p>Register.vue</p>
<!--  <sk-modal-->
<!--    :title="'auth.registration.title'"-->
<!--    name="register"-->
<!--    @close-modal="closeModal"-->
<!--  >-->
<!--    <template #body>-->
<!--      <p v-if="showMessage">-->
<!--        You have been sent a verification email. Please verify the email address by visiting the link you have received.-->
<!--      </p>-->

<!--      <form-->
<!--        v-else-->
<!--        name="registration"-->
<!--        @submit.prevent="onSubmit"-->
<!--        @keydown="form.errors.clear($event.target.name)"-->
<!--      >-->
<!--        <FormulateInput-->
<!--          v-model="form.first_name"-->
<!--          type="text"-->
<!--          label="Vorname"-->
<!--          name="first_name"-->
<!--          class="mb-4 formulate-input&#45;&#45;dark-bg"-->
<!--        />-->
<!--        <FormulateInput-->
<!--          v-model="form.last_name"-->
<!--          type="text"-->
<!--          label="Nachname"-->
<!--          name="last_name"-->
<!--          class="mb-4 formulate-input&#45;&#45;dark-bg"-->
<!--        />-->

<!--        <FormulateInput-->
<!--          v-model="form.email"-->
<!--          type="text"-->
<!--          label="E-Mail"-->
<!--          name="email"-->
<!--          validation="required"-->
<!--          class="mb-4 formulate-input&#45;&#45;dark-bg"-->
<!--        />-->

<!--        <FormulateInput-->
<!--          v-model="form.password"-->
<!--          type="password"-->
<!--          label="Passwort"-->
<!--          name="password"-->
<!--          validation="required"-->
<!--          class="mb-4 formulate-input&#45;&#45;dark-bg"-->
<!--        />-->

<!--        <FormulateInput-->
<!--          v-model="form.password_confirmation"-->
<!--          type="password"-->
<!--          label="Passwort wiederholen"-->
<!--          name="password_confirmation"-->
<!--          validation="required"-->
<!--          class="mb-4 formulate-input&#45;&#45;dark-bg"-->
<!--        />-->

<!--        <FormulateInput-->
<!--          type="submit"-->
<!--          value="Kostenlos registrieren"-->
<!--          class="formulate-input&#45;&#45;submit&#45;&#45;primary formulate-input&#45;&#45;submit&#45;&#45;block"-->
<!--          :disabled="isSending"-->
<!--        />-->
<!--      </form>-->
<!--    </template>-->

<!--    <template #footer>-->
<!--      <span class="mr-2">{{ $t('auth.registration.already_have_account') }} ?</span>-->
<!--      <span-->
<!--        class="link"-->
<!--        @click="setActiveSection('login')"-->
<!--      >{{ $t('auth.login.title') }}</span>-->
<!--    </template>-->
<!--  </sk-modal>-->
</template>
