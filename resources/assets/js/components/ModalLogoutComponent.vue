<template>
	<b-modal ref="myModalRef" @ok="okButton" @hide="toggleModal" :visible="showModal" id="myModal" title="¿Listo para salir?" ok-title="Cerrar Sesión" cancel-title="Cancelar">
		Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.
	</b-modal>
</template>

<script>
export default{
 	computed: {
		showModal(){
			return this.$store.state.Modals.logout
  		}
  	},
  	methods:{
  		toggleModal(){
  			this.$store.dispatch('Modals/StateLogout');
  		},
      okButton(){
        delete axios.defaults.headers.common['Authorization'];

        localStorage.removeItem('user-token');

        this.$store.commit('Accounts/AUTHENTICATED_FALSE');

        this.$router.push({name: 'index'});
      }
  	}
}
</script>