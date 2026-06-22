<?php
/**
 * Infosystem Child Theme - functions.php
 * Centro de Educación Polivalente
 * www.infosystem.net
 */

// ============================================================
// 1. CARGAR ESTILOS DEL TEMA PADRE Y DEL HIJO
// ============================================================
add_action( 'wp_enqueue_scripts', 'infosystem_child_enqueue_styles', 20 );

function infosystem_child_enqueue_styles() {
    // Estilo del tema padre (Eduma)
    wp_enqueue_style(
        'eduma-parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme( 'eduma' )->get( 'Version' )
    );

    // Estilo del child theme (colores y marca Infosystem)
    wp_enqueue_style(
        'infosystem-child-style',
        get_stylesheet_uri(),
        array( 'eduma-parent-style' ),
        wp_get_theme()->get( 'Version' )
    );

    // Estilos de maquetación de la home (parche para Elementor V4 y contenedores optimizados solo en local)
    if ( is_front_page() && ( strpos( $_SERVER['HTTP_HOST'], 'localhost' ) !== false || strpos( $_SERVER['HTTP_HOST'], '127.0.0.1' ) !== false ) ) {
        wp_enqueue_style(
            'infosystem-home-layout',
            get_stylesheet_directory_uri() . '/assets/css/infosystem-home-layout.css',
            array( 'infosystem-child-style' ),
            wp_get_theme()->get( 'Version' )
        );
    }

    // Google Fonts — Merriweather + Source Sans Pro
    wp_enqueue_style(
        'infosystem-fonts',
        'https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+Pro:wght@300;400;600;700&display=swap',
        array(),
        null
    );

    // JS personalizado
    wp_enqueue_script(
        'infosystem-custom-js',
        get_stylesheet_directory_uri() . '/js/infosystem-custom.js',
        array( 'jquery' ),
        wp_get_theme()->get( 'Version' ),
        true
    );
}


// ============================================================
// 2. DATOS DE LA EMPRESA — CONSTANTES GLOBALES
// ============================================================
define( 'EDUMA_CHILD_VERSION',   '1.3.0' );
define( 'INFOSYSTEM_EMPRESA',    'Infosystem' );
define( 'INFOSYSTEM_SUBTITULO',  'Centro de Educación Polivalente' );
define( 'INFOSYSTEM_TELEFONO',   '+34 926 33 11 62' );
define( 'INFOSYSTEM_EMAIL',      'info@infosystem.net' );
define( 'INFOSYSTEM_DIRECCION',  'C. Cruz de Piedra, 13' );
define( 'INFOSYSTEM_CIUDAD',     '13730 Santa Cruz de Mudela · Ciudad Real' );
define( 'INFOSYSTEM_WEB',        'www.infosystem.net' );
define( 'INFOSYSTEM_DIRECTORA',  'Caridad Laguna Castro' );


// ============================================================
// 3. PERSONALIZACIÓN DEL CUSTOMIZER
// ============================================================
add_action( 'customize_register', 'infosystem_customize_register' );

