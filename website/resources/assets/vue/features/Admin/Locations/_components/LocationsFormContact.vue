<script lang="ts" setup>
  import { ref, provide, computed, onMounted } from 'vue';
  import 'reflect-metadata'
  import 'bootstrap';
  import { cloneDeep } from 'lodash';
  import { useStore } from '@/store';
  import { useRouter } from 'vue-router/composables';
  import { useForm } from '@/composables';
  import { Portlet } from '@/components';
  import FileUpload from "@/components/Form/FileUpload.vue";
  import Multiselect from 'vue-multiselect';
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
  import { location } from '@/utils/Objects';

  const router = useRouter();
  const store = useStore();

  const homePath = computed(() => store.state.Root.homePath);

  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);

  const item = ref(cloneDeep(location));
  const edit = router.currentRoute.fullPath.includes('/edit/');
  const id = Number(router.currentRoute.params.locationId);
  const getPostUri = `guest/common/${id}/getLocation`
  const fetchUri = `auth/user`;
  const countries = ref([]);
  const location_types = ref([]);
  const cities = ref([]);
  const {
    form,
    messageClass,
    message,
    loading,
    onSubmit,
    initFormFromItem,
    clearErrors
  } = useForm(getPostUri, location);

  provide('form', form.value);
  provide('labelStart', 'location');

  const postUri = computed(() => `common/location/${id}/edit/contact`);

  const beforeSubmit = (hasToRedirect = true ) => {
    onSubmit(postUri.value, 'edit.location.working_hours', hasToRedirect, form.value);
  }

  const handleModelUpdate = (value, forcities) => {
    console.log("VALUE", value);
    console.log("input", forcities);
  }

  onMounted(async () => {

    await initFormFromItem();

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
        <Portlet
          :has-sticky-header="true"
          :is-loading="loading"
        >
          <PortletHead :size="'lg'">
            <PortletHeadLabel>
              Owner & Contact Info
            </PortletHeadLabel>
            <PortletHeadToolbar>
              <router-link
                :loading="loading"
                :to="{name:'locations'}"
                exact=""
                class="btn btn-clean kt-margin-r-10"
              >
                <i class="la la-arrow-left" />
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
              </div>
            </PortletHeadToolbar>
          </PortletHead>
          <PortletBody>
            <div class="row">
              <div class="col-xl-3" />
              <div class="col-xl-6">
                <div class="kt-section kt-section-first">
                  <div class="kt-section__body">
                    <h3 class="kt-section__title kt-section__title-lg">
                      Contact Person
                    </h3>
                  </div>
                </div>
                <div class="kt-section">
                  <div class="kt-section__body">
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Full Name</label>
                      <div class="col-9">
                        <input
                          id="contact_person"
                          class="form-control"
                          v-model="form.contact_person"
                          placeholder="Full Name"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Phone</label>
                      <div class="col-9">
                        <input
                          id="contact_person_phone"
                          class="form-control"
                          v-model="form.contact_person_phone"
                          placeholder="Phone"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Email</label>
                      <div class="col-9">
                        <input
                          id="contact_person_email"
                          class="form-control"
                          placeholder="Email"
                          v-model="form.contact_person_email"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-3" />
              <div class="col-xl-6">
                <div class="kt-section kt-section-first">
                  <div class="kt-section__body">
                    <h3 class="kt-section__title kt-section__title-lg">
                      Contact Person Second (optional)
                    </h3>
                  </div>
                </div>
                <div class="kt-section">
                  <div class="kt-section__body">
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Full Name</label>
                      <div class="col-9">
                        <input
                          id="contact_person_second"
                          class="form-control"
                          v-model="form.contact_person_second"
                          placeholder="Full Name"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Phone</label>
                      <div class="col-9">
                        <input
                          id="contact_person_phone_second"
                          class="form-control"
                          v-model="form.contact_person_phone_second"
                          placeholder="Phone"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Email</label>
                      <div class="col-9">
                        <input
                          id="contact_person_email_second"
                          class="form-control"
                          placeholder="Email"
                          v-model="form.contact_person_email_second"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-3" />
              <div class="col-xl-6">
                <div class="kt-section kt-section-first">
                  <div class="kt-section__body">
                    <h3 class="kt-section__title kt-section__title-lg">
                      Web
                    </h3>
                  </div>
                </div>
                <div class="kt-section">
                  <div class="kt-section__body">
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Website</label>
                      <div class="col-9">
                        <input
                          id="website"
                          class="form-control"
                          v-model="form.website"
                          placeholder="Website"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Website (optional)</label>
                      <div class="col-9">
                        <input
                          id="website_second"
                          class="form-control"
                          v-model="form.website_second"
                          placeholder="Website"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </PortletBody>
        </Portlet>
      </div>
    </div>
  </CustomForm>
</template>
