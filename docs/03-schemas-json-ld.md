# 03 · Schemas JSON-LD

Todos los schemas custom se inyectan desde el **WPCode snippet ID 16728** "Infosystem SEO - Schemas JSON-LD". El código completo está en [`snippets/infosystem-seo-snippet.php`](../snippets/infosystem-seo-snippet.php).

> Verificado en producción: todas las páginas emiten los schemas esperados (ver tabla "Validación" al final).

---

## Hooks usados

```php
add_action('wp_head', 'infosys_seo_meta_extra', 4);     // OG + geo meta
add_action('wp_head', 'infosys_seo_organization', 5);    // EducationalOrganization + LocalBusiness x4
add_action('wp_head', 'infosys_seo_website', 6);         // WebSite + SearchAction
add_action('wp_head', 'infosys_seo_breadcrumbs', 7);     // BreadcrumbList dinámico
add_action('wp_head', 'infosys_seo_course_schema', 8);   // Course (solo en productos)
add_action('wp_head', 'infosys_seo_article_schema', 9);  // BlogPosting (solo en posts)
add_action('wp_head', 'infosys_seo_faq_schema', 10);     // FAQPage (solo en /preguntas-frecuentes/)
```

---

## 1. `EducationalOrganization` + `LocalBusiness`

Se inyecta en **todas las páginas** del frontend. Combina:

- 1 organización padre (`@id`: `…/#infosys-organization`)
- 4 sucursales (`department[]`) — una por cada centro físico:
  - Santa Cruz de Mudela (`#infosys-centro-santa-cruz-de-mudela`)
  - Viso del Marqués (`#infosys-centro-viso-del-marques`)
  - Fuente el Fresno (`#infosys-centro-fuente-del-fresno`)
  - Membrilla (`#infosys-centro-membrilla`)

Cada sucursal tiene:

- `PostalAddress` (calle, ciudad, CP, provincia, país)
- `GeoCoordinates` (lat, lon)
- `OpeningHoursSpecification` (L-V mañana 09:00-14:00 + tarde 16:00-20:00)
- `priceRange: "Gratuito"`
- `parentOrganization` → `#infosys-organization`

El organismo principal aporta:

- `foundingDate: 1995`
- `areaServed`: las 5 provincias de CLM + Ciudad Real
- `knowsAbout`: temas de formación
- `hasCredential`: reconocida por SEPE, JCCM y FUNDAE
- `sameAs`: enlaces a Facebook, Instagram, LinkedIn (placeholder; sustituir por URLs reales)

> Sustituir `sameAs` por las URLs reales de redes sociales cuando estén creadas.

---

## 2. `WebSite` + `SearchAction`

Permite que Google muestre la **Sitelinks Search Box** en SERPs. URL de búsqueda: `?s={search_term_string}` (búsqueda nativa de WordPress).

```json
{
  "@type": "WebSite",
  "url": "https://...",
  "potentialAction": {
    "@type": "SearchAction",
    "target": ".../?s={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
```

---

## 3. `BreadcrumbList`

Generado dinámicamente en función del tipo de página:

| Tipo | Ruta |
|------|------|
| Home | (no se emite) |
| Post de blog | Inicio › Blog › [Título del post] |
| Producto (curso) | Inicio › Cursos gratis subvencionados › [Curso] |
| Página con padres | Inicio › [Páginas ancestro] › [Página] |
| Página suelta | Inicio › [Página] |
| Categoría / tag / taxonomía | Inicio › [Término] |
| Archive de productos / shop | Inicio › Cursos gratis subvencionados |

`@id` incluye `#breadcrumb` para evitar colisión con Rank Math.

---

## 4. `Course` (solo en productos WooCommerce)

Inyectado **solo en `is_singular('product')`**. Estructura clave:

```json
{
  "@type": "Course",
  "name": "<título del curso>",
  "description": "<60 palabras de la descripción corta>",
  "provider": { "@id": ".../#infosys-organization" },
  "isAccessibleForFree": true,
  "inLanguage": "es-ES",
  "educationalLevel": "Beginner",
  "courseCode": "INFOSYS-<post_id>",
  "coursePrerequisites": "Estar inscrito como trabajador o desempleado en el SEPE",
  "hasCourseInstance": {
    "@type": "CourseInstance",
    "courseMode": ["online", "blended"],
    "courseWorkload": "PT60H",
    "offers": { "price": "0", "priceCurrency": "EUR", "availability": "InStock" }
  }
}
```