function infosystem_customize_register( $wp_customize ) {

    // Panel de configuración de Infosystem
    $wp_customize->add_panel( 'infosystem_panel', array(
        'title'       => __( 'Infosystem — Configuración', 'infosystem-child' ),
        'description' => __( 'Ajustes específicos para el centro de formación Infosystem.', 'infosystem-child' ),
        'priority'    => 10,
    ) );

    // Sección de datos de contacto
    $wp_customize->add_section( 'infosystem_contact_section', array(
        'title'    => __( 'Datos de Contacto', 'infosystem-child' ),
        'panel'    => 'infosystem_panel',
        'priority' => 10,
    ) );

    // Campo: Teléfono
    $wp_customize->add_setting( 'infosystem_phone', array(
        'default'           => '+34 926 33 11 62',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'infosystem_phone', array(
        'label'   => __( 'Teléfono principal', 'infosystem-child' ),
        'section' => 'infosystem_contact_section',
        'type'    => 'text',
    ) );

    // Campo: Email
    $wp_customize->add_setting( 'infosystem_email', array(
        'default'           => 'info@infosystem.net',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'infosystem_email', array(
        'label'   => __( 'Email de contacto', 'infosystem-child' ),
        'section' => 'infosystem_contact_section',
        'type'    => 'email',
    ) );

    // Campo: Dirección
    $wp_customize->add_setting( 'infosystem_address', array(
        'default'           => 'C. Cruz de Piedra, 13 · 13730 Santa Cruz de Mudela, Ciudad Real',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'infosystem_address', array(
        'label'   => __( 'Dirección física', 'infosystem-child' ),
        'section' => 'infosystem_contact_section',
        'type'    => 'text',
    ) );

    // Sección de colores
    $wp_customize->add_section( 'infosystem_colors_section', array(
        'title'    => __( 'Colores Corporativos', 'infosystem-child' ),
        'panel'    => 'infosystem_panel',
        'priority' => 20,
    ) );

    // Color primario (granate)
    $wp_customize->add_setting( 'infosystem_color_primary', array(
        'default'           => '#8B1A1A',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'infosystem_color_primary', array(
        'label'   => __( 'Color Principal (Granate)', 'infosystem-child' ),
        'section' => 'infosystem_colors_section',
    ) ) );

    // Color secundario (dorado)
    $wp_customize->add_setting( 'infosystem_color_secondary', array(
        'default'           => '#D4880A',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'infosystem_color_secondary', array(
        'label'   => __( 'Color Secundario (Dorado)', 'infosystem-child' ),
        'section' => 'infosystem_colors_section',
    ) ) );
}


// ============================================================
// 4. CSS DINÁMICO DESDE CUSTOMIZER
// ============================================================
add_action( 'wp_head', 'infosystem_dynamic_css' );

function infosystem_dynamic_css() {
    $primary   = get_theme_mod( 'infosystem_color_primary',   '#8B1A1A' );
    $secondary = get_theme_mod( 'infosystem_color_secondary', '#D4880A' );
    ?>
    <style id="infosystem-dynamic-css">
        :root {
            --color-primary:   <?php echo esc_attr( $primary ); ?>;
            --color-secondary: <?php echo esc_attr( $secondary ); ?>;
        }

        /* Fix header menu alignment and style Contacto button on desktop (failsafe inline CSS) */
        @media (min-width: 1025px) {
            #header .tm-table,
            .site-header .tm-table {
                display: table !important;
                width: 100% !important;
                table-layout: auto !important;
            }

            #header .tm-table .width-logo,
            .site-header .tm-table .width-logo {
                width: auto !important;
                display: table-cell !important;
                vertical-align: middle !important;
                white-space: nowrap !important;
            }

            #header .tm-table .width-navigation,
            .site-header .tm-table .width-navigation,
            #header .width-navigation,
            .site-header .width-navigation {
                width: 100% !important;
                display: table-cell !important;
                vertical-align: middle !important;
            }

            .thim-ekits-menu__nav {
                display: flex !important;
                align-items: center !important;
                justify-content: flex-end !important; /* Align items to the far right */
                width: 100% !important; /* Stretch menu container to full width of cell */
                margin-left: auto !important;
                margin-top: 8px !important; /* Centrarlo visualmente */
                padding: 0 !important;
            }

            #header .nav > li,
            .thim-ekits-menu__nav > li {
                float: none !important;
                display: inline-flex !important;
                align-items: center !important;
                vertical-align: middle !important;
            }

            /* Hide the menu-right CTA (phone/button widget) on desktop to let Contacto be the rightmost element */
            .thim-ekits-menu__nav > li.menu-right {
                display: none !important;
            }

            /* Style Contacto (menu-item-16720) as a highlighted red button on desktop */
            #header .nav > li.menu-item-16720 > a,
            .thim-ekits-menu__nav > li.menu-item-16720 > a {
                background-color: var(--color-primary) !important;
                color: #ffffff !important;
                padding: 8px 20px !important;
                border-radius: 30px !important; /* Redondo / Pill-shaped button */
                font-weight: 700 !important;
                transition: all 0.3s ease !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                border: none !important;
                border-bottom: none !important;
                margin-left: 15px !important; /* Separación con el menú */
                box-shadow: 0 4px 10px rgba(139, 26, 26, 0.2) !important;
                text-transform: uppercase !important;
                font-size: 13px !important;
            }

            #header .nav > li.menu-item-16720 > a:hover,
            .thim-ekits-menu__nav > li.menu-item-16720 > a:hover {
                background-color: var(--color-secondary) !important; /* Dorado en hover */
                color: #ffffff !important;
                transform: translateY(-2px) !important;
                box-shadow: 0 6px 15px rgba(212, 136, 10, 0.3) !important;
            }

            /* Remove active border bottom highlight since it is now styled as a button */
            #header .nav > li.menu-item-16720.current-menu-item > a,
            #header .nav > li.menu-item-16720.active > a,
            #header .nav > li.menu-item-16720 > a:hover {
                border-bottom: none !important;
                color: #ffffff !important;
            }
        }
    </style>
    <?php
}


// ============================================================
// 5. HELPER: OBTENER DATOS DE CONTACTO
// ============================================================
function infosystem_get_phone() {
    return get_theme_mod( 'infosystem_phone', '+34 926 33 11 62' );
}

function infosystem_get_email() {
    return get_theme_mod( 'infosystem_email', 'info@infosystem.net' );
}

function infosystem_get_address() {
    return get_theme_mod( 'infosystem_address', 'C. Cruz de Piedra, 13 · 13730 Santa Cruz de Mudela, Ciudad Real' );
}


// ============================================================
// 6. MENÚ PERSONALIZADO
// ============================================================
add_action( 'after_setup_theme', 'infosystem_register_menus' );

function infosystem_register_menus() {
    register_nav_menus( array(
        'primary'   => __( 'Menú Principal', 'infosystem-child' ),
        'footer_1'  => __( 'Footer — Columna Nosotros', 'infosystem-child' ),
        'footer_2'  => __( 'Footer — Columna Cursos', 'infosystem-child' ),
    ) );
}


// ============================================================
// 7. WIDGETS — ÁREAS ADICIONALES
// ============================================================
add_action( 'widgets_init', 'infosystem_widgets_init' );

function infosystem_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar — Cursos', 'infosystem-child' ),
        'id'            => 'sidebar-cursos',
        'description'   => __( 'Aparece en páginas de cursos', 'infosystem-child' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Sidebar — Blog', 'infosystem-child' ),
        'id'            => 'sidebar-blog',
        'description'   => __( 'Aparece en entradas del blog', 'infosystem-child' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}


// ============================================================
// 8. SHORTCODES DE DATOS DE EMPRESA
// ============================================================
add_shortcode( 'infosystem_phone',   'infosystem_sc_phone' );
add_shortcode( 'infosystem_email',   'infosystem_sc_email' );
add_shortcode( 'infosystem_address', 'infosystem_sc_address' );

function infosystem_sc_phone() {
    $phone = infosystem_get_phone();
    return '<a href="tel:' . esc_attr( preg_replace('/\s+/', '', $phone) ) . '" class="infosystem-phone">' . esc_html( $phone ) . '</a>';
}

function infosystem_sc_email() {
    $email = infosystem_get_email();
    return '<a href="mailto:' . esc_attr( $email ) . '" class="infosystem-email">' . esc_html( $email ) . '</a>';
}

function infosystem_sc_address() {
    return '<span class="infosystem-address">' . esc_html( infosystem_get_address() ) . '</span>';
}


// ============================================================
// 9. PERSONALIZAR CORREOS DE WORDPRESS
// ============================================================
add_filter( 'wp_mail_from',      'infosystem_mail_from' );
add_filter( 'wp_mail_from_name', 'infosystem_mail_from_name' );

function infosystem_mail_from( $email ) {
    return 'info@infosystem.net';
}

function infosystem_mail_from_name( $name ) {
    return 'Infosystem — Centro de Educación Polivalente';
}


// ============================================================
// 10. AÑADIR META TAGS SEO BASE (sin plugin)
// ============================================================
add_action( 'wp_head', 'infosystem_meta_tags', 1 );

function infosystem_meta_tags() {
    if ( is_front_page() ) : ?>
    <meta name="description" content="Infosystem - Centro de Educación Polivalente en Santa Cruz de Mudela, Ciudad Real. Cursos gratuitos subvencionados por el SEPE y la Junta de Castilla-La Mancha para trabajadores, autónomos y desempleados.">
    <meta name="keywords" content="cursos gratuitos, formación SEPE, Castilla-La Mancha, Ciudad Real, cursos subvencionados, formación para el empleo, Infosystem">
    <meta property="og:title" content="Infosystem - Centro de Educación Polivalente">
    <meta property="og:description" content="Cursos gratuitos subvencionados por el SEPE y la Junta de Castilla-La Mancha. Formación para trabajadores, autónomos y desempleados en Ciudad Real.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo esc_url( home_url() ); ?>">
    <?php endif;
}


// ============================================================
// 11. SEGURIDAD — ELIMINAR VERSIÓN DE WP DEL FRONTEND
// ============================================================
remove_action( 'wp_head', 'wp_generator' );

add_filter( 'the_generator', '__return_empty_string' );


// ============================================================
// 12. SOPORTE DE IMÁGENES PERSONALIZADAS
// ============================================================
add_action( 'after_setup_theme', 'infosystem_image_sizes' );

function infosystem_image_sizes() {
    add_image_size( 'infosystem-course-thumb',  370, 230, true );
    add_image_size( 'infosystem-hero',         1920, 700, true );
    add_image_size( 'infosystem-blog-thumb',    400, 250, true );
    add_image_size( 'infosystem-team',          300, 300, true );
}

require_once get_stylesheet_directory() . '/inc/infosystem-woocommerce-courses.php';

// ============================================================
// 13. REDEFINIR COMPARTIR EN REDES SOCIALES (PLUGGABLE FUNCTION)
// ============================================================
if ( ! function_exists( 'thim_social_share' ) ) {
	function thim_social_share() {
		$networks = array( 'facebook', 'twitter', 'linkedin', 'instagram', 'tiktok' );
		
		echo '<ul class="thim-social-share">';
		do_action( 'thim_before_social_list' );
		echo '<li class="heading">' . esc_html__( 'Compartir:', 'infosystem-child' ) . '</li>';
		
		foreach ( $networks as $network ) {
			switch ( $network ) {
				case 'facebook':
					echo '<li><div class="facebook-social"><a target="_blank" class="facebook" href="https://www.facebook.com/sharer.php?u=' . urlencode( get_permalink() ) . '" title="' . esc_attr__( 'Facebook', 'eduma' ) . '"><i class="edu-facebook"></i></a></div></li>';
					break;
				case 'twitter':
					echo '<li><div class="twitter-social"><a target="_blank" class="twitter" href="https://twitter.com/share?url=' . urlencode( get_permalink() ) . '&amp;text=' . rawurlencode( esc_attr( get_the_title() ) ) . '" title="' . esc_attr__( 'Twitter', 'eduma' ) . '"><i class="edu-x-twitter"></i></a></div></li>';
					break;
				case 'linkedin':
					echo '<li><div class="linkedin-social"><a target="_blank" class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( get_permalink() ) . '&title=' . rawurlencode( esc_attr( get_the_title() ) ) . '&summary=&source=' . rawurlencode( esc_attr( get_the_excerpt() ) ) . '" title="LinkedIn"><svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor" style="display:inline-block; vertical-align:middle; margin-top:-2px;"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a></div></li>';
					break;
				case 'instagram':
					echo '<li><div class="instagram-social"><a href="#" class="instagram" onclick="navigator.clipboard.writeText(window.location.href); alert(\'¡Enlace copiado! Ya puedes pegarlo y compartirlo en tu Instagram.\'); return false;" title="Instagram"><svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor" style="display:inline-block; vertical-align:middle; margin-top:-2px;"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg></a></div></li>';
					break;
				case 'tiktok':
					echo '<li><div class="tiktok-social"><a href="#" class="tiktok" onclick="navigator.clipboard.writeText(window.location.href); alert(\'¡Enlace copiado! Ya puedes pegarlo y compartirlo en tu TikTok.\'); return false;" title="TikTok"><svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor" style="display:inline-block; vertical-align:middle; margin-top:-2px;"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.02 1.59 4.23.99 1.14 2.39 1.89 3.86 2.14v3.91c-1.39-.08-2.77-.63-3.87-1.5-.78-.62-1.42-1.42-1.89-2.32v6.62c.04 1.83-.53 3.65-1.64 5.09-1.36 1.72-3.53 2.76-5.73 2.79-2.02.07-4.04-.63-5.54-1.99-1.66-1.44-2.64-3.59-2.62-5.78.02-2.22 1.04-4.34 2.78-5.73 1.57-1.28 3.65-1.9 5.69-1.71v3.94c-1.07-.15-2.18.15-2.99.88-.89.76-1.38 1.94-1.34 3.1.04 1.15.6 2.23 1.52 2.89.98.74 2.25.92 3.37.5 1.02-.36 1.8-1.2 2.08-2.24.12-.51.15-1.04.14-1.57V.02z"/></svg></a></div></li>';
					break;
			}
		}
		
		do_action( 'thim_after_social_list' );
		echo '</ul>';
	}
}


// ============================================================
// 14. PROGRESSIVE WEB APP (PWA) — REGISTRO Y METATAGS
// ============================================================
add_action( 'wp_head', 'infosystem_pwa_metadata' );

function infosystem_pwa_metadata() {
    $theme_dir = get_stylesheet_directory();
    $icon_path = $theme_dir . '/images/pwa-app-icon.jpg';
    $icon_url  = '';

    if ( file_exists( $icon_path ) ) {
        $icon_url = get_stylesheet_directory_uri() . '/images/pwa-app-icon.jpg';
    } else {
        $icon_url = get_site_icon_url( 192 );
    }
    ?>
    <!-- PWA Manifest -->
    <link rel="manifest" href="<?php echo esc_url( home_url( '/manifest.json' ) ); ?>">

    <!-- PWA Mobile Configuration (iOS y Android) -->
    <meta name="theme-color" content="#8B1A1A">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="InfoSystem">
    <?php if ( $icon_url ) : ?>
    <link rel="apple-touch-icon" href="<?php echo esc_url( $icon_url ); ?>">
    <?php endif; ?>

    <!-- [PWA] Capturar beforeinstallprompt INMEDIATAMENTE — solo guarda flags, nunca muestra nada -->
    <script>
    window.__pwaInstallPrompt = null;
    window.__pwaShowBanner   = false;
    window.addEventListener('beforeinstallprompt', function(e) {
        e.preventDefault();
        window.__pwaInstallPrompt = e;
        window.__pwaShowBanner   = true;
        // NO mostramos el banner aquí: el script del footer se encarga (incluye comprobación de móvil)
    });
    </script>

    <!-- PWA Service Worker Registration -->
    <script data-no-optimize="1" data-cfasync="false">
    (function() {
        function registerSW() {
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(function(r) { console.log('SW registrado:', r.scope); })
                    .catch(function(e) { console.log('SW error:', e); });
            }
        }
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            registerSW();
        } else {
            window.addEventListener('load', registerSW);
        }
    })();
    </script>
    <style>
    /* Ocultar preloader del tema para evitar pantalla blanca con JS retrasado */
    div#preload, #preload, .thim-loading-container, .cssload-container, .loading-container {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }
    /* Forzar visibilidad y opacidad de la página de forma global y con alta especificidad */
    html body,
    html body #wrapper-container,
    html body .content-pusher,
    html body #page,
    html body #main-content {
        opacity: 1 !important;
        visibility: visible !important;
    }
    html, html.thim-html-preload {
        overflow: visible !important;
        height: auto !important;
    }
    body, body.thim-body-preload, body.thim-body-load-overlay {
        overflow: visible !important;
        height: auto !important;
        min-height: 100% !important;
        touch-action: auto !important;
        -webkit-overflow-scrolling: touch !important;
    }
    body #wrapper-container, body #page,
    body #main-content, body .content-pusher {
        overflow-x: clip !important;
        overflow-y: visible !important;
        height: auto !important;
    }
    .elementor-invisible,
    [class*="ekit--"],
    [class*="ekit-animated"],
    .animated {
        opacity: 1 !important;
        visibility: visible !important;
        transform: none !important;
        animation: none !important;
        animation-name: none !important;
    }
    </style>
    <?php
}

