<template>
    <div>
        <div class="row">
            <div class="col-12">
                I'm Here this is the new dashboard pages, yeah!
            </div>
        </div>
        <div class="row">
            <div class="col-12">
<!--                <up-service></up-service>-->
                <up-entreprise-service></up-entreprise-service>
                <siren-details></siren-details>
            </div>
            <div class="col-6"></div>
        </div>
    </div>
</template>
<script>
    import TaskList from "./Dashboard/TaskList"
    import UserTable from "./Dashboard/UserTable"


    //TODO SATELLITE PARTS ================================
    import CountSiretsReunionService from "./Dashboard/CountSiretsReunionService"
    import SirenForm from "./Dashboard/SirenForm"
    import UpEntrepriseService from "./Dashboard/UpEntrepriseService";
    import SirenDetails from "./Dashboard/SirenDetails";
    import Upservice from "./Dashboard/UpService";

    //\TODO SATELLITE PARTS ================================

    export default {
        components: {
            'up-service' : Upservice,
            // LineChart,
            // BarChart,
            TaskList,
            CountSiretsReunionService,
            UserTable,
            UpEntrepriseService,
            SirenForm,
            SirenDetails
        },
    data() {
      return {}
    },
    computed: {
      enableRTL() {
        return this.$route.query.enableRTL;
      },
      isRTL() {
        return this.$rtl.isRTL;
      },
      bigLineChartCategories() {
        return this.$t('dashboard.chartCategories');
      }
    },
    // methods: {
    //
    // },
    mounted() {
      this.i18n = this.$i18n;
      if (this.enableRTL) {
        this.i18n.locale = 'fr';
        this.$rtl.enableRTL();
      }
      // this.initBigChart(0);
    },
    beforeDestroy() {
      if (this.$rtl.isRTL) {
        this.i18n.locale = 'en';
        this.$rtl.disableRTL();
      }
    }
  };
</script>
<style>
</style>
