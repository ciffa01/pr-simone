import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../views/Home.vue';
import Form from '../views/Form.vue';
const routes = [
    {
        path: "/",
        name: "home",
        component: Home,
    },
    {
        path: "/insert",
        name: "insert",
        component: Form,
    },
    {
        path: "/edit/:id",
        name: "edit",
        component: Form
    },
    {
        path: "/view/:id",
        name: "view",
        component: Form
    },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
