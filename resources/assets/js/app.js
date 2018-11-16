import './bootstrap';

import BootstrapVue from 'bootstrap-vue';

import VueRouter from 'vue-router';

import Template from './Template.vue';

import router from './routes';

import store from './store';

window.Vue = require('vue');

Vue.use(BootstrapVue);

Vue.component('treeselect', require('@riophae/vue-treeselect').Treeselect);

Vue.component('default-layout', require('./layouts/Default.vue'));

Vue.component('error404-layout', require('./layouts/Error404.vue'));

Vue.component('entry-layout', require('./layouts/Entry.vue'));

Vue.component('table-component', require('./components/TableComponent.vue'));

Vue.component('table-component', require('./components/TableComponent.vue'));

Vue.component('alert-utilities', require('./components/utilities/AlertComponent.vue'));

Vue.component('modal-logout', require('./components/ModalLogoutComponent.vue'));

Vue.component('nav-component', require('./components/NavComponent.vue'));

Vue.component('breadcrumb', require('./components/breadcrumb.vue'));

const app = new Vue({
    el: '.app',
    store,
    router,
    render: h => h(Template)
});