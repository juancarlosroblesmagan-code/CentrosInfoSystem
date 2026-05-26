# 08 · Menú principal · Header · Footer

## Menú principal

**Slug**: `main-menu` · **ID**: `444` · **Ubicación**: `primary`.

Orden y contenido final:

| Orden | Tipo | Etiqueta | URL |
|-------|------|----------|-----|
| 1 | page | Inicio | `/` |
| 2 | custom | Cursos Gratis | `/cursos-subvencionados-castilla-la-mancha/` |
| 3 | page | Conócenos | `/about-us/` (o `/conocenos/`) |
| 4 | page | Blog | `/blog/` |
| 5 | page | Preguntas Frecuentes | `/preguntas-frecuentes/` |
| 6 | page | Contacto | `/contacto/` |

### Notas

- El item **Cursos Gratis** (ID `16477`) tenía originalmente un mega-menú demo con tabs y productos demo. Se simplificó:
  - URL cambiada a `/cursos-subvencionados-castilla-la-mancha/`.
  - CSS añadido al Customizer para **ocultar los dropdowns** del mega-menu antiguo en este item concreto (selectores por `#menu-item-16477`).
- **Preguntas Frecuentes** (ID `16740`) se añadió tras crear la página `/preguntas-frecuentes/`.
- **Contacto** (ID `16720`) se movió de orden 99 → 6.

---

## Widget del header (lateral derecho del menú)

**Sidebar**: `menu_right` · **Widget**: `text-1210022`.

Reemplazado el shortcode demo por HTML con teléfono clickeable + botón CTA:

```html
<div class="infosystem-menu-right"
     style="display:flex;align-items:center;gap:15px;justify-content:flex-end;">
  <a href="tel:+34926331162"
     style="color:#8B1A1A;font-weight:700;text-decoration:none;">926 33 11 62</a>
  <a class="elementor-button elementor-button-link infosystem-cta-btn"
     href="/cursos-subvencionados-castilla-la-mancha/"
     style="background:#8B1A1A;color:#fff;padding:10px 22px;border-radius:6px;
            font-weight:700;text-decoration:none;">Ver cursos</a>
</div>
```

> El botón "Buy Now" demo del tema Eduma fue eliminado vía CSS + reemplazo del widget.

---

## Footer

**Sidebar**: `footer` · **Widget**: `text-1210023`.

Reemplazado todo el contenido demo por un footer **personalizado y completamente en español**, con 4 columnas + créditos.

### Estructura

```html
<div class="infosystem-footer-inner" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:30px;padding:40px 0 20px;">

  <!-- Columna 1: Marca -->
  <div>
    <h4 style="color:#D4880A;font-family:Merriweather,serif;font-size:1.05rem;">Infosystem</h4>
    <p style="line-height:1.6;">Centro de Educación Polivalente.
       Formación gratuita subvencionada por el SEPE y la Junta de Castilla-La Mancha.</p>
  </div>

  <!-- Columna 2: Cursos -->
  <div>
    <h4 style="color:#D4880A;…">Cursos</h4>
    <ul>
      <li><a href="/cursos-subvencionados-castilla-la-mancha/">Cursos subvencionados CLM</a></li>
      <li><a href="/curso-de-gestion-de-negocios-online-2-0-clm/">Gestión de Negocios Online 2.0</a></li>
      <li><a href="/curso-ofimatica-en-la-nube-con-google-drive-clm/">Ofimática en la Nube con Google Drive</a></li>
      <li><a href="/blog/">Artículos del blog</a></li>
      <li><a href="/preguntas-frecuentes/">Preguntas frecuentes</a></li>
    </ul>
  </div>

  <!-- Columna 3: Empresa -->
  <div>
    <h4>Empresa</h4>
    <ul>
      <li><a href="/conocenos/">Conócenos</a></li>
      <li><a href="/blog/">Blog</a></li>
      <li><a href="/preguntas-frecuentes/">FAQ</a></li>
      <li><a href="/contacto/">Contacto</a></li>
      <li><a href="/trabaja-con-nosotros/">Trabaja con nosotros</a></li>
    </ul>
  </div>

  <!-- Columna 4: Centros y contacto -->
  <div>
    <h4>Centros y contacto</h4>
    <p>Santa Cruz de Mudela · Viso del Marqués · Fuente del Fresno · Membrilla<br><br>
       <strong>Teléfono:</strong> <a href="tel:+34926331162">+34 926 33 11 62</a><br>
       <strong>Email:</strong> <a href="mailto:info@infosystem.net">info@infosystem.net</a><br>
       <strong>Dirección:</strong> C. Cruz de Piedra, 13<br>
       13730 Santa Cruz de Mudela, Ciudad Real</p>
  </div>

</div>

<!-- Créditos -->
<div class="infosystem-footer-credits" style="border-top:1px solid rgba(212,136,10,.25);padding:18px 0 8px;">
  <p><strong>Diseño Web:</strong>
     <a href="https://roblesmagan.com" target="_blank" rel="noopener nofollow">Juan Carlos Robles Magán</a>
     y <a href="https://grupocomunicacion360.com" target="_blank" rel="noopener nofollow">Grupo Comunicación 360º</a></p>
  <p><strong>Recomendamos:</strong>
     <a href="https://cursospremiumonline.es" target="_blank" rel="noopener nofollow">Cursos Premium</a> |
     <a href="https://hipotecaxpert.com" target="_blank" rel="noopener nofollow">HipotecaXpert</a> |
     <a href="https://vipofertas.es" target="_blank" rel="noopener nofollow">VipOfertas — Marcas hasta 70% dto</a></p>
</div>
```

### Cambios respecto a la demo

- Eliminadas las 4 columnas inglesas demo (con tweets, calendario, etc.).
- Datos NAP completos.
- Cross-linking a FAQ y Blog para SEO interno.
- Créditos con `rel="noopener nofollow"` para no traspasar autoridad innecesariamente.

---

## Widgets desactivados

Los siguientes widgets demo se movieron a *Widgets inactivos* (no se borran para poder restaurar si se necesita):

| ID | Contenido original | Razón |
|----|--------------------|-------|
| `text-1210019`, `text-1210018`, `text-1210021` | Bloques demo inactivos | No usados |
| `text-1210020` | Toolbar superior demo | Sin contenido útil |

Además se ocultó por CSS el widget `Eduma Mobile` del sidebar derecho de las páginas de cursos.
