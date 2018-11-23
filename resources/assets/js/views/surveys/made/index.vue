<template>
	<table-component model="surveysmade" :to="to" :state_actions="state_actions" :items="items" :fields="fields" :hide_footer="hide_footer">
		<div slot="actions" slot-scope="props" class="d-flex flex-grow-1 justify-content-center align-items-center">
	        <b-button variant="primary" size="sm" class="mr-1" :to=" {name: to, params: {id: props.row.item.id.toString() }} ">
	          Ver
	        </b-button>

			<!-- <b-button variant="danger" @click="props.delete_item(props.row.item.id)" size="sm">
			  Borrar
			</b-button> -->
        </div>
	</table-component>
</template>

<script>
export default {
	created(){
		this.$store.dispatch('SurveysMade/FETCH_ITEMS');

		this.$store.dispatch('Breadcrumb/SET_ITEMS', [
		{
			text: 'Inicio',
			to: {name: 'home'}
		}, 
		{
			text: 'Encuestas Realizadas',
			to: {name: 'surveys_made'}
		}, 
		{
			text: 'Lista',
			active: true
		}
		]);
	},
	data(){
		return{
			fields: [
				{ key: 'id', label: 'ID', sortable: true, tdClass: 'maxWidth' },
				{ key: 'survey.id', label: 'ID Encuesta', sortable: true, tdClass: 'maxWidth' },
				{ key: 'survey.name', label: 'Nombre de encuesta', 'class': 'text-center', tdClass: 'maxWidth' },
				{ key: 'user.email', label: 'Usuario', sortable: true, 'class': 'text-center', tdClass: 'maxWidth' },
				{ key: 'created_at', sortable: true, label: 'Fecha de creación', tdClass: 'maxWidth' },
				{ key: 'actions', label: '', tdClass: 'maxWidth' }
			],
			hide_footer: false,
			visible: false,
			to: 'surveys_made_see',
			state_actions: true,
			item: {},
		}
	},
	computed:{
		items(){
			return this.$store.state.SurveysMade.items;
		}
	}
}
</script>