<script setup>
const props = defineProps({
  label: {
    type: String,
    default: '',
  },
  modelValue: {
    type: [String, Number],
    default: '',
  },
  type: {
    type: String,
    default: 'text',
  },
  placeholder: {
    type: String,
    default: '',
  },
  error: {
    type: String,
    default: '',
  },
  maxlength: {
    type: [String, Number],
    default: null,
  },
  inputmode: {
    type: String,
    default: 'text',
  },
  numericOnly: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['update:modelValue'])

const handleInput = (event) => {
  let value = event.target.value

  if (props.numericOnly) {
    value = value.replace(/\D/g, '')
    event.target.value = value
  }

  emit('update:modelValue', value)
}
</script>

<template>
  <div>
    <label v-if="label" class="mb-2 block text-sm font-semibold text-slate-700">
      {{ label }}
    </label>

    <input
      :type="type"
      :value="modelValue"
      :placeholder="placeholder"
      :maxlength="maxlength"
      :inputmode="inputmode"
      class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-500"
      :class="error ? 'border-red-400 focus:border-red-500' : ''"
      @input="handleInput"
    />

    <p v-if="error" class="mt-2 text-sm text-red-500">
      {{ error }}
    </p>
  </div>
</template>