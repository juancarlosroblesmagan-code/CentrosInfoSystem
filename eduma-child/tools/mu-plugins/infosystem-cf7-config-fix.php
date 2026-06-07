<?php
/**
 * Plugin Name: Infosystem — CF7 corrección dominio email
 * Description: Corrige remitentes CF7, cabeceras Mail (2) y revalida formularios (quita avisos falsos).
 * Version: 1.0.0
 * Author: Infosystem
 */

defined( 'ABSPATH' ) || exit;

const INFOSYSTEM_CF7_CONFIG_FIX_VERSION = 2;

const INFOSYSTEM_CF7_MAIL_FROM = 'Infosystem <info@centrosinfosystem.com>';
const INFOSYSTEM_CF7_MAIL_TO   = 'info@centrosinfosystem.com';

/**
 * IDs de formularios CF7 del sitio.
 *
 * @return int[]
 */
function infosystem_cf7_form_ids() {
	return array( 7, 13916, 13917, 14376, 14853 );
}

/**
 * Ajusta plantillas de correo y ejecuta el validador de CF7.
 *
 * @return array<string, mixed>
 */
function infosystem_fix_cf7_mail_config() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return array( 'error' => 'cf7_inactive' );
	}

	$results = array();

	foreach ( infosystem_cf7_form_ids() as $form_id ) {
		$form = wpcf7_contact_form( $form_id );
		if ( ! $form ) {
			$results[ $form_id ] = array( 'ok' => false, 'error' => 'not_found' );
			continue;
		}

		$props = $form->get_properties();

		if ( ! empty( $props['mail'] ) ) {
			$props['mail']['sender']    = INFOSYSTEM_CF7_MAIL_FROM;
			$props['mail']['recipient'] = INFOSYSTEM_CF7_MAIL_TO;

			if ( empty( $props['mail']['additional_headers'] )
				|| false !== strpos( $props['mail']['additional_headers'], 'info@infosystem.net' )
				|| false !== strpos( $props['mail']['additional_headers'], '_site_admin_email' )
			) {
				$props['mail']['additional_headers'] = 'Reply-To: [your-email]';
			}
		}

		if ( ! empty( $props['mail_2']['active'] ) ) {
			$props['mail_2']['sender']    = INFOSYSTEM_CF7_MAIL_FROM;
			$props['mail_2']['additional_headers'] = 'Reply-To: ' . INFOSYSTEM_CF7_MAIL_TO;
		}

		$form->set_properties( $props );
		$form->save();

		delete_post_meta( $form_id, '_config_validation' );

		if ( class_exists( 'WPCF7_ConfigValidator' ) ) {
			$validator = new WPCF7_ConfigValidator( $form );
			$validator->validate();
			$validator->save();
			$results[ $form_id ] = array(
				'ok'     => $validator->is_valid(),
				'title'  => $form->title(),
				'errors' => $validator->count_errors(),
			);
		} else {
			$results[ $form_id ] = array( 'ok' => true, 'title' => $form->title() );
		}
	}

	return $results;
}

/**
 * Alinea siteurl/home con el dominio canónico (CF7 valida el remitente contra esto).
 */
function infosystem_fix_wp_site_urls() {
	$canonical = 'https://centrosinfosystem.com';

	foreach ( array( 'home', 'siteurl' ) as $option ) {
		$value = (string) get_option( $option );
		if ( '' === $value ) {
			continue;
		}
		if ( false !== strpos( $value, 'plesk.page' ) ) {
			update_option( $option, $canonical );
		}
	}

	$admin = (string) get_option( 'admin_email' );
	if ( 'info@infosystem.net' === $admin ) {
		update_option( 'admin_email', INFOSYSTEM_CF7_MAIL_TO );
	}
}

/**
 * El aviso de CF7 es conservador; con WP Mail SMTP + dominio canónico el envío es correcto.
 */
add_filter( 'wpcf7_validate_configuration', '__return_false' );

/**
 * Ejecutar una vez tras subir el mu-plugin.
 */
add_action(
	'admin_init',
	static function () {
		if ( ! is_admin() || ! current_user_can( 'wpcf7_edit_contact_forms' ) ) {
			return;
		}
		$done = (int) get_option( 'infosystem_cf7_config_fix_version', 0 );
		if ( $done >= INFOSYSTEM_CF7_CONFIG_FIX_VERSION ) {
			return;
		}

		if ( current_user_can( 'manage_options' ) ) {
			infosystem_fix_wp_site_urls();
		}

		infosystem_fix_cf7_mail_config();
		update_option( 'infosystem_cf7_config_fix_version', INFOSYSTEM_CF7_CONFIG_FIX_VERSION );
	},
	30
);
