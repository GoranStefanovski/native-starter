<script setup lang="ts">
  import Vue from 'vue';
  // import { SkModal } from "@/components";

  const emit = defineEmits(['close-profile-modal']);

  const logout = () => {
    //TODO: Check what makeRequest does when this is turned ON
    Vue.auth.logout({
      makeRequest: true,
      redirect: { name: 'homepage' },
    }).then(() => {
      emit('close-profile-modal')
    }).catch(error => {
      console.log(error);
    });
  }
</script>
<template>
  <div
    :title="$auth.user().last_name"
    name="profile"
    @close-modal="emit('close-profile-modal')"
  >
    <div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-3">
            <img
              class="img-fluid rounded-circle"
              src="images/avatar.jpg"
              alt="Profile image"
            >
          </div> <!-- col-sm-3 -->
          <div class="col-sm-9">
            <table class="table table-sm">
              <tbody>
                <tr>
                  <th>Email:</th>
                  <td>{{ $auth.user().email }}</td>
                </tr>
                <tr>
                  <th>Email:</th>
                  <td>{{ $auth.user().first_name }}</td>
                </tr>
                <tr>
                  <th>Email:</th>
                  <td>{{ $auth.user().last_name }}</td>
                </tr>
              </tbody>
            </table>
          </div> <!-- col-sm-9 -->
        </div>
      </div>
    </div>

    <div>
      <router-link
        :to="{ path: '/user/dashboard/user-profile' }"
        class="btn btn-primary"
        @click.native="emit('close-profile-modal')"
      >
        <i class="fa fa-user mr-2" />
        {{ $t('general.my.profile') }}
      </router-link>
      <a
        class="btn"
        @click.prevent="logout"
      >
        {{ $t('general.logout') }}
        <i class="fa fa-sign-out ml-1" />
      </a>
    </div>
  </div>
</template>
