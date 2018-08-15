import Vue from "vue";

import Router from "vue-router";

import Users from './views/Users.vue';

import Destinations from './views/Destinations.vue';

import Vouchers from './views/Vouchers.vue';

import NotFound from './views/NotFound.vue';

Vue.use(Router);

export default new Router({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "home",
      component: Users // load sync home
    },
    {
      path: "/vouchers",
      name: "vouchers",
      component: Vouchers
    },
    {
      path: "/users",
      name: "users",
      component: Users
    },
    {
      path: "/destinations",
      name: "destinations",
      component: Destinations
    },
    {
      path: "*",
      name: "404",
      meta: { layout: "error404"},
      component: NotFound // load sync home
    }
  ]
});
