<script setup>
import BaseButton from '../base/BaseButton.vue'

defineProps({
    open: {
        type: Boolean,
        default: false,
    },
    loading: {
        type: Boolean,
        default: false,
    },
    error: {
        type: String,
        default: '',
    },
    item: {
        type: Object,
        default: null,
    },
})

const emit = defineEmits(['close'])

const formatBoolean = (value) => {
    return value ? 'Sí' : 'No'
}
</script>

<template>
    <div
        v-if="open"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 px-4 py-6"
    >
        <div class="max-h-[90vh] w-full max-w-5xl overflow-y-auto rounded-[2rem] bg-white p-6 shadow-2xl sm:p-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
            <p class="text-sm font-medium text-slate-500">Detalle de ficha</p>
            <h2 class="text-2xl font-bold text-slate-900">
                Información completa del registro
            </h2>
            </div>

            <BaseButton variant="secondary" @click="emit('close')">
            Cerrar
            </BaseButton>
        </div>

        <div
            v-if="loading"
            class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600"
        >
            Cargando detalle...
        </div>

        <div
            v-else-if="error"
            class="rounded-2xl border border-red-200 bg-red-50 p-6 text-sm text-red-600"
        >
            {{ error }}
        </div>

        <div v-else-if="item" class="space-y-6">
            <div class="grid gap-6 lg:grid-cols-2">
            <section class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <h3 class="mb-4 text-lg font-bold text-slate-900">Datos personales</h3>
                <div class="space-y-2 text-sm text-slate-700">
                <p><span class="font-semibold">Apellidos y nombres:</span> {{ item.full_name || '-' }}</p>
                <p><span class="font-semibold">DNI:</span> {{ item.dni || '-' }}</p>
                <p><span class="font-semibold">RUC:</span> {{ item.ruc || '-' }}</p>
                <p><span class="font-semibold">Sexo:</span> {{ item.sex?.name || '-' }}</p>
                <p><span class="font-semibold">Estado civil:</span> {{ item.marital_status?.name || '-' }}</p>
                <p><span class="font-semibold">Fecha de nacimiento:</span> {{ item.birth_date || '-' }}</p>
                <p><span class="font-semibold">Lugar de nacimiento:</span> {{ item.birth_place || '-' }}</p>
                <p><span class="font-semibold">¿Tiene discapacidad?:</span> {{ formatBoolean(item.has_disability) }}</p>
                <p><span class="font-semibold">CONADIS RUI:</span> {{ item.conadis_rui || '-' }}</p>
                </div>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <h3 class="mb-4 text-lg font-bold text-slate-900">Domicilio y contacto</h3>
                <div class="space-y-2 text-sm text-slate-700">
                <p><span class="font-semibold">Dirección:</span> {{ item.address || '-' }}</p>
                <p><span class="font-semibold">Referencia:</span> {{ item.reference || '-' }}</p>
                <p><span class="font-semibold">Distrito:</span> {{ item.district || '-' }}</p>
                <p><span class="font-semibold">Provincia:</span> {{ item.province || '-' }}</p>
                <p><span class="font-semibold">Departamento:</span> {{ item.department || '-' }}</p>
                <p><span class="font-semibold">Celular:</span> {{ item.cellphone || '-' }}</p>
                <p><span class="font-semibold">Correo personal:</span> {{ item.personal_email || '-' }}</p>
                <p><span class="font-semibold">Contacto de emergencia:</span> {{ item.emergency_contact_name || '-' }}</p>
                <p><span class="font-semibold">Celular de emergencia:</span> {{ item.emergency_contact_phone || '-' }}</p>
                </div>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <h3 class="mb-4 text-lg font-bold text-slate-900">Datos laborales</h3>
                <div class="space-y-2 text-sm text-slate-700">
                <p><span class="font-semibold">Profesión:</span> {{ item.profession || '-' }}</p>
                <p><span class="font-semibold">Cargo actual:</span> {{ item.current_position || '-' }}</p>
                <p><span class="font-semibold">Dependencia actual:</span> {{ item.current_dependency || '-' }}</p>
                <p><span class="font-semibold">Contrato o resolución:</span> {{ item.contract_resolution_number || '-' }}</p>
                <p><span class="font-semibold">Fecha de vínculo:</span> {{ item.employment_start_date || '-' }}</p>
                <p><span class="font-semibold">Régimen laboral:</span> {{ item.labor_regime?.name || '-' }}</p>
                <p><span class="font-semibold">Condición laboral:</span> {{ item.labor_condition || '-' }}</p>
                <p><span class="font-semibold">Régimen pensionario:</span> {{ item.pension_regime?.name || '-' }}</p>
                <p><span class="font-semibold">Código AIRSHSP:</span> {{ item.airshsp_code || '-' }}</p>
                <p><span class="font-semibold">Correo institucional:</span> {{ item.institutional_email || '-' }}</p>
                <p><span class="font-semibold">¿Tiene vínculo laboral?:</span> {{ formatBoolean(item.has_labor_link) }}</p>
                <p><span class="font-semibold">Fecha fin de vínculo:</span> {{ item.labor_end_date || '-' }}</p>
                </div>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <h3 class="mb-4 text-lg font-bold text-slate-900">Datos familiares</h3>

                <div v-if="item.family_members?.length" class="space-y-4">
                <div
                    v-for="member in item.family_members"
                    :key="member.id"
                    class="rounded-2xl border border-slate-200 bg-white p-4 text-sm text-slate-700"
                >
                    <p><span class="font-semibold">Nombre:</span> {{ member.full_name || '-' }}</p>
                    <p><span class="font-semibold">DNI:</span> {{ member.dni || '-' }}</p>
                    <p><span class="font-semibold">Edad:</span> {{ member.age || '-' }}</p>
                    <p><span class="font-semibold">Sexo:</span> {{ member.sex?.name || '-' }}</p>
                    <p><span class="font-semibold">Parentesco:</span> {{ member.relationship?.name || '-' }}</p>
                </div>
                </div>

                <p v-else class="text-sm text-slate-600">
                No se registraron familiares.
                </p>
            </section>
            </div>
        </div>
        </div>
    </div>
</template>