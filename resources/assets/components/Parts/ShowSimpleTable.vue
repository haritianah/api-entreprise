<template>
    <table class="table">
        <thead>
        </thead>
        <tbody>
        <tr v-for="(value, name) in  data ">
            <td> {{ name }} </td>
            <td> {{ value }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "ShowSimpleTable",

        props:{
            data:{type: Object },
        },
    }


</script>

<style scoped>

</style>
