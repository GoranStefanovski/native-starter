<script setup lang="ts">
  import { ref } from 'vue';
  import type { Ref } from 'vue'
  import { BDropdown, BDropdownItem, BDropdownText } from 'bootstrap-vue';
  import { PortletHead, PortletHeadLabel, PortletHeadToolbar } from "@/components/Portlet/components";

  const props = defineProps(['value', 'addRouteName', 'langKey', 'draggableAddNewEnable']);
  const exportGeneration: Ref<boolean> = ref(false);

  // const generateCsv = async () => {
  //   exportGeneration.value = true;
  //   axios.post(props.endpoint, props.value)
  //     .then((response) => {
  //       console.log(response);
  //       var hiddenElement = document.createElement('a'),
  //         blob = new Blob([response.data], { type: "octet/stream" }),
  //         url = window.URL.createObjectURL(blob);
  //       hiddenElement.href = url;
  //       var d = new Date();
  //       hiddenElement.download = this.export_file+'_export_'+d.getFullYear()+'_'+(d.getMonth() < 9 ? '0'+(d.getMonth()+1): +(d.getMonth()+1))+'_'+(d.getDate() < 10 ? '0'+d.getDate(): d.getDate())+'.csv';
  //       hiddenElement.click();
  //       window.URL.revokeObjectURL(url);
  //       this.exportGeneration = false;
  //     });
  // }
</script>

<template>
  <PortletHead :size="'lg'">
    <PortletHeadLabel :has-icon="true">
      Datatable header
      <small>This is a subtitle</small>
    </PortletHeadLabel>

    <PortletHeadToolbar>
        <!--TODO: Create custom component with basic function with the HTML above -->
        <b-dropdown
          id="dropdown-right"
          right
          variant="default"
          toggle-class="btn-icon-sm"
          menu-class="kt-nav"
          class="dropdown-inline"
        >
          <!--<i class="la la-download"></i>-->

          <template slot="button-content">
            <i class="la la-download" /> Export
          </template>

          <b-dropdown-text
            class="kt-nav__section kt-nav__section--first"
            tag="span"
          >
            Choose an option
          </b-dropdown-text>

          <!--<b-dropdown-item-button class="kt-nav__section kt-nav__section&#45;&#45;first" button-class="kt-nav__section-text">
            Choose an option
          </b-dropdown-item-button>-->

          <b-dropdown-item
            href="#"
            class="kt-nav__item"
            :link-class="'kt-nav__link'"
          >
            <i class="kt-nav__link-icon la la-print" />
            <span class="kt-nav__link-text">Print</span>
          </b-dropdown-item>

          <b-dropdown-item
            href="#"
            class="kt-nav__item"
            link-class="kt-nav__link"
          >
            <i class="kt-nav__link-icon la la-copy" />
            <span class="kt-nav__link-text">Copy</span>
          </b-dropdown-item>

          <b-dropdown-item
            href="#"
            class="kt-nav__item"
            link-class="kt-nav__link"
          >
            <i class="kt-nav__link-icon la la-file-excel-o" />
            <span class="kt-nav__link-text">Excel</span>
          </b-dropdown-item>
        </b-dropdown>
        <router-link
          v-if="$auth.user().permissions_array.includes('user_write') && props.addRouteName"
          :to="{ name: props.addRouteName }"
          exact=""
          class="btn btn-brand btn-elevate btn-icon-sm"
        >
          <i class="la la-plus" />
          {{ $t('admin.'+langKey+'.add') }}
        </router-link>
        <button
          v-if="draggableAddNewEnable"
          class="btn btn-brand btn-elevate btn-icon-sm"
          @click="$emit('add-new')"
        >
          <i class="la la-plus" />
          <!--{{ $t('admin.'+langKey+'.add') }}-->
          Add new
        </button>
    </PortletHeadToolbar>
  </PortletHead>
</template>
