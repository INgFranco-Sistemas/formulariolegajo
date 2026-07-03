---
applyTo:
  - docker/**
  - docker-compose.yml
---

# Instrucciones especificas: Infraestructura

## Reglas de esta capa

- Seguir `docs/entorno.md` y `docs/procedimientos.md`.
- Mantener Nginx proxyando `/api/` hacia `backend:8000`.
- Mantener `client_max_body_size` compatible con carga de PDFs de legajo.
- No versionar secretos reales; los valores de compose deben tratarse como locales o de ejemplo.
- Si cambia un puerto, actualizar `docs/entorno.md` y `docs/procedimientos.md`.

## Al cerrar un cambio infra

- Ejecutar `docker compose config` cuando el cambio toque Compose.
- Para Dockerfiles o Nginx, indicar si se probo `docker compose up --build`.
