# Despliegue final Infosystem (v1.3.0 child + mu-pack 2.0.0)

## Resumen

| Qué | Dónde en servidor |
|-----|-------------------|
| Mu-plugin único | `wp-content/mu-plugins/infosystem-mu-pack.php` |
| Tema hijo completo | `wp-content/themes/infosystem-child-theme/` |

## Qué NO subir a mu-plugins

Ver `tools/mu-plugins/_NO-SUBIR/README.md`. Especialmente **no** `infosystem-site-fixes.php`.

## Orden recomendado

1. Tema activo temporalmente **Eduma** (padre) si el child dio pantalla blanca.
2. Limpiar `mu-plugins/` de archivos Infosystem viejos.
3. Subir `infosystem-mu-pack.php` v2.0.0.
4. Vaciar caché WP Rocket.
5. Verificar home en incógnito.
6. Subir carpeta child completa y activar child (modo seguro por defecto).
7. Vaciar caché otra vez.
8. Opcional: `INFOSYSTEM_CHILD_FULL` + Infosystem Setup.

## Modo seguro del child

Por defecto carga solo módulos estables (`performance`, CF7, WooCommerce cursos, etc.).

Con `INFOSYSTEM_CHILD_FULL` se añaden: Conócenos, Cómo funciona, eventos, importación, setup.

## Coordinación mu-pack ↔ child

- `INFOSYSTEM_MU_PACK_ACTIVE` evita doble CSS y doble `ob_start` en home.
- Conócenos: `inc/infosystem-conocenos.php` + `assets/css/infosystem-conocenos-page.css`

## IDs de referencia

- Conócenos: página 16705
- FAQ: 16729
- Menú Cursos: #menu-item-16477
- Catálogo CLM: slug `cursos-subvencionados-castilla-la-mancha`

## CF7 (opcional)

`tools/mu-plugins/infosystem-cf7-config-fix.php` — solo administración; compatible PHP 7.4 (`strpos`).

## Documentación del proyecto

- `docs/DEPLOY-INFOSYSTEM.md`
- `docs/WINSCP-SUBIDA.md`
- `tools/PASOS-ARREGLAR-AHORA.md`
