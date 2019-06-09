import Vue from 'vue'
import VueRouter from 'vue-router'

import ProjectList from './components/ProjectList'
import ProjectEdit from './components/ProjectEdit'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        component: ProjectList,
        name: 'top',
    },
    {
        path: '/project/new',
        component: ProjectEdit,
        name: 'project-new'
    },
    {
        path: '/project/:id',
        component: ProjectEdit,
        name: 'project-edit',
    }
]

const router = new VueRouter({
    routes
})
export default router
