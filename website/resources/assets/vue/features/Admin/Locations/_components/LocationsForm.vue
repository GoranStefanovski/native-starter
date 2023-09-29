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
  import VueTimepicker from 'vue2-timepicker';

  const router = useRouter();
  const store = useStore();

  const homePath = computed(() => store.state.Root.homePath);

  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);

  const item = ref(cloneDeep(location));
  const edit = router.currentRoute.fullPath.includes('/edit/') ? true : false;
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

  const postUri = computed(() => edit ? `common/location/${id}/edit` : '/common/save-location');
  const countriesUri = 'guest/common/get-countries';
  const locationTypesUri = 'guest/common/location-types';

  const fetchCountries = async () => {
    try {
      const response = await axios.get(countriesUri);
      for (let key in response.data) {
        if (response.data.hasOwnProperty(key)) {
          countries.value.push({ id: `${response.data[key]['id']}`, name: `${response.data[key]['name']}` });
        }
      }
    } catch (error) {
      console.error(error);
    }
  }

  const fetchLocationTypes = async () => {
    try {
      const response = await axios.get(locationTypesUri);
      for (let key in response.data) {
        if (response.data.hasOwnProperty(key)) {
          location_types.value.push({ id: `${response.data[key]['id']}`, name: `${response.data[key]['name']}` });
        }
      }
    } catch (error) {
      console.error(error);
    }
  }

  const postImg = (() => {
    console.log(form.value.media[0]);
    const { media } = form.value.media[0];
    if (media != undefined) {
      const postImage = media.find(o => o.collection_name === 'location_image');
      if (!!postImage) {
        return getPhotoPath(postImage, 400);
      }
    }
    return '';
  })

  const beforeSubmit = (hasToRedirect = true) => {
    onSubmit(postUri.value, 'locations', hasToRedirect, form.value);
  }

  const handleModelUpdate = (value, forcities) => {
    console.log("VALUE", value);
    console.log("input", forcities);
  }

  onMounted(async () => {

    await fetchCountries();
    await initFormFromItem();
    await fetchLocationTypes();

    if(edit) {
      form.value.location_types = JSON.parse(form.value.location_types)
    } 

  })

  const customLabel = (option) => {
    return option.name
  }
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
              Location Information
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
                <div class="kt-section kt-section--first">
                  <div class="kt-section__body">
                    <h3 class="kt-section__title kt-section__title-lg">
                      Location:
                    </h3>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Country</label>
                      <div class="col-9">
                        <input
                          id="country"
                          class="form-control"
                          v-model="form.country"
                          :disabled="true"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">City</label>
                      <div class="col-9">
                        <input
                          placeholder="City"
                          id="city"
                          class="form-control"
                          v-model="form.city"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Address</label>
                      <div class="col-9">
                        <input
                          placeholder="Address"
                          id="address"
                          class="form-control"
                          v-model="form.address"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Location Type</label>
                      <div class="col-9">
                        <multiselect
                          v-model="form.location_types"
                          :options="location_types"
                          track-by="id"
                          multiple
                          :custom-label="customLabel"
                          @update:modelValue="handleModelUpdate"
                          >
                        </multiselect>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="kt-separator kt-separator&#45;&#45;border-dashed kt-separator&#45;&#45;space-lg" />
                <div class="kt-section">
                  <div class="kt-section__body">
                    <h3 class="kt-section__title kt-section__title-lg">
                      information:
                    </h3>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Location Image</label>
                      <div class="col-9">
                        <file-upload
                          :id="'uploaded_file'"
                          v-model="form.uploaded_file"
                          :placeholder-image="postImg"
                          :form="form"
                          :edit="edit"
                          component-type="image"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Title</label>
                      <div class="col-9">
                        <input
                          id="title"
                          class="form-control"
                          v-model="form.title"
                          placeholder="Title"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Description</label>
                      <div class="col-9">
                        <input
                          id="description"
                          class="form-control"
                          placeholder="Description"
                          v-model="form.description"
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
    <!--    <unsaved-changes-modal-->
    <!--      v-if="confirmUnsavedChangesModal"-->
    <!--      @confirm-unsaved-changes="confirmUnsavedChanges"-->
    <!--      @cancel-unsaved-changes="cancelUnsavedChanges"-->
    <!--    />-->
  </CustomForm>
</template>
