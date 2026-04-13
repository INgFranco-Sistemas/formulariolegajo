<script setup>
defineProps({
  steps: {
    type: Array,
    default: () => [],
  },
  currentStep: {
    type: Number,
    default: 1,
  },
})
</script>

<template>
  <div class="rounded-[2rem] bg-white p-5 shadow-sm ring-1 ring-slate-200">
    <div class="grid gap-4 md:grid-cols-5">
      <div
        v-for="step in steps"
        :key="step.id"
        class="rounded-2xl border px-4 py-3 text-sm transition"
        :class="
          currentStep === step.id
            ? 'border-slate-900 bg-slate-900 text-white'
            : currentStep > step.id
              ? 'border-slate-300 bg-slate-100 text-slate-700'
              : 'border-slate-200 bg-white text-slate-500'
        "
      >
        <p class="text-xs font-semibold uppercase tracking-wide">
          Paso {{ step.id }}
        </p>
        <p class="mt-1 font-semibold">
          {{ step.label }}
        </p>
      </div>
    </div>
  </div>
</template>