# Agent Protocol

## Rol de este archivo
Punto de entrada operativo para cualquier agente AI que trabaje en este repositorio.
No reemplaza la memoria normativa de `docs/` ni `.github/`; define el orden de lectura, el loop de trabajo y lo que debe mostrarse al usuario.
Si una regla de este archivo choca con `docs/` o `.github/`, detenerse, explicar el conflicto y pedir confirmacion.

## Orden de lectura obligatorio antes de actuar

### Siempre
1. `AGENT_PROTOCOL.md`
2. `docs/guia_IA.md`
3. `.github/copilot-instructions.md`
4. `docs/convenciones.md`
5. `docs/procedimientos.md`

### Si la tarea toca backend Laravel
6. `.github/instructions/backend.instructions.md`
7. `context.md` del modulo funcional afectado en `docs/contextos/`

### Si la tarea toca frontend Vue
6. `.github/instructions/frontend.instructions.md`
7. `context.md` del modulo funcional afectado en `docs/contextos/`

### Si la tarea toca Docker, Nginx o despliegue
6. `.github/instructions/infra.instructions.md`
7. `docs/entorno.md`

### Si se crea o reestructura un contexto de modulo
6. `docs/context-template.md`
7. Actualizar el indice de contextos en `docs/guia_IA.md`

## Clasificacion de tareas

| Tipo | Senal |
|------|-------|
| `backend` | Cambios en `backend-formdatos/**` |
| `frontend` | Cambios en `frontend-formdatos/**` |
| `infra` | Cambios en `docker/**`, `docker-compose.yml`, Dockerfiles o Nginx |
| `memoria` | Cambios en `docs/**`, `.github/**`, `AGENT_PROTOCOL.md` o `context.md` |
| `review` | Auditoria de cumplimiento, deuda, riesgos o inconsistencias |
| `reporte` | Resumen de cambios, pruebas, riesgos y proximos pasos |

## Loop obligatorio de trabajo

1. Identificar tipo de tarea y modulos afectados.
2. Leer la memoria aplicable en el orden definido arriba.
3. Detectar ambiguedad, colision entre reglas o informacion faltante.
4. Si hay ambiguedad o colision: detenerse y pedir confirmacion antes de editar.
5. Si no hay conflicto: explicar al usuario que se va a hacer y cual sera el primer paso.
6. Explorar el codigo real antes de proponer cambios.
7. Aplicar cambios minimos, coherentes y dentro del alcance pedido.
8. Verificar impacto en memoria antes de cerrar.
9. Ejecutar validaciones requeridas segun el tipo de cambio.
10. Cerrar con reporte corto: cambios, validaciones y riesgos pendientes.

## Preflight obligatorio antes de editar

Antes de tocar cualquier archivo, mostrar:
- Archivos de memoria leidos.
- Reglas aplicables a la tarea.
- Archivos que se van a modificar y objetivo de cada uno.
- Validaciones finales que se ejecutaran al cerrar.

## Cierre obligatorio

Al finalizar cualquier tarea mostrar:
- Que cambio.
- Que validaciones se ejecutaron y su resultado.
- Si hubo impacto en memoria.
- Que riesgos o pendientes quedaron.

## Reglas de memoria

- `docs/` y `.github/` son reglas del proyecto, no referencia opcional.
- El negocio especifico de cada modulo vive en `docs/contextos/<modulo>/context.md`.
- Si cambia un patron, convencion o flujo documentado, evaluar si la memoria necesita actualizarse.
- Si se crea un nuevo `context.md`, indexarlo en `docs/guia_IA.md` antes de cerrar.
- No duplicar reglas completas en varios archivos; enlazar a la fuente oficial.

## Reglas de ejecucion

- No improvisar endpoints, nombres, permisos ni estructuras.
- No exponer credenciales ni valores sensibles de `.env`.
- No modificar `_standard/`; es solo el molde.
- No reordenar imports, whitespace ni bloques no relacionados fuera del alcance.
- Al cerrar cambios frontend: ejecutar `npm run build` en `frontend-formdatos` si el cambio toca codigo de aplicacion.
- Al cerrar cambios backend: ejecutar `php artisan test` en `backend-formdatos` o explicar por que no se ejecuto.
- Al cerrar cambios de infraestructura: validar con `docker compose config` cuando aplique.

## Regla de evidencia

Cuando el usuario pida seguir este archivo, actuar como lista de control obligatoria.
Si no se leyo alguno de los archivos requeridos para la tarea, decirlo explicitamente antes de editar.
