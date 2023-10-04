<!--<script lang="ts">-->
<!--  import 'reflect-metadata'-->
<!--  import { BFormCheckbox } from 'bootstrap-vue'-->


<!--  @Component({-->
<!--    components:{-->
<!--      BFormCheckbox-->
<!--    }-->
<!--  })-->

<!--  export default class VueFormulateSwitch extends Vue{-->
<!--    @Prop({-->
<!--      type: Object,-->
<!--      required: true-->
<!--    }) context;-->

<!--    checked: boolean;-->
<!--    constructor(){-->
<!--      super();-->
<!--      this.checked = this.context.model;-->
<!--    }-->

<!--    @Watch('checked')-->
<!--    updateModel(){-->
<!--      this.context.model = this.checked;-->
<!--    }-->

<!--    // get checked() {-->
<!--    //     return this.context.model;-->
<!--    // };-->
<!--    //-->
<!--    // set checked(value) {-->
<!--    //     console.log(typeof(value));-->
<!--    //     if(typeof(value) == 'boolean')-->
<!--    //         this.context.model = value;-->
<!--    // };-->
<!--  }-->
<!--</script>-->
<!--<template>-->
<!--  <div-->
<!--    :class="`formulate-input-element formulate-input-element&#45;&#45;${context.type}`"-->
<!--    :data-type="context.type"-->
<!--  >-->
<!--    <div>-->
<!--      <b-form-checkbox-->
<!--        v-model="checked"-->
<!--        v-bind="context.attributes"-->
<!--        name="check-button"-->
<!--        switch-->
<!--        @blur="context.blurHandler"-->
<!--      >-->
<!--        Switch Checkbox <b>(Checked: {{ checked }})</b>-->
<!--      </b-form-checkbox>-->
<!--    </div>-->
<!--  </div>-->
<!--</template>-->
