<template>
    <card>
        <h4 class="card-title">API Entreprise</h4>
        <div v-if="status.error">
            <div class="alert alert-dismissible alert-danger">
                error:
                {{status.error}}
            </div>
        </div>
        <div v-else>
            <base-table :data="status"
                        :columns="columns">
                <template slot="columns">
<!--                    <th>uname</th>-->
                    <th class="text-left">name</th>
                    <th class="text-left">provider</th>
<!--                    <th>api_version</th>-->
                    <th>code</th>
                    <th class="text-right">timestamp</th>
                    <th></th>
                </template>
                <template slot-scope="{row}">
<!--                    <td>{{row.uname}}</td>-->
                    <td class="text-left">{{row.name}} <small class="text-help">(v{{row.api_version}})</small></td>
                    <td class="text-left">{{row.provider}}</td>
                    <td><i class="tim-icons icon-link-72" :class="style(row.code)" :title="row.code"></i></td>
                    <td class="text-right">{{row.timestamp}}</td>
                    <td class="td-actions text-right">
                        <base-button type="info" size="sm" icon>
                            <i class="tim-icons icon-single-02"></i>
                        </base-button>
                        <base-button type="success" size="sm" icon>
                            <i class="tim-icons icon-settings"></i>
                        </base-button>
                        <base-button type="danger" size="sm" icon>
                            <i class="tim-icons icon-simple-remove"></i>
                        </base-button>
                    </td>
                </template>
            </base-table>
        </div>
    </card>
</template>
<script>

    import baseTable from "../../components/BaseTable"

    import ShowArrayTable from "../../components/Parts/ShowArrayTable"

    export default {
        name: "up-service",

        components:{ ShowArrayTable , baseTable},

        computed:{
            codeColor : function () {

            }
        },

        data() {
            return {
                status: [],

                // columns: ["uname", "name", "provider", "api_version", "code", "timestamp"],
                columns: ["name", "provider", "api_version", "code", "timestamp"],
                columns: ["name", "provider", "code", "timestamp"],

            }
        },

        methods: {
            style: function (value) {

                if(value == 200){
                    return "text-success";
                }

                if(value == 500){
                    return "text-danger";
                }

                if(value == 404){
                    return "text-danger";
                }

                return "text-warning";



            }
        },

        mounted () {
             axios.get('http://stargate.test/api_status').then(console.log(this.status))
            .then(response => (this.status = response.data.results))
            .catch(error => (this.status =  {"error" : error.response.data}));

        }
    }
</script>
<style>
</style>
