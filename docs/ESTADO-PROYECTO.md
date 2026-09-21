# Estado del proyecto — centrosinfosystem.com

**Última revisión:** 21/09/2026

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

---

## Cambios y Mejoras Recientes (Septiembre 2026)

| Elemento | Acción realizada | Ubicación |
|----------|------------------|-----------|
| **Widget WhatsApp & Asistente IA** | Widget flotante (+34 619 06 19 33) con control horario (8h a 20h directo; fuera de horario chatbot IA 24/7 y agendador automático a `info@centrosinfosystem.com`). | `functions.php` y `inc/infosystem-whatsapp-bot.php` |
| **Footer Global Dark** | Rediseño a fondo oscuro `#121217`, acento granate, 4 columnas amplias, iconos corporativos dorados alineados geométricamente y barra de copyright en fila única. | Plantilla Elementor ID **8920** |
| **Formulario Home ("Regístrate")** | Eliminación de scroll interno (`max-height`), tarjeta blanca con generoso margen blanco perimetral (padding 46px 42px 54px), campos estilizados y botón submit con sangría limpia. | `functions.php` (CSS dinámico) y Elementor |
| **Páginas Legales** | Unificación a plantilla `elementor_header_footer` (Ancho Completo) en *Política de Calidad* y *Aviso Legal*, eliminando dobles cabeceras y sidebars del tema padre. | WordPress DB y `style.css` |
| **Política de Calidad** | Eliminación de la separación blanca superior de 20px mediante anulación de `--padding-top`, enlazando el banner a ras del menú dorado (`gap = 0 px`). | `functions.php` (`infosystem_dynamic_css`) |
| **Conócenos** | Expansión del banner CTA granate a full-width real (`100vw`) eliminando la franja blanca lateral. | `style.css` del Child Theme |
| **Cursos (Banda Finalizado)** | Lógica automática para detectar cursos pasados y mostrar la banda "FINALIZADO" en los banners. | `functions.php` y `style.css` |
| **Limpieza de Repositorio** | Eliminación de la carpeta temporal `scratch/` (más de 380 archivos) y notas obsoletas del child theme. | Repositorio Git |

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
