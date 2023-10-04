import MenuLink from "@/components/Admin/Menu/MenuLink/MenuLink.vue";
import SubMenu from "@/components/Admin/Menu/SubMenu/SubMenu.vue";
import { PortletBody } from "@/components/Portlet";
// import VueFormulateAutocomplete from '@/components/VueFormulate/VueFormulateAutocomplete.vue';
// import VueFormulateSwitch from '@/components/VueFormulate/VueFormulateSwitch.vue';

export default (app) => {
  app.component('MenuLink', MenuLink);
  app.component('SubMenu', SubMenu);
  app.component('PortletBody', PortletBody);
  // Vue.component('VueFormulateAutocomplete', VueFormulateAutocomplete);
// Vue.component('VueFormulateSwitch', VueFormulateSwitch);
}
