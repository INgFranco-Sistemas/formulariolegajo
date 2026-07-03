# Instrucciones para el agente AI

## Punto de entrada operativo

Antes de actuar en cualquier tarea, leer `AGENT_PROTOCOL.md` y seguir obligatoriamente:
- Su orden de lectura de memoria.
- Su loop de trabajo.
- Su checklist de preflight y cierre.

`AGENT_PROTOCOL.md` es operativo. `docs/` y `.github/` son la fuente normativa.

## Estilo de respuesta

- Idioma: espanol.
- Respuestas concisas y directas.
- Encabezados y listas solo si aportan legibilidad.
- Referenciar archivos con rutas relativas.
- No inventar datos; pedir confirmacion o marcar pendiente.

## Prohibiciones absolutas

- No modificar `_standard/`.
- No acceder a red externa salvo pedido explicito.
- No exponer credenciales ni datos sensibles.
- No modificar memoria (`docs/`, `.github/`, contextos) sin aprobacion explicita.
- No omitir validaciones criticas.
- No improvisar endpoints, nombres, campos o estructuras.

## Convenciones clave

- Reglas tecnicas globales: `docs/convenciones.md`.
- Procedimientos operativos: `docs/procedimientos.md`.
- Arquitectura y capas: `docs/arquitectura.md`.
- Entorno y variables: `docs/entorno.md`.
- Negocio por modulo: `docs/contextos/*/context.md`.

## Manejo de inconsistencias

Si aparece un patron no documentado, proponer en que archivo debe agregarse y esperar aprobacion antes de aplicarlo.
