import api from './api'

export const adminLoginRequest = async (payload) => {
    const response = await api.post('/admin/login', payload)
    return response.data
}

export const adminMeRequest = async () => {
    const response = await api.get('/admin/me')
    return response.data
}

export const adminLogoutRequest = async () => {
    const response = await api.post('/admin/logout')
    return response.data
}