<script setup lang="ts">
  import Vue, { ref } from 'vue';
  import { BForm, BFormGroup, BFormInput, BFormCheckbox, BButton } from 'bootstrap-vue';
  // import { namespace } from 'vuex-class';
  import dialog from '../../utils/dialog';
  import formValidation from '../../utils/formValidation';

  // TODO: Fix store
  // @Action('Root/setData') setData;

  const form = ref({});
  const authError = ref(false);
  const isSending = ref(false);
  const staySignedIn = ref(false);

  const submitForm = (evt) => {
    if (!formValidation(evt)) return;

    isSending.value = true;
    Vue.auth.login({
      body: form.value,
      data: form.value,
      redirect: null,
      remember: false,
      staySignedIn: staySignedIn.value,
    }).then(response => {
      const { status, data } = response;
      // this.setUser(this.$auth.user());

      if (status === 401) {
        authError.value = true;
      }

      // this.setData();

      if (data.roles_array.includes(1) || data.roles_array.includes(2) || data.roles_array.includes(4)) {
        window.location.assign('/admin');
      }
      if (data.roles_array.includes(3)) {
        Vue.router.push({ name: 'user.dashboard' });
      }
    }).catch(() => {
      authError.value = true;
      dialog('errors.generic_error', false);
    });

    isSending.value = false;
  }

</script>

<template>
  <div>
    <h3 class="text-center">
      Log In
    </h3>
    <b-form
      id="login"
      @submit="submitForm"
    >
      <b-form-group
        :label="$t('strings.email')"
        label-for="email"
      >
        <b-form-input
          v-model="form.email"
          type="email"
          name="email"
          required="required"
          autofocus="autofocus"
        />
        <span
          v-if="authError"
          class="help-block"
        >
          <strong>
            {{ $t('auth.failed') }}
          </strong>
        </span>
      </b-form-group>
      <b-form-group
        :label="$t('strings.password')"
        label-for="password"
      >
        <b-form-input
          v-model="form.password"
          type="password"
          required="required"
        />
      </b-form-group>
      <b-form-group id="boxes">
        <div class="d-flex justify-content-between">
          <b-form-checkbox
            v-model="staySignedIn"
            switch
          >
            {{ $t('auth.keep_connected') }}
          </b-form-checkbox>
          <b-button
            variant="link"
            to="/password/reset"
            class="reset text-secondary pt-0 pr-0"
          >
            <i
              aria-hidden="true"
              class="fa fa-question-circle"
            />
            &nbsp;{{ $t('auth.login.forgot_your_password') }} ?
          </b-button>
        </div>
      </b-form-group>
      <b-form-group>
        <b-button
          type="submit"
          variant="primary"
          class="btn-block"
          :class="{ disabled: isSending }"
        >
          {{ $t('auth.login.title') }}
        </b-button>
      </b-form-group>
    </b-form>
  </div>
</template>
