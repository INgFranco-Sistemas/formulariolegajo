import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import AdminDashboardView from '../views/AdminDashboardView.vue'
import { useAdminAuthStore } from '../stores/adminAuthStore'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
        path: '/',
        name: 'home',
        component: HomeView,
        },
        {
        path: '/login',
        name: 'login',
        component: LoginView,
        meta: { guestOnly: true },
        },
        {
        path: '/admin',
        name: 'admin-dashboard',
        component: AdminDashboardView,
        meta: { requiresAdminAuth: true },
        },
        {
        path: '/admin/employee-forms/:id/edit',
        name: 'admin-employee-form-edit',
        component: () => import('../views/AdminEmployeeFormEditView.vue'),
        meta: { requiresAdminAuth: true },
        },
    ],
})

router.beforeEach(async (to) => {
    const authStore = useAdminAuthStore()

    if (!authStore.initialized) {
        await authStore.fetchMe()
    }

    if (to.meta.requiresAdminAuth && !authStore.isAuthenticated) {
        return '/login'
    }

    if (to.meta.guestOnly && authStore.isAuthenticated) {
        return '/admin'
    }

    return true
})

export default router