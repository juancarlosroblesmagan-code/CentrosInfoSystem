<?php
/**
 * Diagnóstico — sube a httpdocs y abre:
 * https://centrosinfosystem.com/recuperar-diagnostico.php?clave=infosystem-recuperar
 * BORRA el archivo después.
 */

declare( strict_types=1 );

const RECUPERAR_CLAVE = 'infosystem-recuperar';

if ( ! isset( $_GET['clave'] ) || RECUPERAR_CLAVE !== (string) $_GET['clave'] ) {
	http_response_code( 403 );
	exit( 'Forbidden' );
}

$wp_load = __DIR__ . '/wp-load.php';
if ( ! is_readable( $wp_load ) ) {
	exit( 'No encuentro wp-load.php' );
}

require $wp_load;

header( 'Content-Type: text/plain; charset=utf-8' );

echo 'PHP: ' . PHP_VERSION . "\n";
echo 'Tema activo: ' . get_option( 'stylesheet' ) . ' (template: ' . get_option( 'template' ) . ")\n\n";

$child = get_stylesheet_directory();
$files = array(
	'functions.php',
	'style.css',
	'inc/performance.php',
	'inc/infosystem-home-fixes.php',
	'inc/infosystem-como-funciona.php',
	'inc/infosystem-import-courses.php',
);

echo "--- Archivos del tema hijo ---\n";
foreach ( $files as $f ) {
	$path = $child . '/' . $f;
	echo ( is_readable( $path ) ? 'OK' : 'FALTA' ) . "  {$f}\n";
}

echo "\n--- Compatibilidad PHP ---\n";
echo 'str_contains existe: ' . ( function_exists( 'str_contains' ) ? 'sí' : 'NO (usa PHP 7.x — performance.php debe usar strpos)' ) . "\n";

echo "\nSi FALTA algún archivo, sube el tema hijo completo desde eduma-child/.\n";
echo "Si PHP < 8, sube inc/performance.php corregido del proyecto.\n";
