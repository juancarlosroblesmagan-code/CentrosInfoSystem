<?php
/**
 * Landing «Cómo funcionan los cursos subvencionados» (SEO SEPE / CLM).
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

const INFOSYSTEM_COMO_FUNCIONA_SLUG    = 'como-funcionan-cursos-subvencionados-sepe-castilla-la-mancha';
const INFOSYSTEM_COMO_FUNCIONA_OPTION  = 'infosystem_como_funciona_page_id';
const INFOSYSTEM_COMO_FUNCIONA_VER     = 'infosystem_como_funciona_content_ver';
const INFOSYSTEM_COMO_FUNCIONA_VERSION = 4;

/**
 * @return string
 */
function infosystem_como_funciona_url() {
	return home_url( '/' . INFOSYSTEM_COMO_FUNCIONA_SLUG . '/' );
}

/**
 * @return string
 */
function infosystem_como_funciona_cursos_url() {
	if ( function_exists( 'infosystem_site_cursos_url' ) ) {
		return infosystem_site_cursos_url();
	}
	if ( function_exists( 'eduma_child_wc_courses_category_url' ) ) {
		return eduma_child_wc_courses_category_url();
	}
	return home_url( '/cursos-subvencionados-castilla-la-mancha/' );
}

if ( ! function_exists( 'infosystem_como_funciona_blog_cards_html' ) ) :
/**
 * Tres entradas recientes en franja horizontal al pie.
 *
 * @return string
 */
function infosystem_como_funciona_blog_cards_html() {
	$posts = get_posts(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 3,
			'ignore_sticky_posts' => true,
		)
	);
	if ( empty( $posts ) ) {
		return '';
	}

	$out = '';
	foreach ( $posts as $post ) {
		$img   = get_the_post_thumbnail_url( $post, 'medium_large' );
		$img   = $img ? $img : content_url( '/uploads/2026/05/centrosinfosystem-banner.webp' );
		$title = get_the_title( $post );
		$excerpt = wp_trim_words( wp_strip_all_tags( get_the_excerpt( $post ) ), 18, '…' );
		$link  = get_permalink( $post );

		$out .= '<a class="cf-blog-card" href="' . esc_url( $link ) . '">';
		$out .= '<img class="cf-blog-card__img" src="' . esc_url( $img ) . '" alt="" loading="lazy" width="400" height="250" />';
		$out .= '<div class="cf-blog-card__body">';
		$out .= '<h3 class="cf-blog-card__title">' . esc_html( $title ) . '</h3>';
		$out .= '<div class="cf-blog-card__excerpt">' . esc_html( $excerpt ) . '</div>';
		$out .= '<span class="cf-blog-card__more">' . esc_html__( 'Leer artículo', 'eduma-child' ) . '</span>';
		$out .= '</div></a>';
	}

	return $out;
}
endif;

if ( ! function_exists( 'infosystem_como_funciona_content_html' ) ) :
/**
 * HTML de la landing (UTF-8, diseño v4).
 *
 * @return string
 */
