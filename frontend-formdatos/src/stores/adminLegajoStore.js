import { defineStore } from "pinia";
import { ref } from "vue";
import {
    createAdminLegajo,
    getAdminLegajoById,
    getAdminLegajos,
} from '../services/adminLegajoService'

export const useAdminLegajoStore = defineStore("adminLegajos", () => {
    const items = ref([]);
    const loading = ref(false);
    const error = ref("");

    const selectedLegajo = ref(null)
    const sections = ref([])
    const detailLoading = ref(false)
    const detailError = ref('')

    const createLoading = ref(false);
    const createError = ref("");
    const createSuccess = ref("");

    const pagination = ref({
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0,
        from: 0,
        to: 0,
    });

    const filters = ref({
        search: "",
        status: "",
        page: 1,
        per_page: 10,
    });

    const fetchLegajos = async () => {
        loading.value = true;
        error.value = "";

        try {
        const response = await getAdminLegajos(filters.value);
        const payload = response.data;

        items.value = payload.data ?? [];

        pagination.value = {
            current_page: payload.current_page ?? 1,
            last_page: payload.last_page ?? 1,
            per_page: payload.per_page ?? 10,
            total: payload.total ?? 0,
            from: payload.from ?? 0,
            to: payload.to ?? 0,
        };
        } catch (err) {
        error.value =
            err?.response?.data?.message ||
            "No se pudo cargar el listado de legajos.";
        } finally {
        loading.value = false;
        }
    };

    const createLegajo = async (payload) => {
        createLoading.value = true;
        createError.value = "";
        createSuccess.value = "";

        try {
        const response = await createAdminLegajo(payload);

        createSuccess.value =
            response.message || "Legajo aperturado correctamente.";

        return {
            success: true,
            data: response.data,
            message: createSuccess.value,
        };
        } catch (err) {
        createError.value =
            err?.response?.data?.message || "No se pudo aperturar el legajo.";

        return {
            success: false,
            message: createError.value,
        };
        } finally {
        createLoading.value = false;
        }
    };

    const fetchLegajoById = async (id) => {
        detailLoading.value = true
        detailError.value = ''
        selectedLegajo.value = null
        sections.value = []

        try {
            const response = await getAdminLegajoById(id)

            selectedLegajo.value = response.data.legajo
            sections.value = response.data.sections ?? []

            return { success: true }
        } catch (err) {
            detailError.value =
            err?.response?.data?.message ||
            'No se pudo cargar el detalle del legajo.'

            return { success: false }
        } finally {
            detailLoading.value = false
        }
    }

    const clearCreateMessages = () => {
        createError.value = "";
        createSuccess.value = "";
    };

    return {
        items,
        loading,
        error,
        createLoading,
        createError,
        createSuccess,
        pagination,
        filters,
        fetchLegajos,
        createLegajo,
        clearCreateMessages,
        selectedLegajo,
        sections,
        detailLoading,
        detailError,
        fetchLegajoById,
    };
});
