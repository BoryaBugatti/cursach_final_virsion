import { createRouter, createWebHistory } from 'vue-router';
import RegForm from '../components/RegisterForm.vue';
import mainwindow from "../components/mainwindow.vue";
import Athoriz from "../components/Athorization.vue";
import make_order from "../components/make_order.vue";

const routes = [
  {
    path: '/LK',
    name: 'LK',
    component: Athoriz
  },
  {
    path: '/',
    name: 'Home',
    component: mainwindow
  },
  {
    path: '/register',
    name: "register",
    component: RegForm
  },
  {
    path: '/make_order',
    name: "make_order",
    component: make_order
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;