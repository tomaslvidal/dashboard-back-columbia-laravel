<template>
    <tr>
        <th scope="row" style="width: 176px">
            <div class="number d-flex justify-content-start align-items-center" style="max-width: 124px">
                <div class="ball d-flex justify-content-center align-items-center">
                    <span style="min-width: 28px; text-align: center">{{index+1}}</span>

                    <i :key="1" style="padding-left:10px; width: 0px; color: #007bff;" v-if="item.apart.action==1 || item.apart.action==2" class="fas fa-upload"></i>
                
                    <i :key="2" style="padding-left:10px; width: 0px; color: #dc3545;" v-if="item.apart.action==3" class="fas fa-trash-alt"></i>
                </div>
            </div>
        </th>

        <td>
            <div class="d-flex justify-content-center align-items-center" style="width: 46px; height: 46px">
                <progress-radius v-if="item.apart.loading==2" :radius="23" :progress_item="item.apart.progress" :stroke="4"></progress-radius>

                <i :key="2" style="color: #28a745;" v-else-if="item.apart.loading==3" class="far fa-check-circle"></i>

                <i :key="3" style="color: #dc3545;" v-else-if="item.apart.loading==4" class="fas fa-exclamation-circle"></i>
            </div>
        </td>

        <td>{{item.name}}</td>

        <td>{{item.description}}</td>

        <td style="text-align: start;">
            <button type="button" @click="() => {this.state.modal.edit_voucher = !this.state.modal.edit_voucher}" class="edit_voucher btn btn-sm btn-primary">Editar</button>

            <button type="button" @click="click_delete_item" class="btn btn-sm btn-danger">Borrar</button>

            <b-btn size="sm" :disabled="typeof item.file_name != 'undefined' ? (item.file_name.length==0 ? true : false) : true" variant="outline-secondary" target="_blank" :href="'/vouchers/download/'+item.file_name">Descargar</b-btn>

            <b-modal :hideFooter="true" title="Voucher" v-model="state.modal.edit_voucher">
                <voucher-edit :item="item" :closeModal="() => {this.state.modal.edit_voucher = !this.state.modal.edit_voucher}"></voucher-edit>
            </b-modal>
        </td>
    </tr>
</template>

<script>
import uniqueString from 'unique-string';
 
export default {
    components: {
		'progress-radius': require('../../components/utilities/Progress.vue'),
        'voucher-edit': require('../vouchers/edit2.vue')
	},
    props: ['item', 'index', 'upload_status', 'updateProgress', 'delete_item', 'user_id'],
    created(){
        if(typeof this.item.apart == "undefined"){
            this.$set(this.item, 'apart', {
                loading: 1,
                progress: 0,
                action: 0
            })
        }

        if(typeof this.item.front_id == "undefined"){
            this.$set(this.item, 'front_id', uniqueString());
        }
    },
    data(){
        return {
            state: {
                upload: false,
                modal: {
                    edit_voucher: false
                }
            }
        };
    },
    watch: {
        upload_status: function () {
            if(this.upload_status){
                if(typeof this.user_id != "undefined"){            
                    if(this.user_id.length!=0){                    
                        if(this.item.apart.loading!=2){
                            if(this.item.apart.action==1){
                                this.create();
                            }
                            else if(this.item.apart.action==2){
                                typeof this.item.id != "undefined" ? this.edit() : this.create();
                            }
                            else if(this.item.apart.action==3){
                                this.delete();
                            }
                        }
                    }
                }
            }
        },
        'item.apart.progress': function (){
            this.updateProgress();
        }
    },
    methods: {
        click_delete_item(){
            let confirm_ = confirm("¿Eliminar?");

            if(confirm_){
                if(typeof this.item.id == "undefined"){
                    this.delete_item(this.item.front_id);
                }
                else{
                    this.item.apart.action = 3;
                }
            }
        },
        reset_some_aparts(item){
            item.apart.progress = 0;

            item.apart.action = 0;
        },
        edit(){
            let item = this.item;

            const config = {
                onUploadProgress: (progressEvent) => {
                    let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    
                    item.apart.progress = percentCompleted==100 ? 99 : percentCompleted;
                }
            };

            let data = new FormData();

            for(let i=0; Object.keys(this.item).length>i; i++){
                let key_ = Object.keys(this.item)[i];

                if(key_!="apart" && key_!="front_id" && key_!="file_name" && key_!="pivot" && key_!="deleted_at" && key_!="updated_at" && key_!="created_at" && key_!="id"){
                    if(this.item[key_] instanceof FormData){
                        this.item[key_].forEach((value,key) => {
                            data.append('file_name', value);
                        });
                    }
                    else{
                        data.append(key_, this.item[key_]);
                    }
                }
            }

            data.append('users', JSON.stringify([this.user_id]));

            data.append('_method', 'PUT');

            this.$set(this.item.apart, 'loading', 2);

			axios.post('/api/vouchers/'+this.item.id, data, config)
			.then(res => {
                item.apart.progress = 100;

                this.$set(item, 'file_name', res.data.file_name);

                this.$set(item.apart, 'loading', 3);

                this.reset_some_aparts(item);
			})
			.catch(() => {
                this.$set(item.apart, 'loading', 4)

                this.reset_some_aparts(item);
			});
        },
        create(){
            let item = this.item;

            const config = {
                onUploadProgress: (progressEvent) => {
                    let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);

                    item.apart.progress = percentCompleted==100 ? 99 : percentCompleted;
                }
            };

			let data = new FormData();

            for(let i=0; Object.keys(this.item).length>i; i++){
                let key_ = Object.keys(this.item)[i];

                if(key_!="apart" && key_!="front_id" && key_!="file_name" && key_!="pivot" && key_!="deleted_at" && key_!="updated_at" && key_!="created_at" && key_!="id"){
                    if(this.item[key_] instanceof FormData){
                        this.item[key_].forEach((value,key) => {
                            data.append('file_name', value);
                        });
                    }
                    else{
                        data.append(key_, this.item[key_]);
                    }
                }
            }

            data.append('users', JSON.stringify([this.user_id]));

            this.$set(this.item.apart, 'loading', 2);

            axios.post('/api/vouchers', data, config)
            .then(res =>{
                item.apart.progress = 100;

                this.$set(item.apart, 'loading', 3);

                this.$set(item, 'id', res.data.id);

                this.$set(item, 'file_name', res.data.file_name);

                this.reset_some_aparts(item);
            })
            .catch(() => {
                this.$set(item.apart, 'loading', 4)

                this.reset_some_aparts(item);
            });
        },
        delete(){
            let item = this.item;

            this.item.apart.progress = 99;

            this.$set(this.item.apart, 'loading', 2);

            if(typeof this.item.id != "undefined"){
                axios({
                    method: 'DELETE',
                    url: '/api/vouchers/'+this.item.id,
                })
                .then(() => {
                    item.apart.progress = 100;

                    setTimeout(() => {
                        this.delete_item(item.front_id);
                    }, 300)
                });
            }
        }
    }
}
</script>

<style scoped>
    td, th{
        vertical-align: middle;
        text-align: start!important;
    }

    .edit_voucher{
        margin-left: 10px;
        border-color: #007bffd1;
        background-color: #007bffd1;
    }
</style>