# Contexto: Reportes y Exportaciones

## Proposito

Genera salidas documentales desde la informacion registrada: Excel de trabajadores y PDF de ficha de datos generales.

## Actores y permisos

- Administrador autenticado: descarga Excel y visualiza/descarga PDF.
- Backend: genera archivos con librerias Laravel Excel y DomPDF.

## Entidades y relaciones relevantes

- `EmployeeForm`: fuente principal de datos.
- Catalogos asociados: sexo, estado civil, regimen laboral, regimen pensionario y dependencia.
- `Legajo`: contenedor para la ficha PDF.
- `EmployeeFormFamilyMember`: familiares impresos en PDF.

## Estados y transiciones

- Exportacion Excel: `exportLoading` y `exportError` en `adminEmployeeFormStore`.
- PDF: se solicita como blob desde `adminLegajoPdfService`.

## Reglas de negocio

1. El Excel se ordena por ficha descendente.
2. Los encabezados del Excel estan en mayusculas y orientados a trabajadores.
3. Los booleanos se exportan como `SI` o `NO` en Excel.
4. El PDF usa plantilla `resources/views/pdf/ficha-datos-generales.blade.php`.
5. El PDF se genera en A4 vertical y se nombra con el DNI de la ficha.

## Endpoints / backend involucrado

- `GET /api/admin/employee-forms-export` -> descarga Excel.
- `GET /api/admin/legajos/{id}/ficha-pdf` -> stream PDF de ficha de datos generales.

## Flujo de datos

1. Para Excel, el frontend solicita blob y crea enlace temporal de descarga.
2. Backend usa `EmployeeFormsExport` con `FromCollection`, `WithHeadings` y `WithMapping`.
3. Para PDF, backend carga legajo con ficha y relaciones.
4. DomPDF renderiza la vista Blade y retorna stream.

## UI y rutas

- Excel: boton en `/admin`.
- PDF: detalle `/admin/legajos/:id`.
- Servicios: `adminEmployeeFormService.js`, `adminLegajoPdfService.js`.
- Backend: `EmployeeFormsExport.php`, `AdminLegajoPdfController.php`.

## Errores esperables

- Error de exportacion: mostrar `exportError`.
- `404`: legajo no encontrado para PDF.
- Fallo de render PDF: mostrar mensaje general en la vista admin.

## Pruebas manuales minimas

1. Descargar Excel desde `/admin` y abrirlo.
2. Confirmar encabezados y datos principales.
3. Abrir detalle de legajo y solicitar ficha PDF.
4. Confirmar que el PDF contiene datos personales, contacto, laborales y familiares.

## Cambios recientes

- El historial reciente incluye exportacion Excel y ficha.