function infosystem_como_funciona_content_html() {
	$cursos_url   = esc_url( infosystem_como_funciona_cursos_url() );
	$contacto_url = esc_url( home_url( '/contacto/' ) );
	$faq_url      = esc_url( home_url( '/preguntas-frecuentes/' ) );
	$blog_url     = esc_url( home_url( '/blog/' ) );
	$img_hero     = esc_url( content_url( '/uploads/2026/06/centrosinfosystem-nosotros.webp' ) );
	$img_banner   = esc_url( content_url( '/uploads/2026/05/centrosinfosystem-banner.webp' ) );
	$blog_cards   = infosystem_como_funciona_blog_cards_html();

	ob_start();
	?>
	<article class="infosystem-page infosystem-landing-como-funciona infosystem-landing-modern">
		<div class="cf-hero-band" role="banner">
			<div class="cf-hero-band__inner">
				<p class="infosystem-landing-kicker"><?php esc_html_e( 'Formación para el empleo · Castilla-La Mancha', 'eduma-child' ); ?></p>
				<p class="cf-hero-lead"><?php esc_html_e( 'Guía clara para acceder a cursos subvencionados por la Junta de Castilla-La Mancha, el Ministerio de Educación, Formación Profesional y Deportes y el SEPE: requisitos, inscripción gratuita, formación presencial en nuestros centros y certificado con Infosystem.', 'eduma-child' ); ?></p>
				<div class="cf-cta-row">
					<a class="infosystem-cta" href="<?php echo $cursos_url; ?>"><?php esc_html_e( 'Ver catálogo de cursos', 'eduma-child' ); ?></a>
					<a class="infosystem-cta infosystem-cta--ghost" href="<?php echo esc_url( $contacto_url ); ?>"><?php esc_html_e( 'Solicitar información', 'eduma-child' ); ?></a>
				</div>
			</div>
		</div>

		<div class="cf-page-wrap">
			<section class="cf-intro-panel" aria-labelledby="cf-intro-title">
				<div class="cf-intro-panel__grid">
					<div class="cf-intro-panel__content">
						<p class="cf-intro-kicker"><?php esc_html_e( 'Formación presencial · 4 centros en CLM', 'eduma-child' ); ?></p>
						<h2 id="cf-intro-title" class="cf-intro-title"><?php esc_html_e( 'Tu formación subvencionada, paso a paso', 'eduma-child' ); ?></h2>
						<p class="cf-intro-lead"><?php esc_html_e( 'En Infosystem te acompañamos desde la consulta del catálogo hasta la obtención del certificado. Sin coste de matrícula en acciones subvencionadas y con tutores especializados en el aula.', 'eduma-child' ); ?></p>
						<ul class="cf-stats" aria-label="<?php esc_attr_e( 'Datos Infosystem', 'eduma-child' ); ?>">
							<li class="cf-stat">
								<strong class="cf-stat__num">+500</strong>
								<span class="cf-stat__label"><?php esc_html_e( 'cursos', 'eduma-child' ); ?></span>
							</li>
							<li class="cf-stat">
								<strong class="cf-stat__num">+2.000</strong>
								<span class="cf-stat__label"><?php esc_html_e( 'alumnos', 'eduma-child' ); ?></span>
							</li>
							<li class="cf-stat cf-stat--highlight">
								<strong class="cf-stat__num">4</strong>
								<span class="cf-stat__label"><?php esc_html_e( 'centros presenciales', 'eduma-child' ); ?></span>
							</li>
						</ul>
						<p class="cf-intro-centers"><?php esc_html_e( 'Santa Cruz de Mudela · Viso del Marqués · Fuente del Fresno · Membrilla', 'eduma-child' ); ?></p>
						<div class="cf-intro-actions">
							<a class="infosystem-cta cf-intro-actions__primary" href="<?php echo $cursos_url; ?>"><?php esc_html_e( 'Ver catálogo', 'eduma-child' ); ?></a>
							<a class="cf-intro-actions__link" href="<?php echo esc_url( $contacto_url ); ?>"><?php esc_html_e( 'Solicitar información', 'eduma-child' ); ?></a>
						</div>
					</div>
					<figure class="cf-intro-media">
						<div class="cf-intro-media__frame">
							<img src="<?php echo esc_url( $img_hero ); ?>" alt="<?php esc_attr_e( 'Alumnos en formación presencial en un centro Infosystem de Castilla-La Mancha', 'eduma-child' ); ?>" width="720" height="480" loading="eager" decoding="async" />
							<figcaption class="cf-intro-media__caption"><?php esc_html_e( 'Aulas equipadas en nuestros centros de Castilla-La Mancha', 'eduma-child' ); ?></figcaption>
						</div>
					</figure>
				</div>
			</section>

			<section class="cf-section" aria-labelledby="cf-pasos">
				<h2 id="cf-pasos"><?php esc_html_e( 'El proceso en 5 pasos', 'eduma-child' ); ?></h2>
				<p class="cf-section-lead"><?php esc_html_e( 'Desde la consulta del catálogo hasta tu certificado: un recorrido claro y sin coste de matrícula en cursos subvencionados.', 'eduma-child' ); ?></p>
				<ol class="infosystem-steps cf-steps-grid">
					<li>
						<span class="cf-step-num" aria-hidden="true">1</span>
						<h3><?php esc_html_e( 'Comprueba tu perfil', 'eduma-child' ); ?></h3>
						<p><?php esc_html_e( 'Trabajadores en activo, desempleados o empresas que bonifican la formación. Documentación habitual: DNI/NIE y vida laboral.', 'eduma-child' ); ?></p>
					</li>
					<li>
						<span class="cf-step-num" aria-hidden="true">2</span>
						<h3><?php esc_html_e( 'Elige tu curso', 'eduma-child' ); ?></h3>
						<p><?php esc_html_e( 'Digitalización, ofimática en la nube, idiomas, PRL, hostelería y competencias transversales en Castilla-La Mancha.', 'eduma-child' ); ?></p>
					</li>
					<li>
						<span class="cf-step-num" aria-hidden="true">3</span>
						<h3><?php esc_html_e( 'Inscríbete gratis', 'eduma-child' ); ?></h3>
						<p><?php esc_html_e( 'Sin coste de matrícula en acciones subvencionadas. Te ayudamos con el formulario y el alta en la plataforma.', 'eduma-child' ); ?></p>
					</li>
					<li>
						<span class="cf-step-num" aria-hidden="true">4</span>
						<h3><?php esc_html_e( 'Formación en nuestros centros', 'eduma-child' ); ?></h3>
						<p><?php esc_html_e( 'Cursos presenciales en Santa Cruz de Mudela, Viso del Marqués, Fuente del Fresno y Membrilla, con tutores especializados y contenidos actualizados.', 'eduma-child' ); ?></p>
					</li>
					<li>
						<span class="cf-step-num" aria-hidden="true">5</span>
						<h3><?php esc_html_e( 'Obtén tu certificado', 'eduma-child' ); ?></h3>
						<p><?php esc_html_e( 'Al superar la evaluación recibes certificado acreditativo para tu empleo actual o tu búsqueda de trabajo.', 'eduma-child' ); ?></p>
					</li>
				</ol>
			</section>

			<section class="cf-split" aria-labelledby="cf-quien">
				<div class="cf-split-copy">
					<h2 id="cf-quien"><?php esc_html_e( '¿Quién financia estos cursos?', 'eduma-child' ); ?></h2>
					<p><?php echo wp_kses_post( infosystem_subsidizers_financing_paragraph_html() ); ?></p>
					<p><?php esc_html_e( 'Infosystem es centro colaborador que imparte acciones formativas adaptadas al mercado laboral de la región. La formación bonificada para empresas se gestiona además a través de FUNDAE.', 'eduma-child' ); ?></p>
					<?php
					if ( function_exists( 'infosystem_subsidizers_logos_html' ) ) {
						echo infosystem_subsidizers_logos_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					?>
				</div>
				<figure class="cf-split-media">
					<img src="<?php echo esc_url( $img_banner ); ?>" alt="<?php esc_attr_e( 'Formación presencial subvencionada en centros Infosystem', 'eduma-child' ); ?>" width="640" height="420" loading="lazy" decoding="async" />
				</figure>
			</section>

			<section class="cf-section" aria-labelledby="cf-ventajas">
				<h2 id="cf-ventajas"><?php esc_html_e( 'Ventajas de formarte con Infosystem', 'eduma-child' ); ?></h2>
				<ul class="cf-benefits">
					<li><?php esc_html_e( 'Más de 500 cursos y nuevas incorporaciones periódicas', 'eduma-child' ); ?></li>
					<li><?php esc_html_e( 'Cursos presenciales en 4 centros de Castilla-La Mancha con tutorización', 'eduma-child' ); ?></li>
					<li><?php esc_html_e( 'Especialización en empleo, digitalización y competencias transversales', 'eduma-child' ); ?></li>
					<li><?php esc_html_e( 'Atención en español para toda Castilla-La Mancha', 'eduma-child' ); ?></li>
				</ul>
			</section>

			<section class="infosystem-landing-cta-block" aria-labelledby="cf-cta">
				<h2 id="cf-cta"><?php esc_html_e( '¿Listo para empezar?', 'eduma-child' ); ?></h2>
				<p><?php esc_html_e( 'Consulta el catálogo actualizado o escríbenos si tienes dudas sobre plazas, convocatorias o documentación.', 'eduma-child' ); ?></p>
				<div class="cf-cta-row">
					<a class="infosystem-cta" href="<?php echo $cursos_url; ?>"><?php esc_html_e( 'Ver todos los cursos gratuitos', 'eduma-child' ); ?></a>
					<a class="infosystem-cta infosystem-cta--ghost" href="<?php echo esc_url( $faq_url ); ?>"><?php esc_html_e( 'Preguntas frecuentes', 'eduma-child' ); ?></a>
				</div>
			</section>
		</div>

		<?php if ( $blog_cards ) : ?>
		<section class="cf-blog-strip" aria-labelledby="cf-blog-title">
			<div class="cf-blog-strip__inner">
				<div class="cf-blog-strip__head">
					<h2 id="cf-blog-title"><?php esc_html_e( 'Artículos relacionados en el blog', 'eduma-child' ); ?></h2>
					<a class="cf-blog-strip__all" href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e( 'Ver todo el blog', 'eduma-child' ); ?></a>
				</div>
				<!-- wp:html -->
				<div class="cf-blog-cards"><?php echo $blog_cards; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<!-- /wp:html -->
			</div>
		</section>
		<?php endif; ?>
	</article>
	<?php
	return (string) ob_get_clean();
}
endif;

if ( ! function_exists( 'infosystem_sync_como_funciona_page_content' ) ) :
/**
 * Sincroniza título y contenido en la base de datos (UTF-8 correcto).
 */
function infosystem_sync_como_funciona_page_content() {
	if ( (int) get_option( INFOSYSTEM_COMO_FUNCIONA_VER, 0 ) >= INFOSYSTEM_COMO_FUNCIONA_VERSION ) {
		return;
	}

	$page = get_page_by_path( INFOSYSTEM_COMO_FUNCIONA_SLUG, OBJECT, 'page' );
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$title = 'Cómo funcionan los cursos subvencionados por el SEPE en Castilla-La Mancha';

	wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_title'   => $title,
			'post_content' => infosystem_como_funciona_content_html(),
		)
	);

	update_option( INFOSYSTEM_COMO_FUNCIONA_OPTION, $page->ID );

	if ( class_exists( '\RankMath\Helper' ) ) {
		update_post_meta( $page->ID, 'rank_math_title', 'Cómo funcionan los cursos subvencionados SEPE en Castilla-La Mancha | Infosystem' );
		update_post_meta( $page->ID, 'rank_math_description', 'Guía paso a paso: requisitos, inscripción gratuita, formación presencial en nuestros centros y certificado de cursos subvencionados por el SEPE en Castilla-La Mancha con Infosystem.' );
	}

	update_option( INFOSYSTEM_COMO_FUNCIONA_VER, INFOSYSTEM_COMO_FUNCIONA_VERSION );
}
endif;

