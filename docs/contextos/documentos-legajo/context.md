# Contexto: Documentos de Legajo

## Proposito

Permite incorporar, listar y eliminar documentos PDF dentro de un legajo escalafonario, clasificados por seccion.

## Actores y permisos

- Administrador autenticado: sube, consulta y elimina documentos.
- Backend: valida archivo, almacena PDF y recalcula folios.

## Entidades y relaciones relevantes

- `LegajoDocument`: documento individual.
- `Legajo`: contenedor del documento.
- `LegajoSection`: clasificacion del documento.

## Estados y transiciones

- `verification_status`: `PENDIENTE`, `VERIFICADO` u `OBSERVADO` desde la UI.
- `is_sensitive`: indica documento con datos sensibles.
- `folios_total` del legajo cambia al crear o eliminar documentos.

## Reglas de negocio

1. Solo se aceptan archivos PDF.
2. El tamano maximo permitido es 10 MB.
3. Cada documento debe pertenecer a una seccion existente.
4. `document_name` es obligatorio.
5. Si se informan `folios_start` y `folios_end`, `folios_count` se calcula como rango inclusivo, minimo cero.
6. Si no se informa `incorporation_date`, backend usa la fecha actual.
7. Si no se informa `verification_status`, backend usa `PENDIENTE`.
8. Al eliminar, se borra el archivo fisico si existe y luego el registro.

## Endpoints / backend involucrado

- `GET /api/admin/legajos/{legajoId}/documents` -> lista documentos de un legajo.
- `POST /api/admin/legajos/{legajoId}/documents` -> sube PDF y crea documento.
- `DELETE /api/admin/legajos/{legajoId}/documents/{documentId}` -> elimina documento.

## Flujo de datos

1. `AdminLegajoDetailView.vue` carga legajo y documentos.
2. El usuario selecciona una seccion y abre `AdminUploadLegajoDocumentModal`.
3. El store arma `FormData` y envia multipart.
4. Backend guarda archivo en `storage/app/public/legajos/<id>/seccion-<numero>`.
5. Backend recalcula `folios_total`.
6. Frontend recarga documentos y detalle de legajo.

## UI y rutas

- Ruta: `/admin/legajos/:id`.
- Componentes: `AdminUploadLegajoDocumentModal.vue`.
- Store: `frontend-formdatos/src/stores/adminLegajoDocumentStore.js`.
- Servicio: `frontend-formdatos/src/services/adminLegajoDocumentService.js`.
- Controlador: `backend-formdatos/app/Http/Controllers/Api/AdminLegajoDocumentController.php`.

## Errores esperables

- `422`: falta seccion, nombre o archivo.
- `422`: archivo no PDF o mayor a 10 MB.
- `404`: legajo o documento no encontrados.
- Error de almacenamiento: mostrar mensaje general.

## Pruebas manuales minimas

1. Subir PDF valido a una seccion.
2. Intentar subir archivo no PDF.
3. Intentar subir PDF mayor a 10 MB.
4. Verificar recalculo de folios.
5. Eliminar documento y confirmar que desaparece del listado.

## Cambios recientes

- Se agrego carga de documentos por secciones del legajo.
