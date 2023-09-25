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
  import { organization_events } from '@/utils/Objects';

  const router = useRouter();
  const store = useStore();

  const homePath = computed(() => store.state.Root.homePath);

  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);

  const item = ref(cloneDeep(organization_events));
  const edit = router.currentRoute.fullPath.includes('/edit/');
  const id = Number(router.currentRoute.params.organizationEventId);
  const getPostUri = `guest/common/${id}/getOrganizationEvent`
  const fetchUri = `auth/user`;
  const locations = ref([]);
  const musicTypes = ref([]);
  const boostedEvents = ref([]);
  const cities = ref([]);
  const {
    form,
    messageClass,
    message,
    loading,
    onSubmit,
    initFormFromItem,
    clearErrors
  } = useForm(getPostUri, organization_events);

  provide('form', form.value);
  provide('labelStart', 'organization_events');

const postUri = computed(() => edit ? `common/organization-event/${id}/edit` : 'common/save-organization-event');
  const musicTypesUri = 'guest/common/music-types';

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
    onSubmit(postUri.value, 'organization_events', hasToRedirect, form.value);
  }

  const handleModelUpdate = (value, forcities) => {
    console.log("VALUE", value);
    console.log("input", forcities);
  }

  onMounted(async () => {
    await initFormFromItem();
    await fetchMusicTypes();

    if (edit) {
      form.value.music_types = JSON.parse(form.value.music_types);
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
              Basic Information
            </PortletHeadLabel>
            <PortletHeadToolbar>
              <router-link
                :loading="loading"
                :to="{name:'organization_events'}"
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
                      Event Information:
                    </h3>
                  </div>
                </div>
                <div class="form-group row">
                      <label class="col-3 col-form-label">City</label>
                      <div class="col-9">
                        <input
                          id="city"
                          class="form-control"
                          v-model="form.city"
                          placeholder="City"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Address</label>
                      <div class="col-9">
                        <input
                          id="address"
                          class="form-control"
                          v-model="form.address"
                          placeholder="Address"
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
                      <label class="col-3 col-form-label">Name</label>
                      <div class="col-9">
                        <input
                          id="name"
                          class="form-control"
                          v-model="form.name"
                          placeholder="Name"
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

<style>
  .multiselect__tag {
    background: #505ae2 !important;
    display: flex !important;
    align-items: center !important;
    padding: 5px 25px 5px 10px;
    width: max-content !important;
  }

  .multiselect__tag-icon {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .multiselect__tag-icon:after {
    color: white !important;
  }

  .multiselect__tag-icon:hover {
    background: red !important;
}

</style>