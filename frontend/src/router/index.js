import {createRouter, createWebHistory} from 'vue-router'
import SportsView from '../views/SportsView.vue'
import ChampionnatsView from '../views/ChampionnatsView.vue'
import ChampionnatDetailsView from '../views/ChampionnatDetailsView.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path: '/', redirect: '/championnats'},
        {path: '/sports', component: SportsView},
        {path: '/championnats', component: ChampionnatsView},
        {path: '/championnats/:id', component: ChampionnatDetailsView}
    ]
})

export default router
