# Changelog del proyecto Centros Infosystem

Historial cronológico de todos los cambios realizados sobre el sitio.

## 2026-09-20 / 2026-09-21 · Rediseño Integral Footer Dark, Fixes Elementor y Calibración Visual

- **Footer Global Dark (Plantilla Elementor 8920):**
  - Transformación estética a fondo oscuro `#121217` con acento superior granate `#8B1A1A`.
  - Reestructuración a 4 columnas amplias y equilibradas (28%, 23%, 17%, 32%) sin saltos de línea antiestéticos.
  - Iconos de contacto unificados en dorado corporativo (`#D4880A` con hover `#F3B33D`): mapa, teléfono, email (`\e919` de `thim-ekits`) y sede.
  - Calibración geométrica exacta: contenedor de icono a 28.75px para alinear milimétricamente el inicio de todos los textos de contacto en el mismo eje X (`1173.23px`).
  - Barra de copyright (`#0b0b0e`) en fila única con `space-between`: créditos a la izquierda y enlaces legales a la derecha.
- **Páginas Institucionales y Elementor:**
  - **Conócenos:** Eliminación de la franja blanca lateral en el banner CTA granate mediante ancho completo fluido (`100vw; margin-left: calc(50% - 50vw)`).
  - **Cursos:** Implementación de lógica dinámica para la banda "FINALIZADO" automática en los banners de cursos según fechas de inicio y finalización.
  - **Páginas Legales (Aviso Legal, Política de Calidad, Política de Privacidad y Cookies):**
    - Se unificó la plantilla de WordPress a **`elementor_header_footer` (Elementor Ancho Completo)** en *Política de Calidad* y *Aviso Legal*, eliminando la cabecera duplicada por defecto del tema Eduma (`top_heading`).
    - Todas las páginas normativas quedan idénticas a *Política de Cookies*: con cabecera corporativa única en degradado granate (`.legal-header`) y editables al 100% en Elementor sin interferencias.
    - **Alineación Superior en Política de Calidad:** Se corrigió la separación de 20px generada por la variable `--padding-top: 20px` del contenedor raíz de Elementor (`.elementor-element-04b3f27`). Ahora el banner granate inicia exactamente a ras de la línea dorada inferior del menú de navegación (`gap = 0 px`), en perfecta armonía con el resto de páginas legales.
  - **Diseño Completo:** Eliminación de sidebars/latest posts en páginas completas para una experiencia limpia y despejada.
- **Sección de Registro en Home ("Regístrate y Empieza Hoy Mismo"):**
  - **Eliminación de scroll interno:** Se neutralizó la restricción de altura `max-height: 65vh; overflow: hidden auto;` forzada por el plugin de formularios de presupuesto.
  - **Diseño en tarjetas simétricas con sangrado y respiración:** Se perfeccionó la columna derecha (formulario) como una tarjeta blanca prémium (`padding: 46px 42px 54px 42px !important; border-radius: 18px !important; box-shadow: 0 12px 40px rgba(0,0,0,0.07) !important;`) dotando al formulario de generosos márgenes perimetrales blancos ("sangre"). El botón de envío y los campos ya no quedan pegados a los bordes.
  - **Márgenes y diseño de casillas (inputs):** Se incrementó el espacio bajo el subtítulo (24px), se ampliaron los campos a 44px de altura con relleno interno de 10px 15px, y se dotó de un margen inferior holgado de 54px bajo el botón submit "Enviar Mensaje", manteniendo la tarjeta izquierda del contador sincronizada sin quiebre de bloques.
- **Sincronización, Mantenimiento y Limpieza del Repositorio:**
  - Actualización, depuración y eliminación de bloques CSS duplicados en `functions.php`.
  - Sincronización íntegra de `functions.php` en `eduma-child/` con producción.
  - Endurecimiento de `.gitignore` con exclusión de archivos de contraseñas, credenciales, backups y entornos temporales.
  - **Depuración de archivos obsoletos y carpetas redundantes:** Eliminación de la carpeta temporal `scratch/` (más de 380 scripts de depuración, volcados HTML/JSON y capturas intermedias) y supresión de archivos de notas temporales desfasadas en el Child Theme (`LEEME-MAÑANA.md`, `LEEME-DISEÑO.md`, `DEPLOY-FINAL.md`, `actualizar-paginas-legales.php`, `infosystem-homepage.html`), consolidando la documentación en `README.md`, `CHANGELOG.md` y `docs/`.

---

## 2026-06-22 · Detalles del Curso Dinámicos (Ubicación y Fechas) en WooCommerce

