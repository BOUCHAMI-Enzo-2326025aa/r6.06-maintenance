<script setup>
import {onMounted, ref} from 'vue'
import BaseTable from '../components/ui/BaseTable.vue'
import BaseModal from '../components/ui/BaseModal.vue'
import {
  createChampionnatFull,
  getOptionsSportsChampionnats,
  listChampionnats
} from '../services/championnatsApi'

const showModal = ref(false)
const headers = ['Nom', 'Sport', 'Lieu', 'Nb compétitions', 'Actions']
const championnats = ref([])

const error = ref(null)
const loading = ref(false)

const form = ref({
  nom: '',
  lieu: '',
  sportId: null,
  competitions: [
    {
      nom: '',
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

function resetForm() {
  form.value = {
    nom: '',
    lieu: '',
    sportId: null,
    competitions: [{nom: '', epreuves: [{nom: '', sports: []}]}]
  }
}

async function refreshList() {
  const rows = await listChampionnats()

  championnats.value = (rows || []).map((c) => ({
    id: c.id,
    // BaseTable attend col correspondantes aux headers, on fournit des champs déjà “display-friendly”
    nom: c.name,
    sport: c.sport?.name ?? '',
    lieu: c.lieu ?? '',
    nbCompetitions: c.competitions_count ?? 0
  }))
}

async function openCreate() {
  error.value = null
  resetForm()
  showModal.value = true
}

async function loadOptions() {
  const options = await getOptionsSportsChampionnats()
  listeSports.value = (options.sports || []).map((s) => ({id: s.id, nom: s.name}))
}

async function submitChampionnat() {
  error.value = null
  loading.value = true

  try {
    if (!form.value.sportId) throw new Error('Choisis un sport')
    if (!form.value.nom?.trim()) throw new Error('Nom du championnat obligatoire')

    // Validations front minimales (le back valide aussi)
    if (!Array.isArray(form.value.competitions) || form.value.competitions.length < 1) {
      throw new Error('Ajoute au moins une compétition')
    }

    form.value.competitions.forEach((c, idx) => {
      if (!c.nom?.trim()) throw new Error(`Nom de compétition obligatoire (ligne ${idx + 1})`)
      if (!Array.isArray(c.epreuves) || c.epreuves.length < 1) {
        throw new Error(`Ajoute au moins une épreuve dans la compétition ${idx + 1}`)
      }
      c.epreuves.forEach((e, eIdx) => {
        if (!e.nom?.trim()) throw new Error(`Nom d'épreuve obligatoire (comp ${idx + 1}, épreuve ${eIdx + 1})`)
      })
    })

    // Mapping vers payload backend
    const payload = {
      sport_id: form.value.sportId,
      name: form.value.nom,
      lieu: form.value.lieu,
      competitions: form.value.competitions.map((c) => ({
        name: c.nom,
        epreuves: c.epreuves.map((e) => ({
          name: e.nom,
          // V1: toutes individuelles (à étendre quand tu ajoutes team/relay sur le form)
          modes: ['individual']
        }))
      }))
    }

    await createChampionnatFull(payload)

    showModal.value = false
    await refreshList()
  } catch (e) {
    error.value = e?.message || 'Erreur lors de la création du championnat'
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  await loadOptions()
  await refreshList()
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
        <h4 class="text-xs font-black uppercase text-slate-400 mb-3 tracking-widest">Global</h4>
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

      <div
          v-for="(comp, cIdx) in form.competitions"
          :key="cIdx"
          class="p-5 border-2 border-blue-100 rounded-2xl bg-white shadow-sm space-y-4 relative"
      >
        <button
            v-if="form.competitions.length > 1"
            @click="removeCompetition(cIdx)"
            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs shadow-md"
        >
          ✕
        </button>

        <div class="flex justify-between items-end border-b pb-2">
          <div class="flex-1">
            <label class="block text-[10px] font-bold text-blue-900 uppercase italic">Compétition #{{
                cIdx + 1
              }}</label>
            <input
                v-model="comp.nom"
                type="text"
                placeholder="Nom de la compétition (ex: District)"
                class="w-full text-lg font-bold outline-none text-blue-900"
            />
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
                placeholder="Nom de l'épreuve (ex: Nage)"
                class="bg-transparent border-b border-blue-200 focus:border-blue-500 outline-none flex-1 text-sm font-semibold"
            />
            <button
                v-if="comp.epreuves.length > 1"
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
