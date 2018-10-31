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
			<div v-if="item.id!=''" v-for="(item_for, key, index) in items">
				<b-form-group :id="'InputGroup'+index" :label="'Imagen '+(index+1)+':'" :label-for="key">
					<b-input-group>
						<b-form-file v-model="item[key]" @change="onChange($event, key)" :state="Boolean(item[key])" placeholder="Seleccionar archivo..." />

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

			<hr>

			<b-progress v-if="progress.status" :max="progress.max" animated>
				<b-progress-bar :label="progress.label" :variant="progress.variant" :value="progress.value" />
			</b-progress>

			<br v-if="progress.status">

			<b-button type="submit" variant="primary">Crear</b-button>
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
		this.$store.dispatch('Breadcrumb/SET_ITEMS', [{
			text: 'Inicio',
			to: {name: 'home'}
		}, {
			text: 'Destinos',
			to: {name: 'destinations'}
		}, {
			text: 'Crear',
			active: true
		}]);
	},
	data(){
		return {
			config: {
				removeButtons: 'Save,Preview,Templates,Cut,Copy,Language,Format,Paste,PasteText,PasteFromWord,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,Anchor,Blockquote,CreateDiv,HiddenField,BidiLtr,BidiRtl,Flash,Table,HorizontalRule,PageBreak,Styles,Font,About,ShowBlocks',
				removePlugins: 'image',
				extraPlugins: 'imgur, image2',
				imgurClientId: '023280cb8999d92',
				height: '420'
			},
			show: true,
			item: {
				id: "",
				title: "",
				subtitle: "",
				description: "",
				image1: "",
				image2: "",
				image3: "",
				image4: "",
				image5: ""
			},
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
					max: 99
				},
				image2: {
					progress_status: false,
					counter: 0,
					variant: "primary",
					label: "0",
					max: 99
				},
				image3: {
					progress_status: false,
					counter: 0,
					variant: "primary",
					label: "0",
					max: 99
				},
				image4: {
					progress_status: false,
					counter: 0,
					variant: "primary",
					label: "0",
					max: 99
				},
				image5: {
					progress_status: false,
					counter: 0,
					variant: "primary",
					label: "0",
					max: 99
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

			axios.post('/api/destinations', JSON.parse(JSON.stringify(items)), config)
			.then((res)=>{
				this.progress.variant = "success";

				this.progress.label = "Su registro fue creado con éxito";

				this.item.id = res.data.id; items.id = res.data.id;

				this.$store.dispatch('Destinations/ADD_ITEM', JSON.parse(JSON.stringify(items)));
			})
			.catch(()=>{
				this.progress.variant = 'danger';

				this.progress.label = "El registro no pudo ser creado"
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

			this.items[name].progress_status = false;

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

			axios.post('/api/destinations/'+this.item.id, data, config)
			.then(res => {
				this.items[name].variant = 'success';

				this.items[name].label = "Archivo subido"

				axios.get('/api/destinations/'+this.item.id)
				.then(res => {
					this.item[name] = res.data[0][name];

					this.$store.dispatch('Destinations/UPDATE_ITEM', {id: this.item.id, [name]: this.item[name]});
				});
			})
			.catch(err => {
				this.items[name].variant = 'danger';

				this.items[name].label = "Hubo un error al subir el archivo"
			});
		},
		delete_file(key){
			let confirm_ = confirm("¿Eliminar?");

			if(confirm_){
				axios.post('/api/destinations/'+this.item.id+'/delete', {"key" : key})
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