<script setup lang="ts">
  import { computed, onMounted } from "vue";
  import { useStore } from '@/store';
  import { ColumnObject } from '@/components/Datatables/typings';
  import OrganizationEventsDatatable from '../../../features/Admin/OrganizationEvents/_components/OrganizationEventsDatatable.vue';

  const store = useStore();
  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);
  const homePath = computed(() => store.state.Root.homePath);

  onMounted(() => {
    setBackUrl('/organization_events');
    setActiveClasses({
      main: 'organization_events',
      sub: 'organization_events',
      title: 'organization_events.title',
      hasFilters: 'organization_events'
    })
  })

  const columns: ColumnObject[] = [
    { id: 0, width: '10%', label: 'ID', name: 'id', sortable: true },
    { id: 1, width: '15%', label: 'Title', name: 'title', sortable: true },
    { id: 2, width: '10%', label: 'Active', name: 'is_active', sortable: true },
    { id: 3, width: '35%', label: 'Description', name: 'description', sortable: true },
    { id: 4, width: '5%', label: 'Owner', name: 'creator', sortable: true },
    { id: 5, width: '10%', label: 'strings.actions', name: 'actions', sortable: false },
    { id: 6, width: '10%', label: 'strings.delete', name: 'actions', sortable: false }
  ];
</script>

<template>
  <organization-events-datatable :columns="columns" />
</template>
