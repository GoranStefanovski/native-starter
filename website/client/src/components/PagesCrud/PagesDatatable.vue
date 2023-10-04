<script setup>
  import { useDatatable, Datatable } from "@/components/Datatables";
  import { useRootStore } from '@/store/root';
  import { columns } from "./constants/table";
  import PagesDatatableRow from "./PagesDatatableRow.vue";

  const { homePath } = useRootStore();

  const {
    records, loading, pagination, tableInfo, query,
    getData, setQuery
  } = useDatatable({
    endpoint: 'page-builder',
    redirectRoute: homePath,
    columns,
    sortKey: 'first_name'
  });
</script>
<template>
  <Datatable
      :tableInfo="tableInfo"
      :query="query"
      :loading="loading"
      :columns="columns"
      lang-key="pagebuilder"
      addRouteName="create-page"
      :pagination="pagination"
      @onQueryUpdate="setQuery"
  >
    <PagesDatatableRow
        v-for="(page, index) in records"
        :index="index"
        :key="page?.id"
        :columns="columns"
        :page="page"
    />
  </Datatable>
</template>
