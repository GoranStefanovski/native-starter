<script setup lang="ts">
import { TableColumn, TableRow } from '@/components/Datatables'
const props = defineProps(['value', 'columns', 'post', 'index']);
const isEvenRow = props.index % 2 === 0;
const emit = defineEmits(['delete:modelValue']);

  const postDescription = (description) => {
    return description.slice(0,30).concat(" . . . ");
  }

  const emitValue = (post,post_id) => {
    emit('delete:modelValue', post,post_id);
  }
</script>

<template>
  <TableRow :section="'body'" :is-even="isEvenRow">
    <!--kt-datatable__row&#45;&#45;even-->

    <TableColumn :width="columns[0].width">
      {{ post.id }}
    </TableColumn>

    <TableColumn :width="columns[1].width">
      {{ post.title }}
    </TableColumn>

    <TableColumn :width="columns[2].width">
      {{ post.is_active == 1 ? "Active" : "Innactive" }}
    </TableColumn>

    <TableColumn :width="columns[3].width">
      {{ postDescription(post.description) }}
    </TableColumn>

    <TableColumn :width="columns[4].width">
      <!--      <template v-if="user.is_disabled">-->
      <!--        {{ $t('users.status.disabled') }}-->
      <!--      </template>-->
      <!--      <template v-else>-->
      <!--        {{ $t('users.status.enabled') }}-->
      <!--      </template>-->
      {{post.owner}}
    </TableColumn>

    <TableColumn :width="columns[5].width">
      <router-link
        v-if="$auth.user().permissions_array.includes('events_write')"
        :to="{ name: 'edit.event.info', params: { eventId: post.id}}"
        exact=""
      >
        <i
          aria-hidden="true"
          class="fa fa-pencil-square-o"
        /> 
        {{ $t('buttons.edit') }}
      </router-link>
    </TableColumn>

    <TableColumn :width="columns[6].width">
      <i
        v-if="$auth.user().permissions_array.includes('events_write')"
        variant="link"
        style="cursor: pointer;"
        aria-hidden="true"
        class="fa fa-trash-o"
        @click="emitValue(post,post.id)"
      />
    </TableColumn>
  </TableRow>
</template>
