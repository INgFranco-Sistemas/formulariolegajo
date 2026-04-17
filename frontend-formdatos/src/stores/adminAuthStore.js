import { defineStore } from 'pinia'
import { computed, ref } from 'vue'
import {
    adminLoginRequest,
    adminLogoutRequest,
    adminMeRequest,
} from '../services/adminAuthService'

export const useAdminAuthStore = defineStore('adminAuth', () => {
    const token = ref(localStorage.getItem('admin_token') || '')
    const admin = ref(
        localStorage.getItem('admin_user')
        ? JSON.parse(localStorage.getItem('admin_user'))
        : null
    )

  const loading = ref(false)
    const error = ref('')
    const initialized = ref(false)

    const isAuthenticated = computed(() => !!token.value)

    const clearError = () => {
        error.value = ''
    }

    const persistSession = (jwtToken, adminData) => {
        token.value = jwtToken
        admin.value = adminData

        localStorage.setItem('admin_token', jwtToken)
        localStorage.setItem('admin_user', JSON.stringify(adminData))
    }

    const clearSession = () => {
        token.value = ''
        admin.value = null

        localStorage.removeItem('admin_token')
        localStorage.removeItem('admin_user')
    }

    const login = async (credentials) => {
        loading.value = true
        error.value = ''

        try {
        const response = await adminLoginRequest(credentials)

        persistSession(response.data.token, response.data.admin)

        return { success: true }
        } catch (err) {
        error.value =
            err?.response?.data?.message ||
            'No se pudo iniciar sesión. Intente nuevamente.'

        return { success: false }
        } finally {
        loading.value = false
        }
    }

    const fetchMe = async () => {
        if (!token.value) {
        initialized.value = true
        return
        }

        try {
        const response = await adminMeRequest()
        admin.value = response.data
        localStorage.setItem('admin_user', JSON.stringify(response.data))
        } catch {
        clearSession()
        } finally {
        initialized.value = true
        }
    }

    const logout = async () => {
        try {
        if (token.value) {
            await adminLogoutRequest()
        }
        } catch {
        // aunque falle el backend, limpiamos la sesión local
        } finally {
        clearSession()
        }
    }

        return {
        token,
        admin,
        loading,
        error,
        initialized,
        isAuthenticated,
        clearError,
        login,
        fetchMe,
        logout,
        clearSession,
    }
})