<script setup>
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import AdminEmployeeFormDetailModal from '../components/form/AdminEmployeeFormDetailModal.vue'
import BaseButton from '../components/base/BaseButton.vue'
import BaseInput from '../components/base/BaseInput.vue'
import { useAdminAuthStore } from '../stores/adminAuthStore'
import { useAdminEmployeeFormStore } from '../stores/adminEmployeeFormStore'

const router = useRouter()
const authStore = useAdminAuthStore()
const formsStore = useAdminEmployeeFormStore()

const searchInput = ref(formsStore.filters.search)
const flashMessage = ref('')

const handleLogout = async () => {
    await authStore.logout()
    router.push('/login')
}

const handleExportExcel = async () => {
    await formsStore.exportExcel()
}

const handleSearch = async () => {
    formsStore.setSearch(searchInput.value)
    await formsStore.fetchForms()
}

const handleClearSearch = async () => {
    searchInput.value = ''
    formsStore.setSearch('')
    await formsStore.fetchForms()
}

const handleView = async (id) => {
    await formsStore.fetchFormById(id)
}

const handleEdit = (id) => {
    router.push(`/admin/employee-forms/${id}/edit`)
}

onMounted(async () => {
    const savedMessage = sessionStorage.getItem('admin_forms_success_message')

    if (savedMessage) {
        flashMessage.value = savedMessage
        sessionStorage.removeItem('admin_forms_success_message')
    }

    await formsStore.fetchForms()
})

watch(
    () => formsStore.filters.per_page,
    async () => {
        await formsStore.fetchForms()
    }
)
</script>

<template>
    <main class="min-h-screen bg-slate-100">
        <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200">
            <div class="flex flex-col gap-3 sm:flex-row">
                <BaseButton
                    :disabled="formsStore.exportLoading"
                    @click="handleExportExcel"
                >
                    {{ formsStore.exportLoading ? 'Generando Excel...' : 'Excel' }}
                </BaseButton>

                <BaseButton variant="secondary" @click="handleLogout">
                    Cerrar sesión
                </BaseButton>
            </div>

            <div
                v-if="flashMessage"
                class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700"
            >
                {{ flashMessage }}
            </div>

            <div class="mt-8 grid gap-4 lg:grid-cols-[1fr_auto_auto]">
                <BaseInput
                    v-model="searchInput"
                    label="Buscar ficha"
                    placeholder="Buscar por DNI, nombre o correo"
                />

                <div class="self-end">
                    <BaseButton @click="handleSearch">
                    Buscar
                    </BaseButton>
                </div>

                <div class="self-end">
                    <BaseButton variant="secondary" @click="handleClearSearch">
                    Limpiar
                    </BaseButton>
                </div>
            </div>

            <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="text-sm text-slate-600">
                Mostrando {{ formsStore.pagination.from || 0 }} a {{ formsStore.pagination.to || 0 }}
                de {{ formsStore.pagination.total }} registros
            </div>

            <div class="flex items-center gap-3">
                <label class="text-sm text-slate-600">Registros por página</label>
                <select
                v-model="formsStore.filters.per_page"
                class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm"
                >
                <option :value="10">10</option>
                <option :value="20">20</option>
                <option :value="50">50</option>
                </select>
            </div>
            </div>

            <div
            v-if="formsStore.error"
            class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-600"
            >
            {{ formsStore.error }}
            </div>

            <div
            v-else-if="formsStore.loading"
            class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600"
            >
            Cargando fichas registradas...
            </div>

            <div
            v-else-if="formsStore.items.length === 0"
            class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600"
            >
            No se encontraron registros.
            </div>

            <div v-else class="mt-6 overflow-hidden rounded-3xl border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        DNI
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Apellidos y nombres
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Correo personal
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Correo institucional
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Régimen laboral
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Fecha registro
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Acciones
                    </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">
                    <tr
                    v-for="item in formsStore.items"
                    :key="item.id"
                    class="hover:bg-slate-50"
                    >
                    <td class="px-4 py-4 text-sm font-semibold text-slate-800">
                        {{ item.dni }}
                    </td>
                    <td class="px-4 py-4 text-sm text-slate-700">
                        {{ item.full_name }}
                    </td>
                    <td class="px-4 py-4 text-sm text-slate-700">
                        {{ item.personal_email || '-' }}
                    </td>
                    <td class="px-4 py-4 text-sm text-slate-700">
                        {{ item.institutional_email || '-' }}
                    </td>
                    <td class="px-4 py-4 text-sm text-slate-700">
                        {{ item.labor_regime?.name || '-' }}
                    </td>
                    <td class="px-4 py-4 text-sm text-slate-700">
                        {{ item.created_at ? new Date(item.created_at).toLocaleString() : '-' }}
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex gap-2">
                        <BaseButton variant="secondary" @click="handleView(item.id)">
                            Ver
                        </BaseButton>

                        <BaseButton @click="handleEdit(item.id)">
                            Editar
                        </BaseButton>
                        </div>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>

            <div
            v-if="!formsStore.loading && formsStore.pagination.last_page > 1"
            class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
            <div class="text-sm text-slate-600">
                Página {{ formsStore.pagination.current_page }} de {{ formsStore.pagination.last_page }}
            </div>

            <div class="flex gap-3">
                <BaseButton
                variant="secondary"
                :disabled="formsStore.pagination.current_page <= 1"
                @click="formsStore.goToPage(formsStore.pagination.current_page - 1)"
                >
                Anterior
                </BaseButton>

                <BaseButton
                :disabled="formsStore.pagination.current_page >= formsStore.pagination.last_page"
                @click="formsStore.goToPage(formsStore.pagination.current_page + 1)"
                >
                Siguiente
                </BaseButton>
            </div>
            </div>
        </div>
        </section>

        <AdminEmployeeFormDetailModal
        :open="formsStore.detailOpen"
        :loading="formsStore.detailLoading"
        :error="formsStore.detailError"
        :item="formsStore.selectedItem"
        @close="formsStore.closeDetail()"
        />
    </main>
</template>