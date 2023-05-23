<script setup lang="ts">
  import { computed, ref, onMounted, provide } from "vue";
  import 'bootstrap';
  import 'reflect-metadata'
  import { useForm } from '@/composables/useForm';
  import { useStore } from '@/store';
  import { useRouter } from 'vue-router/composables';
  import { staticContent } from '@/utils/Objects';
  // import { IStaticContentForm } from "@/features/Admin/StaticContentTypes";
  import { FormInput, CustomForm } from "@/components/Form/index";
  import { Portlet } from '@/components';
  import { PortletBody, PortletHeadLabel, PortletHead, PortletHeadToolbar } from '@/components/Portlet/components';

  const router = useRouter();
  const store = useStore();

  const homePath = computed(() => store.state.Root.homePath);
  // const backUrl = computed(() => store.state.Root.backUrl);

  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);

  const form_name = 'static_content_data';
  const label_start = 'content.'+form_name;

  const fetchUri = '/shipping/get';
  const postUri = ref('');
  const { form, onSubmit, initFormFromItem, messageClass, message, clearErrors } = useForm(fetchUri, staticContent);
  const edit = ref(router.currentRoute.name == 'edit.static.content');
  const loading = ref(edit.value);
  const id = 25;

  provide('form', form);
  provide('label_start', label_start);

  onMounted(() => {
    if (edit.value) {
      initFormFromItem();
      postUri.value = `/page-builder/save-content/${id}`;
    } else {
      loading.value = false;
      postUri.value =  '/page-builder/save-content';
    }

    setActiveClasses({
      main: '/shipping',
      sub: router.currentRoute.name,
      title: 'users.title'
    });

    // Not 100% sure but probably this is used for the same purpose as redirect route and should be removed
    setBackUrl("/");
  });

  function getRedirectRoute() {
    return '/';
  }

  function beforeSubmit(stop_redirect = false) {
    onSubmit(postUri.value, getRedirectRoute(), stop_redirect);
  }
</script>

<template>
  <CustomForm
    class="container-fluid"
    :message-class="messageClass"
    :message="message"
    @beforeSubmit="beforeSubmit"
    @keyDownFunction="clearErrors"
  >
    <div class="row">
      <div class="col-12">
        <Portlet :is-loading="loading">
          <PortletHead>
            <PortletHeadLabel>
              {{ $t('pagebuilder.page.title') }}
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
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{$t('pagebuilder.page_path')}}</label>
                      <div class="col-9">
                        <FormInput v-model="form.page_path" />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{$t('pagebuilder.title')}}</label>
                      <div class="col-9">
                        <FormInput v-model="form.title" />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label">{{$t('pagebuilder.description')}}</label>
                      <div class="col-9">
                        <FormInput v-model="form.description" />
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
  </CustomForm>
</template>
