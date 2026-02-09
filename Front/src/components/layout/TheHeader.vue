<script setup>
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()

// Fonction de déconnexion
function logout() {
  auth.logout()
  router.push('/login')
}
</script>

<template>
  <header id="entete">
    <div class="top-bar">
      <span>UGSEL Web - Gestion des compétitions</span>

      <div class="user-info">
        <span>{{ auth.user.nom }} ({{ auth.user.role }})</span>
        <button @click="logout" class="btn-logout">Déconnexion</button>
      </div>
    </div>

    <nav class="main-menu">
      <RouterLink to="/" class="nav-link">Accueil</RouterLink>
      <RouterLink to="/etablissements" class="nav-link" v-if="auth.isAdmin"
        >Etablissements</RouterLink
      >
      <RouterLink to="/licencies" class="nav-link">Licenciés</RouterLink>
      <RouterLink to="/competitions" class="nav-link">Compétitions</RouterLink>
      <RouterLink to="/parametres" class="nav-link" v-if="auth.isAdmin"
        >Paramètres</RouterLink
      >
    </nav>
  </header>
</template>

<style scoped>
/* Style inspiré du PHP mais modernisé */
#entete {
  background-color: darkblue; /* Couleur "Océan" du PHP */
  color: white;
  padding: 0;
}

.top-bar {
  display: flex;
  justify-content: space-between;
  padding: 10px 20px;
}

.main-menu {
  background-color: #eee;
  padding: 10px 20px;
  border-bottom: 2px solid #ccc;
}

.nav-link {
  margin-right: 15px;
  text-decoration: none;
  color: darkblue;
  font-weight: bold;
}

.nav-link:hover,
.router-link-active {
  color: red; /* Indication visuelle de la page active */
}

.btn-logout {
  background: none;
  border: 1px solid white;
  color: white;
  cursor: pointer;
  margin-left: 10px;
}
</style>
