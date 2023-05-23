<script setup lang="ts">
  import { ref, onMounted } from 'vue';
  import { useStore } from '@/store';

  const store = useStore();
  const categories = ref([]);
  const isLoading = ref(false);
  const fetchUri = '/common/dashboard/get';

  onMounted(() => {
    isLoading.value = true;
    store.dispatch('Root/setActiveClasses', {
      main: 'item_dashboard',
      sub: 'item_dashboard',
      title: 'strings.dashboard'
    })

    axios.get(fetchUri)
      .then((response) => {
        isLoading.value = false;
        categories.value = response.data;
      });
  })
</script>
<template>
  <div class="row">
    <div class="col-md-6" />
    <div class="col-md-6" />
  </div>
</template>

<style lang="scss">
.home {
  padding: 0;
  background-color: transparent;

  .admin-page-title {
    text-align: right;
    display: block;
    width: 100%;
    font-size: 13px;
  }
}
</style>
