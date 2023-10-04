// import Vue from 'vue';
// import VueAxios from 'vue-axios';
import axios from 'axios'
import { useRouter } from 'vue-router';
import type { App } from 'vue'

// baseUrl is a global variable, we get it through Laravel
declare const baseUrl;

axios.defaults.baseURL = baseUrl;
axios.interceptors.response.use(function (response) {
  return response;
}, function (error) {
  if(error.response.data.error == "Unauthorized action"){
    const router = useRouter();
    router.push({
      name: 'user.dashboard',
    });
  }
  return Promise.reject(error);
});

export default (app: App) => {
  app.axios = axios;
  app.$http = axios;

  app.config.globalProperties.axios = axios;
  app.config.globalProperties.$http = axios;
}

// Vue.axios.interceptors.request.use(function(config) {
//   return config;
// }, function (error) {
//   // Do something with request error
//   return Promise.reject(error);
// });
