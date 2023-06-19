<script setup lang="ts">
  // import { Component, Mixins, Vue } from 'vue-property-decorator';
  // import UserProfile from "@/views/front/User/UserProfile.vue";
  // import { getPhotoPath } from '@/utils/imageProcessing';
  // import Form from '../../../../../../node_modules/form-backend-validation';
  // import { createFile } from '@/utils/edgeFileUpload';
  // import { FormMixin } from "@/mixins/FormMixin";

  // @Component
  // export default class UserDashboard extends Mixins(FormMixin) {
  //
  //   currentComponent: String = "UserProfile";
  //   routes: Object;
  //   uploaded_file: File|null = createFile('image/jpg');
  //   form: Form;
  //
  //   constructor() {
  //     super();
  //     this.routes = {
  //       'user.dashboard.user-profile': 'User Profile'
  //     };
  //
  //     this.form = new Form({
  //       uploaded_file: this.uploaded_file
  //     });
  //   }
  //
  //   getAvatar(){
  //     if(this.$auth.user().media != undefined){
  //       const avatar = this.$auth.user().media.find(o => o.collection_name === 'user_avatars');
  //       if(!!avatar)
  //         return getPhotoPath(avatar, 400);
  //     }
  //     return '';
  //   }
  //
  //   uploadNewAvatar(){
  //     this.form.uploaded_file = (<any>this.$refs.user_avatar).files[0];
  //     this.onSubmit('guest/user/avatar','',true);
  //   }
  // }
</script>

<template>
<!--  <div class="user-dashboard">-->
<!--    <div class="page-header page-header&#45;&#45;image-bg">-->
<!--      <h1 class="page-header__main-title">-->
<!--        Кориснички профил-->
<!--      </h1>-->
<!--      <p class="page-header__sub-title">-->
<!--        Lorem ipsum dolor sit amet, consectetur adipiscing elit,sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.-->
<!--      </p>-->
<!--    </div>-->

<!--    <div class="container">-->
<!--      <div class="row">-->
<!--        <div class="col-md-3">-->
<!--          <input-->
<!--            ref="user_avatar"-->
<!--            style="display: none"-->
<!--            type="file"-->
<!--            @change="uploadNewAvatar"-->
<!--          >-->

<!--          <div class="d-flex justify-content-center mb-4">-->
<!--            <div class="profile-image-outer-container bg-color-primary">-->
<!--              <div class="profile-image-inner-container">-->
<!--                <img-->
<!--                  :src="getAvatar()"-->
<!--                  :alt="'user_avatar'"-->
<!--                  @click="$refs.user_avatar.click()"-->
<!--                >-->
<!--              </div>-->
<!--              <span-->
<!--                class="profile-image-button bg-color-dark"-->
<!--                @click="$refs.user_avatar.click()"-->
<!--              >-->
<!--                <i class="fa fa-camera text-light" />-->
<!--              </span>-->
<!--              &lt;!&ndash;              <input type="file" id="file" class="profile-image-input">&ndash;&gt;-->
<!--            </div>-->
<!--          </div>-->

<!--          <aside-->
<!--            id="sidebar"-->
<!--            class="sidebar mt-2"-->
<!--          >-->
<!--            <ul class="nav nav-list flex-column mb-5">-->
<!--              <ul>-->
<!--                <li-->
<!--                  v-for="(label, route) in routes"-->
<!--                  :key="route"-->
<!--                  class="nav-item"-->
<!--                >-->
<!--                  &lt;!&ndash;                    <a class="nav-link" @click="changeComponent(route)">{{component}}</a>&ndash;&gt;-->
<!--                  <router-link-->
<!--                    :to="{ name: route }"-->
<!--                    class="nav-link"-->
<!--                  >-->
<!--                    {{ label }}-->
<!--                  </router-link>-->
<!--                </li>-->
<!--              </ul>-->
<!--            </ul>-->
<!--          </aside>-->
<!--        </div>-->

<!--        <div class="col-md-9">-->
<!--          <transition-->
<!--            name="fade"-->
<!--            :duration="200"-->
<!--            mode="out-in"-->
<!--          >-->
<!--            <router-view />-->
<!--          </transition>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<div></div>
</template>
