<script setup>
import BaseButton from '../base/BaseButton.vue'

defineProps({
  message: {
    type: String,
    default: 'La ficha fue registrada correctamente.',
  },
})

const emit = defineEmits(['restart'])
</script>

<template>
  <section class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200 sm:p-10">
    <div class="mx-auto max-w-3xl text-center">
      <div
        class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 text-emerald-600"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-10 w-10"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
      </div>

      <h2 class="mt-6 text-3xl font-bold text-slate-900 sm:text-4xl">
        Registro exitoso
      </h2>

      <p class="mt-4 text-base leading-7 text-slate-600 sm:text-lg">
        {{ message }}
      </p>

      <div class="mt-8 rounded-3xl bg-slate-50 p-6 text-left text-sm text-slate-600">
        <p class="font-semibold text-slate-800">Se registró la ficha correctamente.</p>
        <p class="mt-2">
          La información ha sido enviada al sistema. Si necesita registrar otra ficha,
          puede hacerlo usando el botón que aparece a continuación.
        </p>
      </div>

      <div class="mt-8 flex justify-center">
        <BaseButton @click="emit('restart')">
          Registrar otra ficha
        </BaseButton>
      </div>
    </div>
  </section>
</template>