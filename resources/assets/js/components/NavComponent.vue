<template>
  <b-navbar id="mainNav" toggleable="lg" type="dark" variant="dark" fixed="top">
    <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

    <b-navbar-brand href="#">Columbia</b-navbar-brand>

    <b-collapse is-nav id="nav_collapse">
      <!-- Right aligned nav items -->
      <b-nav vertical class="navbar-nav navbar-sidenav">
        <b-nav-item to="/users">
          <i class="fa fa-window-maximize"></i>
          
          <b-nav-text>Usuarios</b-nav-text>
        </b-nav-item>

        <b-nav-item to="/destinations">
          <i class="fa fa-window-maximize"></i>
          
          <b-nav-text>Destinos</b-nav-text>
        </b-nav-item>

        <b-nav-item to="/vouchers">
          <i class="fa fa-window-maximize"></i>
          
          <b-nav-text>Vouchers</b-nav-text>
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
  methods: {
    activeModal(){
      this.$store.dispatch('Modals/StateLogout');
    }
  }
}
</script>