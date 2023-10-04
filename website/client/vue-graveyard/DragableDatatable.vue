<script lang="ts">
  import { defineComponent } from 'vue';
  import ContentLoader from '@/components/ContentLoader/ContentLoader.vue';

  export default defineComponent({
    name: 'DragableDatatable',
    components: {
      ContentLoader
    },
    props: {
      columns: {
        type: Array,
        default: () => []
      },
      loading: Boolean
    },
    methods: {
      getColumnStyle(column) {
        let style = `width: ${column.width};`;
        if (column.name === 'delete') {
          style += ' cursor: pointer;';
        }
        return style;
      }
    }
  })
</script>

<template>
  <table class="table is-bordered data-table">
    <thead>
      <tr>
        <th
          v-for="column in columns"
          :key="column.label"
          :style="'width:'+column.width+';'"
        >
          {{ $t(column.label) }}
        </th>
      </tr>
    </thead>

    <slot />

    <tfoot>
      <tr>
        <td
          v-for="column in columns"
          :key="column.name"
          :style="getColumnStyle(column)"
        >
          <i
            v-if="column.name === 'delete'"
            role="link"
            class="fa fa-plus"
            @click="$emit('add-new')"
          />
        </td>
      </tr>
      <content-loader
        v-if="loading"
        :full-cont="true"
        :transparent="false"
      />
    </tfoot>
  </table>
</template>
