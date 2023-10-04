<script lang="ts">
  import { namespace } from 'vuex-class';
  import { Component, Emit, Prop, Vue } from 'vue-property-decorator';
  import ClickOutside from 'vue-click-outside';
  import { getScrollbarWidth , isBodyOverflowing } from "@/utils/modalHelpers";

  const RootStore = namespace('Root');

  @Component({
    directives: {
      ClickOutside
    }
  })
  export default class SkModal extends Vue {
    @RootStore.Action('setBodyClasses') setBodyClasses;

    @Prop({ type: String }) title;
    @Prop({ type: String, default: 'type' }) name; //Used to identify different types of modals on the site

    hasTitle: boolean = true;
    isBodyOverflowing: boolean = false;
    scrollBarWidth: number = 0;

    constructor() {
      super();

      if (typeof(this.title) === 'undefined' ) {
        this.hasTitle = false;
      }
    }

    //TODO: Open the modals on route

    @Emit('close-modal')
    closeModal() : void {};

    created() {
      this.isBodyOverflowing = isBodyOverflowing();
      this.scrollBarWidth = getScrollbarWidth();
      let bodyClass = {
        'isBodyOverflowing' : this.isBodyOverflowing,
        'scrollBarWidth' : this.scrollBarWidth,
        'modalOpen' : true
      };
      this.setBodyClasses(bodyClass);
    }

    destroyed() {
      let bodyClass = {
        'modalOpen' : false
      };
      this.setBodyClasses(bodyClass);
    }

  }
</script>

<template>
  <div
    class="sk-modal"
    :class="['sk-modal__'+name+'-type']"
  >
    <div class="sk-modal__inner">
      <!--v-click-outside="closeModal"-->

      <div
        class="sk-modal__head"
        :class="{'sk-modal__head--no-title' : !hasTitle}"
      >
        <h4 v-if="hasTitle">
          {{ $t(title) }}
        </h4>
        <span
          class="sk-modal__close"
          @click="closeModal"
        >
          close-icon
        </span>
      </div> <!-- sk-modal-head -->

      <div class="sk-modal__body">
        <slot name="body" />
      </div> <!-- sk-modal-body -->

      <div class="sk-modal__foot">
        <slot name="footer" />
      </div> <!-- sk-foot -->
    </div>
  </div> <!-- sk-modal-overlay -->
</template>
