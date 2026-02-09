<script setup>
import {onMounted, ref} from 'vue'
import BaseTable from '../components/ui/BaseTable.vue'
import BaseModal from '../components/ui/BaseModal.vue'
import {createSport, listSports} from '../services/sportsApi'

const showModal = ref(false)
const headers = ['Nom', 'Actions']
const sports = ref([])

const form = ref({name: ''})
const error = ref(null)
const loading = ref(false)

async function refresh() {
  sports.value = await listSports()
}

const openAdd = () => {
  error.value = null
  form.value = {name: ''}
  showModal.value = true
}

async function submit() {
  error.value = null
  loading.value = true
  try {
    await createSport({name: form.value.name})
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
    <h2 class="text-2xl font-bold text-blue-900">Catalogue des Sports</h2>
    <button
        @click="openAdd"
        class="bg-blue-800 text-white px-4 py-2 rounded-lg hover:bg-blue-700 shadow"
    >
      + Nouveau Sport
    </button>
  </div>

  <BaseTable :headers="headers" :rows="sports"/>

  <BaseModal
      :show="showModal"
      title="Ajouter un Sport"
      @close="showModal = false"
  >
    <div class="space-y-4">
      <div v-if="error" class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg text-sm">
        {{ error }}
      </div>

      <input
          v-model="form.name"
          type="text"
          placeholder="Nom (ex: Athlétisme)"
          class="w-full border p-3 rounded-lg outline-none focus:ring-2 focus:ring-blue-500"
      />

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
