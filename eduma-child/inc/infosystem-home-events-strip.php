<?php
/**
 * Franja de eventos en la home (contenedor Elementor d87535a vacío).
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'infosystem_home_events_strip_html' ) ) :
	/**
	 * @param int $limit Número de tarjetas.
	 * @return string
	 */
	function infosystem_home_events_strip_html( $limit = 3 ) {
		$events = function_exists( 'infosystem_eventos_schedule' )
			? infosystem_eventos_schedule()
			: array();

		if ( empty( $events ) ) {
			return '';
		}

		$events   = array_slice( $events, 0, max( 1, (int) $limit ) );
		$eventos  = function_exists( 'infosystem_eventos_url' )
			? infosystem_eventos_url()
			: home_url( '/eventos-infosystem-castilla-la-mancha/' );
		$contacto = home_url( '/contacto/' );

		$out  = '<div class="infosystem-home-events" role="region" aria-label="Próximos eventos formativos">';
		$out .= '<div class="infosystem-home-events__grid">';

		foreach ( $events as $event ) {
			$title   = isset( $event['title'] ) ? $event['title'] : '';
			$date    = isset( $event['date_label'] ) ? $event['date_label'] : '';
			$loc     = isset( $event['location'] ) ? $event['location'] : '';
			$excerpt = isset( $event['excerpt'] ) ? $event['excerpt'] : '';
			$emoji   = isset( $event['emoji'] ) ? $event['emoji'] : '';
			$tag     = isset( $event['tag'] ) ? $event['tag'] : '';
			$cta     = add_query_arg(
				'asunto',
				rawurlencode( 'Evento: ' . $title ),
				$contacto
			);

			$out .= '<article class="infosystem-home-events__card">';
			$out .= '<div class="infosystem-home-events__card-top">';
			if ( $emoji ) {
				$out .= '<span class="infosystem-home-events__emoji" aria-hidden="true">' . esc_html( $emoji ) . '</span>';
			}
			if ( $tag ) {
				$out .= '<span class="infosystem-home-events__tag">' . esc_html( $tag ) . '</span>';
			}
			$out .= '</div>';
			if ( $date ) {
				$out .= '<p class="infosystem-home-events__date">' . esc_html( $date ) . '</p>';
			}
			$out .= '<h3 class="infosystem-home-events__title">' . esc_html( $title ) . '</h3>';
			if ( $loc ) {
				$out .= '<p class="infosystem-home-events__loc">' . esc_html( $loc ) . '</p>';
			}
			if ( $excerpt ) {
				$out .= '<p class="infosystem-home-events__excerpt">' . esc_html( $excerpt ) . '</p>';
			}
			$out .= '<a class="infosystem-home-events__cta" href="' . esc_url( $cta ) . '">Reservar plaza</a>';
			$out .= '</article>';
		}

		$out .= '</div>';
		$out .= '<p class="infosystem-home-events__more"><a href="' . esc_url( $eventos ) . '">Ver agenda completa de eventos</a></p>';
		$out .= '</div>';

		return $out;
	}
endif;

if ( ! function_exists( 'infosystem_inject_home_events_strip' ) ) :
	/**
	 * Inserta tarjetas en el contenedor Elementor vacío de eventos.
	 *
	 * @param string $html HTML de la página.
	 * @return string
	 */
	function infosystem_inject_home_events_strip( $html ) {
		if ( ! is_string( $html ) || $html === '' || strpos( $html, 'infosystem-home-events' ) !== false ) {
			return $html;
		}

		$strip = infosystem_home_events_strip_html( 3 );
		if ( $strip === '' ) {
			return $html;
		}

		$replaced = preg_replace(
			'/(<div class="elementor-element elementor-element-d87535a[^"]*"[^>]*>)\s*(<\/div>)/',
			'$1' . $strip . '$2',
			$html,
			1
		);

		return is_string( $replaced ) ? $replaced : $html;
	}
endif;
