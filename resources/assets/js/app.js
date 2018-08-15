import './bootstrap';

import BootstrapVue from 'bootstrap-vue';

import VueRouter from 'vue-router';

import Template from './Template.vue';

import Default from './layouts/Default.vue';

import Error404 from './layouts/Error404.vue';

import router from './routes';

import store from './store';

window.Vue = require('vue');

Vue.use(BootstrapVue);

Vue.component('default-layout', Default);

Vue.component('error404-layout', Error404);

Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component('modal-logout', require('./components/ModalLogoutComponent.vue'));

Vue.component('nav-component', require('./components/NavComponent.vue'));

Vue.component('breadcrumb', require('./components/breadcrumb.vue'));

const app = new Vue({
    el: '.app',
    store,
    router,
    render: h => h(Template)
})
