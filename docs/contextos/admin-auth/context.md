# Contexto: Admin/Auth

## Proposito

Gestiona el acceso administrativo para proteger paneles, edicion de fichas, legajos, documentos, PDF y exportaciones.

## Actores y permisos

- Administrador activo: puede iniciar sesion y acceder a rutas admin.
- Administrador inactivo: no puede iniciar sesion.
- Usuario no autenticado: solo accede al formulario publico y login.

## Entidades y relaciones relevantes

- `AdminUser`: usuario administrador con `name`, `email`, `password`, `is_active`.
- JWT emitido por guard `admin_api`.

## Estados y transiciones

- `adminAuth.token`: vacio -> token JWT al iniciar sesion.
- `adminAuth.initialized`: falso -> verdadero luego de `fetchMe`.
- Sesion local: `localStorage.admin_token` y `localStorage.admin_user`.
- Logout: limpia token y usuario aunque falle el backend.

## Reglas de negocio

1. El login requiere email valido y password.
2. Credenciales invalidas devuelven `401`.
3. Admin inactivo devuelve `403` y cierra la sesion del guard.
4. El frontend no debe permitir rutas admin sin `isAuthenticated`.
5. El token se envia como `Authorization: Bearer <token>`.

## Endpoints / backend involucrado

- `POST /api/admin/login` -> devuelve token y datos admin.
- `GET /api/admin/me` -> devuelve usuario autenticado.
- `POST /api/admin/logout` -> invalida/cierra sesion admin.

## Flujo de datos

1. `LoginView.vue` valida campos basicos.
2. `adminAuthStore.login()` llama a `adminLoginRequest()`.
3. Si responde correctamente, persiste token y admin en `localStorage`.
4. El router ejecuta `fetchMe()` antes de resolver rutas protegidas.
5. Axios agrega token en cada request si existe.

## UI y rutas

- Ruta publica: `/login`.
- Rutas protegidas: `/admin`, `/admin/employee-forms/:id/edit`, `/admin/legajos`, `/admin/legajos/:id`.
- Archivos principales: `frontend-formdatos/src/stores/adminAuthStore.js`, `frontend-formdatos/src/router/index.js`, `backend-formdatos/app/Http/Controllers/Api/AdminAuthController.php`.

## Errores esperables

- `401`: credenciales invalidas.
- `403`: administrador inactivo.
- Fallo en `me`: limpiar sesion local.

## Pruebas manuales minimas

1. Entrar a `/admin` sin token y confirmar redireccion a `/login`.
2. Intentar login con campos vacios.
3. Iniciar sesion con admin activo y acceder al panel.
4. Cerrar sesion y confirmar limpieza de acceso.

## Cambios recientes

- El seeder crea un administrador base para entorno local.
