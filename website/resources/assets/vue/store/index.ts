import Vue from 'vue';
import Vuex from 'vuex';

import Root from './Root';

Vue.use(Vuex);

const modules = {
  Root
};

const store = new Vuex.Store({
  modules
});

export default store;
export const useStore = () => store;
