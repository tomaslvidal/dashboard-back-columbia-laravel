<template>
	<div v-if="Object.keys(item).length>0">
		<h4>Destino{{item.id!='' ? ' '+item.id : ''}}: {{item.title}}</h4>

		<hr>

		<b-form @submit="onSubmit" @reset="onReset" v-if="show">
			<!-- Titulo -->
			<b-form-group id="InputGroup1" label="Titulo:" label-for="title">
				<b-form-input id="title" type="text" v-model="item.title" required placeholder="Escribir titulo" />
			</b-form-group>

			<!-- Subtitulo -->
			<b-form-group id="InputGroup2" label="Subtitulo:" label-for="subtitle">
				<b-form-input id="subtitle" type="text" v-model="item.subtitle" required placeholder="Escribir subtitulo" />
			</b-form-group>

			<!-- Descripcion -->
			<b-form-group id="InputGroup3" label="Descripcion:" label-for="description">
				<ckeditor v-model="item.description" :config="config"></ckeditor>
			</b-form-group>

			<!-- Imagenes -->
			<div v-for="(item_for, key, index) in items">
				<b-form-group :id="'InputGroup'+index" :label="'Imagen '+(index+1)+':'" :label-for="key">
					<b-input-group>
						<b-form-file :disabled="items[key].disabled" v-model="item[key]" @change="onChange($event, key)"  :state="Boolean(item[key])" placeholder="Seleccionar archivo..." />

						<b-input-group-append v-if="item[key]!=''">
							<b-btn variant="outline-danger" @click="delete_file(key)" >Borrar</b-btn>

							<b-btn variant="primary" @click="showModal(key)">Ver</b-btn>
						</b-input-group-append>
					</b-input-group>
					<div class="progress_" v-if="items[key].progress_status">
						<b-progress :max="items[key].max" animated>
							<b-progress-bar :label="items[key].label" :variant="items[key].variant" :value="items[key].counter" />
						</b-progress>
					</div>
				</b-form-group>
			</div>

			<!-- <b-button type="reset" variant="danger">Limpiar</b-button> -->

			<hr>

			<b-progress v-if="progress.status" :max="progress.max" animated>
				<b-progress-bar :label="progress.label" :variant="progress.variant" :value="progress.value" />
			</b-progress>

			<br v-if="progress.status">

			<b-button type="submit" variant="primary">Guardar</b-button>
		</b-form>

		<b-modal v-model="modal.show" :title="modal.title" :hide-footer="modal.hide_footer" :cancel-disabled="modal.cancel_disabled" :ok-disabled="modal.ok_disabled">
			<div class="d-flex flex-grow-1 justify-content-center align-items-center">
				<b-img rounded :src="this.modal.url_image" fluid />
			</div>
		</b-modal>
	</div>
</template>

<script>
import Ckeditor from 'vue-ckeditor2';

