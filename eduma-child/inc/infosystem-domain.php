<?php
/**
 * Preparación para el dominio definitivo infosystem.net.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Email de contacto oficial del centro.
 */
const INFOSYSTEM_CONTACT_EMAIL = 'info@centrosinfosystem.com';

/**
 * Sustituye el email antiguo inexistente en contenido renderizado.
 *
 * @param string $content HTML o texto.
 * @return string
 */
function infosystem_replace_legacy_email( $content ) {
	if ( ! is_string( $content ) || $content === '' ) {
		return $content;
	}
	return str_replace( 'info@infosystem.net', INFOSYSTEM_CONTACT_EMAIL, $content );
}

add_filter( 'widget_text', 'infosystem_replace_legacy_email', 20 );
add_filter( 'widget_text_content', 'infosystem_replace_legacy_email', 20 );
add_filter( 'the_content', 'infosystem_replace_legacy_email', 20 );

add_action(
	'template_redirect',
	static function () {
		if ( is_admin() ) {
			return;
		}
		if ( defined( 'INFOSYSTEM_MU_PACK_ACTIVE' ) && INFOSYSTEM_MU_PACK_ACTIVE && is_front_page() ) {
			return;
		}
		ob_start(
			static function ( $html ) {
				if ( ! is_string( $html ) ) {
					return $html;
				}
				$html = infosystem_replace_legacy_email( $html );
				if ( function_exists( 'infosystem_should_protect_emails' ) && infosystem_should_protect_emails() ) {
					$html = infosystem_protect_emails_in_html( $html );
				}
				return $html;
			}
		);
	},
	0
);

/**
 * Cuando cambies DNS a infosystem.net, actualiza también:
 * Ajustes → Generales → Direcciones WordPress y del sitio.
 *
 * Este filtro permite forzar URLs si defines la constante en wp-config.php:
 * define( 'INFOSYSTEM_HOME_URL', 'https://infosystem.net' );
 */
add_filter(
	'home_url',
	static function ( $url, $path, $scheme, $blog_id ) {
		if ( defined( 'INFOSYSTEM_HOME_URL' ) && INFOSYSTEM_HOME_URL ) {
			return trailingslashit( INFOSYSTEM_HOME_URL ) . ltrim( (string) $path, '/' );
		}
		return $url;
	},
	10,
	4
);

add_filter(
	'site_url',
	static function ( $url, $path, $scheme, $blog_id ) {
		if ( defined( 'INFOSYSTEM_SITE_URL' ) && INFOSYSTEM_SITE_URL ) {
			return trailingslashit( INFOSYSTEM_SITE_URL ) . ltrim( (string) $path, '/' );
		}
		return $url;
	},
	10,
	4
);
