<?php
/**
 * Protección anti-scrapers para el email de contacto (HTML público).
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'infosystem_should_protect_emails' ) ) {
	/**
	 * ¿Aplicar ofuscación en esta petición?
	 */
	function infosystem_should_protect_emails() {
		if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
			return false;
		}
		if ( is_feed() || is_trackback() ) {
			return false;
		}
		if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
			return false;
		}
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			return false;
		}
		return true;
	}
}

if ( ! function_exists( 'infosystem_protected_email_addresses' ) ) {
	/**
	 * Emails que se ofuscan en el front.
	 *
	 * @return string[]
	 */
	function infosystem_protected_email_addresses() {
		$primary = defined( 'INFOSYSTEM_CONTACT_EMAIL' ) ? INFOSYSTEM_CONTACT_EMAIL : 'info@centrosinfosystem.com';
		$emails  = array( $primary, 'info@infosystem.net' );
		return array_unique( array_filter( $emails ) );
	}
}

if ( ! function_exists( 'infosystem_build_protected_email_link' ) ) {
	/**
	 * Enlace mailto ofuscado (href real solo con JavaScript).
	 *
	 * @param string      $email Email completo.
	 * @param string|null $label Texto visible.
	 * @return string
	 */
	function infosystem_build_protected_email_link( $email, $label = null ) {
		$label = null !== $label ? $label : $email;
		$parts = explode( '@', $email, 2 );
		if ( count( $parts ) !== 2 ) {
			return esc_html( $label );
		}

		list( $user, $domain ) = $parts;
		$display               = function_exists( 'antispambot' ) ? antispambot( $label ) : esc_html( $label );

		return sprintf(
			'<a href="#" class="infosystem-protected-email" data-infosystem-user="%1$s" data-infosystem-domain="%2$s" rel="nofollow noopener" aria-label="%3$s">%4$s</a>',
			esc_attr( base64_encode( $user ) ),
			esc_attr( base64_encode( $domain ) ),
			esc_attr( sprintf( 'Enviar correo a %s', $email ) ),
			$display
		);
	}
}

if ( ! function_exists( 'infosystem_build_protected_email_text' ) ) {
	/**
	 * Texto de email ofuscado (el carácter @ no va en HTML plano).
	 *
	 * @param string $email Email completo.
	 * @return string
	 */
	function infosystem_build_protected_email_text( $email ) {
		$parts = explode( '@', $email, 2 );
		if ( count( $parts ) !== 2 ) {
			return esc_html( $email );
		}

		list( $user, $domain ) = $parts;

		return sprintf(
			'<span class="infosystem-protected-email-text" data-infosystem-user="%1$s" data-infosystem-domain="%2$s" aria-label="%3$s"><span class="infosystem-email-user">%4$s</span><span class="infosystem-email-at" aria-hidden="true"></span><span class="infosystem-email-domain">%5$s</span></span>',
			esc_attr( base64_encode( $user ) ),
			esc_attr( base64_encode( $domain ) ),
			esc_attr( $email ),
			esc_html( $user ),
			esc_html( $domain )
		);
	}
}

