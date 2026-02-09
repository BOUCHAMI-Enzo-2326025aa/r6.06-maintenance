import { createRouter, createWebHistory } from 'vue-router'
import SportsView from '../views/SportsView.vue'
import EpreuvesView from '../views/EpreuvesView.vue'
import TournoisView from '../views/TournoisView.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', redirect: '/sports' },
    { path: '/sports', component: SportsView },
    { path: '/epreuves', component: EpreuvesView },
    { path: '/tournois', component: TournoisView }
  ]
})

export default router
