<script setup lang="ts">
import { ref, computed } from 'vue';
import type { Ref } from 'vue'
import dialog from '../../../../utils/dialog';
import UsersTableRow from '@/views/admin/Users/UsersTableRow.vue';
import { useDatatable, Datatable } from "@/components/Datatables";
import { useStore } from '@/store';

const props = defineProps(['columns']);
const endpoint: string = 'user';
const store = useStore();
const homePath = computed(() => store.state.Root.homePath);

const {
  records, loading, pagination, tableInfo, query,
  getData, setQuery
} = useDatatable({
  endpoint,
  redirectRoute: homePath,
  columns: props.columns,
  sortKey: 'id'
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

const deleteUser = async (user: User, index: number): Promise<void> => {
  if (!await dialog('general.confirm.delete', true)) {
    return;
  }
  axios.post(endpoint+'/'+index+'/delete')
    .then(response => {
      dialog('strings.front.deleted_successfully', false);
      getData();
    })
    .catch(error => {
      dialog(error.response.data.message, false);
    });
}

</script>
<template>
  <Datatable
    :tableInfo="tableInfo"
    :query="query"
    :loading="loading"
    :columns="columns"
    lang-key="users"
    add-route-name="add.user"
    :pagination="pagination"
    @onQueryUpdate="setQuery"
  >
    <!-- <users-table-row
      v-for="(user, index) in records"
      :index="index"
      :key="user.id"
      :columns="columns"
      :user="user"
    /> -->
  </Datatable>
</template>
