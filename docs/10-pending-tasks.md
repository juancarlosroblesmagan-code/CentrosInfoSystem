# 10 · Pendientes y notas operativas

Tareas que **no se pueden resolver vía API/automatización** o que dependen de que el cliente complete configuraciones externas (dominio, buzones, etc.).

---

## ALTA prioridad

### 1. ✅ HECHO — Configurar SMTP real

- **Email definitivo**: `info@centrosinfosystem.com` (IONOS).
- **Estado**: ✅ **Activo desde el 26/05/2026**.
- **Plugin**: WP Mail SMTP configurado con `smtp.ionos.es:587/TLS`.
- **Tests realizados**: 2 envíos de prueba exitosos (a `info@infosystem.net` y al propio buzón IONOS).
- **CF7**: los 5 formularios (Inscripción, Contacto, Trabaja con nosotros, Contact Home Page, Contact One Course) ya apuntan a `info@centrosinfosystem.com`.
- **Contraseña**: encriptada en BD (oculta en la UI). Recomendado en el futuro pasarla a `WPMS_SMTP_PASS` en `wp-config.php` (ver [`docs/07-forms-cf7.md`](07-forms-cf7.md)).

### 2. Purgar caché tras cambios (WP Rocket)

- **Síntoma**: Los cambios de CSS en la home o la página de cursos pueden tardar en verse en el navegador debido al sistema de caché.
- **Solución manual**:
  1. WordPress admin → **WP Rocket → Dashboard → "Borrar caché"** (botón rojo).
  2. Si no basta, vía Plesk **borrar el directorio** `/wp-content/cache/wp-rocket/` y `/wp-content/cache/min/`.
  3. Refrescar `/post-sitemap.xml?cb=1` para regenerar.

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

### 4. ✅ HECHO — Dominio definitivo

- **Dominio activo**: `https://centrosinfosystem.com` con SSL.
- **Redirect 301** del dominio temporal Plesk: snippet WPCode activo.

### 5. Crear Google Business Profile para cada centro

- Centro 1: Santa Cruz de Mudela (Cruz de Piedra, 13 · 13730).
- Centro 2: Viso del Marqués (Avda. Don Álvaro de Bazán s/n · 13770).
- Centro 3: Fuente el Fresno (Plaza de España s/n · 13412).
- Centro 4: Membrilla (C. Mayor s/n · 13230).

Cada perfil debe enlazar a su `LocalBusiness` correspondiente del schema.

### 6. Redes sociales

Actualizar `sameAs` del schema (snippets/infosystem-seo-snippet.php) con URLs reales cuando se creen los perfiles:

- Facebook
- Instagram
- LinkedIn (cuenta de empresa)
- YouTube (si se hace canal con vídeo)

### 7. ✅ HECHO — Ajustes de Cursos y Layout de Catálogo

- **Cursos centrados y alineados**: Forzado el contenedor principal a 100% de la caja de ancho (centrado) ocultando el sidebar vacío.
- **Tipografías y Botones**: Aplicada tipografía Merriweather y Source Sans Pro de forma consistente. Botón de producto visible en granate con hover dorado.
- **Tarjetas simétricas**: Aplicado diseño flexbox para que todas las tarjetas de la fila tengan la misma altura y los botones queden perfectamente alineados en la parte inferior.

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
- Convertir imágenes pesadas a **WebP**.
- Revisar **CLS** en home (que las cargas asíncronas no muevan layout).

### 10. Reviews / Aggregate Rating

Si en algún momento hay reseñas verificables (Google, Trustpilot), añadir `AggregateRating` al schema de cada centro y/o de los cursos.

### 11. ✅ HECHO — Sincronizar archivos del child theme en Git

- **Acción**: Copiado el child theme completo (estilos y scripts actualizados) al directorio canónico `eduma-child/` en la raíz del repositorio de desarrollo para asegurar un control de versiones limpio y centralizado.

---

## Directrices para Futuras Modificaciones

> [!CAUTION]
> **REGLA DE NO-CÓDIGO PHP/TEMPLATES INNECESARIOS:**
> No reescribir plantillas de php ni sobrecargar el backend con código innecesario.
> Si se necesitan añadir funcionalidades estéticas a WooCommerce o Elementor, hacerlo mediante selectores CSS en el archivo `style.css` del Child Theme o a través de los ajustes visuales en el editor de Elementor/WordPress. 
> Mantener las plantillas php nativas del tema Eduma para asegurar que no se produzcan incompatibilidades al actualizar WordPress, WooCommerce o Elementor.
