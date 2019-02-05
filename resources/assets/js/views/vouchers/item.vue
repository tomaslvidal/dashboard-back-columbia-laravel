<template>
    <tr :key="index">
        <th scope="row">
            <div class="number d-flex justify-content-start align-items-center">
                <div class="ball d-flex justify-content-center align-items-center">
                    <span>{{index+1}}</span>
                </div>

                <div class="d-flex justify-content-end align-items-end" style="padding-left: 10px;">
                    <i :key="1" style="color: #007bff;" v-if="item.apart.loading==2" class="fas fa-circle-notch fa-spin"></i>

                    <i :key="2" style="color: #48b461;" v-else-if="item.apart.loading==3" class="fas fa-check"></i>

                    <i :key="3" style="color: ##ff0059;" v-else-if="item.apart.loading==4" class="fas fa-times"></i>
                </div>
            </div>
        </th>

        <td>{{item.data.get('name')}}</td>

        <td style="">
        </td>

        <td style="text-align: start;">
            <!-- <button type="button" class="btn btn-sm btn-primary">Ver</button> -->
        </td>
    </tr>
</template>

<script>
export default {
    props: ['item', 'index'],
    methods: {
    }
}
</script>

<style>

</style>