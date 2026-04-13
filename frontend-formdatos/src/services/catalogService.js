import api from './api'

export const getCatalogs = async () => {
    const response = await api.get('/catalogs')
    return response.data
}