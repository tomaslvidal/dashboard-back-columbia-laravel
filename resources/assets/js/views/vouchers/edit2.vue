<template>
    <b-form>
        <!-- Nombre -->
        <b-form-group id="InputGroup1" label="Nombre:" label-for="name">
            <b-form-input @change="onChange_2($event)" type="text" v-model="item.name" required placeholder="Escribir nombre" />
        </b-form-group>

        <!-- Descripcion -->
        <b-form-group id="InputGroup2" label="Descripcion:" label-for="description">
            <b-form-input @change="onChange_2($event)" type="text" v-model="item.description" required placeholder="Escribir descripcion" />
        </b-form-group>

        <!-- Archivo -->
        <b-form-group id="InputGroup3" label="Archivo:" label-for="file_name">
            <b-input-group>
                <b-form-file ref="fileinput" v-model="file_name" @change="onChange($event)" required :state="Boolean(file_name)" placeholder="Seleccionar archivo..." />
            </b-input-group>
        </b-form-group>

        <hr>

        <b-progress v-if="progress.status" :max="progress.max" animated>
				<b-progress-bar :label="progress.label" :variant="progress.variant" :value="progress.value" />
        </b-progress>

        <br v-if="progress.status">

        <div class="w-100">
			<b-button class="w-100" @click="closeModal()" variant="primary">Cerrar</b-button>
        </div>
    </b-form>
</template>

<script>
export default {
    props: ['item', 'add_voucher', 'closeModal'],
	data(){
		return {
            variant: 'primary',
			progress_status: false,
			progress: {
				status: false,
				value: 0,
				variant: "primary",
				max: 99,
				label: "0"
			},
            file_name: 0,
			counter: 0,
			label: "0",
			max: 99,
		}
	},
	methods: {
        onChange_2(e){
            this.item.apart.action = 2;
        },
		onChange(e){
			let data = new FormData();

			data.append('file', e.target.files[0]);

            this.item.file = data;

            this.item.apart.action = 2;
		},
        delete_file(){
            
        }
	}
}
</script>

<style>
	.custom-file-label::after {
	    content: "Subir";
	}
</style>