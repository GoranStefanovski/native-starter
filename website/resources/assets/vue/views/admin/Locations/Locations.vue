<script setup lang="ts">
  import { computed, onMounted } from "vue";
  import { useStore } from '@/store';
  import { ColumnObject } from '@/components/Datatables/typings';
  // import LocationsDatatable from '../../../features/Admin/Locations/_components/LocationsDatatable.vue';
  import LocationsDatatable from '../../../features/Admin/Locations/_components/LocationsDatatable.vue'

  const store = useStore();
  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);
  const homePath = computed(() => store.state.Root.homePath);

  onMounted(() => {
    setBackUrl('/locations');
    setActiveClasses({
      main: 'locations',
      sub: 'locations',
      title: 'locations.title',
      hasFilters: 'locations'
    })
  })

  const columns: ColumnObject[] = [
    { id: 0, width: '5%', label: 'ID', name: 'id', sortable: true },
    { id: 1, width: '10%', label: 'Title', name: 'title', sortable: true },
    { id: 2, width: '5%', label: 'Active', name: 'active', sortable: true },
    { id: 3, width: '10%', label: 'Country', name: 'country', sortable: true },
    { id: 4, width: '10%', label: 'City', name: 'city', sortable: true },
    { id: 5, width: '3%', label: 'Owner', name: 'creator', sortable: true },
    { id: 6, width: '3%', label: 'strings.actions', name: 'actions', sortable: false },
    { id: 7, width: '3%', label: 'strings.delete', name: 'actions', sortable: false }
  ];
</script>

<template>
  <locations-datatable :columns="columns" />
</template>
