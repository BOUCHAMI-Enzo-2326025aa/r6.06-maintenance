<script setup>
import { ref } from 'vue'
import BaseTable from '../components/ui/BaseTable.vue'
import BaseModal from '../components/ui/BaseModal.vue'

const showModal = ref(false)
const headers = ['Championnat', 'Lieu', 'Nb Compétitions', 'Actions']
const championnats = ref([])

// --- LA STRUCTURE DE DONNÉES IMBRIQUÉE ---
const form = ref({
  nom: '',
  lieu: '',
  // Niveau 2 : Liste des Compétitions
  competitions: [
    {
      nom: '',
      // Niveau 3 : Liste des Épreuves par compétition
      epreuves: [
        { nom: '', sports: [] } // Niveau 4 : Liste des Sports par épreuve
      ]
    }
  ]
})

// --- LOGIQUE POUR LES COMPÉTITIONS ---
const addCompetition = () => {
  form.value.competitions.push({ nom: '', epreuves: [{ nom: '', sports: [] }] })
}
const removeCompetition = (cIdx) => {
  form.value.competitions.splice(cIdx, 1)
}

// --- LOGIQUE POUR LES ÉPREUVES ---
const addEpreuve = (cIdx) => {
  form.value.competitions[cIdx].epreuves.push({ nom: '', sports: [] })
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

// Simulation pour les menus déroulants
const listeSports = ref([
  { id: 1, nom: 'Natation' },
  { id: 2, nom: 'Judo' },
  { id: 3, nom: 'Cyclisme' },
  { id: 4, nom: 'Cross' }
])
const listeCompetitionsExistantes = ref(['Inter-Régional', 'Départemental'])
</script>

<template>
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-blue-900">Championnats</h2>
    <button
      @click="showModal = true"
      class="bg-blue-800 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700 font-bold transition"
    >
      + Créer un Championnat
    </button>
  </div>

  <BaseTable :headers="headers" :rows="championnats" />

  <BaseModal
    :show="showModal"
    title="Configuration Championnat"
    @close="showModal = false"
  >
    <div class="space-y-6 max-h-[75vh] overflow-y-auto pr-2 custom-scrollbar">
      <section class="p-4 bg-slate-50 rounded-xl border-2 border-slate-200">
        <h4
          class="text-xs font-black uppercase text-slate-400 mb-3 tracking-widest"
        >
          Global
        </h4>
        <div class="space-y-3">
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

      <div
        v-for="(comp, cIdx) in form.competitions"
        :key="cIdx"
        class="p-5 border-2 border-blue-100 rounded-2xl bg-white shadow-sm space-y-4 relative"
      >
        <button
          @click="removeCompetition(cIdx)"
          class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs shadow-md"
        >
          ✕
        </button>

        <div class="flex justify-between items-end border-b pb-2">
          <div class="flex-1">
            <label
              class="block text-[10px] font-bold text-blue-900 uppercase italic"
              >Compétition #{{ cIdx + 1 }}</label
            >
            <input
              v-model="comp.nom"
              type="text"
              placeholder="Nom de la compétition (ex: Elite)"
              class="w-full text-lg font-bold outline-none text-blue-900"
            />
            <select class="text-xs border rounded p-1 bg-slate-50">
              <option>Sélectionner existante...</option>
              <option v-for="c in listeCompetitionsExistantes" :key="c">
                {{ c }}
              </option>
            </select>
          </div>
          <button
            @click="addEpreuve(cIdx)"
            class="text-[10px] bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition"
          >
            + ÉPREUVE
          </button>
        </div>

        <div
          v-for="(epreuve, eIdx) in comp.epreuves"
          :key="eIdx"
          class="ml-4 p-4 bg-blue-50/30 rounded-xl border border-blue-100 space-y-3"
        >
          <div class="flex justify-between items-center">
            <input
              v-model="epreuve.nom"
              type="text"
              placeholder="Nom de l'épreuve (ex: Finale)"
              class="bg-transparent border-b border-blue-200 focus:border-blue-500 outline-none flex-1 text-sm font-semibold"
            />
            <button
              @click="removeEpreuve(cIdx, eIdx)"
              class="text-red-400 ml-2"
            >
              ✕
            </button>
          </div>

          <div class="space-y-2">
            <div class="flex flex-wrap gap-2">
              <span
                v-for="(s, sIdx) in epreuve.sports"
                :key="sIdx"
                class="bg-blue-900 text-white text-[10px] px-2 py-1 rounded-full flex items-center gap-2 font-bold uppercase"
              >
                {{ s.nom }}
                <button
                  @click="removeSportFromEpreuve(cIdx, eIdx, sIdx)"
                  class="hover:text-yellow-400"
                >
                  ✕
                </button>
              </span>
            </div>

            <select
              @change="(e) => addSportToEpreuve(cIdx, eIdx, e.target.value)"
              class="w-full text-xs border rounded p-1.5 bg-white"
            >
              <option value="">+ Ajouter un sport à cette épreuve...</option>
              <option v-for="s in listeSports" :key="s.id" :value="s.id">
                {{ s.nom }}
              </option>
            </select>
          </div>
        </div>
      </div>

      <button
        @click="addCompetition"
        class="w-full border-2 border-dashed border-slate-300 py-3 rounded-xl text-slate-400 font-bold hover:bg-white hover:border-blue-300 hover:text-blue-500 transition"
      >
        + AJOUTER UNE COMPÉTITION
      </button>

      <button
        class="w-full bg-blue-900 text-white py-4 rounded-xl font-black uppercase tracking-widest hover:bg-green-600 sticky bottom-0 shadow-2xl transition-all"
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
