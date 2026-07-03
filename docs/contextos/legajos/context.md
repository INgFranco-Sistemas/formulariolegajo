# Contexto: Legajos

## Proposito

Gestiona la apertura, busqueda y detalle de legajos escalafonarios asociados a fichas de trabajadores.

## Actores y permisos

- Administrador autenticado: crea y consulta legajos.
- Trabajador: no accede a legajos.

## Entidades y relaciones relevantes

- `Legajo`: legajo principal.
- `EmployeeForm`: ficha origen; cada ficha puede tener un solo legajo.
- `Dependency` y `LaborRegime`: se copian desde la ficha al crear legajo.
- `LegajoSection`: secciones activas para organizar documentos.
- `LegajoDocument`: documentos incorporados al legajo.

## Estados y transiciones

- `Legajo.status`: actualmente se crea como `ACTIVO`; la UI filtra `ACTIVO` y `PASIVO`.
- `opening_date`: se establece con la fecha actual al crear.
- `folios_total`: se recalcula desde documentos, no se edita manualmente en el flujo actual.

## Reglas de negocio

1. Una ficha no puede tener mas de un legajo.
2. El numero de legajo se genera como `LEG-YYYY-#####-DNI`.
3. El correlativo se calcula por cantidad de legajos creados en el anio actual mas uno.
4. Al crear legajo se copian dependencia, regimen laboral y cargo actual desde la ficha.
5. El estado inicial es `ACTIVO`.
6. El detalle de legajo debe cargar ficha completa, catalogos relacionados y secciones activas.

## Endpoints / backend involucrado

- `GET /api/admin/legajos` -> listado paginado con filtros.
- `POST /api/admin/legajos` -> apertura de legajo.
- `GET /api/admin/legajos/{id}` -> detalle, ficha y secciones.

## Flujo de datos

1. Desde el panel admin se abre modal de legajo para una ficha sin legajo.
2. El frontend envia `employee_form_id`, ubicaciones y observaciones.
3. Backend verifica que no exista legajo para esa ficha.
4. Backend crea legajo en transaccion y responde con datos cargados.
5. El listado de legajos permite buscar por numero, trabajador, DNI o dependencia y filtrar por estado.

## UI y rutas

- Listado: `/admin/legajos`.
- Detalle: `/admin/legajos/:id`.
- Vista relacionada desde panel: `/admin`.
- Store: `frontend-formdatos/src/stores/adminLegajoStore.js`.
- Servicios: `frontend-formdatos/src/services/adminLegajoService.js`.
- Controlador: `backend-formdatos/app/Http/Controllers/Api/AdminLegajoController.php`.

## Errores esperables

- `422`: trabajador ya cuenta con legajo.
- `422`: `employee_form_id` inexistente o faltante.
- `404`: legajo o ficha no encontrados.

## Pruebas manuales minimas

1. Abrir legajo para una ficha sin legajo.
2. Intentar abrir segundo legajo para la misma ficha.
3. Buscar legajo por numero, DNI, nombre y dependencia.
4. Filtrar por `ACTIVO`.
5. Abrir detalle y verificar secciones activas.

## Cambios recientes

- Se agrego modulo escalafonario con legajos, secciones y documentos.
