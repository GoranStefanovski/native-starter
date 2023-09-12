import { ref, computed, onMounted, watch } from 'vue';
import type { Ref } from 'vue'
import dialog from "@/utils/dialog";
import { post } from "@/services/HTTP";
import { useRouter } from 'vue-router/composables';
import { PaginationObject, TableInfo, TableQuery } from './typings';

const initTableData: TableInfo = {
  error: false,
  errorMessage: '',
  noRecords: false,
}

const initQueryData: TableQuery = {
  draw: 1,
  length: 10,
  search: '',
  dir: 'desc',
}

const initPagination: PaginationObject = {
  lastPage: 0,
  currentPage: 0,
  total: 0,
  dataLength: 10,
  options: {
    path: '',
    pageName: ''
  }
}

export function useDatatable({
  endpoint, columns, redirectRoute, sortKey = 'id'
}) {
  const records: Ref<Object[]> = ref([]);
  const loading: Ref<boolean> = ref(true);
  const tableInfo: Ref<TableInfo> = ref(initTableData);
  const pagination: Ref<PaginationObject> = ref(initPagination);
  const query: Ref<TableQuery> = ref({
    ...initQueryData,
    column: sortKey
  });

  const router = useRouter();

  const actualUser = computed(() => $auth.user());

  const setQuery = (queryObject: TableQuery) => {
    query.value = {
      ...query.value,
      ...queryObject
    }
  }

  const setTableInfo = (newData: TableInfo) => {
    tableInfo.value = {
      ...tableInfo.value,
      ...newData
    }
  }

  const setDatatableError = (message= '') => setTableInfo({
    error: true,
    errorMessage: message
  })

  const deleteRow = async (index: number): Promise<void> => {
    if (!await dialog('general.confirm.delete', true)) {
      return;
    }
    axios.get(endpoint.value + '/' + index + '/delete')
      .then(() => {
        dialog('strings.front.deleted_successfully', false);
        getData();
      })
      .catch((error) => {
        dialog(error.response.data.message, false);
      });
  }

  const getData = async (url?: string) => {
    loading.value = true;
    query.value.draw++; //TODO: Figure out what this does

    const getDataEndpoint = url ?? `${endpoint}/draw`;

    //TODO: Switch to get
    const { success, data, status, message } = await post(getDataEndpoint, query.value);

    if (success) {
      const {
        records: newRecords,
        pagination: newPagination,
        draw,
        errors
      } = data;
      loading.value = false;

      switch (status) {
        case 200: {
          if (errors) {
            setDatatableError();
            return;
          }
          if (query.value.draw == draw) {
            records.value = newRecords;
            pagination.value = newPagination;
            setTableInfo({
              noRecords: newRecords.length <= 0
            })
          }
          break;
        }
        case 401: {
          router.push(redirectRoute);
          return;
        }
        default: {
          setDatatableError();
          return;
        }
      }
    } else {
      setDatatableError(message);
    }

    loading.value = false;
  }

  // This is unused left just in case it is needed again
  // async changePage(page: number): Promise<void>  {
  //   let url = this.endpoint;
  //   url = url+'/draw';
  //   url = url+'?page='+ String(page);
  //   this.getData(url);
  // }

  watch(query, () => {
    getData();
  })

  onMounted(() => {
    getData();
  })

  return {
    records,
    query,
    loading,
    pagination,
    tableInfo,
    getData,
    setQuery
  };
}
