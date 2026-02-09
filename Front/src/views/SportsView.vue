<script setup>
import { ref } from 'vue'
import BaseTable from '../components/ui/BaseTable.vue'
import BaseModal from '../components/ui/BaseModal.vue'

const showModal = ref(false)
const headers = ['Code', 'Libellé', 'Actions']
const sports = ref([]) // Tes données viendront ici

const openAdd = () => {
  showModal.value = true
}
</script>

<template>
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-blue-900">
      Catalogue des Sports
    </h2>
    <button
      @click="openAdd"
    >
      + Nouveau Sport
    </button>
  </div>

  <BaseTable 
    :headers="headers" 
    :rows="sports" 
  />

  <BaseModal
    :show="showModal"
    title="Ajouter un Sport"
    @close="showModal = false"
  >
    <div class="space-y-4">
      <input
        type="text"
        placeholder="Code (ex: ATHLE)"
        class="w-full border p-3 rounded-lg outline-none focus:ring-2 focus:ring-blue-500"
      >
      <input
        type="text"
        placeholder="Nom complet (ex: Athlétisme)"
        class="w-full border p-3 rounded-lg outline-none focus:ring-2 focus:ring-blue-500"
      >
      <button
        class="w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition"
      >
        Enregistrer le sport
      </button>
    </div>
  </BaseModal>
</template>
