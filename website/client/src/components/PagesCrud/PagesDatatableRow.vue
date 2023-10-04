<script setup lang="ts">
  import { TableColumn, TableRow } from '@/components/Datatables'
  const props = defineProps(['value', 'columns', 'page', 'index']);
  const isEvenRow = props.index % 2 === 0;
</script>

<template>
  <TableRow :section="'body'" :is-even="isEvenRow">

    <TableColumn :width="columns[0].width">
      {{ page.title }}
    </TableColumn>

    <TableColumn :width="columns[1].width">
      {{ page.slug }}
    </TableColumn>

    <TableColumn :width="columns[2].width">
      <router-link
          v-if="$auth.user().permissions_array.includes('create-users')"
          :to="{ name: 'page.crud', params: { id: page.id }}"
          exact=""
      >
        <i
            aria-hidden="true"
            class="fa fa-pencil-square-o"
        /> 
        {{ $t('buttons.edit') }}
      </router-link>
    </TableColumn>
  </TableRow>
</template>
