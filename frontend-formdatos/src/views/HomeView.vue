<script setup>
import { computed, onMounted } from 'vue'
import PublicLayout from '../layouts/PublicLayout.vue'
import FormStepper from '../components/form/FormStepper.vue'
import FormSectionCard from '../components/form/FormSectionCard.vue'
import BaseButton from '../components/base/BaseButton.vue'
import { useFormStore } from '../stores/formStore'
import { useCatalogStore } from '../stores/catalogStore'

import StepPersonalData from '../components/form/steps/StepPersonalData.vue'
import StepContactData from '../components/form/steps/StepContactData.vue'
import StepLaborData from '../components/form/steps/StepLaborData.vue'
import StepFamilyData from '../components/form/steps/StepFamilyData.vue'
import StepConfirmation from '../components/form/steps/StepConfirmation.vue'

import SuccessState from '../components/form/SuccessState.vue'

const formStore = useFormStore()
const catalogStore = useCatalogStore()

const sexOptions = computed(() => catalogStore.sexes)
const maritalStatusOptions = computed(() => catalogStore.maritalStatuses)
const laborRegimeOptions = computed(() => catalogStore.laborRegimes)
const pensionRegimeOptions = computed(() => catalogStore.pensionRegimes)
const relationshipOptions = computed(() => catalogStore.familyRelationships)

const currentTitle = computed(() => {
  const titles = {
    1: 'Datos personales',
    2: 'Domicilio y contacto',
    3: 'Datos laborales',
    4: 'Datos familiares',
    5: 'Confirmación',
  }

  return titles[formStore.currentStep] || 'Formulario'
})

const currentDescription = computed(() => {
  const descriptions = {
    1: 'Ingrese los datos personales del trabajador.',
    2: 'Complete la información de domicilio, contacto y emergencia.',
    3: 'Registre la información laboral actual.',
    4: 'Registre familiares directos en caso corresponda.',
    5: 'Revise toda la información antes del envío final.',
  }

  return descriptions[formStore.currentStep] || ''
})

onMounted(() => {
  catalogStore.fetchCatalogs()
})

const handleSubmit = async () => {
  const result = await formStore.submitForm()

  if (result.success) {
    // aquí luego podremos mostrar una pantalla de éxito más elegante
  }
}

const handleRestart = () => {
  formStore.resetForm()
}

const handleNextStep = async () => {
  await formStore.nextStep()
}
</script>

<template>
  <PublicLayout>
    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
      <div class="mb-8">
        <span
          class="inline-flex rounded-full border border-slate-200 bg-white px-4 py-1 text-sm font-medium text-slate-600 shadow-sm"
        >
          Formulario institucional
        </span>

        <h2 class="mt-4 text-4xl font-bold text-slate-900 sm:text-5xl">
          Rellenar el formulario
        </h2>

        <p class="mt-4 max-w-3xl text-base leading-7 text-slate-600 sm:text-lg">
          Complete la ficha de datos generales con información actualizada y verificada.
          El proceso está dividido por secciones para facilitar un registro claro,
          ordenado y seguro.
        </p>
      </div>

      <div class="space-y-6">
        <SuccessState
          v-if="formStore.submitSuccess"
          :message="formStore.submitMessage"
          @restart="handleRestart"
        />

        <template v-else>
          <FormStepper
            :steps="formStore.steps"
            :current-step="formStore.currentStep"
          />

          <div
            v-if="catalogStore.loading"
            class="rounded-[2rem] bg-white p-6 text-sm text-slate-600 shadow-sm ring-1 ring-slate-200"
          >
            Cargando catálogos del formulario...
          </div>

          <div
            v-else-if="catalogStore.error"
            class="rounded-[2rem] border border-red-200 bg-red-50 p-6 text-sm text-red-600 shadow-sm"
          >
            {{ catalogStore.error }}
          </div>

          <FormSectionCard
            v-else
            :title="currentTitle"
            :description="currentDescription"
          >
            <div
              v-if="formStore.submitError"
              class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-600"
            >
              {{ formStore.submitError }}
            </div>

            <StepPersonalData
              v-if="formStore.currentStep === 1"
              :form="formStore.form"
              :errors="formStore.errors"
              :sex-options="sexOptions"
              :marital-status-options="maritalStatusOptions"
            />

            <StepContactData
              v-if="formStore.currentStep === 2"
              :form="formStore.form"
              :errors="formStore.errors"
            />

            <StepLaborData
              v-if="formStore.currentStep === 3"
              :form="formStore.form"
              :errors="formStore.errors"
              :labor-regime-options="laborRegimeOptions"
              :pension-regime-options="pensionRegimeOptions"
            />

            <StepFamilyData
              v-if="formStore.currentStep === 4"
              :form="formStore.form"
              :errors="formStore.errors"
              :sex-options="sexOptions"
              :relationship-options="relationshipOptions"
            />

            <StepConfirmation
              v-if="formStore.currentStep === 5"
              :form="formStore.form"
              :sex-options="sexOptions"
              :marital-status-options="maritalStatusOptions"
              :labor-regime-options="laborRegimeOptions"
              :pension-regime-options="pensionRegimeOptions"
              :relationship-options="relationshipOptions"
            />

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-between">
              <BaseButton
                v-if="formStore.currentStep > 1"
                variant="secondary"
                @click="formStore.previousStep()"
              >
                Atrás
              </BaseButton>

              <div class="sm:ml-auto">
                <BaseButton
                  v-if="formStore.currentStep < 5"
                  :disabled="formStore.checkingDni"
                  @click="handleNextStep"
                >
                  {{ formStore.checkingDni && formStore.currentStep === 1 ? 'Validando DNI...' : 'Continuar' }}
                </BaseButton>

                <BaseButton
                  v-else
                  :disabled="formStore.submitting"
                  @click="handleSubmit"
                >
                  {{ formStore.submitting ? 'Enviando...' : 'Enviar formulario' }}
                </BaseButton>
              </div>
            </div>
          </FormSectionCard>
        </template>
      </div>
    </section>
  </PublicLayout>
</template>