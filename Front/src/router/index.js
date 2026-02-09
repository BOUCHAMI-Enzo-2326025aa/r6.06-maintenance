import { createRouter, createWebHistory } from 'vue-router'
import SportsView from '../views/SportsView.vue'
import ChampionnatsView from '../views/ChampionnatsView.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', redirect: '/championnats' },
    { path: '/sports', component: SportsView },
    { path: '/championnats', component: ChampionnatsView }
  ]
})

export default router
