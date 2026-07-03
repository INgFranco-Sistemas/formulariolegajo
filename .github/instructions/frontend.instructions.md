---
applyTo:
  - frontend-formdatos/**
---

# Instrucciones especificas: Frontend Vue

## Reglas de esta capa

- Seguir `docs/convenciones.md`, secciones Frontend Vue, Manejo de errores y Calidad.
- Leer el contexto del modulo afectado en `docs/contextos/` antes de cambiar flujo, UI o reglas.
- Usar Composition API en Vue y Pinia.
- Encapsular llamadas HTTP en `src/services`; las vistas usan stores.
- Mantener guard admin con `meta.requiresAdminAuth` y `meta.guestOnly`.
- Reutilizar `BaseInput`, `BaseSelect` y `BaseButton` cuando sea posible.
- No relajar validaciones frontend si el backend mantiene reglas mas estrictas.

## Al cerrar un cambio frontend

- Ejecutar `cd frontend-formdatos && npm run build`.
- Si cambia un endpoint usado por la UI, revisar el servicio y store correspondiente.
- Si cambia negocio, estados o reglas, actualizar el `context.md` del modulo.
