<script setup lang="ts">
  // import { namespace } from 'vuex-class';
  // import { FormMixin } from "@/mixins/FormMixin";
  // import Form from '../../../../../../../node_modules/form-backend-validation';
  // import ContentLoader from '@/components/ContentLoader/ContentLoader.vue';
  // import { cloneDeep } from 'lodash';
  // import EventBus from "@/utils/event-bus";
  //
  // import { user } from '@/utils/Objects';
  // import { FileUpload } from "@/components/Form";
  // import { Taxonomies } from '@/services';
  // import container from "@/config/ioc_config";
  // import SERVICE_IDENTIFIER from "@/config/constants/Identifiers";
  //
  // const { Action } = namespace('Root');
  // const { State } = namespace('Root');
  //
  // @Component({
  //   components: {
  //     ContentLoader,
  //     FileUpload
  //   }
  // })
  // export default class MyProfileForm extends Mixins(FormMixin)  {
  //
  //   item: MyProfileFormItem;
  //   id: number | undefined;
  //   taxonomies: Taxonomies = container.get<Taxonomies>(SERVICE_IDENTIFIER.TAXONOMIES);
  //
  //   constructor() {
  //     super();
  //     this.message = "";
  //     this.messageClass = "";
  //     this.loading = false;
  //     this.id = 0;
  //     this.fetchUri = 'guest/user/myprofile';
  //     this.item = cloneDeep(user);
  //     this.form = new Form(this.item);
  //   }
  //
  //   mounted() {
  //     EventBus.$on('formSubmitSuccess', this.refreshUser);
  //     this.initFormFromItem();
  //   }
  //
  //   getRoute() {
  //     return 'guest/user/myprofile/' + this.id;
  //   }
  //
  //   attachFile(file){
  //     this.form.uploaded_file = (<any>this.$refs.photo_file).files[0];
  //     console.table(this.form.uploaded_file);
  //   }
  //
  //   refreshUser(){
  //     this.$auth.fetch().then(()=>{
  //       this.initFormFromItem();
  //     });
  //   }
  //
  //   beforeSubmit(route, redirect_success, stop_redirect){
  //     // if(this.form.password == '' && this.form.password_confirmation == '') {
  //     //     delete (this.form.password);
  //     //     delete (this.form.password_confirmation);
  //     // }
  //     this.onSubmit(route, redirect_success, stop_redirect);
  //   }
  // }
</script>
<!--TODO: Use custom form inputs for this form-->
<template>
<!--  <div class="user-profile">-->
<!--    <div class="overflow-hidden mb-1">-->
<!--      <h2-->
<!--        class="font-weight-normal text-7 mb-0"-->
<!--        v-html="$t('pages.user_dashboard.titles.my_profile')"-->
<!--      />-->
<!--    </div>-->
<!--    <div class="overflow-hidden mb-4 pb-3">-->
<!--      <p class="mb-0">-->
<!--        {{ $t('pages.user_dashboard.titles.my_profile_subtitle') }}-->
<!--      </p>-->
<!--    </div>-->

<!--    <form-->
<!--      class="container-fluid"-->
<!--      @submit.prevent="beforeSubmit(getRoute(), '', true)"-->
<!--      @keydown="form.errors.clear($event.target.name)"-->
<!--    >-->
<!--      <div class="row">-->
<!--        <div class="col-md-12">-->
<!--          <content-loader-->
<!--            v-if="loading"-->
<!--            :height-class="'mh-10'"-->
<!--            :full-cont="true"-->
<!--            :transparent="true"-->
<!--          />-->

<!--          <div :class="messageClass">-->
<!--            {{ message }}-->
<!--          </div>-->

<!--          <div class="form-group row">-->
<!--            <label class="col-lg-3 font-weight-bold text-dark col-form-label form-control-label text-2 required">{{ $t('users.email.label') }}</label>-->
<!--            <div class="col-lg-9">-->
<!--              <input-->
<!--                v-model="form.email"-->
<!--                type="text"-->
<!--                name="email"-->
<!--                placeholder="Email"-->
<!--                class="form-control"-->
<!--              >-->
<!--              <div-->
<!--                v-if="form.errors.has('email')"-->
<!--                class="invalid-feedback"-->
<!--              >-->
<!--                {{ $t(form.errors.get('email')) }}-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->

