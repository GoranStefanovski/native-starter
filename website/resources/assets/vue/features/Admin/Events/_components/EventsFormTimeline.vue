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
  const edit = router.currentRoute.fullPath.includes('/edit/');
  const selectedStartDate = ref(null);
  const selectedEndDate = ref(null);
  const id = Number(router.currentRoute.params.eventId);
  const getPostUri = `guest/common/${id}/getEvent`
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

  const sections: Array<any> = [{ name: 'Hall 1', inputs: [{ value: '' }] }]

  const postUri = computed(() => `common/event/${id}/edit/timeline`);

  const beforeSubmit = (hasToRedirect = true) => {
    form.value.start_date = formatDate(form.value.start_date)
    form.value.end_date = formatDate(form.value.end_date)
    onSubmit(postUri.value, 'events', hasToRedirect, form.value);
  }

  const handleModelUpdate = (value, forcities) => {
    console.log("VALUE", value);
    console.log("input", forcities);
  }

  const addInputField = (sectionIndex) => {
      sections[sectionIndex].inputs.push({ value: '' });
    }

    const addSection = (sectionIndex) => {
      const newSectionName = `Section ${sections.length + 1}`;
      const newSection = { name: newSectionName, inputs: [{ value: '' }] };
      sections.push(newSection);
    }
    
    const removeSection = (sectionIndex) => {
     sections.splice(sectionIndex, 1);
    }
  
    const formatDate = (dateInput) => {
      const date = new Date(dateInput);
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is zero-based
      const day = String(date.getDate()).padStart(2, '0');
      return `${year}-${month}-${day}`;
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
              Timeline & Halls
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
                      Timeline
                    </h3>
                  </div>
                </div>
                <div class="kt-section">
                  <div class="kt-section__body">
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Event Start:</label>
                      <div class="col-9">
                        <datepicker v-model="form.start_date" @update:modelValue="handleModelUpdate" :enableTimePicker="false" format="YYYY-MM-DD" :placeholder="form.start_date ? form.start_date : 'Start Date'"></datepicker>
                        <vue-timepicker v-model="form.start_time" @update:modelValue="handleModelUpdate" format="HH:mm" placeholder="Start Time"></vue-timepicker>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Event End:</label>
                      <div class="col-9">
                        <datepicker v-model="form.end_date" @update:modelValue="handleModelUpdate" :enableTimePicker="false" :format="'YYYY-MM-DD'" :placeholder="form.end_date ? form.end_date : 'End Date'"></datepicker>
                        <vue-timepicker v-model="form.end_time" @update:modelValue="handleModelUpdate" format="HH:mm" placeholder="End Time"></vue-timepicker>
                      </div>
                    </div>
                    <div class="kt-section kt-section-first">
                  <div class="kt-section__body">
                    <h3 class="kt-section__title kt-section__title-lg">
                      Halls & DJ's
                    </h3>
                  </div>
                </div>
                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                       <div class="form-group row halls-wrapper" v-for="(section, index) in sections" :key="index">
                      <label class="col-3 col-form-label">Hall {{ index + 1 }}</label>
                      <div class="col-6">
                        <div class="row halls-wrapper_inputs">
                          <input class="form-control" v-model="section.name" placeholder="Hall Name" />
                          <div v-for="(input, i) in section.inputs" :key="i">
                          <input v-model="input.value" :placeholder="'DJ ' + (i + 1)" />
                        </div>
                      </div>
                      </div>
                        <div class="col-3 halls-wrapper_buttons">
                          <button class="btn btn-brand" @click="addInputField(index)">Add DJ</button>
                          <button class="btn btn-brand" @click="removeSection(index)">Remove Hall</button>
                        </div>
                      </div>
                      <button class="btn btn-brand" @click="addSection(sections.length)">Add Hall</button>
                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
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

<style lang="scss">
.halls-wrapper {
  &_buttons {
    text-align: right;

    & > button {
      margin-bottom: 3px;
    }
  }

  &_inputs {
    & > input {
      margin-bottom: 8px;
    }

    & > div {
      & > input {
        margin-bottom: 5px;
        display: block;
        width: 67%;
        height: calc(1.5em + 1.3rem + -6px);
        padding: 0.65rem 1rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #e2e5ec;
        border-radius: 4px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
      }
    }
  }
}
</style>