if ( ! function_exists( 'infosystem_como_funciona_page_css' ) ) :
/**
 * @return string
 */
function infosystem_como_funciona_page_css() {
	$path = dirname( __DIR__ ) . '/tools/css-patch-como-funciona-v4.css';
	if ( is_readable( $path ) ) {
		return (string) file_get_contents( $path );
	}
	return '';
}
endif;

add_action(
	'admin_init',
	static function () {
		if ( ! current_user_can( 'edit_pages' ) ) {
			return;
		}
		infosystem_ensure_como_funciona_page();
	},
	20
);
if ( function_exists( 'infosystem_sync_como_funciona_page_content' ) ) {
	add_action(
		'admin_init',
		static function () {
			if ( ! current_user_can( 'edit_pages' ) ) {
				return;
			}
			infosystem_sync_como_funciona_page_content();
		},
		25
	);
}

/**
 * Crea la página si no existe.
 */
function infosystem_ensure_como_funciona_page() {
	if ( get_option( INFOSYSTEM_COMO_FUNCIONA_OPTION ) ) {
		$page_id = (int) get_option( INFOSYSTEM_COMO_FUNCIONA_OPTION );
		if ( $page_id && 'publish' === get_post_status( $page_id ) ) {
			return;
		}
	}

	$existing = get_page_by_path( INFOSYSTEM_COMO_FUNCIONA_SLUG, OBJECT, 'page' );
	if ( $existing instanceof WP_Post ) {
		update_option( INFOSYSTEM_COMO_FUNCIONA_OPTION, $existing->ID );
		return;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => 'Cómo funcionan los cursos subvencionados por el SEPE en Castilla-La Mancha',
			'post_name'    => INFOSYSTEM_COMO_FUNCIONA_SLUG,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => infosystem_como_funciona_content_html(),
		),
		true
	);

	if ( ! is_wp_error( $page_id ) && $page_id ) {
		update_option( INFOSYSTEM_COMO_FUNCIONA_OPTION, $page_id );
	}
}

