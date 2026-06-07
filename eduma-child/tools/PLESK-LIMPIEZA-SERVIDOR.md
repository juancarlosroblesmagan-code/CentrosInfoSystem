# Limpieza en Plesk (centrosinfosystem.com)

Haz esto con la web **ya funcionando** (tema Eduma activo, sin error crítico).

## 1. Plugins — borrar carpetas muertas

`httpdocs/wp-content/plugins/`

| Carpeta | Acción |
|---------|--------|
| `infosystem-fixes-v2.OLD` (o `.OFF`, etc.) | **Eliminar** |
| `infosystem-fixes-v2-1.OLD` | **Eliminar** |
| `infosystem-fixes-v2-2.OLD` | **Eliminar** |
| Cualquier `infosystem-fixes-v2*` duplicado | **Eliminar** (no dejar ninguno activo) |

No reinstalar el plugin Infosystem Fixes hasta nueva versión acordada sin `ob_start` global.

## 2. mu-plugins — dejar limpio

`httpdocs/wp-content/mu-plugins/`

**Borrar** todos los `infosystem-*.php` **excepto** si necesitas admin Plesk:

| Mantener solo si hace falta | Motivo |
|-----------------------------|--------|
| `infosystem-plesk-user-query-fix.php` | Abrir wp-admin desde Plesk |

**Borrar** (rompen o duplican): `infosystem-site-fixes.php`, `infosystem-global-ui-fix.php`, `infosystem-mu-pack.php` (si el diseño va por CSS + Elementor), `infosystem-safe-ui.php`, `infosystem-mu-ui-css.php`, carpetas sueltas de pruebas.

## 3. Raíz httpdocs

Borrar si existen (restos de emergencia):

- `deactivate-infosystem-fixes-emergency.php`
- `deactivate-v23-emergency.php`
- `recuperar-web.php` (solo si ya no lo necesitas)
- `plesk-install.php`, `fix-plesk-admin.php`

## 4. WPCode

En **Code Snippets → Snippets**: desactivar o borrar duplicados «Infosystem - Trabaja / Global / Home» si el diseño ya está en Elementor + CSS.

Mantener activos solo los documentados en `CHANGELOG.md` (SEO, 301, email anti-scraper, etc.) si siguen siendo necesarios.

## 5. Caché

**WP Rocket → Vaciar caché** y, si hace falta, borrar `wp-content/cache/wp-rocket/` desde archivos.

## 6. Comprobar

- Home carga (>200 KB HTML, no pantalla blanca)
- Sin `info@infosystem.net` en el HTML de contacto
- Menú **Cursos** sin mega menú roto
