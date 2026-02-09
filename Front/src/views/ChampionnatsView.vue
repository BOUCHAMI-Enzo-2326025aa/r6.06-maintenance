<script setup>
import {onMounted, ref} from 'vue'
import BaseTable from '../components/ui/BaseTable.vue'
import BaseModal from '../components/ui/BaseModal.vue'
import {createChampionnat, getOptionsSportsChampionnats} from '../services/championnatsApi'

const showModal = ref(false)
const headers = ['Championnat', 'Lieu', 'Nb Compétitions', 'Actions']
const championnats = ref([])

const error = ref(null)
const loading = ref(false)

// --- LA STRUCTURE DE DONNÉES IMBRIQUÉE ---
const form = ref({
  nom: '',
  lieu: '',
  sportId: null,
  // Niveau 2 : Liste des Compétitions
  competitions: [
    {
      nom: '',
      // Niveau 3 : Liste des Épreuves par compétition
      epreuves: [{nom: '', sports: []}]
    }
  ]
})

// --- LOGIQUE POUR LES COMPÉTITIONS ---
const addCompetition = () => {
  form.value.competitions.push({nom: '', epreuves: [{nom: '', sports: []}]})
}
const removeCompetition = (cIdx) => {
  form.value.competitions.splice(cIdx, 1)
}

// --- LOGIQUE POUR LES ÉPREUVES ---
const addEpreuve = (cIdx) => {
  form.value.competitions[cIdx].epreuves.push({nom: '', sports: []})
}
const removeEpreuve = (cIdx, eIdx) => {
  form.value.competitions[cIdx].epreuves.splice(eIdx, 1)
}

// --- LOGIQUE POUR LES SPORTS (MULTI-SÉLECTION) ---
const addSportToEpreuve = (cIdx, eIdx, sportId) => {
  if (!sportId) return
  const epreuve = form.value.competitions[cIdx].epreuves[eIdx]
  const sportComplet = listeSports.value.find((s) => s.id === parseInt(sportId))

  // On ne l'ajoute que s'il n'y est pas déjà
  if (sportComplet && !epreuve.sports.find((s) => s.id === sportComplet.id)) {
    epreuve.sports.push(sportComplet)
  }
}
const removeSportFromEpreuve = (cIdx, eIdx, sIdx) => {
  form.value.competitions[cIdx].epreuves[eIdx].sports.splice(sIdx, 1)
}

const listeSports = ref([])
const listeCompetitionsExistantes = ref(['Inter-Régional', 'Départemental'])

function resetForm() {
  form.value = {
    nom: '',
    lieu: '',
    sportId: null,
    competitions: [{nom: '', epreuves: [{nom: '', sports: []}]}]
  }
}

async function openCreate() {
  error.value = null
  resetForm()
  showModal.value = true
}

async function loadOptions() {
  const options = await getOptionsSportsChampionnats()
  // Le front attend {id, nom}. Le back renvoie {id, name}.
  // On normalise ici, sans changer le back.
  listeSports.value = (options.sports || []).map((s) => ({id: s.id, nom: s.name}))
}

async function submitChampionnat() {
  error.value = null
  loading.value = true
  try {
    if (!form.value.sportId) throw new Error('Choisis un sport')
    if (!form.value.nom?.trim()) throw new Error('Nom du championnat obligatoire')

    // V1: crée seulement le championnat (les compétitions/épreuves seront branchées ensuite)
    await createChampionnat({sportId: form.value.sportId, name: form.value.nom})

    showModal.value = false
  } catch (e) {
    error.value = e?.message || 'Erreur lors de la création du championnat'
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  await loadOptions()
})
</script>

<template>
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-blue-900">Championnats</h2>
    <button
        @click="openCreate"
        class="bg-blue-800 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700 font-bold transition"
    >
      + Créer un Championnat
    </button>
  </div>

  <BaseTable :headers="headers" :rows="championnats"/>

  <BaseModal
      :show="showModal"
      title="Configuration Championnat"
      @close="showModal = false"
  >
    <div class="space-y-6 max-h-[75vh] overflow-y-auto pr-2 custom-scrollbar">
      <div v-if="error" class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg text-sm">
        {{ error }}
      </div>

      <section class="p-4 bg-slate-50 rounded-xl border-2 border-slate-200">
        <h4 class="text-xs font-black uppercase text-slate-400 mb-3 tracking-widest">
          Global
        </h4>
        <div class="space-y-3">
          <select v-model="form.sportId" class="w-full border p-2 rounded-lg">
            <option :value="null">Sélectionner un sport...</option>
            <option v-for="s in listeSports" :key="s.id" :value="s.id">
              {{ s.nom }}
            </option>
          </select>

          <input
              v-model="form.nom"
              type="text"
              placeholder="Nom du Championnat"
              class="w-full border p-2 rounded-lg font-bold"
          />
          <input
              v-model="form.lieu"
              type="text"
              placeholder="Lieu/Ville"
              class="w-full border p-2 rounded-lg"
          />
        </div>
      </section>

      <button
          @click="submitChampionnat"
          :disabled="loading"
          class="w-full bg-blue-900 text-white py-4 rounded-xl font-black uppercase tracking-widest hover:bg-green-600 sticky bottom-0 shadow-2xl transition-all disabled:opacity-50"
      >
        Enregistrer le Championnat complet
      </button>
    </div>
  </BaseModal>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #1e3a8a;
  border-radius: 10px;
}
</style>
