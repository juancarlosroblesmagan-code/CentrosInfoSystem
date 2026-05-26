# 07 · Formularios (Contact Form 7)

Hay **tres formularios CF7 activos**:

| ID | Título | Uso |
|----|--------|-----|
| 13916 | `Contact Us` | Página `/contacto/` |
| 14376 | `Trabaja con nosotros` | Página `/trabaja-con-nosotros/` |
| (ver abajo) | `Inscripción curso` | Reemplaza el botón "Añadir al carrito" en productos de la categoría *Cursos Castilla la Mancha* |

> Los envíos quedan **guardados en Flamingo** (Contact Form 7 → Flamingo → Mensajes entrantes), incluso si el email falla.

---

## 1 · Formulario de inscripción a curso

Integrado vía **WooCommerce Quote or Enquiry Contact Form 7**.

### Configuración del plugin

- **Categoría aplicable**: *Cursos Castilla la Mancha*.
- Sustituye en esos productos el bloque "Añadir al carrito" por el shortcode del CF7 elegido (visible solo en la ficha del producto cuando el usuario llega desde "Leer más").

### Campos del formulario

- Nombre completo (`tu-nombre`)
- DNI / NIE (`dni`)
- Email (`tu-email`)
- Teléfono (`tu-telefono`)
- Localidad (`localidad`)
- Provincia (`provincia`)
- Situación laboral (radio: Desempleado / Trabajador en activo / Autónomo / Empresa)
- Curso de interés (`curso-interes`, oculto, autopoblado con el nombre del producto)
- Mensaje libre (textarea)
- Consentimiento RGPD (checkbox, obligatorio)

### Notificación al alumno (auto-respuesta)

Configurada para enviarse a la dirección que rellene el campo email:

> Asunto: *"Gracias por tu interés en [curso] · Infosystem"*

Cuerpo (resumen):

- Confirmación de la recepción.
- Próximos pasos (contacto en menos de 24 h laborables).
- Datos de los centros y teléfono.

### Notificación a la academia

- **Destinatario**: `info@infosystem.net` (cambiará a `info@centrosinfosystem.com` cuando el SMTP esté operativo).
- **Asunto**: *"Nueva inscripción · [Nombre] · [Curso]"*.
- **Cuerpo**: todos los campos del formulario en HTML legible.

---

## 2 · Formulario "Trabaja con nosotros" (ID 14376)

Página: `/trabaja-con-nosotros/`.

### Campos

- Nombre y apellidos
- Email
- Teléfono
- Localidad
- Especialidad / familia profesional (select)
- Experiencia (textarea)
- Adjuntar CV (`file` con `filetypes:pdf|doc|docx`, `limit:5mb`)
- Consentimiento RGPD

### Notificación a la academia

- **A**: `info@infosystem.net`.
- **Asunto**: `Nueva candidatura - Trabaja con nosotros`.
- **Adjunto**: el CV subido (CF7 lo adjunta automáticamente con `[your-file]` en la cabecera `File attachments`).

### Auto-respuesta al candidato

- Asunto: *"Hemos recibido tu candidatura - Infosystem"*.
- Cuerpo: agradecimiento + revisión en 7-15 días + datos de contacto.

---

## 3 · Formulario de contacto general (ID 13916)

Página: `/contacto/`.

Formulario standard de "Contact Us" del tema, con:

- Nombre, email, asunto, mensaje, consentimiento RGPD.
- Notificación a `info@infosystem.net`.
- Auto-respuesta al usuario.

---

## SMTP — Configuración IONOS ✅ ACTIVO

Buzón corporativo: **`info@centrosinfosystem.com`** alojado en **IONOS**. Configurado y funcionando desde el 26 de mayo de 2026.

### Parámetros IMAP (recepción)

| Campo | Valor |
|-------|-------|
| Servidor entrante | `imap.ionos.es` |
| Puerto | `993` |
| Seguridad | SSL/TLS |
| Usuario | `info@centrosinfosystem.com` |
| Contraseña | (la del buzón en el panel IONOS) |

> El IMAP es para que el equipo lea el buzón desde cliente de correo. WordPress no lo necesita.

### Parámetros SMTP (envío — lo que usa WordPress)

| Campo | Valor |
|-------|-------|
| Servidor saliente | `smtp.ionos.es` |
| Puerto | `587` |
| Encriptación | `TLS (STARTTLS)` |
| Autenticación | **Sí** (obligatorio) |
| Usuario | `info@centrosinfosystem.com` |
| Contraseña | (la del buzón en el panel IONOS) |

