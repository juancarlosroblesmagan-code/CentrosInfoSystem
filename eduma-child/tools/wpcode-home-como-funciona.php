<?php
/**
 * WPCode — Home: enlaces, tarjetas iguales, botones + landing SEO «Cómo funciona».
 * Ejecutar en todas partes · PHP.
 */
defined( 'ABSPATH' ) || exit;

/* --- URLs --- */
if ( ! function_exists( 'infosystem_wc_cursos_url' ) ) {
	function infosystem_wc_cursos_url() {
		$slug = 'cursos-subvencionados-castilla-la-mancha';
		$term = get_term_by( 'slug', $slug, 'product_cat' );
		if ( $term && ! is_wp_error( $term ) ) {
			$link = get_term_link( $term );
			if ( ! is_wp_error( $link ) ) {
				return $link;
			}
		}
		return home_url( '/' . $slug . '/' );
	}
}

if ( ! function_exists( 'infosystem_como_funciona_url' ) ) {
	function infosystem_como_funciona_url() {
		return home_url( '/como-funcionan-cursos-subvencionados-sepe-castilla-la-mancha/' );
	}
}

/* --- Landing: crear página + contenido --- */
if ( ! function_exists( 'infosystem_como_funciona_content_html' ) ) {
	function infosystem_como_funciona_content_html() {
		$cursos   = infosystem_wc_cursos_url();
		$contacto = home_url( '/contacto/' );
		$faq      = home_url( '/preguntas-frecuentes/' );
		ob_start();
		?>
		<article class="infosystem-page infosystem-landing-como-funciona">
			<header class="infosystem-landing-hero">
				<p class="infosystem-landing-kicker">Formación para el empleo · Castilla-La Mancha</p>
				<h1>Cómo funcionan los cursos subvencionados por el SEPE en Castilla-La Mancha</h1>
				<p class="infosystem-lead">En <strong>Infosystem</strong> te explicamos el proceso completo: desde comprobar si cumples requisitos hasta obtener tu certificado, con cursos <strong>100&nbsp;% gratuitos</strong> para trabajadores, desempleados y empresas.</p>
				<p><a class="infosystem-cta" href="<?php echo esc_url( $cursos ); ?>">Ver catálogo de cursos</a> <a class="infosystem-cta infosystem-cta--ghost" href="<?php echo esc_url( $contacto ); ?>">Solicitar información</a></p>
			</header>
			<section><h2>El proceso en 5 pasos</h2>
			<ol class="infosystem-steps">
				<li><h3>1. Comprueba tu perfil</h3><p>Requisitos según trabajador, desempleado o empresa. Documentación: DNI/NIE, vida laboral, etc.</p></li>
				<li><h3>2. Elige tu curso</h3><p>Catálogo de digitalización, ofimática, idiomas, PRL y más en Castilla-La Mancha.</p></li>
				<li><h3>3. Inscríbete gratis</h3><p>Sin coste de matrícula en acciones subvencionadas. Te guiamos en el alta.</p></li>
				<li><h3>4. Formación online a tu ritmo</h3><p>Ordenador, tablet o móvil. Tutores y contenidos actualizados.</p></li>
				<li><h3>5. Certificación</h3><p>Certificado al superar la evaluación. Mejora tu empleabilidad en CLM y España.</p></li>
			</ol></section>
			<section><h2>¿Quién financia estos cursos?</h2>
			<p>La formación está subvencionada por la <strong>Junta de Castilla-La Mancha</strong>, el <strong>Ministerio de Educación, Formación Profesional y Deportes</strong> y el <strong>SEPE</strong>. Infosystem imparte formación para el empleo en la región.</p></section>
			<section class="infosystem-landing-cta-block"><h2>¿Listo para empezar?</h2>
			<p><a class="infosystem-cta" href="<?php echo esc_url( $cursos ); ?>">Ver todos los cursos gratuitos</a> <a class="infosystem-cta infosystem-cta--ghost" href="<?php echo esc_url( $faq ); ?>">Preguntas frecuentes</a></p></section>
		</article>
		<?php
		return (string) ob_get_clean();
	}
}

add_action(
	'init',
	static function () {
		$slug = 'como-funcionan-cursos-subvencionados-sepe-castilla-la-mancha';
		$opt  = 'infosystem_como_funciona_page_id';
		$id   = (int) get_option( $opt );
		if ( $id && 'publish' === get_post_status( $id ) ) {
			return;
		}
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page instanceof WP_Post ) {
			update_option( $opt, $page->ID );
			return;
		}
		$new_id = wp_insert_post(
			array(
				'post_title'   => 'Cómo funcionan los cursos subvencionados por el SEPE en Castilla-La Mancha',
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => infosystem_como_funciona_content_html(),
			),
			true
		);
		if ( ! is_wp_error( $new_id ) && $new_id ) {
			update_option( $opt, $new_id );
			update_post_meta( $new_id, 'rank_math_title', 'Cómo funcionan los cursos subvencionados SEPE en Castilla-La Mancha | Infosystem' );
			update_post_meta( $new_id, 'rank_math_description', 'Guía paso a paso: requisitos, inscripción gratuita, formación online y certificado de cursos subvencionados por el SEPE en Castilla-La Mancha.' );
		}
	},
	20
);