- **Meta Box en Edición de Producto:** Añadida sección nativa para definir "Lugar de impartición" (con selector de centros físicos predefinidos + opción de ubicación personalizada) y "Fechas de inicio y finalización" usando selectores HTML5.
- **Visualización en Ficha de Producto:** Añadida visualización en la columna derecha de la página de curso individual (Single Product WooCommerce) con estilos corporativos granates, iconos de FontAwesome y conversión de fechas al formato español (DD/MM/YYYY).
- **Consistencia de Estilos:** Unificados los estilos en el stylesheet del child theme tanto en desarrollo (`eduma-child`) como en producción (`infosystem-child-theme`).

---

## 2026-06-22 · Protección Anti-Spam (Akismet) + Limpieza de Formularios (CF7)

- **Protección Akismet integrada:** Reconfiguramos los formularios activos (`Contact Home Page`, `Contact Us`, `Trabaja con nosotros`) para incluir firmas de Akismet en los campos de Nombre, Email y Teléfono (`akismet:author`, `akismet:author_email`, `akismet:author_url`).
- **Traducción al español:** Traducimos todos los mensajes de validación y de error por defecto al español en los formularios activos de producción.
- **Limpieza de base de datos:** Detectamos y eliminamos los formularios de contacto no utilizados en Elementor, páginas o widgets (como el duplicado `Información Cursos` y otros obsoletos).
- **Herramienta `manage-cf7-akismet.php`:** Creada y guardada en `eduma-child/tools/` para mantenimiento futuro de formularios.

---

## 2026-06-18 · Optimización Rank Math SEO V2.1 (Tildes, URLs y Word Count)

- **Optimización de palabras clave:** Actualizada la base de datos para usar palabras clave de enfoque con acentos correctos en español (ej. `Formación Dual Castilla-La Mancha`).
- **Slugs y URLs:** Limpiamos y unificamos los slugs de las 8 entradas de blog en producción para que coincidan con las palabras clave exactas de Rank Math, eliminando errores de URL.
- **Inserción de FAQs y Ampliación de palabras (>700):** Añadimos un acordeón de 4 preguntas frecuentes detalladas a cada entrada de blog para superar el límite mínimo de 600 palabras exigido por Rank Math.
- **Inserción de imágenes Gutenberg:** Inyectamos bloques de imágenes nativos de Gutenberg con textos alternativos (`alt`) optimizados que contienen las palabras clave exactas.
- **Herramienta `update-seo-v2.php`:** Creada y guardada en `eduma-child/tools/` para mantenimiento futuro del SEO.

## 2026-05-26 · SMTP IONOS operativo + recipientes CF7 unificados

- **WP Mail SMTP** configurado con IONOS (`smtp.ionos.es:587/TLS`, autenticación con `info@centrosinfosystem.com`).
- **From Email / From Name** forzados a `info@centrosinfosystem.com` / `Infosystem`.
- **Contraseña**: encriptada en BD, no visible en UI; recomendación futura: pasar a `WPMS_SMTP_PASS` en `wp-config.php`.
- **Test Email** del plugin realizado correctamente (2 veces, a 2 buzones distintos).
- **CF7 — 5 formularios actualizados** (recipient + sender + subject):
  - 7 (Información Cursos / inscripción)
  - 13916 (Contact Us / `/contacto/`)
  - 13917 (Contact Home Page)
  - 14376 (Trabaja con nosotros)
  - 14853 (Contact One Course)
- Todos ahora envían a `info@centrosinfosystem.com` con remitente `Infosystem <info@centrosinfosystem.com>` y asuntos prefijados con "Infosystem" para fácil filtrado.

---

## 2026-05-26 · SEO masivo + 10 posts + FAQ + cross-linking

### SEO

- **Auditoría SEO** completa (Rank Math, sitemap, robots, schemas existentes).
- **Snippet WPCode `Infosystem SEO - Schemas JSON-LD`** (ID 16728) creado e inyectando en `frontend_only`:
  - `EducationalOrganization` + `LocalBusiness` con los 4 centros.
  - `WebSite` + `SearchAction`.
  - `BreadcrumbList` dinámico.
  - `Course` schema para productos WooCommerce.
  - `BlogPosting` schema para posts.
  - `FAQPage` schema en `/preguntas-frecuentes/`.
  - Meta tags Open Graph + geo localization.
  - Filtro `woocommerce_canonical_product_url`.
- **Rank Math** configurado para Local SEO + titles/descripciones home + redes sociales (placeholder).

### Página FAQ

- Creada `/preguntas-frecuentes/` (ID 16729) con **28 FAQs** en 5 secciones temáticas.
- Schema FAQPage funcionando.

### Blog (10 posts SEO)

