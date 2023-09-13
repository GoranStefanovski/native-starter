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
  import Datepicker from 'vue2-datepicker';
  import VueTimepicker from 'vue2-timepicker';
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
  import { event } from '@/utils/Objects';

  const router = useRouter();
  const store = useStore();

  const homePath = computed(() => store.state.Root.homePath);

  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);

  const item = ref(cloneDeep(event));
  const edit = router.currentRoute.name == 'edit.event';
  const id = Number(router.currentRoute.params.eventId);
  const getPostUri = `guest/common/${id}/getEvent`
  const fetchUri = `auth/user`;
  const locations = ref([]);
  const musicTypes = ref([]);
  const cities = ref([]);
  const {
    form,
    messageClass,
    message,
    loading,
    onSubmit,
    initFormFromItem,
    clearErrors
  } = useForm(getPostUri, event);

  provide('form', form.value);
  provide('labelStart', 'event');

const postUri = computed(() => edit ? `common/event/${id}/edit` : '/common/save-event');
  const locationsApi = 'common/locations/user/draw';
  const musicTypesUri = 'guest/common/music-types';

  const fetchCountries = async () => {
    try {
      const response = await axios.post(locationsApi);
      for (let key in response.data) {
        if (response.data.hasOwnProperty(key)) {
          locations.value.push({ id: `${response.data[key]['id']}`, name: `${response.data[key]['title']}` });
        }
      }
    } catch (error) {
      console.error(error);
    }
  }

  const fetchMusicTypes = async () => {
    try {
      const response = await axios.get(musicTypesUri);
      for (let key in response.data) {
        if (response.data.hasOwnProperty(key)) {
          musicTypes.value.push({ id: `${response.data[key]['id']}`, name: `${response.data[key]['name']}` });
        }
      }
    } catch (error) {
      console.error(error);
    }
  }

  const customLabel = (option) => {
    return option.name
  }

  const postImg = (() => {
    console.log(form.value.media[0]);
    const { media } = form.value.media[0];
    if (media != undefined) {
      const postImage = media.find(o => o.collection_name === 'event_image');
      if (!!postImage) {
        return getPhotoPath(postImage, 400);
      }
    }
    return '';
  })

  const beforeSubmit = (hasToRedirect = true) => {
    onSubmit(postUri.value, 'events', hasToRedirect, form.value);
  }

  const handleModelUpdate = (value, forcities) => {
    console.log("VALUE", value);
    console.log("input", forcities);
  }

  onMounted(async () => {

    await fetchCountries();
    await initFormFromItem();
    await fetchMusicTypes();

    if(edit) {
      form.value.music_types = JSON.parse(form.value.music_types)
    }    
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
              {{ $t('posts.basic.information') }}
            </PortletHeadLabel>
            <PortletHeadToolbar>
              <router-link
                :loading="loading"
                :to="{name:'events'}"
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
                <button
                  type="button"
                  class="btn btn-brand dropdown-toggle dropdown-toggle-split"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                />
                <div class="dropdown-menu dropdown-menu-right">
                  <ul class="kt-nav">
                    <li class="kt-nav__item">
                      <a
                        href="#"
                        class="kt-nav__link"
                      >
                        <i class="kt-nav__link-icon flaticon2-reload" />
                        <span class="kt-nav__link-text">Save & continue</span>
                      </a>
                    </li>
                    <li class="kt-nav__item">
                      <a
                        href="#"
                        class="kt-nav__link"
                      >
                        <i class="kt-nav__link-icon flaticon2-power" />
                        <span class="kt-nav__link-text">Save & exit</span>
                      </a>
                    </li>
                    <li class="kt-nav__item">
                      <a
                        href="#"
                        class="kt-nav__link"
                      >
                        <i class="kt-nav__link-icon flaticon2-edit-interface-symbol-of-pencil-tool" />
                        <span class="kt-nav__link-text">Save & edit</span>
                      </a>
                    </li>
                    <li class="kt-nav__item">
                      <a
                        href="#"
                        class="kt-nav__link"
                      >
                        <i class="kt-nav__link-icon flaticon2-add-1" />
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
              <div class="col-xl-3" />
              <div class="col-xl-6">
                <div class="kt-section kt-section--first">
                  <div class="kt-section__body">
                    <h3 class="kt-section__title kt-section__title-lg">
                      {{ $t('posts.post_status') }}:
                    </h3>
                  </div>
                </div>
                <div class="form-group row">
                      <label class="col-3 col-form-label">Location Name:</label>
                      <div class="col-9">
                        <FormDropdown
                          id="location_id"
                          v-model="form.location_id"
                          :options="locations"
                          :getcities="true"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Music Genre:</label>
                      <div class="col-9">
                        <multiselect
                          v-model="form.music_types"
                          :options="musicTypes"
                          track-by="id"
                          multiple
                          :custom-label="customLabel"
                          @update:modelValue="handleModelUpdate"
                          >
                        </multiselect>
                      </div>
                    </div>
                <div class="kt-section">
                  <div class="kt-section__body">
                    <h3 class="kt-section__title kt-section__title-lg">
                      Post information:
                    </h3>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Event Image</label>
                      <div class="col-9">
                        <file-upload
                          :id="'uploaded_file'"
                          v-model="form.uploaded_file"
                          :placeholder-image="postImg"
                          :form="form"
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
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Event Start:</label>
                      <div class="col-9">
                        <datepicker v-model="form.start_date" format="DD/MM/YYYY" placeholder="Start Date"></datepicker>
                        <vue-timepicker v-model="form.start_time" format="HH:mm" placeholder="Start Time"></vue-timepicker>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Event End:</label>
                      <div class="col-9">
                        <datepicker v-model="form.end_date" format="DD/MM/YYYY" placeholder="End Date"></datepicker>
                        <vue-timepicker v-model="form.end_time" format="HH:mm" placeholder="End Time"></vue-timepicker>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Active</label>
                      <div class="col-9">
                        <input
                          id="Active"
                          type="checkbox"
                          class="form-control"
                          placeholder="Active"
                          v-model="form.is_active"
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