// ============================================================
// 15. ELIMINAR PRELOADER AL INSTANTE (BYPASS WP ROCKET DELAYS)
// ============================================================
add_action( 'wp_head', 'infosystem_remove_preload_instantly', 1 );

function infosystem_remove_preload_instantly() {
    ?>
    <script data-no-optimize="1" data-cfasync="false">
    /* rocket-exclude: infosystem_remove_preload_instantly */
    (function() {
        document.documentElement.classList.remove('thim-html-preload');
        document.documentElement.classList.remove('thim-html-load-overlay');
        var removeBodyPreload = function() {
            if (document.body) {
                document.body.classList.remove('thim-body-preload');
                document.body.classList.remove('thim-body-load-overlay');
                var preload = document.getElementById('preload');
                if (preload) {
                    preload.style.display = 'none';
                    preload.style.visibility = 'hidden';
                    preload.style.opacity = '0';
                    preload.style.pointerEvents = 'none';
                }
            } else {
                setTimeout(removeBodyPreload, 4);
            }
        };
        removeBodyPreload();
    })();
    </script>
    <?php
}

// Quitar las clases de preloader del body antes de que las añada el tema padre
add_filter( 'body_class', 'infosystem_remove_preloader_body_classes', 999 );
function infosystem_remove_preloader_body_classes( $classes ) {
    return array_diff( $classes, array( 'thim-body-preload', 'thim-body-load-overlay' ) );
}

