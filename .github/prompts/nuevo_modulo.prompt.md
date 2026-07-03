# Prompt: Nuevo módulo (backend + frontend)

Sigue `base_universal.prompt.md` como preamble obligatorio.

Instrucciones adicionales para crear un módulo nuevo:

## Antes de escribir código
1. Verificar que no exista ya un módulo con el mismo propósito o uno similar.
2. Leer `docs/arquitectura.md` para entender dónde debe vivir el nuevo módulo.
3. Leer `docs/context-template.md` para saber qué documentar.
4. Si el módulo tiene dependencias de otro módulo, leer su `context.md`.

## Preflight adicional
- Nombre del módulo propuesto (en inglés, según convenciones)
- Namespace al que pertenece
- Permisos que requiere (patrón `<módulo>.(view|create|edit|delete)`)
- Entidades de datos que gestiona
- Dependencias de otros módulos

## Orden de trabajo obligatorio

### Backend
1. Migración (nueva tabla o cambio de esquema)
2. Modelo con relaciones y docblocks
3. Controlador con middleware de permisos
4. Registro en rutas (`apiResource`)
5. Seeder de permisos y menú
6. Tests mínimos

### Frontend
1. Core model (`src/core/<namespace>/<modelo>.js`)
2. Store Pinia (`src/stores/<namespace>/<modelo>.js`)
3. Componentes del módulo (`src/modules/<namespace>/<módulo>/`)
4. Registro de ruta con `meta.permissions`
5. Entrada de menú (si aplica)
6. `context.md` del módulo
7. Indexar en `docs/guia_IA.md`

## Al finalizar
- Confirmar que el `context.md` existe y está completo
- Confirmar que está indexado en `docs/guia_IA.md`
- Si se creó tabla nueva, confirmar que se registró en los scripts de backup (si aplica)
- Ejecutar validaciones de cierre de ambas capas
