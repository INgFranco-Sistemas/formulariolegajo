import api from './api'

export const getAdminLegajoDocuments = async (legajoId) => {
    const response = await api.get(`/admin/legajos/${legajoId}/documents`)
    return response.data
}

export const uploadAdminLegajoDocument = async (legajoId, payload) => {
    const formData = new FormData()

    Object.entries(payload).forEach(([key, value]) => {
        if (value !== null && value !== undefined && value !== '') {
        formData.append(key, value)
        }
    })

    const response = await api.post(`/admin/legajos/${legajoId}/documents`, formData, {
        headers: {
        'Content-Type': 'multipart/form-data',
        },
    })

    return response.data
    }

    export const deleteAdminLegajoDocument = async (legajoId, documentId) => {
    const response = await api.delete(`/admin/legajos/${legajoId}/documents/${documentId}`)
    return response.data
}