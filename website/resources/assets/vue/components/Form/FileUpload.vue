<script lang="ts">
  import 'reflect-metadata';

  export default {
    props: {
      value: {},
      id: {},
      label: {},
      form: {},
      isInline: {},
      edit: {
        type: Boolean
      },
      disabled: {},
      placeholderImage: {},
      componentType: {
        default: 'full'
      }
    },
    data() {
      const colOneClass = !this.isInline || typeof this.isInline === 'undefined'
        ? 'col-12'
        : 'col-lg-4 col-md-2';
      const colTwoClass = !this.isInline || typeof this.isInline === 'undefined'
        ? 'col-12'
        : 'col-lg-8 col-md-10';
      const formGroupClass = !this.isInline || typeof this.isInline === 'undefined'
        ? 'form-group form-file-upload'
        : 'form-group form-file-upload form-group-inline';
      const labelClass = !this.isInline || typeof this.isInline === 'undefined'
        ? 'text-2'
        : 'col-form-label text-2';

      return {
        colOneClass : colOneClass,
        colTwoClass : colTwoClass,
        formGroupClass : formGroupClass,
        labelClass : labelClass,
        inputClass: 'form-control',
        newUrl : null
      };
    },

    computed: {
      hasForm() {
        return typeof this.form !== 'undefined';
      },
      url() {
        if(this.edit && this.form.media[0] !== undefined){
          console.log('ASDASDASD')
          return this.form.media[0].original_url;
        }else{
          return null
        }
      }
    },
    methods: {
      updated() {
        if (this.hasForm && this.form.errors.has(this.id)) {
          this.inputClass = 'form-control error';
        } else {
          this.inputClass = 'form-control';
        }
      },
      onFileChange(file) {
      // const file = e.target.files[0];
      },
      emitValue() {
        const file = this.$refs.photo_file.files[0];
        this.newUrl = URL.createObjectURL(file);
        this.$emit('input', file);
      }
    }
  };
</script>
<template>
  <div :class="formGroupClass">
    <div class="form-row">
      <div
        v-if="label !== undefined"
        :class="colOneClass"
      >
        <label
          v-if="label"
          :for="id"
          :class="labelClass"
        >{{ $t(label) }}</label>
      </div>
      <div :class="colTwoClass">
        <input
          v-show="componentType === 'full' || componentType === 'button'"
          :id="id"
          ref="photo_file"
          type="file"
          :name="id"
          @change="emitValue()"
        >
        <div
          v-show="componentType === 'full' || componentType === 'image'"
          class="bg-image-holder"
          :class="{ 'image-only': componentType === 'image' }"
          @click="$refs.photo_file.click()"
        >
          <div
            v-show="componentType === 'image'"
            class="edit-overlay"
          >
            <i class="fa fa-upload" />
          </div>
          <template v-if="url !== null || newUrl !== null">
            <img
              v-if="url && !newUrl"
              :src="url"
              :alt="'photo_file'"
              class="img-fluid"
            >
            <img
              v-else-if="newUrl !== null"
              :src="newUrl"
              :alt="'photo_file'"
              class="img-fluid"
            >
            <img
              v-else
              :src="placeholderImage"
              :alt="'photo_file'"
              class="img-fluid"
            >
          </template>
          <template v-else>
            <div
              v-if="componentType === 'image'"
              style="height:100px;width:100px;background:lightblue;border:1px solid #1c2023"
            />
          </template>
        </div>
        <div
          v-if="hasForm && form.errors.has(id)"
          class="invalid-feedback"
        >
          <span
            v-for="error in form.errors.errors[id]"
            :key="error"
          >{{ $t(error) }}</span>
        </div>
      </div>
    </div>
  </div>
</template>
