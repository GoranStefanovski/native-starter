<script lang="ts">
  import { namespace } from 'vuex-class';
  // import formValidation from '../../../../../utils/formValidation';
  // import EventBus from "@/utils/event-bus";
  // import { SkModal } from "@/components";
  import { Component, Vue } from 'vue-property-decorator';  //
  const { Action } = namespace('Root');
  // const { State } = namespace('Root');
  // import Form from '../../../../../../../../node_modules/form-backend-validation';
  //
  // @Component({
  //   components: {
  //     SkModal
  //   }
  // })
  export default class Login extends Vue {
    @Action('Root/setData') setData;
    //   @Prop({ default: true }) redirect;
    //
    csrf = {};
    user = {};
    authError = false;
    form: any;

    constructor(){
      super();
      this.form = {
        email: '',
        password: ''
      }
    }
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

    async doLogin() {
      // await this.$auth.login({
      //   data: this.form,
      //   success(response) {
      //     const { status } = response;
      //
      //     // this.setUser(this.$auth.user());
      //
      //     if (status === 401) {
      //       this.authError = true;
      //     }
      //     this.setData();
      //     if(this.redirect) {
      //       if (this.$auth.user().roles_array.includes(1)) {
      //         console.log('User is admin. ');
      //         window.location.assign('/admin');
      //       }
      //       if (this.$auth.user().roles_array.includes(3)) {
      //         console.log('User is public. ');
      //         console.log(this.$auth.user());
      //         this.$router.push({ name: 'user.dashboard' });
      //       }
      //     }
      //     else {
      //       EventBus.$emit("authenticationSuccessful");
      //     }
      //   },
      //   redirect: (false)
      // });
      Login.axios.get('/sanctum/csrf-cookie').then(response => {
        console.log(response);
        console.log(this.form.email)
        Login.axios.post('/api/login', {
          email: this.form.email,
          password: this.form.password },{
            withCredentials: true,
            headers: {
              'Content-Type': 'application/json' }
          }).then(response => {
          Login.axios.get('/api/user',{ withCredentials: true }).then(response => {
            // Set user data. ex permissions role etc ....
            this.user = response.data
            this.$store.commit('setUser', this.user)

            console.log(this.user)
          })
        })
      });

    }
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
  }
</script>

<template>
  <div>
    <div class="font-sans text-gray-900 antialiased">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Login Form
      </h2>
    </div>
    <form @submit.prevent="doLogin">
      <label
        class="block font-medium text-sm text-gray-700"
        for="email"
      >
        Email
      </label>
      <input
        id="email"
        v-model="form.email"
        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
        type="text"
        name="text"
      >
      <label
        class="block font-medium text-sm text-gray-700"
        for="password"
      >
        Password
      </label>
      <input
        id="password"
        v-model="form.password"
        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
        type="password"
        name="password"
      >
      <button
        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
        type="submit"
      >
        Submit
      </button>
    </form>
    <div>{{ storedUser }}</div>
  </div>
</template>