> Ajustes futuros: cuando se conozca duración real, formato (online/presencial) y fechas de inicio, modificar `courseWorkload`, `courseMode` y añadir `startDate`/`endDate` por instancia.

---

## 5. `BlogPosting`

Inyectado **solo en `is_singular('post')`**. Es un Article enriquecido con:

- `headline`, `description` (excerpt o 35 primeras palabras)
- `image` (featured image o logo de fallback)
- `datePublished` / `dateModified` ISO 8601
- `author` → mapeado a la `@id` de la organización
- `publisher` → organización con logo (ImageObject)
- `inLanguage: es-ES`
- `articleSection: "Formación para el empleo"`

---

## 6. `FAQPage`

Solo en `/preguntas-frecuentes/` (page `ID 16729`). El snippet **parsea el contenido renderizado** buscando pares `<h3>pregunta</h3> ... <h3>` y los convierte en `Question`/`acceptedAnswer`.

Si en el futuro se cambia la estructura HTML del FAQ (por ejemplo a acordeones de Elementor), revisar el regex en `infosys_seo_faq_schema()` y adaptarlo.

Actualmente se reconocen **28 FAQs**.

---

## 7. Meta tags extra (OpenGraph + geo)

Inyectados en `wp_head` con prioridad 4 (lo más arriba posible):

```html
<meta property="og:locale" content="es_ES" />
<meta property="og:site_name" content="Infosystem — Centro de Educación Polivalente" />
<meta name="geo.region" content="ES-CR" />
<meta name="geo.placename" content="Santa Cruz de Mudela, Ciudad Real, Castilla-La Mancha" />
<meta name="geo.position" content="38.6411;-3.4683" />
<meta name="ICBM" content="38.6411, -3.4683" />
```

En posts añade además `article:section` y un `article:tag` por cada tag del post.

---

## Validación en frontend (verificado)

| URL | Schemas emitidos |
|-----|------------------|
| `/` | Person, Organization, WebSite, ImageObject, WebPage (RM) · EducationalOrganization + LocalBusiness (custom) · WebSite SearchAction (custom) |
| `/preguntas-frecuentes/` | BreadcrumbList (RM) · EducationalOrganization + LocalBusiness · WebSite · BreadcrumbList (custom) · **FAQPage** |
| `/cursos-subvencionados-castilla-la-mancha/` | RM CollectionPage · EducationalOrganization + LocalBusiness · WebSite · BreadcrumbList |
| Post de blog | BreadcrumbList (RM) · EducationalOrganization + LocalBusiness · WebSite · BreadcrumbList · **BlogPosting** |
| Producto curso | BreadcrumbList (RM) · EducationalOrganization + LocalBusiness · WebSite · BreadcrumbList · **Course** |

> El número de BreadcrumbList aparece elevado por la coexistencia con Rank Math. Google interpreta uno solo (el más completo). No es un problema según las guidelines.

---

## Cómo validar

1. **Rich Results Test**: `https://search.google.com/test/rich-results?url=<URL>`
2. **Schema.org Validator**: `https://validator.schema.org/`
3. Desde el navegador, en DevTools console:

```js
[...document.querySelectorAll('script[type="application/ld+json"]')]
  .map(s => { try { return JSON.parse(s.textContent); } catch(e) { return 'PARSE_ERROR'; } });
```

---

## Cambios habituales

- **Cambiar logo**: edita `infosys_seo_logo_url()` apuntando a la nueva URL.
- **Cambiar coordenadas de un centro**: edita el array dentro de `infosys_seo_get_centros()`.
- **Añadir nuevo centro**: añade entrada en el array de `infosys_seo_get_centros()` (se incluye automáticamente como `department`).
- **Cambiar dominio**: nada que tocar; `infosys_seo_base_url()` usa `home_url()` dinámico.
- **Quitar duplicado de WebSite**: si quieres que solo Rank Math emita `WebSite`, comenta el `add_action` de `infosys_seo_website`.
