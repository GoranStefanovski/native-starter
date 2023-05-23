<script setup lang="ts">
  // TODO: This will not work
  // import { DialogComponent } from 'vue-modal-dialogs';

  const props = defineProps(['isConfirm', 'message'])

  const cancel = () => {
    // this.$close(false);
  }

  const ok = () => {
    // this.$close(true);
  }

</script>

<template>
  <div class="message-wrapper">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          {{ $t(message) }}
        </div>
        <div class="modal-footer">
          <button
            variant="primary"
            @click="ok"
          >
            {{ $t('buttons.ok') }}
          </button>
          <button
            v-if="isConfirm"
            variant="secondary"
            @click="cancel"
          >
            {{ $t('buttons.cancel') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
  .message-wrapper {
    background-color: rgba(0, 0, 0, 0.5);
    height: 100%;
    left: 0;
    padding-top: 20px;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 2001;
  }
</style>
