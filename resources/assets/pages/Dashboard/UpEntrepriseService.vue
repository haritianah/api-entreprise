<template>
    <card>
        <h4 class="card-title">Entreprise API gouv.fr</h4>
        <h6 class="card-subtitle mb-2 text-muted" style="color:deepskyblue">Historique des données</h6>
        <div v-if="loading">Loading</div>
        <div v-else>
            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link text-white" id="pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="pills-home" aria-selected="true">General</a>
                        <a class="nav-link" v-for="(s, index) of status" data-toggle="pill" :href="'#v-pills-'+s.provider_name" role="tab" :aria-controls="'v-pills-'+s.provider_name" aria-selected="false">{{s.provider_name}}</a>
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="pills-home-tab'">
                            <up-service></up-service>
                        </div>
                        <div v-for="(s, index) of status" class="tab-pane fade show" :id="'v-pills-'+s.provider_name" role="tabpanel" :aria-labelledby="'v-pills-'+s.provider_name+'-tab'">
                            <card class="bg-default">
                                <h4 class="card-title">Provider {{s.provider_name}}</h4>
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li v-for="(endpoint, i) of s.endpoints_availability_history" class="nav-item">
                                        <a class="nav-link text-white" :id="'pills-'+s.provider_name+'-'+endpoint.uname+'-tab'" data-toggle="pill" :href="'#pills-'+s.provider_name+'-'+endpoint.uname" role="tab" :aria-controls="'pills-'+s.provider_name+'-'+endpoint.uname" aria-selected="true">{{endpoint.name}}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div v-for="(endpoint, i) of s.endpoints_availability_history" class="tab-pane fade show" :id="'pills-'+s.provider_name+'-'+endpoint.uname" role="tabpanel" :aria-labelledby="'pills-'+s.provider_name+'-'+endpoint.uname+'-tab'">
                                        <card class="bg-dark">
                                            <table class="table stripped table-full-width">
                                                <thead>
                                                <tr>
                                                    <th colspan="2">{{endpoint.name}} <small>({{endpoint.uname}})</small></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>api version</td>
                                                    <td>version {{endpoint.api_version}}</td>
                                                </tr>
                                                <tr>
                                                    <td>provider name</td>
                                                    <td>{{endpoint.provider_name ? endpoint.provider_name : "missing"}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">SLA</td>
                                                    <td>{{endpoint.sla}} %</td>
                                                </tr>
                                                <tr>
                                                    <td>last history code status</td>
                                                    <td>
                                                        {{endpoint.availability_history.slice().reverse()[0][0]}} - {{endpoint.availability_history.slice().reverse()[0][2]}} : {{endpoint.availability_history.slice().reverse()[0][1]}} <i class="tim-icons icon-link-72" :style="style(endpoint.availability_history.slice().reverse()[0][1])"></i>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <div>
                                                <base-button type="info" data-toggle="modal" :data-target="'#'+s.provider_name+'-'+endpoint.uname+'-tab-history'">More History Info</base-button>
                                            </div>
                                            <div class="modal" :id="s.provider_name+'-'+endpoint.uname+'-tab-history'" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content bg-dark">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-default">Services Uptime History of {{s.provider_name}} - {{endpoint.name}} </h5>
                                                            <button type="button button-danger" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <base-table :data="endpoint.availability_history.slice().reverse()" class="bg-dark">
                                                                <template slot="columns">
                                                                    <th>From</th>
                                                                    <th>To</th>
                                                                    <th>Status</th>
                                                                </template>
                                                                <template slot-scope="{row}">
                                                                    <td>{{row[0]}}</td>
                                                                    <td>{{row[2]}}</td>
                                                                    <td>{{row[1]}} <i class="tim-icons icon-link-72" :class="style(row[1])"></i></td>
                                                                </template>
                                                            </base-table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </card>
                                    </div>
                                </div>
                            </card>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </card>
</template>
<script>
    import Card from "@/components/Cards/Card";
    import BaseTable from "@/components/BaseTable";
    import {gql} from "apollo-boost";
    import UpService from "./UpService";

    export default {
        name: "up-entreprise-service",
        components: {
            UpService,
            Card,
            BaseTable
        },
        data: () => {
            return {
                status: {},
                loading: true,
                //
                columns: [0, 2, 1]
            }
        },
        methods: {
            toggleHistory: function(ev){
              console.log(ev);
            },
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
        beforemount() {
            this.loading = true;


        },
        mounted() {
            axios
                .get('http://stargate.test/availibility-history')
                .then(response => (this.status = response.data.results));
            this.loading = false;
            console.log(this.status.results);
        }
    }
</script>
<style>
</style>
