<template>
    <div>
        <card v-for="data of datas" v-bind:key="data.id" class="bg-info text-info">
            <table class="table" >
                <tbody>
                    <tr v-for="(value, name) in  data">
                        <td> {{ name }} </td>
                        <td> {{ value }}</td>
                    </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>

<script>
    export default {
        name: "ShowArrayTable",

        props:{
            datas:{type: Array },
        },
    }


</script>

<style scoped>

</style>
