<script setup>
defineProps({
  headers: { type: Array, required: true },
  rows: { type: Array, default: () => [] }
})
</script>

<template>
  <div
    class="w-full overflow-hidden rounded-xl border border-slate-200 shadow-sm bg-white"
  >
    <table class="w-full border-collapse text-left text-sm">
      <thead class="bg-slate-50 border-b border-slate-200">
        <tr>
          <th
            v-for="h in headers"
            :key="h"
            class="px-6 py-4 font-bold text-slate-700 uppercase tracking-wider text-xs"
          >
            {{ h }}
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        <tr
          v-for="(row, i) in rows"
          :key="i"
          class="hover:bg-blue-50/50 transition-colors"
        >
          <td
            v-for="(cell, j) in row"
            :key="j"
            class="px-6 py-4 text-slate-600"
          >
            {{ cell }}
          </td>
        </tr>

        <tr v-if="rows.length === 0">
          <td
            :colspan="headers.length"
            class="px-6 py-12 text-center text-slate-400 italic"
          >
            Aucune donnée enregistrée pour le moment.
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
