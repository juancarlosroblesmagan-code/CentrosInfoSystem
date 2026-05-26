# Snippets

## `infosystem-seo-snippet.php`

Snippet PHP que se carga **vía el plugin WPCode** (Code Snippets) en WordPress.

### Estado en producción

- **WPCode Snippet ID**: `16728`
- **Título**: `Infosystem SEO - Schemas JSON-LD`
- **Estado**: Activo
- **Tipo**: PHP Snippet
- **Ubicación**: `frontend_only` (importante)

### Funcionalidad

Inyecta automáticamente en `<head>`:

1. `EducationalOrganization` + `LocalBusiness` con los 4 centros como `department[]`.
2. `WebSite` + `SearchAction` (Sitelinks Searchbox de Google).
3. `BreadcrumbList` dinámico para post / producto / página / categoría / archive.
4. `Course` schema para productos WooCommerce (cursos a 0 €).
5. `BlogPosting` schema para posts de blog.
6. `FAQPage` schema para `/preguntas-frecuentes/`.
7. Meta tags Open Graph + geo localization.
8. Filtro WooCommerce para canonical correcto de productos.

### Cómo instalarlo (si hay que reinstalar)

1. Plugin **WPCode** debe estar instalado y activo.
2. `WordPress admin → Code Snippets → Add Snippet → Add Your Custom Code (New Snippet)`.
3. Seleccionar tipo: **PHP Snippet**.
4. Título: `Infosystem SEO - Schemas JSON-LD`.
5. **Pegar todo el contenido** de `infosystem-seo-snippet.php` (omitir la primera línea `<?php` si WPCode la añade automáticamente; depende de la versión).
6. **Insertion**: `Auto Insert` → `Frontend Only`.
7. Guardar y **Activar**.
8. Verificar en el frontend que aparecen los JSON-LD esperados.

### Errores comunes

- Si lo pones en `site_wide_header`: los `add_action('wp_head', …)` no se registran a tiempo. Los schemas no aparecen.
- Si copias y pegas con comillas escapadas: error de sintaxis. Asegúrate de copiar el archivo tal cual.
- Si quieres modificar centros, edita el array dentro de `infosys_seo_get_centros()` y guarda.

### Compatibilidad con Rank Math

- Convive sin problemas. Los `@id` son únicos (`#infosys-organization`, `#infosys-website`, `#infosys-course`, `#infosys-article`, `#infosys-faq`, `#breadcrumb`) y Google deduplica los duplicados.
- Si quieres que solo Rank Math emita `WebSite`, comenta el `add_action('wp_head', 'infosys_seo_website', 6)`.
