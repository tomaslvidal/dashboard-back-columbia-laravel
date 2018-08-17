<template>
	<table-component :items="items" :fields="fields"/>
</template>

<script>
export default {
	created(){
		if(this.$store.state.Users.request_made==false){
			this.$store.dispatch('Users/FETCH_ITEMS');
		}
	},
	data(){
		return{
			fields: [
				{ key: 'id', label: 'ID', sortable: true},
				{ key: 'name', label: 'Nombre', 'class': 'text-center' },
				{ key: 'last_name', label: 'Apellido' },
				{ key: 'email', label: 'Email' },
				{ key: 'telephone', label: 'Telefono' },
				{ key: 'created_at', sortable: true, label: 'Fecha de creación' },
				{ key: 'updated_at', sortable: true, label: 'Fecha de actualización' },
				{ key: 'actions', label: '' }
			]
		}
	},
	computed:{
		items(){
			return this.$store.state.Users.items;
		}
	}
}
</script>