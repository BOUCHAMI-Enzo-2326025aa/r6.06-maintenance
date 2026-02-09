<script setup>
import { ref } from 'vue'
import BaseTable from '../components/ui/BaseTable.vue'

const headers = ['Code', 'Libellé', 'Actions']
const sports = ref([])
</script>

<template>
  <div class="space-y-6">
    <div class="flex justify-between items-center">
      <h2
        class="text-2xl font-bold text-blue-900 underline decoration-yellow-400"
      >
        Liste des Sports
      </h2>
      <button class="bg-blue-800 text-white px-4 py-2 rounded shadow">
        + Ajouter un Sport
      </button>
    </div>

    <BaseTable :headers="headers" :rows="sports" />
  </div>
</template>
