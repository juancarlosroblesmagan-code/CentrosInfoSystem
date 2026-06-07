<?php
/** WPCode — Landing Eventos Infosystem */
defined( 'ABSPATH' ) || exit;
if ( function_exists( 'infosystem_eventos_url' ) ) { return; }
const INFOSYSTEM_EVENTOS_SLUG   = 'eventos-infosystem-castilla-la-mancha';
const INFOSYSTEM_EVENTOS_OPTION = 'infosystem_eventos_page_id';

/**
 * @return string
 */
function infosystem_eventos_url() {
	return home_url( '/' . INFOSYSTEM_EVENTOS_SLUG . '/' );
}

/**
 * @return array<int, array<string, mixed>>
 */
function infosystem_eventos_schedule() {
	$year = (int) gmdate( 'Y' );

	return array(
		array(
			'id'          => 'puertas-abiertas-online',
			'title'       => 'Puertas abiertas online: «¿Esto es gratis de verdad?»',
			'date'        => $year . '-06-12T17:00:00+02:00',
			'date_label'  => '12 junio · 17:00 h',
			'location'    => 'Videollamada (desde el sofá, válido)',
			'mode'        => 'online',
			'tag'         => 'Gratuito',
			'emoji'       => '🚪',
			'excerpt'     => 'Te enseñamos el campus, los cursos estrella y cómo inscribirte sin mandar el DNI a un grupo de WhatsApp dudoso.',
			'description' => 'Sesión en directo para trabajadores y desempleados de Castilla-La Mancha. Resolvemos dudas de requisitos SEPE, plazos y certificados. Duración aproximada: 45 minutos más el tiempo que tardemos en decir «tranquilo, es subvencionado».',
		),
		array(
			'id'          => 'webinar-inscripcion-sepe',
			'title'       => 'Webinar: Inscripción SEPE sin drama',
			'date'        => $year . '-06-26T18:30:00+02:00',
			'date_label'  => '26 junio · 18:30 h',
			'location'    => 'Online en directo',
			'mode'        => 'online',
			'tag'         => 'Plazas limitadas',
			'emoji'       => '📋',
			'excerpt'     => 'Documentación, plazos y errores típicos (sí, hay lista). Sales sabiendo qué hacer y qué no mandar por correo.',
			'description' => 'Guía práctica para acceder a cursos subvencionados en CLM. Incluye demo de navegación por el catálogo y tiempo de preguntas. Recomendado si alguna vez has dicho «lo miro mañana» tres meses seguidos.',
		),
		array(
			'id'          => 'taller-excel-express',
			'title'       => 'Taller exprés: Excel para humanos',
			'date'        => $year . '-07-10T11:00:00+02:00',
			'date_label'  => '10 julio · 11:00 h',
			'location'    => 'Online · 90 minutos',
			'mode'        => 'online',
			'tag'         => 'Demostración',
			'emoji'       => '📊',
			'excerpt'     => 'Muestra en vivo de lo que aprenderás en nuestros cursos de ofimática. Spoiler: las tablas dinámicas no muerden (mucho).',
			'description' => 'Demostración orientada a empleo: fórmulas útiles, tablas y trucos para el día a día. Ideal si tu relación con Excel es «solo abro el correo».',
		),
		array(
			'id'          => 'empresas-fundae',
			'title'       => 'Desayuno digital para empresas (café incluido en metáfora)',
			'date'        => $year . '-07-24T09:30:00+02:00',
			'date_label'  => '24 julio · 9:30 h',
			'location'    => 'Online · RRHH y autónomos',
			'mode'        => 'online',
			'tag'         => 'Empresas',
			'emoji'       => '☕',
			'excerpt'     => 'Bonificación, crédito de formación y cómo no dejar caducar euros que ya pagaste en cotizaciones.',
			'description' => 'Sesión para pymes y equipos de RRHH de Castilla-La Mancha: cómo planificar formación bonificada, documentación y calendario anual sin sorpresas a final de año.',
		),
		array(
			'id'          => 'orientacion-mudela',
			'title'       => 'Orientación laboral presencial · Santa Cruz de Mudela',
			'date'        => $year . '-09-18T10:00:00+02:00',
			'date_label'  => '18 septiembre · 10:00 h',
			'location'    => 'C. Cruz de Piedra, 13 · Ciudad Real',
			'mode'        => 'presencial',
			'tag'         => 'Con cita previa',
			'emoji'       => '📍',
			'excerpt'     => 'Revisamos tu perfil, cursos que encajan y próximos pasos. Trae CV si lo tienes; si no, te ayudamos a ordenar ideas.',
			'description' => 'Punto de información en nuestro centro de referencia. Atención personalizada para desempleados y trabajadores en activo de la zona. Duración estimada: 30–40 minutos por persona.',
		),
		array(
			'id'          => 'maraton-google-drive',
			'title'       => 'Maratón «Google Drive sin pánico»',
			'date'        => $year . '-10-08T17:00:00+02:00',
			'date_label'  => '8 octubre · 17:00 h',
			'location'    => 'Online',
			'mode'        => 'online',
			'tag'         => 'Novedad',
			'emoji'       => '☁️',
			'excerpt'     => 'Compartir carpetas, permisos y no borrar el archivo de todo el equipo por accidente. Sí, ha pasado.',
			'description' => 'Avance del curso de ofimática en la nube con Google Drive en CLM. Perfecto para teletrabajo y pymes que viven en documentos compartidos.',
		),
	);
}

