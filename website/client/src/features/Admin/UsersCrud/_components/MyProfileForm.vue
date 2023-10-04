<!--<script lang="ts">-->
<!--  import Form from '../../../../../../../node_modules/form-backend-validation';-->
<!--  import { AdminSection, FormInput } from '@/components/Form';-->

<!--  @Component({-->
<!--    components:{-->
<!--      AdminSection,-->
<!--      FormInput-->
<!--    }-->
<!--  })-->
<!--  export default class MyProfileForm extends Vue {-->

<!--    message: string;-->
<!--    messageClass: string;-->
<!--    loading: boolean;-->
<!--    user: MyProfileFormItem;-->
<!--    fetchUri: string;-->
<!--    id: number | undefined;-->
<!--    showAttached: boolean;-->
<!--    form: Form;-->
<!--    roles: Array<any>;-->
<!--    countries: Array<any>;-->
<!--    file: File;-->
<!--    initial_filename: string | undefined;-->
<!--    initial_id: number | undefined;-->
<!--    currently_selected_filename : string;-->

<!--    constructor() {-->
<!--      super();-->
<!--      this.message = "";-->
<!--      this.messageClass = "";-->
<!--      this.loading = true;-->
<!--      this.id = 0;-->
<!--      this.fetchUri = 'user/myprofile';-->
<!--      this.initial_filename = "";-->
<!--      this.initial_id = 0;-->
<!--      this.currently_selected_filename = "";-->
<!--      this.file = new File([], '');-->
<!--      this.user = {-->
<!--        id: 0,-->
<!--        email: '',-->
<!--        first_name: '',-->
<!--        last_name: '',-->
<!--        password: '',-->
<!--        password_confirmation: '',-->
<!--        country_id: 0,-->
<!--        uploaded_file: this.file-->
<!--      };-->
<!--      this.form = new Form(this.user);-->
<!--      this.roles = [];-->
<!--      this.countries = [];-->
<!--      this.showAttached = false;-->

<!--      console.log(2);-->
<!--    }-->

<!--    onSubmit() {-->
<!--      this.loading = true;-->
<!--      this.form.uploaded_file = this.file;-->
<!--      if(this.form.password == ''){-->
<!--        delete(this.form.password);-->
<!--      }-->
<!--      this.form.post(this.getRoute())-->
<!--        .then((response) => {-->
<!--          this.loading = false;-->
<!--          // TODO: Translated message here-->
<!--          this.displaySuccessMessage('User updated!');-->
<!--          this.fetchUser();-->
<!--          Vue.router.push({-->
<!--            name: 'myprofile'-->
<!--          });-->
<!--        })-->
<!--        .catch((error) => {-->
<!--          this.displayErrorMessage(error.message)-->
<!--          this.loading = false;-->
<!--        });-->
<!--    }-->

<!--    async created() {-->
<!--      this.renderForm();-->
<!--      this.fetchCountries();-->
<!--    }-->

<!--    renderForm() {-->
<!--      this.fetchUser();-->
<!--      this.form.errors.clear();-->
<!--    }-->

<!--    fetchCountries() {-->
<!--      this.axios.get('user/dropdown/countries')-->
<!--        .then((response) => {-->
<!--          this.countries = response.data;-->
<!--          this.countries.push({ id: 0, name: '- Select a country -' });-->
<!--        });-->

<!--    }-->

<!--    getRoute() {-->
<!--      return 'user/edit/myprofile/' + this.id;-->
<!--    }-->

<!--    fetchUser() {-->
<!--      this.loading = true;-->
<!--      this.axios.get(this.fetchUri)-->
<!--        .then((response) => {-->
<!--          this.loading = false;-->
<!--          this.user = response.data;-->
<!--          if (this.user.image) {-->
<!--            this.showAttached = true;-->
<!--            this.initial_filename = this.user.image.file_name;-->
<!--            this.initial_id = this.user.image.id;-->
<!--          } else {-->
<!--            this.showAttached = false;-->
<!--          }-->
<!--          this.id = this.user.id;-->
<!--          this.form.populate(this.user)-->
<!--          // this.form.roles = this.user.roles_array;-->
<!--        });-->
<!--    }-->

<!--    displaySuccessMessage(message: string) {-->
<!--      this.messageClass = 'alert alert-success';-->
<!--      this.message = message;-->
<!--    }-->

<!--    displayErrorMessage(message: string) {-->
<!--      this.messageClass = 'alert alert-danger';-->
<!--      this.message = 'Validation failed';-->
<!--    }-->

<!--    clearMessage(): void {-->
<!--      this.message = '';-->
<!--    }-->

<!--    removeFormErrors(field: string){-->
<!--      this.form.errors.clear(field);-->
<!--    }-->

<!--    fileUpload() {-->
<!--      this.file = (<any>this.$refs.file).files[0];-->
<!--      this.form.file_name = this.file.name;-->
<!--    }-->
<!--  }-->
<!--</script>-->

