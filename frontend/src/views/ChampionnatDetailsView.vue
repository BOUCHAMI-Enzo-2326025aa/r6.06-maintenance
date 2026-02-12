<script setup>
import {onMounted, ref} from 'vue'
import {useRoute, useRouter} from 'vue-router'
import {getChampionnat} from '../services/championnatsApi'

const route = useRoute()
const router = useRouter()

const championnat = ref(null)
const loading = ref(false)
const error = ref(null)

async function load() {
  loading.value = true
  error.value = null

  try {
    const id = route.params.id
    championnat.value = await getChampionnat(id)
  } catch (e) {
    error.value = e?.message || 'Erreur lors du chargement du championnat'
  } finally {
    loading.value = false
  }
}

onMounted(load)
</script>

<template>
  <div class="mb-6 flex items-center gap-3">
    <button
        class="text-xs font-bold text-blue-900 border border-blue-200 px-3 py-2 rounded-lg hover:bg-blue-50"
        @click="router.push('/championnats')"
    >
      ← Retour
    </button>

    <div>
      <h2 class="text-2xl font-extrabold text-blue-900">
        {{ championnat?.name || 'Championnat' }}
      </h2>
      <p class="text-sm text-slate-500">
        <span class="font-semibold">Sport:</span> {{ championnat?.sport?.name || '-' }}
        <span class="mx-2">•</span>
        <span class="font-semibold">Lieu:</span> {{ championnat?.lieu || '-' }}
      </p>
    </div>
  </div>

  <div v-if="loading" class="text-slate-500 italic">Chargement…</div>
  <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg text-sm">
    {{ error }}
  </div>

  <div v-else class="space-y-4">
    <div
        v-for="comp in (championnat?.competitions || [])"
        :key="comp.id"
        class="bg-white border border-slate-200 rounded-xl shadow-sm p-4"
    >
      <div class="flex items-center justify-between">
        <h3 class="text-lg font-black text-blue-900">{{ comp.name }}</h3>
        <span class="text-xs px-2 py-1 rounded-full bg-slate-100 text-slate-600 font-bold uppercase">
          {{ comp.status }}
        </span>
      </div>

      <ul class="mt-3 space-y-2">
        <li
            v-for="e in (comp.epreuves || [])"
            :key="e.id"
            class="flex items-center justify-between bg-slate-50 border border-slate-100 rounded-lg px-3 py-2"
        >
          <div>
            <div class="font-semibold text-slate-800">{{ e.name }}</div>
            <div class="text-xs text-slate-500">
              min équipe: {{ e.min_team_size }}
            </div>
          </div>

          <div class="flex flex-wrap gap-1 justify-end">
            <span
                v-for="m in (e.registration_modes || [])"
                :key="m.id"
                class="text-[10px] font-bold uppercase px-2 py-1 rounded-full bg-blue-900 text-white"
            >
              {{ m.mode }}
            </span>
          </div>
        </li>
      </ul>
    </div>

    <div v-if="(championnat?.competitions || []).length === 0" class="text-slate-500 italic">
      Aucune compétition pour ce championnat.
    </div>
  </div>
</template>
