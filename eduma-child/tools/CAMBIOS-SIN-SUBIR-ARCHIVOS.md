# Cambiar la web SIN subir temas ni mu-plugins

**Objetivo:** dejar de romper la web. Todo se hace en **wp-admin** (y Elementor).  
**No subas:** carpetas `themes/`, `mu-plugins/`, ZIPs ni `infosystem-site-fixes.php`.

---

## Después del backup de Plesk

1. Entra a **wp-admin** → **Apariencia → Temas**.
2. Tema activo: **Eduma** (padre). **No actives** el child.
3. En Plesk, carpeta `wp-content/mu-plugins/`:
   - Si hay archivos `infosystem-*.php`, **bórralos** (no sustituyas por otros).
4. **WP Rocket** → vaciar caché.

La web debe verse como tras el backup (aunque quede demo en inglés). Eso es normal hasta editar en el panel.

---

## Paso 1 — Menú «Cursos» (2 minutos)

**Apariencia → Menús** → menú principal del header.

| Acción | Detalle |
|--------|---------|
| Renombrar | «Cursos Gratis» → **Cursos** |
| Enlace | Debe ir a la categoría de cursos CLM (URL con `cursos-subvencionados-castilla-la-mancha`) |
| Mega menú | En el ítem, desactiva mega menú / submenú Elementor si aparece la opción Thim |
| Guardar | Guardar menú |

*(El CSS del paso 2 oculta la flecha y el panel si el tema sigue mostrándolos.)*

---

## Paso 2 — CSS adicional (5 minutos, muy seguro)

**Apariencia → Personalizar → CSS adicional**

1. Abre en tu PC: `eduma-child/tools/css-adicional-personalizar.css`
2. Copia **todo** el contenido.
3. Pégalo al final del CSS adicional (si ya hay reglas, déjalas).
4. **Publicar** → vaciar caché WP Rocket.

Efecto: banners en páginas internas, menú sin desplegable, tarjetas de la home alineadas, blog/FAQ/Conócenos a ancho completo, catálogo sin contador WooCommerce.

**No cambia textos** («View All Packages», acordeón). Eso es el paso 3.

---

## Paso 3 — Home en Elementor (15–25 minutos)

**Páginas →** la página de inicio (suele llamarse *Demo Main Infosystem* o la marcada como portada) → **Editar con Elementor**.

### Textos y enlaces a buscar (Ctrl+F en el panel de Elementor)

| Buscar | Cambiar a |
|--------|-----------|
| View All Packages | Ver todos los cursos |
| Elige el plan que mejor se adapte… | Más de 500 cursos subvencionados en Castilla-La Mancha. Elige tu perfil y empieza hoy sin coste de matrícula. |
| Cursos completamente actualizados | Aprende a tu ritmo. Cursos online actualizados, sin horarios fijos. |
| Inscríbete cuando quieras, formación a tu ritmo | Texto largo por perfil (ver abajo) |
| Enlaces a envato.market / packages / courses | Tu catálogo: `/cursos-subvencionados-castilla-la-mancha/` |
| Botón hero «Ver cursos gratuitos» | Enlace al catálogo CLM |
| «Solicitar información» | `/contacto/` |

### Acordeón «¿Por qué elegirnos?»

Abre cada panel y pega el texto (modo texto/HTML del widget):

**Trabajadores:**  
Si trabajas en activo en Castilla-La Mancha, accede a cursos gratuitos subvencionados (SEPE y Junta), 100 % online. [Ver catálogo] [Cómo inscribirte] — enlaza catálogo y `/como-funcionan-cursos-subvencionados-sepe-castilla-la-mancha/`

**Desempleados:**  
Cursos gratuitos para desempleados en CLM. [Ver todos los cursos] → catálogo.

**Empresas:**  
Formación bonificada (FUNDAE). [Información para empresas] → `/contacto/`

**Tutores:**  
Tutores especializados en cada curso. [Áreas formativas] → catálogo.

**Importante:** al terminar → **Actualizar** la página → WP Rocket → vaciar caché.

---

## Paso 4 — Traducciones sueltas (opcional)

Si tienes **Loco Translate** (o similar):

- Dominio **eduma** o **thim**
- Cadenas: `View All Packages`, `Get Free Access`, `Package Courses` → español

Sin plugin: solo Elementor (paso 3).

---

## Qué NO hacer (para no romper otra vez)

| No hagas | Por qué |
|----------|---------|
| Subir tema hijo / ZIP a `themes/` | Pantalla blanca recurrente |
| Subir `infosystem-site-fixes.php` | Pantalla blanca |
| Activar child theme | Mismo riesgo |
| Subir varios mu-plugins a la vez | Conflictos |
| Restaurar backup **después** de editar en Elementor | Pierdes cambios del panel |

**Orden:** backup → limpiar mu-plugins viejos → editar menú + CSS + Elementor → luego ya no toques archivos por FTP.

---

## Si la web se queda en blanco otra vez

Sin subir nada nuevo:

1. Plesk → **Restaurar** el backup (o cambiar tema a Eduma en base de datos).
2. Borrar `mu-plugins/infosystem-*.php` si existen.
3. No reactivar el child.

---

## Resumen

| Qué quieres | Dónde |
|-------------|--------|
| Menú Cursos, banners, layout | CSS adicional + menú |
| Textos home, acordeón, enlaces | **Elementor** |
| Conócenos / Cómo funciona completos | Editar esas **páginas** en Elementor o el editor de bloques |
| Código automático masivo | **Solo cuando la web vaya estable** — entonces valoramos 1 mu-plugin pequeño |

Este método es más lento pero **no sustituye archivos** y no tumba el sitio.
