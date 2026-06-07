<?php
/**
 * EMERGENCIA — recuperar web en blanco tras borrar/renombrar el tema hijo.
 *
 * 1. Sube este archivo a la carpeta httpdocs (junto a wp-config.php).
 * 2. Abre en el navegador (cambia la clave si quieres):
 *    https://centrosinfosystem.com/recuperar-web.php?clave=infosystem-recuperar
 * 3. Debe salir el mensaje de OK.
 * 4. BORRA recuperar-web.php del servidor enseguida.
 */

declare( strict_types=1 );

const RECUPERAR_CLAVE = 'infosystem-recuperar';

if ( ! isset( $_GET['clave'] ) || RECUPERAR_CLAVE !== (string) $_GET['clave'] ) {
	http_response_code( 403 );
	header( 'Content-Type: text/plain; charset=utf-8' );
	exit( 'Acceso denegado. Usa: recuperar-web.php?clave=infosystem-recuperar' );
}

$wp_load = __DIR__ . '/wp-load.php';
if ( ! is_readable( $wp_load ) ) {
	http_response_code( 500 );
	exit( 'No encuentro wp-load.php. Sube este archivo dentro de httpdocs (raíz de WordPress).' );
}

require $wp_load;

$themes_root = WP_CONTENT_DIR . '/themes';
$padre       = 'eduma';
$hijo        = 'infosystem-child-theme';

header( 'Content-Type: text/html; charset=utf-8' );

echo '<h1>Recuperación Infosystem</h1><pre>';

if ( ! is_dir( $themes_root . '/' . $padre ) ) {
	echo "ERROR: No existe el tema padre /themes/{$padre}/\n";
	exit( '</pre>' );
}

/* Activar tema padre Eduma (la web debe volver a verse). */
update_option( 'template', $padre );
update_option( 'stylesheet', $padre );

echo "OK: Tema activo cambiado a «{$padre}» (padre).\n";
echo "Abre la home: " . esc_html( home_url( '/' ) ) . "\n\n";

if ( is_dir( $themes_root . '/' . $hijo ) ) {
	echo "Carpeta del hijo encontrada: /themes/{$hijo}/\n";
	$style = $themes_root . '/' . $hijo . '/style.css';
	if ( is_readable( $style ) ) {
		$header = (string) file_get_contents( $style, false, null, 0, 800 );
		if ( str_contains( $header, 'Template:' ) && str_contains( $header, 'eduma' ) ) {
			echo "style.css del hijo parece correcto (Template: eduma).\n";
		} else {
			echo "AVISO: Revisa style.css del hijo — debe incluir «Template: eduma».\n";
		}
	} else {
		echo "AVISO: Falta style.css en el tema hijo.\n";
	}
	$functions = $themes_root . '/' . $hijo . '/functions.php';
	if ( ! is_readable( $functions ) ) {
		echo "AVISO: Falta functions.php en el tema hijo.\n";
	}
	$inc = $themes_root . '/' . $hijo . '/inc';
	if ( ! is_dir( $inc ) ) {
		echo "AVISO: Falta la carpeta inc/ (sube el tema hijo completo desde tu PC).\n";
	}
} else {
	echo "AVISO: No existe /themes/{$hijo}/ — sube el tema hijo completo.\n";
}

echo "\n--- SIGUIENTE ---\n";
echo "1. BORRA este archivo recuperar-web.php del servidor.\n";
echo "2. Entra a wp-admin → Apariencia → Temas.\n";
echo "3. Activa «Eduma Child - Infosystem» solo si la carpeta infosystem-child-theme está completa.\n";
echo "4. WP Rocket → vaciar caché.\n";
echo '</pre>';
