import api from './api'

export const getAdminEmployeeForms = async (params = {}) => {
    const response = await api.get('/admin/employee-forms', { params })
    return response.data
}

export const getAdminEmployeeFormById = async (id) => {
    const response = await api.get(`/admin/employee-forms/${id}`)
    return response.data
}

export const updateAdminEmployeeForm = async (id, payload) => {
    const response = await api.put(`/admin/employee-forms/${id}`, payload)
    return response.data
}

export const exportAdminEmployeeFormsExcel = async () => {
    const response = await api.get('/admin/employee-forms-export', {
        responseType: 'blob',
    })

    return response
}