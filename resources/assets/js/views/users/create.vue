<template>
	<div v-if="Object.keys(item).length>0">
		<h4>Usuario{{item.id ? ' '+item.id : ''}}: {{item.name+" "+item.last_name}}</h4>

		<hr>

		<b-form @submit="onSubmit" @reset="onReset" v-if="show">
			<!-- Nombre -->
			<b-form-group id="InputGroup1" label="Nombre:" label-for="name">
				<b-form-input id="name" type="text" v-model="item.name" required placeholder="Escribir nombre" />
			</b-form-group>

			<!-- Apellido -->
			<b-form-group id="InputGroup2" label="Apellido:" label-for="last_name">
				<b-form-input id="last_name" type="text" v-model="item.last_name" required placeholder="Escribir apellido" />
			</b-form-group>

			<!-- Email -->
			<b-form-group id="InputGroup3" label="Email:" label-for="email">
				<b-form-input id="email" type="email" v-model="item.email" required placeholder="Escribir email" />
			</b-form-group>

			<!-- Contraseña -->
			<b-form-group id="InputGroup4" label="Contraseña:" label-for="password">
				<b-form-input id="password" type="password" v-model="item.password" placeholder="Escribir contraseña" />
			</b-form-group>

			<!-- Telefono -->
			<b-form-group id="InputGroup5" label="Telefono:" label-for="telephone">
				<b-form-input id="telephone" type="tel" v-model="item.telephone" required placeholder="Escribir telefono" />
			</b-form-group>

			<!-- Agregar Vouchers -->
			<b-form-group id="InputGroup6" label="Vouchers:" label-for="add_vouchers">
				<treeselect
					:multiple="treeselect.multiple"
					:options="items"
					:value-consists-of="treeselect.valueConsistsOf"
					:alwaysOpen="treeselect.alwaysOpen"
					:clearOnSelect="treeselect.clearOnSelect"
					:closeOnSelect="treeselect.closeOnSelect"
					:appendToBody="treeselect.appendToBody"
					:openDirection="treeselect.openDirection"
					:noChildrenText="treeselect.noChildrenText"
					:noOptionsText="treeselect.noOptionsText"
					:noResultsText="treeselect.noResultsText"
					:placeholder="treeselect.placeholder"
					:retryText="treeselect.retryText"
					:retryTitle="treeselect.retryTitle"
					:searchPromptText="treeselect.searchPromptText"
					:loadingText="treeselect.loadingText"
					:clearValueText="treeselect.clearValueText"
					:clearAllText="treeselect.clearAllText"
					:matchKeys="treeselect.matchKeys"
					v-model="treeselect.value"
					:normalizer="treeselect.normalizer"
					:valueFormat="treeselect.valueFormat"
				/>
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
import '@riophae/vue-treeselect/dist/vue-treeselect.css';

export default {
	created(){
		if(this.$store.state.Vouchers.request_made==false){
			this.$store.dispatch('Vouchers/FETCH_ITEMS');
		}

		this.$store.dispatch('Breadcrumb/SET_ITEMS', [{
			text: 'Inicio',
			to: {name: 'home'}
		}, {
			text: 'Usuarios',
			to: {name: 'users'}
		}, {
			text: 'Crear',
			active: true
		}]);
	},
	computed:{
		items(){
			return [{
				id: 'vouchers',
				name: 'Vouchers',
				children: this.$store.state.Vouchers.items,
			}];
		}
	},
	data(){
		return {
			show: true,
			disabledCreate: false,
			progress: {
				status: false,
				value: 0,
				variant: "primary",
				max: 99,
				label: "0"
			},
			item: {
				id: "",
				name: "",
				last_name: "",
				email: "",
				password: "",
				telephone: ""
			},
			treeselect: {
				noChildrenText: "No hay sub-opciones.",
				noOptionsText: "No hay opciones disponibles.",
				noResultsText: "No se encontraron resultados...",
				placeholder:"Asignar Vouchers...",
				retryText:"¿Procesar de nuevo?",
				retryTitle:"Haga clic para volver a intentar",
				searchPromptText:"Escribe para buscar...",
				loadingText:"Cargando...",
				clearValueText:"Limpiar valor",
				clearAllText:"Limpiar todo",
				multiple: true,
				alwaysOpen: false,
				clearOnSelect: true,
				closeOnSelect: false,
				appendToBody: false,
				openDirection: 'top',
				matchKeys: ['name'],
				value: [],
				valueConsistsOf: 'LEAF_PRIORITY',
				valueFormat: 'object',
				normalizer(node) {
				  return {
				    label: node.name,
				  }
				},
			}
		}
	},
	methods: {
		resetSaveProgress(){
			this.progress.value = 0;

			this.progress.variant = 'primary';
		},
		onSubmit(evt){
			evt.preventDefault();

			this.progress.status = false;

			this.$nextTick( () => { this.resetSaveProgress(); this.progress.status = true });

			this.item.vouchers = this.treeselect.value;

			const config = {
				onUploadProgress: (progressEvent) => {
					let percentCompleted = Math.round((progressEvent.loaded * 99) / progressEvent.total);

					this.progress.label = percentCompleted.toString();

					this.progress.value = percentCompleted;
				}
			};

			['id', 'created_at'].forEach(e => delete this.item[e]);

			axios.post('/api/users', JSON.parse(JSON.stringify(this.item)), config)
			.then((res)=>{
				setTimeout( () => {
					this.progress.variant = "success";

					this.progress.label = "Su registro fue creado con éxito";

					this.item.id = res.data.id;

					this.item.created_at = res.data.created_at;

					this.disabledCreate = true;

					this.$store.dispatch('Users/ADD_ITEM', JSON.parse(JSON.stringify(this.item)));

					setTimeout( () => {
						this.$router.push({name: 'users'}); // this.$router.go(-1);
					}, 1500);
				}, 1000);
			})
			.catch(()=>{
				setTimeout( () => {
					this.progress.variant = 'danger';

					this.progress.label = "El registro no pudo ser creado"
				}, 1000);
			});
		},
		onReset(evt){
			evt.preventDefault();

			for (var i = 0; i < Object.keys(this.item).length; i++) {
				this.item[Object.keys(this.item)[i]] = '';
			}

			this.show = false;

			this.$nextTick(() => { this.show = true });
		}
	}
}
</script>