# Herramientas Infosystem (repo)

## Diseño (usar esto)

| Archivo | Uso |
|---------|-----|
| `css-adicional-personalizar.css` | Copiar a **Personalizar → CSS adicional** |
| `../assets/css/infosystem-customizer.css` | Misma CSS, referencia en repo |
| `conocenos-full-bleed-sections.css` | WPCode CSS o Elementor (Conócenos) |
| `CAMBIOS-SIN-SUBIR-ARCHIVOS.md` | Guía paso a paso (menú, home Elementor) |
| `../LEEME-DISEÑO.md` | Índice único |

## WPCode (fuentes PHP — pegar solo si hace falta)

`wpcode-performance-seo.php`, `wpcode-301-legacy-slugs.php`, `wpcode-global-headers-footer.php`, `wpcode-email-anti-scraper.php`, `wpcode-conocenos-full-bleed.php`, `wpcode-conocenos-trust-logos-line.php`, `wpcode-eventos-landing.php`, `wpcode-cf7-html-mail.php`, `wpcode-append-accordion-why.php`, `wpcode-home-como-funciona.php`, `wpcode-append-16837-home.txt`

## mu-plugins (opcional en servidor)

| Archivo | Cuándo |
|---------|--------|
| `mu-plugins/infosystem-plesk-user-query-fix.php` | Admin Plesk roto |
| `mu-plugins/infosystem-cf7-config-fix.php` | Avisos CF7 en panel |
| `mu-plugins/infosystem-cf7-html-mail.php` | Mails CF7 en HTML |
| `mu-plugins/_NO-SUBIR/README.md` | Lista de prohibidos |

## Servidor

`PLESK-LIMPIEZA-SERVIDOR.md` — qué borrar en producción.

## Recuperación

`RECUPERAR-WEB-URGENTE.md`, `recuperar-web.php`

## Datos

`source-*.json`, `data/import-payload.json`, `sync-courses-from-premium.ps1`

## Eliminado del repo (no restaurar)

Plugin `infosystem-fixes`, ZIPs, scripts `cdp-*`, carpetas `infosystem-SUBIR-AHORA`, `infosystem-mu-pack.php`, duplicados global/trabaja en PHP.
