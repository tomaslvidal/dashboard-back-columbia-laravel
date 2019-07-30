<template>
	<div v-if="Object.keys(item).length>0">
		<h4>Usuario{{item.id ? ' '+item.id : ''}}: {{item.name+" "+item.last_name}}</h4>

		<hr>

		<b-form @submit="onSubmit">
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

                    <button type="button" @click="() => { this.state.modal.voucher = !this.state.modal.voucher }" class="btn btn-sm btn-primary add_voucher" style="margin-left: 10px;">Agregar</button>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>

                            <th scope="col">Carga</th>

                            <th scope="col">Nombre</th>

                            <th scope="col">Descripción</th>

                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <item :user_id="item.id" :delete_item="delete_item" :updateProgress="updateProgress" :key="index" :index="index" :upload_status="state.uploads_vouchers" :item="item_" v-for="(item_, index) in item.vouchers" />
                    </tbody>
                </table>
            </div>

            <b-modal :hideFooter="true" title="Voucher" v-model="state.modal.voucher">
                <voucher-create :item="modal.voucher" :add_voucher="add_voucher"></voucher-create>
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
        'item.apart.progress': function (){
            this.updateProgress();
        },
    },
	data(){
		return {
			disabledCreate: false,
            state: {
                modal: {
                    voucher: false
                },
                uploads_vouchers: false,
            },
			progress: {
				status: false,
				value: 0,
				variant: "primary",
				max: 99,
				label: "0"
			},
            modal: {
                voucher: {
                    name: "",
                    description: "",
                    file_name: "",
                    file: "",
                    apart: {
                        loading: 1,
                        progress: 0,
                        action: 0
                    }
                }
            },
			item: {
				id: "",
				name: "",
				last_name: "",
				email: "",
				password: "",
				telephone: "",
                vouchers: [],
                apart: {
                    progress: 0
                }
			}
		}
	},
	methods: {
        delete_item(front_id){
            this.item.vouchers.splice(this.item.vouchers.findIndex(item => item.front_id == front_id), 1);
        },
        updateProgress(){
            let sum = 0, voucher_cant_actions = 0;

            for(let i = 0; this.item.vouchers.length>i; i++){
                sum += (1*this.item.vouchers[i].apart.progress)/100;

                voucher_cant_actions += this.item.vouchers[i].apart.action==1 || this.item.vouchers[i].apart.action==2 || this.item.vouchers[i].apart.action==3 ? 1 : 0
            }

            sum+= (1*this.item.apart.progress)/100;

            this.progress.value = (sum/(voucher_cant_actions+1))*100;

            this.progress.label = this.progress.value.toFixed().toString();

            if(this.progress.value==100){
                this.progress.variant = "success";

                this.progress.label = "Su registro fue creado con éxito";
            }
        },
        reset_modal_voucher(){
            this.modal.voucher = {
                name: "",
                description: "",
                file: "",
                apart: {
                    loading: 1,
                    progress: 0,
                    action: 0
                }
            };
        },
        add_voucher(resetFile){
            resetFile();

            this.item.vouchers.push(Object.assign(this.modal.voucher, {apart: {loading: 1, progress: 0, action: 1}}));

            this.reset_modal_voucher();
        },
        resetSaveProgress(){
            this.state.uploads_vouchers = false;

            this.item.apart.progress = 0;
            
            this.progress = {
                status: false,
                value: 0,
                variant: "primary",
                max: 99,
                label: "0"
            }
		},
		onSubmit(e){
			e.preventDefault();

			this.$nextTick( () => { this.resetSaveProgress(); this.progress.status = true });

            const config = {
                onUploadProgress: (progressEvent) => {
                    let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);

                    this.item.apart.progress = percentCompleted==100 ? 99 : percentCompleted;
                }
            };

            let item = JSON.parse(JSON.stringify(this.item)), method = typeof this.item.id != "undefined" ? (this.item.id.length!=0 ? 'PUT' : 'POST') : 'POST';

			['vouchers', 'apart'].forEach(e => delete item[e]);

			axios({
                url: '/api/users'+(method == 'PUT' ? '/'+this.item.id : ''),
                data: item,
                method: method,
                onUploadProgress: config.onUploadProgress
            })
			.then(res => {
                if(typeof res.data.id!="undefined"){
                    if(res.data.id.length!=0){
                        this.$set(this.item, 'id', res.data.id); item.id = res.data.id;

                        item.created_at = res.data.created_at
                    }
                }
                this.item.apart.progress = 100;

                this.state.uploads_vouchers = true;

                this.$store.dispatch('Users/ADD_ITEM', item);
			})
			.catch(() => {
                this.progress.value = 100;

                this.progress.variant = 'danger';

                this.progress.label = "El registro no pudo ser creado";
			});
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