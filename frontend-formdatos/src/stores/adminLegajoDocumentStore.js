import { defineStore } from 'pinia'
import { ref } from 'vue'
import {
    deleteAdminLegajoDocument,
    getAdminLegajoDocuments,
    uploadAdminLegajoDocument,
} from '../services/adminLegajoDocumentService'

export const useAdminLegajoDocumentStore = defineStore('adminLegajoDocuments', () => {
    const items = ref([])
    const loading = ref(false)
    const error = ref('')

    const uploadLoading = ref(false)
    const uploadError = ref('')
    const uploadSuccess = ref('')

    const fetchDocuments = async (legajoId) => {
        loading.value = true
        error.value = ''

        try {
        const response = await getAdminLegajoDocuments(legajoId)
        items.value = response.data ?? []
        } catch (err) {
        error.value =
            err?.response?.data?.message ||
            'No se pudieron cargar los documentos del legajo.'
        } finally {
        loading.value = false
        }
    }

    const uploadDocument = async (legajoId, payload) => {
        uploadLoading.value = true
        uploadError.value = ''
        uploadSuccess.value = ''

        try {
        const response = await uploadAdminLegajoDocument(legajoId, payload)

        uploadSuccess.value = response.message || 'Documento incorporado correctamente.'
        await fetchDocuments(legajoId)

        return { success: true, data: response.data }
        } catch (err) {
        if (err?.response?.status === 422) {
            const errors = err.response.data.errors || {}
            uploadError.value =
            Object.values(errors)?.[0]?.[0] ||
            'Revise los datos del documento.'
        } else {
            uploadError.value =
            err?.response?.data?.message ||
            'No se pudo incorporar el documento.'
        }

        return { success: false }
        } finally {
        uploadLoading.value = false
        }
    }

    const deleteDocument = async (legajoId, documentId) => {
        try {
        await deleteAdminLegajoDocument(legajoId, documentId)
        await fetchDocuments(legajoId)
        return { success: true }
        } catch (err) {
        error.value =
            err?.response?.data?.message ||
            'No se pudo eliminar el documento.'
        return { success: false }
        }
    }

    const clearUploadState = () => {
        uploadError.value = ''
        uploadSuccess.value = ''
    }

    const documentsBySection = (sectionId) => {
        return items.value.filter((item) => Number(item.legajo_section_id) === Number(sectionId))
    }

    return {
        items,
        loading,
        error,
        uploadLoading,
        uploadError,
        uploadSuccess,
        fetchDocuments,
        uploadDocument,
        deleteDocument,
        clearUploadState,
        documentsBySection,
    }
})