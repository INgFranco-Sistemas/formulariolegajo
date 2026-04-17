<script setup>
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import BaseButton from '../components/base/BaseButton.vue'
import BaseInput from '../components/base/BaseInput.vue'
import { useAdminAuthStore } from '../stores/adminAuthStore'

const router = useRouter()
const authStore = useAdminAuthStore()

const form = reactive({
    email: '',
    password: '',
})

const errors = reactive({
    email: '',
    password: '',
})

const clearFieldErrors = () => {
    errors.email = ''
    errors.password = ''
}

const validateForm = () => {
    clearFieldErrors()
    authStore.clearError()

    let valid = true

    if (!form.email.trim()) {
        errors.email = 'El correo es obligatorio.'
        valid = false
    }

    if (!form.password.trim()) {
        errors.password = 'La contraseña es obligatoria.'
        valid = false
    }

    return valid
}

const handleLogin = async () => {
    if (!validateForm()) return

    const result = await authStore.login({
        email: form.email,
        password: form.password,
    })

    if (result.success) {
        router.push('/admin')
    }
}
</script>

<template>
    <main class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-slate-200">
        <section class="mx-auto flex min-h-screen max-w-7xl items-center px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid w-full gap-8 lg:grid-cols-[1fr_0.9fr]">
            <div class="flex flex-col justify-center">
            <span
                class="mb-4 inline-flex w-fit items-center rounded-full border border-slate-200 bg-white px-4 py-1 text-sm font-medium text-slate-600 shadow-sm"
            >
                Acceso administrativo
            </span>

            <h1 class="text-4xl font-bold leading-tight text-slate-900 sm:text-5xl">
                Iniciar sesión
            </h1>

            <p class="mt-5 max-w-2xl text-base leading-7 text-slate-600 sm:text-lg">
                Ingrese con su cuenta de administrador para gestionar la información
                registrada por el personal de la institución.
            </p>
            </div>

            <div class="flex items-center">
                <div class="w-full rounded-[2rem] bg-white p-6 shadow-2xl ring-1 ring-slate-200 sm:p-8">
                    <div class="mb-6">
                    <p class="text-sm font-medium text-slate-500">Panel administrativo</p>
                    <h2 class="mt-1 text-2xl font-bold text-slate-900">
                        Acceso seguro
                    </h2>
                    </div>

                    <div
                    v-if="authStore.error"
                    class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-600"
                    >
                    {{ authStore.error }}
                    </div>

                    <div class="space-y-5">
                    <BaseInput
                        v-model="form.email"
                        type="email"
                        label="Correo electrónico"
                        placeholder="admin@institucion.gob.pe"
                        :error="errors.email"
                    />

                    <BaseInput
                        v-model="form.password"
                        type="password"
                        label="Contraseña"
                        placeholder="Ingrese su contraseña"
                        :error="errors.password"
                    />

                    <div class="pt-2">
                        <BaseButton
                            :fullWidth="true"
                            :disabled="authStore.loading"
                            @click="handleLogin"
                            >
                            {{ authStore.loading ? 'Ingresando...' : 'Ingresar' }}
                        </BaseButton>
                    </div>

                    <div class="text-center">
                        <RouterLink
                        to="/"
                        class="text-sm font-medium text-slate-600 hover:text-slate-900"
                        >
                        Volver al formulario público
                        </RouterLink>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </main>
</template>