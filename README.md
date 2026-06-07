# Centros Infosystem — Proyecto web

Sitio oficial de **Infosystem — Centro de Educación Polivalente** ([centrosinfosystem.com](https://centrosinfosystem.com)): formación subvencionada SEPE / JCCM en Castilla-La Mancha, con cuatro centros en Ciudad Real.

- **Dominio canónico**: `https://centrosinfosystem.com`
- **Email**: `info@centrosinfosystem.com` (SMTP IONOS activo)
- **Teléfono**: `+34 926 33 11 62`
- **Repositorio**: `https://github.com/juancarlosroblesmagan-code/CentrosInfoSystem`

---

## Stack técnico

| Capa | Tecnología | Notas |
|------|------------|-------|
| CMS | WordPress + Eduma | Child en modo mínimo; producción estable con **Eduma padre** |
| Builder | Elementor | Home y páginas institucionales |
| Catálogo | WooCommerce | Cursos a 0 €, inscripción vía CF7 |
| Formularios | Contact Form 7 | 5 formularios → `info@centrosinfosystem.com` |
| SEO | Rank Math + WPCode | Schemas JSON-LD en `snippets/` |
| SMTP | WP Mail SMTP + IONOS | Activo desde 26/05/2026 |
| Caché | WP Rocket | Vaciar tras cada cambio de diseño |
| Hosting | Plesk | Mu-plugin Plesk solo si admin roto |

---

## Diseño y maquetación (producción estable)

**Sin plugin Infosystem Fixes.** No subir mu-plugins experimentales.

| Guía | Contenido |
|------|-----------|
| `eduma-child/LEEME-DISEÑO.md` | Índice único: menú, CSS, Elementor, CF7 |
| `docs/ESTADO-PROYECTO.md` | Checklist actual y WPCode IDs |
| `eduma-child/tools/CAMBIOS-SIN-SUBIR-ARCHIVOS.md` | Pasos en wp-admin sin subir PHP |
| `eduma-child/tools/PLESK-LIMPIEZA-SERVIDOR.md` | Qué borrar en producción |

---

## Estructura del repositorio

```
CentrosInfoSystem/
├── README.md, CHANGELOG.md
├── docs/                     ← arquitectura, SEO, formularios, ESTADO-PROYECTO.md
├── snippets/                 ← snippet SEO para WPCode
├── content/                  ← FAQ HTML de referencia
├── ImagenesWeb/              ← imágenes WebP del sitio
└── eduma-child/              ← tema hijo (referencia; no activar sin revisión)
    ├── inc/                  ← módulos PHP
    ├── assets/css|js/
    └── tools/                ← CSS producción, fuentes WPCode, mu-plugins permitidos
```

---

## Quickstart

1. Arquitectura → [`docs/01-architecture.md`](docs/01-architecture.md)
2. Estado actual → [`docs/ESTADO-PROYECTO.md`](docs/ESTADO-PROYECTO.md)
3. SEO → [`docs/02-seo-strategy.md`](docs/02-seo-strategy.md) + [`snippets/infosystem-seo-snippet.php`](snippets/infosystem-seo-snippet.php)
4. Páginas y posts → [`docs/04-pages.md`](docs/04-pages.md), [`docs/05-blog-posts.md`](docs/05-blog-posts.md)
5. Formularios → [`docs/07-forms-cf7.md`](docs/07-forms-cf7.md)
6. Pendientes → [`docs/10-pending-tasks.md`](docs/10-pending-tasks.md)

---

## Pendientes conocidos

Ver [`docs/10-pending-tasks.md`](docs/10-pending-tasks.md). Resumen:

1. ✅ SMTP IONOS — hecho
2. ✅ Dominio `centrosinfosystem.com` — activo
3. Purgar caché del sitemap (`/post-sitemap.xml`)
4. Activar snippets WPCode de diseño (Conócenos, blog, SEO)
5. Validar schemas en Rich Results Test

---

## Créditos

Diseño y desarrollo: Juan Carlos Robles Magán ([roblesmagan.com](https://roblesmagan.com)) y Grupo Comunicación 360º. Cliente: Infosystem.
