---
applyTo:
  - backend-formdatos/**
---

# Instrucciones especificas: Backend Laravel

## Reglas de esta capa

- Seguir `docs/convenciones.md`, secciones Backend Laravel, Datos y Persistencia, Manejo de archivos y Manejo de errores.
- Leer el contexto del modulo afectado en `docs/contextos/` antes de cambiar reglas, flujo o endpoints.
- Mantener controladores API en `backend-formdatos/app/Http/Controllers/Api`.
- Usar `FormRequest` para validaciones extensas de fichas o flujos complejos.
- Mantener respuestas JSON con `success`, `data` y `message` cuando aplique.
- Proteger endpoints admin con `auth:admin_api`.
- No editar migraciones ya ejecutadas; crear nuevas migraciones.
- No exponer secretos de `.env`.

## Al cerrar un cambio backend

- Ejecutar `cd backend-formdatos && php artisan test` o explicar por que no se ejecuto.
- Si cambia un endpoint, validar que el servicio frontend correspondiente siga alineado.
- Si cambia negocio, estados o reglas, actualizar el `context.md` del modulo.
