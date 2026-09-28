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
  laborRegimeOptions: {
    type: Array,
    default: () => [],
  },
  pensionRegimeOptions: {
    type: Array,
    default: () => [],
  },
  dependencyOptions: {
    type: Array,
    default: () => [],
  },
})

const academicEducationOptions = [
  { id: 'TITULO UNIVERSITARIO', name: 'TÍTULO UNIVERSITARIO' },
  { id: 'BACHILLER', name: 'BACHILLER' },
  { id: 'EGRESADO UNIVERSITARIO', name: 'EGRESADO UNIVERSITARIO' },
  { id: 'TITULADO TECNICO', name: 'TITULADO TÉCNICO' },
  { id: 'EGRESADO TECNICO', name: 'EGRESADO TÉCNICO' },
  { id: 'ESTUDIANTE', name: 'ESTUDIANTE' },
  { id: 'INCONCLUSO', name: 'INCONCLUSO' },
]
</script>

<template>
  <div class="grid gap-5 md:grid-cols-2">
    <BaseSelect
      v-model="form.academic_education"
      label="Formación académica"
      :options="academicEducationOptions"
      placeholder="Seleccione la formación académica"
      :error="errors.academic_education"
    />

    <BaseInput
      :modelValue="form.profession"
      @update:modelValue="form.profession = toUpper($event)"
      label="Profesión"
      placeholder="Ingrese su profesión"
      :error="errors.profession"
    />

    <BaseInput
      :modelValue="form.current_position"
      @update:modelValue="form.current_position = toUpper($event)"
      label="Cargo actual"
      placeholder="Ingrese su cargo actual"
      :error="errors.current_position"
    />

      <BaseSelect
        v-model="form.dependency_id"
        label="Dependencia actual"
        :options="dependencyOptions"
        placeholder="Seleccione la dependencia actual"
        :error="errors.dependency_id"
      />

    <BaseInput
      :modelValue="form.contract_resolution_number"
      @update:modelValue="form.contract_resolution_number = toUpper($event)"
      label="Contrato o Resolución N°"
      placeholder="Ingrese el contrato o resolución"
      :error="errors.contract_resolution_number"
    />

    <BaseInput
      v-model="form.employment_start_date"
      type="date"
      label="Fecha de vínculo"
      :error="errors.employment_start_date"
    />

    <BaseSelect
      v-model="form.labor_regime_id"
      label="Régimen laboral"
      :options="laborRegimeOptions"
      placeholder="Seleccione el régimen laboral"
      :error="errors.labor_regime_id"
    />

    <BaseInput
      :modelValue="form.labor_condition"
      @update:modelValue="form.labor_condition = toUpper($event)"
      label="Condición laboral"
      placeholder="Ingrese la condición laboral"
      :error="errors.labor_condition"
    />

    <BaseSelect
      v-model="form.pension_regime_id"
      label="Régimen pensionario"
      :options="pensionRegimeOptions"
      placeholder="Seleccione el régimen pensionario"
      :error="errors.pension_regime_id"
    />

    <BaseInput
      :modelValue="form.airshsp_code"
      @update:modelValue="form.airshsp_code = toUpper($event)"
      label="Código AIRSHSP"
      placeholder="Ingrese el código"
      :error="errors.airshsp_code"
    />

    <BaseInput
      :modelValue="form.institutional_email"
      @update:modelValue="form.institutional_email = toUpper($event)"
      type="email"
      label="Correo institucional"
      placeholder="usuario@institucion.gob.pe"
      :error="errors.institutional_email"
    />

    <BaseSelect
      v-model="form.has_labor_link"
      label="¿Tiene vínculo laboral?"
      :options="[
        { id: true, name: 'Sí tiene' },
        { id: false, name: 'No tiene' }
      ]"
      placeholder="Seleccione una opción"
      :error="errors.has_labor_link"
    />

    <BaseInput
      v-if="form.has_labor_link === false"
      v-model="form.labor_end_date"
      type="date"
      label="Fecha de fin de vínculo"
      :error="errors.labor_end_date"
    />
  </div>
</template>