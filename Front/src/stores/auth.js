import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  // État (State)
  const user = ref(null)

  // Getters
  const isAuthenticated = computed(() => user.value !== null)
  const isAdmin = computed(() => user.value?.role === 'Admin')

  // Actions
  function login(loginInput, passwordInput) {
    // Simulation simple pour le développement Front
    if (loginInput === 'admin' && passwordInput === 'admin') {
      user.value = { nom: 'Administrateur', role: 'Admin' }
      return true
    }
    // Simulation d'un établissement
    else if (loginInput === '035001' && passwordInput === 'demo') {
      user.value = { nom: 'Saint-Malo', role: 'Etablissement' }
      return true
    }
    return false
  }

  function logout() {
    user.value = null
  }

  return { user, isAuthenticated, isAdmin, login, logout }
})
