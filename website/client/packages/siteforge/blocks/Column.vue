<script setup>
  const props = defineProps({
    content: {
      type: String,
    }
  })
</script>
<template>
  <div class="col-lg-4">
    {{ content }}
  </div>
</template>
