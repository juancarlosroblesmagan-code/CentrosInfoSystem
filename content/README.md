# Contenido fuente

## `faq-content.html`

Copia exacta del contenido publicado en `/preguntas-frecuentes/` (página WordPress ID 16729). Estructura:

- `<h1>` título principal.
- `<h2>` por cada una de las 5 secciones temáticas.
- `<h3>` para cada pregunta.
- `<p>` con la respuesta inmediatamente debajo de cada `<h3>`.

Este formato es el que **espera el parser del schema FAQPage** (función `infosys_seo_faq_schema()` del snippet WPCode). No cambiar la estructura sin actualizar también el regex del snippet.

### Cómo re-publicar el contenido

Si por cualquier motivo hay que recrear la página:

1. Crear página nueva en WordPress.
2. Slug: `preguntas-frecuentes`.
3. Pegar el contenido de `faq-content.html` en modo **HTML / Código** del editor (no en visual).
4. Publicar.
5. Rellenar Rank Math (title, description, focus keyword) — ver `docs/06-faq.md`.
6. Verificar en frontend que el JSON-LD `FAQPage` aparece (DevTools).
