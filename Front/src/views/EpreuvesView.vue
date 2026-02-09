<script setup>
import { ref } from 'vue'
import BaseTable from '../components/ui/BaseTable.vue'
import BaseModal from '../components/ui/BaseModal.vue'

const showModal = ref(false)
const headers = ['Code', 'Libellé', 'Sport', 'Actions']
const rows = ref([])
</script>

<template>
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-blue-900">Gestion des Épreuves</h2>
    <button
      @click="showModal = true"
      class="bg-blue-800 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow"
    >
      + Nouvelle Épreuve
    </button>
  </div>
  <BaseTable :headers="headers" :rows="rows" />

  <BaseModal
    :show="showModal"
    title="Ajouter une Épreuve"
    @close="showModal = false"
  >
    <div class="space-y-4 text-slate-700">
      <select class="w-full border p-2 rounded bg-white">
        <option value="">Sélectionner un Sport</option>
      </select>
      <input
        type="text"
        placeholder="Code épreuve"
        class="w-full border p-2 rounded"
      />
      <input
        type="text"
        placeholder="Nom de l'épreuve"
        class="w-full border p-2 rounded"
      />
      <button
        class="w-full bg-green-600 text-white py-2 rounded font-bold hover:bg-green-700"
      >
        Enregistrer
      </button>
    </div>
  </BaseModal>
</template>
