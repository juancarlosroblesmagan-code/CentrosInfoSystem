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

## SMTP (PENDIENTE)

El envío de emails actualmente falla porque **no hay un SMTP configurado**. Síntomas observados:

- Los formularios se envían y guardan correctamente en **Flamingo**.
- El email **no llega** a la academia ni al usuario.
- WP Mail SMTP marca el envío como fallido en su log.

### Configuración objetivo

Cuando esté listo el dominio `centrosinfosystem.com`:

1. Crear buzón `info@centrosinfosystem.com` en el panel de Plesk.
2. **Plugin WP Mail SMTP** → Settings:
   - From Email: `info@centrosinfosystem.com`
   - From Name: `Infosystem`
   - Mailer: `Other SMTP` (o `Sendinblue/Brevo` si se quiere transaccional).
   - Host: `smtp.centrosinfosystem.com` (Plesk lo dirá exactamente)
   - Port: `587`
   - Encryption: `TLS`
   - Authentication: ON
   - Username: `info@centrosinfosystem.com`
   - Password: (contraseña del buzón)
3. Hacer un envío de prueba desde *WP Mail SMTP → Tools → Email Test*.
4. **Actualizar destinatario en los 3 CF7** (`To`) a `info@centrosinfosystem.com`.
5. Hacer envío de prueba real desde cada formulario.

### Mientras tanto

- Revisar los envíos en `wp-admin → Flamingo → Mensajes entrantes` (todos quedan registrados ahí).
- Configurar un **email de respaldo personal** en WP Mail SMTP para no perder leads (opcional).
