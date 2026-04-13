<script setup>
import BaseButton from '../../base/BaseButton.vue'
import BaseInput from '../../base/BaseInput.vue'
import BaseSelect from '../../base/BaseSelect.vue'

const props = defineProps({
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
  relationshipOptions: {
    type: Array,
    default: () => [],
  },
})

const addFamilyMember = () => {
  props.form.family_members.push({
    full_name: '',
    dni: '',
    age: '',
    sex_id: '',
    relationship_id: '',
  })
}

const removeFamilyMember = (index) => {
  props.form.family_members.splice(index, 1)
}
</script>

<template>
  <div class="space-y-6">
    <BaseSelect
      v-model="form.is_parent"
      label="¿Es padre o madre de familia?"
      :options="[
        { id: true, name: 'Sí' },
        { id: false, name: 'No' }
      ]"
      placeholder="Seleccione una opción"
      :error="errors.is_parent"
    />

    <p v-if="errors.family_members" class="text-sm text-red-500">
      {{ errors.family_members }}
    </p>

    <div v-if="form.is_parent" class="space-y-5">
      <div class="flex items-center justify-between">
        <div>
          <h3 class="text-lg font-bold text-slate-900">Familiares directos</h3>
          <p class="text-sm text-slate-600">
            Registre cónyuge e hijos, según corresponda.
          </p>
        </div>

        <BaseButton @click="addFamilyMember">
          Agregar familiar
        </BaseButton>
      </div>

      <div
        v-for="(member, index) in form.family_members"
        :key="index"
        class="rounded-3xl border border-slate-200 bg-slate-50 p-5"
      >
        <div class="mb-4 flex items-center justify-between">
          <h4 class="font-semibold text-slate-800">
            Familiar {{ index + 1 }}
          </h4>

          <button
            type="button"
            class="text-sm font-semibold text-red-500"
            @click="removeFamilyMember(index)"
          >
            Eliminar
          </button>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
          <div class="md:col-span-2">
            <BaseInput
              v-model="member.full_name"
              label="Nombres y apellidos"
              placeholder="Ingrese nombres y apellidos"
              :error="errors[`family_members.${index}.full_name`]"
            />
          </div>

          <BaseInput
            v-model="member.dni"
            label="DNI"
            placeholder="Ingrese el DNI"
            :error="errors[`family_members.${index}.dni`]"
          />

          <BaseInput
            v-model="member.age"
            type="number"
            label="Edad"
            placeholder="Ingrese la edad"
            :error="errors[`family_members.${index}.age`]"
          />

          <BaseSelect
            v-model="member.sex_id"
            label="Sexo"
            :options="sexOptions"
            placeholder="Seleccione el sexo"
            :error="errors[`family_members.${index}.sex_id`]"
          />

          <BaseSelect
            v-model="member.relationship_id"
            label="Parentesco"
            :options="relationshipOptions"
            placeholder="Seleccione el parentesco"
            :error="errors[`family_members.${index}.relationship_id`]"
          />
        </div>
      </div>

      <div
        v-if="form.family_members.length === 0"
        class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-sm text-slate-500"
      >
        Aún no ha agregado familiares.
      </div>
    </div>
  </div>
</template>