import Vue from 'vue';
import VueRouter from 'vue-router';
// import EmployeeIndex from '../components/Employee/IndexComponent.vue';
Vue.use(VueRouter);
const routes = [
    // { path: '/employee/detail', component: EmployeeIndex, name: 'employee.detail' }
];
export default new VueRouter({
    mode: 'history',
    base: '/',
    routes
}); 