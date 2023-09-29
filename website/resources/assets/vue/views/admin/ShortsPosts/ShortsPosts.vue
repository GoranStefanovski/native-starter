<script setup lang="ts">
  import { computed, onMounted } from "vue";
  import { useStore } from '@/store';
  import { ColumnObject } from '@/components/Datatables/typings';
  // import LocationsDatatable from '../../../features/Admin/Locations/_components/LocationsDatatable.vue';
  import ShortsPostsDatatable from '../../../features/Admin/ShortsPosts/_components/ShortsPostsDatatable.vue'
  
  const store = useStore();
  const setBackUrl = (url) => store.dispatch('Root/setBackUrl', url);
  const setMenu = (url) => store.dispatch('Root/setMenu', url);
  const setActiveClasses = (obj) => store.dispatch('Root/setActiveClasses', obj);
  const homePath = computed(() => store.state.Root.homePath);

  onMounted(() => {
    setBackUrl('/posts_short');
    setActiveClasses({
      main: 'posts_short',
      sub: 'posts_short',
      title: 'posts_short.title',
      hasFilters: 'posts_short'
    })
  })

  const columns: ColumnObject[] = [
    { id: 0, width: '5%', label: 'ID', name: 'id', sortable: true },
    { id: 1, width: '15%', label: 'Title', name: 'title', sortable: true },
    { id: 2, width: '15%', label: 'Link', name: 'link', sortable: true },
    { id: 3, width: '5%', label: 'Active', name: 'active', sortable: true },
    { id: 4, width: '3%', label: 'strings.actions', name: 'actions', sortable: false },
    { id: 5, width: '3%', label: 'strings.delete', name: 'actions', sortable: false }
  ];
</script>

<template>
  <shorts-posts-datatable :columns="columns" />
</template>
