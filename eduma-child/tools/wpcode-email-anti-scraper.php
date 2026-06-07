<?php
/**
 * WPCode — Protección email anti-bots (pegar en snippet PHP, ejecutar en todas partes).
 */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'infosystem_should_protect_emails' ) ) {
	function infosystem_should_protect_emails() {
		return ! ( is_admin() || wp_doing_ajax() || is_feed() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) );
	}
}

if ( ! function_exists( 'infosystem_protected_email_addresses' ) ) {
	function infosystem_protected_email_addresses() {
		return array( 'info@centrosinfosystem.com' );
	}
}

if ( ! function_exists( 'infosystem_build_protected_email_link' ) ) {
	function infosystem_build_protected_email_link( $email, $label = null ) {
		$label = $label ? $label : $email;
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
	function infosystem_build_protected_email_text( $email ) {
		$parts = explode( '@', $email, 2 );
		if ( count( $parts ) !== 2 ) {
			return esc_html( $email );
		}
		list( $user, $domain ) = $parts;
		return sprintf(
			'<span class="infosystem-protected-email-text" aria-label="%1$s"><span class="infosystem-email-user">%2$s</span><span class="infosystem-email-at" aria-hidden="true"></span><span class="infosystem-email-domain">%3$s</span></span>',
			esc_attr( $email ),
			esc_html( $user ),
			esc_html( $domain )
		);
	}
}

if ( ! function_exists( 'infosystem_protect_emails_in_html' ) ) {
	function infosystem_protect_emails_in_html( $html ) {
		if ( ! is_string( $html ) || false === strpos( $html, '@' ) ) {
			return $html;
		}

		$html = preg_replace(
			'/(<strong>Email:<\/strong>\s*)<a\b[^>]*\binfosystem-protected-email\b[^>]*>[\s\S]*?<\/a>/i',
			'$1<a href="mailto:info@centrosinfosystem.com">info@centrosinfosystem.com</a>',
			$html
		);

		$hold = array();
		$hold_block = static function ( $m ) use ( &$hold ) {
			$key          = '<!--IH' . count( $hold ) . '-->';
			$hold[ $key ] = $m[0];
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
			$q = preg_quote( $email, '/' );
			$html = preg_replace_callback(
				'/<a\b(?![^>]*\binfosystem-protected-email\b)[^>]*\bhref\s*=\s*["\']mailto:' . $q . '["\'][^>]*>[\s\S]*?<\/a>/i',
				static function ( $m ) use ( $email ) {
					if ( preg_match( '/<a\b[^>]*>([\s\S]*?)<\/a>/i', $m[0], $label_match ) ) {
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
			$html = preg_replace_callback(
				'/>([^<]*' . $q . '[^<]*)</i',
				static function ( $m ) use ( $email ) {
					return '>' . str_ireplace( $email, infosystem_build_protected_email_text( $email ), $m[1] ) . '<';
				},
				$html
			);
		}
		foreach ( $hold as $key => $block ) {
			$html = str_replace( $key, $block, $html );
		}
		return $html;
	}
}

if ( ! function_exists( 'infosystem_email_protection_assets' ) ) {
	function infosystem_email_protection_assets() {
		if ( ! infosystem_should_protect_emails() ) {
			return;
		}
		echo '<style id="infosystem-email-protection-css">.infosystem-email-at::before{content:"\\0040";}</style>';
		echo '<script id="infosystem-email-protection">(function(){function d(v){try{return atob(v||"")}catch(e){return ""}}document.querySelectorAll(".infosystem-protected-email").forEach(function(el){var u=d(el.getAttribute("data-infosystem-user")),x=d(el.getAttribute("data-infosystem-domain"));if(u&&x)el.href="mailto:"+u+"@"+x})})();</script>';
	}
}

if ( ! has_action( 'wp_footer', 'infosystem_email_protection_assets' ) ) {
	add_action( 'wp_footer', 'infosystem_email_protection_assets', 99 );
}

add_action(
	'wp_footer',
	static function () {
		if ( is_admin() || ! ( is_tax( 'product_cat' ) || is_post_type_archive( 'product' ) || is_singular( 'product' ) ) ) {
			return;
		}
		echo '<style id="infosystem-wc-course-buttons">';
		echo '.product-grid li.product a.button.product_type_simple,';
		echo '.thim-product-grid li.product a.button,';
		echo '.woocommerce .product-grid a.button.product_type_simple{';
		echo 'color:#8B1A1A!important;background:#fff!important;border:2px solid #8B1A1A!important;';
		echo 'border-radius:999px!important;font-weight:600!important;padding:12px 28px!important;';
		echo 'display:inline-block!important;text-decoration:none!important;}';
		echo '.product-grid li.product a.button.product_type_simple:hover,';
		echo '.thim-product-grid li.product a.button:hover{';
		echo 'color:#fff!important;background:#8B1A1A!important;border-color:#8B1A1A!important;}';
		echo '</style>';
	},
	999
);

add_action(
	'template_redirect',
	static function () {
		if ( ! infosystem_should_protect_emails() ) {
			return;
		}
		ob_start(
			static function ( $html ) {
				if ( ! is_string( $html ) ) {
					return $html;
				}
				$html = str_replace( 'info@infosystem.net', 'info@centrosinfosystem.com', $html );
				return infosystem_protect_emails_in_html( $html );
			}
		);
	},
	0
);
