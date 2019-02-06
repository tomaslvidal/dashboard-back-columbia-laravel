<template>
    <tr>
        <th scope="row">
            <div class="number d-flex justify-content-start align-items-center">
                <div class="ball d-flex justify-content-center align-items-center">
                    <span>{{index+1}}</span>
                </div>

                <div class="d-flex justify-content-end align-items-end" style="padding-left: 10px;">
                    <div class="d-flex justify-content-center align-items-center" style="width: 46px; height: 46px">
                        <progress-radius v-if="item.apart.loading==2" :radius="23" :progress_item="item.apart.progress" :stroke="4"></progress-radius>

                        <i :key="2" style="color: #28a745;" v-else-if="item.apart.loading==3" class="far fa-check-circle"></i>

                        <i :key="3" style="color: #a90000;" v-else-if="item.apart.loading==4" class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
            </div>
        </th>

        <td>{{item.data.get('name')}}</td>

        <td>{{item.data.get('description')}}</td>

        <!-- <td style="text-align: start;">
            <button type="button" class="btn btn-sm btn-primary">Ver</button>
        </td> -->
    </tr>
</template>

<script>
export default {
    components: {
		'progress-radius': require('../../components/utilities/Progress.vue'),
	},
    props: ['item', 'index', 'upload_status', 'updateProgress'],
    data(){
        return {
            state: {
                upload: false
            }
        };
    },
    watch: {
        upload_status: function () {
            this.upload_status==true ? (!this.state.upload ? this.upload() : null) : null;
        },
        'item.apart.progress': function (){
            this.updateProgress();
        }
    },
    methods: {
        upload(){
            const config = {
                onUploadProgress: (progressEvent) => {
                    let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);

                    this.item.apart.progress = percentCompleted;
                }
            };

            this.state.upload = true;

            this.$set(this.item.apart, 'loading', 2);

            axios.post('/api/vouchers', this.item.data, config)
            .then((res)=>{
                this.$set(this.item.apart, 'loading', 3)
            })
            .catch(()=>{
                this.$set(this.item.apart, 'loading', 4)
            });
        }
    }
}
</script>

<style scoped>
    td{
        vertical-align: middle;
        text-align: start!important;
    }
</style>