<template>
	<table-component model="vouchers" to="voucher_edit" :items="items" :fields="fields" />
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
				{ key: 'id', label: 'ID', sortable: true, tdClass: 'maxWidth' },
				{ key: 'name', label: 'Nombre', 'class': 'text-center', tdClass: 'maxWidth' },
				{ key: 'description', label: 'Descripción', tdClass: 'maxWidth' },
				{ key: 'created_at', sortable: true, label: 'Fecha de creación', tdClass: 'maxWidth' },
				{ key: 'actions', label: '', tdClass: 'maxWidth' }
			],
			hide_footer: false,
			visible: false,
			item: {},
			file_name: null,
		}
	},
	computed:{
		items(){
			return this.$store.state.Vouchers.items;
		}
	},
	methods : {
		okModal(e, item){
			this.$store.dispatch('Vouchers/UPDATE_ITEM', JSON.parse(JSON.stringify(item)));

			this.$store.dispatch('Modals/StateModalEditSave');
		}
	}
}
</script>

<style>
	.center-div{
		justify-content: center;
		align-items: center;
		display: flex;
		flex-direction: column;
		margin-top: 10px;
		margin-bottom: 10px;
	}

	.custom-file-label::after {
		content: "Subir";
	}
</style>