<template>
	<table-component :items="items" :fields="fields"/>
</template>

<script>
export default {
	created(){
		if(this.$store.state.Vouchers.request_made==false){
			this.$store.dispatch('Vouchers/FETCH_ITEMS');
		}

		this.$store.dispatch('Breadcrumb/SET_ITEMS', [{
			text: 'Inicio',
			href: '/home'
		}, {
			text: 'Vouchers',
			href: '#'
		}, {
			text: 'Lista',
			active: true
		}]);
	},
	data(){
		return{
			fields: [
				{ key: 'id', label: 'ID', sortable: true},
				{ key: 'name', label: 'Nombre', 'class': 'text-center' },
				{ key: 'description', label: 'Descripción' },
				{ key: 'created_at', sortable: true, label: 'Fecha de creación' },
				{ key: 'actions', label: '' }
			]
		}
	},
	computed:{
		items(){
			return this.$store.state.Vouchers.items;
		}
	}
}
</script>