# Estado del proyecto — centrosinfosystem.com

**Última revisión:** 30/05/2026

---

## Producción (ahora)

| Elemento | Estado |
|----------|--------|
| Dominio | ✅ `https://centrosinfosystem.com` |
| Web accesible | ✅ Home, blog, cursos, formularios |
| wp-admin / Plesk | ✅ Tras mu-plugin `infosystem-plesk-user-query-fix.php` |
| SMTP (IONOS) | ✅ `info@centrosinfosystem.com` |
| Tema activo | **Eduma padre** (estable; child en modo mínimo / no activar sin revisión) |
| Caché | WP Rocket — vaciar tras cada cambio de diseño |

---

## Diseño pendiente (sin romper la web)

Prioridad **wp-admin** (CSS, Elementor, WPCode). Ver `eduma-child/LEEME-DISEÑO.md`.

| Tarea | Dónde | Archivo / snippet |
|-------|--------|-------------------|
| CSS global (menú, footer, blog) | Personalizar → CSS adicional | `eduma-child/tools/css-adicional-personalizar.css` |
| Home Elementor (textos, acordeón, demo inglés) | Páginas → Portada → Elementor | `eduma-child/tools/CAMBIOS-SIN-SUBIR-ARCHIVOS.md` |
| Conócenos vacío | WPCode snippet **16830** (activar) | `wpcode-conocenos-full-bleed.php` |
| Blog sidebar «Latest Posts» | WPCode **16831** (activar) | — |
| Single post CTA | WPCode **16832** (activar) | — |
| Banner cursos | WPCode **16828** (activar) | — |
| Schemas SEO | WPCode **16728** (activar) | `snippets/infosystem-seo-snippet.php` |
| Meta home en español | Rank Math → Home | — |
| Sitemap desactualizado | WP Rocket → borrar caché | `docs/10-pending-tasks.md` §2 |

**No subir:** `infosystem-mu-pack.php`, plugin `infosystem-fixes`, ZIPs de despliegue.

---

## Repositorio (estructura canónica)

```
CentrosInfoSystem/
├── README.md, CHANGELOG.md
├── docs/                    ← arquitectura, SEO, formularios, ESTADO-PROYECTO.md
├── content/                 ← FAQ HTML de referencia
├── snippets/                ← SEO JSON-LD para WPCode
├── ImagenesWeb/             ← imágenes WebP del sitio
└── eduma-child/
    ├── LEEME-DISEÑO.md      ← guía única de diseño
    ├── functions.php        ← child modo mínimo
    ├── inc/                 ← módulos PHP (referencia)
    ├── assets/css/
    └── tools/               ← CSS producción, WPCode fuentes, mu-plugins permitidos
```

---

## WPCode — referencia IDs

| ID | Nombre | Acción |
|----|--------|--------|
| 16728 | SEO schemas | Activar |
| 16828 | Banner cursos | Activar |
| 16830 | Conócenos full-bleed | Activar |
| 16831 | Blog moderno | Activar |
| 16832 | Single post | Activar |
| 16857 | Trabaja con nosotros | **Dejar inactivo** (duplica) |

Ya activos (confirmado): anti-scraper email, avatar autor, 301 dominio temporal.

---

## Servidor Plesk — mu-plugins permitidos

Solo en `wp-content/mu-plugins/`:

- `infosystem-plesk-user-query-fix.php` (admin Plesk)
- Opcional: `infosystem-cf7-config-fix.php`, `infosystem-cf7-html-mail.php`

Lista completa de prohibidos: `eduma-child/tools/mu-plugins/_NO-SUBIR/README.md`

---

## Páginas clave (IDs)

| Página | ID |
|--------|-----|
| Home | 4524 |
| Conócenos | 16705 |
| FAQ | 16729 |
| Catálogo CLM | slug `cursos-subvencionados-castilla-la-mancha` |

---

## Seguridad

- Rotar contraseñas compartidas en sesiones de desarrollo.
- Eliminar usuarios temporales (`CursorAgent`, etc.) cuando no hagan falta.
