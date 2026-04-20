<script setup>
defineProps({
  form: {
    type: Object,
    required: true,
  },
  sexOptions: {
    type: Array,
    default: () => [],
  },
  maritalStatusOptions: {
    type: Array,
    default: () => [],
  },
  laborRegimeOptions: {
    type: Array,
    default: () => [],
  },
  pensionRegimeOptions: {
    type: Array,
    default: () => [],
  },
  relationshipOptions: {
    type: Array,
    default: () => [],
  },
  dependencyOptions: {
    type: Array,
    default: () => [],
  },
})

const findOptionName = (options, value) => {
  const option = options.find((item) => String(item.id) === String(value))
  return option ? option.name : '-'
}
</script>

<template>
  <div class="space-y-8">
    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
      <h3 class="text-lg font-bold text-slate-900">Resumen del registro</h3>
      <p class="mt-2 text-sm text-slate-600">
        Revise cuidadosamente la información antes de enviar el formulario.
      </p>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
      <div class="rounded-3xl border border-slate-200 bg-white p-6">
        <h4 class="mb-4 text-lg font-bold text-slate-900">Datos personales</h4>
        <div class="space-y-2 text-sm text-slate-700">
          <p><span class="font-semibold">Apellidos y nombres:</span> {{ form.full_name || '-' }}</p>
          <p><span class="font-semibold">DNI:</span> {{ form.dni || '-' }}</p>
          <p><span class="font-semibold">RUC:</span> {{ form.ruc || '-' }}</p>
          <p><span class="font-semibold">Sexo:</span> {{ findOptionName(sexOptions, form.sex_id) }}</p>
          <p><span class="font-semibold">Estado civil:</span> {{ findOptionName(maritalStatusOptions, form.marital_status_id) }}</p>
          <p><span class="font-semibold">Fecha de nacimiento:</span> {{ form.birth_date || '-' }}</p>
          <p><span class="font-semibold">Lugar de nacimiento:</span> {{ form.birth_place || '-' }}</p>
        </div>
      </div>

      <div class="rounded-3xl border border-slate-200 bg-white p-6">
        <h4 class="mb-4 text-lg font-bold text-slate-900">Domicilio y contacto</h4>
        <div class="space-y-2 text-sm text-slate-700">
          <p><span class="font-semibold">Dirección:</span> {{ form.address || '-' }}</p>
          <p><span class="font-semibold">Referencia:</span> {{ form.reference || '-' }}</p>
          <p><span class="font-semibold">Distrito:</span> {{ form.district || '-' }}</p>
          <p><span class="font-semibold">Provincia:</span> {{ form.province || '-' }}</p>
          <p><span class="font-semibold">Departamento:</span> {{ form.department || '-' }}</p>
          <p><span class="font-semibold">Celular:</span> {{ form.cellphone || '-' }}</p>
          <p><span class="font-semibold">Correo personal:</span> {{ form.personal_email || '-' }}</p>
        </div>
      </div>

      <div class="rounded-3xl border border-slate-200 bg-white p-6">
        <h4 class="mb-4 text-lg font-bold text-slate-900">Datos laborales</h4>
        <div class="space-y-2 text-sm text-slate-700">
          <p><span class="font-semibold">Profesión:</span> {{ form.profession || '-' }}</p>
          <p><span class="font-semibold">Cargo actual:</span> {{ form.current_position || '-' }}</p>
          <p><span class="font-semibold">Dependencia:</span> {{ findOptionName(dependencyOptions, form.dependency_id) }}</p>
          <p><span class="font-semibold">Contrato/Resolución:</span> {{ form.contract_resolution_number || '-' }}</p>
          <p><span class="font-semibold">Fecha de vínculo:</span> {{ form.employment_start_date || '-' }}</p>
          <p><span class="font-semibold">Régimen laboral:</span> {{ findOptionName(laborRegimeOptions, form.labor_regime_id) }}</p>
          <p><span class="font-semibold">Régimen pensionario:</span> {{ findOptionName(pensionRegimeOptions, form.pension_regime_id) }}</p>
        </div>
      </div>

      <div class="rounded-3xl border border-slate-200 bg-white p-6">
        <h4 class="mb-4 text-lg font-bold text-slate-900">Datos familiares</h4>

        <div v-if="form.is_parent && form.family_members.length > 0" class="space-y-4">
          <div
            v-for="(member, index) in form.family_members"
            :key="index"
            class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-700"
          >
            <p><span class="font-semibold">Nombre:</span> {{ member.full_name || '-' }}</p>
            <p><span class="font-semibold">DNI:</span> {{ member.dni || '-' }}</p>
            <p><span class="font-semibold">Edad:</span> {{ member.age || '-' }}</p>
            <p><span class="font-semibold">Sexo:</span> {{ findOptionName(sexOptions, member.sex_id) }}</p>
            <p><span class="font-semibold">Parentesco:</span> {{ findOptionName(relationshipOptions, member.relationship_id) }}</p>
          </div>
        </div>

        <p v-else class="text-sm text-slate-600">
          No se registraron familiares.
        </p>
      </div>
    </div>
  </div>
</template>