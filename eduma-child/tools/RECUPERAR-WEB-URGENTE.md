# RECUPERAR WEB (pantalla en blanco)

## Pantalla blanca tras borrar/renombrar el tema hijo

WordPress sigue buscando una carpeta que ya no existe (por ejemplo `eduma-child`) o el tema hijo nuevo está **incompleto** (falta `inc/`, `functions.php`, etc.).

### Recuperación rápida (script)

1. En Plesk, si existe `wp-content/mu-plugins`, renómbrala a `mu-plugins-APAGADO`.
2. Sube a **httpdocs** (raíz, junto a `wp-config.php`) el archivo:
   - `eduma-child/tools/recuperar-web.php`
3. Abre en el navegador:
   - `https://centrosinfosystem.com/recuperar-web.php?clave=infosystem-recuperar`
4. Debe activar el tema **Eduma** padre y la home debería cargar.
5. **Borra** `recuperar-web.php` del servidor al instante.
6. Entra a **wp-admin** → **Apariencia → Temas** → activa el hijo solo cuando hayas subido la carpeta completa `infosystem-child-theme`.

### Sin script (phpMyAdmin en Plesk)

Tabla `wp_options` (el prefijo puede ser `wp_` u otro):

```sql
UPDATE wp_options SET option_value = 'eduma' WHERE option_name = 'template';
UPDATE wp_options SET option_value = 'eduma' WHERE option_name = 'stylesheet';
```

Luego sube el tema hijo completo y actívalo desde el panel.

---

## Por qué pasa (mu-plugins)

En el servidor ya está activo el **tema hijo** `infosystem-child-theme`, que incluye los mismos arreglos en PHP.

Si subes **`infosystem-site-fixes.php`** (el grande), WordPress carga **dos veces** el mismo código → error fatal → **pantalla blanca**.

No es que se hayan borrado tus datos: es un conflicto de archivos.

---

## PASO 1 — Comprobar que la web vuelve (ya lo hiciste)

Con la carpeta `mu-plugins` **vacía** o borrada, abre:

https://centrosinfosystem.com/

Debe cargar (aunque sin algunos arreglos visuales extra).

---

## PASO 2 — Subir SOLO el archivo seguro

1. Plesk → **Archivos** → `httpdocs/wp-content/`
2. Crea la carpeta **`mu-plugins`** si no existe.
3. Sube **un solo archivo** desde tu PC:

   `eduma-child/tools/mu-plugins/infosystem-mu-ui-css.php`

4. **NO subas**:
   - `infosystem-site-fixes.php` (rompe la web)
   - `infosystem-global-ui-fix.php`
   - `infosystem-conocenos-fix.php`
   - `infosystem-como-funciona-landing.php`
   - `infosystem-course-images.php`
   - `infosystem-cf7-config-fix.php`

5. **WP Rocket → Vaciar caché** + Ctrl+F5 en el navegador.

Ese archivo solo añade **CSS** (menú, banners, blog, home). No choca con el tema hijo.

---

## PASO 3 — Si sigue en blanco

1. Borra o renombra `mu-plugins` → `mu-plugins-APAGADO`
2. Si aún falla, en Plesk renombra `wp-content/object-cache.php` → `object-cache.off`
3. Entra a `/wp-admin` y desactiva **Redis Object Cache** si está activo

---

## Opción mejor a medio plazo (sin mu-plugins)

Sube el **tema hijo completo** por FTP a:

`httpdocs/wp-content/themes/infosystem-child-theme/`

Carpeta local: `eduma-child/` del proyecto.

Así tienes Conócenos, Cómo funciona, home y banners **sin** usar mu-plugins.

---

## CF7 (formularios)

Los archivos `infosystem-cf7-*.php` son **opcionales**. Si quieres quitar avisos de email, corrige manualmente en cada formulario:

- **De:** `Infosystem <info@centrosinfosystem.com>`
- **Mail (2) → Cabeceras:** `Reply-To: info@centrosinfosystem.com`

---

## Resumen

| Archivo | ¿Subir? |
|---------|---------|
| `infosystem-mu-ui-css.php` | **SÍ** (seguro) |
| `infosystem-site-fixes.php` | **NO** (pantalla blanca) |
| Resto de mu-plugins | **NO** por ahora |
| Tema hijo actualizado | Recomendado cuando puedas por FTP |