add_filter(
	'the_content',
	static function ( $content ) {
		if ( ! is_page( 'como-funcionan-cursos-subvencionados-sepe-castilla-la-mancha' ) ) {
			return $content;
		}
		if ( strlen( trim( wp_strip_all_tags( $content ) ) ) < 80 ) {
			return infosystem_como_funciona_content_html();
		}
		return $content;
	},
	5
);

/* --- Home: enlaces y textos --- */
add_action(
	'template_redirect',
	static function () {
		if ( is_admin() || ! is_front_page() ) {
			return;
		}
		$cursos = esc_url( infosystem_wc_cursos_url() );
		$como   = esc_url( infosystem_como_funciona_url() );
		$home   = esc_url( home_url( '/' ) );
		ob_start(
			static function ( $html ) use ( $cursos, $como, $home ) {
				if ( ! is_string( $html ) ) {
					return $html;
				}
				$html = str_replace( 'href="' . $home . '" target="_self" class="tp-button-outline e-415bdea', 'href="' . $cursos . '" target="_self" class="tp-button-outline e-415bdea', $html );
				$html = str_replace( 'href="' . $home . '" target="_self" class="tp-button-outline e-5264a37', 'href="' . $cursos . '" target="_self" class="tp-button-outline e-5264a37', $html );
				$html = str_replace( 'href="' . esc_url( home_url( '/packages/' ) ) . '"', 'href="' . $cursos . '"', $html );
				$html = str_replace( 'View All Packages', 'Ver todos los cursos', $html );
				$html = str_replace( 'href="' . esc_url( home_url( '/courses/' ) ) . '"', 'href="' . $cursos . '"', $html );
				$html = str_replace( 'View All</a>', 'Ver todos los cursos</a>', $html );
				$html = str_replace( 'Cursos completamente actualizados.', 'Aprende a tu ritmo. Cursos online actualizados, sin horarios fijos.', $html );
				$html = preg_replace( '/<button(\s+class="tp-button-primary e-100c151[^"]*"[^>]*)>\s*Cómo funciona\s*<\/button>/iu', '<a$1 href="' . $como . '">Cómo funciona</a>', $html, 1 );
				return $html;
			}
		);
	},
	0
);

add_action(
	'wp_footer',
	static function () {
		if ( is_front_page() ) {
			echo '<style id="infosystem-home-fixes">';
			echo '.elementor-element-263d9da{display:flex!important;flex-wrap:wrap;gap:24px;align-items:stretch!important}';
			echo '.elementor-element-263d9da>.elementor-element{flex:1 1 280px;display:flex!important}';
			echo '.elementor-element-263d9da .elementor-icon-box-wrapper{display:flex!important;align-items:flex-start;gap:16px;background:#fff;border:1px solid #eee;border-radius:12px;padding:28px 24px!important;box-shadow:0 4px 20px rgba(0,0,0,.06);min-height:160px;height:100%;box-sizing:border-box;width:100%}';
			echo '.elementor-element-263d9da .elementor-icon-box-description{min-height:3.2em}';
			echo '.tp-button-outline.e-button-base{color:#8B1A1A!important;border:2px solid #8B1A1A!important;background:#fff!important;padding:14px 32px!important;border-radius:999px!important;font-weight:600!important;text-decoration:none!important;display:inline-block!important}';
			echo '.tp-button-outline.e-button-base:hover{background:#8B1A1A!important;color:#fff!important}';
			echo 'a.tp-button-primary.e-button-base{text-decoration:none!important;display:inline-block}';
			echo '</style>';
		}
		if ( is_page( 'como-funcionan-cursos-subvencionados-sepe-castilla-la-mancha' ) ) {
			echo '<style id="infosystem-como-funciona-css">';
			echo '.infosystem-landing-como-funciona{max-width:920px;margin:0 auto}.infosystem-landing-como-funciona h1{color:#8b1a1a}';
			echo '.infosystem-steps{list-style:none;padding:0}.infosystem-steps li{margin-bottom:1rem;padding:1rem;background:#fafafa;border-left:4px solid #ffb606}';
			echo '.infosystem-landing-cta-block{background:linear-gradient(135deg,#8b1a1a,#5c1010);color:#fff;padding:2rem;border-radius:12px;margin-top:2rem}';
			echo '.infosystem-cta{display:inline-block;padding:.75rem 1.5rem;background:#ffb606;color:#222!important;font-weight:600;text-decoration:none!important;margin:.5rem .5rem 0 0;border-radius:2px}';
			echo '.infosystem-cta--ghost{background:transparent;border:2px solid #ffb606}.infosystem-landing-cta-block .infosystem-cta--ghost{border-color:#fff;color:#fff!important}';
			echo '</style>';
		}
	},
	998
);
