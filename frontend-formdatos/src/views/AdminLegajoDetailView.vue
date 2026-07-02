<script setup>
import { computed, onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import BaseButton from '../components/base/BaseButton.vue'
import { useAdminLegajoStore } from '../stores/adminLegajoStore'
import AdminUploadLegajoDocumentModal from '../components/form/AdminUploadLegajoDocumentModal.vue'
import { useAdminLegajoDocumentStore } from '../stores/adminLegajoDocumentStore'
import { getLegajoFichaPdf } from '../services/adminLegajoPdfService'

const route = useRoute()
const router = useRouter()
const legajoStore = useAdminLegajoStore()

const BACKEND_URL = import.meta.env.VITE_BACKEND_URL || 'http://127.0.0.1:8000'

const documentStore = useAdminLegajoDocumentStore()

const uploadModalOpen = ref(false)
const selectedSection = ref(null)

const legajo = computed(() => legajoStore.selectedLegajo)
const employee = computed(() => legajo.value?.employee_form)

const formatBoolean = (value) => {
    return value ? 'SÍ' : 'NO'
}

const handleBack = () => {
    router.push('/admin/legajos')
}

const openUploadModal = (section) => {
    documentStore.clearUploadState()
    selectedSection.value = section
    uploadModalOpen.value = true
}

const closeUploadModal = () => {
    uploadModalOpen.value = false
    selectedSection.value = null
    documentStore.clearUploadState()
}

const handleUploadDocument = async (payload) => {
    const result = await documentStore.uploadDocument(route.params.id, payload)

    if (result.success) {
        await legajoStore.fetchLegajoById(route.params.id)
    }
}

const handleDeleteDocument = async (documentId) => {
    const confirmed = window.confirm('¿Está seguro de eliminar este documento del legajo?')

    if (!confirmed) return

    await documentStore.deleteDocument(route.params.id, documentId)
    await legajoStore.fetchLegajoById(route.params.id)
}

onMounted(async () => {
    await legajoStore.fetchLegajoById(route.params.id)
    await documentStore.fetchDocuments(route.params.id)
})

const handleOpenFichaPdf = async () => {
    const response = await getLegajoFichaPdf(route.params.id)

    const blob = new Blob([response.data], {
        type: 'application/pdf',
    })

    const url = window.URL.createObjectURL(blob)
    window.open(url, '_blank')
}
</script>

<template>
    <main class="min-h-screen bg-slate-100">
        <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Detalle de legajo</p>
                    <h1 class="mt-1 text-3xl font-bold text-slate-900">
                        Legajo Escalafonario
                    </h1>
                    <p class="mt-2 text-sm text-slate-600">
                        Visualización general del legajo y sus secciones oficiales.
                    </p>
                </div>

                <div class="flex gap-3">
                    <BaseButton @click="handleOpenFichaPdf">
                        Ver ficha PDF
                    </BaseButton>

                    <BaseButton variant="secondary" @click="handleBack">
                        Volver a legajos
                    </BaseButton>
                </div>
            </div>

            <div v-if="legajoStore.detailLoading"
                class="rounded-[2rem] bg-white p-8 text-sm text-slate-600 shadow-xl ring-1 ring-slate-200">
                Cargando legajo...
            </div>

            <div v-else-if="legajoStore.detailError"
                class="rounded-[2rem] border border-red-200 bg-red-50 p-8 text-sm text-red-600">
                {{ legajoStore.detailError }}
            </div>

            <div v-else-if="legajo" class="space-y-6">
                <section class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200">
                    <div class="grid gap-6 lg:grid-cols-3">
                        <div>
                            <p class="text-sm font-medium text-slate-500">N° de legajo</p>
                            <p class="mt-1 text-xl font-bold text-slate-900">
                                {{ legajo.legajo_number }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-slate-500">Estado</p>
                            <span class="mt-1 inline-flex rounded-full px-3 py-1 text-xs font-semibold" :class="legajo.status === 'ACTIVO'
                                ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                                : 'bg-slate-100 text-slate-700 ring-1 ring-slate-200'">
                                {{ legajo.status }}
                            </span>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-slate-500">Fecha de apertura</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">
                                {{ legajo.opening_date || '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 grid gap-6 lg:grid-cols-2">
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <h2 class="mb-4 text-lg font-bold text-slate-900">
                                Datos del trabajador
                            </h2>

                            <div class="space-y-2 text-sm text-slate-700">
                                <p><span class="font-semibold">Apellidos y nombres:</span> {{ employee?.full_name || '-'
                                }}</p>
                                <p><span class="font-semibold">DNI:</span> {{ employee?.dni || '-' }}</p>
                                <p><span class="font-semibold">Sexo:</span> {{ employee?.sex?.name || '-' }}</p>
                                <p><span class="font-semibold">Estado civil:</span> {{ employee?.marital_status?.name ||
                                    '-' }}</p>
                                <p><span class="font-semibold">Fecha de nacimiento:</span> {{ employee?.birth_date ||
                                    '-' }}</p>
                                <p><span class="font-semibold">Celular:</span> {{ employee?.cellphone || '-' }}</p>
                                <p><span class="font-semibold">Correo personal:</span> {{ employee?.personal_email ||
                                    '-' }}</p>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <h2 class="mb-4 text-lg font-bold text-slate-900">
                                Datos laborales
                            </h2>

                            <div class="space-y-2 text-sm text-slate-700">
                                <p><span class="font-semibold">Cargo:</span> {{ legajo.position_name ||
                                    employee?.current_position || '-' }}</p>
                                <p><span class="font-semibold">Dependencia:</span> {{ legajo.dependency?.name ||
                                    employee?.dependency?.name || '-' }}</p>
                                <p><span class="font-semibold">Régimen laboral:</span> {{ legajo.labor_regime?.name ||
                                    employee?.labor_regime?.name || '-' }}</p>
                                <p><span class="font-semibold">Fecha de vínculo:</span> {{
                                    employee?.employment_start_date || '-' }}</p>
                                <p><span class="font-semibold">Contrato/Resolución:</span> {{
                                    employee?.contract_resolution_number || '-' }}</p>
                                <p><span class="font-semibold">Ubicación física:</span> {{ legajo.physical_location ||
                                    '-' }}</p>
                                <p><span class="font-semibold">Ubicación digital:</span> {{ legajo.digital_location ||
                                    '-' }}</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200">
                    <div class="mb-6">
                        <p class="text-sm font-medium text-slate-500">Contenido del legajo</p>
                        <h2 class="mt-1 text-2xl font-bold text-slate-900">
                            12 secciones oficiales
                        </h2>
                        <p class="mt-2 text-sm text-slate-600">
                            Secciones establecidas para la organización del legajo escalafonario.
                        </p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <article v-for="section in legajoStore.sections" :key="section.id"
                            class="rounded-3xl border border-slate-200 bg-slate-50 p-5 transition hover:bg-white hover:shadow-sm">
                            <div class="mb-3 flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Sección {{ String(section.number).padStart(2, '0') }}
                                    </p>
                                    <h3 class="mt-1 text-base font-bold text-slate-900">
                                        {{ section.name }}
                                    </h3>
                                </div>

                                <span
                                    class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 ring-1 ring-slate-200">
                                    {{ documentStore.documentsBySection(section.id).length }} docs
                                </span>
                            </div>

                            <p class="text-sm leading-6 text-slate-600">
                                {{ section.description }}
                            </p>

                            <div v-if="documentStore.documentsBySection(section.id).length" class="mt-4 space-y-3">
                                <div v-for="doc in documentStore.documentsBySection(section.id)" :key="doc.id"
                                    class="rounded-2xl border border-slate-200 bg-white p-4 text-sm">
                                    <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                                        <div>
                                            <p class="font-semibold text-slate-900">
                                                {{ doc.document_name }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-500">
                                                {{ doc.document_type || 'Sin tipo' }}
                                                <span v-if="doc.document_number"> | {{ doc.document_number }}</span>
                                            </p>
                                            <p class="mt-1 text-xs text-slate-500">
                                                Folios:
                                                {{ doc.folios_start || '-' }} - {{ doc.folios_end || '-' }}
                                                <span v-if="doc.folios_count">({{ doc.folios_count }} folios)</span>
                                            </p>
                                            <p class="mt-1 text-xs text-slate-500">
                                                Estado: {{ doc.verification_status }}
                                            </p>
                                        </div>

                                        <div class="flex gap-2">
                                            <a :href="`${BACKEND_URL}...`"
                                                target="_blank"
                                                class="rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                                Ver PDF
                                            </a>

                                            <BaseButton variant="secondary" @click="handleDeleteDocument(doc.id)">
                                                Eliminar
                                            </BaseButton>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 flex justify-end">
                                <BaseButton variant="secondary" @click="openUploadModal(section)">
                                    Subir PDF
                                </BaseButton>
                            </div>
                        </article>
                    </div>
                </section>

                <section class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200">
                    <h2 class="mb-4 text-2xl font-bold text-slate-900">
                        Familiares registrados
                    </h2>

                    <div v-if="employee?.family_members?.length" class="grid gap-4 md:grid-cols-2">
                        <article v-for="member in employee.family_members" :key="member.id"
                            class="rounded-3xl border border-slate-200 bg-slate-50 p-5 text-sm text-slate-700">
                            <p><span class="font-semibold">Nombre:</span> {{ member.full_name || '-' }}</p>
                            <p><span class="font-semibold">DNI:</span> {{ member.dni || '-' }}</p>
                            <p><span class="font-semibold">Edad:</span> {{ member.age || '-' }}</p>
                            <p><span class="font-semibold">Sexo:</span> {{ member.sex?.name || '-' }}</p>
                            <p><span class="font-semibold">Parentesco:</span> {{ member.relationship?.name || '-' }}</p>
                        </article>
                    </div>

                    <p v-else class="text-sm text-slate-600">
                        No se registraron familiares.
                    </p>
                </section>
            </div>
        </section>

        <AdminUploadLegajoDocumentModal
            :open="uploadModalOpen"
            :section="selectedSection"
            :loading="documentStore.uploadLoading"
            :error="documentStore.uploadError"
            :success="documentStore.uploadSuccess"
            @close="closeUploadModal"
            @submit="handleUploadDocument"
        />
    </main>
</template>