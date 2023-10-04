<script setup lang="ts">
  const emit = defineEmits(['confirm-unsaved-changes', 'cancel-unsaved-changes']);
</script>

<template>
  <div class="sk-modal-overlay">
    <div class="sk-modal-overlay-inner">
      <div class="sk-modal-head">
        <h4>Unsaved changes!</h4>
        <span
          class="close-btn"
          @click="emit('cancel-unsaved-changes')"
        >
          <i class="fa fa-times" />
        </span>
      </div>

      <div class="sk-modal-body">
        <p>
          You have unsaved changes in this form!
          Are you sure you want to leave this page?
        </p>
      </div>

      <div class="sk-modal-foot">
        <button
          class="btn btn-success"
          @click.prevent="emit('confirm-unsaved-changes')"
        >
          <i class="fa fa-check mr-2" />
          Yes
        </button>
        <button
          class="btn btn-danger ml-3"
          @click.prevent="emit('cancel-unsaved-changes')"
        >
          <i class="fa fa-times mr-2" />
          No
        </button>
      </div>
    </div>
  </div>
</template>
