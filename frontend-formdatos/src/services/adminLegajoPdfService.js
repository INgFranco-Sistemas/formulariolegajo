import api from './api'

export const getLegajoFichaPdf = async (id) => {
    const response = await api.get(`/admin/legajos/${id}/ficha-pdf`, {
        responseType: 'blob',
    })

    return response
}