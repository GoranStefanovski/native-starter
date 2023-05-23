<!--<script>-->
<!--  import {ref, computed} from 'vue';-->
<!--  export default {-->
<!--    name: "Example",-->
<!--    setup(){-->
<!--      const message = ref('Hello!');-->
<!--      function handleClick() {-->
<!--        console.log("Clicknavme");-->
<!--      }-->
<!--      return {message, handleClick}-->
<!--    }-->
<!--  }-->

<!--</script>-->

<!--<template>-->
<!--  <div>-->
<!--    <button @click="handleClick">Click here</button>-->
<!--  </div>-->
<!--</template>-->

<!--<script setup lang="ts">-->
<!--  console.log('hello script setup')-->
<!--  import { ref, computed } from 'vue';-->

<!--  const message = ref('Hello!');-->

<!--  function handleClick() {-->
<!--    console.log("Clicknavme");-->
<!--  }-->
<!--</script>-->
<script setup>
  // variable
  const msg = 'Hello!'

  // functions
  function log() {
    console.log(msg)
  }
</script>
<!--<script>-->
<!--  export default {-->cd
<!--    setup() {-->
<!--      return-->
<!--    }-->
<!--  }-->
<!--</script>-->
<template>
  <div>
    <button @click="log">
      Click here
    </button>
  </div>
</template>
