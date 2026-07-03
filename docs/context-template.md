# Plantilla de context.md por módulo

## Objetivo
Estandarizar la documentación de negocio y flujo real por módulo.
El `context.md` es la sede principal del modelo de negocio del módulo. No duplicar aquí reglas que ya estén en `docs/convenciones.md`; solo documentar lo específico de este módulo.

---

## Estructura obligatoria

```markdown
# Contexto: <Namespace/Módulo>

## Propósito
Qué problema resuelve este módulo en una o dos oraciones.

## Actores y permisos
Quiénes interactúan con el módulo y qué pueden hacer.
- Actor 1: permisos / rol
- Actor 2: permisos / rol

## Entidades y relaciones relevantes
Modelos de datos principales que usa o gestiona el módulo.

## Estados y transiciones
Si el módulo maneja entidades con estados, documentar el diagrama:
- estado_a → estado_b (condición)
- estado_a → estado_c (condición)

## Reglas de negocio
Lista numerada de las reglas que la IA debe respetar al tocar este módulo.
1. Regla 1
2. Regla 2

## Endpoints / backend involucrado
- `MÉTODO /ruta` → descripción breve
- `MÉTODO /ruta` → descripción breve

## Flujo de datos (si aplica)
Cómo viajan los datos desde la UI hasta el backend y de vuelta.

## UI y rutas
- Ruta: `/ruta-del-módulo`
- Componentes principales: ComponenteA.vue, ComponenteB.vue
- Acciones visibles: crear, editar, eliminar, etc.

## Errores esperables
Qué errores puede devolver el backend y cómo debe reaccionar el frontend.

## Pruebas manuales mínimas
Pasos para verificar que el módulo funciona correctamente.
1. Paso 1
2. Paso 2

## Cambios recientes (opcional)
Decisiones de diseño o cambios no obvios recientes que impactan cómo trabaja el módulo.
```

---

## Reglas

- Todo módulo funcional real debe tener `context.md`.
- El negocio específico del módulo vive aquí, no en la documentación global.
- Si el módulo cambia su flujo, reglas o endpoints relevantes, este archivo debe actualizarse antes de cerrar la tarea.
- Si se crea un nuevo `context.md`, debe indexarse en `docs/guia_IA.md`.
- No documentar aquí convenciones de código generales; solo lo específico de este módulo.
