<script setup>
defineProps({
  label: {
    type: String,
    default: '',
  },
  modelValue: {
    type: [String, Number, Boolean, null],
    default: '',
  },
  options: {
    type: Array,
    default: () => [],
  },
  placeholder: {
    type: String,
    default: 'Seleccione una opción',
  },
  error: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['update:modelValue'])

const handleChange = (event) => {
  const value = event.target.value

  if (value === 'true') {
    emit('update:modelValue', true)
    return
  }

  if (value === 'false') {
    emit('update:modelValue', false)
    return
  }

  emit('update:modelValue', value)
}
</script>

<template>
  <div>
    <label v-if="label" class="mb-2 block text-sm font-semibold text-slate-700">
      {{ label }}
    </label>

    <select
      :value="modelValue"
      class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-500"
      :class="error ? 'border-red-400 focus:border-red-500' : ''"
      @change="handleChange"
    >
      <option value="">{{ placeholder }}</option>

      <option
        v-for="option in options"
        :key="option.id"
        :value="option.id"
      >
        {{ option.name }}
      </option>
    </select>

    <p v-if="error" class="mt-2 text-sm text-red-500">
      {{ error }}
    </p>
  </div>
</template>