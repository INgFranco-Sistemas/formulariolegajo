# Entorno

## Requisitos

- Node.js `^20.19.0` o `>=22.12.0` para el frontend.
- PHP 8.2+ para Laravel; Docker usa PHP 8.3 CLI.
- Composer 2.
- Docker y Docker Compose para entorno contenedorizado.
- PostgreSQL 17 cuando se usa `docker-compose.yml`.

## Servicios Docker

| Servicio | Puerto local | Descripcion |
|----------|-------------|-------------|
| `db` | `5450 -> 5432` | PostgreSQL 17 con base `formulariolegajo`. |
| `backend` | expone `8000` dentro de la red Docker | Laravel servido con `php artisan serve`. |
| `web` | `8082 -> 80` | Nginx con frontend compilado y proxy `/api/`. |
| `frontend-builder` | sin puerto | Perfil `build` para compilar frontend con Node 20. |

## Variables backend relevantes

| Variable | Descripcion |
|----------|-------------|
| `APP_NAME` | Nombre de la aplicacion Laravel. |
| `APP_ENV` | Entorno de ejecucion. |
| `APP_KEY` | Clave de aplicacion Laravel; no versionar valores reales. |
| `APP_DEBUG` | Modo debug. |
| `APP_URL` | URL base del backend. |
| `DB_CONNECTION` | Motor de base de datos; Docker usa `pgsql`. |
| `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Conexion a base de datos. |
| `JWT_SECRET` | Secreto para tokens JWT admin; no exponer valores reales. |
| `SESSION_DRIVER`, `CACHE_STORE`, `QUEUE_CONNECTION` | Drivers operativos Laravel. |

## Variables frontend relevantes

| Variable | Descripcion |
|----------|-------------|
| `VITE_API_BASE_URL` | Base URL usada por `src/services/api.js`; default `http://127.0.0.1:8000/api`. |
| `VITE_BACKEND_URL` | URL backend usada para enlaces de archivos/PDF en vistas admin; default `http://127.0.0.1:8000`. |

## Alias y configuracion de paths

No hay alias de imports configurados en `frontend-formdatos/vite.config.js` ni en `jsconfig.json`; el codigo usa imports relativos.

## Instalacion local

```bash
# Backend
cd backend-formdatos
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# Frontend
cd frontend-formdatos
npm install
```

## Arranque local

```bash
# Backend local
cd backend-formdatos
php artisan serve

# Frontend local
cd frontend-formdatos
npm run dev

# Stack Docker
docker compose up --build
```

## Notas de seguridad

- `docker-compose.yml` contiene valores de ejemplo para despliegue local; revisar secretos antes de usar en produccion.
- No copiar valores reales de `.env` a documentacion, issues o prompts.
