# 10 · Pendientes y notas operativas

Tareas que **no se pueden resolver vía API/automatización** o que dependen de que el cliente complete configuraciones externas (dominio, buzones, etc.).

---

## ALTA prioridad

### 1. Configurar SMTP real

- **Email definitivo**: `info@centrosinfosystem.com`.
- **Estado**: pendiente de que el buzón esté operativo en Plesk.
- **Plugin**: WP Mail SMTP (instalado).
- **Pasos**: ver [`docs/07-forms-cf7.md`](07-forms-cf7.md) sección "SMTP (PENDIENTE)".
- **Impacto**: sin SMTP **no se envían emails** desde los formularios. Los leads quedan en Flamingo pero no llegan al equipo.

### 2. Purgar caché del sitemap

- **Síntoma**: `/post-sitemap.xml` sigue mostrando los 18 posts demo eliminados y NO muestra los 10 posts reales.
- **Causa**: WP Rocket cachea el XML como fichero estático en `/wp-content/cache/wp-rocket/`.
- **Solución manual**:
  1. WordPress admin → **WP Rocket → Dashboard → "Borrar caché"** (botón rojo).
  2. Si no basta, vía Plesk **borrar el directorio** `/wp-content/cache/wp-rocket/` y `/wp-content/cache/min/`.
  3. Refrescar `/post-sitemap.xml?cb=1` para regenerar.
- **Verificación**: visitando `/post-sitemap.xml` deben aparecer los 10 slugs de posts (`cursos-subvencionados-sepe…`, `cursos-gratis-desempleados…`, etc.) y ningún slug de 2022/2025.

### 3. Validar schemas externamente

Tras purgar caché, pasar por **Rich Results Test** las siguientes URLs:

- `/` → Organization + LocalBusiness
- `/preguntas-frecuentes/` → **FAQPage**
- `/curso-ofimatica-en-la-nube-con-google-drive-clm/` → **Course**
- `/curso-de-gestion-de-negocios-online-2-0-clm/` → **Course**
- `/blog/2026/05/26/cursos-mas-demandados-castilla-la-mancha-2026/` → **BlogPosting**

Herramienta: `https://search.google.com/test/rich-results`.

---

## MEDIA prioridad

### 4. Migrar al dominio definitivo

Cuando esté listo `centrosinfosystem.com`:

1. **Backup completo** (Plesk → Backup Manager).
2. Configurar dominio + DNS apuntando al hosting Plesk.
3. Instalar **SSL Let's Encrypt** (Plesk lo hace en 1 click).
4. WordPress: cambiar `siteurl` y `home` (`wp-options`) o vía WP-CLI:
   ```bash
   wp option update home https://centrosinfosystem.com
   wp option update siteurl https://centrosinfosystem.com
   wp search-replace 'friendly-sutherland.5-175-47-192.plesk.page' 'centrosinfosystem.com' --skip-columns=guid
   ```
5. Forzar HTTPS (WP Rocket o Really Simple SSL).
6. **Redirect 301** del dominio antiguo al nuevo (si se mantiene activo el de Plesk un tiempo).
7. Re-enviar sitemap a Google Search Console con el dominio nuevo.
8. Re-validar schemas.

### 5. Crear Google Business Profile para cada centro

- Centro 1: Santa Cruz de Mudela (Cruz de Piedra, 13 · 13730).
- Centro 2: Viso del Marqués (Avda. Don Álvaro de Bazán s/n · 13770).
- Centro 3: Fuente el Fresno (Plaza de España s/n · 13412).
- Centro 4: Membrilla (C. Mayor s/n · 13230).

Cada perfil debe enlazar a su `LocalBusiness` correspondiente del schema (en realidad lo hace Google automáticamente cuando ve coincidencia de NAP).

### 6. Redes sociales

Actualizar `sameAs` del schema (snippets/infosystem-seo-snippet.php) con URLs reales cuando se creen los perfiles:

- Facebook
- Instagram
- LinkedIn (cuenta de empresa)
- YouTube (si se hace canal con vídeo)

### 7. Imágenes con texto demo en home

Algunas tarjetas de categoría de la home aún tienen imágenes con texto incrustado en inglés del tema Eduma. Sustituirlas por imágenes propias (mejor SEO + branding):

- Categorías: subir imágenes generadas con texto español o sin texto y poner el título por overlay HTML.

---

## BAJA prioridad / mejoras opcionales

### 8. Ampliar el blog

Plantilla recomendada de cadencia: **1 post/semana**. Temas sugeridos:

- "Cursos para personas mayores de 45 años en CLM"
- "Cómo conseguir tu primer empleo con un curso del SEPE"
- "Energías renovables: oportunidades de empleo en Ciudad Real"
- "Comparativa: SEPE vs FUNDAE vs JCCM"
- "Cómo solicitar la capitalización del paro para emprender"

Detalles en [`docs/05-blog-posts.md`](05-blog-posts.md) → sección "Ampliar la serie".

### 9. Mejoras de velocidad (Core Web Vitals)

Tras migrar al dominio:

- Auditar con PageSpeed Insights / GTmetrix.
- Activar **lazy loading** de imágenes en WP Rocket si no está.
- Convertir imágenes pesadas a **WebP** (Smush, ShortPixel, o el optimizador integrado de WP Rocket).
- Revisar **CLS** en home (que las cargas asíncronas no muevan layout).

### 10. Reviews / Aggregate Rating

Si en algún momento hay reseñas verificables (Google, Trustpilot), añadir `AggregateRating` al schema de cada centro y/o de los cursos.

### 11. Eliminar restos demo del child setup

La página `themes.php?page=eduma-child-infosystem-setup` daba 404 al inicio porque el child theme estaba incompleto. Tras subir el child completo se resolvió, pero conviene comprobar que el child theme tiene **todos** los archivos (`functions.php`, `style.css`, `screenshot.png`, plantillas heredadas si se modifican).

### 12. Hardening de seguridad

- **Actualizar contraseñas** de los usuarios administradores periódicamente.
- Habilitar **2FA** en Rank Math / WP Mail SMTP / WordPress.
- Revisar permisos: `CursorAgent` (si aún existe) puede eliminarse después.
- Activar logs de actividad (plugin opcional).

---

## Notas históricas (problemas resueltos)

Estas cosas ya están resueltas pero conviene tenerlas documentadas por si vuelven a aparecer:

| Problema | Cómo se resolvió |
|----------|------------------|
| Nulled code en `eduma/functions.php` | Eliminado manualmente |
| Edición directa de `functions.php` fallaba sin error | Usar WPCode en lugar del editor de temas |
| WPCode con error "unexpected identifier application" | Cambiar `echo "<script…\"...\"…>"` a comillas simples para HTML |
| Schemas no aparecían en frontend | Cambiar ubicación del snippet de `site_wide_header` a `frontend_only` |
| Login con `CursorAgent` fallaba | Crear correctamente el usuario con rol Administrador |
| Imagen 15102 (Ofimática) daba 404 | Re-subir la imagen y reasignarla |
| Categoría "Cursos Castilla la Mancha" no persistía en plugin Quote | Seleccionar la opción vía CDP en el `<select>` oculto y submit |
| `/trabaja-con-nosotros/` daba 404 | Crear página + form CF7 14376; fusionar duplicado y borrarlo |
| Posts demo persistían en frontend tras borrarlos | Purgar caché de WP Rocket y regenerar CSS de Elementor |
| "Buy Now" persistía pese al CSS | Reemplazar contenido del widget `text-1210022` vía REST API |
| Mega-menú "Cursos Gratis" demo persistía | CSS específico + cambio de URL del menu item |
