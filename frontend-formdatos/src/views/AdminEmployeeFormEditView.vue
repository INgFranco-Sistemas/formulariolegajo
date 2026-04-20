<script setup>
import { computed, onMounted } from 'vue'
import { useUbigeo } from '../composables/useUbigeo'
import { useRoute, useRouter } from 'vue-router'
import BaseButton from '../components/base/BaseButton.vue'
import BaseInput from '../components/base/BaseInput.vue'
import BaseSelect from '../components/base/BaseSelect.vue'
import { useAdminEmployeeFormStore } from '../stores/adminEmployeeFormStore'
import { useCatalogStore } from '../stores/catalogStore'

const route = useRoute()
const router = useRouter()
const formsStore = useAdminEmployeeFormStore()
const catalogStore = useCatalogStore()

const form = computed(() => formsStore.editItem)

const {
    loadUbigeo,
    ubigeoLoading,
    ubigeoError,
    departmentOptions,
    provinceOptions,
    districtOptions,
    handleDepartmentChange,
    handleProvinceChange,
    syncUbigeoValues,
} = useUbigeo(form)

const sexOptions = computed(() => catalogStore.sexes)
const maritalStatusOptions = computed(() => catalogStore.maritalStatuses)
const laborRegimeOptions = computed(() => catalogStore.laborRegimes)
const pensionRegimeOptions = computed(() => catalogStore.pensionRegimes)
const relationshipOptions = computed(() => catalogStore.familyRelationships)
const dependencyOptions = computed(() => catalogStore.dependencies)

const addFamilyMember = () => {
    if (!formsStore.editItem) return

    formsStore.editItem.family_members.push({
        full_name: '',
        dni: '',
        age: '',
        sex_id: '',
        relationship_id: '',
    })
}

const removeFamilyMember = (index) => {
    if (!formsStore.editItem) return

    formsStore.editItem.family_members.splice(index, 1)
}

const handleSave = async () => {
    const result = await formsStore.updateForm(route.params.id)

    if (result.success) {
        sessionStorage.setItem(
            'admin_forms_success_message',
            formsStore.editSuccess || 'La ficha fue actualizada correctamente.'
        )

        formsStore.clearEditState()
        router.push('/admin')
    }
}

const handleBack = () => {
    formsStore.clearEditState()
    router.push('/admin')
}

onMounted(async () => {
    await loadUbigeo()

    if (!catalogStore.sexes.length) {
        await catalogStore.fetchCatalogs()
    }

    await formsStore.fetchEditableFormById(route.params.id)

    if (formsStore.editItem) {
        syncUbigeoValues()
    }
})
</script>

