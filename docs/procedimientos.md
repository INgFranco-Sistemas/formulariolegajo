# Procedimientos

## Objetivo

Concentrar pasos operativos del proyecto: entorno, desarrollo, validacion y despliegue.
Antes de ejecutar una tarea de desarrollo, leer `AGENT_PROTOCOL.md`.

## Entorno y arranque

```bash
# Instalar dependencias backend
cd backend-formdatos
composer install

# Instalar dependencias frontend
cd frontend-formdatos
npm install

# Levantar stack Docker
docker compose up --build
```

Servicios esperados con Docker:
- `web` en `http://localhost:8082`
- PostgreSQL en `localhost:5450`
- API Laravel accesible via `http://localhost:8082/api`

## Desarrollo local

```bash
# Backend
cd backend-formdatos
php artisan serve

# Frontend
cd frontend-formdatos
npm run dev
```

## Migraciones y datos base

```bash
# Crear migracion
cd backend-formdatos
php artisan make:migration nombre_de_la_migracion

# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders
php artisan db:seed

# Migrar y sembrar desde cero en entorno local
php artisan migrate:fresh --seed
```

Reglas:
- Crear migraciones nuevas para modificar tablas existentes.
- No editar migraciones ya ejecutadas sin aprobacion explicita.
- Mantener seeders idempotentes para catalogos y datos base.

## Validacion tecnica

### Backend

```bash
cd backend-formdatos
php artisan test
```

La suite actual solo contiene tests base de ejemplo; para cambios funcionales importantes, agregar o describir pruebas manuales especificas.

### Frontend

```bash
cd frontend-formdatos
npm run build
```

No hay script de lint configurado en `frontend-formdatos/package.json`.

### Infraestructura

```bash
docker compose config
docker compose up --build
```

## Build de produccion

```bash
# Frontend
cd frontend-formdatos
npm run build

# Backend optimizaciones utiles
cd backend-formdatos
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Flujos operativos frecuentes

### Crear una ficha publica

1. Cargar catalogos con `GET /api/catalogs`.
2. Validar DNI con `POST /api/employee-forms/check-dni`.
3. Enviar ficha con `POST /api/employee-forms`.
4. Verificar que se cree `employee_forms` y, si aplica, `employee_form_family_members`.

### Abrir un legajo

1. Iniciar sesion admin.
2. Listar fichas desde `/admin`.
3. Abrir modal de legajo para una ficha sin legajo.
4. Crear con `POST /api/admin/legajos`.
5. Verificar numero `LEG-YYYY-#####-DNI` y estado `ACTIVO`.

### Incorporar documento a legajo

1. Abrir detalle de legajo.
2. Seleccionar seccion activa.
3. Subir PDF maximo 10 MB.
4. Verificar documento, ruta de archivo y recalculo de folios.

## Cierre tecnico obligatorio

Antes de declarar una tarea como completa:

1. Revisar si el cambio afecta memoria (`docs/`, `.github/`, `AGENT_PROTOCOL.md`, `docs/contextos/**/context.md`).
2. Ejecutar validacion segun capa:
   - Backend: `php artisan test`.
   - Frontend: `npm run build`.
   - Infra: `docker compose config`.
3. Si cambia negocio, estados o endpoints de un modulo, actualizar su `context.md`.
4. Si se crea un contexto nuevo, indexarlo en `docs/guia_IA.md`.
