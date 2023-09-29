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
  import Datepicker from 'vue2-datepicker';
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
  import axios from 'axios';
  const router = useRouter();
  const store = useStore();

  const homePath = computed(() => store.state.Root.homePath);

  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);

  const item = ref(cloneDeep(shorts_post));
  const id = Number(router.currentRoute.params.shortsPostId);
  const getPostUri = `guest/common/${id}/getShortsPost`
  const fetchUri = `auth/user`;
  const responseDataArray = [];
  const edit = responseDataArray[0] ? true : false;
  const cities = ref([]);
  let isEdit = false;
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

  const postUri = computed(() => `/common/short-post/${id}/edit/status`);

  const formatDate = (dateInput) => {
      const date = new Date(dateInput);
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is zero-based
      const day = String(date.getDate()).padStart(2, '0');
      return `${year}-${month}-${day}`;
    }

  const beforeSubmit = (hasToRedirect = true) => {
    form.value.start_active_date = formatDate(form.value.start_active_date)
    form.value.end_active_date = formatDate(form.value.end_active_date)
    onSubmit(postUri.value, 'posts_short', hasToRedirect, form.value);
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
              Active Period
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
                  <div class="kt-section">
                    <div class="kt-section__body">
                      <div class="form-group row">
                        <label class="col-3 col-form-label">Active Period Start:</label>
                        <div class="col-9">
                          <datepicker v-model="form.start_active_date" @update:modelValue="handleModelUpdate" :enableTimePicker="false" format="YYYY-MM-DD" :placeholder="form.start_active_date ? form.start_active_date : 'Start Date'"></datepicker>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-3 col-form-label">Active Period End:</label>
                        <div class="col-9">
                          <datepicker v-model="form.end_active_date" @update:modelValue="handleModelUpdate" :enableTimePicker="false" :format="'YYYY-MM-DD'" :placeholder="form.end_active_date ? form.end_active_date : 'End Date'"></datepicker>
                        </div>
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