/**
 * @return string
 */
function infosystem_eventos_content_html() {
	$cursos_url   = function_exists( 'infosystem_cursos_archive_url' )
		? infosystem_cursos_archive_url()
		: home_url( '/cursos-subvencionados-castilla-la-mancha/' );
	$contacto_url = home_url( '/contacto/' );
	$como_url     = function_exists( 'infosystem_como_funciona_url' )
		? infosystem_como_funciona_url()
		: home_url( '/como-funcionan-cursos-subvencionados-sepe-castilla-la-mancha/' );
	$events       = infosystem_eventos_schedule();

	ob_start();
	?>
	<article class="infosystem-page infosystem-eventos" id="infosystem-eventos-top">
		<header class="infosystem-eventos-hero">
			<div class="infosystem-eventos-hero__glow" aria-hidden="true"></div>
			<p class="infosystem-eventos-kicker">Agenda Infosystem · Castilla-La Mancha</p>
			<h1>Eventos donde aprendes, preguntas… y no te vendemos un máster carísimo</h1>
			<p class="infosystem-lead infosystem-eventos-lead">
				Jornadas gratuitas, webinars y encuentros presenciales para sacarle partido a la
				<strong>formación subvencionada</strong>. Sin powerpoints interminables de la ESO.
				Con tutores reales, humor controlado y respuestas que entiende tu madre.
			</p>
			<div class="infosystem-eventos-hero__actions">
				<a class="infosystem-cta" href="#agenda">Ver la agenda</a>
				<a class="infosystem-cta infosystem-cta--ghost" href="<?php echo esc_url( $contacto_url ); ?>">Quiero que me aviséis</a>
			</div>
			<ul class="infosystem-eventos-stats" aria-label="Datos rápidos">
				<li><strong>100&nbsp;%</strong> orientados al empleo</li>
				<li><strong>0</strong> letra pequeña tipo «sorpresa, ahora pagas»</li>
				<li><strong>+500</strong> cursos detrás de cada charla</li>
			</ul>
		</header>

		<nav class="infosystem-eventos-filters" aria-label="Filtrar eventos por modalidad">
			<button type="button" class="is-active" data-filter="all">Todos</button>
			<button type="button" data-filter="online">Online</button>
			<button type="button" data-filter="presencial">Presencial</button>
			<button type="button" data-filter="empresas">Empresas</button>
		</nav>

		<section class="infosystem-eventos-grid-wrap" id="agenda" aria-labelledby="eventos-agenda-title">
			<h2 id="eventos-agenda-title">Próximos eventos</h2>
			<p class="infosystem-eventos-grid-intro">
				Fechas orientativas — confirma plaza en contacto. Si un evento se llena, no hacemos
				«últimas 2 plazas» cada martes durante seis meses. Prometido.
			</p>
			<div class="infosystem-eventos-grid">
				<?php foreach ( $events as $event ) : ?>
					<?php
					$filter_class = $event['mode'];
					if ( false !== strpos( $event['title'], 'empresas' ) || false !== strpos( $event['id'], 'empresa' ) ) {
						$filter_class .= ' empresas';
					}
					?>
					<article
						class="infosystem-event-card"
						data-mode="<?php echo esc_attr( $event['mode'] ); ?>"
						data-tags="<?php echo esc_attr( $filter_class ); ?>"
						id="evento-<?php echo esc_attr( $event['id'] ); ?>"
					>
						<div class="infosystem-event-card__top">
							<span class="infosystem-event-card__emoji" aria-hidden="true"><?php echo esc_html( $event['emoji'] ); ?></span>
							<span class="infosystem-event-card__tag"><?php echo esc_html( $event['tag'] ); ?></span>
						</div>
						<time datetime="<?php echo esc_attr( $event['date'] ); ?>"><?php echo esc_html( $event['date_label'] ); ?></time>
						<h3><?php echo esc_html( $event['title'] ); ?></h3>
						<p class="infosystem-event-card__loc"><?php echo esc_html( $event['location'] ); ?></p>
						<p><?php echo esc_html( $event['excerpt'] ); ?></p>
						<details class="infosystem-event-card__more">
							<summary>Más info (sin relleno)</summary>
							<p><?php echo esc_html( $event['description'] ); ?></p>
						</details>
						<a class="infosystem-event-card__cta" href="<?php echo esc_url( $contacto_url ); ?>?asunto=<?php echo rawurlencode( 'Evento: ' . $event['title'] ); ?>">
							Reservar plaza
						</a>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="infosystem-eventos-types" aria-labelledby="eventos-tipos-title">
			<h2 id="eventos-tipos-title">¿Qué puedes encontrarte aquí?</h2>
			<div class="infosystem-eventos-types__grid">
				<div class="infosystem-eventos-type-card">
					<h3>🎓 Webinars SEPE</h3>
					<p>Inscripción, requisitos y catálogo sin tecnicismos. Para cuando Google te ha dado cincuenta respuestas distintas.</p>
				</div>
				<div class="infosystem-eventos-type-card">
					<h3>🏢 Sesiones para empresas</h3>
					<p>Bonificación y planificación formativa. El Excel de RRHH te lo agradecerá (y tu crédito FUNDAE también).</p>
				</div>
				<div class="infosystem-eventos-type-card">
					<h3>📍 Encuentros en centro</h3>
					<p>En Santa Cruz de Mudela y red de centros en CLM. Humanos, sillas y orientación cara a cara.</p>
				</div>
				<div class="infosystem-eventos-type-card">
					<h3>🛠️ Talleres demostración</h3>
					<p>Muestras de ofimática, digitalización e idiomas. Probar antes de matricularse: como una test drive, pero de conocimiento.</p>
				</div>
			</div>
		</section>

		<section class="infosystem-eventos-fun" aria-labelledby="eventos-fun-title">
			<h2 id="eventos-fun-title">Eventos que NO organizamos (por si acaso)</h2>
			<ul class="infosystem-eventos-fun-list">
				<li>«Cómo hacerse rico en 48 horas vendiendo cursos a tus primos»</li>
				<li>«Networking» que es solo un folleto y un café frío</li>
				<li>Webinar de 4 horas donde el 70&nbsp;% es publicidad de otro webinar</li>
				<li>Sorteo de un PDF llamado «guía definitiva» con 3 páginas en Comic Sans</li>
			</ul>
			<p class="infosystem-eventos-fun-note">
				Lo nuestro va de <strong>formación para el empleo en Castilla-La Mancha</strong>.
				Serio en lo importante; relajados en el trato.
			</p>
		</section>

		<section class="infosystem-eventos-faq" aria-labelledby="eventos-faq-title">
			<h2 id="eventos-faq-title">Preguntas que nos hacen (con cariño)</h2>
			<details>
				<summary>¿Los eventos son gratis?</summary>
				<p>Casi siempre sí: son sesiones informativas u orientativas. Los cursos completos siguen su propia convocatoria subvencionada. Si algún día cobráramos por un café, te avisaríamos en grande.</p>
			</details>
			<details>
				<summary>¿Puedo asistir si aún no sé qué curso quiero?</summary>
				<p>Perfecto. Para eso están. Te ayudamos a encajar perfil, plazos y objetivo profesional.</p>
			</details>
			<details>
				<summary>¿Hacéis eventos solo en Ciudad Real?</summary>
				<p>La base es CLM y online para toda la región. Consulta fechas presenciales o pide cita en tu municipio.</p>
			</details>
		</section>

		<section class="infosystem-eventos-cta infosystem-landing-cta-block" aria-labelledby="eventos-cta-title">
			<h2 id="eventos-cta-title">¿No encuentras tu fecha ideal?</h2>
			<p>
				Escríbenos y te avisamos de la siguiente convocatoria. Mientras tanto, puedes explorar
				el catálogo o leer cómo funciona la inscripción paso a paso.
			</p>
			<p>
				<a class="infosystem-cta" href="<?php echo esc_url( $contacto_url ); ?>">Contactar con Infosystem</a>
				<a class="infosystem-cta infosystem-cta--ghost" href="<?php echo esc_url( $cursos_url ); ?>">Ver cursos subvencionados</a>
				<a class="infosystem-cta infosystem-cta--ghost" href="<?php echo esc_url( $como_url ); ?>">Cómo funciona el SEPE</a>
			</p>
		</section>
	</article>
	<?php
	return (string) ob_get_clean();
}

