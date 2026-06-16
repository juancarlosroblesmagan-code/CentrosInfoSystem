# Estado del proyecto — centrosinfosystem.com

**Última revisión:** 16/06/2026

---

## Directrices de Diseño y Desarrollo (Anti-Gravity)

> [!IMPORTANT]
> **REGLA DE ORO DE DESARROLLO LIMPIO:**
> Queda estrictamente prohibido introducir código PHP personalizado innecesario, añadir nuevos plugins o modificar las plantillas del tema padre que compliquen el mantenimiento.
> Todo el diseño visual y la maquetación pertenecen a **Elementor** y **WordPress nativo**. 
> Los estilos CSS globales y las correcciones de diseño van exclusivamente en `style.css` del Child Theme (o CSS adicional en el Customizer). La lógica de backend va en snippets individuales de **WPCode**.

---

## Estado de Producción y Desarrollo Local

| Elemento | Estado |
|----------|--------|
| Dominio | ✅ `https://centrosinfosystem.com` |
| Web accesible | ✅ Home, blog, cursos, formularios |
| wp-admin / Plesk | ✅ Tras mu-plugin `infosystem-plesk-user-query-fix.php` |
| SMTP (IONOS) | ✅ `info@centrosinfosystem.com` |
| Tema activo | **Eduma Child Theme** (con estructura de archivos y estilos enlazados) |
| Caché | WP Rocket — vaciar tras cada cambio de diseño |

---

## Cambios de Maquetación Realizados (16/06/2026)

| Elemento | Acción realizada | Ubicación |
|----------|------------------|-----------|
| **Itinerarios Formativos** | Eliminado / Ocultado completamente. | `style.css` del Child Theme |
| **Talleres y Jornadas Formativas** | Sección de eventos eliminada por completo. | `style.css` del Child Theme |
| **Acordeón ¿Por Qué Elegirnos?** | Forzado a cargar colapsado en inicio mediante JS. | `js/infosystem-custom.js` |
| **Contenidos del Acordeón** | Redacción profesional de los 4 desplegables con enfoque SEO. | WPCode Snippet **16837** (DB) |
| **Footer (Recomendados)** | Duplicado eliminado (barra negra) y VipOfertas limpio. | `antigravity-seo.php` (MU-plugin) y Widget de Texto **1210023** |
| **Página de Cursos** | Layout expandido a 100% de la caja de ancho, sin sidebar. | `style.css` del Child Theme |
| **Página de Cursos (Tarjetas)** | Tarjetas simétricas de igual altura, tipografía forzada y botón granate. | `style.css` del Child Theme |

---

## Repositorio (Estructura Canónica)

```
CentrosInfoSystem/
├── README.md, CHANGELOG.md
├── docs/                    ← arquitectura, SEO, formularios, ESTADO-PROYECTO.md
├── content/                 ← FAQ HTML de referencia
├── snippets/                ← SEO JSON-LD para WPCode
├── ImagenesWeb/             ← imágenes WebP del sitio
└── eduma-child/
    ├── LEEME-DISEÑO.md      ← guía única de diseño
    ├── functions.php        ← child setup y encolado de módulos
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
