<?php
/**
 * WPCode — Añadir al snippet «Infosystem - 301 dominio temporal» (ID 16825).
 * Redirecciones 301 para slugs legacy de páginas demo eliminadas.
 */
defined( 'ABSPATH' ) || exit;

add_action(
	'template_redirect',
	static function () {
		if ( is_admin() ) {
			return;
		}
		$request = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
		$path    = trim( (string) wp_parse_url( $request, PHP_URL_PATH ), '/' );
		$map     = array(
			'term_conditions'  => '/condiciones-generales-de-venta/',
			'terms-conditions' => '/condiciones-generales-de-venta/',
		);
		if ( isset( $map[ $path ] ) ) {
			wp_safe_redirect( home_url( $map[ $path ] ), 301 );
			exit;
		}
	},
	5
);