/**
 * Crea la página si no existe.
 */
function infosystem_ensure_eventos_page() {
	if ( get_option( INFOSYSTEM_EVENTOS_OPTION ) ) {
		$page_id = (int) get_option( INFOSYSTEM_EVENTOS_OPTION );
		if ( $page_id && 'publish' === get_post_status( $page_id ) ) {
			return;
		}
	}

	$existing = get_page_by_path( INFOSYSTEM_EVENTOS_SLUG, OBJECT, 'page' );
	if ( $existing instanceof WP_Post ) {
		update_option( INFOSYSTEM_EVENTOS_OPTION, $existing->ID );
		return;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => 'Eventos Infosystem: jornadas y webinars de formación en Castilla-La Mancha',
			'post_name'    => INFOSYSTEM_EVENTOS_SLUG,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => infosystem_eventos_content_html(),
		),
		true
	);

	if ( ! is_wp_error( $page_id ) && $page_id ) {
		update_option( INFOSYSTEM_EVENTOS_OPTION, $page_id );
		if ( class_exists( '\RankMath\Helper' ) ) {
			update_post_meta(
				$page_id,
				'rank_math_title',
				'Eventos y jornadas de formación subvencionada en Castilla-La Mancha | Infosystem'
			);
			update_post_meta(
				$page_id,
				'rank_math_description',
				'Webinars, puertas abiertas y orientación laboral gratuita en CLM. Eventos Infosystem sobre cursos SEPE, empresas y formación online. Reserva tu plaza.'
			);
		}
	}
}

