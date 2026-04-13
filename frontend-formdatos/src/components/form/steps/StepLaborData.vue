<script setup>
import BaseInput from '../../base/BaseInput.vue'
import BaseSelect from '../../base/BaseSelect.vue'

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
})
</script>

<template>
  <div class="grid gap-5 md:grid-cols-2">
    <BaseInput
      v-model="form.profession"
      label="Profesión"
      placeholder="Ingrese su profesión"
      :error="errors.profession"
    />

    <BaseInput
      v-model="form.current_position"
      label="Cargo actual"
      placeholder="Ingrese su cargo actual"
      :error="errors.current_position"
    />

    <div class="md:col-span-2">
      <BaseInput
        v-model="form.current_dependency"
        label="Dependencia actual"
        placeholder="Ingrese su dependencia actual"
        :error="errors.current_dependency"
      />
    </div>

    <BaseInput
      v-model="form.contract_resolution_number"
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
      v-model="form.labor_condition"
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
      v-model="form.airshsp_code"
      label="Código AIRSHSP"
      placeholder="Ingrese el código"
      :error="errors.airshsp_code"
    />

    <BaseInput
      v-model="form.institutional_email"
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