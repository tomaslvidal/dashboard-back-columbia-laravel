<template>
	<table-component :items="items" :fields="fields" :hide_footer="hide_footer">
		<div slot="html-modal" slot-scope="{ item, reset }">
			<b-modal id="modalInfo" :visible="visible" :hide-footer="hide_footer" :title="`Persona: ${item.name} ${item.last_name}`" ok-title="Guardar" cancelVariant="danger" cancel-title="Reset" @ok="okModal($event, item)" @cancel="reset">
				<form>
				  <div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="name">Nombre</label>

				      <input type="text" v-model="item.name" class="form-control" id="name" placeholder="Escribir nuevo nombre" autocomplete="new-name">
				    </div>

				    <div class="form-group col-md-6">
				      <label for="last_name">Apellido</label>

				      <input type="text" v-model="item.last_name" class="form-control" id="last_name" placeholder="Escribir nuevo apellido" autocomplete="new-lastname">
				    </div>
				  </div>

				  <div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="password">Contraseña</label>

				      <input type="password" class="form-control" id="password" placeholder="Escribir nueva contraseña" autocomplete="new-password">
				    </div>

				    <div class="form-group col-md-6">
				      <label for="password-repeat">Repetir contraseña</label>

				      <input type="password" class="form-control" id="password-repeat" placeholder="Repetir contraseña" autocomplete="new-password">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="email">Email</label>

				    <input type="email" v-model="item.email" class="form-control" id="email" placeholder="Escribir nuevo email" autocomplete="new-email">
				  </div>

				  <div class="form-group">
				    <label for="telephone">Telefono</label>

				    <input type="tel" v-model="item.telephone" class="form-control" id="telephone" placeholder="Escribir nuevo telefono" autocomplete="new-telephone">
				  </div>
				</form>
    		</b-modal>
		</div>
	</table-component>
</template>

<script>
export default {
	created(){
		if(this.$store.state.Users.request_made==false){
			this.$store.dispatch('Users/FETCH_ITEMS');
		}

		this.$store.dispatch('Breadcrumb/SET_ITEMS', [{
			text: 'Inicio',
			href: '/'
		}, {
			text: 'Usuarios',
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
				{ key: 'last_name', label: 'Apellido' },
				{ key: 'email', label: 'Email' },
				{ key: 'telephone', label: 'Telefono' },
				{ key: 'created_at', sortable: true, label: 'Fecha de creación' },
				{ key: 'updated_at', sortable: true, label: 'Fecha de actualización' },
				{ key: 'actions', label: '' }
			],
			hide_footer: false,
			visible: false,
			item: {}
		}
	},
	computed:{
		items(){
			return this.$store.state.Users.items;
		}
	},
	methods : {
		okModal(e, item){
			e.preventDefault();

			this.$store.dispatch('Users/UPDATE_ITEM', JSON.parse(JSON.stringify(item)));

        	this.$store.dispatch('Modals/StateModalEditSave');
		}
	}
}
</script>

<style>
.probando{
	color: red;
}
</style>