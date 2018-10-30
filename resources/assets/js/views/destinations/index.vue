<template>
	<table-component model="destinations" to="destination_edit" :items="items" :fields="fields"/>
</template>

<script>
export default {
	created(){
		if(this.$store.state.Destinations.request_made==false){
			this.$store.dispatch('Destinations/FETCH_ITEMS');
		}

		this.$store.dispatch('Breadcrumb/SET_ITEMS', [{
			text: 'Inicio',
			to: {name: 'home'}
		}, {
			text: 'Destinos',
			to: {name: 'destinations'}
		}, {
			text: 'Lista',
			active: true
		}]);
	},
	data(){
		return{
			fields: [
				{ key: 'id', label: 'ID', sortable: true, tdClass: 'maxWidth' },
				{ key: 'title', label: 'Titulo', tdClass: 'maxWidth' },
				{ key: 'subtitle', label: 'Subtitulo', tdClass: 'maxWidth' },
				{ key: 'created_at', sortable: true, label: 'Fecha de creación', tdClass: 'maxWidth' },
				{ key: 'actions', label: '', tdClass: 'maxWidth' }
			]
		}
	},
	computed:{
		items(){
			return this.$store.state.Destinations.items;
		}
	}
}
</script>