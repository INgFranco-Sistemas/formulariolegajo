# Prompt: Inicializar el sistema de artefactos del proyecto

## Para qué sirve este prompt

La carpeta `_standard/` contiene plantillas genéricas con placeholders.
Tu trabajo es leer el proyecto real a fondo y generar los archivos definitivos **fuera de `_standard/`**, en la raíz del proyecto, con contenido real — sin placeholders.

**Regla absoluta: nunca modifiques nada dentro de `_standard/`. Esa carpeta es el molde; los archivos que vas a crear son el resultado.**

Los archivos de destino son:
```
./AGENT_PROTOCOL.md
./docs/guia_IA.md
./docs/convenciones.md
./docs/procedimientos.md
./docs/arquitectura.md
./docs/entorno.md
./docs/context-template.md
./.github/copilot-instructions.md
./.github/prompts/base_universal.prompt.md
./.github/prompts/codigo.prompt.md
./.github/prompts/modulo_negocio.prompt.md
./.github/prompts/revision.prompt.md
./.github/prompts/memoria_documentacion.prompt.md
./.github/prompts/generar_reporte.prompt.md
./.github/prompts/nuevo_modulo.prompt.md
./.github/instructions/<capa>.instructions.md  (una por capa tecnológica real)
<módulo>/context.md                             (uno por módulo funcional real)
```

Si alguno de esos archivos ya existe en el proyecto, mejóralo en lugar de sobreescribirlo desde cero.

No apliques ningún cambio hasta completar el análisis y recibir aprobación.

---

## Fase 1: Leer las plantillas

Lee todos los archivos de `_standard/` para entender la estructura esperada de cada artefacto:
- `_standard/AGENT_PROTOCOL.md`
- `_standard/docs/guia_IA.md`
- `_standard/docs/convenciones.md`
- `_standard/docs/procedimientos.md`
- `_standard/docs/arquitectura.md`
- `_standard/docs/entorno.md`
- `_standard/docs/context-template.md`
- `_standard/.github/copilot-instructions.md`
- `_standard/.github/instructions/capa.instructions.md`
- `_standard/.github/prompts/*.prompt.md`

Esto te da la estructura. El contenido real lo obtienes del proyecto en la siguiente fase.

---

## Fase 2: Explorar el proyecto en profundidad

Lee el proyecto real con el nivel de detalle necesario para eliminar todos los placeholders:

1. Estructura de carpetas desde la raíz (3 niveles).
2. Stack tecnológico: `package.json`, `composer.json`, `pyproject.toml`, `go.mod` o equivalente. Anota versiones y dependencias clave.
3. Archivos de configuración: `vite.config.*`, `tsconfig.*`, `.env.example`, `docker-compose.*`, `webpack.config.*`, etc.
4. Identificar todas las capas del sistema (frontend, backend, infra, etc.) y sus rutas.
5. Identificar todos los módulos funcionales (carpetas con lógica de negocio propia).
6. Leer el código de **al menos 3 módulos representativos** — uno simple y uno complejo — para inferir:
   - Convenciones de naming (archivos, funciones, clases, constantes)
   - Estructura interna de módulos
   - Cómo se gestiona el estado
   - Cómo se manejan los errores y respuestas
   - Cómo se controlan los permisos
   - Patrones recurrentes de código
7. Leer al menos un controlador/servicio backend representativo (si aplica).
8. Leer los tests existentes para entender qué flujos están cubiertos.
9. Historial reciente: `git log --oneline -20`.
10. Si ya existen `docs/`, `AGENT_PROTOCOL.md` o `context.md` en el proyecto (fuera de `_standard/`), leerlos todos para no perder lo que ya está documentado.

---

## Fase 2b: Profundizar en módulos

Para cada módulo funcional identificado:
- Leer su carpeta completa (componentes, store, modelos, rutas, tests si existen).
- Inferir: propósito, actores, entidades, estados posibles, endpoints que usa, flujo de datos, reglas de negocio visibles en el código.
- Anotar qué está claro en el código y qué es ambiguo (requiere pregunta al usuario).

---

## Fase 3: Diagnóstico — mostrar antes de editar nada

Después de explorar, presentar este diagnóstico sin tocar nada todavía:

### Estado de los artefactos de destino

