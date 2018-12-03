<template>
	<table-component model="surveys" :to="to" :state_actions="state_actions" :items="items" :fields="fields" :hide_footer="hide_footer">
		<div slot="actions" slot-scope="props" class="d-flex flex-grow-1 justify-content-center align-items-center">
	        <b-button variant="primary" size="sm" class="mr-1" :to=" {name: to, params: {id: props.row.item.id.toString() }} ">
	          Editar
	        </b-button>

			<b-button variant="danger" @click="props.delete_item(props.row.item.id)" size="sm">
			  Borrar
			</b-button>
        </div>
	</table-component>
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
				{ key: 'state', label: 'Estado', 'class': 'text-center', tdClass: 'maxWidth' },
				{ key: 'created_at', sortable: true, label: 'Fecha de creación', tdClass: 'maxWidth' },
				{ key: 'actions', label: '', tdClass: 'maxWidth' }
			],
			hide_footer: false,
			visible: false,
			state_actions: true,
			item: {},
			to: "survey_edit"
		}
	},
	computed:{
		items(){
			return this.$store.state.Surveys.items;
		}
	}
}
</script>