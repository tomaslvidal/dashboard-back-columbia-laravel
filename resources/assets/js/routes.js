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
      component: require('./views/vouchers/index.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/vouchers/create',
      name: "voucher_create",
      component: require('./views/vouchers/create.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/vouchers/:id',
      name: "voucher_edit",
      component: require('./views/vouchers/edit.vue'),
      beforeEnter: Authenticated
    },
    {
      path: "/users",
      name: "users",
      component: require('./views/users/index.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/users/create',
      name: "user_create",
      component: require('./views/users/create.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/users/:id',
      name: "user_edit",
      component: require('./views/users/edit.vue'),
      beforeEnter: Authenticated
    },
    {
      path: "/destinations",
      name: "destinations",
      component: require('./views/destinations/index.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/destinations/create',
      name: "destination_create",
      component: require('./views/destinations/create.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/destinations/:id',
      name: "destination_edit",
      component: require('./views/destinations/edit.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/surveys',
      name: "surveys",
      component: require('./views/surveys/index.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/surveys/create',
      name: "survey_create",
      component: require('./views/surveys/create.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/surveys/:id',
      name: "survey_edit",
      component: require('./views/surveys/edit.vue'),
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