<template>
    <card>
        <card>
            <form @submit.prevent="querySiren()">
                <div class="row">
                    <div class="col">
                        <base-input v-model="sirenInput" placeholder="Enter your Siren" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    type = "number"
                                    maxlength = "9"
                                    />
                    </div>
                    <div class="col">
                        <base-button native-type="submit" type="primary">Submit</base-button>
                    </div>
                </div>
            </form>
        </card>
        <div v-if="sirenValide" class="row">
            <card>

                <show-simple-table :data="entreprise"></show-simple-table>
            </card>
            <card>
                <show-simple-table :data="etablissement_siege"></show-simple-table>
            </card>
        </div>
        <card v-if="sirenNonValide" class="bg-warning rounded">
            SIREN non valid
        </card>
    </card>
</template>

<script>

    import ShowSimpleTable from "../../components/Parts/ShowSimpleTable"

    export default {
        name: "siren-details",

        components:{ ShowSimpleTable },

        data() {
            return {
                sirenInput :'',
                sirenDetails :'',
                entreprise :{},
                etablissement_siege :{},
                sirenValide: false,
                sirenNonValide: false,
            }
        },

        methods: {
            setResult(value){
                if(value.entreprise){
                    this.sirenValide = true;
                    this.sirenNonValide = false;
                    this.entreprise = value.entreprise;
                    this.etablissement_siege = value.etablissement_siege
                }else{
                    this.sirenNonValide = true;
                    this.sirenValide = false;
                }
            },

            querySiren(){
                axios
                    .get('http://stargate.test/siren/'+this.sirenInput)
                    .then(
                        response => (this.setResult(response.data)),

                        (error) => ( this.sirenNonValide = true,
                            this.sirenValide = false )
                    );
            },
        },


    }
</script>
<style scoped>

</style>
