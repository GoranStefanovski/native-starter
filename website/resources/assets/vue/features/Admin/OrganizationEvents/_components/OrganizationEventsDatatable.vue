<script setup lang="ts">
  import { ref, computed, onMounted } from 'vue';
  import type { Ref } from 'vue'
  import dialog from '../../../../utils/dialog';
  import { useDatatable, Datatable } from "@/components/Datatables";
  import { useStore } from '@/store';
  import OrganizationEventsTableRow from '../../../../views/admin/OrganizationEvents/OrganizationEventsTableRow.vue';
  
  const props = defineProps(['columns']);
  const endpoint: string = 'common/organization-events';
  const store = useStore();
  const homePath = computed(() => store.state.Root.homePath);

  const {
    records, loading, pagination, tableInfo, query,
    getData, setQuery
  } = useDatatable({
    endpoint,
    redirectRoute: homePath,
    columns: props.columns,
    sortKey: 'id',
  });

  const roles: Ref<any[]> = ref([]);
  const statuses: any[] = [
    { id: 3, name: 'All status' },
    { id: 0, name: 'Enabled' },
    { id: 1, name: 'Disabled' }
  ];
  const exportGeneration: boolean = false;

  const fetchRoles = () => {
    axios.get('user/roles/get')
      .then((response) => {
        roles.value = [
          ...response.data,
          { id: 0, display_name: '- All roles -' }
        ];
      }).catch(error => {
        console.log(error);
      });
  }

  const deletePost = async (post: OrganizationEventFormItem, id : number): Promise<void> => {
    console.log(post)
    // if (!await dialog('general.confirm.delete', true)) {
    //   return;
    // }
    axios.post(endpoint+'/'+id+'/delete')
      .then(response => {
        // dialog('strings.front.deleted_successfully', false); // TODO: dialog's Cancel and Ok functions are broken
        getData();
      })
      .catch(error => {
        dialog(error.response.data.message, false);
      });
  }

  onMounted(() => {
  })
</script>
<template>
  <Datatable
    :table-info="tableInfo"
    :query="query"
    :loading="loading"
    :columns="columns"
    lang-key="organization_events"
    add-route-name="add.organization_events"
    :pagination="pagination"
    @onQueryUpdate="setQuery"
  >
    <OrganizationEventsTableRow
      v-for="(event, index) in records"
      :key="event.id"
      :index="index"
      :columns="columns"
      :post="event"
      @delete:modelValue="deletePost"
    />
  </Datatable>
</template>
