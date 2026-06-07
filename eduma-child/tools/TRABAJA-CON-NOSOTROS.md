# Trabaja con nosotros — arreglo URL, home y formulario

## Problema

- La home enlazaba a `/become-a-teacher/` (demo Eduma) → **404**
- La página correcta es: **https://centrosinfosystem.com/trabaja-con-nosotros/**

## Solución (un mu-plugin)

Sube a `wp-content/mu-plugins/`:

`tools/mu-plugins/infosystem-trabaja.php`

Hace:

1. **Redirección 301** de `/become-a-teacher/` → `/trabaja-con-nosotros/`
2. **Enlaces de la home** corregidos (script ligero, sin romper la web)
3. **Página visual** con formulario Contact Form 7 (ID **14376**)
4. **Campo CV** obligatorio (PDF/Word, máx. 5 MB)
5. **Emails:**
   - A `info@centrosinfosystem.com`: aviso de nueva candidatura + CV adjunto
   - Al candidato: confirmación de recepción

## Después de subir

1. Entra **una vez** a wp-admin (sincroniza el formulario CF7).
2. **WP Rocket** → vaciar caché.
3. Prueba:
   - https://centrosinfosystem.com/become-a-teacher/ → debe ir a trabaja-con-nosotros
   - Desde la home, botón «Trabaja con nosotros»
   - Envío de prueba con un PDF pequeño

## Si el formulario no envía

Comprueba **WP Mail SMTP** activo y formulario **14376** en Contacto → Formularios de contacto.

## Sin mu-plugin (manual)

- **Elementor** en la home: cambia el enlace del botón a `/trabaja-con-nosotros/`
- **Rank Math / Redirecciones** o plugin Redirection: 301 `become-a-teacher` → `trabaja-con-nosotros`
