<script setup>
defineProps({
  type: {
    type: String,
    default: 'button',
  },
  variant: {
    type: String,
    default: 'primary',
  },
  fullWidth: {
    type: Boolean,
    default: false,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
})
</script>

<template>
  <button
    :type="type"
    :disabled="disabled"
    :class="[
      'rounded-2xl px-5 py-3 text-sm font-semibold transition duration-200',
      fullWidth ? 'w-full' : '',
      disabled
        ? 'cursor-not-allowed opacity-60'
        : '',
      variant === 'primary'
        ? 'bg-slate-900 text-white shadow-lg hover:-translate-y-0.5'
        : 'border border-slate-300 bg-white text-slate-700 shadow-sm hover:bg-slate-50'
    ]"
  >
    <slot />
  </button>
</template>