/**
 * JSON-LD Event para SEO.
 */
function infosystem_eventos_print_schema() {
	if ( ! is_page( INFOSYSTEM_EVENTOS_SLUG ) ) {
		return;
	}

	$events = array();
	foreach ( infosystem_eventos_schedule() as $event ) {
		$is_presencial = ( 'presencial' === $event['mode'] );
		$location      = array(
			'@type' => $is_presencial ? 'Place' : 'VirtualLocation',
			'name'  => $event['location'],
			'url'   => infosystem_eventos_url(),
		);
		if ( $is_presencial ) {
			$location['address'] = array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => 'C. Cruz de Piedra, 13',
				'addressLocality' => 'Santa Cruz de Mudela',
				'addressRegion'   => 'Ciudad Real',
				'postalCode'      => '13730',
				'addressCountry'  => 'ES',
			);
		}

		$events[] = array(
			'@type'               => 'Event',
			'name'                => $event['title'],
			'startDate'           => $event['date'],
			'eventAttendanceMode' => $is_presencial
				? 'https://schema.org/OfflineEventAttendanceMode'
				: 'https://schema.org/OnlineEventAttendanceMode',
			'eventStatus'         => 'https://schema.org/EventScheduled',
			'location'            => $location,
			'description'         => $event['description'],
			'organizer'           => array(
				'@type' => 'Organization',
				'name'  => 'Infosystem — Centro de Educación Polivalente',
				'url'   => home_url( '/' ),
			),
			'offers'              => array(
				'@type'   => 'Offer',
				'price'   => '0',
				'priceCurrency' => 'EUR',
				'availability'  => 'https://schema.org/InStock',
				'url'           => home_url( '/contacto/' ),
			),
			'isAccessibleForFree' => true,
		);
	}

	$schema = array(
		'@context' => 'https://schema.org',
		'@graph'   => $events,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}

