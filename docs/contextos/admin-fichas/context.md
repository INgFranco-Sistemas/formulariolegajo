# Contexto: Admin/Fichas

## Proposito

Permite al administrador listar, buscar, revisar, editar y exportar fichas registradas por trabajadores.
Tambien es el punto desde el que se abre un legajo para una ficha sin legajo.

## Actores y permisos

- Administrador autenticado: consulta, edita, exporta y abre legajos.
- Backend admin: protege rutas con `auth:admin_api`.

## Entidades y relaciones relevantes

- `EmployeeForm` con relaciones a catalogos, familiares, dependencia y legajo.
- `EmployeeFormFamilyMember` se reemplaza completamente al actualizar la ficha.
- `Legajo` se consulta para saber si la ficha ya tiene legajo.

## Estados y transiciones

- Listado: filtros `search`, `page`, `per_page`.
- Detalle: `selectedItem`, `detailOpen`, `detailLoading`, `detailError`.
- Edicion: `editItem`, `editSaving`, `editErrors`, `editSuccess`.
- Exportacion: `exportLoading`, `exportError`.

## Reglas de negocio

1. El listado busca por DNI, nombre, correo personal, correo institucional o dependencia.
2. `per_page` se limita entre 1 y 100 en backend.
3. La edicion mantiene DNI unico ignorando la ficha actual.
4. Al editar, los familiares existentes se eliminan y se crean nuevamente desde el payload.
5. Una ficha que ya tiene legajo no debe abrir otro legajo desde el panel.
6. La exportacion Excel incluye fichas con catalogos principales.

## Endpoints / backend involucrado

- `GET /api/admin/employee-forms` -> listado paginado.
- `GET /api/admin/employee-forms/{id}` -> detalle.
- `PUT /api/admin/employee-forms/{id}` -> edicion.
- `GET /api/admin/employee-forms-export` -> archivo Excel.
- `POST /api/admin/legajos` -> apertura de legajo desde ficha.

## Flujo de datos

1. `AdminDashboardView.vue` llama `formsStore.fetchForms()`.
2. El store pasa filtros al servicio `adminEmployeeFormService`.
3. Para editar, el store normaliza fechas a `YYYY-MM-DD` y convierte IDs a numeros al guardar.
4. El backend valida con `UpdateAdminEmployeeFormRequest`.
5. En exito, el frontend usa `sessionStorage` para mostrar mensaje al volver al panel.

## UI y rutas

- Ruta listado: `/admin`.
- Ruta edicion: `/admin/employee-forms/:id/edit`.
- Vistas: `AdminDashboardView.vue`, `AdminEmployeeFormEditView.vue`.
- Componentes: `AdminEmployeeFormDetailModal.vue`, `AdminOpenLegajoModal.vue`.
- Store: `adminEmployeeFormStore.js`.

## Errores esperables

- `422`: errores de validacion de ficha; se mapean por campo en edicion.
- `404`: ficha no encontrada.
- Error de exportacion: mostrar `exportError`.

## Pruebas manuales minimas

1. Login admin y cargar `/admin`.
2. Buscar por DNI, nombre y dependencia.
3. Abrir detalle de una ficha.
4. Editar una ficha y confirmar persistencia.
5. Intentar duplicar DNI y confirmar error.
6. Exportar Excel.
7. Confirmar que una ficha con legajo no permite abrir otro.

## Cambios recientes

- El historial reciente incluye filtrado, ficha y exportacion Excel.
