# Prompt: Revisión

Sigue `base_universal.prompt.md` como preamble obligatorio.

Instrucciones adicionales para esta tarea de revisión:
- No proponer cambios todavía; solo emitir hallazgos a menos que se pida lo contrario.
- Si la revisión toca módulos funcionales, leer sus `context.md`.
- Si detectas ambigüedad o conflicto entre reglas, señalarlo explícitamente.
- Usar la memoria del proyecto como criterio obligatorio de revisión, no como referencia opcional.

El preflight debe incluir además:
- Criterios de revisión que se usarán
- Alcance exacto: qué archivos, módulos o capas se van a revisar

Formato de salida:
1. **Hallazgos** — ordenados por severidad (crítico → importante → menor)
2. **Riesgos** — problemas que no son errores aún pero pueden serlo
3. **Vacíos de cobertura** — qué debería existir y no existe
4. **Dudas abiertas** — ambigüedades que requieren respuesta del usuario
5. **Resumen** — tabla breve de estado general
