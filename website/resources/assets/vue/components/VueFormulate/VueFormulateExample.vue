<script setup lang="ts">
import { computed, ref } from "vue";
import 'reflect-metadata'
// import { useForm } from '@/composables/useForm';
import { useStore } from '@/store';

const store = useStore();

const homePath = computed(() => store.state.Root.homePath);

const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
const setMenu = (url) => store.dispatch('Root/setMenu', url);
const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);

const isLoading = ref(false);
const testValues = {
  first: 'first',
  second: 'second',
  third: 'third',
}

// import Form from '../../../../../node_modules/form-backend-validation';

//
// loading: boolean;
// item: Object;
// form: Form;
// test_value_1: String = "first";
// test_value_2: String = "first";
// test_value_3: String = "first";
//
// constructor() {
//   super();
//
//   this.item = {
//     "id": "id",
//     "image": ""
//   };
//
//   this.form = new Form(this.item);

</script>

<template>
  <form
    autocomplete="off"
    enctype="multipart/form-data"
    class="container-fluid"
  >
    <!--    @submit.prevent="onSubmit('', '', false)"-->
    <!--    @keydown="form.errors.clear($event.target.name)"-->
    <div class="row">
    <div class="col-md-9">
      <h4 slot="header">
        Create New CRUD
      </h4>

      <div class="form-row">
        <div class="col-md-12 col-sm-12">
          <FormulateInput
            type="color"
            name="sample"
            label="Sample color input"
            placeholder="Sample color placeholder"
            help="Sample color help text"
            validation="required"
            value="#3eaf7c"
            error-behavior="live"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 col-sm-12">
          <FormulateInput
            type="date"
            name="sample"
            label="Sample date input"
            placeholder="Sample date placeholder"
            help="Sample date help text"
            validation="required|after:2019-01-01"
            min="2018-12-01"
            max="2021-01-01"
            error-behavior="live"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 col-sm-12">
          <FormulateInput
            type="email"
            name="sample"
            label="Sample email input"
            placeholder="Sample email placeholder"
            help="Sample email help text"
            validation="required|email"
            error-behavior="live"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 col-sm-12">
          <FormulateInput
            type="hidden"
            name="sample"
            value="secret-code"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 col-sm-12">
          <FormulateInput
            type="number"
            name="sample"
            label="Sample number input"
            placeholder="Sample number placeholder"
            help="Sample number help text"
            validation="required|number|between:10,20"
            min="0"
            max="100"
            error-behavior="live"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 col-sm-12">
          <FormulateInput
            type="password"
            name="sample"
            label="Sample password input"
            placeholder="Sample password placeholder"
            help="Sample password help text"
            validation="required|min:10,length"
            validation-name="Password"
            error-behavior="live"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 col-sm-12">
          <FormulateInput
            type="url"
            name="sample"
            label="Sample url input"
            placeholder="Sample url placeholder"
            help="Sample url help text"
            validation="required"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 col-sm-12">
          <FormulateInput
            v-model="testValues.first"
            type="checkbox"
            label="This is a single checkbox"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 col-sm-12">
          <FormulateInput
            v-model="testValues.first"
            :options="{first: 'First', second: 'Second', third: 'Third', fourth: 'Fourth'}"
            type="checkbox"
            label="This is a label for all the options"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 col-sm-12">
          <FormulateInput
            v-model="testValues.first"
            :options="{first: 'First', second: 'Second', third: 'Third', fourth: 'Fourth'}"
            type="radio"
            label="This is a label for all the options"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 col-sm-12">
          <FormulateInput
            type="file"
            name="file"
            label="Select your documents to upload"
            help="Select one or more PDFs to upload"
            validation="mime:application/pdf"
            multiple
          />
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 col-sm-12">
<!--          <FormulateInput-->
<!--            v-model="form.image"-->
<!--            type="image"-->
<!--            name="headshot"-->
<!--            label="Select an image to upload"-->
<!--            help="Select a png, jpg or gif to upload."-->
<!--            validation="mime:image/jpeg,image/png,image/gif"-->
<!--            multiple-->
<!--          />-->
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 col-sm-12">
          <FormulateInput
            type="autocomplete"
            name="user"
            label="Search for a user"
            :options="[
                { value: 1, label: 'Jon Doe'},
                { value: 2, label: 'Jane Roe'},
                { value: 3, label: 'Bob Foe'},
                { value: 4, label: 'Ben Cho'},
              ]"
            validation="required|min:2,length"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 col-sm-12">
          <!--                <FormulateInput-->
          <!--                  v-model="switch_test"-->
          <!--                  type="switch"-->
          <!--                  name="switch-test"-->
          <!--                  label="switch me"-->
          <!--                />-->
        </div>
      </div>
<!--      <a @click.prevent="onSubmit('guest/common/vue/formulate/test', '', true)">Submit Form</a>-->
    </div>

    <div class="col-md-3">
      <button
        slot="footer"
        type="submit"
        :loading="isLoading"
        class="btn btn-success"
      >
        <i class="fa fa-save mr-1" />{{ $t('buttons.save') }}
      </button>

      <router-link
        slot="footer"
        :loading="isLoading"
        :to="`/admin/users/public`"
        exact=""
        class="btn btn-outline-secondary"
      >
        {{ $t('buttons.cancel') }}
      </router-link>
    </div>
  </div>
  </form>
</template>
