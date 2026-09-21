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
| `docs/ESTADO-PROYECTO.md` | Checklist actual, arquitectura y WPCode IDs |
| `docs/04-pages.md` | Guía de páginas institucionales y legales |
| `eduma-child/tools/CAMBIOS-SIN-SUBIR-ARCHIVOS.md` | Pasos en wp-admin sin subir PHP |
| `eduma-child/tools/PLESK-LIMPIEZA-SERVIDOR.md` | Qué borrar en producción |

---

## Estructura del repositorio

```
CentrosInfoSystem/
├── README.md, CHANGELOG.md
├── docs/                     ← arquitectura, SEO, formularios, ESTADO-PROYECTO.md
├── snippets/                 ← snippet SEO para WPCode
├── content/                  ← FAQ HTML de referencia y contenidos del blog
├── ImagenesWeb/              ← imágenes WebP del sitio
└── eduma-child/              ← tema hijo (referencia; no activar sin revisión)
    ├── inc/                  ← módulos PHP
    ├── assets/css|js/
    └── tools/                ← CSS producción, mu-plugins y scripts de mantenimiento
        ├── update-seo-v2.php ➔ Script de optimización de posts y Rank Math SEO V2.1
        ├── manage-cf7-akismet.php ➔ Script de protección anti-spam Akismet y limpieza de CF7
        └── mu-plugins/       ← Plugins imprescindibles (plesk user fix, seo custom schemas)
```

---

## Scripts de Mantenimiento (tools/)

En la carpeta `eduma-child/tools/` dispones de herramientas en PHP para tareas automatizadas en producción:

1. **`update-seo-v2.php`**: Automatiza la inyección de palabras clave con tildes correctas en español, inserta bloques de imágenes con textos alternativos optimizados, añade bloques de preguntas frecuentes (FAQs) para sobrepasar las 600 palabras exigidas por Rank Math, y fuerza la actualización de metadatos SEO en la base de datos para obtener puntuaciones >90.
2. **`manage-cf7-akismet.php`**: Analiza el uso real de los formularios (en contenido, widgets, Elementor y el plugin de presupuestos de WooCommerce), borra los formularios no utilizados, inyecta las etiquetas de Akismet para protección anti-spam en los formularios activos y traduce automáticamente todas las respuestas de validación al español.

*Instrucciones de uso: Subir temporalmente a la raíz de producción (`httpdocs/`), ejecutar en navegador mediante el parámetro `?clave=infosystem-recuperar` y eliminar del servidor inmediatamente después.*

---

## Quickstart

1. Arquitectura → [`docs/01-architecture.md`](docs/01-architecture.md)
2. Estado actual → [`docs/ESTADO-PROYECTO.md`](docs/ESTADO-PROYECTO.md)
3. SEO → [`docs/02-seo-strategy.md`](docs/02-seo-strategy.md) + [`snippets/infosystem-seo-snippet.php`](snippets/infosystem-seo-snippet.php)
4. Páginas y posts → [`docs/04-pages.md`](docs/04-pages.md), [`docs/05-blog-posts.md`](docs/05-blog-posts.md)
5. Formularios → [`docs/07-forms-cf7.md`](docs/07-forms-cf7.md)
6. Pendientes → [`docs/10-pending-tasks.md`](docs/10-pending-tasks.md)

---

## Últimas Mejoras y Rediseño de Producción (Septiembre 2026)

1. **Widget Flotante WhatsApp (+34 619 06 19 33) y Chatbot IA Fuera de Horario**:
   - Botón interactivo responsive en esquina inferior derecha con degradado oficial WhatsApp y badge de estado.
   - **Horario diurno (8:00h a 20:00h)**: Atención directa por WhatsApp, botón de llamada rápida a `+34 619 06 19 33` y chips de preguntas frecuentes.
   - **Horario nocturno / Fuera de horario (20:00h a 8:00h)**: Activación automática del Asistente Virtual 24/7 con Inteligencia Artificial (soporte Google Gemini API Free Tier y fallback de conocimiento local).
   - **Agendamiento interactivo**: Formulario integrado en el chat para solicitar citas o llamadas con envío inmediato de notificaciones a `info@centrosinfosystem.com`.
2. **Footer Global Dark Premium (Elementor Template 8920)**:
   - Fondo oscuro `#121217` con acento superior granate `#8B1A1A` y 4 columnas proporcionadas sin cortes.
   - Iconos de contacto unificados en dorado corporativo (`#D4880A` con hover `#F3B33D`): mapa, teléfono, email (`\e919` thim-ekits) y sede.
   - Alineación vertical milimétrica de todos los textos de contacto (eje X exacto).
   - Barra de copyright (`#0b0b0e`) en fila única: autoría a la izquierda y enlaces legales a la derecha.
2. **Páginas Institucionales y Elementor**:
   - **Conócenos**: Corrección del banner CTA granate a full-width real (`100vw`) eliminando la franja blanca lateral.
   - **Cursos**: Detección y renderizado automático de la banda "FINALIZADO" según fechas de inicio y fin.
   - **Páginas Legales**: Cabeceras unificadas con fondo granate (`.legal-header`) y tipografía Merriweather en Elementor Ancho Completo, eliminando cabeceras duplicadas del tema padre.
   - **Política de Calidad**: Corrección milimétrica de la separación superior de 20px, unificando el banner a ras de la línea dorada del menú (`gap = 0 px`) idéntico a Política de Cookies y Aviso Legal.
   - **Formulario Home ("Regístrate y Empieza Hoy Mismo")**: Maquetación de la tarjeta con generoso margen blanco perimetral (padding 46px 42px 54px), campos con espaciado uniforme, eliminación de scroll interno y botón de envío sin recortes ni pegado al borde.
3. **Seguridad, Mantenimiento y Calidad**:
   - Protección antispam de correos electrónicos mediante ofuscación Base64 y decodificación JS.
   - Sincronización íntegra de `functions.php` con el Child Theme de producción.
   - Depuración integral del repositorio: eliminación de scripts y volcados de depuración temporales, consolidando una base de código limpia, mantenible y libre de archivos confusos.
   - Endurecimiento de `.gitignore` para proteger credenciales, respaldos y entornos locales.

---

## Créditos

Diseño y desarrollo: Juan Carlos Robles Magán ([roblesmagan.com](https://roblesmagan.com)) y Grupo Comunicación 360º. Cliente: Infosystem.