// ============================================================
// 16. PRECARGA DE HERO + WP ROCKET DELAY JS DESACTIVADO EN HOME
// ============================================================
// SOLUCIÓN DEFINITIVA:
// WP Rocket "Delay JavaScript Execution" retrasa TODO el JS
// (incluyendo Elementor que aplica background-images y el script PWA).
// Desactivar el delay en la home page resuelve ambos problemas a la vez:
// la imagen hero carga instantáneamente y el botón de instalar app aparece.

// Excluir nuestros scripts críticos (preloader, banner y fadeout de splash) de WP Rocket Delay JS
add_filter( 'rocket_delay_js_exclusions', 'infosystem_exclude_critical_scripts_from_delay' );
function infosystem_exclude_critical_scripts_from_delay( $exclusions ) {
    $exclusions[] = 'infosystem_remove_preload_instantly';
    $exclusions[] = 'infosystem_pwa_install_banner';
    $exclusions[] = 'infosystem_splash_fadeout';
    return $exclusions;
}

// Excluir la imagen hero y la clase del contenedor del Lazy Load CSS de WP Rocket
add_filter( 'rocket_lazyload_excluded_src', 'infosystem_exclude_hero_lazyload' );
function infosystem_exclude_hero_lazyload( $srcs ) {
    $srcs[] = 'infosysytem_home.webp';
    return $srcs;
}

