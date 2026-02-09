<template>
  <div class="min-h-screen bg-slate-50 font-sans text-slate-900">
    <nav class="bg-blue-900 text-white shadow-lg p-4">
      <div class="max-w-7xl mx-auto flex gap-8 items-center">
        <h1 class="text-xl font-bold border-r pr-6 border-white/20">
          UGSEL Admin
        </h1>
        <div class="flex gap-6">
          <RouterLink
            to="/sports"
            class="hover:text-yellow-400 font-medium transition"
            >Sports</RouterLink
          >
          <RouterLink
            to="/epreuves"
            class="hover:text-yellow-400 font-medium transition"
            >Épreuves</RouterLink
          >
          <RouterLink
            to="/tournois"
            class="hover:text-yellow-400 font-medium transition"
            >Tournois</RouterLink
          >
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto p-6 text-slate-800">
      <RouterView />
    </main>
  </div>
</template>

<style>
/* Style pour indiquer le lien actif */
</style>
