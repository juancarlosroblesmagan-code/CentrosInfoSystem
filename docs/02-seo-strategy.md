# 02 · Estrategia SEO

## Objetivo de negocio

Centros Infosystem opera en **núcleos poblacionales pequeños de Ciudad Real** (Santa Cruz de Mudela, Viso del Marqués, Fuente el Fresno, Membrilla). El SEO debe captar tráfico de:

1. **Búsquedas locales**: "cursos gratis Ciudad Real", "cursos subvencionados Santa Cruz de Mudela", "formación gratuita Membrilla"…
2. **Búsquedas regionales**: "cursos SEPE Castilla-La Mancha", "cursos JCCM gratis", "certificados profesionalidad CLM"…
3. **Búsquedas nicho (vertical)**: "formación bonificada FUNDAE empresas", "formación dual CLM", "cursos online subvencionados trabajadores activos".
4. **Búsquedas long-tail informativas** (blog): "qué es un certificado de profesionalidad", "cómo bonificar FUNDAE", "trabaja con nosotros formador".

---

## Pirámide de keywords

```
                  Top funnel (informativo)
              ┌──────────────────────────────┐
              │  Blog (10 artículos)          │
              │  /preguntas-frecuentes/       │
              └──────────────────────────────┘
                  Mid funnel (consideración)
              ┌──────────────────────────────┐
              │  Páginas de centros           │
              │  Página /conocenos/           │
              │  Categorías de cursos         │
              └──────────────────────────────┘
                  Bottom funnel (conversión)
              ┌──────────────────────────────┐
              │  Producto curso individual    │
              │  /cursos-subvencionados-clm/  │
              │  Formulario inscripción 0 €   │
              └──────────────────────────────┘
```

---

## Configuración Rank Math

Lo gestionamos junto con el snippet WPCode. Rank Math sigue siendo el **gestor principal de**:

- Title tags
- Meta descriptions
- Canonicals (excepto productos, ver más abajo)
- Open Graph básico
- Sitemap XML
- Schema `Person/Organization` por defecto
- Schema `WebSite` base
- Schema `BreadcrumbList` para algunas plantillas
- Schema `BlogPosting` para posts (lo enriquecemos con el snippet)

### Local SEO

Configurado:

- 4 centros como negocios locales (en realidad inyectados todos desde el snippet WPCode como `department[]` para que se asocien a la organización padre).
- Datos completos: NAP (Name/Address/Phone), coordenadas, horarios, `priceRange: Gratuito`.

### Sitemap

- Pages, products, categories, product categories, authors → activados.
- Posts → activado (pero **cacheado en disco**; ver pendientes).

### Redes sociales

Pendiente de poner enlaces reales cuando estén creados los perfiles.

---

## Schemas custom (WPCode)

Ver detalle en [`docs/03-schemas-json-ld.md`](03-schemas-json-ld.md). Resumen rápido por tipo de página:

| Página | Schemas emitidos (Rank Math + custom) |
|--------|---------------------------------------|
| `/` (home) | Person, Organization, WebSite, ImageObject, WebPage (RM) + EducationalOrganization+LocalBusiness, WebSite con SearchAction (custom) |
| `/preguntas-frecuentes/` | RM base + Organization, WebSite, BreadcrumbList, **FAQPage (28 Q&A)** |
| `/cursos-subvencionados-castilla-la-mancha/` | RM CollectionPage + Org + WebSite + BreadcrumbList |
| Producto curso individual | Org + WebSite + BreadcrumbList + **Course** (custom) |
| Post de blog | Org + WebSite + BreadcrumbList + **BlogPosting** enriquecido |

> **Duplicados aceptables**: Rank Math y nuestro snippet emiten ambos `BreadcrumbList` y `WebSite`. Google deduplica usando `@id` distintos (RM usa `…#breadcrumb` y nosotros usamos `…#breadcrumb` con sufijo diferente cuando aplica). No es un problema de SEO según directrices de Google.

