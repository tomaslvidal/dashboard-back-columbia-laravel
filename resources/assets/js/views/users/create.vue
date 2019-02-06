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
            <div id="InputGroup6" role="group" aria-labelledby="InputGroup6__BV_label_" class="b-form-group form-group">
                <div class="d-flex align-items-center mb-3 pt-1">
                    <label id="InputGroup6__BV_label_" for="add_vouchers" class="col-form-label py-0">Vouchers</label>

                    <button type="button" @click="showModal()" class="btn btn-sm btn-primary add_voucher" style="margin-left: 10px;">Agregar</button>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>

                            <th scope="col">Nombre</th>

                            <th scope="col">Descripción</th>

                            <!-- <th scope="col">Acción</th> -->
                        </tr>
                    </thead>

                    <tbody>
                        <item :updateProgress="updateProgress" :key="index" :index="index" :upload_status="uploads_vouchers" :item="item" v-for="(item, index) in item.vouchers" />
                    </tbody>
                </table>
            </div>

            <b-modal :hideFooter="true" title="Voucher" v-model="modal.voucher.state">
                <div v-if="modal.voucher.state">
                    <voucher-create :item="item.voucher_modal" :add_voucher="add_voucher"></voucher-create>
                </div>
            </b-modal>

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
    components: {
		'voucher-create': require('../vouchers/create.vue'),
		'item': require('../vouchers/item.vue'),
	},
	created(){
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
    watch: {
        'item.progress': function (){
            this.updateProgress();
        },
    },
	data(){
		return {
			show: true,
			disabledCreate: false,
            uploads_vouchers: false,
            vouchers_loaded: 0,
            modal:{
                voucher: {
                    state: false,
                    id: null
                }
            },
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
				telephone: "",
                progress: 0,
                voucher_modal: {
                    name: "",
                    description: "",
                    file_name: "",
                    file: ""
                },
                vouchers: []
			}
		}
	},
	methods: {
		resetSaveProgress(){
            this.uploads_vouchers = false;

            this.item.progress = 0;
            
			this.progress.value = 0;

			this.progress.variant = 'primary';
		},
        showModal(){
			this.modal.voucher.state = !this.modal.voucher.state;
		},
        updateProgress(){
            let sum = 0;

            for(let i = 0; this.item.vouchers.length>i; i++){
                sum += (1*this.item.vouchers[i].apart.progress)/100;
            }

            sum+= (1*this.item.progress)/100;

            this.progress.value = (sum/(this.item.vouchers.length+1))*100;

            this.progress.label = this.progress.value.toFixed().toString();

            if(this.item.vouchers.length>0){
                if(this.progress.value==100){
                    setTimeout(() => {
                        this.progress.variant = "success";

                        this.progress.label = "Su registro fue creado con éxito";
                    }, 3500);
                }
            }
        },
        reset_modal_voucher(){
            this.item.voucher_modal = {
                name: "",
                description: "",
                file_name: "",
                file: ""
            };
        },
        add_voucher(resetFile){
            resetFile();

			let data = new FormData();

            for(let i=0; Object.keys(this.item.voucher_modal).length>i; i++){
                if(Object.keys(this.item.voucher_modal)[i]!="id"){
                    if(this.item.voucher_modal[Object.keys(this.item.voucher_modal)[i]] instanceof FormData){
                        this.item.voucher_modal[Object.keys(this.item.voucher_modal)[i]].forEach((value,key) => {
                            data.append(key, value);
                        });
                    }
                    else{
                        if(Object.keys(this.item.voucher_modal)[i]!="file_name"){
                            data.append(Object.keys(this.item.voucher_modal)[i], this.item.voucher_modal[Object.keys(this.item.voucher_modal)[i]]);
                        }
                    }
                }
            }

            this.item.vouchers.push({data: data, apart: {loading: 1, progress: 0}});

            this.reset_modal_voucher();
        },
		onSubmit(e){
			e.preventDefault();

			this.progress.status = false;

			this.$nextTick( () => { this.resetSaveProgress(); this.progress.status = true });

            const config = {
                onUploadProgress: (progressEvent) => {
                    let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);

                    this.item.progress = percentCompleted;
                }
            };

            let item = JSON.parse(JSON.stringify(this.item));

			['id', 'created_at', 'vouchers', 'voucher_modal', 'progress'].forEach(e => delete item[e]);

			axios.post('/api/users', item, config)
			.then((res)=>{
                this.uploads_vouchers = true;

                if(this.item.vouchers.length==0){
                    this.progress.variant = "success";

                    this.progress.label = "Su registro fue creado con éxito";
                }
			})
			.catch(()=>{
                this.progress.value = 100;

                this.progress.variant = 'danger';

                this.progress.label = "El registro no pudo ser creado";
			});
		},
		onReset(e){
			e.preventDefault();

			for (var i = 0; i < Object.keys(this.item).length; i++) {
				this.item[Object.keys(this.item)[i]] = '';
			}

			this.show = false;

			this.$nextTick(() => { this.show = true });
		}
	}
}
</script>

<style scoped>
    .ball{
        height: 24px;
        width: 24px;
        background: #343a40;
        color: #fff;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .add_voucher{
        margin-left: 10px;
        border-color: #343a40;
        background-color: #343a40;
    }
</style>