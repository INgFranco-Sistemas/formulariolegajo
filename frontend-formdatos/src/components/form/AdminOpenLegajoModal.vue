<script setup>
import { reactive, watch } from 'vue'
import BaseButton from '../base/BaseButton.vue'
import BaseInput from '../base/BaseInput.vue'

const props = defineProps({
    open: {
        type: Boolean,
        default: false,
    },
    employee: {
        type: Object,
        default: null,
    },
    loading: {
        type: Boolean,
        default: false,
    },
    error: {
        type: String,
        default: '',
    },
})

const emit = defineEmits(['close', 'submit'])

const form = reactive({
    physical_location: '',
    digital_location: '',
    observations: '',
})

watch(
    () => props.open,
    (isOpen) => {
        if (isOpen) {
            form.physical_location = 'ARCHIVO ESCALAFÓN'
            form.digital_location = 'REPOSITORIO DIGITAL DE LEGAJOS'
            form.observations = 'APERTURA INICIAL DEL LEGAJO ESCALAFONARIO.'
        }
    }
)

const handleSubmit = () => {
    if (!props.employee?.id) return

    emit('submit', {
        employee_form_id: props.employee.id,
        physical_location: form.physical_location,
        digital_location: form.digital_location,
        observations: form.observations,
    })
}
</script>

<template>
    <div v-if="open" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 px-4 py-6">
        <div class="w-full max-w-2xl rounded-[2rem] bg-white p-6 shadow-2xl sm:p-8">
            <div class="mb-6 flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Apertura de legajo</p>
                    <h2 class="text-2xl font-bold text-slate-900">
                        Aperturar legajo escalafonario
                    </h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Se creará un legajo para el trabajador seleccionado.
                    </p>
                </div>

                <BaseButton variant="secondary" @click="emit('close')">
                    Cerrar
                </BaseButton>
            </div>

            <div v-if="employee"
                class="mb-6 rounded-3xl border border-slate-200 bg-slate-50 p-5 text-sm text-slate-700">
                <p><span class="font-semibold">Trabajador:</span> {{ employee.full_name }}</p>
                <p><span class="font-semibold">DNI:</span> {{ employee.dni }}</p>
                <p><span class="font-semibold">Cargo:</span> {{ employee.current_position || '-' }}</p>
            </div>

            <div v-if="error" class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-600">
                {{ error }}
            </div>

            <div class="space-y-5">
                <BaseInput v-model="form.physical_location" label="Ubicación física"
                    placeholder="Ejemplo: ARCHIVO ESCALAFÓN - ANAQUEL 01" />

                <BaseInput v-model="form.digital_location" label="Ubicación digital"
                    placeholder="Ejemplo: REPOSITORIO DIGITAL / LEGAJOS" />

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Observaciones
                    </label>
                    <textarea v-model="form.observations" rows="4"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-500"
                        placeholder="Ingrese observaciones"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <BaseButton variant="secondary" @click="emit('close')">
                        Cancelar
                    </BaseButton>

                    <BaseButton :disabled="loading" @click="handleSubmit">
                        {{ loading ? 'Aperturando...' : 'Aperturar legajo' }}
                    </BaseButton>
                </div>
            </div>
        </div>
    </div>
</template>