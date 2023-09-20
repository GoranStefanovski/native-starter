<script lang="ts" setup>
  import 'bootstrap';
  import { useRouter } from 'vue-router/composables';
  import "./EventsForm.scss";
  const router = useRouter();

  const menuItems = [
    {id: 0, toName: 'edit.event.info', value: 'Info'},
    {id: 1, toName: 'edit.event.timeline', value: 'Timeline'},
    {id: 2, toName: 'edit.event.status', value: 'Status'},
  ]

</script>

<template>
    <div>
      <div class="row">
        <div class="col-12">
          <div class="container-fluid events-edit-header">
            <span v-for="(item,index) in menuItems" :key="index" :class="{'events-edit-header__menu-active':router.currentRoute.fullPath.includes( '/' + item.value.toLowerCase())}" >
              <router-link :to="{name: item.toName}" :title="item.value">{{ item.value }}</router-link>
            </span>
          </div>
        </div>
      </div>

      <!-- Router View For Edit Event -->
      <router-view></router-view>

    </div>
</template>
