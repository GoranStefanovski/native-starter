<script lang="ts">
  import { Component, Inject, Prop, Vue } from 'vue-property-decorator';
  import FormControl from "@/components/Form/FormControl.vue";
  import { namespace } from "vuex-class";
  import EventBus from "@/utils/event-bus";

  const { Action } = namespace('Root');

  @Component ({
    components: {
      FormControl
    }
  })
  export default class CustomForm extends Vue {
    @Action('setActiveClasses') setActiveClasses;
    @Prop() messageClass;
    @Prop() message;
    @Inject() labelStart;

    constructor() {
      super();
    }

    mounted() {
      //Taken from old forms Needs to be rethought
      EventBus.$on('stepSave', data => {
        // Triger current form save should be somewhere in here
        console.log("Event clicked on Progress  menu");
        console.log(data);
        this.$router.push({ name: data.route })
      });

      this.setActiveClasses({
        main: Vue.router.currentRoute.meta
          ? Vue.router.currentRoute.meta.main
          : '/',
        sub: Vue.router.currentRoute.name,
        title: this.label_start + '.title'
      });
    }
  }
</script>

<template>
  <form
    autocomplete="off"
    enctype="multipart/form-data"
    class="container-fluid"
    @submit.prevent="$emit('beforeSubmit')"
    @keydown="$emit('keyDownFunction',$event)"
  >
    <!-- TODO This probably is not in the correct place in the html  -->
    <div
      class="row"
      :class="messageClass"
    >
      {{ message }}
    </div>

    <slot />
  </form>
</template>
