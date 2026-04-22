<script setup>
import BaseInput from '../../base/BaseInput.vue'
import BaseSelect from '../../base/BaseSelect.vue'

const toUpper = (value) => value?.toUpperCase() || ''

defineProps({
  form: {
    type: Object,
    required: true,
  },
  errors: {
    type: Object,
    default: () => ({}),
  },
  sexOptions: {
    type: Array,
    default: () => [],
  },
  maritalStatusOptions: {
    type: Array,
    default: () => [],
  },
})
</script>

<template>
  <div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
      <BaseInput
        :modelValue="form.full_name"
        @update:modelValue="form.full_name = toUpper($event)"
        label="Apellidos y nombres"
        placeholder="Ingrese sus apellidos y nombres"
        :error="errors.full_name"
      />
    </div>

    <BaseInput
      v-model="form.dni"
      label="DNI"
      placeholder="12345678"
      :error="errors.dni"
    />

    <BaseInput
      v-model="form.ruc"
      label="RUC"
      placeholder="Ingrese su RUC"
      :error="errors.ruc"
    />

    <BaseSelect
      v-model="form.sex_id"
      label="Sexo"
      :options="sexOptions"
      placeholder="Seleccione el sexo"
      :error="errors.sex_id"
    />

    <BaseSelect
      v-model="form.marital_status_id"
      label="Estado civil"
      :options="maritalStatusOptions"
      placeholder="Seleccione el estado civil"
      :error="errors.marital_status_id"
    />

    <BaseInput
      v-model="form.birth_date"
      type="date"
      label="Fecha de nacimiento"
      :error="errors.birth_date"
    />

    <BaseInput
      :modelValue="form.birth_place"
      @update:modelValue="form.birth_place = toUpper($event)"
      label="Lugar de nacimiento"
      placeholder="Ingrese el lugar de nacimiento"
      :error="errors.birth_place"
    />

    <BaseSelect
      v-model="form.has_disability"
      label="¿Tiene alguna discapacidad?"
      :options="[
        { id: true, name: 'Sí' },
        { id: false, name: 'No' }
      ]"
      placeholder="Seleccione una opción"
      :error="errors.has_disability"
    />

    <BaseInput
      v-if="form.has_disability === true"
      :modelValue="form.conadis_rui"
      @update:modelValue="form.conadis_rui = toUpper($event)"
      label="CONADIS RUI"
      placeholder="Ingrese el código CONADIS"
      :error="errors.conadis_rui"
    />
  </div>
</template>