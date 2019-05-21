import Vue from 'vue'
import VueRouter from 'vue-router'

import ProjectList from './components/ProjectList'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        component: ProjectList,
        name: 'top',
    },
]

const router = new VueRouter({
    routes
})
export default router
