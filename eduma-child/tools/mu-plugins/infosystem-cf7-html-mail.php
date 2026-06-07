<?php
/**
 * Plugin Name: Infosystem CF7 HTML Mail
 * Description: Envía correos de Contact Form 7 como HTML cuando el cuerpo incluye etiquetas.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'wpcf7_mail_components',
	static function ( $components, $contact_form, $mail_template ) {
		if ( ! is_array( $components ) || empty( $components['body'] ) ) {
			return $components;
		}

		$body = $components['body'];
		if ( false !== stripos( $body, '<' ) && false !== stripos( $body, '>' ) ) {
			$components['use_html'] = true;
		}

		return $components;
	},
	10,
	3
);
