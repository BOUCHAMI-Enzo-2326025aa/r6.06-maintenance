<script setup>
defineProps({
  show: { type: Boolean, default: false },
  title: { type: String, default: 'Formulaire' }
})
defineEmits(['close'])
</script>

<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
  >
    <div
      class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
      @click="$emit('close')"
    />

    <div
      class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200"
    >
      <div
        class="bg-blue-900 px-6 py-4 flex justify-between items-center text-white"
      >
        <h3 class="font-bold text-lg">
          {{ title }}
        </h3>
        <button
          class="hover:text-yellow-400 text-2xl leading-none"
          @click="$emit('close')"
        >
          &times;
        </button>
      </div>

      <div class="p-6">
        <slot />
      </div>
    </div>
  </div>
</template>
