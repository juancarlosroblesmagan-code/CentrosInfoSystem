<?php
/**
 * Textos y logos de organismos subvencionadores (JCCM, MEFP, SEPE).
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * @return string
 */
function infosystem_subsidizers_names_html() {
	return __(
		'la <strong>Junta de Castilla-La Mancha</strong>, el <strong>Ministerio de Educación, Formación Profesional y Deportes</strong> y el <strong>SEPE</strong>',
		'eduma-child'
	);
}

/**
 * @return string
 */
function infosystem_subsidizers_financing_paragraph_html() {
	return __(
		'La formación que impartimos en Infosystem está subvencionada por la <strong>Junta de Castilla-La Mancha</strong>, el <strong>Ministerio de Educación, Formación Profesional y Deportes</strong> y el <strong>SEPE</strong> (Servicio Público de Empleo Estatal).',
		'eduma-child'
	);
}

/**
 * @return string
 */
function infosystem_subsidizers_logos_html() {
	$uploads = content_url( '/uploads/2026/05' );
	ob_start();
	?>
	<div class="infosystem-subsidizers-logos" role="group" aria-label="<?php esc_attr_e( 'Organismos que subvencionan la formación en Infosystem', 'eduma-child' ); ?>">
		<img class="infosystem-subsidizers-logo infosystem-subsidizers-logo--jccm" src="<?php echo esc_url( $uploads . '/logo-jccm-castilla-la-mancha.png' ); ?>" alt="<?php esc_attr_e( 'Junta de Castilla-La Mancha', 'eduma-child' ); ?>" width="164" height="109" loading="lazy" decoding="async" />
		<img class="infosystem-subsidizers-logo infosystem-subsidizers-logo--mefp" src="<?php echo esc_url( $uploads . '/InfoSystem-ministerio_educacion-300x61.png' ); ?>" alt="<?php esc_attr_e( 'Ministerio de Educación, Formación Profesional y Deportes', 'eduma-child' ); ?>" width="218" height="44" loading="lazy" decoding="async" />
		<img class="infosystem-subsidizers-logo infosystem-subsidizers-logo--sepe" src="<?php echo esc_url( $uploads . '/InfoSystem-ministerio_trabajo-300x64.png' ); ?>" alt="<?php esc_attr_e( 'SEPE — Servicio Público de Empleo Estatal', 'eduma-child' ); ?>" width="214" height="46" loading="lazy" decoding="async" />
	</div>
	<?php
	return (string) ob_get_clean();
}
