<script setup>
defineProps({
  title: {
    type: String,
    default: '',
  },
  description: {
    type: String,
    default: '',
  },
})
</script>

<template>
  <section class="rounded-[2rem] bg-white p-6 shadow-xl ring-1 ring-slate-200 sm:p-8">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-slate-900">
        {{ title }}
      </h2>
      <p v-if="description" class="mt-2 text-sm leading-6 text-slate-600">
        {{ description }}
      </p>
    </div>

    <slot />
  </section>
</template>