if ( ! function_exists( 'infosystem_protect_emails_in_html' ) ) {
	/**
	 * Ofusca emails en HTML (JSON-LD se excluye temporalmente del buffer).
	 *
	 * @param string $html HTML de la página.
	 * @return string
	 */
	function infosystem_protect_emails_in_html( $html ) {
		if ( ! is_string( $html ) || strpos( $html, '@' ) === false ) {
			return $html;
		}

		// Reparar email del footer si quedó doblemente ofuscado en el widget.
		$html = preg_replace(
			'/(<strong>Email:<\/strong>\s*)<a\b[^>]*\binfosystem-protected-email\b[^>]*>[\s\S]*?<\/a>/i',
			'$1<a href="mailto:info@centrosinfosystem.com">info@centrosinfosystem.com</a>',
			$html
		);

		$placeholders = array();
		$hold_block     = static function ( $matches ) use ( &$placeholders ) {
			$key                  = '<!--INFOSYSTEM_HOLD_' . count( $placeholders ) . '-->';
			$placeholders[ $key ] = $matches[0];
			return $key;
		};

		$html = preg_replace_callback(
			'/<script\b[^>]*type\s*=\s*["\']application\/ld\+json["\'][^>]*>[\s\S]*?<\/script>/i',
			$hold_block,
			$html
		);

		$html = preg_replace_callback(
			'/<a\b[^>]*\bclass="[^"]*\binfosystem-protected-email\b[^"]*"[^>]*>[\s\S]*?<\/a>/i',
			$hold_block,
			$html
		);

		$html = preg_replace_callback(
			'/<span\b[^>]*\bclass="[^"]*\binfosystem-protected-email-text\b[^"]*"[^>]*>[\s\S]*?<\/span>/i',
			$hold_block,
			$html
		);

		foreach ( infosystem_protected_email_addresses() as $email ) {
			$quoted = preg_quote( $email, '/' );

			$html = preg_replace_callback(
				'/<a\b(?![^>]*\binfosystem-protected-email\b)[^>]*\bhref\s*=\s*["\']mailto:' . $quoted . '["\'][^>]*>[\s\S]*?<\/a>/i',
				static function ( $matches ) use ( $email ) {
					if ( preg_match( '/<a\b[^>]*>([\s\S]*?)<\/a>/i', $matches[0], $label_match ) ) {
						$label = wp_strip_all_tags( $label_match[1] );
						if ( false !== strpos( $label, 'infosystem-email-' ) || false !== strpos( $label, '&gt;' ) ) {
							$label = $email;
						}
						return infosystem_build_protected_email_link( $email, $label ? $label : null );
					}
					return infosystem_build_protected_email_link( $email );
				},
				$html
			);

			// Solo texto visible entre etiquetas (no atributos HTML).
			$html = preg_replace_callback(
				'/>([^<]*' . $quoted . '[^<]*)</i',
				static function ( $matches ) use ( $email ) {
					return '>' . str_ireplace( $email, infosystem_build_protected_email_text( $email ), $matches[1] ) . '<';
				},
				$html
			);
		}

		foreach ( $placeholders as $key => $block ) {
			$html = str_replace( $key, $block, $html );
		}

		return $html;
	}
}

if ( ! function_exists( 'infosystem_email_protection_inline_script' ) ) {
	/**
	 * Script mínimo: monta mailto solo en el navegador.
	 */
	function infosystem_email_protection_inline_script() {
		if ( ! infosystem_should_protect_emails() ) {
			return;
		}
		?>
		<script id="infosystem-email-protection">
		(function () {
			function decode(v) {
				try { return atob(v || ''); } catch (e) { return ''; }
			}
			document.querySelectorAll('.infosystem-protected-email').forEach(function (el) {
				var u = decode(el.getAttribute('data-infosystem-user'));
				var d = decode(el.getAttribute('data-infosystem-domain'));
				if (!u || !d) return;
				el.href = 'mailto:' + u + '@' + d;
			});
		})();
		</script>
		<?php
	}
}

if ( ! function_exists( 'infosystem_email_protection_inline_styles' ) ) {
	/**
	 * CSS: el @ solo se pinta en pantalla.
	 */
	function infosystem_email_protection_inline_styles() {
		if ( ! infosystem_should_protect_emails() ) {
			return;
		}
		echo '<style id="infosystem-email-protection-css">.infosystem-email-at::before{content:"\\0040";}</style>';
	}
}

if ( ! has_action( 'wp_footer', 'infosystem_email_protection_inline_script' ) ) {
	add_action( 'wp_footer', 'infosystem_email_protection_inline_script', 99 );
}

if ( ! has_action( 'wp_head', 'infosystem_email_protection_inline_styles' ) ) {
	add_action( 'wp_head', 'infosystem_email_protection_inline_styles', 99 );
}
