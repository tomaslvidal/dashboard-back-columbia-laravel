<template>
  <div ref="table-component">
    <b-row>
      <b-col md="6" class="my-1">
        <b-form-group horizontal label="Buscar" class="mb-0">
          <b-input-group>
            <b-form-input v-model="filter" placeholder="" />

            <b-input-group-append>
              <b-btn :disabled="!filter" @click="filter = ''">Limpiar</b-btn>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
      </b-col>
      <b-col md="6" class="my-1">
        <b-form-group horizontal label="Ordenar por" class="mb-0">
          <b-input-group>
            <b-form-select v-model="sortBy" :options="sortOptions" />

            <b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
              <option :value="false">Asc</option>

              <option :value="true">Desc</option>
            </b-form-select>
          </b-input-group>
        </b-form-group>
      </b-col>
      <b-col md="6" cols="3" class="my-1">
        <b-form-group horizontal label="Orden" class="mb-0">
          <b-input-group>
            <b-form-select v-model="sortDirection" slot="append">
              <option value="asc">Asc</option>

              <option value="desc">Desc</option>
            </b-form-select>
          </b-input-group>
        </b-form-group>
      </b-col>
      <b-col md="6" cols="9" class="my-1">
        <b-form-group horizontal label="Registros por pagina" class="mb-0">
          <b-form-select :options="pageOptions" v-model="perPage" />
        </b-form-group>
      </b-col>
    </b-row>

    <div class="table-responsive">
      <b-table v-if="_items.length>0" show-empty
        :stacked="stacked"
        :responsive="responsive"
        :items="_items"
        :fields="fields_"
        :current-page="currentPage"
        :per-page="perPage"
        :filter="filter"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        :sort-direction="sortDirection"
        @filtered="onFiltered"
        :striped="striped"
        :bordered="bordered"
        :outlined="outlined"
        :small="small"
        :hover="hover"
        :dark="dark"
        :fixed="fixed"
        :foot-clone="footClone"
        :empty-filtered-text="empty_filtered_text"
        :empty-text="empty_text"
        :no-provider-sorting="no_provider_sorting"
      >
        <template slot="actions" slot-scope="row">
          <div class="d-flex flex-grow-1 justify-content-center align-items-center">
            <b-button variant="primary" :to=" {name: to, params: {id: row.item.id.toString() }} " size="sm" class="mr-1">
              Editar
            </b-button>

            <b-button variant="danger" @click="delete_item(row.item.id)" size="sm">
              Borrar
            </b-button>
          </div>
        </template>
        <template slot="row-details" slot-scope="row">
          <b-card>
            <ul>
              <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value}}</li>
            </ul>
          </b-card>
        </template>
      </b-table>
    </div>

    <b-row v-if="_items.length>0">
      <div class="centerFullWidth">
        <b-col cols="12" class="my-1">
          <b-pagination align="center" :total-rows="totalRows" :limit="limit" :per-page="perPage" v-model="currentPage" class="my-0" />
        </b-col>
      </div>
    </b-row>
  </div>
</template>

<script>

export default {
  props: ['items', 'fields', 'to', 'model'],
  data(){
    return {
      fields_: this.fields,
      currentPage: 1,
      perPage: 25,
      pageOptions: [10, 15, 20, 25, 50],
      sortBy: 'id',
      sortDesc: false,
      sortDirection: 'asc',
      filter: null,
      item: { index: '', data: '', oldData: '' },
      striped: false,
      bordered: false,
      outlined: false,
      small: false,
      hover: true,
      dark: false,
      fixed: false,
      footClone: true,
      totalRows: null,
      stacked: false,
      responsive: false,
      empty_filtered_text: "No hay registros que coincidan con su solicitud",
      empty_text: "No hay registros para mostrar",
      no_provider_sorting: true,
      limit: 12
    }
  },
  computed: {
    _items(){
      return this.items;
    },
    sortOptions () {
      return this.fields_
        .filter(f => f.sortable)
        .map(f => { return { text: f.label, value: f.key } })
    }
  },
  watch:{
    sortDirection: function(val){
      if(val=="asc"){
        this.sortDesc = false;
      }
      else if(val=="desc"){
        this.sortDesc = true;
      }
    }
  },
  methods: {
    onFiltered (filteredItems) {
      this.totalRows = filteredItems.length;

      this.currentPage = 1;
    },
    delete_item(id){
      let confirm_ = confirm("¿Eliminar?");

      if(confirm_){
        axios.delete('/api/'+this.model+'/'+id)
        .then( () => {
          this.$store.dispatch(this.model[0].toUpperCase()+this.model.substring(1)+'/REMOVE_ITEM', {id: id});
        });
      }
    },
    close_popover(id){
      this.$root.$emit('bv::hide::popover', 'popoverButton-disable-'+id);
    }
  }
}
</script>

<style>
.table-responsive{
  padding-top: 20px;
}

.centerFullWidth{
  display: flex;
  justify-content:center;
  flex: 1;
}
</style>