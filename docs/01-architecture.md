# 01 · Arquitectura y stack

## Sitio en producción (staging)

- **URL actual**: `https://friendly-sutherland.5-175-47-192.plesk.page`
- **Hosting**: Plesk
- **PHP**: 8.x
- **MySQL/MariaDB**: gestionado por Plesk
- **WordPress**: instalación estándar
- **Login admin**: usuario `CursosPremium` (rol Administrador). Email: `info@infosystem.net`.

> ⚠️ El dominio actual es temporal de Plesk. El definitivo es `centrosinfosystem.com`.

---

## Tema

| Elemento | Valor |
|----------|-------|
| Tema padre | **Eduma** (de ThimPress) |
| Tema activo | **infosystem-child-theme** (child de Eduma) |
| Carpeta child | `wp-content/themes/eduma-child-infosystem/` (nombre slug aprox.) |

### Nota sobre código nulled

Durante el setup inicial se detectó y **eliminó** una pieza de código *nulled* del tema padre Eduma (`functions.php`). Si se reinstala/actualiza el tema, **vigilar** que no vuelva a aparecer.

### Edición de `functions.php`

❌ **No editar `functions.php` del child a través del editor de temas** de WordPress. El WAF de Plesk **rechaza silenciosamente** POSTs grandes con código PHP. Se intentó y falló sin error visible.

✅ **Usar siempre el plugin WPCode** (Code Snippets) para añadir PHP custom. Snippet activo:

- **ID**: `16728`
- **Título**: `Infosystem SEO - Schemas JSON-LD`
- **Ubicación de inserción**: `frontend_only` (NO `site_wide_header`, porque ese se ejecuta tarde y los `add_action('wp_head', …)` ya no llegan a tiempo).
- **Estado**: Activo.
- **Tipo**: PHP Snippet.
- **Código real**: ver [`snippets/infosystem-seo-snippet.php`](../snippets/infosystem-seo-snippet.php).

---

## Plugins clave

| Plugin | Función | Estado |
|--------|---------|--------|
| **WooCommerce** | Catálogo de cursos como productos a 0 € | Activo |
| **WooCommerce Quote or Enquiry Contact Form 7** | Reemplaza "Añadir al carrito" por formulario CF7 | Activo |
| **Contact Form 7** | Formularios de inscripción y trabaja con nosotros | Activo |
| **Flamingo** | Guarda los envíos de CF7 en base de datos | Activo |
| **WP Mail SMTP** | Envío de correos | Activo, **pendiente configurar SMTP real** |
| **Rank Math SEO** | SEO base (titles, descriptions, sitemaps) | Activo |
| **WPCode** | Snippets PHP custom (schemas SEO) | Activo |
| **WP Rocket** | Caché y optimización | Activo (purgar manualmente tras cambios grandes) |
| **Elementor** | Page builder para home y páginas | Activo |
| **LearnPress** + addons | LMS | **Desactivado** (no se usa) |

### Categoría WooCommerce de cursos

- Categoría: **Cursos Castilla la Mancha** (slug aprox. `cursos-castilla-la-mancha`).
- Es la categoría que se mostraba en `/cursos-subvencionados-castilla-la-mancha/`.
- Se configuró en el plugin "WooCommerce Quote or Enquiry CF7" para que solo en esa categoría se reemplace el botón.

---

## Caché

WP Rocket está configurado y **funciona bien para HTML**, pero:

- El **sitemap XML** (`/post-sitemap.xml`) queda cacheado como archivo estático en `/wp-content/cache/wp-rocket/`. Si se eliminan posts demo y aparecen aún en el sitemap, **borrar manualmente esa carpeta** o usar el botón **"Borrar caché"** en WP Rocket → Dashboard.
- Para validar cambios en frontend, usar `?_cb=<timestamp>` o `fetch(url, { cache: 'no-store' })` desde DevTools.
- Elementor también cachea CSS por página: ante un cambio en `_elementor_data` puede ser necesario regenerar el CSS desde el editor.

---

## Estructura de directorios del sitio

```
wp-content/
├── themes/
│   ├── eduma/                          ← tema padre (NO tocar)
│   └── eduma-child-infosystem/         ← child theme activo
├── plugins/
│   ├── woocommerce/
│   ├── contact-form-7/
│   ├── wpcode-lite/ o wpcode-premium/
│   ├── seo-by-rank-math/
│   └── ...
└── uploads/
    └── 2026/04/InfoSystem-logo.png     ← logo oficial (att. ID ≈ 16674)
```

---

## Modelo de datos relevante

### Posts existentes (10 — todos creados manualmente, 0 demo)

Ver [`docs/05-blog-posts.md`](05-blog-posts.md) para la lista completa.

### Productos (cursos) WooCommerce

| ID | Título | Slug |
|----|--------|------|
| 14376 | Gestión de Negocios Online 2.0 CLM | `curso-de-gestion-de-negocios-online-2-0-clm` |
| 13916 | Ofimática en la nube con Google Drive CLM | `curso-ofimatica-en-la-nube-con-google-drive-clm` |

### Páginas clave

| ID | Slug | Título |
|----|------|--------|
| 4524 | (home) `Demo Main` | Página principal (Elementor) |
| — | `/cursos-subvencionados-castilla-la-mancha/` | Listado de cursos (Woo archive) |
| 16719 | `/contacto/` | Contacto |
| 16707 | `/trabaja-con-nosotros/` | Trabaja con nosotros |
| 16729 | `/preguntas-frecuentes/` | Preguntas Frecuentes (FAQ) |
| — | `/about-us/` (o `/conocenos/`) | Conócenos |

Detalle completo en [`docs/04-pages.md`](04-pages.md).

---

## Multi-entorno

Actualmente **único entorno** (producción/staging compartido). Recomendación al pasar al dominio real:

1. Hacer un **backup completo** (Plesk → Backup).
2. Cambiar `siteurl` y `home` en `wp-options`.
3. Hacer **search & replace** con WP-CLI:
   ```bash
   wp search-replace 'friendly-sutherland.5-175-47-192.plesk.page' 'centrosinfosystem.com' --skip-columns=guid
   ```
4. Configurar redirects 301 del dominio antiguo si se mantiene.
5. **Purgar todas las cachés** (WP Rocket, Elementor, navegador).
6. Re-validar schemas y volver a enviar sitemap a Search Console.
