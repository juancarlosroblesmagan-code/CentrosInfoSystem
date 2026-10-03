# Estado del proyecto — centrosinfosystem.com

**Última revisión:** 03/10/2026

## Estado vigente de cierre

La referencia actual es [CIERRE-2026-10-03.md](CIERRE-2026-10-03.md): incluye cambios publicados, mediciones públicas, IDs de producción/clon, reversión y pendientes.

- Ajustes solicitados de formulario, footer móvil, X y contador publicados. Formularios funcionan según confirmación del propietario.
- Producción: WP Rocket y Redis; WP Super Cache inactivo. Indexación permitida. Clon noindex y aislado mediante WordPress, con protección HTTP de Axarnet pendiente.
- Medición móvil pública Lighthouse: rendimiento 54–62 (mediana 58), accesibilidad/buenas prácticas 100; SEO 92 por timeout de robots en la herramienta, con robots válido en comprobación independiente.
- CSS crítico aplazado por decisión del propietario. Pendientes seguridad: rotación de credenciales y reparación de protección HTTP del clon.
- El contador termina el 01/01/2027 a las 23:59; no es un plazo de inscripción de cursos validado.
- Los cambios visuales adicionales se publicaron con fragmentos WPCode separados y controles nativos, sin desplegar íntegramente el tema ni importar BD.

**El contenido siguiente se conserva como historial de septiembre; no representa una auditoría vigente de todas las URLs, Search Console, servicios o permisos. Las condiciones de cierre anteriores prevalecen.**

---

## Directrices de Diseño y Desarrollo (Anti-Gravity)

> [!IMPORTANT]
> **REGLA DE ORO DE DESARROLLO LIMPIO:**
> Queda estrictamente prohibido introducir código PHP personalizado innecesario, añadir nuevos plugins o modificar las plantillas del tema padre que compliquen el mantenimiento.
> Todo el diseño visual y la maquetación pertenecen a **Elementor** y **WordPress nativo**. 
> Los estilos CSS globales y las correcciones de diseño van exclusivamente en `style.css` y `functions.php` del Child Theme.

---

## Estado de Producción y Desarrollo Local

| Elemento | Estado |
|----------|--------|
| Dominio | ✅ `https://centrosinfosystem.com` |
| Web accesible | ✅ Home, blog, cursos, páginas legales, formularios |
| wp-admin / Plesk | ✅ Tras mu-plugin `infosystem-plesk-user-query-fix.php` |
| SMTP (IONOS) | ✅ `info@centrosinfosystem.com` |
| Tema activo | **Eduma Child Theme** (`eduma-child` / `infosystem-child-theme`) |
| Caché | WP Rocket — vaciado y operativo |
| Sitemaps & Search Console | ✅ 0 errores, 0 redirecciones, 0 noindex en Sitemaps XML (35 URLs indexables) |
| Enlaces Internos | ✅ 0 errores 404 en rastreo interno completo |
| Jerarquía Semántica | ✅ Exactamente 1 H1 único por página en todo el sitio |

---

## Cambios y Mejoras Recientes (Septiembre 2026)

