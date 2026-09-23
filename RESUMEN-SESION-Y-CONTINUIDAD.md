# Resumen de Sesión y Guía de Continuidad — Centros InfoSystem
**Fecha:** 24 de Septiembre de 2026  
**Sitio en Producción:** `https://centrosinfosystem.com`  
**Tema Activo:** `eduma-child` (Child Theme del tema Eduma)

---

## 1. Estado Actual del Proyecto (Producción 100% Operativo)

1. **Google Search Console & SEO Técnico:**
   - **404 Eliminados al 100%:** Detectados y corregidos los enlaces residuales en megamenú y Home a `/curso-ofimatica-en-la-nube-con-google-drive-clm/` y `/curso-de-gestion-de-negocios-online-2-0-clm/`. Se redirigen server-side con HTTP 301 a `/curso-de-ofimatica/` y `/cursos/`, y se sustituyen preventivamente en el DOM. Cero errores 404 en el rastreo interno.
   - **Sitemaps XML Saneados (Yoast SEO):**
     - Exclusión de páginas con noindex (`/cursos-subvencionados-comunidad-de-madrid/`, `/formacion-premium-con-descuento/`).
     - `category-sitemap.xml` emite directamente las URLs en español (`/categoria/*`) eliminando los saltos 301 del sitemap.
     - Resumen del sitemap global: 35 URLs limpias, 0 errores, 0 redirecciones, 0 noindex.
   - **Jerarquía Semántica H1 (1 único H1 por página):**
     - Home: Convertido el título de pantalla de precarga/splash a `div`, dejando 1 único H1.
     - Cursos: Temarios y módulos WooCommerce convertidos a `<h3>`, dejando 1 único H1 por curso.
     - Conócenos, Contacto y FAQ: Subtítulos internos a `<h2>`, dejando 1 único H1 por página.

2. **Página de Contacto (`/contacto/`):**
   - Eliminación de barras de desplazamiento internas en el formulario.
   - Acordeón colapsable para el bloque legal RGPD (`<details class="infosystem-rgpd-accordion">`).
   - Casillas de verificación (checkboxes) agrupadas y estilizadas limpiamente.
   - Botón de envío granate corporativo con `border-radius: 10px`, ancho completo y sombra suave.
   - Equilibrio visual milimétrico entre la columna de información y la del formulario.

3. **Widget WhatsApp & Asistente Virtual:**
   - Logotipo oficial de Centros InfoSystem (`InfoSystem-logo.png`) integrado en el botón lanzador.
   - Optimización de visualización en vista móvil (z-index 999999, sin solapamientos).
   - Control horario activo (08:00h - 20:00h directo a WhatsApp; fuera de horario asistente IA con agendador de llamadas a `info@centrosinfosystem.com`).

---

## 2. Herramientas y Despliegue en Producción

El proyecto cuenta con un script de despliegue automatizado que sincroniza el código local con producción mediante el Theme Editor de WordPress, purga la caché de WP Rocket, invalida la caché de sitemaps y refresca los permalinks:

```bash
python eduma-child/tools/deploy-functions.py
```

- **Archivo fuente del Child Theme:** [`eduma-child/functions.php`](file:///c:/Users/JuanCarlosMagan/OneDrive%20-%20Juan%20Carlos%20Robles%20Mag%C3%A1n/ANTIGUO/OJO%20C/ANTI-GRAVITY/CENTROS%20INFOSYSTEM/eduma-child/functions.php)
  - **Sección 20:** Widget Flotante de WhatsApp + Chatbot IA + Agendador.
  - **Sección 21:** Arquitectura SEO, Redirecciones 301, Filtrado de Sitemaps e Hispanización de Menús.

---

## 3. Verificación de URLs Clave (Resultados HTTP en Vivo)

| URL | Código HTTP | Acción / Destino |
|---|---|---|
| `https://centrosinfosystem.com/` | **200 OK** | Página de inicio |
| `https://centrosinfosystem.com/cursos/` | **200 OK** | Catálogo formativo |
| `https://centrosinfosystem.com/categoria/cursos-subvencionados/` | **200 OK** | Archivo de categoría nativa |
| `https://centrosinfosystem.com/category/cursos-subvencionados/` | **301 MOVED** | Redirige a `/categoria/cursos-subvencionados/` |
| `https://centrosinfosystem.com/course/create-an-lms-website-with-learnpress/` | **301 MOVED** | Redirige a `/cursos/` |
| `https://centrosinfosystem.com/page-sitemap.xml` | **200 OK** | XML limpio con 7 URLs indexables |
| `https://centrosinfosystem.com/contacto/` | **200 OK** | Formulario optimizado con acordeón RGPD |

---

## 4. Instrucciones para Reanudar en la Siguiente Sesión

Al abrir la conversación nuevamente:
1. El repositorio local se encuentra limpio y sincronizado con Git (`main`).
2. Todo el código activo está en producción en el servidor de Centros InfoSystem.
3. El próximo paso operativo recomendado es acceder a **Google Search Console** y pulsar en **"Validar corrección"** en los informes de:
   - *Páginas no encontradas (404)*.
   - *URL enviada contiene la etiqueta noindex*.
4. Si el usuario solicita nuevas optimizaciones de diseño, contenidos o rendimiento, consultar previamente [`docs/ESTADO-PROYECTO.md`](file:///c:/Users/JuanCarlosMagan/OneDrive%20-%20Juan%20Carlos%20Robles%20Mag%C3%A1n/ANTIGUO/OJO%20C/ANTI-GRAVITY/CENTROS%20INFOSYSTEM/docs/ESTADO-PROYECTO.md) y [`eduma-child/functions.php`](file:///c:/Users/JuanCarlosMagan/OneDrive%20-%20Juan%20Carlos%20Robles%20Mag%C3%A1n/ANTIGUO/OJO%20C/ANTI-GRAVITY/CENTROS%20INFOSYSTEM/eduma-child/functions.php).
