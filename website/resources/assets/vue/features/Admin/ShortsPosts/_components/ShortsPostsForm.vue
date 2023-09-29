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
  import { shorts_post } from '@/utils/Objects';
  import VueTimepicker from 'vue2-timepicker';

  const router = useRouter();
  const store = useStore();

  const homePath = computed(() => store.state.Root.homePath);

  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);

  const item = ref(cloneDeep(shorts_post));
  const edit = router.currentRoute.fullPath.includes('/edit/') ? true : false;
  const id = Number(router.currentRoute.params.shortsPostId);
  const getPostUri = `guest/common/${id}/getShortsPost`
  const fetchUri = `auth/user`;
  const location_types = ref([]);
  const music_types = ref([]);
  const cities = ref([]);
  const {
    form,
    messageClass,
    message,
    loading,
    onSubmit,
    initFormFromItem,
    clearErrors
  } = useForm(getPostUri, shorts_post);

  provide('form', form.value);
  provide('labelStart', 'shorts_post');

  const postUri = computed(() => edit ? `common/short-post/${id}/edit` : '/common/save-short-post');
  const locationTypesUri = 'guest/common/location-types';
  const musicTypesUri = 'guest/common/music-types';

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

  const fetchMusicTypes = async () => {
    try {
      const response = await axios.get(musicTypesUri);
      for (let key in response.data) {
        if (response.data.hasOwnProperty(key)) {
          music_types.value.push({ id: `${response.data[key]['id']}`, name: `${response.data[key]['name']}` });
        }
      }
    } catch (error) {
      console.error(error);
    }
  }

  const beforeSubmit = (hasToRedirect = true) => {
    onSubmit(postUri.value, 'posts_short', hasToRedirect, form.value);
  }

  const handleModelUpdate = (value, forcities) => {
    console.log("VALUE", value);
    console.log("input", forcities);
  }

  onMounted(async () => {

    await initFormFromItem();
    await fetchLocationTypes();
    await fetchMusicTypes();
    if(edit) {
      form.value.location_types = JSON.parse(form.value.location_types)
      form.value.music_types = JSON.parse(form.value.music_types)
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
              Shorts Post Data
            </PortletHeadLabel>
            <PortletHeadToolbar>
              <router-link
                :loading="loading"
                :to="{name:'posts_short'}"
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
                      Blog Post:
                    </h3>
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
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Music Type</label>
                      <div class="col-9">
                        <multiselect
                          v-model="form.music_types"
                          :options="music_types"
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
                      <label class="col-3 col-form-label">Link</label>
                      <div class="col-9">
                        <input
                          id="link"
                          class="form-control"
                          placeholder="Link"
                          v-model="form.link"
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
