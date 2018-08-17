<template>
  <b-container fluid>
    <!-- User Interface controls -->
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
            <b-form-select v-model="sortBy" :options="sortOptions">
            </b-form-select>
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
    <!-- Main table element -->
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
          <!-- We use @click.stop here to prevent a 'row-clicked' event from also happening -->
          <b-button size="sm" @click.stop="info(row.item, row.index, $event.target)" class="mr-1">
            Info modal
          </b-button>
          <b-button size="sm" @click.stop="row.toggleDetails">
            {{ row.detailsShowing ? 'Hide' : 'Show' }} Details
          </b-button>
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
          <b-pagination align="center" :total-rows="_items.length" :limit="limit" :per-page="perPage" v-model="currentPage" class="my-0" />
        </b-col>
      </div>
    </b-row>

    <b-modal id="modalInfo" @hide="resetModal" :title="modalInfo.title" ok-only>
      <pre>{{ modalInfo.content }}</pre>
    </b-modal>

  </b-container>
</template>

<script>
export default {
  props:['items', 'fields'],
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
      modalInfo: { title: '', content: '' },
      striped: false,
      bordered: false,
      outlined: false,
      small: false,
      hover: true,
      dark: false,
      fixed: false,
      footClone: true,
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
    info (item, index, button) {
      this.modalInfo.title = `Row index: ${index}`
      this.modalInfo.content = JSON.stringify(item, null, 2)
      this.$root.$emit('bv::show::modal', 'modalInfo', button)
    },
    resetModal () {
      this.modalInfo.title = ''
      this.modalInfo.content = ''
    },
    onFiltered (filteredItems) {
      this.totalRows = filteredItems.length
      this.currentPage = 1
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