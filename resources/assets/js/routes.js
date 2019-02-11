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
      path: "/users",
      name: "users",
      props: {
        model: 'User'
      },
      component: require('./views/users/index.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/users/create',
      name: "user_create",
      props: {
        model: 'User'
      },
      component: require('./views/users/create.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/users/:id',
      name: "user_edit",
      props: {
        model: 'User'
      },
      component: require('./views/users/edit.vue'),
      beforeEnter: Authenticated
    },
    {
      path: "/destinations",
      name: "destinations",
      props: {
        model: 'Destination'
      },
      component: require('./views/destinations/index.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/destinations/create',
      name: "destination_create",
      props: {
        model: 'Destination'
      },
      component: require('./views/destinations/create.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/destinations/:id',
      name: "destination_edit",
      props: {
        model: 'Destination'
      },
      component: require('./views/destinations/edit.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/surveys',
      name: "surveys",
      props: {
        model: 'Survey'
      },
      component: require('./views/surveys/index.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/surveysmade',
      name: "surveys_made",
      props: {
        model: 'Survey'
      },
      component: require('./views/surveys/made/index.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/surveysmade/:id',
      name: "surveys_made_see",
      props: {
        model: 'Survey'
      },
      component: require('./views/surveys/made/see.vue'),
    },
    {
      path: '/surveys/create',
      name: "survey_create",
      props: {
        model: 'Survey'
      },
      component: require('./views/surveys/create.vue'),
      beforeEnter: Authenticated
    },
    {
      path: '/surveys/:id',
      name: "survey_edit",
      props: {
        model: 'Survey'
      },
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