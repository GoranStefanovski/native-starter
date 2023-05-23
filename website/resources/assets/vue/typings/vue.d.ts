import { AxiosInstance } from 'axios';
import VueRouter from 'vue-router';

declare module "vue/types/vue" {
  interface Vue {
    $auth: any;
    router: VueRouter;
    axios: AxiosInstance;
  }

  interface VueConstructor<V extends Vue = Vue> {
    $auth: any;
    router: VueRouter;
    axios: AxiosInstance;
  }

  interface ComponentOptions<V extends Vue> {
    metaInfo?: any;
  }
}

// @ Component declaration does not have a metaInfo field defined.
// That is why we need the below extension, so that it can be compatible with vue-meta plugin
import Vue from "vue";

declare module "vue/types/options" {
  interface ComponentOptions<V extends Vue> {
    metaInfo?: any;
  }
}
