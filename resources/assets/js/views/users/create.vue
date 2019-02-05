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

                            <th scope="col">Carga</th>

                            <th scope="col">Acción</th>
                        </tr>
                    </thead>

                    <tbody>
                        <item :key="index" :index="index" :item="item" v-for="(item, index) in item.vouchers" />
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
	data(){
		return {
			show: true,
			disabledCreate: false,
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
			this.progress.value = 0;

			this.progress.variant = 'primary';
		},
        showModal(){
			this.modal.voucher.state = !this.modal.voucher.state;
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

            this.item.vouchers.push({data: data, apart: {loading: 1}});

            this.reset_modal_voucher();
        },
		onSubmit(e){
			e.preventDefault();

			this.progress.status = false;

			this.$nextTick( () => { this.resetSaveProgress(); this.progress.status = true });

            let vouchers_loaded = 0;

            const config = {
                onUploadProgress: (progressEvent) => {
                    let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);

                    let progress = parseFloat(100-(100/(this.item.vouchers.length+1))*(((this.item.vouchers.length+1)-vouchers_loaded)-(percentCompleted/100))).toFixed(); progress = progress >= 100 ? 100 : progress;

                    this.progress.label = progress.toString();

                    this.progress.value = Number(progress);

                    if(Number(percentCompleted)==100){
                        vouchers_loaded++;

                        if((this.item.vouchers.length+1)==vouchers_loaded){
                            this.progress.variant = "success";

                            this.progress.label = "Su registro fue creado con éxito";
                        }
                    }
                }
            };

            let item_user = this.item;

			['id', 'created_at', 'vouchers', 'voucher_modal'].forEach(e => delete item_user.e);

			axios.post('/api/users', JSON.parse(JSON.stringify(item_user)), config)
			.then((res)=>{
				setTimeout( () => {
                    if (this.item.vouchers.length>0){
                        for (let i = 0; i < this.item.vouchers.length; i++) {
                            let items = this.item.vouchers[i];

                            this.$set(this.item.vouchers[i].apart, 'loading', 2)

                            console.log("test: ", JSON.parse(JSON.stringify(this.item.vouchers[i].data)));

                            axios.post('/api/vouchers', this.item.vouchers[i].data, config)
                            .then((res)=>{
                                setTimeout( () => {
                                    this.$set(this.item.vouchers[i].apart, 'loading', 3)
                                }, 1000);
                            })
                            .catch(()=>{
                                setTimeout( () => {
                                    this.$set(this.item.vouchers[i].apart, 'loading', 4)
                                }, 1000);
                            });
                        }
                    }

					setTimeout( () => {
						// this.$router.push({name: 'users'}); // this.$router.go(-1);
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