add_filter( 'rocket_lazyload_excluded_css_background_images', 'infosystem_exclude_hero_bg_lazyload' );
function infosystem_exclude_hero_bg_lazyload( $exclusions ) {
    $exclusions[] = 'e-63b7721-00125a1';
    $exclusions[] = 'elementor-element-63b7721';
    $exclusions[] = 'infosysytem_home.webp';
    return $exclusions;
}

// Inyectar preload + CSS de fondo hero en el <head> con prioridad máxima
add_action( 'wp_head', 'infosystem_force_hero_bg_immediate', 1 );
function infosystem_force_hero_bg_immediate() {
    if ( ! is_front_page() ) return;
    $hero_img = 'https://centrosinfosystem.com/wp-content/uploads/2026/04/infosysytem_home.webp';
    ?>
    <link rel="preload" as="image" href="<?php echo esc_url( $hero_img ); ?>" fetchpriority="high" crossorigin="anonymous">
    <style id="infosystem-hero-css" data-no-optimize="1" data-cfasync="false">
        /* Aplicar la imagen de fondo hero ANTES de que Elementor ejecute su JS */
        .elementor-element-63b7721,
        .e-63b7721-00125a1,
        [data-id="63b7721"],
        body.home .elementor-element-63b7721,
        body.home .e-63b7721-00125a1 {
            background-image: url("<?php echo esc_url( $hero_img ); ?>") !important;
            background-size: cover !important;
            background-position: center center !important;
        }
        .elementor-element-63b7721.elementor-invisible,
        .e-63b7721-00125a1.elementor-invisible {
            opacity: 1 !important;
            visibility: visible !important;
        }
    </style>
    <?php
}

