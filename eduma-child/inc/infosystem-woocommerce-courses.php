<?php
/**
 * Cursos como productos WooCommerce (estilo cursospremiumonline.es).
 * Sin LearnPress / LMS.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

/** Slug de la categoría principal de cursos CLM. */
const EDUMA_CHILD_WC_CAT_SLUG = 'cursos-subvencionados-castilla-la-mancha';

/**
 * URL del archivo de la categoría de cursos.
 *
 * @return string
 */
function eduma_child_wc_courses_category_url() {
	$term = get_term_by( 'slug', EDUMA_CHILD_WC_CAT_SLUG, 'product_cat' );
	if ( $term && ! is_wp_error( $term ) ) {
		$link = get_term_link( $term );
		if ( ! is_wp_error( $link ) ) {
			return $link;
		}
	}
	return home_url( '/cursos-subvencionados-castilla-la-mancha/' );
}

/**
 * Configura WooCommerce para el catálogo de cursos.
 */
function eduma_child_infosystem_setup_woocommerce_courses() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$term = get_term_by( 'slug', EDUMA_CHILD_WC_CAT_SLUG, 'product_cat' );
	if ( ! $term ) {
		$created = wp_insert_term(
			'Cursos Castilla la Mancha',
			'product_cat',
			array(
				'slug'        => EDUMA_CHILD_WC_CAT_SLUG,
				'description' => 'Cursos gratuitos subvencionados en Castilla-La Mancha por la Junta de CLM, el Ministerio de Educación, Formación Profesional y Deportes y el SEPE.',
			)
		);
		if ( is_wp_error( $created ) ) {
			return;
		}
		$term_id = (int) $created['term_id'];
	} else {
		$term_id = (int) $term->term_id;
	}

	$cursos_page = get_page_by_path( 'cursos-gratis' );
	if ( $cursos_page instanceof WP_Post ) {
		update_post_meta( $cursos_page->ID, '_eduma_child_wc_catalog_redirect', '1' );
		delete_post_meta( $cursos_page->ID, '_elementor_edit_mode' );
		delete_post_meta( $cursos_page->ID, '_elementor_data' );
		wp_update_post(
			array(
				'ID'           => $cursos_page->ID,
				'post_content' => '<!-- wp:shortcode -->[product_category category="' . EDUMA_CHILD_WC_CAT_SLUG . '" per_page="24" columns="3" orderby="date" order="DESC"]<!-- /wp:shortcode -->',
			)
		);
	}

	$shop_id = (int) get_option( 'woocommerce_shop_page_id', 0 );
	if ( $cursos_page && $shop_id === (int) $cursos_page->ID ) {
		update_option( 'woocommerce_shop_page_id', 0 );
	}

	if ( class_exists( 'LearnPress' ) ) {
		$lp_courses = (int) get_option( 'learn_press_courses_page_id', 0 );
		if ( $cursos_page && $lp_courses === (int) $cursos_page->ID ) {
			update_option( 'learn_press_courses_page_id', 0 );
		}
	}

	update_option( 'eduma_child_wc_cat_term_id', $term_id );
}

add_action( 'eduma_child_infosystem_run_setup', 'eduma_child_infosystem_setup_woocommerce_courses', 15 );

/**
 * Redirige /cursos-gratis/ al archivo de categoría.
 */
add_action(
	'template_redirect',
	static function () {
		if ( ! is_page( 'cursos-gratis' ) ) {
			return;
		}
		if ( ! get_post_meta( get_queried_object_id(), '_eduma_child_wc_catalog_redirect', true ) ) {
			return;
		}
		$target = eduma_child_wc_courses_category_url();
		if ( trailingslashit( home_url( '/cursos-gratis/' ) ) === trailingslashit( $target ) ) {
			return;
		}
		wp_safe_redirect( $target, 301 );
		exit;
	},
	5
);

/* ------------------------------------------------------------------------- *
 * Cursos gratuitos (0 €): botón "Leer más", sin añadir al carrito.
 * ------------------------------------------------------------------------- */

add_filter(
	'woocommerce_is_purchasable',
	static function ( $purchasable, $product ) {
		if ( $product && (float) $product->get_price() <= 0 ) {
			return false;
		}
		return $purchasable;
	},
	10,
	2
);

add_filter(
	'woocommerce_product_add_to_cart_text',
	static function ( $text, $product ) {
		if ( $product && (float) $product->get_price() <= 0 ) {
			return __( 'Leer más', 'eduma-child' );
		}
		return $text;
	},
	10,
	2
);

add_filter(
	'woocommerce_product_add_to_cart_url',
	static function ( $url, $product ) {
		if ( $product && (float) $product->get_price() <= 0 ) {
			return $product->get_permalink();
		}
		return $url;
	},
	10,
	2
);

add_filter(
	'woocommerce_get_price_html',
	static function ( $html, $product ) {
		if ( $product && (float) $product->get_price() <= 0 ) {
			return '';
		}
		return $html;
	},
	10,
	2
);

/**
 * Archivo categoría cursos CLM: sin contador ni selector «Ordenar por».
 */
add_action(
	'wp',
	static function () {
		if ( ! is_tax( 'product_cat', EDUMA_CHILD_WC_CAT_SLUG ) ) {
			return;
		}
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	},
	20
);
