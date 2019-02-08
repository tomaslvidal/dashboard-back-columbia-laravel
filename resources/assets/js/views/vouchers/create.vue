<template>
    <b-form v-on:submit.prevent="() => {add_voucher(resetFile)}">
        <!-- Nombre -->
        <b-form-group id="InputGroup1" label="Nombre:" label-for="name">
            <b-form-input type="text" v-model="item.name" required placeholder="Escribir nombre" />
        </b-form-group>

        <!-- Descripcion -->
        <b-form-group id="InputGroup2" label="Descripcion:" label-for="description">
            <b-form-input type="text" v-model="item.description" required placeholder="Escribir descripcion" />
        </b-form-group>

        <!-- Archivo -->
        <b-form-group id="InputGroup3" label="Archivo:" label-for="file_name">
            <b-input-group>
                <b-form-file ref="fileinput" v-model="file_name" @change="onChange($event)" required :state="Boolean(file_name)" placeholder="Seleccionar archivo..." />
            </b-input-group>
        </b-form-group>

        <hr>

        <div class="w-100">
            <b-button class="w-100" variant="primary" type="submit">Agregar</b-button>
        </div>
    </b-form>
</template>

<script>
export default {
    props: ['item', 'add_voucher'],
	data(){
		return {
            file_name: 0,
			variant: 'primary',
		}
	},
	methods: {
		onChange(e){
			let data = new FormData();

			data.append('file', e.target.files[0]);

            this.item.file = data;
		},
        resetFile(){
            this.$refs.fileinput.reset();
        }
	}
}
</script>

<style>
	.custom-file-label::after {
	    content: "Subir";
	}
</style>