// PHP hook: añadir clase e-no-lazyload y style inline directamente en el HTML renderizado por Elementor
add_action( 'elementor/element/before_render', 'infosystem_force_hero_inline_style', 5, 1 );
function infosystem_force_hero_inline_style( $element ) {
    if ( ! is_front_page() ) return;
    if ( $element->get_id() === '63b7721' ) {
        $hero_img = 'https://centrosinfosystem.com/wp-content/uploads/2026/04/infosysytem_home.webp';
        $element->add_render_attribute( '_wrapper', 'style',
            'background-image: url("' . esc_url( $hero_img ) . '") !important; ' .
            'background-size: cover !important; ' .
            'background-position: center center !important;',
            true
        );
        $element->add_render_attribute( '_wrapper', 'class', 'e-no-lazyload', true );
    }
}

// ============================================================
// 17. BANNER DE INSTALACIÓN PWA (HTML + CSS + JS) — solo móvil
// ============================================================
add_action( 'wp_footer', 'infosystem_pwa_install_banner' );
function infosystem_pwa_install_banner() {
    $theme_dir  = get_stylesheet_directory();
    $icon_path  = $theme_dir . '/images/pwa-app-icon.jpg';
    $icon_url   = file_exists( $icon_path )
                  ? get_stylesheet_directory_uri() . '/images/pwa-app-icon.jpg'
                  : get_site_icon_url( 192 );
    ?>
    <!-- ===== HTML DEL BANNER PWA ===== -->
    <div id="pwa-install-banner" role="complementary" aria-label="Instalar aplicación">
        <span id="pwa-banner-accent"></span>
        <div id="pwa-banner-row">
            <button id="pwa-banner-close" onclick="infosystemClosePWA()" aria-label="Cerrar">&#10005;</button>
            <div id="pwa-banner-icon-wrap">
                <?php if ( $icon_url ) : ?>
                <img src="<?php echo esc_url( $icon_url ); ?>" alt="Infosystem" width="54" height="54"
                     onerror="this.parentNode.innerHTML='<div id=\'pwa-banner-icon-fallback\'>IS</div>';">
                <?php else : ?>
                <div id="pwa-banner-icon-fallback">IS</div>
                <?php endif; ?>
            </div>
            <div id="pwa-banner-text">
                <span id="pwa-banner-title">App Infosystem</span>
                <span id="pwa-banner-subtitle">Gratis &bull; Formaci&oacute;n para el empleo</span>
            </div>
            <button id="pwa-install-action" onclick="infosystemInstallPWA()">Instalar</button>
        </div>
        <div id="pwa-banner-hint"></div>
    </div>

    <script data-no-optimize="1" data-cfasync="false">
    /* rocket-exclude: infosystem_pwa_install_banner */
    (function() {
        // DETECCIÓN DE MÓVIL — primera comprobación antes de hacer nada
        var ua      = navigator.userAgent || '';
        var isIOS   = /iphone|ipad|ipod/i.test(ua) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
        var isAnd   = /android/i.test(ua);
        // Si NO es móvil, salir inmediatamente (no mostrar el banner en desktop)
        if (!isIOS && !isAnd) return;

        var KEY    = 'pwa_banner_v3';
        var banner = document.getElementById('pwa-install-banner');

        // Si el usuario ya cerró el banner en esta sesión, salir
        if (sessionStorage.getItem(KEY)) return;
        var hint   = document.getElementById('pwa-banner-hint');
        if (!banner || sessionStorage.getItem(KEY)) return;

        function showBanner() {
            if (!banner || sessionStorage.getItem(KEY)) return;
            banner.style.setProperty('display', 'flex', 'important');
            void banner.offsetWidth;
            banner.style.setProperty('opacity', '1', 'important');
            banner.style.setProperty('transform', 'translateY(0)', 'important');
        }

        function hideBanner() {
            if (!banner) return;
            banner.style.setProperty('opacity', '0', 'important');
            banner.style.setProperty('transform', 'translateY(24px)', 'important');
            setTimeout(function() { if (banner) banner.style.setProperty('display', 'none', 'important'); }, 380);
        }

        window.infosystemInstallPWA = function() {
            if (window.__pwaInstallPrompt) {
                window.__pwaInstallPrompt.prompt();
                window.__pwaInstallPrompt.userChoice.then(function(r) {
                    if (r.outcome === 'accepted') hideBanner();
                    window.__pwaInstallPrompt = null;
                });
            } else if (isIOS) {
                if (hint) {
                    hint.style.setProperty('display', 'block', 'important');
                    hint.innerHTML = '&#128072; Pulsa <b style="all:unset;font-weight:700;">Compartir</b> (&uarr;) en Safari y toca <b style="all:unset;font-weight:700;">&ldquo;A&ntilde;adir a pantalla de inicio&rdquo;</b>.';
                }
            } else {
                alert('Para instalar:\n1. Abre el men\u00fa (\u22ee)\n2. \u00abA\u00f1adir a pantalla de inicio\u00bb');
            }
        };

        window.infosystemClosePWA = function() {
            sessionStorage.setItem(KEY, '1');
            hideBanner();
        };

        if (window.__pwaInstallPrompt || window.__pwaShowBanner) {
            showBanner();
            window.__pwaShowBanner = false;
            return;
        }

        window.addEventListener('beforeinstallprompt', function(e) {
            e.preventDefault();
            window.__pwaInstallPrompt = e;
            showBanner();
        });

        if (isIOS && !window.navigator.standalone) {
            setTimeout(showBanner, 500);
        }

        if (isAnd) {
            setTimeout(function() {
                if (!window.__pwaInstallPrompt && !sessionStorage.getItem(KEY)) showBanner();
            }, 500);
        }
    })();
    </script>
    <?php
}

