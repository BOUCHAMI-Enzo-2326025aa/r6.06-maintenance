<template>
  <div class="min-h-screen bg-slate-50 font-sans text-slate-900">
    <nav class="bg-blue-900 text-white shadow-lg p-4">
      <div class="max-w-7xl mx-auto flex gap-8 items-center">
        <h1
          class="text-xl font-bold border-r pr-6 border-white/20 tracking-tight"
        >
          UGSEL <span class="text-yellow-400">CHAMPIONNATS</span>
        </h1>
        <div class="flex gap-6">
          <RouterLink to="/championnats" class="nav-item"
            >Championnats</RouterLink
          >
          <RouterLink to="/sports" class="nav-item">Sports</RouterLink>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto p-6">
      <RouterView />
    </main>
  </div>
</template>

<style scoped>
/*
.nav-item {
  @apply hover:text-yellow-400 font-medium transition-all py-2 border-b-2 border-transparent;
}
.router-link-active {
  @apply text-yellow-400 border-yellow-400;
}*/
</style>
