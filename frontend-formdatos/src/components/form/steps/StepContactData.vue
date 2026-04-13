<script setup>
import BaseInput from '../../base/BaseInput.vue'

defineProps({
  form: {
    type: Object,
    required: true,
  },
  errors: {
    type: Object,
    default: () => ({}),
  },
})
</script>

<template>
  <div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
      <BaseInput
        v-model="form.address"
        label="Domicilio o dirección actual"
        placeholder="Ingrese su dirección actual"
        :error="errors.address"
      />
    </div>

    <div class="md:col-span-2">
      <BaseInput
        v-model="form.reference"
        label="Referencia"
        placeholder="Ingrese una referencia"
        :error="errors.reference"
      />
    </div>

    <BaseInput
      v-model="form.district"
      label="Distrito"
      placeholder="Ingrese el distrito"
      :error="errors.district"
    />

    <BaseInput
      v-model="form.province"
      label="Provincia"
      placeholder="Ingrese la provincia"
      :error="errors.province"
    />

    <BaseInput
      v-model="form.department"
      label="Departamento"
      placeholder="Ingrese el departamento"
      :error="errors.department"
    />

    <BaseInput
      v-model="form.cellphone"
      label="Celular"
      placeholder="987654321"
      :error="errors.cellphone"
    />

    <div class="md:col-span-2">
      <BaseInput
        v-model="form.personal_email"
        type="email"
        label="Correo personal"
        placeholder="usuario@ejemplo.com"
        :error="errors.personal_email"
      />
    </div>

    <BaseInput
      v-model="form.emergency_contact_name"
      label="Contacto en caso de emergencia"
      placeholder="Ingrese el nombre del contacto"
      :error="errors.emergency_contact_name"
    />

    <BaseInput
      v-model="form.emergency_contact_phone"
      label="Celular de emergencia"
      placeholder="Ingrese el celular del contacto"
      :error="errors.emergency_contact_phone"
    />
  </div>
</template>