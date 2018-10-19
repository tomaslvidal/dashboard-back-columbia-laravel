<template>
	<table-component model="users" to="user_edit" :items="items" :fields="fields" :hide_footer="hide_footer" />
</template>

<script>
export default {
	created(){
		if(this.$store.state.Users.request_made==false){
			this.$store.dispatch('Users/FETCH_ITEMS');
		}

		this.$store.dispatch('Breadcrumb/SET_ITEMS', [{
			text: 'Inicio',
			to: {name: 'home'}
		}, {
			text: 'Usuarios',
			to: {name: 'users'}
		}, {
			text: 'Lista',
			active: true
		}]);
	},
	data(){
		return{
			fields: [
				{ key: 'id', label: 'ID', sortable: true, tdClass: 'maxWidth' },
				{ key: 'name', label: 'Nombre', 'class': 'text-center', tdClass: 'maxWidth' },
				{ key: 'last_name', label: 'Apellido', tdClass: 'maxWidth' },
				{ key: 'email', label: 'Email', tdClass: 'maxWidth' },
				{ key: 'telephone', label: 'Telefono' , tdClass: 'maxWidth'},
				{ key: 'created_at', sortable: true, label: 'Fecha de creación', tdClass: 'maxWidth' },
				{ key: 'actions', label: '', tdClass: 'maxWidth' }
			],
			hide_footer: false,
			visible: false,
			item: {},
		}
	},
	computed:{
		items(){
			return this.$store.state.Users.items;
		}
	}
}
</script>