---

## Estrategia de cross-linking interno

Cada pieza de contenido enlaza al menos a **3 piezas relevantes**:

```
Home
 ├─→ /cursos-subvencionados-castilla-la-mancha/
 ├─→ /preguntas-frecuentes/
 └─→ /blog/

/cursos-subvencionados-clm/
 ├─→ Curso Gestión Negocios Online 2.0
 ├─→ Curso Ofimática Google Drive
 └─→ /preguntas-frecuentes/

Cada producto/curso
 ├─→ /cursos-subvencionados-clm/ (volver al listado)
 ├─→ /preguntas-frecuentes/
 ├─→ /contacto/
 └─→ Posts de blog relacionados

/preguntas-frecuentes/
 ├─→ /cursos-subvencionados-clm/
 ├─→ Curso Gestión Negocios Online 2.0
 ├─→ Curso Ofimática Google Drive
 └─→ /contacto/, /trabaja-con-nosotros/

Cada post de blog
 ├─→ /cursos-subvencionados-clm/
 ├─→ /preguntas-frecuentes/
 ├─→ /contacto/
 └─→ Posts relacionados o cursos específicos
```

Esta estrategia se aplica en:

- **Menú principal** (Inicio · Cursos Gratis · Conócenos · Blog · Preguntas Frecuentes · Contacto).
- **Footer** (columnas Cursos / Empresa con enlaces a FAQ y Blog).
- **Cuerpo** de cada artículo del blog (con anchor text variado: "cursos subvencionados CLM", "ver cursos gratis", "preguntas frecuentes", etc.).

---

## Open Graph y redes sociales

Inyectado por el snippet WPCode en `wp_head` con prioridad 4:

```html
<meta property="og:locale" content="es_ES" />
<meta property="og:site_name" content="Infosystem — Centro de Educación Polivalente" />
<meta name="geo.region" content="ES-CR" />
<meta name="geo.placename" content="Santa Cruz de Mudela, Ciudad Real, Castilla-La Mancha" />
<meta name="geo.position" content="38.6411;-3.4683" />
<meta name="ICBM" content="38.6411, -3.4683" />
```

En posts añade:

```html
<meta property="article:section" content="Formación para el empleo" />
<meta property="article:tag" content="…" />
```

---

## Canonical en productos (WooCommerce)

Forzamos el canonical de productos a su permalink real (evita problemas con URLs con parámetros):

```php
add_filter('woocommerce_canonical_product_url', function($url, $product){
    return get_permalink($product->get_id());
}, 10, 2);
```

---

## KPIs a vigilar tras lanzar

1. **Posiciones medias** (Search Console) para keywords objetivo: `cursos subvencionados ciudad real`, `cursos gratis castilla la mancha`, `FUNDAE empresas CLM`…
2. **CTR de SERPs** (mejora esperada gracias a los Rich Snippets de FAQ, Course y BlogPosting).
3. **Cobertura del sitemap** en Search Console (debe mostrar ≈ 10 posts + 4-6 páginas + 2 productos + categorías).
4. **Rich Results Test**: `https://search.google.com/test/rich-results` debe validar Course, FAQPage, BlogPosting, Organization sin errores.

---

## Próximos pasos SEO (post-lanzamiento)

1. Dar de alta **Google Business Profile** por cada uno de los 4 centros.
2. Conseguir **backlinks locales** (ayuntamientos, asociaciones de comerciantes, prensa local de Ciudad Real).
3. Añadir **reseñas Google** en cada centro (`aggregateRating` se podría inyectar después si hay reviews reales).
4. Crear posts adicionales según resultados de Search Console (qué queries traen impresiones pero pocos clics).
5. Imágenes con `alt` localizados ("curso ofimática Membrilla", "centro Infosystem Santa Cruz de Mudela"…).
6. Velocidad: revisar Core Web Vitals tras pasar al dominio definitivo.