<template>
    <main class="min-h-screen bg-slate-100">
        <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Edición administrativa</p>
                    <h1 class="mt-1 text-3xl font-bold text-slate-900">
                        Editar ficha registrada
                    </h1>
                </div>

                <BaseButton variant="secondary" @click="handleBack">
                    Volver al panel
                </BaseButton>
            </div>

            <div v-if="formsStore.editLoading"
                class="rounded-[2rem] border border-slate-200 bg-white p-8 text-sm text-slate-600 shadow-xl">
                Cargando ficha para edición...
            </div>

            <div v-else-if="formsStore.editError && !form"
                class="rounded-[2rem] border border-red-200 bg-red-50 p-8 text-sm text-red-600 shadow-xl">
                {{ formsStore.editError }}
            </div>

            <div v-else-if="form" class="space-y-6">
                <div v-if="formsStore.editSuccess"
                    class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                    {{ formsStore.editSuccess }}
                </div>

                <div v-if="formsStore.editError"
                    class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-600">
                    {{ formsStore.editError }}
                </div>

                <section class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200">
                    <h2 class="mb-6 text-2xl font-bold text-slate-900">Datos personales</h2>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <BaseInput v-model="form.full_name" label="Apellidos y nombres"
                                placeholder="Ingrese apellidos y nombres" :error="formsStore.editErrors.full_name" />
                        </div>

                        <BaseInput v-model="form.dni" label="DNI" placeholder="12345678"
                            :error="formsStore.editErrors.dni" />

                        <BaseInput v-model="form.ruc" label="RUC" placeholder="Ingrese RUC"
                            :error="formsStore.editErrors.ruc" />

                        <BaseSelect v-model="form.sex_id" label="Sexo" :options="sexOptions"
                            placeholder="Seleccione el sexo" :error="formsStore.editErrors.sex_id" />

                        <BaseSelect v-model="form.marital_status_id" label="Estado civil"
                            :options="maritalStatusOptions" placeholder="Seleccione el estado civil"
                            :error="formsStore.editErrors.marital_status_id" />

                        <BaseInput v-model="form.birth_date" type="date" label="Fecha de nacimiento"
                            :error="formsStore.editErrors.birth_date" />

                        <BaseInput v-model="form.birth_place" label="Lugar de nacimiento"
                            placeholder="Ingrese lugar de nacimiento" :error="formsStore.editErrors.birth_place" />

                        <BaseSelect v-model="form.has_disability" label="¿Tiene alguna discapacidad?" :options="[
                            { id: true, name: 'Sí' },
                            { id: false, name: 'No' }
                        ]" placeholder="Seleccione una opción" :error="formsStore.editErrors.has_disability" />

                        <BaseInput v-if="form.has_disability === true" v-model="form.conadis_rui" label="CONADIS RUI"
                            placeholder="Ingrese código CONADIS" :error="formsStore.editErrors.conadis_rui" />
                    </div>
                </section>

                <section class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200">
                    <h2 class="mb-6 text-2xl font-bold text-slate-900">Domicilio y contacto</h2>

                    <div v-if="ubigeoError"
                        class="mb-4 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-600">
                        {{ ubigeoError }}
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <BaseInput v-model="form.address" label="Dirección actual" placeholder="Ingrese dirección"
                                :error="formsStore.editErrors.address" />
                        </div>

                        <div class="md:col-span-2">
                            <BaseInput v-model="form.reference" label="Referencia" placeholder="Ingrese referencia"
                                :error="formsStore.editErrors.reference" />
                        </div>

                        <BaseSelect v-model="form.department" label="Departamento" :options="departmentOptions"
                            placeholder="Seleccione el departamento" :error="formsStore.editErrors.department"
                            :disabled="ubigeoLoading" @change="handleDepartmentChange" />

                        <BaseSelect v-model="form.province" label="Provincia" :options="provinceOptions"
                            placeholder="Seleccione la provincia" :error="formsStore.editErrors.province"
                            :disabled="ubigeoLoading || !form.department" @change="handleProvinceChange" />

                        <BaseSelect v-model="form.district" label="Distrito" :options="districtOptions"
                            placeholder="Seleccione el distrito" :error="formsStore.editErrors.district"
                            :disabled="ubigeoLoading || !form.province" />

                        <BaseInput v-model="form.cellphone" label="Celular" placeholder="Ingrese celular"
                            :error="formsStore.editErrors.cellphone" />

                        <div class="md:col-span-2">
                            <BaseInput v-model="form.personal_email" type="email" label="Correo personal"
                                placeholder="Ingrese correo" :error="formsStore.editErrors.personal_email" />
                        </div>

                        <BaseInput v-model="form.emergency_contact_name" label="Contacto de emergencia"
                            placeholder="Ingrese contacto" :error="formsStore.editErrors.emergency_contact_name" />

                        <BaseInput v-model="form.emergency_contact_phone" label="Celular de emergencia"
                            placeholder="Ingrese celular" :error="formsStore.editErrors.emergency_contact_phone" />
                    </div>
                </section>

                <section class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200">
                    <h2 class="mb-6 text-2xl font-bold text-slate-900">Datos laborales</h2>

                    <div class="grid gap-5 md:grid-cols-2">
                        <BaseInput v-model="form.profession" label="Profesión" placeholder="Ingrese profesión"
                            :error="formsStore.editErrors.profession" />

                        <BaseInput v-model="form.current_position" label="Cargo actual" placeholder="Ingrese cargo"
                            :error="formsStore.editErrors.current_position" />

                        <div class="md:col-span-2">
                            <BaseSelect
                                v-model="form.dependency_id"
                                label="Dependencia actual"
                                :options="dependencyOptions"
                                placeholder="Seleccione la dependencia actual"
                                :error="formsStore.editErrors.dependency_id"
                            />
                        </div>

                        <BaseInput v-model="form.contract_resolution_number" label="Contrato o Resolución"
                            placeholder="Ingrese contrato o resolución"
                            :error="formsStore.editErrors.contract_resolution_number" />

                        <BaseInput v-model="form.employment_start_date" type="date" label="Fecha de vínculo"
                            :error="formsStore.editErrors.employment_start_date" />

                        <BaseSelect v-model="form.labor_regime_id" label="Régimen laboral" :options="laborRegimeOptions"
                            placeholder="Seleccione régimen laboral" :error="formsStore.editErrors.labor_regime_id" />

                        <BaseInput v-model="form.labor_condition" label="Condición laboral"
                            placeholder="Ingrese condición laboral" :error="formsStore.editErrors.labor_condition" />

                        <BaseSelect v-model="form.pension_regime_id" label="Régimen pensionario"
                            :options="pensionRegimeOptions" placeholder="Seleccione régimen pensionario"
                            :error="formsStore.editErrors.pension_regime_id" />

                        <BaseInput v-model="form.airshsp_code" label="Código AIRSHSP" placeholder="Ingrese código"
                            :error="formsStore.editErrors.airshsp_code" />

                        <BaseInput v-model="form.institutional_email" type="email" label="Correo institucional"
                            placeholder="Ingrese correo institucional"
                            :error="formsStore.editErrors.institutional_email" />

                        <BaseSelect v-model="form.has_labor_link" label="¿Tiene vínculo laboral?" :options="[
                            { id: true, name: 'Sí tiene' },
                            { id: false, name: 'No tiene' }
                        ]" placeholder="Seleccione una opción" :error="formsStore.editErrors.has_labor_link" />

                        <BaseInput v-if="form.has_labor_link === false" v-model="form.labor_end_date" type="date"
                            label="Fecha de fin de vínculo" :error="formsStore.editErrors.labor_end_date" />
                    </div>
                </section>

                <section class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">Datos familiares</h2>
                            <p class="mt-1 text-sm text-slate-600">
                                Edite los familiares registrados o agregue nuevos.
                            </p>
                        </div>

                        <BaseButton variant="secondary" @click="addFamilyMember">
                            Agregar familiar
                        </BaseButton>
                    </div>

                    <div class="space-y-5">
                        <BaseSelect v-model="form.is_parent" label="¿Es padre o madre de familia?" :options="[
                            { id: true, name: 'Sí' },
                            { id: false, name: 'No' }
                        ]" placeholder="Seleccione una opción" :error="formsStore.editErrors.is_parent" />

                        <p v-if="formsStore.editErrors.family_members" class="text-sm text-red-500">
                            {{ formsStore.editErrors.family_members }}
                        </p>

                        <div v-for="(member, index) in form.family_members" :key="index"
                            class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <div class="mb-4 flex items-center justify-between">
                                <h3 class="font-semibold text-slate-800">Familiar {{ index + 1 }}</h3>

                                <button type="button" class="text-sm font-semibold text-red-500"
                                    @click="removeFamilyMember(index)">
                                    Eliminar
                                </button>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <BaseInput v-model="member.full_name" label="Nombres y apellidos"
                                        placeholder="Ingrese nombres y apellidos"
                                        :error="formsStore.editErrors[`family_members.${index}.full_name`]" />
                                </div>

                                <BaseInput v-model="member.dni" label="DNI" placeholder="Ingrese DNI"
                                    :error="formsStore.editErrors[`family_members.${index}.dni`]" />

                                <BaseInput v-model="member.age" type="number" label="Edad" placeholder="Ingrese edad"
                                    :error="formsStore.editErrors[`family_members.${index}.age`]" />

                                <BaseSelect v-model="member.sex_id" label="Sexo" :options="sexOptions"
                                    placeholder="Seleccione sexo"
                                    :error="formsStore.editErrors[`family_members.${index}.sex_id`]" />

                                <BaseSelect v-model="member.relationship_id" label="Parentesco"
                                    :options="relationshipOptions" placeholder="Seleccione parentesco"
                                    :error="formsStore.editErrors[`family_members.${index}.relationship_id`]" />
                            </div>
                        </div>
                    </div>
                </section>

                <div class="flex justify-end">
                    <BaseButton :disabled="formsStore.editSaving" @click="handleSave">
                        {{ formsStore.editSaving ? 'Guardando cambios...' : 'Guardar cambios' }}
                    </BaseButton>
                </div>
            </div>
        </section>
    </main>
</template>