| Artefacto (destino, fuera de `_standard/`) | Estado | Observaciones |
|--------------------------------------------|--------|---------------|
| `./AGENT_PROTOCOL.md` | ✅ existe completo / ⚠️ existe incompleto / ❌ falta | ... |
| `./docs/guia_IA.md` | ... | ... |
| `./docs/convenciones.md` | ... | ... |
| `./docs/procedimientos.md` | ... | ... |
| `./docs/arquitectura.md` | ... | ... |
| `./docs/entorno.md` | ... | ... |
| `./.github/copilot-instructions.md` | ... | ... |

### Capas tecnológicas detectadas

| Capa | Ruta principal | Tecnologías clave | ¿Necesita `.instructions.md`? |
|------|---------------|-------------------|-------------------------------|
| ... | ... | ... | ... |

### Módulos funcionales detectados

| Módulo | Ruta | Propósito inferido | ¿Tiene `context.md`? |
|--------|------|--------------------|----------------------|
| ... | ... | ... | ✅ / ❌ |

### Patrones de código que documentaré en `convenciones.md`

Lista concreta de los patrones inferidos del código real:
- Naming: ...
- Estructura de módulos: ...
- Manejo de estado: ...
- Manejo de errores: ...
- Autenticación y permisos: ...
- Otros: ...

### Flujos críticos que documentaré en `guia_IA.md`

Flujos que el agente debe respetar sin alterar (auth, permisos, estados de entidades clave).

### Ambigüedades que requieren respuesta tuya

Lista de preguntas concretas antes de escribir. Si no hay, decirlo explícitamente.

---

## Fase 4: Plan de trabajo

Presentar la lista de archivos que se van a crear o modificar, en orden, con una línea de descripción por cada uno.

**Esperar aprobación explícita antes de escribir cualquier archivo.**

---

## Fase 5: Construcción (solo después de aprobación)

Usar las plantillas de `_standard/` como guía de estructura y escribir los archivos definitivos en sus rutas de destino (fuera de `_standard/`).

### Reglas de construcción

- **No dejar ningún placeholder `<!-- ... -->`** en los archivos generados. Si algo es genuinamente ambiguo, escribir un comentario `<!-- PENDIENTE: <pregunta concreta> -->` y seguir.
- Inferir convenciones solo del código real; no inventar.
- Si ya existe un archivo en el destino, preservar lo que ya está correcto y mejorar lo que falta o está desactualizado.
- Si el código contradice la documentación existente, señalar la brecha y preguntar cuál es la fuente de verdad antes de escribir.
- Los prompts de `.github/prompts/` se copian tal cual desde `_standard/` (ya son genéricos); solo ajustar si el proyecto tiene convenciones que los hagan necesitar cambios.
- `docs/context-template.md` se copia tal cual desde `_standard/`; no modificarla con contenido específico del proyecto.

### Orden de escritura

1. `./AGENT_PROTOCOL.md` — adaptar tipos de tarea, rutas de capas y orden de lectura al proyecto real.
2. `./docs/arquitectura.md` — mapa real: stack, capas, carpetas, flujo de datos.
3. `./docs/entorno.md` — servicios reales, variables reales, alias reales.
4. `./docs/convenciones.md` — convenciones reales inferidas del código, sin placeholders.
5. `./docs/procedimientos.md` — comandos reales del proyecto.
6. `./docs/guia_IA.md` — comportamiento AI + índice de módulos completo.
7. `./.github/copilot-instructions.md` — adaptar idioma, prohibiciones y referencias al proyecto.
8. `./.github/instructions/<capa>.instructions.md` — una por cada capa tecnológica real.
9. `<módulo>/context.md` — uno por cada módulo funcional. Usar `docs/context-template.md` como estructura.
   - Priorizar los módulos más complejos o con más reglas de negocio visibles.
   - Para módulos simples, un `context.md` breve es mejor que ninguno.
10. Actualizar el índice de módulos en `./docs/guia_IA.md` con todos los `context.md` creados.

---

## Cierre

Al terminar, reportar:
- Qué archivos se crearon y cuáles se mejoraron
- Qué módulos tienen ahora `context.md`
- Qué `<!-- PENDIENTE: ... -->` quedaron marcados y en qué archivos
- Qué preguntas requieren respuesta tuya para cerrar esas brechas
