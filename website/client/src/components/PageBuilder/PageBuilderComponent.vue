<script setup>
  import { computed } from "vue";
  const props = defineProps(['block']);

  const is = computed(() => props.block.component)
</script>
<template>
  <component :is="is" :content="block.content" />
</template>