// Filtro adicional para excluir la clase del hero del lazyload de Elementor via WP Rocket
add_filter( 'rocket_lazyload_css_background_images_excluded_classes', function( $classes ) {
    $classes[] = 'elementor-element-63b7721';
    $classes[] = 'e-63b7721-00125a1';
    return $classes;
});

// ============================================================
// 18. SPLASH SCREEN TEMPORAL PARA MÓVIL EN LA HOME (PREVIEW RÁPIDA)
// ============================================================
add_action( 'wp_footer', 'infosystem_mobile_splash_screen' );
function infosystem_mobile_splash_screen() {
    if ( ! is_front_page() ) return;
    ?>
    <div id="infosystem-mobile-splash">
        <div class="infosystem-splash-overlay"></div>
        <div class="infosystem-splash-content">
            <h5 class="infosystem-splash-subtitle">Especialistas en Formación para el Empleo</h5>
            <h1 class="infosystem-splash-title">Formación Gratuita para Mejorar tu Futuro Profesional</h1>
            <p class="infosystem-splash-desc">Cursos subvencionados por la Junta de Castilla La Mancha, el Ministerio de Trabajo y el Ministerio de Educación y Formación Profesional y Deportes.</p>
            <div class="infosystem-splash-buttons">
                <span class="infosystem-splash-btn primary">Ver cursos gratuitos</span>
                <span class="infosystem-splash-btn outline">Solicitar información</span>
            </div>
        </div>
    </div>
    <style id="infosystem-splash-styles">
    #infosystem-mobile-splash {
        display: none !important;
    }
    @media (max-width: 1024px) {
        body.home #infosystem-mobile-splash {
            display: block !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            background-image: url('https://centrosinfosystem.com/wp-content/uploads/2026/04/infosysytem_home.webp') !important;
            background-size: cover !important;
            background-position: center center !important;
            z-index: 9998 !important; /* Justo debajo del header y banner PWA */
            pointer-events: none !important; /* Permite que el toque pase al body para activar WP Rocket */
        }
        .infosystem-splash-overlay {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: rgba(0, 0, 0, 0.45) !important;
            z-index: 1 !important;
        }
        .infosystem-splash-content {
            position: absolute !important;
            top: 52% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            width: 90% !important;
            max-width: 450px !important;
            text-align: center !important;
            color: #ffffff !important;
            z-index: 2 !important;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        }
        .infosystem-splash-subtitle {
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #ffffff !important;
            margin: 0 0 12px 0 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            line-height: 1.2 !important;
            display: block !important;
        }
        .infosystem-splash-title {
            font-size: 26px !important;
            font-weight: 800 !important;
            color: #ffffff !important;
            margin: 0 0 16px 0 !important;
            line-height: 1.3 !important;
            display: block !important;
        }
        .infosystem-splash-desc {
            font-size: 13px !important;
            color: rgba(255, 255, 255, 0.85) !important;
            line-height: 1.5 !important;
            margin: 0 0 24px 0 !important;
            display: block !important;
        }
        .infosystem-splash-buttons {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
            align-items: center !important;
            width: 100% !important;
        }
        .infosystem-splash-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            max-width: 260px !important;
            padding: 12px 20px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            border-radius: 30px !important;
            text-transform: uppercase !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
        }
        .infosystem-splash-btn.primary {
            background-color: #ffb606 !important;
            color: #333333 !important;
            border: none !important;
        }
        .infosystem-splash-btn.outline {
            border: 2px solid #ffffff !important;
            color: #ffffff !important;
            background: transparent !important;
        }
    }
    </style>
    <script data-no-optimize="1" data-cfasync="false">
    /* rocket-exclude: infosystem_splash_fadeout */
    (function() {
        var hideSplash = function() {
            var splash = document.getElementById('infosystem-mobile-splash');
            if (splash) {
                splash.style.transition = 'opacity 0.4s ease-out';
                splash.style.opacity = '0';
                setTimeout(function() {
                    if (splash && splash.parentNode) {
                        splash.parentNode.removeChild(splash);
                    }
                }, 400);
            }
        };
        document.addEventListener('touchstart', hideSplash, {once: true, passive: true});
        document.addEventListener('mousedown', hideSplash, {once: true, passive: true});
    })();
    </script>
    <?php
}
