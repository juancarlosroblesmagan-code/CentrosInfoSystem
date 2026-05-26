# 11 · Mantenimiento del sitio

Guía para tareas recurrentes y cambios habituales.

---

## Acceso

- **URL admin**: `https://friendly-sutherland.5-175-47-192.plesk.page/wp-admin/`
- **Usuario**: `CursosPremium` · rol Administrador.
- **Email**: `info@infosystem.net`.

> Cambiar al pasar al dominio definitivo: `https://centrosinfosystem.com/wp-admin/`.

---

## Tareas mensuales recomendadas

1. **Actualizar plugins y tema** (rama estable).
2. **Hacer backup completo** desde Plesk antes de actualizar.
3. **Revisar Search Console**:
   - Cobertura del sitemap.
   - Posiciones medias por keyword objetivo.
   - Errores 404, redirecciones, cuestiones de indexación.
4. **Revisar Flamingo** para ver leads no procesados.
5. **Comprobar formularios**:
   - Enviar un test desde `/contacto/`.
   - Enviar un test desde `/trabaja-con-nosotros/`.
   - Enviar un test desde inscripción a curso.
6. **Purgar caché** de WP Rocket tras cualquier cambio grande.

---

## Cambios habituales

### Añadir un nuevo curso (producto WooCommerce)

1. WordPress → **Productos → Añadir**.
2. Categoría: **Cursos Castilla la Mancha** (importante, para que el plugin Quote reemplace el carrito por el formulario).
3. **Precio**: dejar en 0,00 € o vacío (gratuito).
4. **Imagen destacada** y descripción corta (≤ 60 palabras → la consume el schema Course).
5. **Descripción larga** con contenido formativo.
6. **Rank Math**: rellenar title, description, focus keyword.
7. Publicar. El schema `Course` se inyecta automáticamente.

### Añadir un post de blog

1. WordPress → **Entradas → Añadir nueva**.
2. Título → genera slug SEO-friendly.
3. Estructura: H2 secciones, H3 sub-apartados.
4. Mínimo 600-800 palabras.
5. 3+ enlaces internos a `/cursos-subvencionados-castilla-la-mancha/`, `/preguntas-frecuentes/`, productos.
6. Imagen destacada (1200×630 px recomendado para Open Graph).
7. Categorías + tags relevantes.
8. **Rank Math**: title (≤ 60 ch), description (≤ 160 ch), focus keyword.
9. Publicar. Schema `BlogPosting` automático.

### Añadir una FAQ

1. Editar `/preguntas-frecuentes/` (ID 16729).
2. En la sección H2 correspondiente, añadir:
   - Bloque **Heading H3** con la pregunta.
   - Bloque **Párrafo** con la respuesta.
3. Guardar. El schema FAQPage detectará el nuevo par.

### Añadir un nuevo centro físico

1. Editar `snippets/infosystem-seo-snippet.php` (en WPCode snippet ID 16728):
   ```php
   // Dentro de infosys_seo_get_centros()
   [
       'id' => 'nombre-slug',
       'name' => 'Infosystem [Localidad]',
       'street' => 'Calle, número',
       'locality' => 'Localidad',
       'postal' => 'CP',
       'lat' => 0.0, 'lon' => 0.0,
       'phone' => '+34 926 33 11 62',
   ],
   ```
2. Actualizar el footer (widget `text-1210023`) añadiendo la localidad.
3. Considerar crear post de blog "Centro Infosystem [Localidad]" para SEO local.

### Cambiar logo

1. Subir imagen nueva a la mediateca.
2. **Apariencia → Personalizar → Logo**:
   - Logo desktop.
   - Logo mobile.
   - Logo sticky.
3. Editar `infosys_seo_logo_url()` en el snippet WPCode si la URL cambia.

### Cambiar email de notificación de los formularios

1. **CF7 → [formulario] → Correo**:
   - Cambiar `Para:` al nuevo email.
2. Repetir en los tres formularios: 13916, 14376 y el de inscripción.
3. (Pendiente SMTP) Si no funciona, revisar WP Mail SMTP.

### Modificar contenido del footer

1. **Apariencia → Widgets → Footer**.
2. Editar el widget `text-1210023` (HTML completo descrito en [`docs/08-menus-widgets.md`](08-menus-widgets.md)).

### Modificar el menú principal

1. **Apariencia → Menús → Main Menu**.
2. Añadir/quitar/reordenar items.
3. Guardar (no requiere purgar caché por norma general; si no se ve, sí).

### Actualizar Rank Math (configuración global)

- **Rank Math → Titles & Meta → Homepage**: title y description de la home.
- **Rank Math → Titles & Meta → Posts / Pages / Products**: plantillas por tipo.
- **Rank Math → Local SEO**: información de la organización (también se inyecta vía nuestro snippet, pero RM la usa para sus propios schemas).
- **Rank Math → Sitemap Settings**: configurar qué CPT incluir.

---

## Resolución de incidencias frecuentes

### "He hecho un cambio y no se ve"

1. **Purgar WP Rocket** (botón "Borrar caché").
2. Si es Elementor: **Elementor → Herramientas → Regenerar CSS**.
3. Recargar con **Ctrl+F5** (force refresh navegador).
4. Si sigue: borrar a mano `/wp-content/cache/wp-rocket/` y `/wp-content/cache/min/`.

### "El formulario no envía emails"

1. Revisar **Flamingo** para confirmar que el envío SE registró → si está → es el SMTP.
2. **WP Mail SMTP → Email Test** → comprobar si pasa.
3. Si falla, revisar config SMTP (ver [`docs/07-forms-cf7.md`](07-forms-cf7.md)).

### "Aparece texto inglés residual"

1. Revisar Elementor de la home (`page 4524 _elementor_data`).
2. Revisar widgets (especialmente footer y header).
3. Revisar el CSS adicional por si hay que añadir un `display:none` para algún elemento del tema.

### "Un schema no aparece en frontend"

1. Comprobar que el snippet WPCode (ID 16728) está **Activo**.
2. Comprobar que su ubicación es `frontend_only`.
3. Inspeccionar `<head>` en DevTools y verificar el JSON-LD.
4. Pasar la URL por Rich Results Test.

### "WP-admin va lento"

- Desactivar plugins innecesarios temporalmente.
- Aumentar `WP_MEMORY_LIMIT` en `wp-config.php` a 256M.

### "Quiero clonar el sitio a otro entorno"

1. Plesk → **Clone subscription** o un plugin tipo Duplicator/All-in-One WP Migration.
2. Tras restaurar, hacer search-replace de URLs (ver `docs/10-pending-tasks.md` punto 4).

---

## Contactos

- **Diseño & desarrollo**: Juan Carlos Robles Magán (`roblesmagan.com`).
- **Cliente / contenidos**: Infosystem (`info@infosystem.net` → futuro `info@centrosinfosystem.com`).
