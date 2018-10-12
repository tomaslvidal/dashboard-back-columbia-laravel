<template>
	<table-component :items="items" :fields="fields">
		<div slot="html-modal" slot-scope="{ item, reset }">
			<b-modal id="modalInfo" :visible="visible" :hide-footer="hide_footer" :title="`Voucher: ${item.name}`" ok-title="Guardar" cancelVariant="danger" cancel-title="Reset" @ok="okModal($event, item)" @cancel="reset">
				<form ref="form" enctype="multipart/form-data">
					<div class="form-group">
						<label for="name">Nombre</label>

						<input type="text" v-model="item.name" class="form-control" id="name" placeholder="Escribir nombre" autocomplete="new-name">
					</div>

					<div class="form-group">
						<label for="description">Descripción</label>

						<b-form-textarea id="description" autocomplete="new-description" v-model="item.description" placeholder="Escribir Descripción" :rows="8" :max-rows="20"></b-form-textarea>
					</div>

					<div class="form-group">
						<label for="file_name">Archivo</label>

						<b-form-file @change="onChange($event, item.id)" v-model="file_name" :state="Boolean(file_name)" placeholder="Elegir archivo.."></b-form-file>
					</div>
				</form>
    		</b-modal>
		</div>
	</table-component>
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
		},
		onChange(e, id){
			const config = {
				onUploadProgress: (progressEvent) => {
						let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);

						console.log(percentCompleted);
				}
			}

			let data = new FormData();

			data.append('file_name', e.target.files[0]);

			data.append('_method', 'PUT');

			axios.post('api/vouchers/'+id, data, config)
			.then(res => {
				console.log(res)
			})
			.catch(err => {
				console.log(err)
			});
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