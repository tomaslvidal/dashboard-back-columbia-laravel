<template>
	<table-component model="surveys" to="survey_edit" :items="items" :fields="fields" :hide_footer="hide_footer" />
</template>

<script>
export default {
	created(){
		if(this.$store.state.Surveys.request_made==false){
			this.$store.dispatch('Surveys/FETCH_ITEMS');
		}

		this.$store.dispatch('Breadcrumb/SET_ITEMS', [{
			text: 'Inicio',
			to: {name: 'home'}
		}, {
			text: 'Encuestas',
			to: {name: 'surveys'}
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
			return this.$store.state.Surveys.items;
		}
	}
}
</script>