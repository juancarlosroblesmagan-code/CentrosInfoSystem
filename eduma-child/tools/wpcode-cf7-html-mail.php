<?php
/**
 * CF7: forzar envío de correos en HTML cuando el cuerpo contiene etiquetas HTML.
 * Evita que lleguen como texto plano con <h3>, <p>, etc. visibles.
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
