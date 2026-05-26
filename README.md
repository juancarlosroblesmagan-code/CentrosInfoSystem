# Centros Infosystem — Documentación del proyecto web

Sitio web oficial de **Infosystem — Centro de Educación Polivalente**, especialistas en **formación profesional para el empleo subvencionada por el SEPE y la Junta de Comunidades de Castilla-La Mancha**, con cuatro centros físicos en Ciudad Real (Santa Cruz de Mudela, Viso del Marqués, Fuente el Fresno y Membrilla) y cursos online para toda Castilla-La Mancha.

- **Dominio actual (staging)**: `https://friendly-sutherland.5-175-47-192.plesk.page`
- **Dominio definitivo previsto**: `centrosinfosystem.com`
- **Email institucional (SMTP ACTIVO IONOS)**: `info@centrosinfosystem.com`
- **Email de respaldo**: `info@infosystem.net`
- **Teléfono**: `+34 926 33 11 62`

---

## Stack técnico

| Capa | Tecnología | Notas |
|------|------------|-------|
| CMS | WordPress | Tema **Eduma** + child theme `infosystem-child-theme` |
| Page builder | Elementor | Para la home y páginas institucionales |
| E-commerce | WooCommerce | Usado como catálogo de cursos a 0 € con botón "Leer más" |
| Formularios | Contact Form 7 + Flamingo | Inscripción curso, "Trabaja con nosotros" |
| Integración CF7 + WC | WooCommerce Quote or Enquiry Contact Form 7 | Sustituye "Añadir al carrito" por el formulario |
| SEO | Rank Math SEO + WPCode (snippet propio) | Schemas JSON-LD custom complementarios |
| SMTP | WP Mail SMTP + IONOS | ✅ Activo: `info@centrosinfosystem.com` vía `smtp.ionos.es:587/TLS` |
| Caché | WP Rocket | Purgar manualmente tras cambios grandes |
| Hosting | Plesk | Cuidado con WAF para edición masiva de `functions.php` |

---

## Filosofía y decisiones clave

1. **No LMS**: se decidió **no usar LearnPress** (ni otros LMS). El curso es solo informativo y la "compra" es una **inscripción gratuita** (formulario CF7). LearnPress y addons están desactivados.
2. **Cursos = productos WooCommerce a 0 €** con el botón "Añadir al carrito" reemplazado por **"Leer más"** que enlaza con el formulario de inscripción.
3. **Esquemas SEO inyectados vía WPCode** (no en `functions.php` del child, porque el WAF de Plesk rechaza POSTs grandes con código PHP).
4. **Cross-linking interno potente** entre `/cursos-subvencionados-castilla-la-mancha/`, `/preguntas-frecuentes/`, `/blog/` y las páginas de cada centro/curso.

---

## Estructura del repositorio

```
CentrosInfoSystem/
├── README.md                          ← este archivo
├── CHANGELOG.md                       ← historial de cambios
├── docs/                              ← documentación detallada por área
│   ├── 01-architecture.md             ← stack y arquitectura
│   ├── 02-seo-strategy.md             ← estrategia SEO global
│   ├── 03-schemas-json-ld.md          ← documentación de los schemas
│   ├── 04-pages.md                    ← todas las páginas + IDs
│   ├── 05-blog-posts.md               ← los 10 posts de blog SEO
│   ├── 06-faq.md                      ← página FAQ con 28 preguntas
│   ├── 07-forms-cf7.md                ← formularios y notificaciones
│   ├── 08-menus-widgets.md            ← menú principal + footer
│   ├── 09-customizations.md           ← CSS + ajustes del tema
│   ├── 10-pending-tasks.md            ← pendientes manuales
│   └── 11-maintenance.md              ← guía de mantenimiento
├── snippets/
│   ├── infosystem-seo-snippet.php     ← snippet PHP que se carga en WPCode
│   └── README.md                      ← instrucciones de instalación
├── content/
│   └── faq-content.html               ← copia del contenido FAQ
└── assets/                            ← capturas y recursos
```

---

## Quickstart — Continuar el proyecto

1. **Lee primero** [`docs/01-architecture.md`](docs/01-architecture.md) para entender el stack.
2. **Si tocas SEO** → lee [`docs/02-seo-strategy.md`](docs/02-seo-strategy.md) y [`docs/03-schemas-json-ld.md`](docs/03-schemas-json-ld.md). El código vive en [`snippets/infosystem-seo-snippet.php`](snippets/infosystem-seo-snippet.php) y se gestiona desde **WPCode → Code Snippets** (snippet ID 16728 "Infosystem SEO - Schemas JSON-LD").
3. **Si tocas contenido** → [`docs/04-pages.md`](docs/04-pages.md) y [`docs/05-blog-posts.md`](docs/05-blog-posts.md) listan todas las páginas y posts con IDs y slugs.
4. **Si tocas formularios** → [`docs/07-forms-cf7.md`](docs/07-forms-cf7.md).
5. **Si vas a configurar el SMTP definitivo o pasar al dominio real** → [`docs/10-pending-tasks.md`](docs/10-pending-tasks.md).

---

## Logros del proyecto

- ✅ Sitio totalmente en **español**, sin restos demo en inglés (home, eventos, posts).
- ✅ Logo definitivo de Infosystem en escritorio, móvil y sticky.
- ✅ **2 cursos** activos (Gestión de Negocios Online y Ofimática en la nube con Google Drive).
- ✅ Formulario de **inscripción gratuita** integrado en cada curso (CF7 14376 / 13916).
- ✅ Página **/trabaja-con-nosotros/** con formulario + adjunto CV.
- ✅ Página **/preguntas-frecuentes/** con **28 FAQs** + schema `FAQPage`.
- ✅ **10 artículos** de blog SEO geolocalizados en CLM.
- ✅ Schemas JSON-LD: `EducationalOrganization`, `LocalBusiness x4`, `WebSite + SearchAction`, `BreadcrumbList`, `Course`, `BlogPosting`, `FAQPage`.
- ✅ OpenGraph + Twitter Cards + geo meta tags.
- ✅ Menú y footer reorganizados con cross-linking a FAQ y blog.

---

## Pendientes conocidos

Ver detalle completo en [`docs/10-pending-tasks.md`](docs/10-pending-tasks.md):

1. ✅ ~~Configurar SMTP real~~ — **HECHO** (IONOS activo 26/05/2026).
2. **Purgar caché del sitemap** (`/post-sitemap.xml`) — está cacheado a fichero estático por WP Rocket.
3. **Validar schemas** en `https://search.google.com/test/rich-results` tras pasar al dominio definitivo.
4. **Mover el sitio al dominio definitivo** `centrosinfosystem.com` (incluye redirects 301).
5. **Configurar DNS SPF/DKIM/DMARC** en el DNS de `centrosinfosystem.com` para evitar SPAM:
   - SPF: `v=spf1 include:_spf.kundenserver.de ~all`
   - DKIM y DMARC: los registros que indique el panel IONOS.

---

## Créditos

- **Diseño y desarrollo web**: Juan Carlos Robles Magán ([roblesmagan.com](https://roblesmagan.com)) y Grupo Comunicación 360º ([grupocomunicacion360.com](https://grupocomunicacion360.com)).
- **Cliente**: Infosystem — Centro de Educación Polivalente.
