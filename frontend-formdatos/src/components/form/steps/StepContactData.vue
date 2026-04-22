<script setup>
import { onMounted, toRef } from 'vue'
import BaseInput from '../../base/BaseInput.vue'
import BaseSelect from '../../base/BaseSelect.vue'
import { useUbigeo } from '../../../composables/useUbigeo'

const toUpper = (value) => value?.toUpperCase() || ''

const props = defineProps({
  form: {
    type: Object,
    required: true,
  },
  errors: {
    type: Object,
    default: () => ({}),
  },
})

const formRef = toRef(props, 'form')

const {
  loadUbigeo,
  ubigeoLoading,
  ubigeoError,
  departmentOptions,
  provinceOptions,
  districtOptions,
  handleDepartmentChange,
  handleProvinceChange,
} = useUbigeo(formRef)

onMounted(async () => {
  await loadUbigeo()
})
</script>

<template>
  <div class="space-y-5">
    <div
      v-if="ubigeoError"
      class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-600"
    >
      {{ ubigeoError }}
    </div>

    <div class="grid gap-5 md:grid-cols-2">
      <div class="md:col-span-2">
        <BaseInput
          :modelValue="form.address"
          @update:modelValue="form.address = toUpper($event)"
          label="Domicilio o dirección actual"
          placeholder="Ingrese su dirección actual"
          :error="errors.address"
        />
      </div>

      <div class="md:col-span-2">
        <BaseInput
          :modelValue="form.reference"
          @update:modelValue="form.reference = toUpper($event)"
          label="Referencia"
          placeholder="Ingrese una referencia"
          :error="errors.reference"
        />
      </div>

      <BaseSelect
        v-model="form.department"
        label="Departamento"
        :options="departmentOptions"
        placeholder="Seleccione el departamento"
        :error="errors.department"
        :disabled="ubigeoLoading"
        @change="handleDepartmentChange"
      />

      <BaseSelect
        v-model="form.province"
        label="Provincia"
        :options="provinceOptions"
        placeholder="Seleccione la provincia"
        :error="errors.province"
        :disabled="ubigeoLoading || !form.department"
        @change="handleProvinceChange"
      />

      <BaseSelect
        v-model="form.district"
        label="Distrito"
        :options="districtOptions"
        placeholder="Seleccione el distrito"
        :error="errors.district"
        :disabled="ubigeoLoading || !form.province"
      />

      <BaseInput
        v-model="form.cellphone"
        label="Celular"
        placeholder="987654321"
        :error="errors.cellphone"
      />

      <div class="md:col-span-2">
        <BaseInput
          :modelValue="form.personal_email"
          @update:modelValue="form.personal_email = toUpper($event)"
          type="email"
          label="Correo personal"
          placeholder="usuario@ejemplo.com"
          :error="errors.personal_email"
        />
      </div>

      <BaseInput
        :modelValue="form.emergency_contact_name"
        @update:modelValue="form.emergency_contact_name = toUpper($event)"
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
  </div>
</template>