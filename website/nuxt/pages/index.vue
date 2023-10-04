<script setup>
  const Header = resolveComponent('Header')

  const dynamicContent = {
    body: [
      {
        _uid: "BUY6Drn9e1",
        component: "Header",
        children: "WTF!"
      }
    ]
  }
</script>
<template>
  <UContainer v-for="block in dynamicContent.body" :key="block._uid">
    <UCard>
      <component :is="block.component">
        <template v-if="block.children">{{ block.children }}</template>
      </component>
    </UCard>
  </UContainer>
</template>
