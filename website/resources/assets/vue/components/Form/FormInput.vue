<script setup lang="ts">
  import 'reflect-metadata';
  import { inject } from "vue";

  const emit = defineEmits(['update:modelValue']);
  const props = defineProps(['value', 'id', 'type', 'isInline', 'disabled', 'hasLabel']);
  const form = inject('form');
  const labelStart = inject('labelStart');

  const emitValue = (value) => {
    emit('update:modelValue', value);
  }
</script>

<template>
  <div
    class="d-flex"
    :class="{
      'd-inline-flex': isInline,
      'flex-column': !isInline
    }"
  >
    <label
      v-if="!!id"
      :for="id"
      class="text-2"
      :class="{
        'col-form-label': !isInline
      }"
    >
      {{ $t(labelStart + '.' + id) }}
    </label>
    <input
      :id="id"
      type="text"
      aria-describedby="PLACEHOLDER"
      :value="value"
      :name="id"
      :class="['form-control', {'error':form.errors.has(id)}]"
      :disabled="disabled"
      :type="type"
      @input="emitValue($event.target.value)"
    >
  </div>
</template>
