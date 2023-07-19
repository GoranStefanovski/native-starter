<template>
  <div>
    <stripe-element-card
      ref="elementRef"
      :pk="publishableKey"
      @token="tokenCreated"
    />
    <button @click="submit">Generate token</button>
  </div>
</template>

<script lang="ts">
import { StripeElementCard } from '@vue-stripe/vue-stripe';
export default {
  components: {
    StripeElementCard,
  },
  data () {
    this.publishableKey ="pk_test_51KjLshCKJEL4uCt4pLkzi0GiXlRQE8raUG6GyPCu1JGesstjo5p45p3Gi7BTVUP8Ezjh5LuMcSy3W0LpojdlCPBX00GPLEf3ky";
    return {
      token: null,
    };
  },
  methods: {
    submit () {
      // this will trigger the process
      this.$refs.elementRef.submit();
    },
    tokenCreated (token) {
      console.log(token);
      // handle the token
      // send it to your server
    },
  }
};
</script>