import Vue from 'vue';
import Router from 'vue-router';
import DashboardLayout from '@/layout/starter/SampleLayout.vue';
import Starter from '@/layout/starter/SamplePage.vue';

const Dashboard = () => import(/* webpackChunkName: "dashboard" */"@/pages/Dashboard.vue");

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      redirect: '/dashboard',
      component: DashboardLayout,
      children: [
        {
          path: 'dashboard',
          name: 'dashboard',
          component: Dashboard
        }
      ]
    }
  ]
});
