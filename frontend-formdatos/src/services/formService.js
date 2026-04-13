import api from './api'

export const checkDniExists = async (dni) => {
    const response = await api.post('/employee-forms/check-dni', { dni })
    return response.data
}

export const submitEmployeeForm = async (payload) => {
    const response = await api.post('/employee-forms', payload)
    return response.data
}