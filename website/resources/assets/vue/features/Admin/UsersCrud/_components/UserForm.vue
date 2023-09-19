<script lang="ts" setup>
  import { ref, provide, computed, onMounted } from 'vue';
  import 'reflect-metadata'
  import 'bootstrap';
  import { cloneDeep } from 'lodash';
  import { useStore } from '@/store';
  import { useRouter } from 'vue-router/composables';
  import { useForm } from '@/composables';
  import { Portlet } from '@/components';
  import axios from 'axios';

  import {
    PortletFoot, PortletBody, PortletHeadLabel, PortletHead, PortletHeadToolbar
  } from '@/components/Portlet/components';
  import {
    FormDropdown,
    FormInputRadio,
    FormInput,
    CustomForm
  } from '@/components/Form';
  import { getPhotoPath } from '@/utils/imageProcessing';
  import { user } from '@/utils/Objects';

  const router = useRouter();
  const store = useStore();

  const homePath = computed(() => store.state.Root.homePath);

  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);

  const item = ref(cloneDeep(user));
  const edit = router.currentRoute.name == 'edit.user';
  const id = Number(router.currentRoute.params.userId);
  const fetchUri = `/user/${id}/get`;
  const roles = ref([]);
  const countries = ref([]);
  const subTypes = ref([]);
  const {
    form,
    messageClass,
    message,
    loading,
    onSubmit,
    initFormFromItem,
    clearErrors
  } = useForm(fetchUri, user);

  provide('form', form.value);
  provide('labelStart', 'user');

  const postUri = computed(() => edit ? `/user/${id}/edit` : '/guest/user/register');
  const redirectRoute = computed(() => [1,2].includes(form.roles) ? 'users' : 'users.public');

  const optionsIsDisabled: Array<any> = [{'id': 0, 'name':'Enabled'},{'id': 1, 'name':'Disabled'}];

    const fetchRoles = async () => {
    try {
      const response = await axios.get('user/roles/get');
      roles.value = response.data;
    } catch (error) {
      console.error(error);
    }
  }

  const fetchSubTypes = async () => {
    try {
      const response = await axios.get('guest/common/sub-types');
      for (let key in response.data) {
        if (response.data.hasOwnProperty(key)) {
          subTypes.value.push({ id: `${response.data[key]['id']}`, name: `${response.data[key]['name']}` });
        }
      }
    } catch (error) {
      console.error(error);
    }
  }

  const fetchCountries = async () => {
    try {
      const response = await axios.get('guest/common/get-countries');
      for (let key in response.data) {
        if (response.data.hasOwnProperty(key)) {
          countries.value.push({ id: key, name: `${response.data[key]['full_name']}` });
        }
      }
    } catch (error) {
      console.error(error);
    }
  }

  const avatar = computed(() => {
    const { media } = item.value;
    if (media != undefined) {
      const userAvatar = media.find(o => o.collection_name === 'user_avatars');
      if (!!userAvatar) {
        return getPhotoPath(userAvatar, 400);
      }
    }
    return '';
  })

  const beforeSubmit = (hasToRedirect = true) => {
    onSubmit(postUri.value, redirectRoute.value, hasToRedirect, form);
  }

  onMounted(() => {
    if (edit) {
      item.value.roles = item.value.roles_array[0];
    } else {
      item.value.roles = 3;
    }
    initFormFromItem();
    fetchCountries();
    fetchRoles();
    fetchSubTypes();
  })
</script>

