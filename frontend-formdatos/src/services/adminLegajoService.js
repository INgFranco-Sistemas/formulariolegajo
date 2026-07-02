import api from "./api";

export const createAdminLegajo = async (payload) => {
    const response = await api.post("/admin/legajos", payload);
    return response.data;
};

export const getAdminLegajos = async (params = {}) => {
    const response = await api.get("/admin/legajos", { params });
    return response.data;
};

export const getAdminLegajoById = async (id) => {
    const response = await api.get(`/admin/legajos/${id}`)
    return response.data
}