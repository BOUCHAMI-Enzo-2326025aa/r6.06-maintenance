<script setup>
defineProps(['headers', 'rows'])
</script>

<template>
  <div
    class="mt-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
  >
    <table class="min-w-full divide-y divide-gray-300">
      <thead class="bg-blue-900 text-white">
        <tr>
          <th
            v-for="h in headers"
            :key="h"
            class="px-3 py-3.5 text-left text-sm font-semibold uppercase"
          >
            {{ h }}
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-for="(row, i) in rows" :key="i" class="hover:bg-gray-50">
          <td
            v-for="(cell, j) in row"
            :key="j"
            class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
          >
            {{ cell }}
          </td>
        </tr>
        <tr v-if="rows.length === 0">
          <td
            :colspan="headers.length"
            class="px-3 py-10 text-center italic text-gray-400"
          >
            Aucune donnée disponible
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
