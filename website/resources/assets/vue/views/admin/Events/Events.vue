<script setup lang="ts">
  import { computed, onMounted } from "vue";
  import { useStore } from '@/store';
  import { ColumnObject } from '@/components/Datatables/typings';
  import EventsDatatable from '../../../features/Admin/Events/_components/EventsDatatable.vue';

  const store = useStore();
  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);
  const homePath = computed(() => store.state.Root.homePath);

  onMounted(() => {
    setBackUrl('/');
    setActiveClasses({
      main: 'events',
      sub: 'events',
      title: 'events.title',
    hasFilters: 'events'
    })
  })

  const columns: ColumnObject[] = [
    { id: 0, width: '20%', label: 'admin.datatable.event.title', name: 'title', sortable: true },
    { id: 1, width: '20%', label: 'admin.datatable.event.desc', name: 'description', sortable: true },
    { id: 2, width: '20%', label: 'admin.datatable.event.creator', name: 'creator', sortable: true },
    { id: 3, width: '20%', label: 'strings.actions', name: 'actions', sortable: false },
    { id: 4, width: '20%', label: 'strings.delete', name: 'actions', sortable: false }
  ];
</script>

<template>
  <events-datatable :columns="columns" />
</template>