| ID | Slug | Foco |
|----|------|------|
| 16730 | `cursos-subvencionados-sepe-castilla-la-mancha-2026` | SEPE guía completa |
| 16731 | `cursos-gratis-desempleados-ciudad-real-jccm` | Desempleados Ciudad Real |
| 16732 | `formacion-bonificada-fundae-empresas-castilla-la-mancha` | FUNDAE empresas |
| 16733 | `cursos-online-trabajadores-activo-subvencionados` | Trabajadores en activo |
| 16734 | `certificados-profesionalidad-gratis-castilla-la-mancha` | Certificados profesionalidad |
| 16735 | `centros-infosystem-ciudad-real` | Local (4 centros) |
| 16736 | `cursos-mas-demandados-castilla-la-mancha-2026` | Top 10 cursos demandados |
| 16737 | `formacion-dual-castilla-la-mancha-guia` | FP Dual |
| 16738 | `ofimatica-nube-google-drive-por-que-aprenderlo` | Curso Ofimática |
| 16739 | `gestion-negocios-online-emprender-castilla-la-mancha` | Curso Gestión Negocios |

Todos con title/description Rank Math, focus keyword, categorías y cross-links internos.

### Cross-linking

- **Menú principal**: añadido item `Preguntas Frecuentes` (ID 16740) entre Blog y Contacto. Orden final reorganizado.
- **Footer**: añadidos enlaces a `Preguntas frecuentes` en columnas Cursos y Empresa.

### Validación

- Todas las URLs probadas en frontend: schemas correctos.
- Sitemap pendiente de purga manual de caché WP Rocket (ver `docs/10-pending-tasks.md`).

---

## 2026-05-25 (sesiones previas) · Limpieza y localización

### Localización al español

- Home (`page 4524 _elementor_data`): search & replace de "Share Your Knowledge…", "Package Courses", "No deadlines…", etc.
- Eliminados **18 posts demo** en inglés.
- Eliminados **8 eventos demo** (CPT `tp_event`).

### Logo definitivo

- Configurado `InfoSystem-logo.png` (att. ID 16674) en desktop, mobile y sticky.

### Página "Trabaja con nosotros"

- Creada `/trabaja-con-nosotros/` (ID 16707) con texto + form CF7 14376.
- Form configurado con adjunto CV + notificación a `info@infosystem.net` + auto-respuesta.
- Fusión y borrado del duplicado `/trabaja-con-nosotros-2/` (ID 16723).

### Header y Menú

- Eliminado "Buy now" del header (CSS + reemplazo del widget `text-1210022` con teléfono + CTA "Ver cursos").
- Simplificado mega-menú "Cursos Gratis" → enlace directo a `/cursos-subvencionados-castilla-la-mancha/` con CSS para ocultar dropdown.
- Añadido item `Contacto` al menú.

### Footer

- Reemplazado footer demo por footer Infosystem en español:
  - 4 columnas (Marca, Cursos, Empresa, Centros & contacto).
  - Créditos "Diseño Web: Juan Carlos Robles Magán + Grupo Comunicación 360º".
  - "Recomendamos": Cursos Premium, HipotecaXpert, VipOfertas.

### Widgets

- Ocultado `Eduma Mobile` del sidebar derecho en páginas de cursos.

---

## Setup inicial · Cursos + WooCommerce + Inscripción

### Cursos importados

- **Gestión de Negocios Online 2.0 CLM** (producto WooCommerce, slug `curso-de-gestion-de-negocios-online-2-0-clm`).
- **Ofimática en la Nube con Google Drive CLM** (producto WooCommerce, slug `curso-ofimatica-en-la-nube-con-google-drive-clm`).

Replicados desde `cursospremiumonline.es` con texto, imagen destacada, excerpt y tags.

### WooCommerce como catálogo de cursos a 0 €

- Cursos como productos a precio 0,00 €.
- Categoría: `Cursos Castilla la Mancha`.
- Plugin **WooCommerce Quote or Enquiry Contact Form 7** activado para reemplazar "Añadir al carrito" por formulario CF7 en esa categoría.

### Formularios CF7

- ID 13916 (Contact Us) en `/contacto/`.
- ID 14376 (Trabaja con nosotros) en `/trabaja-con-nosotros/`.
- Form de inscripción a cursos (reemplaza al "Añadir al carrito").

### LearnPress desactivado

- LMS y todos sus addons desactivados — el modelo es informativo + formulario, no plataforma de aprendizaje.

### Redirects

- `/cursos-gratis/` → `/cursos-subvencionados-castilla-la-mancha/` (301).

### Limpieza de código

- Eliminada pieza de código *nulled* en `eduma/functions.php` (vigilar tras actualizaciones del tema).
