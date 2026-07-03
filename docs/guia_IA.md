# Guia para la IA

## Punto de entrada operativo

Antes de actuar en cualquier tarea, leer `AGENT_PROTOCOL.md` y seguirlo como checklist.
`docs/` y `.github/` son la fuente normativa; `AGENT_PROTOCOL.md` es el operativo.

## Estilo de respuesta

- Idioma: espanol.
- Tono: conciso, directo y con pasos claros.
- Referencias a archivos: rutas relativas.
- No inventar datos; si el codigo no permite inferir algo, marcarlo como pendiente o preguntar.

## Comportamientos transversales

- Aplicar estrictamente toda la documentacion del proyecto.
- Verificar siempre impacto en memoria antes de cerrar.
- No inventar endpoints, permisos, nombres de campos ni estructuras.
- El negocio especifico vive en `docs/contextos/*/context.md`.
- No modificar `_standard/`; contiene plantillas.
- No exponer credenciales ni valores reales de `.env`.

## Flujos criticos del sistema

- Registro publico de ficha: catalogos, validacion por pasos, verificacion de DNI, envio final y persistencia transaccional con familiares.
- Autenticacion admin: login JWT, token en `localStorage`, guard de rutas Vue y middleware `auth:admin_api`.
- Gestion admin de fichas: listado paginado, busqueda, detalle, edicion y exportacion Excel.
- Apertura de legajo: una ficha solo puede tener un legajo; el numero se genera con anio, correlativo y DNI.
- Documentos de legajo: solo PDF, maximo 10 MB, clasificacion por seccion, recalculo de folios al crear o eliminar.
- Generacion PDF: usa datos de legajo y ficha con plantilla Blade `pdf.ficha-datos-generales`.

## Reglas de analisis de memoria

- Leer reglas una a una y compararlas con el cambio pedido.
- Si hay ambiguedad o conflicto, detenerse y pedir confirmacion.
- Si se agrega una regla nueva, ubicarla en el archivo normativo correcto.
- Si se crea un nuevo `context.md`, indexarlo aqui antes de cerrar.
- Si cambia un modulo, revisar su contexto antes de tocar codigo.

## Contextos de modulos

- Formulario/Publico: `docs/contextos/formulario-publico/context.md`
- Catalogos: `docs/contextos/catalogos/context.md`
- Admin/Auth: `docs/contextos/admin-auth/context.md`
- Admin/Fichas: `docs/contextos/admin-fichas/context.md`
- Legajos: `docs/contextos/legajos/context.md`
- Documentos de Legajo: `docs/contextos/documentos-legajo/context.md`
- Reportes y Exportaciones: `docs/contextos/reportes-exportaciones/context.md`
