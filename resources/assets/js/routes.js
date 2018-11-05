import Vue from "vue";

import Router from "vue-router";

import store from './store';

Vue.use(Router);

const Authenticated = (to, from, next) => {
  next();

  return;
}

export default new Router({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "home",
      component: {
        template: '<div></div>',
        created(){
          store.dispatch('Breadcrumb/SET_ITEMS', [{
            text: 'Inicio',
            to: {name: 'home'},
            active: true
          }]);
        }
      },
      beforeEnter: Authenticated
    },
    {
      path: "/home",
      name: "home_",
      component: {
        template: '<div></div>',
        created(){
          store.dispatch('Breadcrumb/SET_ITEMS', [{
            text: 'Inicio',
            to: {name: 'home'},
            active: true
          }]);
        }
      },
      beforeEnter: Authenticated
    },
    {
      path: "/vouchers",
      name: "vouchers",
      component: require('./views/Vouchers/index.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/vouchers/create',
      name: "voucher_create",
      component: require('./views/Vouchers/create.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/vouchers/:id',
      name: "voucher_edit",
      component: require('./views/Vouchers/edit.vue'),
      beforeEnter: Authenticated
    },
    {
      path: "/users",
      name: "users",
      component: require('./views/Users/index.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/users/create',
      name: "user_create",
      component: require('./views/Users/create.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/users/:id',
      name: "user_edit",
      component: require('./views/Users/edit.vue'),
      beforeEnter: Authenticated
    },
    {
      path: "/destinations",
      name: "destinations",
      component: require('./views/Destinations/index.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/destinations/create',
      name: "destination_create",
      component: require('./views/Destinations/create.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/destinations/:id',
      name: "destination_edit",
      component: require('./views/Destinations/edit.vue'),
      beforeEnter: Authenticated
    },
    {
      path: "*",
      name: "404",
      meta: { layout: "error404"},
      component: require('./views/NotFound.vue')
    }
  ]
});