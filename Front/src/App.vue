<template>
  <div
    class="min-h-screen bg-blue-900 flex flex-col items-center justify-center p-6 font-sans"
  >
    <div
      class="bg-white p-10 rounded-3xl shadow-2xl text-center max-w-lg border-t-8 border-yellow-400"
    >
      <h1 class="text-4xl font-extrabold text-blue-900 mb-2">UGSEL WEB</h1>
      <p class="text-gray-500 font-medium mb-8">
        Refactoring Vue.js + Tailwind
      </p>

      <div class="space-y-4">
        <div
          class="p-4 bg-green-100 text-green-700 rounded-lg font-bold border border-green-200"
        >
          ✅ Si ce bandeau est vert, Tailwind fonctionne !
        </div>

        <button
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition duration-300 transform hover:scale-105 shadow-md"
        >
          Bouton stylé
        </button>
      </div>
    </div>

    <p class="mt-6 text-blue-300 text-sm italic animate-pulse">
      Vite tourne parfaitement.
    </p>
  </div>
</template>

<script setup>
// Rien ici pour le moment, on teste juste le visuel
</script>
