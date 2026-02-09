<script setup>
import { ref } from 'vue'
import BaseTable from '../components/ui/BaseTable.vue'
import BaseModal from '../components/ui/BaseModal.vue'

// Colonnes pour les tournois
const headers = ['Nom', 'Sport', 'Date', 'Lieu', 'Actions']
const tournois = ref([]) // Le front attend les données ici
const showModal = ref(false)

// Objet pour le formulaire (Création ou Edition)
const form = ref({ nom: '', sport: '', date: '', lieu: '' })

const openCreate = () => {
  form.value = { nom: '', sport: '', date: '', lieu: '' }
  showModal.value = true
}

const handleEdit = (item) => {
  form.value = { ...item }
  showModal.value = true
}

const handleDelete = (id) => {
  confirm('Supprimer ce tournoi ?')
}
</script>

<template>
  <div class="space-y-6">
    <div class="flex justify-between items-center">
      <h2
        class="text-2xl font-bold text-blue-900 underline decoration-yellow-400"
      >
        Gestion des Tournois
      </h2>
      <button
        @click="openCreate"
        class="bg-blue-800 text-white px-4 py-2 rounded shadow hover:bg-blue-700"
      >
        + Créer un Tournoi
      </button>
    </div>

    <BaseTable :headers="headers" :rows="tournois"> </BaseTable>

    <BaseModal
      :show="showModal"
      title="Détails du Tournoi"
      @close="showModal = false"
    >
      <form class="space-y-4">
        <div>
          <label class="block text-sm font-bold mb-1">Nom du tournoi</label>
          <input
            v-model="form.nom"
            type="text"
            class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 outline-none"
          />
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-bold mb-1">Sport</label>
            <select
              v-model="form.sport"
              class="w-full border p-2 rounded bg-white"
            >
              <option value="">Choisir un sport...</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-bold mb-1">Date</label>
            <input
              v-model="form.date"
              type="date"
              class="w-full border p-2 rounded"
            />
          </div>
        </div>
        <div>
          <label class="block text-sm font-bold mb-1">Lieu</label>
          <input
            v-model="form.lieu"
            type="text"
            class="w-full border p-2 rounded"
          />
        </div>
        <div class="flex justify-end gap-2 pt-4">
          <button
            type="button"
            @click="showModal = false"
            class="px-4 py-2 border rounded"
          >
            Annuler
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-green-600 text-white rounded"
          >
            Enregistrer
          </button>
        </div>
      </form>
    </BaseModal>
  </div>
</template>