### Configuración aplicada en WP Mail SMTP

`WordPress admin → WP Mail SMTP → Settings → General`:

| Campo | Valor |
|-------|-------|
| **From Email** | `info@centrosinfosystem.com` |
| **Force From Email** | ✅ ON |
| **From Name** | `Infosystem` |
| **Force From Name** | ✅ ON |
| **Return Path** | ✅ ON |
| **Mailer** | `Other SMTP` |
| **SMTP Host** | `smtp.ionos.es` |
| **Encryption** | `TLS` |
| **SMTP Port** | `587` |
| **Auto TLS** | ✅ ON |
| **Authentication** | ✅ ON |
| **SMTP Username** | `info@centrosinfosystem.com` |
| **SMTP Password** | ✅ Encriptada en BD (no visible en UI, oculta tras botón "Quitar la contraseña") |

> **Mejora futura recomendada (no urgente)**: mover la contraseña a una constante en `wp-config.php` para que ni siquiera quede encriptada en la base de datos:
>
> ```php
> define( 'WPMS_ON', true );
> define( 'WPMS_SMTP_PASS', 'tu_password_aqui' );
> ```
>
> Después, en la UI de WP Mail SMTP el campo aparecerá oculto y un aviso indicará que se está leyendo desde `wp-config.php`. Requiere acceso por FTP/Plesk al `wp-config.php`.

### Pasos ya realizados (26/05/2026)

1. ✅ Buzón `info@centrosinfosystem.com` creado y activo en IONOS.
2. ✅ Configurado WP Mail SMTP con los parámetros de la tabla anterior.
3. ✅ Configuración guardada.
4. ✅ Email Test ejecutado dos veces → ambos respondieron *"El correo de prueba HTML se ha enviado correctamente"*:
   - Test 1 → `info@infosystem.net`
   - Test 2 → `info@centrosinfosystem.com` (autotest, verificable en webmail IONOS)
5. ✅ Destinatarios CF7 actualizados a `info@centrosinfosystem.com` en los 5 formularios (ver tabla siguiente).

### Recipientes CF7 (estado actual)

| ID | Form | Asunto | Destinatario | Remitente |
|----|------|--------|--------------|-----------|
| 7 | Información Cursos (inscripción) | `Nueva inscripcion - [product-name] - Infosystem` | `info@centrosinfosystem.com` | `Infosystem <info@centrosinfosystem.com>` |
| 13916 | Contact Us (/contacto/) | `Nuevo contacto - Infosystem - [your-subject]` | `info@centrosinfosystem.com` | `Infosystem <info@centrosinfosystem.com>` |
| 13917 | Contact Home Page | `Nuevo contacto desde la web - Infosystem` | `info@centrosinfosystem.com` | `Infosystem <info@centrosinfosystem.com>` |
| 14376 | Trabaja con nosotros | `Nueva candidatura - Trabaja con nosotros - Infosystem` | `info@centrosinfosystem.com` | `Infosystem <info@centrosinfosystem.com>` |
| 14853 | Contact One Course | `Nueva consulta curso - Infosystem - [your-subject]` | `info@centrosinfosystem.com` | `Infosystem <info@centrosinfosystem.com>` |

### Troubleshooting

| Síntoma | Posible causa | Solución |
|---------|---------------|----------|
| "Authentication failed" | Contraseña incorrecta o cuenta no creada | Verificar credenciales en panel IONOS |
| "Connection timed out" | Hosting bloquea puerto 587 saliente | Pedir a Plesk que abra puerto SMTP saliente o probar puerto 465 con SSL |
| Email llega marcado como SPAM | Falta SPF/DKIM | Configurar en el DNS de `centrosinfosystem.com` los registros que indica IONOS:
| | | • SPF: `v=spf1 include:_spf.kundenserver.de ~all` |
| | | • DKIM: el selector que dé IONOS |
| | | • DMARC: `v=DMARC1; p=quarantine; rua=mailto:info@centrosinfosystem.com` |
| Auto-respuesta no llega al alumno | CF7 con un solo "Mail" configurado | Activar también "Mail (2)" en cada formulario CF7 |

### Mientras tanto

- Revisar los envíos en `wp-admin → Flamingo → Mensajes entrantes` (todos quedan registrados ahí, incluso si el SMTP falla).
