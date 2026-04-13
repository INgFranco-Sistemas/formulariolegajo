import { defineStore } from 'pinia'
import { ref } from 'vue'
import { getCatalogs } from '../services/catalogService'

export const useCatalogStore = defineStore('catalog', () => {
    const sexes = ref([])
    const maritalStatuses = ref([])
    const laborRegimes = ref([])
    const pensionRegimes = ref([])
    const familyRelationships = ref([])

    const loading = ref(false)
    const error = ref('')

    const fetchCatalogs = async () => {
        loading.value = true
        error.value = ''

        try {
            const response = await getCatalogs()

            sexes.value = response.data.sexes ?? []
            maritalStatuses.value = response.data.marital_statuses ?? []
            laborRegimes.value = response.data.labor_regimes ?? []
            pensionRegimes.value = response.data.pension_regimes ?? []
            familyRelationships.value = response.data.family_relationships ?? []
        } catch (err) {
            error.value =
                err?.response?.data?.message ||
                'No se pudieron cargar los catálogos del formulario.'
        } finally {
            loading.value = false
        }
    }

    return {
        sexes,
        maritalStatuses,
        laborRegimes,
        pensionRegimes,
        familyRelationships,
        loading,
        error,
        fetchCatalogs,
    }
})