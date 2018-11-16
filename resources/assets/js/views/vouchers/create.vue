<template>
	<div v-if="Object.keys(item).length>0">
		<h4>Voucher{{item.id ? ' '+item.id : ''}}: {{item.name}}</h4>

		<hr>

		<b-form @submit="onSubmit" @reset="onReset" v-if="show">
			<!-- Nombre -->
			<b-form-group id="InputGroup1" label="Nombre:" label-for="name">
				<b-form-input id="name" type="text" v-model="item.name" required placeholder="Escribir nombre" />
			</b-form-group>

			<!-- Descripcion -->
			<b-form-group id="InputGroup2" label="Descripcion:" label-for="description">
				<b-form-input id="description" type="text" v-model="item.description" required placeholder="Escribir descripcion" />
			</b-form-group>

			<!-- Archivo -->
			<b-form-group v-if="item.id!=''" id="InputGroup3" label="Archivo:" label-for="file_name">
				<b-input-group>
					<b-form-file v-model="file_name" @change="onChange($event)" :disabled="disabled" :state="Boolean(item.file_name)" placeholder="Seleccionar archivo..." />

					<b-input-group-append v-if="item.file_name!=''">
						<b-btn variant="outline-danger" @click="delete_file" >Borrar</b-btn>

						<b-btn variant="outline-success" target="_blank" :href="'/vouchers/download/'+item.file_name">Descargar</b-btn>
					</b-input-group-append>

				</b-input-group>
				<div class="progress_" v-if="progress_status">
					<b-progress :max="max" animated>
						<b-progress-bar :label="label" :variant="variant" :value="counter" />
					</b-progress>
				</div>
			</b-form-group>

			<hr>

			<b-progress v-if="progress.status" :max="progress.max" animated>
				<b-progress-bar :label="progress.label" :variant="progress.variant" :value="progress.value" />
			</b-progress>

			<br v-if="progress.status">

			<b-button type="submit" variant="primary" :disabled="disabledCreate">Crear</b-button>
		</b-form>
	</div>
</template>

<script>
export default {
	created(){
		this.$store.dispatch('Breadcrumb/SET_ITEMS', [
		{
			text: 'Inicio',
			to: { name: 'home' }
		}, 
		{
			text: 'Vouchers',
			to: { name: 'vouchers' }
		}, 
		{
			text: 'Crear',
			active: true
		}
		]);
	},
	data(){
		return {
			show: true,
			disabledCreate: false,
			file_name: null,
			counter: 0,
			label: "0",
			max: 99,
			progress_status: false,
			variant: 'primary',
			progress: {
				status: false,
				value: 0,
				variant: "primary",
				max: 99,
				label: "0"
			},
			item:{
				id: "",
				name: "",
				description: "",
				file_name: ""
			},
			disabled: false
		}
	},
	methods: {
		onSubmit(evt){
			evt.preventDefault();

			this.progress.status = false;

			this.$nextTick(() => { this.resetSaveProgress(); this.progress.status = true });

			let items = JSON.parse(JSON.stringify(this.item));

			['file_name', 'users', 'id', 'created_at'].forEach(e => delete items[e]);

			const config = {
				onUploadProgress: (progressEvent) => {
					let percentCompleted = Math.round((progressEvent.loaded * 99) / progressEvent.total);

					this.progress.label = percentCompleted.toString();

					this.progress.value = percentCompleted;
				}
			};

			axios.post('/api/vouchers', JSON.parse(JSON.stringify(items)), config)
			.then((res)=>{
				setTimeout( () => {
					this.progress.variant = "success";

					this.progress.label = "Su registro fue creado con éxito";

					this.item.id = res.data.id; items.id = res.data.id;

					this.item.created_at = res.data.created_at; items.created_at = res.data.created_at;

					this.disabledCreate = true;

					this.$store.dispatch('Vouchers/ADD_ITEM', JSON.parse(JSON.stringify(items)));
				}, 1000);
			})
			.catch(()=>{
				setTimeout( () => {
					this.progress.variant = 'danger';

					this.progress.label = "El registro no pudo ser creado";
				}, 1000);
			});
		},
		resetSaveProgress(){
			this.progress.value = 0;

			this.progress.variant = 'primary';
		},
		onReset(evt){
			evt.preventDefault();

			for (var i = 0; i < Object.keys(this.item).length; i++) {
				this.item[Object.keys(this.item)[i]] = '';
			}

			this.show = false;

			this.$nextTick(() => { this.show = true });
		},
		resetProgress(){
			this.label = "0";

			this.counter = 0;

			this.variant = "primary";
		},
		onChange(e){
			this.resetProgress();

			this.progress_status = false; this.disabled = true;

			this.$nextTick(() => { this.progress_status = true });

			const config = {
				onUploadProgress: (progressEvent) => {
					let percentCompleted = Math.round((progressEvent.loaded * 99) / progressEvent.total);

					this.label = percentCompleted.toString();

					this.counter = percentCompleted;
				}
			};

			let data = new FormData();

			data.append('file_name', e.target.files[0]);

			data.append('_method', 'PUT');

			axios.post('/api/vouchers/'+this.item.id, data, config)
			.then(res => {
				this.variant = 'success';

				this.disabled = false;

				this.label = "Archivo subido"

				axios.get('/api/vouchers/'+this.item.id)
				.then(res => {
					this.item.file_name = res.data.file_name;

					this.$store.dispatch('Vouchers/UPDATE_ITEM', {id: this.item.id, file_name: this.item.file_name});
				});
			})
			.catch(err => {
				this.variant = 'danger';

				this.disabled = false;

				this.label = "Hubo un error al subir el archivo"
			});
		},
		delete_file(){
			let confirm_ = confirm("¿Eliminar?");

			if(confirm_){
				axios.post('/api/vouchers/'+this.item.id+'/delete')
				.then( () => {
					this.item.file_name = "";

					this.resetProgress();

					this.progress_status = false;

					this.$store.dispatch('Vouchers/ADD_ITEM', {id: this.item.id, file_name: ''});
				});
			}
		}
	}
}
</script>

<style>
	.custom-file-label::after {
	    content: "Subir";
	}
</style>