<template>
  <CustomForm
    class="container-fluid"
    autocomplete="off"
    enctype="multipart/form-data"
    @beforeSubmit="beforeSubmit"
    @keydown="form.errors.clear($event.target.name)"
  >
    <div class="row">
      <div class="col-12">
        <Portlet :has-sticky-header="true" :is-loading="loading">
          <PortletHead :size="'lg'">
            <PortletHeadLabel>
              {{ $t('users.basic.information') }}
            </PortletHeadLabel>
            <PortletHeadToolbar>
              <router-link
                :loading="loading"
                :to="`/admin/users/public`"
                exact=""
                class="btn btn-clean kt-margin-r-10"
              >
                <i class="la la-arrow-left"></i>
                <span class="kt-hidden-mobile">{{ $t('buttons.cancel') }}</span>
              </router-link>
              <div class="btn-group">
                <button
                  type="submit"
                  :loading="loading"
                  class="btn btn-brand"
                >
                  <i class="fa fa-save mr-1" />
                  {{ $t('buttons.save') }}
                </button>
                <button type="button" class="btn btn-brand dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <ul class="kt-nav">
                    <li class="kt-nav__item">
                      <a href="#" class="kt-nav__link">
                        <i class="kt-nav__link-icon flaticon2-reload"></i>
                        <span class="kt-nav__link-text">Save & continue</span>
                      </a>
                    </li>
                    <li class="kt-nav__item">
                      <a href="#" class="kt-nav__link">
                        <i class="kt-nav__link-icon flaticon2-power"></i>
                        <span class="kt-nav__link-text">Save & exit</span>
                      </a>
                    </li>
                    <li class="kt-nav__item">
                      <a href="#" class="kt-nav__link">
                        <i class="kt-nav__link-icon flaticon2-edit-interface-symbol-of-pencil-tool"></i>
                        <span class="kt-nav__link-text">Save & edit</span>
                      </a>
                    </li>
                    <li class="kt-nav__item">
                      <a href="#" class="kt-nav__link">
                        <i class="kt-nav__link-icon flaticon2-add-1"></i>
                        <span class="kt-nav__link-text">Save & add new</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </PortletHeadToolbar>
          </PortletHead>
          <PortletBody>
            <div class="row">
              <div class="col-xl-3"></div>
              <div class="col-xl-6">

                <div class="kt-section kt-section--first">
                  <div class="kt-section__body">
                    <h3 class="kt-section__title kt-section__title-lg">{{ $t('users.user_status') }}:</h3>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{$t('users.roles.label')}}</label>
                      <div class="col-9">
                        <FormDropdown v-model="form.roles" :options="roles" id="roles"/>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{$t('users.status')}}</label>
                      <div class="col-9" style="display: grid;">
                        <span v-for="option, index in optionsIsDisabled" :key="index">
                        <label :for="option.name">{{ option.name }}</label>
                        <input
                          :value="option.id"
                          type="radio"
                          :placeholder="option.name"
                          :id="'is_disabled'"
                          v-model="form.is_disabled"
                        />
                      </span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Subscription Plan:</label>
                      <div class="col-9">
                        <FormDropdown v-model="form.sub_type" :options="subTypes" id="sub_type" />
                      </div>>
                    </div>
                  </div>
                </div>

                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>

                <div class="kt-section">
                  <div class="kt-section__body">
                    <h3 class="kt-section__title kt-section__title-lg">Customer Info:</h3>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Username</label>
                      <div class="col-9">
                        <input v-model="form.username" class="form-control" type="text" placeholder="Username" required  />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{$t('users.last_name.label')}}</label>
                      <div class="col-9">
                        <input v-model="form.last_name" class="form-control" type="text" placeholder="Last Name" required  />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{$t('users.first_name.label')}}</label>
                      <div class="col-9">
                        <input v-model="form.first_name" class="form-control" type="text" placeholder="First Name" required />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{$t('users.email.label')}}</label>
                      <div class="col-9">
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                            <input v-model="form.email" class="form-control" type="text" placeholder="Email" required />
                          </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{$t('users.phone.label')}}</label>
                      <div class="col-9">
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
                          <input v-model="form.phone" class="form-control" type="text" placeholder="Phone" required />
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{$t('users.country.label')}}</label>
                      <div class="col-9">
                        <FormDropdown v-model="form.country_id" :options="countries" id="country_id" />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{$t('users.company')}}</label>
                      <div class="col-9">
                        <input v-model="form.company" class="form-control" type="text" placeholder="Company" required />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>

                <div class="kt-section">
                  <div class="kt-section__body">
                    <h3 class="kt-section__title kt-section__title-lg">{{ $t('users.password.new_password') }}:</h3>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{$t('users.password.label')}}</label>
                      <div class="col-9">
                        <input v-model="form.password" class="form-control" type="password" placeholder="Password" :required="!edit ? true : false" />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{$t('users.password.confirm')}}</label>
                      <div class="col-9">
                        <input v-model="form.password_confirmation" class="form-control" type="password" placeholder="Password Confirmation" :required="!edit ? true : false" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3"></div>
            </div>
          </PortletBody>
        </Portlet>
      </div>
    </div>
    <!--    <unsaved-changes-modal-->
    <!--      v-if="confirmUnsavedChangesModal"-->
    <!--      @confirm-unsaved-changes="confirmUnsavedChanges"-->
    <!--      @cancel-unsaved-changes="cancelUnsavedChanges"-->
    <!--    />-->
  </CustomForm>
</template>
