<template>
  <b-navbar id="mainNav" toggleable="lg" type="dark" variant="dark" fixed="top">
    <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

    <router-link class="navbar-brand" :to="{ name: 'home' }">Columbia</router-link>

    <b-collapse :visible="visible" is-nav id="nav_collapse">
      <!-- Right aligned nav items -->
      <b-nav vertical class="navbar-nav navbar-sidenav">
        <b-nav-item v-b-toggle.collapse1 @click="hideNavCollapse" href="#">
          <i class="fa fa-window-maximize"></i>
          
          <b-nav-text>Usuarios</b-nav-text>

          <b-collapse id="collapse1" accordion="my-accordion" class="mt-2">
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'users' }">
              <b-nav-text>Listado</b-nav-text>
            </b-nav-item>
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'user_create' }">
              <b-nav-text>Agregar</b-nav-text>
            </b-nav-item>
          </b-collapse>
        </b-nav-item>

        <b-nav-item v-b-toggle.collapse2 @click="hideNavCollapse" href="#">
          <i class="fa fa-window-maximize"></i>
          
          <b-nav-text>Destinos</b-nav-text>

          <b-collapse id="collapse2" accordion="my-accordion" class="mt-2">
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'destinations' }">
              <b-nav-text>Listado</b-nav-text>
            </b-nav-item>
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'destination_create' }">
              <b-nav-text>Agregar</b-nav-text>
            </b-nav-item>
          </b-collapse>
        </b-nav-item>

        <b-nav-item v-b-toggle.collapse3 @click="hideNavCollapse" href="#">
          <i class="fa fa-window-maximize"></i>
          
          <b-nav-text>Vouchers</b-nav-text>

          <b-collapse id="collapse3" accordion="my-accordion" class="mt-2">
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'vouchers' }">
              <b-nav-text>Listado</b-nav-text>
            </b-nav-item>
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'voucher_create' }">
              <b-nav-text>Agregar</b-nav-text>
            </b-nav-item>
          </b-collapse>
        </b-nav-item>

        <b-nav-item v-b-toggle.collapse4 @click="hideNavCollapse" href="#">
          <i class="fa fa-window-maximize"></i>
          
          <b-nav-text>Encuestas</b-nav-text>

          <b-collapse id="collapse4" accordion="my-accordion" class="mt-2">
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'surveys' }">
              <b-nav-text>Listado</b-nav-text>
            </b-nav-item>
            <b-nav-item @click="hideNavCollapse" :to="{ name: 'survey_create' }">
              <b-nav-text>Agregar</b-nav-text>
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
  },
  data(){
    return{
      permission: false
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
    }
  },
  computed: {
    visible(){
      return this.$store.state.Modals.nav_collapse;
    }
  }
}
</script>