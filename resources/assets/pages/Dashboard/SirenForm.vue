<template>
    <div>
        <card>
            <form @submit.prevent="querySiren">
                <div class="row">
                    <div class="col">
                        <base-input type="text" v-model="sirenInput" placeholder="Enter your Siren"/>
                    </div>
                    <div class="col">
                        <base-button native-type="submit" type="primary">Submit</base-button>
                    </div>
                </div>
            </form>
        </card>
        <div v-if="sirenValide" class="row">
                <div class="col">
                    <card>
                        <show-simple-table :data="this.siren" ></show-simple-table>
                    </card>
                </div>
                <div class="col">
                    <card>
                        <show-array-table :datas="this.sirets"></show-array-table>
                    </card>

                </div>
        </div>
        <card v-if="sirenNonValide" class="bg-warning rounded">
            SIREN non valid
        </card>
    </div>

</template>

<script>


    import {gql} from "apollo-boost";
    import ShowSimpleTable from "../../components/Parts/ShowSimpleTable"
    import ShowArrayTable from "../../components/Parts/ShowArrayTable"

    export default {
        name: "sirenForm",

        components:{ ShowSimpleTable, ShowArrayTable },

        data: function () {
            return {
                sirenInput: '',
                siren: {},
                sirenValide: false,
                sirenNonValide: false,
                res: '',
                sirets: []
            };
        },

        methods: {

            playresult: function (data) {
                if (data.siren) {
                    this.siren = data.siren;
                    this.sirets = this.siren.sirets
                    delete this.siren.sirets;
                    this.sirenValide = true;
                    this.sirenNonValide = false;

                } else {
                    this.sirenValide = false;
                    this.sirenNonValide = true;
                }

            },

            querySiren() {
                console.log(this);

                const siren = gql`
                            query Siren($siren: String!) {
                                  siren(siren: $siren){
                                    siren
                                    statutDiffusionUniteLegale
                                    unitePurgeeUniteLegale
                                    dateCreationUniteLegale
                                    sigleUniteLegale
                                    sexeUniteLegale
                                    prenom1UniteLegale
                                    prenom2UniteLegale
                                    prenom3UniteLegale
                                    prenom4UniteLegale
                                    prenomUsuelUniteLegale
                                    pseudonymeUniteLegale
                                    identifiantAssociationUniteLegale
                                    trancheEffectifsUniteLegale
                                    anneeEffectifsUniteLegale
                                    dateDernierTraitementUniteLegale
                                    nombrePeriodesUniteLegale
                                    categorieEntreprise
                                    anneeCategorieEntreprise
                                    dateDebut
                                    etatAdministratifUniteLegale
                                    nomUniteLegale
                                    nomUsageUniteLegale
                                    denominationUniteLegale
                                    denominationUsuelle1UniteLegale
                                    denominationUsuelle2UniteLegale
                                    denominationUsuelle3UniteLegale
                                    categorieJuridiqueUniteLegale
                                    activitePrincipaleUniteLegale
                                    nomenclatureActivitePrincipaleUniteLegale
                                    nicSiegeUniteLegale
                                    economieSocialeSolidaireUniteLegale
                                    caractereEmployeurUniteLegal
                                    sirets{
                                        siret
                                        nic
                                        statutDiffusionEtablissement
                                        dateCreationEtablissement
                                        trancheEffectifsEtablissement
                                        anneeEffectifsEtablissement
                                        activitePrincipaleRegistreMetiersEtablissement
                                        dateDernierTraitementEtablissement
                                        etablissementSiege
                                        nombrePeriodesEtablissement
                                        complementAdresseEtablissement
                                        numeroVoieEtablissement
                                        indiceRepetitionEtablissement
                                        typeVoieEtablissement
                                        libelleVoieEtablissement
                                        codePostalEtablissement
                                        libelleCommuneEtablissement
                                        libelleCommuneEtrangerEtablissement
                                        distributionSpecialeEtablissement
                                        codeCommuneEtablissement
                                        codeCedexEtablissement
                                        libelleCedexEtablissement
                                        codePaysEtrangerEtablissement
                                        libellePaysEtrangerEtablissement
                                        complementAdresse2Etablissement
                                        numeroVoie2Etablissement
                                        indiceRepetition2Etablissement
                                        typeVoie2Etablissement
                                        libelleVoie2Etablissement
                                        codePostal2Etablissement
                                        libelleCommune2Etablissement
                                        libelleCommuneEtranger2Etablissement
                                        distributionSpeciale2Etablissement
                                        codeCommune2Etablissement
                                        codeCedex2Etablissement
                                        libelleCedex2Etablissement
                                        codePaysEtranger2Etablissement
                                        libellePaysEtranger2Etablissement
                                        dateDebut
                                        etatAdministratifEtablissement
                                        enseigne1Etablissement
                                        enseigne2Etablissement
                                        enseigne3Etablissement
                                        denominationUsuelleEtablissement
                                        activitePrincipaleEtablissement
                                        nomenclatureActivitePrincipaleEtablissement
                                        caractereEmployeurEtablissement
                                        categorieJuridiqueUniteLegale
                                    }
                                  }
                                }
                        `

                this.$apollo.query({
                    query: siren,
                    variables: {
                        // Use vue reactive properties here
                        siren: this.sirenInput
                    }
                }).then(result => this.playresult(result.data))
            }
        },

        mounted() {
            console.log("siren form monted")
        }
    }
</script>

<style scoped>

</style>
