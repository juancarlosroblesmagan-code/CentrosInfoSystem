# 04 · Páginas del sitio

Inventario completo de páginas WordPress activas. IDs reales en producción.

---

## Home

| Campo | Valor |
|-------|-------|
| ID | 4524 |
| Slug | (raíz) `/` |
| Título interno | `Demo Main` |
| Editor | Elementor |
| Estado | Publicado · página estática asignada como home |

Construida con Elementor. El contenido fue **localizado al español** vía edición directa del meta `_elementor_data` (search & replace REST API) para eliminar:

- "Share Your Knowledge. Teach the World." → "Comparte tu conocimiento. Forma al mundo."
- "Package Courses" → "Cursos destacados"
- "Our courses are designed to be simple…" → versión española equivalente
- "No deadlines. No pressure." → "Sin agobios. A tu ritmo."

Imágenes con texto en inglés en la sección de Categorías quedan pendientes de reemplazo si se quiere pulir más.

---

## Listado de cursos (Woo archive personalizado)

| Campo | Valor |
|-------|-------|
| Slug | `/cursos-subvencionados-castilla-la-mancha/` |
| Tipo | Archive WooCommerce con redirect/categoría |
| Categoría | `Cursos Castilla la Mancha` |
| Botón producto | "Leer más" (reemplaza "Añadir al carrito") |

Aquí se listan los cursos a 0 €. Al hacer click en "Leer más" se va a la ficha del producto, que muestra **el formulario de inscripción** en lugar de los controles de compra.

Existe un redirect 301 de `/cursos-gratis/` → `/cursos-subvencionados-castilla-la-mancha/` (configurado en la rewrite/plugin de redirects).

---

## Páginas institucionales

| ID | Slug | Título | Notas |
|----|------|--------|-------|
| 16719 | `/contacto/` | Contacto | Datos NAP + CF7 13916 |
| 16707 | `/trabaja-con-nosotros/` | Trabaja con nosotros | Form CF7 14376 con adjunto CV |
| 16729 | `/preguntas-frecuentes/` | Preguntas frecuentes | 28 FAQs + schema FAQPage |
| — | `/about-us/` (o `/conocenos/`) | Conócenos | Página institucional Eduma |

### `/contacto/` (ID 16719)

Contenido tipo: encabezado, datos de cada uno de los 4 centros (NAP), email `info@infosystem.net`, teléfono `+34 926 33 11 62`, y el shortcode:

```
[contact-form-7 id="13916" title="Contact Us"]
```

### `/trabaja-con-nosotros/` (ID 16707)

Página de captación de personal docente para los 4 centros.

```html
<h2>Trabaja con nosotros</h2>
<p>En Infosystem buscamos continuamente <strong>tutores, formadores y personal docente</strong>
   con experiencia para nuestros centros de Castilla-La Mancha…</p>

[contact-form-7 id="14376" title="Trabaja con nosotros"]
```

> Nota: hubo en su día un duplicado `/trabaja-con-nosotros-2/` (ID 16723) que se eliminó tras fusionar el contenido en la página 16707.

### `/preguntas-frecuentes/` (ID 16729)

Documentación detallada en [`06-faq.md`](06-faq.md).

- 28 preguntas estructuradas con `<h3>` (pregunta) + `<p>` (respuesta).
- 5 secciones temáticas con `<h2>`.
- Enlaces internos a `/cursos-subvencionados-castilla-la-mancha/`, productos, `/contacto/`.
- SEO con Rank Math:
  - Title: *"Preguntas frecuentes - Cursos subvencionados Castilla-La Mancha | Infosystem"*
  - Description: optimizada
  - Focus keyword: `preguntas frecuentes cursos subvencionados`

---

## Páginas previas (corregidas durante el setup)

- `/conocenos/` → existía vacía y devolvía 404 desde el menú: se rellenó con contenido institucional.
- `/cursos-gratis/` → redirigía a productos demo: se cambió por redirect 301 a `/cursos-subvencionados-castilla-la-mancha/`.

---

## Eliminadas durante la limpieza

- **18 posts demo en inglés** (Working Smart with AI, Why You Should Read Every Day, Succeed in an Online Course, etc.) — borrados permanentemente vía REST API. Nota: aún aparecen en `/post-sitemap.xml` por caché de WP Rocket (ver [`docs/10-pending-tasks.md`](10-pending-tasks.md)).
- **8 eventos demo** del CPT `tp_event` (Education Autumn Tour, etc.).
- Duplicado `/trabaja-con-nosotros-2/` (ID 16723).

---

## Estructura jerárquica final

```
/
├─ /cursos-subvencionados-castilla-la-mancha/
│  ├─ /curso-de-gestion-de-negocios-online-2-0-clm/      (producto)
│  └─ /curso-ofimatica-en-la-nube-con-google-drive-clm/  (producto)
├─ /about-us/  (Conócenos)
├─ /blog/
│  ├─ /blog/2026/05/26/cursos-subvencionados-sepe-castilla-la-mancha-2026/
│  ├─ /blog/2026/05/26/cursos-gratis-desempleados-ciudad-real-jccm/
│  ├─ /blog/2026/05/26/formacion-bonificada-fundae-empresas-castilla-la-mancha/
│  ├─ /blog/2026/05/26/cursos-online-trabajadores-activo-subvencionados/
│  ├─ /blog/2026/05/26/certificados-profesionalidad-gratis-castilla-la-mancha/
│  ├─ /blog/2026/05/26/centros-infosystem-ciudad-real/
│  ├─ /blog/2026/05/26/cursos-mas-demandados-castilla-la-mancha-2026/
│  ├─ /blog/2026/05/26/formacion-dual-castilla-la-mancha-guia/
│  ├─ /blog/2026/05/26/ofimatica-nube-google-drive-por-que-aprenderlo/
│  └─ /blog/2026/05/26/gestion-negocios-online-emprender-castilla-la-mancha/
├─ /preguntas-frecuentes/
├─ /contacto/
└─ /trabaja-con-nosotros/
```
