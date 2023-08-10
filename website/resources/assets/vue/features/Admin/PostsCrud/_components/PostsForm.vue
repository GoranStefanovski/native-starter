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
  import { post } from '@/utils/Objects';

  const router = useRouter();
  const store = useStore();

  const homePath = computed(() => store.state.Root.homePath);

  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);

  const item = ref(cloneDeep(post));
  const edit = router.currentRoute.name == 'edit.post';
  const id = Number(router.currentRoute.params.postId);
  const getPostUri = `guest/common/${id}/getPost`
  const fetchUri = `auth/user`;
  const countries = ref([]);
  const cities = ref([]);
  const {
    form,
    messageClass,
    message,
    loading,
    onSubmit,
    initFormFromItem,
    clearErrors
  } = useForm(getPostUri, post);

  provide('form', form.value);
  provide('labelStart', 'post');

  const postUri = computed(() => edit ? `common/post/${id}/edit` : '/common/save-post');
  const countriesUri = 'guest/common/getCountries';
  const redirectRoute = computed(() => [1,2].includes(form.roles) ? 'posts.category_one' : 'posts.category_one');

  const fetchCountries = async () => {
    try {
      const response = await axios.get(countriesUri);
      for (let key in response.data) {
        if (response.data.hasOwnProperty(key)) {
          countries.value.push({ id: key, name: `${response.data[key]['name']}` });
        }
      }
    } catch (error) {
      console.error(error);
    }
  }

  const fetchCities = async (country) => {
    cities.value = [];
    try {
      const response = await axios.post('https://countriesnow.space/api/v0.1/countries/cities',{
        "country" : country
      },{ withCredentials: false });
      for (let value in response.data.data) {
        cities.value.push({ id:value, name: response.data.data[value] });
      }
    } catch (error) {
      console.error(error);
    }
  }

  const postImg = (() => {
    console.log(form.value.media[0]);
    const { media } = form.value.media[0];
    if (media != undefined) {
      const postImage = media.find(o => o.collection_name === 'post_image');
      if (!!postImage) {
        return getPhotoPath(postImage, 400);
      }
    }
    return '';
  })

  const beforeSubmit = (hasToRedirect = true) => {
    console.log(form.value);
    form.value.city = cities.value.find(city => city.id == form.value.city_id);
    console.log(form.value);
    onSubmit(postUri.value, 'posts.category_one', hasToRedirect);
  }

  const handleModelUpdate = (value, forcities) => {
    console.log("VALUE", value);
    console.log("input", forcities);
    if(forcities){
      let country = countries.value.find(o=> o.id == value);
      fetchCities(country.name)
    }
    // form[input]=value;

  }
  //
  // const handleModelUp = (value, input, test) => {
  //   console.log(test);
  //   let country = countries.value.find(o=> o.id == value);
  //   console.log("COUNTRY", country);
  //   form[input]= country.id;
  //   fetchCities(country.name);
  // }

  onMounted(async () => {

    await fetchCountries();
    await initFormFromItem();
    if(edit){
      let country = form.value.country.name
      console.log(form.value);
      console.log(country);
      fetchCities(form.value.country.name);
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
                :to="{name:'posts.category_one'}"
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
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{ $t('posts.location.country') }}</label>
                      <div class="col-9">
                        <FormDropdown
                          id="country_id"
                          v-model="form.country_id"
                          :options="countries"
                          :getcities="true"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{ $t('posts.location.city') }}</label>
                      <div class="col-9">
                        <FormDropdown
                          id="city_id"
                          v-model="form.city_id"
                          :options="cities"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                    <!--                    <div class="form-group row">-->
                    <!--                      <label class="col-3 col-form-label">{{ $t('users.status') }}</label>-->
                    <!--                      <div class="col-9">-->
                    <!--                        <FormInputRadio-->
                    <!--                          :id="'enabled'"-->
                    <!--                          v-model="form.is_disabled"-->
                    <!--                          :options="[{'id': 0, 'name':'Enabled'},{'id': 1, 'name':'Disabled'}]"-->
                    <!--                        />-->
                    <!--                      </div>-->
                    <!--                    </div>-->
                  </div>
                </div>
                <!--                <div class="kt-separator kt-separator&#45;&#45;border-dashed kt-separator&#45;&#45;space-lg" />-->
                <div class="kt-section">
                  <div class="kt-section__body">
                    <h3 class="kt-section__title kt-section__title-lg">
                      Post information:
                    </h3>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{ $t('posts.image') }}</label>
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
                      <label class="col-3 col-form-label">{{ $t('posts.title') }}</label>
                      <div class="col-9">
                        <FormInput
                          id="title"
                          v-model="form.title"
                          @update:modelValue="handleModelUpdate"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{ $t('posts.description') }}</label>
                      <div class="col-9">
                        <FormInput
                          id="description"
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
