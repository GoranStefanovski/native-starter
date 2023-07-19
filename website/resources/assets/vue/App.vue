<script lang="ts">
  import Vue, { defineComponent } from 'vue';
  import { mapState, mapActions } from "vuex";
  import { onMounted } from 'vue';
  import { isTouchDevice } from "@/utils/userAgentCheck";
  import BaseAuth from './views/auth/BaseAuth.vue';

  export default defineComponent({
    name: 'App',
    components: {
      BaseAuth
    },
    computed: {
      ...mapState('Root', [
        'bodyClasses'
      ]),
      isAuthLoaded: () => Vue.auth.ready()
    },
    methods: {
      ...mapActions('Root', [
        'setData',
        'setFrontActiveClass'
      ]),
      routerChangeHandler(to) {
        setTimeout(() => {
          window.scrollTo({
            top: 0,
            left: 0
          });
        }, 500);

        this.setFrontActiveClass(to.name);
      },
      bodyStyles() {
        let bodyStyles = '';

        if (!this.touchDevice && this.bodyClasses.isBodyOverflowing) {
          if (this.bodyClasses.modalOpen || this.bodyClasses.navMenuOpen)  {
            bodyStyles = 'padding-right:'+this.bodyClasses.scrollBarWidth+'px;';
          }
        }

        return bodyStyles;
      },
      bodyClassesControll(classObj) {
        let body = document.getElementsByTagName('body')[0];
        let bodyClasses : string[] = [];

        body.className = "";

        this.touchDevice ? bodyClasses.push('touch-device') : bodyClasses.push('no-touch-device');
        if (classObj.modalOpen) { bodyClasses.push('modal-open') }
        if (classObj.navMenuOpen) { bodyClasses.push('nav-menu-open') }
        if (classObj.navSearchActive) { bodyClasses.push('nav-search-active') }

        body.classList.add(...bodyClasses);
      }
    },
    watch: {
      bodyClasses (value) {
        this.bodyClassesControll(value);
      }
    },
    mounted() {
      this.touchDevice = isTouchDevice();

      Vue.auth.load().then(async () => {
        if (Vue.auth.check()) {
          await this.setData();
        }
      })
    },
    created() {
      this.$router.afterEach(this.routerChangeHandler);
    },
    data() : {
      touchDevice: boolean,
      el: any
    } {
      return {
        touchDevice: false,
        el: 'body'
      }
    }
  })
</script>

<template>
  <router-view
    v-show="isAuthLoaded"
    :style="bodyStyles()"
    :class="['main-wrapper',{
      'main-wrapper--modal-open':bodyClasses.modalOpen,
      'main-wrapper--dimmed':bodyClasses.navMenuOpen,
      'main-wrapper--nav-search-active':bodyClasses.navSearchActive,
      'main-wrapper--touch-device':touchDevice,
      'main-wrapper--no-touch-device':!touchDevice}]"
  /> <!-- Main tag from subview is displayed instead of this-->
</template>