<!--          <div class="form-group row">-->
<!--            <label class="col-lg-3 font-weight-bold text-dark col-form-label form-control-label text-2 required">{{ $t('users.first_name.label') }}</label>-->
<!--            <div class="col-lg-9">-->
<!--              <input-->
<!--                v-model="form.first_name"-->
<!--                type="text"-->
<!--                name="first_name"-->
<!--                placeholder="First Name"-->
<!--                class="form-control"-->
<!--              >-->
<!--              <div-->
<!--                v-if="form.errors.has('first_name')"-->
<!--                class="invalid-feedback"-->
<!--              >-->
<!--                {{ $t(form.errors.get('first_name')) }}-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->

<!--          <div class="form-group row">-->
<!--            <label class="col-lg-3 font-weight-bold text-dark col-form-label form-control-label text-2 required">{{ $t('users.last_name.label') }}</label>-->
<!--            <div class="col-lg-9">-->
<!--              <input-->
<!--                v-model="form.last_name"-->
<!--                type="text"-->
<!--                name="last_name"-->
<!--                placeholder="Last Name"-->
<!--                class="form-control"-->
<!--              >-->
<!--              <div-->
<!--                v-if="form.errors.has('last_name')"-->
<!--                class="invalid-feedback"-->
<!--              >-->
<!--                {{ $t(form.errors.get('last_name')) }}-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->

<!--          &lt;!&ndash;<file-upload :id="'file_upload'" :label="'users.avatar'" v-model="form.uploaded_file" :isInline="true" @input="attachFile"></file-upload>&ndash;&gt;-->

<!--          <div class="form-group row">-->
<!--            <label class="col-lg-3 font-weight-bold text-dark col-form-label form-control-label text-2">{{ $t('users.avatar') }}</label>-->
<!--            <div class="col-lg-9">-->
<!--              <input-->
<!--                id="file_upload"-->
<!--                ref="photo_file"-->
<!--                type="file"-->
<!--                name="file_upload"-->
<!--                @change="attachFile()"-->
<!--              >-->
<!--              <div-->
<!--                v-if="form.errors.has('file_upload')"-->
<!--                class="invalid-feedback"-->
<!--              >-->
<!--                {{ $t(form.errors.get('file_upload')) }}-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->

<!--          <div class="form-group row">-->
<!--            <label class="col-lg-3 font-weight-bold text-dark col-form-label form-control-label text-2 required">{{ $t('users.password.new_password') }}:</label>-->
<!--            <div class="col-lg-9">-->
<!--              <input-->
<!--                id="pass_eing"-->
<!--                v-model="form.password"-->
<!--                class="form-control"-->
<!--                name="password"-->
<!--                type="password"-->
<!--              >-->
<!--              <div-->
<!--                v-for="error in form.errors.get('password')"-->
<!--                v-if="form.errors.has('password')"-->
<!--                class="invalid-feedback"-->
<!--              >-->
<!--                {{ $t(error) }}-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->

<!--          <div class="form-group row">-->
<!--            <label class="col-lg-3 font-weight-bold text-dark col-form-label form-control-label text-2 required">{{ $t('users.password.confirm_new_password') }}:</label>-->
<!--            <div class="col-lg-9">-->
<!--              <input-->
<!--                id="pass2_eing"-->
<!--                v-model="form.password_confirmation"-->
<!--                class="form-control"-->
<!--                name="password_confirmation"-->
<!--                type="password"-->
<!--              >-->
<!--              <div-->
<!--                v-if="form.errors.has('password_confirmation')"-->
<!--                class="invalid-feedback"-->
<!--              >-->
<!--                {{ $t(form.errors.get('password_confirmation')) }}-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->

<!--          <div class="form-group row">-->
<!--            <div class="form-group col-12">-->
<!--              <input-->
<!--                type="submit"-->
<!--                :loading="loading"-->
<!--                :value="$t('buttons.save')"-->
<!--                class="btn btn-primary btn-modern float-right profile_submit"-->
<!--              >-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </form>-->
<!--  </div>-->
</template>
