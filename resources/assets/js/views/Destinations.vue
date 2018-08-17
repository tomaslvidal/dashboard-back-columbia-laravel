<template>
	<table-component :items="items" :fields="fields"/>
</template>

<script>
export default {
	created(){
		this.$store.dispatch('Destinations/FETCH_ITEMS');
	},
	data(){
		return{
			fields: [
				{ key: 'id', label: 'ID', sortable: true},
				{ key: 'title', label: 'Titulo', 'class': 'text-center' },
				{ key: 'subtitle', label: 'Subtitulo' },
				{ key: 'description', label: 'Descripción' },
				{ key: 'created_at', sortable: true, label: 'Fecha de creación' },
				{ key: 'actions', label: '' }
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