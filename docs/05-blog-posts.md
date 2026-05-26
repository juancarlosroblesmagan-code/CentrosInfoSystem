# 05 · Blog · 10 artículos SEO

Los 10 artículos están **diseñados para captar tráfico de búsqueda local y regional** en Castilla-La Mancha, con foco en Ciudad Real y los 4 núcleos donde Infosystem tiene centros. Todos publicados el 26/05/2026 (con `date_gmt` escalonado por segundos para preservar el orden).

Cada post lleva:

- Title SEO Rank Math optimizado (≤ 60 caracteres con marca incluida)
- Meta description (≤ 160 caracteres)
- Focus keyword Rank Math
- Categorías relevantes
- 3+ enlaces internos
- Estructura H1/H2/H3
- Schema `BlogPosting` automático (vía WPCode snippet)

---

## Lista completa

| # | ID | Slug | Título | Focus keyword |
|---|----|------|--------|---------------|
| 1 | 16730 | `cursos-subvencionados-sepe-castilla-la-mancha-2026` | Cursos subvencionados SEPE en Castilla-La Mancha 2026: guía completa | cursos subvencionados SEPE Castilla-La Mancha |
| 2 | 16731 | `cursos-gratis-desempleados-ciudad-real-jccm` | Cursos gratis para desempleados en Ciudad Real (JCCM 2026) | cursos gratis desempleados Ciudad Real |
| 3 | 16732 | `formacion-bonificada-fundae-empresas-castilla-la-mancha` | Formación bonificada FUNDAE para empresas en Castilla-La Mancha | formación bonificada FUNDAE empresas CLM |
| 4 | 16733 | `cursos-online-trabajadores-activo-subvencionados` | Cursos online subvencionados para trabajadores en activo (CLM) | cursos online subvencionados trabajadores |
| 5 | 16734 | `certificados-profesionalidad-gratis-castilla-la-mancha` | Certificados de profesionalidad gratis en Castilla-La Mancha 2026 | certificados profesionalidad gratis CLM |
| 6 | 16735 | `centros-infosystem-ciudad-real` | Centros Infosystem en Ciudad Real: Santa Cruz de Mudela, Viso, Fuente el Fresno y Membrilla | centros Infosystem Ciudad Real |
| 7 | 16736 | `cursos-mas-demandados-castilla-la-mancha-2026` | Los 10 cursos más demandados en Castilla-La Mancha en 2026 | cursos más demandados Castilla-La Mancha 2026 |
| 8 | 16737 | `formacion-dual-castilla-la-mancha-guia` | Formación Dual en Castilla-La Mancha: guía completa 2026 | formación dual Castilla-La Mancha |
| 9 | 16738 | `ofimatica-nube-google-drive-por-que-aprenderlo` | Ofimática en la nube con Google Drive: por qué aprenderlo en 2026 | ofimática en la nube Google Drive |
| 10 | 16739 | `gestion-negocios-online-emprender-castilla-la-mancha` | Gestión de Negocios Online 2.0: emprende en CLM en 2026 | emprender Castilla-La Mancha online |

---

## Mapa de keywords cubiertas

```
SEPE / JCCM (institucional)        → Posts 1, 2, 5
Empresas (FUNDAE)                  → Post 3
Trabajadores en activo             → Post 4
Desempleados                       → Post 2
Local (Ciudad Real)                → Posts 2, 6
Centros físicos (long-tail local)  → Post 6
Tendencias / empleabilidad         → Post 7
Formación reglada (Dual)           → Post 8
Cursos específicos (afiliados)     → Posts 9, 10
Emprendimiento                     → Post 10
```

---

## Cross-linking en los posts

Cada post enlaza, como mínimo:

- A `/cursos-subvencionados-castilla-la-mancha/` (CTA principal).
- A `/preguntas-frecuentes/`.
- A `/contacto/` o `/trabaja-con-nosotros/`.
- A los 2 productos de cursos cuando aplica (posts 9 y 10 directamente).

---

## Categorías usadas

| Slug | Nombre |
|------|--------|
| `cursos-subvencionados` | Cursos subvencionados |
| `castilla-la-mancha` | Castilla-La Mancha |
| `cursos-gratuitos` | Cursos Gratuitos |
| `desempleados` | Desempleados |
| `empresas-fundae` | Empresas (FUNDAE) |
| `cursos-online` | Cursos Online |
| `trabajadores` | Trabajadores |
| `certificados-de-profesionalidad` | Certificados de profesionalidad |

---

## Ampliar la serie

Recomendación: publicar **1 post por semana** alternando temas:

- "Cursos para personas mayores de 45 años en CLM"
- "Cómo conseguir tu primer empleo en Ciudad Real con un curso del SEPE"
- "Cursos de inglés gratuitos para conseguir trabajo en hostelería"
- "Curso de atención sociosanitaria: salidas profesionales en CLM"
- "Cursos de marketing digital gratis 2026"
- "Renovación de carné CAP: cómo hacerlo en CLM"
- "Energías renovables en Ciudad Real: oportunidades de empleo"
- Comparativas: "SEPE vs FUNDAE vs JCCM: ¿en qué se diferencian?"

### Función helper `window._createPost`

Durante la creación se preparó una función JavaScript en consola para crear posts vía REST API. Útil si quieres replicar el flujo:

```javascript
window._createPost = async function ({title, slug, content, excerpt, focusKw, seoTitle, categories}) {
  const nonce = window.wpApiSettings.nonce;
  const res = await fetch('/wp-json/wp/v2/posts', {
    method: 'POST',
    headers: { 'X-WP-Nonce': nonce, 'Content-Type': 'application/json' },
    credentials: 'same-origin',
    body: JSON.stringify({
      title, slug, status: 'publish',
      content, excerpt,
      categories: categories || [],
      meta: {
        'rank_math_title': seoTitle,
        'rank_math_description': excerpt,
        'rank_math_focus_keyword': focusKw,
      }
    })
  });
  const data = await res.json();
  return { status: res.status, id: data.id, link: data.link };
};

window._catIds = {
  'cursos-subvencionados': 123, // sustituir por IDs reales tras consultar /wp-json/wp/v2/categories
  'castilla-la-mancha': 124,
  // ...
};
```
