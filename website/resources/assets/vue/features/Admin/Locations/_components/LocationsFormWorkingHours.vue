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
  import { working_hours } from '@/utils/Objects';

  const router = useRouter();
  const store = useStore();

  const homePath = computed(() => store.state.Root.homePath);

  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);

  const item = ref(cloneDeep(working_hours));
  const id = Number(router.currentRoute.params.locationId);

  const getUri = `common/location/${id}/get-working-hours`
  const fetchUri = `auth/user`;
  const {
    form,
    messageClass,
    message,
    loading,
    onSubmit,
    initFormFromItem,
    clearErrors
  } = useForm(getUri, working_hours);

  const daysOfWeek = [{ name: 'Monday', value: 'monday'}, { name: 'Tuesday', value: "tuesday" }, { name: 'Wednesday', value: 'wednesday'}, {name:'Thursday', value: 'thursday'}, { name: 'Friday', value: 'friday'}, { name:'Saturday', value: 'saturday'}, { name: 'Sunday', value: 'sunday'}]
  
  provide('form', form.value);
  provide('labelStart', 'location');

  const postUri = computed(() => `common/location/${id}/save-working-hours`);

  const beforeSubmit = (hasToRedirect = true ) => {
    onSubmit(postUri.value, 'locations', hasToRedirect, form.value);
  }

  const handleModelUpdate = async (value, forcities) => {
    console.log("VALUE", value);
    console.log("input", forcities);
    await initFormFromItem();

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
              Working Hours
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
                <div class="kt-section">
                  <div class="kt-section__body">
                    <div class="form-group row working-hour-wrapper" v-for="day, index in daysOfWeek" :key="index">
                      <label class="col-3 col-form-label">{{day.name}}</label> 
                        <input type="checkbox" v-model="form[day.value + '_working']" @update:modelValue="handleModelUpdate" placeholder="Working"/>
                        <vue-timepicker v-model="form[day.value + '_start']" @update:modelValue="handleModelUpdate" format="HH:mm" placeholder="Opening Time" :class="{'disabled':!form[day.value + '_working']}"></vue-timepicker>
                        <vue-timepicker v-model="form[day.value + '_end']" @update:modelValue="handleModelUpdate" format="HH:mm" placeholder="Closing Time" :class="{'disabled':!form[day.value + '_working']}"></vue-timepicker>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">Open 24/7</label>
                      <div class="col-9">
                        <input
                          id="always_open"
                          type="checkbox"
                          class="form-control"
                          placeholder="Open 24/7"
                          v-model="form.always_open"
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

<style lang="scss">
.disabled {
  pointer-events: none;
}

.working-hour-wrapper {
  align-items: center;
  & > * {
    &:not(:first-child) {
      margin-right: 15px;
      
      &:hover {
        cursor: pointer;
      }
    }
  }
}
</style>
