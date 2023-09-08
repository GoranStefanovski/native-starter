<script setup lang="ts">
  import { computed, onMounted } from "vue";
  import { useStore } from '@/store';
  import { ColumnObject } from '@/components/Datatables/typings';
  import PostsDatatable from '../../../features/Admin/PostsCrud/_components/PostsDatatable.vue';

  const store = useStore();
  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);
  const homePath = computed(() => store.state.Root.homePath);

  onMounted(() => {
    setBackUrl('/');
    setActiveClasses({
      main: 'locations',
      sub: 'locations',
      title: 'locations.title',
      hasFilters: 'locations'
    })
  })

  const columns: ColumnObject[] = [
    { id: 0, width: '8.7%', label: 'admin.datatable.location.title', name: 'title', sortable: true },
    { id: 1, width: '15%', label: 'admin.datatable.location.desc', name: 'description', sortable: true },
    { id: 2, width: '15%', label: 'admin.datatable.location.country', name: 'country', sortable: true },
    { id: 3, width: '15%', label: 'admin.datatable.location.city', name: 'city', sortable: true },
    { id: 4, width: '3%', label: 'admin.datatable.location.rating', name: 'rating', sortable: true },
    { id: 4, width: '3%', label: 'admin.datatable.location.creator', name: 'creator', sortable: true },
    { id: 5, width: '3%', label: 'strings.actions', name: 'actions', sortable: false },
    { id: 6, width: '3%', label: 'strings.delete', name: 'actions', sortable: false }
  ];
</script>

<template>
  <posts-datatable :columns="columns" />
</template>