add_action( 'init', 'infosystem_ensure_eventos_page', 20 );

add_filter(
	'the_content',
	static function ( $content ) {
		if ( ! is_page( INFOSYSTEM_EVENTOS_SLUG ) ) {
			return $content;
		}
		$custom = infosystem_eventos_content_html();
		if ( strlen( trim( wp_strip_all_tags( $content ) ) ) < 80 ) {
			return $custom;
		}
		return $content;
	},
	5
);

add_action( 'wp_head', 'infosystem_eventos_print_schema', 20 );

add_action( 'wp_footer', static function () {
	if ( ! is_page( INFOSYSTEM_EVENTOS_SLUG ) ) {
		return;
	}
	echo '<style id="infosystem-eventos-css">.infosystem-page{max-width:1100px;margin:0 auto 3rem;padding:0 1rem}.infosystem-lead{font-size:1.15rem;line-height:1.7}.infosystem-cta{display:inline-block;margin:.5rem 1rem 0 0;padding:.75rem 1.5rem;background:#ffb606;color:#222!important;text-decoration:none!important;font-weight:600;border-radius:2px}.infosystem-cta--ghost{background:transparent;border:2px solid #ffb606}.infosystem-landing-cta-block{background:linear-gradient(135deg,#8b1a1a,#5c1010);color:#fff;padding:2rem;border-radius:12px}.infosystem-landing-cta-block h2,.infosystem-landing-cta-block p{color:#fff} .infosystem-eventos { max-width: 1100px; padding-bottom: 4rem; } .infosystem-eventos-hero { position: relative; margin: 0 -1rem 2.5rem; padding: 3rem 1.5rem 2.5rem; border-radius: 0 0 24px 24px; overflow: hidden; color: #fff; background: linear-gradient(135deg, #5c1010 0%, #8b1a1a 45%, #a83232 100%); box-shadow: 0 20px 60px rgba(139, 26, 26, 0.25); } .infosystem-eventos-hero__glow { position: absolute; inset: -40% -20% auto auto; width: 70%; height: 140%; background: radial-gradient(circle, rgba(255, 182, 6, 0.35) 0%, transparent 65%); pointer-events: none; animation: infosystem-eventos-pulse 8s ease-in-out infinite; } @keyframes infosystem-eventos-pulse { 0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.7; } 50% { transform: translate(-8%, 5%) scale(1.08); opacity: 1; } } .infosystem-eventos-kicker { text-transform: uppercase; letter-spacing: 0.12em; font-size: 0.8rem; color: rgba(255, 255, 255, 0.85); margin-bottom: 0.75rem; } .infosystem-eventos-hero h1 { color: #fff; font-size: clamp(1.85rem, 4.5vw, 2.75rem); line-height: 1.15; margin-bottom: 1rem; max-width: 18ch; } .infosystem-eventos-lead { color: rgba(255, 255, 255, 0.92); max-width: 52ch; margin-bottom: 1.5rem; } .infosystem-eventos-hero__actions { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 2rem; } .infosystem-eventos-hero .infosystem-cta--ghost { border-color: rgba(255, 255, 255, 0.9); color: #fff !important; } .infosystem-eventos-hero .infosystem-cta--ghost:hover { background: #fff; color: #8b1a1a !important; } .infosystem-eventos-stats { display: flex; flex-wrap: wrap; gap: 1rem 2rem; list-style: none; margin: 0; padding: 1.25rem 0 0; border-top: 1px solid rgba(255, 255, 255, 0.2); } .infosystem-eventos-stats li { font-size: 0.95rem; color: rgba(255, 255, 255, 0.9); } .infosystem-eventos-stats strong { display: block; font-size: 1.35rem; color: #ffb606; } .infosystem-eventos-filters { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 2rem; position: sticky; top: 80px; z-index: 5; padding: 0.5rem 0; background: linear-gradient(to bottom, #fff 70%, transparent); } .infosystem-eventos-filters button { border: 2px solid #e8e8e8; background: #fff; color: #444; padding: 0.5rem 1.1rem; border-radius: 999px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; } .infosystem-eventos-filters button:hover, .infosystem-eventos-filters button.is-active { border-color: #8b1a1a; background: #8b1a1a; color: #fff; } .infosystem-eventos-grid-wrap h2 { color: #8b1a1a; font-size: 1.75rem; margin-bottom: 0.5rem; } .infosystem-eventos-grid-intro { color: #666; margin-bottom: 1.5rem; max-width: 60ch; } .infosystem-eventos-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; } .infosystem-event-card { display: flex; flex-direction: column; background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 1.35rem 1.35rem 1.25rem; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06); transition: transform 0.25s ease, box-shadow 0.25s ease; } .infosystem-event-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(139, 26, 26, 0.12); } .infosystem-event-card.is-hidden { display: none; } .infosystem-event-card__top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem; } .infosystem-event-card__emoji { font-size: 2rem; line-height: 1; } .infosystem-event-card__tag { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.06em; background: #fff8e6; color: #8b1a1a; padding: 0.25rem 0.6rem; border-radius: 4px; font-weight: 700; } .infosystem-event-card time { font-size: 0.85rem; color: #888; font-weight: 600; } .infosystem-event-card h3 { color: #222; font-size: 1.15rem; line-height: 1.35; margin: 0.35rem 0 0.5rem; } .infosystem-event-card__loc { font-size: 0.9rem; color: #8b1a1a; font-weight: 600; margin-bottom: 0.5rem; } .infosystem-event-card p { margin: 0 0 0.75rem; line-height: 1.65; color: #555; flex-grow: 1; } .infosystem-event-card__more { margin: 0 0 1rem; font-size: 0.9rem; } .infosystem-event-card__more summary { cursor: pointer; color: #8b1a1a; font-weight: 600; } .infosystem-event-card__cta { display: inline-block; align-self: flex-start; padding: 0.6rem 1.25rem; background: #8b1a1a; color: #fff !important; text-decoration: none !important; font-weight: 600; border-radius: 999px; transition: background 0.2s ease; } .infosystem-event-card__cta:hover { background: #5c1010; } .infosystem-eventos-types { margin: 3.5rem 0; } .infosystem-eventos-types h2 { color: #8b1a1a; margin-bottom: 1.25rem; } .infosystem-eventos-types__grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1rem; } .infosystem-eventos-type-card { background: linear-gradient(160deg, #fafafa 0%, #f3f3f3 100%); border-radius: 12px; padding: 1.25rem; border-left: 4px solid #ffb606; } .infosystem-eventos-type-card h3 { margin: 0 0 0.5rem; font-size: 1.05rem; color: #333; } .infosystem-eventos-type-card p { margin: 0; font-size: 0.95rem; line-height: 1.6; color: #555; } .infosystem-eventos-fun { background: #1a1a1a; color: #eee; border-radius: 16px; padding: 2rem 1.75rem; margin: 3rem 0; } .infosystem-eventos-fun h2 { color: #ffb606; margin-top: 0; } .infosystem-eventos-fun-list { margin: 0 0 1rem; padding-left: 1.25rem; line-height: 1.8; } .infosystem-eventos-fun-list li { margin-bottom: 0.35rem; } .infosystem-eventos-fun-note { margin: 0; color: #ccc; } .infosystem-eventos-faq { margin: 2.5rem 0; } .infosystem-eventos-faq h2 { color: #8b1a1a; margin-bottom: 1rem; } .infosystem-eventos-faq details { border: 1px solid #eee; border-radius: 8px; padding: 0.85rem 1rem; margin-bottom: 0.75rem; background: #fafafa; } .infosystem-eventos-faq summary { cursor: pointer; font-weight: 600; color: #333; } .infosystem-eventos-faq p { margin: 0.75rem 0 0; line-height: 1.65; color: #555; } .infosystem-eventos-cta.infosystem-landing-cta-block { margin-top: 2rem; } .infosystem-eventos-cta .infosystem-cta { margin-top: 0.5rem; } @media (max-width: 768px) { .infosystem-eventos-hero { margin-left: -0.5rem; margin-right: -0.5rem; padding: 2rem 1rem 1.75rem; } .infosystem-eventos-hero h1 { max-width: none; } .infosystem-eventos-filters { top: 60px; } } </style>';
	echo '<script id="infosystem-eventos-js">/**
 * Filtros de modalidad en la landing de eventos.
 */
(function () {
	'use strict';

	var nav = document.querySelector('.infosystem-eventos-filters');
	if (!nav) {
		return;
	}

	var buttons = nav.querySelectorAll('button[data-filter]');
	var cards = document.querySelectorAll('.infosystem-event-card');

	function applyFilter(mode) {
		buttons.forEach(function (btn) {
			btn.classList.toggle('is-active', btn.getAttribute('data-filter') === mode);
		});

		cards.forEach(function (card) {
			var tags = card.getAttribute('data-tags') || '';
			var show =
				mode === 'all' ||
				card.getAttribute('data-mode') === mode ||
				(mode === 'empresas' && tags.indexOf('empresas') !== -1);
			card.classList.toggle('is-hidden', !show);
		});
	}

	buttons.forEach(function (btn) {
		btn.addEventListener('click', function () {
			applyFilter(btn.getAttribute('data-filter') || 'all');
		});
	});
})();
</script>';
}, 998 );

/* Demo Eduma /events/ → landing propia. */
add_action(
	'template_redirect',
	static function () {
		if ( is_admin() ) {
			return;
		}

		$target = infosystem_eventos_url();

		if ( is_post_type_archive( 'tp_event' ) || is_singular( 'tp_event' ) ) {
			wp_safe_redirect( $target, 301 );
			exit;
		}

		$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) : '';
		if ( is_string( $path ) && preg_match( '#^/events/?$#i', $path ) && ! is_page( INFOSYSTEM_EVENTOS_SLUG ) ) {
			wp_safe_redirect( $target, 301 );
			exit;
		}
	},
	1
);
