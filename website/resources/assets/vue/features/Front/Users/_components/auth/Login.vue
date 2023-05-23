<script setup lang="ts">
  // import { namespace } from 'vuex-class';
  // import formValidation from '../../../../../utils/formValidation';
  // import EventBus from "@/utils/event-bus";
  // import { SkModal } from "@/components";
  //
  // const { Action } = namespace('Root');
  // const { State } = namespace('Root');
  //
  // @Component({
  //   components: {
  //     SkModal
  //   }
  // })
  // export default class Login extends Vue {
  //   @Action('Root/setData') setData;
  //   @Prop({ default: true }) redirect;
  //
  //   form = {};
  //   authError = false;
  //   isSending = false;
  //   redirectRouteName: string = 'dashboard';
  //
  //   @Emit('close-auth')
  //   closeModal(): void {
  //   }
  //
  //   @Emit('set-active-section')
  //   setActiveSection(string: string): void {
  //   }
  //
  //   async doLogin() {
  //     await this.$auth.login({
  //       data: this.form,
  //       success(response) {
  //         const { status } = response;
  //
  //         // this.setUser(this.$auth.user());
  //
  //         if (status === 401) {
  //           this.authError = true;
  //         }
  //         this.setData();
  //         if(this.redirect) {
  //           if (this.$auth.user().roles_array.includes(1)) {
  //             console.log('User is admin. ');
  //             window.location.assign('/admin');
  //           }
  //           if (this.$auth.user().roles_array.includes(3)) {
  //             console.log('User is public. ');
  //             console.log(this.$auth.user());
  //             this.$router.push({ name: 'user.dashboard' });
  //           }
  //         }
  //         else {
  //           EventBus.$emit("authenticationSuccessful");
  //         }
  //       },
  //       redirect: (false)
  //     });
  //   }
  //
  //   async login(evt: Event) {
  //     if (!formValidation(evt)) return;
  //
  //     this.isSending = true;
  //
  //     try {
  //       await this.doLogin();
  //     } catch {
  //       this.authError = true;
  //     }
  //
  //     this.isSending = false;
  //   }
  // }
</script>

<template>
  <p>Login.vue</p>
<!--  <sk-modal-->
<!--    :title="'auth.login.title'"-->
<!--    name="login"-->
<!--    @close-modal="closeModal"-->
<!--  >-->
<!--    <template #body>-->
<!--      <form-->
<!--        id="login_form"-->
<!--        class="ajaxform"-->
<!--        @submit="login"-->
<!--      >-->
<!--        <div-->
<!--          v-if="authError"-->
<!--          class="errormessage"-->
<!--        >-->
<!--          Fehler: E-Mail oder Passwort falsch!-->
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
<!--          v-model="form.password"-->
<!--          type="password"-->
<!--          label="Passwort"-->
<!--          name="password"-->
<!--          validation="required"-->
<!--          class="mb-4 formulate-input&#45;&#45;dark-bg"-->
<!--        />-->

<!--        <div-->
<!--          v-if="authError"-->
<!--          class="alert alert-danger"-->
<!--          role="alert"-->
<!--        >-->
<!--          {{ $t('auth.login.incorrect_password') }}-->
<!--        </div>-->

<!--        <FormulateInput-->
<!--          type="submit"-->
<!--          value="Login"-->
<!--          class="formulate-input&#45;&#45;submit&#45;&#45;primary formulate-input&#45;&#45;submit&#45;&#45;block"-->
<!--          :disabled="isSending"-->
<!--        />-->

<!--        <div class="sk-modal__login-type__reset">-->
<!--          <a-->
<!--            :title="$t('auth.login.forgot_your_password')"-->
<!--            type="button"-->
<!--            @click="setActiveSection('reset')"-->
<!--          >-->
<!--            {{ $t('auth.login.forgot_your_password') }} ?-->
<!--          </a>-->
<!--          &lt;!&ndash;<input type="checkbox" id="permanent" name="permanent" value="1"><label for="permanent"><b></b>Eingeloggt bleiben</label>&ndash;&gt;-->
<!--        </div>-->
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
