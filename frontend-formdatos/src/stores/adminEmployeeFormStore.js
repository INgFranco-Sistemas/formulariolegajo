import { defineStore } from 'pinia'
import { ref } from 'vue'
import {
    getAdminEmployeeFormById,
    getAdminEmployeeForms,
    updateAdminEmployeeForm,
} from '../services/adminEmployeeFormService'

export const useAdminEmployeeFormStore = defineStore('adminEmployeeForms', () => {
    const items = ref([])
    const loading = ref(false)
    const error = ref('')

    const selectedItem = ref(null)
    const detailLoading = ref(false)
    const detailError = ref('')
    const detailOpen = ref(false)

    const editItem = ref(null)
    const editLoading = ref(false)
    const editSaving = ref(false)
    const editError = ref('')
    const editSuccess = ref('')
    const editErrors = ref({})

    const pagination = ref({
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0,
        from: 0,
        to: 0,
    })

    const filters = ref({
        search: '',
        page: 1,
        per_page: 10,
    })

    const fetchForms = async () => {
        loading.value = true
        error.value = ''

        try {
        const response = await getAdminEmployeeForms(filters.value)
        const payload = response.data

        items.value = payload.data ?? []

        pagination.value = {
            current_page: payload.current_page ?? 1,
            last_page: payload.last_page ?? 1,
            per_page: payload.per_page ?? 10,
            total: payload.total ?? 0,
            from: payload.from ?? 0,
            to: payload.to ?? 0,
        }
        } catch (err) {
        error.value =
            err?.response?.data?.message ||
            'No se pudo cargar el listado de fichas.'
        } finally {
        loading.value = false
        }
    }

    const fetchFormById = async (id) => {
        detailLoading.value = true
        detailError.value = ''

        try {
        const response = await getAdminEmployeeFormById(id)
        selectedItem.value = response.data
        detailOpen.value = true
        } catch (err) {
        detailError.value =
            err?.response?.data?.message ||
            'No se pudo cargar el detalle de la ficha.'
        } finally {
        detailLoading.value = false
        }
    }

    const fetchEditableFormById = async (id) => {
        editLoading.value = true
        editError.value = ''
        editSuccess.value = ''
        editErrors.value = {}

    try {
        const response = await getAdminEmployeeFormById(id)
        const item = response.data

        editItem.value = {
            id: item.id,
            full_name: item.full_name ?? '',
            dni: item.dni ?? '',
            ruc: item.ruc ?? '',
            sex_id: item.sex_id ?? '',
            marital_status_id: item.marital_status_id ?? '',
            birth_date: item.birth_date ?? '',
            birth_place: item.birth_place ?? '',
            has_disability: item.has_disability ?? false,
            conadis_rui: item.conadis_rui ?? '',
            address: item.address ?? '',
            reference: item.reference ?? '',
            district: item.district ?? '',
            province: item.province ?? '',
            department: item.department ?? '',
            cellphone: item.cellphone ?? '',
            personal_email: item.personal_email ?? '',
            emergency_contact_name: item.emergency_contact_name ?? '',
            emergency_contact_phone: item.emergency_contact_phone ?? '',
            profession: item.profession ?? '',
            current_position: item.current_position ?? '',
            current_dependency: item.current_dependency ?? '',
            contract_resolution_number: item.contract_resolution_number ?? '',
            employment_start_date: item.employment_start_date ?? '',
            labor_regime_id: item.labor_regime_id ?? '',
            labor_condition: item.labor_condition ?? '',
            pension_regime_id: item.pension_regime_id ?? '',
            airshsp_code: item.airshsp_code ?? '',
            institutional_email: item.institutional_email ?? '',
            has_labor_link: item.has_labor_link ?? true,
            labor_end_date: item.labor_end_date ?? '',
            is_parent: item.is_parent ?? false,
            family_members: (item.family_members ?? []).map((member) => ({
            full_name: member.full_name ?? '',
            dni: member.dni ?? '',
            age: member.age ?? '',
            sex_id: member.sex_id ?? '',
            relationship_id: member.relationship_id ?? '',
            })),
        }
        } catch (err) {
        editError.value =
            err?.response?.data?.message ||
            'No se pudo cargar la ficha para edición.'
        } finally {
        editLoading.value = false
        }
    }

    const normalizeEditPayload = () => {
        if (!editItem.value) return null

        return {
        ...editItem.value,
        sex_id: editItem.value.sex_id ? Number(editItem.value.sex_id) : null,
        marital_status_id: editItem.value.marital_status_id ? Number(editItem.value.marital_status_id) : null,
        labor_regime_id: editItem.value.labor_regime_id ? Number(editItem.value.labor_regime_id) : null,
        pension_regime_id: editItem.value.pension_regime_id ? Number(editItem.value.pension_regime_id) : null,
        family_members: (editItem.value.family_members ?? []).map((member) => ({
            ...member,
            age: member.age !== '' ? Number(member.age) : null,
            sex_id: member.sex_id ? Number(member.sex_id) : null,
            relationship_id: member.relationship_id ? Number(member.relationship_id) : null,
        })),
        }
    }

    const updateForm = async (id) => {
        editSaving.value = true
        editError.value = ''
        editSuccess.value = ''
        editErrors.value = {}

        try {
        const payload = normalizeEditPayload()
        const response = await updateAdminEmployeeForm(id, payload)

        editSuccess.value = response.message || 'La ficha fue actualizada correctamente.'
        return { success: true, data: response.data }
        } catch (err) {
        if (err?.response?.status === 422) {
            const backendErrors = err.response.data.errors || {}

            Object.entries(backendErrors).forEach(([field, messages]) => {
            editErrors.value[field] = Array.isArray(messages) ? messages[0] : messages
            })

            editError.value = 'Se encontraron errores de validación.'
        } else {
            editError.value =
            err?.response?.data?.message ||
            'No se pudo actualizar la ficha.'
        }

        return { success: false }
        } finally {
        editSaving.value = false
        }
    }

    const closeDetail = () => {
        detailOpen.value = false
        selectedItem.value = null
        detailError.value = ''
    }

    const clearEditState = () => {
        editItem.value = null
        editLoading.value = false
        editSaving.value = false
        editError.value = ''
        editSuccess.value = ''
        editErrors.value = {}
    }

    const setSearch = (value) => {
        filters.value.search = value
        filters.value.page = 1
    }

    const goToPage = async (page) => {
        if (page < 1 || page > pagination.value.last_page) return

        filters.value.page = page
        await fetchForms()
    }

    const refresh = async () => {
        await fetchForms()
    }

    return {
        items,
        loading,
        error,
        selectedItem,
        detailLoading,
        detailError,
        detailOpen,
        editItem,
        editLoading,
        editSaving,
        editError,
        editSuccess,
        editErrors,
        pagination,
        filters,
        fetchForms,
        fetchFormById,
        fetchEditableFormById,
        updateForm,
        closeDetail,
        clearEditState,
        setSearch,
        goToPage,
        refresh,
    }
})