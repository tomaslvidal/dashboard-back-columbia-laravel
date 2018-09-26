import Vue from "vue";

import Router from "vue-router";

import Users from './views/Users.vue';

import Destinations from './views/Destinations.vue';

import Vouchers from './views/Vouchers.vue';

import Login from './views/Login.vue';

import NotFound from './views/NotFound.vue';

Vue.use(Router);

export default new Router({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "home",
      component: {
        template: '<div></div>'
      }
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
      path: "/login",
      name: "login",
      meta: { layout: "login"},
      component: Login
    },
    {
      path: "*",
      name: "404",
      meta: { layout: "error404"},
      component: NotFound
    }
  ]
});