export default {
	components: { Ckeditor },
	created(){
		this.$store.dispatch('Destinations/GET_ITEM', { "id" : this.$route.params.id});

		this.$store.dispatch('Breadcrumb/SET_ITEMS', [{
			text: 'Inicio',
			to: {name: 'home'}
		}, {
			text: 'Destinos',
			to: {name: 'destinations'}
		}, {
			text: this.$route.params.id,
			active: true
		}]);
	},
	destroyed(){
		this.$store.dispatch('Destinations/CLEAR_ITEM');
	},
	computed: {
		item(){
			return this.$store.state.Destinations.item;
		}
	},
	data(){
		return {
			config: {
				removeButtons: 'Save,Preview,Templates,Cut,Copy,Language,Format,Paste,PasteText,PasteFromWord,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,Anchor,Blockquote,CreateDiv,HiddenField,BidiLtr,BidiRtl,Flash,Table,HorizontalRule,PageBreak,Styles,Font,About,ShowBlocks',
				height: '420'
			},
			show: true,
			progress: {
				status: false,
				value: 0,
				variant: "primary",
				max: 99,
				label: "0"
			},
			modal:{
				ok_disabled: true,
				cancel_disabled: true,
				hide_footer: true,
				show: false,
				url_image: "",
				title: "Imagen"
			},
			items: {
				image1: {
					progress_status: false,
					counter: 0,
					variant: "primary",
					label: "0",
					max: 99,
					disabled: false
				},
				image2: {
					progress_status: false,
					counter: 0,
					variant: "primary",
					label: "0",
					max: 99,
					disabled: false
				},
				image3: {
					progress_status: false,
					counter: 0,
					variant: "primary",
					label: "0",
					max: 99,
					disabled: false
				},
				image4: {
					progress_status: false,
					counter: 0,
					variant: "primary",
					label: "0",
					max: 99,
					disabled: false
				},
				image5: {
					progress_status: false,
					counter: 0,
					variant: "primary",
					label: "0",
					max: 99,
					disabled: false
				}
			}
		}
	},
	methods: {
		onSubmit(evt){
			evt.preventDefault();

			this.progress.status = false;

			this.$nextTick(() => { this.resetSaveProgress(); this.progress.status = true });

			let items = JSON.parse(JSON.stringify(this.item));

			['image1', 'image2', 'image3', 'image4', 'image5'].forEach(e => delete items[e]);

			const config = {
				onUploadProgress: (progressEvent) => {
					let percentCompleted = Math.round((progressEvent.loaded * 99) / progressEvent.total);

					this.progress.label = percentCompleted.toString();

					this.progress.value = percentCompleted;
				}
			};

			axios.put('/api/destinations/'+this.$route.params.id, items, config)
			.then(()=>{
				setTimeout( () => {
					this.progress.variant = "success";

					this.progress.label = "Su registro fue guardado con éxito";
					
					this.$store.dispatch('Destinations/UPDATE_ITEM', items);

					setTimeout( () => {
						this.$router.push({name: 'destinations'}); // this.$router.go(-1);
					}, 1500);
				}, 1000);
			})
			.catch(()=>{
				setTimeout( () => {
					this.progress.variant = 'danger';

					this.progress.label = "El registro no pudo ser guardado";
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
		resetProgress(name){
			this.items[name].label = "0";

			this.items[name].counter = 0;

			this.items[name].variant = "primary";
		},
		onChange(e, name){
			this.resetProgress(name);

			this.items[name].progress_status = false; this.items[name].disabled = true;

			this.$nextTick(() => { this.items[name].progress_status = true });

			const config = {
				onUploadProgress: (progressEvent) => {
					let percentCompleted = Math.round((progressEvent.loaded * 99) / progressEvent.total);

					this.items[name].label = percentCompleted.toString();

					this.items[name].counter = percentCompleted;
				}
			};

			let data = new FormData();

			data.append(name, e.target.files[0]);

			data.append('_method', 'PUT');

			axios.post('/api/destinations/'+this.$route.params.id, data, config)
			.then(res => {
				this.items[name].variant = 'success';

				this.items[name].label = "Archivo subido"

				this.items[name].disabled = false;

				axios.get('/api/destinations/'+this.$route.params.id)
				.then(res => {
					this.item[name] = res.data[0][name];

					this.$store.dispatch('Destinations/UPDATE_ITEM', {id: this.item.id, [name]: this.item[name]});
				});
			})
			.catch(err => {
				this.items[name].variant = 'danger';

				this.items[name].disabled = false;

				this.items[name].label = "Hubo un error al subir el archivo"
			});
		},
		delete_file(key){
			let confirm_ = confirm("¿Eliminar?");

			if(confirm_){
				axios.post('/api/destinations/'+this.$route.params.id+'/delete', {"key" : key})
				.then( () => {
					this.item[key] = "";

					this.resetProgress(key);

					this.items[key].progress_status = false;

					this.$store.dispatch('Destinations/UPDATE_ITEM', {id: this.item.id, [key]: ''});
				});
			}
		},
		showModal(key){
			this.modal.url_image = '/destinations/download/'+this.item[key];

			this.modal.show = !this.modal.show;
		}
	}
}
</script>

<style>
	.custom-file-label::after {
	    content: "Subir";
	}
</style>