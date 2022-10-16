<template>
    <card>
        <h4 class="card-title">Sirets Réunion</h4>
        <h6 v-if="$apollo.loading" class="card-subtitle mb-2 text-muted" style="color:deepskyblue">Loading</h6>
        <h6 v-else class="card-subtitle mb-2 text-muted"> actuèllement il y a {{sirets_count}} d'entreprises actifs à la
            réunion dans notre BDD </h6>
        <p v-if="$apollo.loading" class="text-muted" style="color:deepskyblue">Fetching Data, Please Wait</p>

    </card>
</template>
<script>
    import Card from "@/components/Cards/Card";
    import {gql} from "apollo-boost";

    export default {
        name: "reunion_sirets",
        components: {
            Card
        },
        data: function () {
            return {sirets_count: ''};
        },
        apollo: {
            sirets_count: {
                query: gql
                    `
                        {
                          sirets_count(
                            where: {
                              AND: [
                                { column: "codeCommuneEtablissement", operator: LIKE, value: "97%" }
                                { column: "etatAdministratifEtablissement", operator: LIKE, value: "A" }
                              ]
                            }
                          )
                        }

                    `
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
<style>
</style>
