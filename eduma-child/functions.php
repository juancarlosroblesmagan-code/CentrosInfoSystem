<?php
/**
 * Eduma Child — Infosystem
 *
 * Por defecto: SOLO estilos (no carga inc/*.php) → evita pantalla blanca.
 * Diseño en producción: CSS adicional + Elementor (ver LEEME-DISEÑO.md). Tema Eduma padre activo.
 *
 * wp-config.php (opcional):
 *   define( 'INFOSYSTEM_CHILD_LOAD_MODULES', true );  // módulos ligeros
 *   define( 'INFOSYSTEM_CHILD_FULL', true );           // Conócenos, eventos, setup…
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

define( 'EDUMA_CHILD_VERSION', '1.3.1' );

/**
 * @param string $file Ruta relativa dentro de inc/.
 */
function eduma_child_require_inc( $file ) {
	$path = get_stylesheet_directory() . '/inc/' . ltrim( $file, '/' );
	if ( is_readable( $path ) ) {
		require_once $path;
		return true;
	}
	return false;
}

/**
 * Encola estilos del child.
 */
function eduma_child_enqueue_styles() {
	$deps = array();
	if ( wp_style_is( 'thim-style', 'registered' ) || wp_style_is( 'thim-style', 'enqueued' ) ) {
		$deps[] = 'thim-style';
	}
	wp_enqueue_style(
		'eduma-child-style',
		get_stylesheet_uri(),
		$deps,
		EDUMA_CHILD_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'eduma_child_enqueue_styles', 1002 );

if ( ! defined( 'INFOSYSTEM_CHILD_LOAD_MODULES' ) || ! INFOSYSTEM_CHILD_LOAD_MODULES ) {
	add_action(
		'admin_notices',
		static function () {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}
			echo '<div class="notice notice-info"><p><strong>Infosystem child (modo mínimo):</strong> ';
			echo 'Solo estilos. Maquetación: <code>LEEME-DISEÑO.md</code> (CSS + Elementor, sin plugin Infosystem Fixes). ';
			echo 'Para cargar PHP del child: <code>define( \'INFOSYSTEM_CHILD_LOAD_MODULES\', true );</code> en wp-config.</p></div>';
		}
	);
	return;
}

$eduma_child_modules = array(
	'performance.php',
	'accessibility.php',
	'cache-plugins.php',
	'infosystem-email-protection.php',
	'infosystem-cf7-html-mail.php',
	'infosystem-cleanup.php',
	'infosystem-woocommerce-courses.php',
	'infosystem-course-content.php',
	'infosystem-subsidizers.php',
);

if ( defined( 'INFOSYSTEM_CHILD_FULL' ) && INFOSYSTEM_CHILD_FULL ) {
	$eduma_child_modules = array_merge(
		$eduma_child_modules,
		array(
			'infosystem-global-headers-footer.php',
			'infosystem-home-fixes.php',
			'infosystem-home-events-strip.php',
			'infosystem-domain.php',
			'infosystem-content.php',
			'infosystem-site.php',
			'infosystem-import-courses.php',
			'infosystem-conocenos.php',
			'infosystem-conocenos-trust-logos.php',
			'infosystem-conocenos-full-bleed.php',
			'infosystem-como-funciona.php',
			'infosystem-eventos.php',
		)
	);
}

foreach ( $eduma_child_modules as $module ) {
	eduma_child_require_inc( $module );
}

add_action(
	'admin_notices',
	static function () {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( defined( 'INFOSYSTEM_CHILD_FULL' ) && INFOSYSTEM_CHILD_FULL ) {
			return;
		}
		echo '<div class="notice notice-info"><p><strong>Infosystem child (módulos ligeros):</strong> ';
		echo 'Conócenos/eventos requieren <code>INFOSYSTEM_CHILD_FULL</code> en wp-config.</p></div>';
	}
);
