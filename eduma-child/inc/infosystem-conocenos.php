<?php
/**
 * Conócenos — maquetación moderna, sin sidebar, contenido completo.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

const INFOSYSTEM_CONOCENOS_PAGE_ID = 16705;
const INFOSYSTEM_CONOCENOS_VER_OPT = 'infosystem_conocenos_layout_ver';
const INFOSYSTEM_CONOCENOS_LAYOUT_VER = 4;

/**
 * @return bool
 */
function infosystem_is_conocenos_page() {
	return is_page( INFOSYSTEM_CONOCENOS_PAGE_ID ) || is_page( 'conocenos' );
}

/**
 * @return string
 */
function infosystem_conocenos_cursos_url() {
	if ( function_exists( 'eduma_child_wc_courses_category_url' ) ) {
		return eduma_child_wc_courses_category_url();
	}
	if ( function_exists( 'infosystem_mu_cursos_url' ) ) {
		return infosystem_mu_cursos_url();
	}
	return home_url( '/cursos-subvencionados-castilla-la-mancha/' );
}

/**
 * HTML completo de la página Conócenos.
 *
 * @return string
 */
function infosystem_conocenos_page_html() {
	$cursos   = esc_url( infosystem_conocenos_cursos_url() );
	$contacto = esc_url( home_url( '/contacto/' ) );
	$tel      = esc_url( 'tel:+34926331162' );
	$img_hero = esc_url( content_url( '/uploads/2026/05/centrosinfosystem-24.webp' ) );
	$img_team = esc_url( content_url( '/uploads/2026/05/centrosinfosystem-4.webp' ) );
	$map_main = esc_url( 'https://www.google.com/maps/search/?api=1&query=C.+Cruz+de+Piedra+13+13730+Santa+Cruz+de+Mudela+Ciudad+Real' );

	$centers = array(
		array(
			'name'     => 'Santa Cruz de Mudela',
			'lines'    => array( 'C. Cruz de Piedra, 13', '13730 Santa Cruz de Mudela, Ciudad Real' ),
			'badge'    => 'Sede central',
			'meta'     => 'Atención presencial y secretaría',
			'featured' => true,
			'map'      => $map_main,
		),
		array(
			'name'     => 'Viso del Marqués',
			'lines'    => array( 'Centro Infosystem', 'Viso del Marqués · Ciudad Real' ),
			'badge'    => 'Centro colaborador',
			'meta'     => 'Formación presencial y online',
			'featured' => false,
			'map'      => '',
		),
		array(
			'name'     => 'Fuente del Fresno',
			'lines'    => array( 'Centro Infosystem', 'Fuente del Fresno · Ciudad Real' ),
			'badge'    => 'Centro colaborador',
			'meta'     => 'Cursos para desempleados y empresas',
			'featured' => false,
			'map'      => '',
		),
		array(
			'name'     => 'Membrilla',
			'lines'    => array( 'Centro Infosystem', 'Membrilla · Ciudad Real' ),
			'badge'    => 'Centro colaborador',
			'meta'     => 'Formación bonificada FUNDAE',
			'featured' => false,
			'map'      => '',
		),
	);

	ob_start();
	?>
	<div class="cis-about-page">
		<section class="cis-about-hero">
			<div class="cis-about-container">
				<div class="cis-about-hero-grid">
					<div class="cis-about-hero-text">
						<span class="cis-about-tag">Desde 2007 · Centro de Educación Polivalente</span>
						<h2 class="cis-about-hero-title">Formamos a Castilla-La Mancha para el empleo del <span class="cis-about-accent">futuro</span></h2>
						<p class="cis-about-hero-lead">En <strong>Infosystem</strong> impartimos formación <strong>100&nbsp;% gratuita</strong> subvencionada por la <strong>Junta de Castilla-La Mancha</strong>, el <strong>Ministerio de Educación, Formación Profesional y Deportes</strong> y el <strong>SEPE</strong>. Más de 18 años acompañando a trabajadores, desempleados y empresas.</p>
						<div class="cis-about-hero-ctas">
							<a class="cis-btn cis-btn-primary" href="<?php echo $cursos; ?>">Ver cursos disponibles</a>
							<a class="cis-btn cis-btn-ghost" href="<?php echo $contacto; ?>">Contactar con un centro</a>
						</div>
					</div>
					<div class="cis-about-hero-media">
						<img src="<?php echo $img_hero; ?>" alt="Centro de Educación Polivalente Infosystem" width="1600" height="953" loading="eager" decoding="async" />
						<div class="cis-about-hero-badge"><span class="cis-about-hero-badge-num">+18</span><span class="cis-about-hero-badge-lbl">años formando</span></div>
					</div>
				</div>
			</div>
		</section>

		<section class="cis-about-stats" aria-label="Cifras Infosystem">
			<div class="cis-about-container">
				<div class="cis-about-stats-grid">
					<div class="cis-about-stat"><div class="cis-about-stat-num">+18</div><div class="cis-about-stat-lbl">Años de experiencia</div></div>
					<div class="cis-about-stat"><div class="cis-about-stat-num">4</div><div class="cis-about-stat-lbl">Centros en Ciudad Real</div></div>
					<div class="cis-about-stat"><div class="cis-about-stat-num">+3.000</div><div class="cis-about-stat-lbl">Alumnos formados</div></div>
					<div class="cis-about-stat"><div class="cis-about-stat-num">100%</div><div class="cis-about-stat-lbl">Gratuito y subvencionado</div></div>
				</div>
			</div>
		</section>

		<section class="cis-about-story">
			<div class="cis-about-container">
				<header class="cis-about-section-head">
					<span class="cis-about-eyebrow">Quiénes somos</span>
					<h2 class="cis-about-h2">Un proyecto educativo arraigado en la comarca</h2>
				</header>
				<div class="cis-about-story-grid">
					<div class="cis-about-story-text">
						<p>Nacimos en <strong>2007</strong> para acercar la <strong>formación profesional de calidad</strong> a Castilla-La Mancha, sin que la distancia ni el coste sean barreras.</p>
						<p>Desde <strong>cuatro centros</strong> en Santa Cruz de Mudela, Viso del Marqués, Fuente del Fresno y Membrilla impartimos cursos subvencionados por la <strong>Junta de Castilla-La Mancha</strong>, el <strong>Ministerio de Educación, Formación Profesional y Deportes</strong> y el <strong>SEPE</strong>, y formación bonificada <strong>FUNDAE</strong>.</p>
						<p>Nuestro equipo une <strong>experiencia profesional real</strong> y metodologías actuales orientadas al empleo.</p>
						<ul class="cis-about-bullets">
							<li>Cursos certificados y reconocidos oficialmente</li>
							<li>Atención personalizada de matrícula a certificación</li>
							<li>Modalidad presencial, online y mixta</li>
							<li>Orientación profesional y bolsa de empleo</li>
						</ul>
					</div>
					<div class="cis-about-story-media">
						<img src="<?php echo $img_team; ?>" alt="Equipo docente Infosystem" width="1200" height="800" loading="lazy" decoding="async" />
						<div class="cis-about-story-card">
							<div class="cis-about-story-card-icon" aria-hidden="true">✓</div>
							<div>
								<div class="cis-about-story-card-title">Formación oficial</div>
								<div class="cis-about-story-card-sub">JCCM · MEFP · SEPE</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="cis-about-mvv">
			<div class="cis-about-container">
				<header class="cis-about-section-head cis-about-section-head-center">
					<span class="cis-about-eyebrow">Nuestro ADN</span>
					<h2 class="cis-about-h2">Misión, visión y valores</h2>
				</header>
				<div class="cis-about-mvv-grid">
					<article class="cis-about-mvv-card"><div class="cis-about-mvv-icon" aria-hidden="true">🎯</div><h3>Misión</h3><p>Democratizar la formación profesional en CLM con cursos subvencionados que mejoren la empleabilidad.</p></article>
					<article class="cis-about-mvv-card"><div class="cis-about-mvv-icon" aria-hidden="true">🔭</div><h3>Visión</h3><p>Ser referente en formación para el empleo en el sur de Ciudad Real, con impacto real en la inserción laboral.</p></article>
					<article class="cis-about-mvv-card"><div class="cis-about-mvv-icon" aria-hidden="true">💛</div><h3>Valores</h3><p>Cercanía, compromiso territorial, excelencia docente, igualdad e innovación pedagógica.</p></article>
				</div>
			</div>
		</section>

		<section class="cis-about-centers" id="nuestros-centros">
			<div class="cis-about-container">
				<header class="cis-about-section-head cis-about-section-head-center">
					<span class="cis-about-eyebrow">Dónde estamos</span>
					<h2 class="cis-about-h2">Nuestros 4 centros en Ciudad Real</h2>
					<p class="cis-about-section-sub">Formación cerca de ti. Consulta la sede que te quede más accesible.</p>
				</header>
				<div class="cis-about-centers-grid">
					<?php foreach ( $centers as $center ) : ?>
						<article class="cis-center-card<?php echo $center['featured'] ? ' cis-center-card--featured' : ''; ?>">
							<div class="cis-center-card__head">
								<span class="cis-center-card__pin" aria-hidden="true">📍</span>
								<div class="cis-center-card__titles">
									<h3><?php echo esc_html( $center['name'] ); ?></h3>
									<span class="cis-center-card__badge"><?php echo esc_html( $center['badge'] ); ?></span>
								</div>
							</div>
							<div class="cis-center-card__address">
								<?php foreach ( $center['lines'] as $line ) : ?>
									<p><?php echo esc_html( $line ); ?></p>
								<?php endforeach; ?>
							</div>
							<footer class="cis-center-card__footer">
								<span class="cis-center-card__meta"><?php echo esc_html( $center['meta'] ); ?></span>
								<?php if ( ! empty( $center['map'] ) ) : ?>
									<a class="cis-center-card__map" href="<?php echo esc_url( $center['map'] ); ?>" target="_blank" rel="noopener noreferrer">Cómo llegar</a>
								<?php endif; ?>
							</footer>
						</article>
					<?php endforeach; ?>
				</div>
				<div class="cis-about-centers-cta">
					<a class="cis-btn cis-btn-primary" href="<?php echo $tel; ?>">Llamar al 926 33 11 62</a>
					<a class="cis-btn cis-btn-ghost" href="<?php echo $contacto; ?>">Formulario de contacto</a>
				</div>
			</div>
		</section>

		<section class="cis-about-services">
			<div class="cis-about-container">
				<header class="cis-about-section-head cis-about-section-head-center">
					<span class="cis-about-eyebrow">Qué ofrecemos</span>
					<h2 class="cis-about-h2">Formación gratuita a tu medida</h2>
					<p class="cis-about-section-sub">Cuatro líneas formativas, 100&nbsp;% subvencionadas y certificadas.</p>
				</header>
				<div class="cis-about-services-grid">
					<article class="cis-about-service"><div class="cis-about-service-icon" aria-hidden="true">👤</div><h3>Cursos para desempleados</h3><p>Programas SEPE/JCCM compatibles con la prestación por desempleo.</p></article>
					<article class="cis-about-service"><div class="cis-about-service-icon" aria-hidden="true">💼</div><h3>Cursos para trabajadores</h3><p>Mejora competencias sin renunciar a tu jornada. Horarios flexibles y online.</p></article>
					<article class="cis-about-service"><div class="cis-about-service-icon" aria-hidden="true">🏢</div><h3>Formación bonificada FUNDAE</h3><p>Para empresas que forman equipos con el crédito formativo anual.</p></article>
					<article class="cis-about-service"><div class="cis-about-service-icon" aria-hidden="true">📜</div><h3>Certificados de profesionalidad</h3><p>Titulaciones oficiales válidas en toda España.</p></article>
				</div>
			</div>
		</section>

		<section class="cis-about-why">
			<div class="cis-about-container">
				<header class="cis-about-section-head cis-about-section-head-center">
					<span class="cis-about-eyebrow">Por qué elegirnos</span>
					<h2 class="cis-about-h2">7 razones para formarte con Infosystem</h2>
				</header>
				<div class="cis-about-why-grid">
					<?php
					$reasons = array(
						'100&nbsp;% gratuito: subvencionado por la Junta de Castilla-La Mancha, el Ministerio de Educación, Formación Profesional y Deportes y el SEPE.',
						'Certificación oficial reconocida a nivel estatal.',
						'Docentes con experiencia profesional en activo.',
						'Cuatro sedes en la comarca, sin desplazamientos largos.',
						'Campus virtual 24/7 para aprender a tu ritmo.',
						'Tutorización personalizada durante todo el curso.',
						'Orientación al empleo y aterrizaje de competencias.',
					);
					foreach ( $reasons as $reason ) :
						?>
						<div class="cis-about-why-item">
							<span class="cis-about-why-check" aria-hidden="true">✓</span>
							<div><?php echo wp_kses_post( $reason ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="cis-about-trust">
			<div class="cis-about-container">
				<header class="cis-about-section-head cis-about-section-head-center">
					<span class="cis-about-eyebrow">Acreditaciones</span>
					<h2 class="cis-about-h2">Formación oficial respaldada</h2>
				</header>
				<p class="cis-about-trust-note">La formación de esta academia está subvencionada por la <strong>Junta de Castilla-La Mancha</strong>, el <strong>Ministerio de Educación, Formación Profesional y Deportes</strong> y el <strong>SEPE</strong>.</p>
				<?php
				if ( function_exists( 'infosystem_subsidizers_logos_html' ) ) {
					echo infosystem_subsidizers_logos_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
				<p class="cis-about-trust-note">También impartimos formación bonificada para empresas (<strong>FUNDAE</strong>) y programas cofinanciados por la <strong>Unión Europea</strong>.</p>
				<div class="cis-about-trust-row cis-about-trust-logos-extra">
					<img class="cis-about-trust-logo cis-about-trust-logo--fundae" src="<?php echo esc_url( content_url( '/uploads/2026/05/logo-fundae.svg' ) ); ?>" alt="FUNDAE" width="185" height="44" loading="lazy" />
					<img class="cis-about-trust-logo cis-about-trust-logo--ue" src="<?php echo esc_url( content_url( '/uploads/2026/05/logo-union-europea.png' ) ); ?>" alt="Unión Europea" width="117" height="117" loading="lazy" />
				</div>
			</div>
		</section>

		<section class="cis-about-cta-final">
			<div class="cis-about-container">
				<div class="cis-about-cta-inner">
					<div>
						<h2 class="cis-about-cta-title">¿Listo para impulsar tu carrera profesional?</h2>
						<p class="cis-about-cta-sub">Consulta el catálogo o llámanos: te asesoramos sin compromiso.</p>
					</div>
					<div class="cis-about-cta-buttons">
						<a class="cis-btn cis-btn-white" href="<?php echo $cursos; ?>">Ver cursos</a>
						<a class="cis-btn cis-btn-outline-white" href="<?php echo $contacto; ?>">Hablar con un asesor</a>
					</div>
				</div>
			</div>
		</section>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Sincroniza contenido en BD (Elementor puede seguir en meta; el filtro the_content manda).
 */
function infosystem_sync_conocenos_layout() {
	if ( (int) get_option( INFOSYSTEM_CONOCENOS_VER_OPT, 0 ) >= INFOSYSTEM_CONOCENOS_LAYOUT_VER ) {
		return;
	}
	$page = get_post( INFOSYSTEM_CONOCENOS_PAGE_ID );
	if ( ! $page instanceof WP_Post ) {
		return;
	}
	wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_content' => infosystem_conocenos_page_html(),
		)
	);
	update_option( INFOSYSTEM_CONOCENOS_VER_OPT, INFOSYSTEM_CONOCENOS_LAYOUT_VER );
}

add_action(
	'admin_init',
	static function () {
		if ( ! current_user_can( 'edit_pages' ) ) {
			return;
		}
		infosystem_sync_conocenos_layout();
	},
	26
);

add_filter(
	'body_class',
	static function ( $classes ) {
		if ( infosystem_is_conocenos_page() ) {
			$classes[] = 'infosystem-page-conocenos';
		}
		return $classes;
	}
);

add_filter(
	'the_content',
	static function ( $content ) {
		if ( ! infosystem_is_conocenos_page() ) {
			return $content;
		}
		return infosystem_conocenos_page_html();
	},
	999
);

add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! infosystem_is_conocenos_page() ) {
			return;
		}
		$css_path = get_stylesheet_directory() . '/assets/css/infosystem-conocenos-page.css';
		if ( ! is_readable( $css_path ) ) {
			return;
		}
		$css = (string) file_get_contents( $css_path );
		if ( wp_style_is( 'infosystem-mu-pack', 'enqueued' ) ) {
			wp_add_inline_style( 'infosystem-mu-pack', $css );
			return;
		}
		wp_register_style( 'infosystem-conocenos-page', false, array(), (string) INFOSYSTEM_CONOCENOS_LAYOUT_VER );
		wp_enqueue_style( 'infosystem-conocenos-page' );
		wp_add_inline_style( 'infosystem-conocenos-page', $css );
	},
	100002
);
