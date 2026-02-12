<script setup>
import {onMounted, ref, computed} from 'vue'
import BaseTable from '../components/ui/BaseTable.vue'
import BaseModal from '../components/ui/BaseModal.vue'
import {createSport, listSports} from '../services/sportsApi'

const showModal = ref(false)
const headers = ['Nom Du Sport', 'Type Du Sport']
const allSports = ref([])
const form = ref({name: '', type: 'individuel'})
const error = ref(null)
const loading = ref(false)

// Filtrer les données pour afficher uniquement name et type
const sports = computed(() => {
  return allSports.value.map(sport => ({
    name: sport.name,
    type: sport.type
  }))
})

async function refresh() {
  allSports.value = await listSports()
}

const openAdd = () => {
  error.value = null
  form.value = {name: '', type: 'individuel'}
  showModal.value = true
}

async function submit() {
  error.value = null
  loading.value = true
  try {
    await createSport({name: form.value.name, type: form.value.type})
    showModal.value = false
    await refresh()
  } catch (e) {
    error.value = e?.message || 'Erreur lors de la création du sport'
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  await refresh()
})
</script>

<template>
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-blue-900">
      Catalogue des Sports
    </h2>
    <button @click="openAdd" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
      + Nouveau Sport
    </button>
  </div>

  <BaseTable :headers="headers" :rows="sports" />

  <BaseModal :show="showModal" title="Ajouter un Sport" @close="showModal = false">
    <div class="space-y-4">
      <div v-if="error" class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg text-sm">
        {{ error }}
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nom du sport</label>
        <input
          v-model="form.name"
          type="text"
          placeholder="Ex: Athlétisme"
          class="w-full border p-3 rounded-lg outline-none focus:ring-2 focus:ring-blue-500"
        >
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Type de sport</label>
        <select
          v-model="form.type"
          class="w-full border p-3 rounded-lg outline-none focus:ring-2 focus:ring-blue-500"
        >
          <option value="individuel">Individuel</option>
          <option value="equipe">Équipe</option>
          <option value="relais">Relais</option>
          <option value="individuel_equipe">Individuel/Équipe</option>
        </select>
      </div>

      <button
        :disabled="loading"
        @click="submit"
        class="w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition disabled:opacity-50"
      >
        Enregistrer le sport
      </button>
    </div>
  </BaseModal>
</template>