import Vue from 'vue'
import VueRouter from 'vue-router'

import ProjectList from './components/ProjectList'
import ProjectEdit from './components/ProjectEdit'

import ProjectDetail from './components/ProjectDetail'
import ReviewEdit from './components/ReviewEdit'
import About from './components/about'

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
        path: '/project/:id/edit',
        component: ProjectEdit,
        name: 'project-edit',
    },
    {
        path: '/project/:id',
        component: ProjectDetail,
        name: 'project-detail',
    },
    {
        path: '/project/:id/review/new',
        component: ReviewEdit,
        name: 'review-new',
    },
    {
        path: '/project/:id/review/:review_id',
        component: ReviewEdit,
        name: 'review-edit',
    },
    {
        path: '/about',
        component: About,
        name: 'about',
    },
]

const router = new VueRouter({
    routes
})
export default router
