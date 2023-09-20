<script lang="ts" setup>
  import 'bootstrap';
  import { useRouter } from 'vue-router/composables';
  import "./LocationsForm.scss";
  const router = useRouter();
  const menuItems = [
    {id: 0, toName: 'edit.location.info', value: 'Info'},
    {id: 1, toName: 'edit.location.contact', value: 'Contact'},
    {id: 2, toName: 'edit.location.working_hours', value: 'Working Hours'},
    {id: 3, toName: 'edit.location.status', value: 'Status'},
  ]

</script>

<template>
    <div>
      <div class="row">
        <div class="col-12">
          <div class="container-fluid events-edit-header">
            <span v-for="(item,index) in menuItems" :key="index" :class="{'events-edit-header__menu-active':router.currentRoute.fullPath.includes( '/' + item.value.toLowerCase().split(' ')[0])}" >
              <router-link :to="{name: item.toName}" :title="item.value">{{ item.value }}</router-link>
            </span>
          </div>
        </div>
      </div>

      <!-- Router View For Edit Event -->
      <router-view></router-view>

    </div>
</template>
