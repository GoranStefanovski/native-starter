<script setup>
  import { onMounted } from "vue";
  import { useRootStore } from '@/store/root';
  import PagesDatatable from "@/components/PagesCrud/PagesDatatable.vue";

  const { setBackUrl, setActiveClasses } = useRootStore();

  onMounted(() => {
    setBackUrl('/');
    setActiveClasses({
      main: 'users',
      sub: 'users',
      title: 'users.title',
      hasFilters: 'users'
    })
  });
</script>
<template>
  <PagesDatatable />
</template>
