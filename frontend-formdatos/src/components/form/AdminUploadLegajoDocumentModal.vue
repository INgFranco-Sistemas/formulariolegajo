<script setup>
import { reactive, ref, watch } from 'vue'
import BaseButton from '../base/BaseButton.vue'
import BaseInput from '../base/BaseInput.vue'

const props = defineProps({
    open: {
        type: Boolean,
        default: false,
    },
    section: {
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
    success: {
        type: String,
        default: '',
    },
})

const emit = defineEmits(['close', 'submit'])

const selectedFile = ref(null)

const form = reactive({
    document_name: '',
    document_type: '',
    document_number: '',
    issue_date: '',
    incorporation_date: '',
    folios_start: '',
    folios_end: '',
    is_sensitive: false,
    verification_status: 'PENDIENTE',
    observations: '',
})

watch(
    () => props.open,
    (isOpen) => {
        if (isOpen) {
            selectedFile.value = null
            form.document_name = ''
            form.document_type = ''
            form.document_number = ''
            form.issue_date = ''
            form.incorporation_date = new Date().toISOString().slice(0, 10)
            form.folios_start = ''
            form.folios_end = ''
            form.is_sensitive = false
            form.verification_status = 'PENDIENTE'
            form.observations = ''
        }
    }
)

const handleFileChange = (event) => {
    selectedFile.value = event.target.files?.[0] || null
}

const handleSubmit = () => {
    if (!props.section?.id) return

    emit('submit', {
        legajo_section_id: props.section.id,
        document_name: form.document_name,
        document_type: form.document_type,
        document_number: form.document_number,
        issue_date: form.issue_date,
        incorporation_date: form.incorporation_date,
        folios_start: form.folios_start,
        folios_end: form.folios_end,
        is_sensitive: form.is_sensitive,
        verification_status: form.verification_status,
        observations: form.observations,
        file: selectedFile.value,
    })
}
</script>

<template>
    <div v-if="open" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 px-4 py-6">
        <div class="max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-[2rem] bg-white p-6 shadow-2xl sm:p-8">
            <div class="mb-6 flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Incorporación de documento
                    </p>
                    <h2 class="text-2xl font-bold text-slate-900">
                        Subir PDF al legajo
                    </h2>
                    <p class="mt-2 text-sm text-slate-600">
                        {{ section ? `Sección ${String(section.number).padStart(2, '0')} - ${section.name}` : '' }}
                    </p>
                </div>

                <BaseButton variant="secondary" @click="emit('close')">
                    Cerrar
                </BaseButton>
            </div>

            <div v-if="error" class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-600">
                {{ error }}
            </div>

            <div v-if="success"
                class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                {{ success }}
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <BaseInput v-model="form.document_name" label="Nombre del documento"
                        placeholder="Ejemplo: COPIA DE DNI" />
                </div>

                <BaseInput v-model="form.document_type" label="Tipo de documento"
                    placeholder="Ejemplo: DNI, RESOLUCIÓN, CONTRATO" />

                <BaseInput v-model="form.document_number" label="Número de documento"
                    placeholder="Ejemplo: RESOLUCIÓN N° 001-2026" />

                <BaseInput v-model="form.issue_date" type="date" label="Fecha de emisión" />

                <BaseInput v-model="form.incorporation_date" type="date" label="Fecha de incorporación" />

                <BaseInput v-model="form.folios_start" type="number" label="Folio inicial" placeholder="Ejemplo: 1" />

                <BaseInput v-model="form.folios_end" type="number" label="Folio final" placeholder="Ejemplo: 3" />

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Estado de verificación
                    </label>
                    <select v-model="form.verification_status"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-500">
                        <option value="PENDIENTE">PENDIENTE</option>
                        <option value="VERIFICADO">VERIFICADO</option>
                        <option value="OBSERVADO">OBSERVADO</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <label
                        class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
                        <input v-model="form.is_sensitive" type="checkbox" class="h-4 w-4" />
                        Documento con datos sensibles
                    </label>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Archivo PDF
                    </label>
                    <input type="file" accept="application/pdf"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm"
                        @change="handleFileChange" />
                    <p class="mt-2 text-xs text-slate-500">
                        Solo PDF. Tamaño máximo permitido: 10 MB.
                    </p>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Observaciones
                    </label>
                    <textarea v-model="form.observations" rows="4"
                        class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-500"
                        placeholder="Ingrese observaciones"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <BaseButton variant="secondary" @click="emit('close')">
                    Cancelar
                </BaseButton>

                <BaseButton :disabled="loading" @click="handleSubmit">
                    {{ loading ? 'Subiendo...' : 'Guardar PDF' }}
                </BaseButton>
            </div>
        </div>
    </div>
</template>