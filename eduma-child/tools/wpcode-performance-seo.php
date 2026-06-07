<?php
/**
 * WPCode — Rendimiento + SEO técnico (PHP, ejecutar en todas partes / frontend).
 */
defined( 'ABSPATH' ) || exit;

/* Preconnect / DNS-prefetch */
add_action(
	'wp_head',
	static function () {
		if ( is_admin() ) {
			return;
		}
		echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
		echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
	},
	1
);

/* Desactivar emoji scripts (menos JS en front) */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/* Embeds oEmbed discovery (menos peticiones en head) */
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

/* Rank Math: asegurar sitemap activo vía filtro */
add_filter( 'rank_math/sitemap/enable', '__return_true' );

/* Meta geo Castilla-La Mancha */
add_action(
	'wp_head',
	static function () {
		if ( is_admin() ) {
			return;
		}
		echo '<meta name="geo.region" content="ES-CM" />' . "\n";
		echo '<meta name="geo.placename" content="Castilla-La Mancha" />' . "\n";
	},
	3
);

/* Botones sin enlace: enlazar CTAs vacíos a contacto/cursos */
add_action(
	'wp_footer',
	static function () {
		if ( is_admin() ) {
			return;
		}
		$cursos = home_url( '/cursos-subvencionados-castilla-la-mancha/' );
		$contacto = home_url( '/contacto/' );
		?>
		<script id="infosystem-link-fallback">
		(function () {
			document.querySelectorAll('a.button, a.cis-btn, .infosystem-cta').forEach(function (el) {
				var href = (el.getAttribute('href') || '').trim();
				if (href && href !== '#' && href !== 'javascript:void(0)') {
					return;
				}
				var label = (el.textContent || '').toLowerCase();
				if (/curso|leer|ver|formación|inscrib/.test(label)) {
					el.setAttribute('href', <?php echo wp_json_encode( $cursos ); ?>);
				} else if (/contact|llam|asesor|info|escríb/.test(label)) {
					el.setAttribute('href', <?php echo wp_json_encode( $contacto ); ?>);
				}
			});
		})();
		</script>
		<?php
	},
	99
);

/* Lazy-load imágenes sin atributo (refuerzo) */
add_filter(
	'wp_get_attachment_image_attributes',
	static function ( $attr ) {
		if ( empty( $attr['loading'] ) ) {
			$attr['loading'] = 'lazy';
		}
		if ( empty( $attr['decoding'] ) ) {
			$attr['decoding'] = 'async';
		}
		return $attr;
	},
	20
);