add_filter(
	'the_content',
	static function ( $content ) {
		if ( ! is_page( INFOSYSTEM_COMO_FUNCIONA_SLUG ) ) {
			return $content;
		}
		$modern = strpos( $content, 'infosystem-landing-modern' ) !== false;
		if ( ! $modern || strlen( trim( wp_strip_all_tags( $content ) ) ) < 200 ) {
			return infosystem_como_funciona_content_html();
		}
		return $content;
	},
	999
);

add_filter(
	'body_class',
	static function ( $classes ) {
		if ( is_page( INFOSYSTEM_COMO_FUNCIONA_SLUG ) ) {
			$classes[] = 'infosystem-page-como-funciona';
		}
		return $classes;
	}
);

add_filter(
	'document_title_parts',
	static function ( $parts ) {
		if ( is_page( INFOSYSTEM_COMO_FUNCIONA_SLUG ) ) {
			$parts['title'] = 'Cómo funcionan los cursos subvencionados SEPE en Castilla-La Mancha';
		}
		return $parts;
	}
);

add_action(
	'wp_head',
	static function () {
		if ( ! is_page( INFOSYSTEM_COMO_FUNCIONA_SLUG ) || ! function_exists( 'infosystem_como_funciona_page_css' ) ) {
			return;
		}
		$css = infosystem_como_funciona_page_css();
		if ( $css === '' ) {
			return;
		}
		echo '<style id="infosystem-como-funciona-v4">' . $css . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	},
	99
);

add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! is_page( INFOSYSTEM_COMO_FUNCIONA_SLUG ) ) {
			return;
		}
		$css = infosystem_como_funciona_page_css();
		if ( $css === '' ) {
			return;
		}
		$handle = 'infosystem-como-funciona-inline';
		wp_register_style( $handle, false, array(), (string) INFOSYSTEM_COMO_FUNCIONA_VERSION );
		wp_enqueue_style( $handle );
		wp_add_inline_style( $handle, $css );
	},
	100000
);
