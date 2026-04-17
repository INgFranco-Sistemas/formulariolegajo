<script setup>
import { RouterLink } from 'vue-router'
</script>

<template>
    <div class="min-h-screen bg-slate-100 text-slate-800">
        <header class="border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <div>
                    <p class="text-sm font-medium text-slate-500">Plataforma institucional</p>
                    <h1 class="text-lg font-bold text-slate-900 sm:text-xl">
                        Ficha de Datos Generales
                    </h1>
                </div>

                <div class="flex items-center gap-3">
                    <RouterLink
                        to="/login"
                        class="rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                    >
                        Iniciar sesión
                    </RouterLink>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-600">
                        Registro único por trabajador
                    </div>
                </div>
            </div>
        </header>
        <main>
            <slot />
        </main>

        <footer class="border-t border-slate-200 bg-white">
            <div div class="mx-auto max-w-7xl px-4 py-4 text-sm text-slate-500 sm:px-6 lg:px-8">
                Sistema institucional de registro de datos del personal
            </div>
        </footer>
    </div>
</template>