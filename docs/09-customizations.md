# 09 · Personalizaciones (CSS · tema · logo)

## CSS adicional (Customizer)

Aplicado vía `Apariencia → Personalizar → CSS adicional` (`thim_custom_css`). Su propósito es ocultar restos demo del tema Eduma y normalizar la estética.

```css
/* ============================================================
   INFOSYSTEM - Custom CSS
   Oculta restos demo y aplica estilos de marca
   ============================================================ */

/* 1) Ocultar "Buy Now" del header demo (tema Eduma) */
.bp1-buy-now,
.thim-buy-now,
.tt-buy-now,
.elementor-button.eduma-buy-now,
a.eduma-buy-now,
.header-action-buy-now,
.thim-eduma-mobile {
  display: none !important;
}

/* 2) Ocultar el widget "Eduma Mobile" del sidebar derecho en /cursos-subvencionados…/ */
body.archive .widget_thim_eduma_mobile,
body.post-type-archive-product .widget_thim_eduma_mobile,
body.product-template-default .widget_thim_eduma_mobile,
.thim-eduma-mobile-widget,
aside.widget_eduma_mobile {
  display: none !important;
}

/* 3) Simplificar el menu-item "Cursos Gratis" (era un mega-menú demo) */
#menu-item-16477 .sub-menu,
#menu-item-16477 > .megamenu,
#menu-item-16477 ul.dropdown-menu,
#menu-item-16477 .mega-menu,
#menu-item-16477 .sub-megamenu {
  display: none !important;
}
#menu-item-16477 > a::after,
#menu-item-16477 .caret,
#menu-item-16477 .fa-angle-down {
  display: none !important;
}

/* 4) Ocultar branding "Eduma" / "ThimPress" residual */
.eduma-credits,
.thimpress-credits,
.thim-copyright-text a[href*="thimpress"],
.thim-copyright-text a[href*="eduma"] {
  display: none !important;
}

/* 5) Footer Infosystem - asegurar tipografía y espacios consistentes */
.infosystem-footer-inner { color: #fff; }
.infosystem-footer-inner a { color: #fff; text-decoration: none; transition: color .2s; }
.infosystem-footer-inner a:hover { color: #D4880A; }
.infosystem-footer-credits { color: rgba(255,255,255,.85); }
.infosystem-footer-credits a { color: #D4880A; text-decoration: none; }
.infosystem-footer-credits a:hover { text-decoration: underline; }

/* 6) Botón CTA "Ver cursos" en el header */
.infosystem-cta-btn { transition: opacity .2s; }
.infosystem-cta-btn:hover { opacity: .9; color: #fff !important; }

/* 7) Ocultar columnas demo del footer si reaparecen tras una actualización del tema */
.footer-demo-en,
.eduma-footer-tweets,
.eduma-footer-instagram-demo {
  display: none !important;
}
```

> Si en algún momento se actualiza el tema Eduma y vuelven a aparecer elementos demo, **revisar y ampliar** este CSS.

---

## Logo

| Setting | Archivo | Att. ID |
|---------|---------|---------|
| `thim_logo` (desktop) | `wp-content/uploads/2026/04/InfoSystem-logo.png` | 16674 |
| `thim_logo_mobile` (móvil) | mismo archivo | 16674 |
| `thim_sticky_logo` (sticky desktop) | mismo archivo | 16674 |
| `thim_sticky_logo_mobile` (sticky móvil) | mismo archivo | 16674 |

Todos ajustados al mismo archivo para mantener la marca consistente. Si en el futuro hay una versión "blanca para fondos oscuros" del logo, sustituir solo el sticky por esa versión.

---

## Página principal (Elementor)

Cambios aplicados sobre el meta `_elementor_data` (búsqueda y reemplazo via REST API). Localizaciones:

| EN (demo) | ES (Infosystem) |
|-----------|-----------------|
| Share Your Knowledge. Teach the World. | Comparte tu conocimiento. Forma al mundo. |
| Package Courses | Cursos destacados |
| Our courses are designed to be simple and easy to follow… | Nuestros cursos están diseñados para ser claros, prácticos y enfocados a empleabilidad… |
| No deadlines. No pressure. | Sin agobios. A tu ritmo. |
| Education Autumn Tour | (sección eliminada) |
| Roundtable discussion on STEAM education | (sección eliminada) |
| Working Smart with AI | (post demo eliminado) |
| Why You Should Read Every Day | (post demo eliminado) |
| Succeed in an Online Course | (post demo eliminado) |

> Tras editar `_elementor_data`, regenerar el CSS de Elementor desde *Elementor → Herramientas → Regenerar CSS* y purgar WP Rocket.

---

## Posts y eventos eliminados

- **18 posts demo** (CPT `post`) eliminados permanentemente por REST API (`force=true`).
- **8 eventos demo** del CPT `tp_event` eliminados permanentemente.

> Nota: si se reinstala/restaura el tema, podrían volver a aparecer demos. Revisar y eliminar de nuevo.

---

## Redirecciones (rewrite rules / plugin de redirects)

| Origen | Destino | Tipo |
|--------|---------|------|
| `/cursos-gratis/` | `/cursos-subvencionados-castilla-la-mancha/` | 301 |

Si se cambia de slug en el futuro, dejar siempre un 301.