| Elemento | Acción realizada | Ubicación |
|----------|------------------|-----------|
| **Corrección 404 Cursos Antiguos** | Eliminación de 404 para `/curso-ofimatica-en-la-nube...` y `/curso-de-gestion-de-negocios...`. Redirección 301 server-side a `/curso-de-ofimatica/` y `/cursos/`, y reemplazo en caliente en DOM. | `eduma-child/functions.php` (Sección 21) |
| **Saneamiento Total Sitemaps** | Exclusión de `/cursos-subvencionados-comunidad-de-madrid/` (noindex) e hispanización directa a `/categoria/*` en `category-sitemap.xml` (0 redirects). | `eduma-child/functions.php` (Sección 21) |
| **Normalización Semántica H1** | Eliminado H1 duplicado en pantalla splash de Home (convertido a `div`). Fichas de cursos normalizadas de 20 H1s a 1 H1 (temarios a H3). Conócenos y Contacto a 1 H1. | `eduma-child/functions.php` (Secciones 18 y 21) |
| **Resolución Google Search Console** | Eliminación de 404 de cursos demo en megamenú (`/course/create-an-lms...`), redirecciones 301 server-side de `/courses/*` a `/cursos/`. | `eduma-child/functions.php` (Sección 21) |
| **Hispanización de Arquitectura** | Redirección 301 de `/category/*` a `/categoria/*` con rewrite nativo (200 OK). Redirección de `/user-account/` a `/mi-cuenta/` y `/become-a-teacher/` a `/trabaja-con-nosotros/`. Corrección de canibalización `-2/`. | `eduma-child/functions.php` (Sección 21) |
| **Saneamiento Sitemap XML** | Exclusión estricta de páginas noindex y de utilidad (`/carrito/`, `/mi-cuenta/`, `/formacion-premium-con-descuento/`, `-2/`) en `page-sitemap.xml`. Purga de transitorios. De 11 a 7 URLs canónicas. | `eduma-child/functions.php` (Sección 21) |
| **Megamenú en Español** | Reemplazo de textos de plantilla ("Ficha de curso estilo 1") por categorías reales en español (Cursos Subvencionados, Desempleados, Trabajadores, etc.). | `eduma-child/functions.php` (Sección 21) |
| **Formulario Contacto (`/contacto/`)** | Eliminación de scroll interno, agrupación limpia de checkboxes, botón de envío granate corporativo prémium y acordeón desplegable RGPD (`<details>`) para eliminar la pared de texto. | `eduma-child/functions.php` y Elementor |
| **Logo Oficial en Widget WhatsApp** | Reemplazo de iniciales "IS" por el logotipo corporativo oficial (`InfoSystem-logo.png`), animación luminosa y optimizaciones mobile-first. | `eduma-child/functions.php` (Sección 20) |
| **Widget WhatsApp & Asistente IA** | Widget flotante (+34 619 06 19 33) con control horario (8h a 20h directo; fuera de horario chatbot IA 24/7 y agendador automático a `info@centrosinfosystem.com`). | `functions.php` y `inc/infosystem-whatsapp-bot.php` |
| **Footer Global Dark** | Rediseño a fondo oscuro `#121217`, acento granate, 4 columnas amplias, iconos corporativos dorados alineados geométricamente y barra de copyright en fila única. | Plantilla Elementor ID **8920** |
| **Formulario Home ("Regístrate")** | Eliminación de scroll interno (`max-height`), tarjeta blanca con generoso margen blanco perimetral (padding 46px 42px 54px), campos estilizados y botón submit con sangría limpia. | `functions.php` (CSS dinámico) y Elementor |
| **Páginas Legales** | Unificación a plantilla `elementor_header_footer` (Ancho Completo) en *Política de Calidad* y *Aviso Legal*, eliminando dobles cabeceras y sidebars del tema padre. | WordPress DB y `style.css` |
| **Política de Calidad** | Eliminación de la separación blanca superior de 20px mediante anulación de `--padding-top`, enlazando el banner a ras del menú dorado (`gap = 0 px`). | `functions.php` (`infosystem_dynamic_css`) |
| **Conócenos** | Expansión del banner CTA granate a full-width real (`100vw`) eliminando la franja blanca lateral. | `style.css` del Child Theme |
| **Cursos (Banda Finalizado)** | Lógica automática para detectar cursos pasados y mostrar la banda "FINALIZADO" en los banners. | `functions.php` y `style.css` |

## Repositorio (Estructura Canónica)

```
CentrosInfoSystem/
├── README.md, CHANGELOG.md
├── docs/                    ← arquitectura, SEO, formularios, ESTADO-PROYECTO.md
├── content/                 ← FAQ HTML de referencia
├── snippets/                ← SEO JSON-LD para WPCode
├── ImagenesWeb/             ← imágenes WebP del sitio
└── eduma-child/
    ├── functions.php        ← child setup y encolado de módulos
    ├── inc/                 ← módulos PHP (whatsapp-bot, woocommerce, etc.)
    ├── style.css            ← CSS del child con overrides de maquetación y cursos
    ├── js/
    │   └── infosystem-custom.js ← JS personalizado (acordeón colapsado, etc.)
    ├── inc/                 ← módulos PHP (referencia)
    ├── assets/css/
    └── tools/               ← CSS producción, WPCode fuentes, mu-plugins permitidos
```

---

## WPCode — Referencia IDs

| ID | Nombre | Acción |
|----|--------|--------|
| 16728 | SEO schemas | Activar |
| 16828 | Banner cursos | Activar |
| 16830 | Conócenos full-bleed | Activar |
| 16831 | Blog moderno | Activar |
| 16832 | Single post | Activar |
| 16837 | Infosystem - Protección email y textos home | Activo (Contiene filtros de acordeón y landing) |
| 16857 | Trabaja con nosotros | **Dejar inactivo** (duplica) |

---

## Servidor Plesk — MU-Plugins Permitidos

Solo en `wp-content/mu-plugins/`:

- `infosystem-plesk-user-query-fix.php` (admin Plesk)
- `antigravity-seo.php` (enlace corporativo de footer desactivado para evitar redundancia con el widget de texto)
- Opcional: `infosystem-cf7-config-fix.php`, `infosystem-cf7-html-mail.php`
