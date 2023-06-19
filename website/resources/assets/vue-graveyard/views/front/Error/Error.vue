<script setup lang="ts">
  import { onMounted } from "vue";

  //TODO: Send parameters for the request here down to the grid component
  onMounted(() => {
    if(navigator.userAgent.includes('Prerender')){
      let element = document.head.querySelector('meta[name="prerender-status-code"]');
      if (element) {
        element.setAttribute('content', '404');
      }else{
        let element = document.createElement('meta');
        element.name ='prerender-status-code';
        element.content = '404';
        document.head.appendChild(element);
      }
    }
  })
</script>

<template>
  <div>
    <section class="errorpage">
      <div class="container">
        <div class="clearer" />
      </div>
    </section>
  </div>
</template>