<!--<template>-->
<!--  <form-->
<!--    class="container-fluid"-->
<!--    autocomplete="off"-->
<!--    enctype="multipart/form-data"-->
<!--    @submit.prevent="onSubmit"-->
<!--    @keydown="form.errors.clear($event.target.name)"-->
<!--  >-->
<!--    <div class="row">-->
<!--      <div class="col-md-9">-->
<!--        <admin-section :loading="loading">-->
<!--          <h4 slot="header">-->
<!--            {{ $t('admin.profile.information') }}-->
<!--          </h4>-->

<!--          <div-->
<!--            slot="content"-->
<!--            :class="messageClass"-->
<!--          >-->
<!--            {{ message }}-->
<!--          </div>-->
<!--          <div-->
<!--            slot="content"-->
<!--            class="message-body"-->
<!--          >-->
<!--            <div-->
<!--              slot="content"-->
<!--              class="form-row"-->
<!--            >-->
<!--              <div class="col-md-3 col-sm-6">-->
<!--                <form-input-->
<!--                  :id="'last_name'"-->
<!--                  v-model="form.last_name"-->
<!--                  :label="'users.last_name.label'"-->
<!--                  :form="form"-->
<!--                />-->
<!--              </div>-->
<!--              <div class="col-md-3 col-sm-6">-->
<!--                <form-input-->
<!--                  :id="'first_name'"-->
<!--                  v-model="form.first_name"-->
<!--                  :label="'users.first_name.label'"-->
<!--                  :form="form"-->
<!--                />-->
<!--              </div>-->
<!--            </div>-->

<!--            <div-->
<!--              slot="content"-->
<!--              class="form-row"-->
<!--            >-->
<!--              <div class="col-md-3 col-sm-6">-->
<!--                <form-input-->
<!--                  :id="'email'"-->
<!--                  v-model="form.email"-->
<!--                  :label="'strings.email'"-->
<!--                  :form="form"-->
<!--                />-->
<!--              </div>-->
<!--            </div>-->

<!--            <div-->
<!--              slot="content"-->
<!--              class="form-row"-->
<!--            >-->
<!--              <div class="col-md-3 col-sm-6">-->
<!--                <form-input-->
<!--                  :id="'password'"-->
<!--                  v-model="form.password"-->
<!--                  :label="'users.password.label'"-->
<!--                  :form="form"-->
<!--                />-->
<!--              </div>-->
<!--              <div class="col-md-3 col-sm-6">-->
<!--                <form-input-->
<!--                  :id="'password_confirmation'"-->
<!--                  v-model="form.password_confirmation"-->
<!--                  :label="'users.password.confirm'"-->
<!--                  :form="form"-->
<!--                />-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--        </admin-section>-->
<!--      </div> &lt;!&ndash; .col-md-9 &ndash;&gt;-->

<!--      <div class="col-md-3">-->
<!--        <admin-section>-->
<!--          <h4 slot="header">-->
<!--            {{ $t('admin.user_status') }}-->
<!--          </h4>-->
<!--          <div-->
<!--            slot="content"-->
<!--            class="form-row"-->
<!--          />-->
<!--          <router-link-->
<!--            slot="footer"-->
<!--            :loading="loading"-->
<!--            :to="`/admin/users`"-->
<!--            exact=""-->
<!--            class="btn btn-danger"-->
<!--          >-->
<!--            {{ $t('buttons.cancel') }}-->
<!--          </router-link>-->

<!--          <button-->
<!--            slot="footer"-->
<!--            type="submit"-->
<!--            :loading="loading"-->
<!--            class="btn btn-success"-->
<!--          >-->
<!--            {{ $t('buttons.save') }}-->
<!--          </button>-->
<!--        </admin-section>-->
<!--      </div> &lt;!&ndash; .col-md-3 &ndash;&gt;-->
<!--    </div> &lt;!&ndash; .row &ndash;&gt;-->
<!--  </form>-->
<!--</template>-->
