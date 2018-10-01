import Vue from "vue";

import Router from "vue-router";

import Index from './views/Index.vue';

import Users from './views/Users.vue';

import Destinations from './views/Destinations.vue';

import Vouchers from './views/Vouchers.vue';

import Login from './views/Login.vue';

import Register from './views/Register.vue';

import NotFound from './views/NotFound.vue';

import store from './store';

Vue.use(Router);

const Authenticated = (to, from, next) => {
  if(store.state.Accounts.isAuthenticated && localStorage.getItem('user-token')){
    store.commit('Accounts/AUTHENTICATED_TRUE');

    next();

    return;
  }
  else if(localStorage.getItem('user-token')){
    axios.defaults.headers.common['Authorization'] = 'Bearer '+localStorage.getItem('user-token');

    axios.get('/validate-token')
      .then(response => {
        response = response.data;

        store.commit('Accounts/AUTHENTICATED_TRUE');

        next();

        return;
      })
      .catch( () => {
        delete axios.defaults.headers.common['Authorization'];

        localStorage.removeItem('user-token');

        store.commit('Accounts/AUTHENTICATED_FALSE');

        next('/login');

        return;
      });
  }
  else{
    next('/login');

    return;    
  }
}

export default new Router({
  mode: "history",
  routes: [
    {
      path: '/',
      name: 'index',
      meta: { layout: "entry"},
      component: Login
    },
    {
      path: "/home",
      name: "home",
      component: {
        template: '<div></div>'
      },
      beforeEnter: Authenticated
    },
    {
      path: "/vouchers",
      name: "vouchers",
      component: Vouchers,
      beforeEnter: Authenticated
    },
    {
      path: "/users",
      name: "users",
      component: Users,
      beforeEnter: Authenticated
    },
    {
      path: "/destinations",
      name: "destinations",
      component: Destinations,
      beforeEnter: Authenticated
    },
    {
      path: "/login",
      name: "login",
      meta: { layout: "entry"},
      component: Login
    },
    {
      path: "/register",
      name: "register",
      meta: { layout: "entry"},
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