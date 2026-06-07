# Diseño Infosystem — guía única (sin plugins nuevos)

**Producción estable:** tema **Eduma** (padre) activo. **No** activar el child ni subir el plugin `infosystem-fixes`. **No** subir mu-plugins `infosystem-*` salvo emergencia Plesk (ver abajo).

Todo el diseño visible se hace en **wp-admin**: menús, **CSS adicional**, **Elementor** y formularios CF7.

---

## Orden recomendado

| Paso | Dónde | Archivo / acción |
|------|--------|------------------|
| 1 | Apariencia → Menús | Renombrar «Cursos Gratis» → **Cursos**; enlace al catálogo CLM |
| 2 | Personalizar → **CSS adicional** | Copiar `tools/css-adicional-personalizar.css` (copia en `assets/css/infosystem-customizer.css`) |
| 3 | Páginas → Portada → **Elementor** | Textos, enlaces, acordeón (ver `tools/CAMBIOS-SIN-SUBIR-ARCHIVOS.md` § Paso 3) |
| 4 | Tildes rotas (`MÃ¡s`, `catÃ¡logo`) | En Elementor, reescribir el texto con teclado español (no copiar de PDF/Word con encoding raro) |
| 5 | Contact Form 7 | **De:** `Infosystem <info@centrosinfosystem.com>` en cada formulario |
| 6 | WP Rocket | Vaciar caché tras cada cambio |

Detalle paso a paso: **`tools/CAMBIOS-SIN-SUBIR-ARCHIVOS.md`**.

---

## WPCode (solo si ya lo usas)

Fuentes en `tools/wpcode-*.php` — pegar en **Code Snippets / WPCode** como snippets PHP **solo** los que necesites (SEO, Conócenos full-bleed, etc.). No duplicar lo que ya cubre el CSS o Elementor.

Snippet **16857** «Trabaja con nosotros»: mantener **inactivo** (duplica código).

---

## Servidor — qué debe quedar

Ver **`tools/PLESK-LIMPIEZA-SERVIDOR.md`** (borrar carpetas `infosystem-fixes-v2*.OLD`, plugins duplicados, mu-plugins viejos).

---

## Emergencia Plesk (solo admin roto)

Subir `tools/mu-plugins/infosystem-plesk-user-query-fix.php` a `wp-content/mu-plugins/`. Nada más salvo que acordemos otra cosa.

---

## Repositorio

- **Fuente del tema:** `eduma-child/`
- **No volver a crear:** plugin `infosystem-fixes`, ZIPs de despliegue, scripts `cdp-*` / subida automática.
