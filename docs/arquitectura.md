# Arquitectura del proyecto

## Stack actual

- Frontend: Vue 3.5, Vite 8, Pinia 3, Vue Router 5, Axios, Tailwind CSS 4.
- Backend: Laravel 12, PHP 8.2+, JWT Auth, Sanctum, DomPDF, Laravel Excel.
- Base de datos: PostgreSQL 17 en Docker; `.env.example` local conserva configuracion Laravel por defecto con SQLite.
- Infraestructura: Docker Compose con servicios `db`, `backend`, `frontend-builder` y `web`; Nginx sirve el frontend y proxya `/api/` al backend.

## Capas del sistema

| # | Capa | Responsabilidad | Donde vive |
|---|------|-----------------|------------|
| 1 | Negocio por modulo | Actores, reglas, estados, endpoints y flujos | `docs/contextos/*/context.md` |
| 2 | Persistencia y dominio | Migraciones, modelos Eloquent, relaciones y seeders | `backend-formdatos/database`, `backend-formdatos/app/Models` |
| 3 | Contrato API | Endpoints REST JSON, auth admin, exportaciones y PDF | `backend-formdatos/routes/api.php`, `backend-formdatos/app/Http/Controllers/Api` |
| 4 | Estado cliente | Stores Pinia, normalizacion de payloads, errores y paginacion | `frontend-formdatos/src/stores` |
| 5 | Presentacion | Vistas, componentes, formularios, modales y rutas | `frontend-formdatos/src/views`, `frontend-formdatos/src/components`, `frontend-formdatos/src/router` |
| 6 | Infraestructura | Contenedores, Nginx, variables de despliegue | `docker-compose.yml`, `docker/**` |

## Mapa de carpetas frontend

```text
frontend-formdatos/
├── src/components/base     Componentes reutilizables de formulario y botones.
├── src/components/form     Componentes del formulario publico y modales admin.
├── src/components/form/steps Pasos del formulario publico.
├── src/composables         Logica reutilizable, como carga de ubigeo.
├── src/layouts             Layout publico.
├── src/router              Rutas publicas y protegidas admin.
├── src/services            Cliente Axios y llamadas HTTP.
├── src/stores              Estado Pinia y reglas de flujo cliente.
└── src/views               Pantallas publicas y administrativas.
```

## Mapa de carpetas backend

```text
backend-formdatos/
├── app/Exports             Exportacion Excel de fichas.
├── app/Http/Controllers/Api Controladores REST y generacion PDF.
├── app/Http/Requests       Validaciones FormRequest de fichas.
├── app/Models              Modelos Eloquent y relaciones.
├── config                  Configuracion Laravel, auth, JWT, CORS y servicios.
├── database/migrations     Esquema de catalogos, fichas, admin y legajos.
├── database/seeders        Datos base de catalogos, secciones y admin.
├── resources/views/pdf     Plantilla Blade para ficha PDF.
├── routes                  Rutas API, web y consola.
└── tests                   Tests base de Laravel; cobertura funcional aun minima.
```

## Flujo global de datos

1. El frontend carga catalogos desde `GET /api/catalogs`.
2. El usuario completa el formulario publico por pasos en Pinia.
3. El frontend valida campos por paso y verifica DNI con `POST /api/employee-forms/check-dni`.
4. El envio final usa `POST /api/employee-forms`; Laravel valida, guarda la ficha y familiares en transaccion.
5. El admin inicia sesion con JWT y accede a listados, edicion, apertura de legajos, documentos, PDF y Excel.

## Principios de diseño

- El backend es la fuente de verdad para validacion y persistencia.
- El frontend duplica validaciones solo para experiencia de usuario; no debe relajar reglas del backend.
- Las respuestas API usan una envoltura recurrente con `success`, `message` cuando aplica y `data`.
- Los textos de negocio y datos personales se normalizan mayoritariamente a mayusculas antes de persistir.
- Los contextos de modulo son la fuente para reglas de negocio especificas.

## Componentes y helpers compartidos

- `frontend-formdatos/src/services/api.js`: instancia Axios con base URL, headers JSON y token bearer admin.
- `frontend-formdatos/src/composables/useUbigeo.js`: carga y sincroniza departamento, provincia y distrito.
- `frontend-formdatos/src/components/base/BaseInput.vue`: input base con label y error.
- `frontend-formdatos/src/components/base/BaseSelect.vue`: select base con opciones por `id` y `name`.
- `frontend-formdatos/src/components/base/BaseButton.vue`: boton base con variantes.
- `backend-formdatos/app/Models/EmployeeForm.php`: normaliza strings a mayusculas en `creating` y `updating`.

## Donde vive cada tipo de conocimiento

| Conocimiento | Archivo |
|--------------|---------|
| Reglas globales y tecnicas | `docs/convenciones.md` |
| Procedimientos operativos | `docs/procedimientos.md` |
| Arquitectura y mapa del sistema | `docs/arquitectura.md` |
| Entorno y variables | `docs/entorno.md` |
| Protocolo de trabajo del agente | `AGENT_PROTOCOL.md` |
| Negocio por modulo | `docs/contextos/*/context.md` |
