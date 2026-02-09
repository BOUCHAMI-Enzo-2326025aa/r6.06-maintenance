<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const auth = useAuthStore()

// Variables réactives pour le formulaire
const login = ref('')
const password = ref('')
const errorMsg = ref('')

// Gestion de la soumission
const handleSubmit = () => {
  // Simulation de la vérification (à remplacer par appel API plus tard)
  if (auth.login(login.value, password.value)) {
    router.push('/') // Redirection vers l'accueil
  } else {
    errorMsg.value = "Identifiants incorrects (Essayez 'admin' / 'admin')"
  }
}
</script>

<template>
  <div class="login-container">
    <div class="login-box">
      <h2>UGSEL Web</h2>
      <p>Espace d'inscription aux compétitions</p>

      <form @submit.prevent="handleSubmit">
        <div class="form-group">
          <label>Utilisateur :</label>
          <input type="text" v-model="login" required />
        </div>

        <div class="form-group">
          <label>Mot de passe :</label>
          <input type="password" v-model="password" required />
        </div>

        <p v-if="errorMsg" class="error">{{ errorMsg }}</p>

        <button type="submit" class="btn-grand">Connexion</button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 80vh;
}

.login-box {
  background-color: #f9f9f9; /* Couleur "Campagne" ou similaire */
  padding: 30px;
  border: 1px solid darkblue;
  border-radius: 8px;
  text-align: center;
  width: 350px;
}

.form-group {
  margin-bottom: 15px;
  text-align: left;
}

input {
  width: 100%;
  padding: 5px;
  margin-top: 5px;
}

.btn-grand {
  background-color: darkblue;
  color: white;
  border: none;
  padding: 10px 20px;
  font-size: 1.1em;
  cursor: pointer;
  width: 100%;
}

.error {
  color: red;
  font-weight: bold;
}
</style>
