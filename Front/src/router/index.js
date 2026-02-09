import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import DashboardView from '../views/DashboardView.vue'
// On importera les autres vues au fur et à mesure

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/',
      name: 'home',
      component: DashboardView
    },
    {
      path: '/competitions',
      name: 'competitions',
      component: () => import('../views/CompetitionsView.vue') // Lazy loading
    }
    // Ajouter les autres routes ici
  ]
})

// Gardien de navigation (Vérifie si on est connecté)
router.beforeEach((to, from, next) => {
  // Note: Il faudra importer le store ici pour vérifier l'auth réelle
  const publicPages = ['/login']
  const authRequired = !publicPages.includes(to.path)
  // Logique simplifiée pour l'instant
  next()
})

export default router
