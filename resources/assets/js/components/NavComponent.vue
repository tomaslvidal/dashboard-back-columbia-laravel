<template>
  <b-navbar id="mainNav" toggleable="lg" type="dark" variant="dark" fixed="top">
    <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

    <router-link class="navbar-brand" :to="{ name: 'home' }">Columbia <i class="fas fa-globe"></i></router-link>

    <b-collapse :visible="visible" is-nav id="nav_collapse">
      <b-nav vertical class="navbar-nav navbar-sidenav">
        <b-nav-item :active="checkActive.User" v-b-toggle.collapse1 @click="hideNavCollapse" href="#">
          <i class="fas fa-users"></i>
          
          <b-nav-text>Usuarios</b-nav-text>

          <b-collapse id="collapse1" accordion="my-accordion" class="mt-2">
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'users' }">
              <i class="fas fa-list-ol"></i>

              <b-nav-text>Listado</b-nav-text>
            </b-nav-item>
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'user_create' }">
              <i class="fas fa-plus-circle"></i>

              <b-nav-text>Agregar</b-nav-text>
            </b-nav-item>
          </b-collapse>
        </b-nav-item>

        <b-nav-item :active="checkActive.Destination" v-b-toggle.collapse2 @click="hideNavCollapse" href="#">
          <i class="fas fa-map-marked"></i>
          
          <b-nav-text>Destinos</b-nav-text>

          <b-collapse id="collapse2" accordion="my-accordion" class="mt-2">
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'destinations' }">
              <i class="fas fa-list-ol"></i>

              <b-nav-text>Listado</b-nav-text>
            </b-nav-item>
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'destination_create' }">
              <i class="fas fa-plus-circle"></i>

              <b-nav-text>Agregar</b-nav-text>
            </b-nav-item>
          </b-collapse>
        </b-nav-item>

        <b-nav-item :active="checkActive.Survey" v-b-toggle.collapse4 @click="hideNavCollapse" href="#">
          <i class="fas fa-poll-h"></i>
          
          <b-nav-text>Encuestas</b-nav-text>

          <b-collapse id="collapse4" accordion="my-accordion" class="mt-2">
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'surveys' }">
              <i class="fas fa-list-ol"></i>

              <b-nav-text>Listado </b-nav-text>
            </b-nav-item>
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'survey_create' }">
              <i class="fas fa-plus-circle"></i>

              <b-nav-text>Agregar</b-nav-text>
            </b-nav-item>
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'surveys_made' }">
              <i class="fas fa-poll-h"></i>

              <b-nav-text>Encuestas realizadas </b-nav-text>
            </b-nav-item>
          </b-collapse>
        </b-nav-item>
      </b-nav>

      <b-navbar-nav class="ml-auto">
        <b-nav-item v-on:click="activeModal" href="#"><i class="fa fa-fw fa-sign-out"></i>Cerrar Sesión</b-nav-item>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>
export default {
  created(){
    this.watchWidth();

    window.addEventListener('resize', ()=>{
      this.watchWidth();
    });

    this.$root.$on('bv::toggle::collapse', () => {
      if(this.permission==true){
        this.$store.dispatch('Modals/StateNavCollapse');
      }
    });

    this.checkActive_();
  },
  data(){
    return{
      permission: false,
      checkActive: {

      }
    }
  },
  watch:{
    $route(){
      this.checkActive_();
    }
  },
  methods: {
    activeModal(){
      this.$store.dispatch('Modals/StateLogout');
    },
    hideNavCollapse(){
          if(this.permission==true){
        this.$store.dispatch('Modals/StateNavCollapse')
      }
    },
    watchWidth(){
      if(window.innerWidth<992){
        this.permission = true;
      }
      else{
        this.permission = false;
      }
    },
    checkActive_(){
      if(this.$router.currentRoute.matched[0].props.default){
        if(this.$router.currentRoute.matched[0].props.default.model){
          this.checkActive = {};

          this.$set(this.checkActive, this.$router.currentRoute.matched[0].props.default.model, true);

          return;
        }
      }

      this.checkActive = {};
    }
  },
  computed: {
    visible(){
      return this.$store.state.Modals.nav_collapse;
    }
  }
}
</script>