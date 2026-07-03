# Convenciones

## 1. Generales

- Idioma de documentacion, UI y mensajes al usuario: espanol.
- Nombres de clases PHP: PascalCase.
- Nombres de metodos PHP y funciones JavaScript: camelCase.
- Nombres de modelos y relaciones Eloquent: singular en PascalCase para clases, camelCase para relaciones.
- Nombres de tablas y campos: snake_case en ingles.
- Componentes Vue: PascalCase en archivos `.vue`.
- Stores Pinia: `use<Modulo>Store` y archivo `<modulo>Store.js`.
- Servicios HTTP frontend: funciones con verbo de accion y archivo `<modulo>Service.js`.

## 2. Frontend Vue

### Estructura

- Las vistas viven en `frontend-formdatos/src/views`.
- Los componentes base viven en `frontend-formdatos/src/components/base`.
- Los componentes especificos de formulario y admin viven en `frontend-formdatos/src/components/form`.
- Los pasos del formulario publico viven en `frontend-formdatos/src/components/form/steps`.
- La comunicacion HTTP vive en `frontend-formdatos/src/services`.
- El estado de flujo, carga, errores y paginacion vive en `frontend-formdatos/src/stores`.

### Estado y stores

- Usar Pinia con Composition API (`defineStore`, `ref`, `computed`).
- Cada store mantiene banderas `loading`, mensajes `error` y estados especificos como `editSaving`, `uploadLoading` o `submitSuccess`.
- Las llamadas al backend se encapsulan en servicios; las vistas no deben llamar directamente a Axios.
- Normalizar IDs numericos antes de enviar payloads al backend.

### Rutas

- Las rutas admin usan `meta.requiresAdminAuth`.
- La ruta `/login` usa `meta.guestOnly`.
- El guard global llama `authStore.fetchMe()` una vez cuando la sesion no esta inicializada.
- Si falta autenticacion admin, redirigir a `/login`.

### Estilos y UI

- El proyecto usa Tailwind CSS 4.
- Mantener la composicion visual existente: fondos `slate`, tarjetas blancas, bordes suaves y estados `red`/`emerald`.
- Reutilizar `BaseInput`, `BaseSelect` y `BaseButton` antes de crear controles nuevos.
- Los formularios muestran errores por campo mediante props `error`.

## 3. Backend Laravel

### Rutas y controladores

- Las rutas API viven en `backend-formdatos/routes/api.php`.
- Los controladores API viven en `backend-formdatos/app/Http/Controllers/Api`.
- Las rutas admin protegidas van dentro de `Route::middleware('auth:admin_api')`.
- Los endpoints publicos actuales son catalogos, verificacion de DNI y registro de ficha.

### Validacion

- Para fichas usar `FormRequest`: `StoreEmployeeFormRequest` y `UpdateAdminEmployeeFormRequest`.
- Para endpoints pequenos se permite `$request->validate()` en el controlador.
- Mensajes de validacion se escriben en espanol.
- Reglas condicionales existentes:
  - `conadis_rui` es obligatorio si `has_disability` es verdadero.
  - `labor_end_date` es obligatorio si `has_labor_link` es falso.
  - `family_members` requiere al menos un elemento si `is_parent` es verdadero en registro publico.

### Respuestas

- Respuesta exitosa JSON: `success: true`, `data` y `message` cuando aplica.
- Respuesta de error de negocio: `success: false`, `message` y codigo HTTP adecuado.
- Laravel devuelve errores `422` con `errors` para validacion.
- Los listados usan paginacion Laravel y se devuelven dentro de `data`.

### Autenticacion y autorizacion

- La autenticacion admin usa guard `admin_api` con JWT.
- El frontend guarda `admin_token` y `admin_user` en `localStorage`.
- El interceptor Axios agrega `Authorization: Bearer <token>` si existe token.
- No hay permisos granulares por rol en el codigo actual; solo usuario admin activo/inactivo.

## 4. Datos y persistencia

- Las migraciones nuevas deben agregarse como archivos nuevos; no editar migraciones ya ejecutadas salvo instruccion explicita.
- Los catalogos base se cargan con seeders idempotentes (`updateOrInsert` o `updateOrCreate`).
- `EmployeeForm` convierte strings a mayusculas en eventos `creating` y `updating`.
- Las relaciones se cargan con `with()` y seleccion de columnas cuando el endpoint lo permite.
- La apertura de legajos copia datos laborales vigentes desde la ficha al momento de crear el legajo.

## 5. Manejo de archivos

- Los documentos de legajo aceptan solo PDF y maximo 10 MB.
- Los archivos se guardan en disk `public`, ruta `legajos/<id>/seccion-<numero>`.
- Al eliminar un documento, se borra tambien el archivo fisico si existe.
- Luego de crear o eliminar documentos se recalcula `folios_total`.

## 6. Manejo de errores

- `422`: validacion o regla de negocio recuperable.
- `401`: credenciales invalidas o sesion no autenticada.
- `403`: admin inactivo o accion prohibida.
- `404`: recurso no encontrado.
- `500`: fallos tecnicos reales.

## 7. Formato de commits

No hay formato formal documentado en el historial. Usar prefijos convencionales en espanol o ingles de forma consistente:
- `feat: descripcion`
- `fix: descripcion`
- `docs: descripcion`
- `refactor: descripcion`
- `chore: descripcion`

## 8. Calidad y cierre

- Mantener cambios pequenos y dentro del alcance.
- No reordenar imports, whitespace ni bloques no relacionados.
- Revisar residuos antes de cerrar: variables, imports, flags, helpers o ramas no usadas.
- Ejecutar validacion tecnica segun `docs/procedimientos.md`.
