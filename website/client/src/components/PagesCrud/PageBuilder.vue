<script setup>
  import { computed } from 'vue';
  import {
    PageBuilderComponent,
    PageBuilderAddComponent
  } from "@/components/PageBuilder";
  import './PageBuilder.scss';

  const props = defineProps({
    body: {
      required: true
    }
  })
  const blocks = computed(() => props.body.blocks);
</script>
<template>
  <div class="page-builder">
    <PageBuilderAddComponent />
    <div class="container" v-for="container in body.containers" :key="container.id">
      <div class="row">
        <div class="col-12">{{container.name}}</div>
        <PageBuilderComponent
          v-for="block in container.blocks"
          :block="blocks[block]"
        />
      </div>
    </div>
  </div>
</template>
