<script setup lang="ts">
  import { onMounted, provide } from "vue";
  import { useRoute } from "vue-router";
  import { useForm } from '@/composables';
  import { Portlet, PortletHead, PortletBody, PortletHeadLabel, PortletHeadToolbar } from '@/components/Portlet';
  import { pageData } from "@/components/PagesCrud/constants/defaults";
  import PageBuilder from "@/components/PagesCrud/PageBuilder.vue";
  import { CustomForm, FormInput } from '@/components/Form';

  const route = useRoute();

  const id = Number(route.params.id);
  const {
    form,
    messageClass,
    message,
    loading,
    onSubmit,
    initFormFromItem,
    clearErrors
  } = useForm(`page-builder/draw/${id}`, pageData);

  const beforeSubmit = (hasToRedirect = true) => {
    onSubmit('/page/new', 'pages', hasToRedirect);
  }

  onMounted(() => {
    initFormFromItem();
  });

  provide('form', form.value);
</script>
<template>
  <div class="row">
    <div class="col-12">
      <Portlet :hasStickyHeader="true" :is-loading="loading">
        <PortletHead>
          <PortletHeadLabel>
            {{ form.title }}
          </PortletHeadLabel>
          <PortletHeadToolbar>
            <router-link
              :loading="loading"
              to="/admin/pages"
              class="btn btn-clean kt-margin-r-10"
            >
              <i class="la la-arrow-left"></i>
              <span class="kt-hidden-mobile">{{ $t('buttons.cancel') }}</span>
            </router-link>
            <div class="btn-group">
              <button
                type="submit"
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
          <CustomForm
            class="container-fluid"
            autocomplete="off"
            enctype="multipart/form-data"
            @beforeSubmit="beforeSubmit"
            @keydown="form.errors.clear($event.target.name)"
          >
          <div class="row">
            <div class="col-md-6">
              <FormInput v-model="form.title" />
            </div>
            <div class="col-md-6">
              <FormInput v-model="form.slug" />
            </div>
          </div>
          </CustomForm>
        </PortletBody>
      </Portlet>
      <PageBuilder :body="form.body" />
    </div>
  </div>
</template>
