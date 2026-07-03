# Contexto: Catalogos

## Proposito

Centraliza listas maestras usadas por el formulario y modulos admin: sexo, estado civil, regimen laboral, regimen pensionario, parentescos, dependencias y secciones de legajo.

## Actores y permisos

- Usuario publico: consume catalogos para completar la ficha.
- Administrador: consume catalogos al editar fichas y gestionar legajos.
- Backend: mantiene catalogos mediante seeders.

## Entidades y relaciones relevantes

- `Sex`, `MaritalStatus`, `LaborRegime`, `PensionRegime`, `FamilyRelationship`, `Dependency`, `LegajoSection`.
- `EmployeeForm` referencia sexo, estado civil, regimen laboral, regimen pensionario y dependencia.
- `EmployeeFormFamilyMember` referencia sexo y parentesco.
- `LegajoDocument` referencia seccion de legajo.

## Estados y transiciones

- `Dependency.is_active`: solo dependencias activas se devuelven en `GET /api/catalogs`.
- `LegajoSection.is_active`: solo secciones activas se devuelven en el detalle de legajo.

## Reglas de negocio

1. Los catalogos base se crean con seeders idempotentes.
2. Los codigos de catalogo son unicos cuando la migracion lo define.
3. Las dependencias se ordenan por nombre en el endpoint publico.
4. No eliminar catalogos referenciados por fichas o documentos sin revisar restricciones.

## Endpoints / backend involucrado

- `GET /api/catalogs` -> devuelve catalogos del formulario publico.
- `GET /api/admin/legajos/{id}` -> devuelve secciones activas junto al legajo.

## Flujo de datos

1. `catalogStore.fetchCatalogs()` llama a `getCatalogs()`.
2. El backend consulta modelos de catalogo con columnas `id`, `name`, `code`.
3. Los componentes `BaseSelect` consumen opciones por `id` y `name`.

## UI y rutas

- Se usan en `/`, `/admin/employee-forms/:id/edit` y `/admin/legajos/:id`.
- Store principal: `frontend-formdatos/src/stores/catalogStore.js`.

## Errores esperables

- Error de carga de catalogos: bloquear el formulario o mostrar mensaje de error.
- IDs inexistentes: Laravel responde `422` por reglas `exists`.

## Pruebas manuales minimas

1. Cargar formulario publico y verificar selects poblados.
2. Editar ficha admin y verificar que los catalogos aparezcan.
3. Abrir detalle de legajo y confirmar secciones activas.

## Cambios recientes

- Las dependencias institucionales estan sembradas en `DependencySeeder`.
