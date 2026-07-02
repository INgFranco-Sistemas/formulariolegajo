<script setup>
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import BaseButton from '../components/base/BaseButton.vue'
import BaseInput from '../components/base/BaseInput.vue'
import { useAdminLegajoStore } from '../stores/adminLegajoStore'

const router = useRouter()
const legajoStore = useAdminLegajoStore()

const searchInput = ref(legajoStore.filters.search)
const statusInput = ref(legajoStore.filters.status)
let searchTimeout = null

const handleSearch = async () => {
    legajoStore.filters.search = searchInput.value
    legajoStore.filters.status = statusInput.value
    legajoStore.filters.page = 1
    await legajoStore.fetchLegajos()
}

const handleClear = async () => {
    clearTimeout(searchTimeout)

    searchInput.value = ''
    statusInput.value = ''
    legajoStore.filters.search = ''
    legajoStore.filters.status = ''
    legajoStore.filters.page = 1
    await legajoStore.fetchLegajos()
}

const goToPage = async (page) => {
    if (page < 1 || page > legajoStore.pagination.last_page) return

    legajoStore.filters.page = page
    await legajoStore.fetchLegajos()
}

const handleBack = () => {
    router.push('/admin')
}

watch(searchInput, (value) => {
    clearTimeout(searchTimeout)

    searchTimeout = setTimeout(async () => {
        legajoStore.filters.search = value
        legajoStore.filters.page = 1
        await legajoStore.fetchLegajos()
    }, 500)
})

onMounted(async () => {
    await legajoStore.fetchLegajos()
})

watch(
    () => legajoStore.filters.per_page,
    async () => {
        legajoStore.filters.page = 1
        await legajoStore.fetchLegajos()
    }
)
</script>

<template>
    <main class="min-h-screen bg-slate-100">
        <section class="mx-auto max-w-[150rem] px-4 py-8 sm:px-6 lg:px-8">
            <div class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Módulo escalafonario</p>
                        <h1 class="mt-1 text-3xl font-bold text-slate-900">
                            Legajos Escalafonarios
                        </h1>
                        <p class="mt-2 text-sm text-slate-600">
                            Administre los legajos activos y pasivos del personal registrado.
                        </p>
                    </div>

                    <BaseButton variant="secondary" @click="handleBack">
                        Volver al panel
                    </BaseButton>
                </div>

                <div class="mt-8 grid gap-4 lg:grid-cols-[1fr_220px_auto_auto]">
                    <BaseInput
                        v-model="searchInput"
                        label="Buscar legajo"
                        placeholder="Buscar por número de legajo, DNI, nombres o dependencia"
                    />

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Estado
                        </label>
                        <select v-model="statusInput"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-500">
                            <option value="">Todos</option>
                            <option value="ACTIVO">Activos</option>
                            <option value="PASIVO">Pasivos</option>
                        </select>
                    </div>

                    <div class="self-end">
                        <BaseButton @click="handleSearch">
                            Buscar
                        </BaseButton>
                    </div>

                    <div class="self-end">
                        <BaseButton variant="secondary" @click="handleClear">
                            Limpiar
                        </BaseButton>
                    </div>
                </div>

                <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-slate-600">
                        Mostrando {{ legajoStore.pagination.from || 0 }} a {{ legajoStore.pagination.to || 0 }}
                        de {{ legajoStore.pagination.total }} legajos
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="text-sm text-slate-600">Registros por página</label>
                        <select v-model="legajoStore.filters.per_page"
                            class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm">
                            <option :value="10">10</option>
                            <option :value="20">20</option>
                            <option :value="50">50</option>
                        </select>
                    </div>
                </div>

                <div v-if="legajoStore.error"
                    class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-600">
                    {{ legajoStore.error }}
                </div>

                <div v-else-if="legajoStore.loading"
                    class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600">
                    Cargando legajos...
                </div>

                <div v-else-if="legajoStore.items.length === 0"
                    class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600">
                    No se encontraron legajos registrados.
                </div>

                <div v-else class="mt-6 overflow-hidden rounded-3xl border border-slate-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        N° Legajo
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Trabajador
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        DNI
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Cargo
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Dependencia
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Régimen
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Estado
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Ubicación
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 bg-white">
                                <tr v-for="item in legajoStore.items" :key="item.id" class="hover:bg-slate-50">
                                    <td class="px-4 py-4 text-sm font-semibold text-slate-900">
                                        {{ item.legajo_number }}
                                    </td>

                                    <td class="px-4 py-4 text-sm text-slate-700">
                                        {{ item.employee_form?.full_name || '-' }}
                                    </td>

                                    <td class="px-4 py-4 text-sm font-semibold text-slate-800">
                                        {{ item.employee_form?.dni || '-' }}
                                    </td>

                                    <td class="px-4 py-4 text-sm text-slate-700">
                                        {{ item.position_name || item.employee_form?.current_position || '-' }}
                                    </td>

                                    <td class="px-4 py-4 text-sm text-slate-700">
                                        {{ item.dependency?.name || '-' }}
                                    </td>

                                    <td class="px-4 py-4 text-sm text-slate-700">
                                        {{ item.labor_regime?.name || '-' }}
                                    </td>

                                    <td class="px-4 py-4 text-sm">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold" :class="item.status === 'ACTIVO'
                                            ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                                            : 'bg-slate-100 text-slate-700 ring-1 ring-slate-200'">
                                            {{ item.status }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-sm text-slate-700">
                                        {{ item.physical_location || item.digital_location || '-' }}
                                    </td>

                                    <td class="px-4 py-4">
                                        <BaseButton @click="router.push(`/admin/legajos/${item.id}`)">
                                            Ver legajo
                                        </BaseButton>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div v-if="!legajoStore.loading && legajoStore.pagination.last_page > 1"
                    class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-slate-600">
                        Página {{ legajoStore.pagination.current_page }}
                        de {{ legajoStore.pagination.last_page }}
                    </div>

                    <div class="flex gap-3">
                        <BaseButton variant="secondary" :disabled="legajoStore.pagination.current_page <= 1"
                            @click="goToPage(legajoStore.pagination.current_page - 1)">
                            Anterior
                        </BaseButton>

                        <BaseButton :disabled="legajoStore.pagination.current_page >= legajoStore.pagination.last_page"
                            @click="goToPage(legajoStore.pagination.current_page + 1)">
                            Siguiente
                        </BaseButton>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>