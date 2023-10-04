<script setup>
  import { computed } from 'vue';
  import * as containers from 'siteforge/containers';
  import { usePageBuilderStore } from "@/store/pageBuilder";

  const containersNames = computed(() => Object.keys(containers));
  const { blocks, addBlock } = usePageBuilderStore();
</script>
<template>
  <div>
    <button v-for="componentName in containersNames" @click="addBlock(componentName)">
      {{ componentName }}
    </button>
  </div>
</template>
