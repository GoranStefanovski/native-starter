<script>
  export default {
    props: {
      context: {
        type: Object,
        required: true
      }
    },
    data () {
      return {
        selectedIndex: 0
      }
    },
    computed: {
      model () {
        return this.context.model
      },
      selection () {
        if (this.filteredOptions[this.selectedIndex]) {
          return this.filteredOptions[this.selectedIndex]
        }
        return false
      },
      filteredOptions () {
        if (Array.isArray(this.context.options) && this.context.model) {
          const isAlreadySelected = this.context.options.find(option => option.label === this.context.model)
          if (!isAlreadySelected) {
            return this.context.options
              .filter(option => option.label.toLowerCase().includes(this.context.model.toLowerCase()))
          }
        }
        return []
      }
    },
    watch: {
      model () {
        this.selectedIndex = 0
      }
    },
    methods: {
      increment () {
        const length = this.filteredOptions.length
        if (this.selectedIndex + 1 < length) {
          this.selectedIndex++
        } else {
          this.selectedIndex = 0
        }
      },
      decrement () {
        const length = this.filteredOptions.length
        if (this.selectedIndex - 1 >= 0) {
          this.selectedIndex--
        } else {
          this.selectedIndex = length - 1
        }
      }
    }
  }
</script>
<template>
  <div
    :class="`formulate-input-element formulate-input-element--${context.type}`"
    :data-type="context.type"
  >
    <input
      v-model="context.model"
      type="text"
      v-bind="context.attributes"
      autocomplete="no"
      @keydown.enter.prevent="context.model = selection.label"
      @keydown.down.prevent="increment"
      @keydown.up.prevent="decrement"
      @blur="context.blurHandler"
    >
    <ul
      v-if="filteredOptions.length"
      class="formulate-input-dropdown"
    >
      <li
        v-for="(option, index) in filteredOptions"
        :key="option.value"
        :data-is-selected="selection && selection.value === option.value"
        @mouseenter="selectedIndex = index"
        @click="context.model = selection.label"
        v-text="option.label"
      />
    </ul>
  </div>
</template>
