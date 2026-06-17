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
    $icon_url = '';
    
    // Check if the custom PWA icon exists in the child theme folder
    if ( file_exists( $icon_path ) ) {
        $icon_url = get_stylesheet_directory_uri() . '/images/pwa-app-icon.jpg';
    } else {
        // Fallback to WordPress Site Icon (Favicon)
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
    <link rel="apple-touch-icon" href="<?php echo esc_url($icon_url); ?>">
    <?php endif; ?>
    
    <!-- PWA Service Worker Registration & Install Prompt -->
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
                console.log('PWA Service Worker registrado con éxito. Scope:', registration.scope);
            }, function(err) {
                console.log('Fallo al registrar el Service Worker de la PWA:', err);
            });
        });
    }

    // PWA Smart Installation Banner
    document.addEventListener('DOMContentLoaded', function() {
        // Check if running in standalone mode (already installed)
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
        if (isStandalone) return;

        // Check localStorage if dismissed
        if (localStorage.getItem('pwa_install_dismissed')) return;

        // Detect iOS & Android
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

        // Only show on mobile / tablet
        const isMobile = window.innerWidth <= 1024;
        if (!isMobile) return;

        let deferredPrompt = null;

        // Listen for the native PWA install prompt (Chrome / Android)
        window.addEventListener('beforeinstallprompt', function(e) {
            e.preventDefault();
            deferredPrompt = e;
            showPWABanner();
        });

        // If it's iOS Safari, show PWA banner automatically (since it doesn't support beforeinstallprompt)
        if (isIOS) {
            setTimeout(showPWABanner, 2500); // delay show for a smooth entry
        }

        function showPWABanner() {
            // Create banner element if not already present
            if (document.getElementById('pwa-install-banner')) return;

            const banner = document.createElement('div');
            banner.id = 'pwa-install-banner';
            banner.innerHTML = `
                <div class="pwa-banner-container">
                    <?php if ( $icon_url ) : ?>
                    <img class="pwa-banner-icon" src="<?php echo esc_url($icon_url); ?>" alt="InfoSystem App" id="pwa-icon-img">
                    <?php else: ?>
                    <div class="pwa-banner-icon-fallback"><span>I</span></div>
                    <?php endif; ?>
                    <div class="pwa-banner-text">
                        <span class="pwa-banner-title">Instalar App</span>
                        <span class="pwa-banner-subtitle">Añade a tu pantalla de inicio</span>
                    </div>
                    <button class="pwa-banner-btn" id="pwa-install-action">Instalar</button>
                    <button class="pwa-banner-close" id="pwa-install-close" aria-label="Cerrar"></button>
                </div>
                <div class="pwa-ios-instructions" id="pwa-ios-instructions" style="display: none;">
                    <p>Para instalar en tu iPhone o iPad:</p>
                    <ol>
                        <li>Pulsa el botón de compartir <span class="ios-share-icon-wrapper"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="ios-share-svg"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg></span> en la barra de Safari.</li>
                        <li>Selecciona <strong>"Añadir a la pantalla de inicio"</strong>.</li>
                    </ol>
                </div>
            `;
            document.body.appendChild(banner);

            // Handle image error fallback dynamically in JS
            const img = document.getElementById('pwa-icon-img');
            if (img) {
                img.onerror = function() {
                    const fallbackSiteIcon = '<?php echo esc_url( get_site_icon_url( 192 ) ); ?>';
                    if (fallbackSiteIcon && this.src !== fallbackSiteIcon) {
                        this.src = fallbackSiteIcon;
                    } else {
                        // If everything fails, show the initials fallback
                        const fallbackDiv = document.createElement('div');
                        fallbackDiv.className = 'pwa-banner-icon-fallback';
                        fallbackDiv.innerHTML = '<span>I</span>';
                        this.parentNode.replaceChild(fallbackDiv, this);
                    }
                };
            }

            // Close button handler
            document.getElementById('pwa-install-close').addEventListener('click', function(e) {
                e.stopPropagation();
                banner.style.display = 'none';
                localStorage.setItem('pwa_install_dismissed', 'true');
            });

            // Action button handler
            document.getElementById('pwa-install-action').addEventListener('click', function() {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then(function(choiceResult) {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('El usuario aceptó la instalación de la PWA');
                            banner.style.display = 'none';
                        }
                        deferredPrompt = null;
                    });
                } else if (isIOS) {
                    const instructions = document.getElementById('pwa-ios-instructions');
                    if (instructions.style.display === 'none') {
                        instructions.style.display = 'block';
                        document.getElementById('pwa-install-action').innerText = 'Entendido';
                    } else {
                        instructions.style.display = 'none';
                        document.getElementById('pwa-install-action').innerText = 'Instalar';
                    }
                } else {
                    // Fallback for browsers that don't support prompt
                    alert('Para instalar la App en tu pantalla, abre el menú del navegador y selecciona "Instalar aplicación" o "Añadir a la pantalla de inicio".');
                }
            });
        }
    });
    </script>
    <style>
    /* PWA Banner Styles */
    #pwa-install-banner {
        position: fixed !important;
        bottom: 20px !important;
        left: 15px !important;
        right: 15px !important;
        background: rgba(255, 255, 255, 0.96) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        border: 1px solid rgba(255, 255, 255, 0.7) !important;
        border-radius: 20px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12), 0 1px 3px rgba(0, 0, 0, 0.05) !important;
        z-index: 999999 !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
        box-sizing: border-box !important;
        overflow: hidden !important;
        animation: pwaSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both !important;
        max-width: 460px !important;
        margin: 0 auto !important;
    }
    @keyframes pwaSlideUp {
        from { transform: translateY(80px) scale(0.96); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }
    .pwa-banner-container {
        display: flex !important;
        align-items: center !important;
        padding: 14px 16px !important;
        position: relative !important;
        box-sizing: border-box !important;
        width: 100% !important;
    }
    .pwa-banner-icon {
        width: 44px !important;
        height: 44px !important;
        max-width: 44px !important;
        max-height: 44px !important;
        border-radius: 10px !important;
        border: 1px solid rgba(0, 0, 0, 0.08) !important;
        margin-right: 12px !important;
        object-fit: cover !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06) !important;
        flex-shrink: 0 !important;
        position: static !important;
    }
    .pwa-banner-icon-fallback {
        width: 44px !important;
        height: 44px !important;
        max-width: 44px !important;
        max-height: 44px !important;
        border-radius: 10px !important;
        background: linear-gradient(135deg, #8B1A1A 0%, #D4880A 100%) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: #fff !important;
        font-weight: 700 !important;
        font-size: 20px !important;
        margin-right: 12px !important;
        box-shadow: 0 2px 6px rgba(139, 26, 26, 0.2) !important;
        flex-shrink: 0 !important;
        position: static !important;
    }
    .pwa-banner-icon-fallback span {
        line-height: 1 !important;
    }
    .pwa-banner-text {
        display: flex !important;
        flex-direction: column !important;
        flex-grow: 1 !important;
        margin-right: 12px !important;
        min-width: 0 !important;
        position: static !important;
    }
    .pwa-banner-title {
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #1e1e1e !important;
        margin-bottom: 2px !important;
        line-height: 1.2 !important;
        letter-spacing: -0.2px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    .pwa-banner-subtitle {
        font-size: 12px !important;
        color: #666 !important;
        line-height: 1.3 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    .pwa-banner-btn {
        background: linear-gradient(135deg, #8B1A1A 0%, #a32222 100%) !important;
        border: none !important;
        border-radius: 20px !important;
        color: #ffffff !important;
        padding: 7px 16px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        box-shadow: 0 3px 8px rgba(139, 26, 26, 0.2) !important;
        transition: all 0.2s ease !important;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
        outline: none !important;
        margin-right: 20px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: auto !important;
        height: auto !important;
        max-width: 110px !important;
        position: relative !important;
        top: auto !important;
        left: auto !important;
        right: auto !important;
        bottom: auto !important;
    }
    .pwa-banner-btn:hover, .pwa-banner-btn:active {
        background: linear-gradient(135deg, #D4880A 0%, #ef9d1a 100%) !important;
        box-shadow: 0 4px 10px rgba(212, 136, 10, 0.25) !important;
        transform: translateY(-1px) !important;
    }
    .pwa-banner-close {
        position: absolute !important;
        top: 6px !important;
        right: 6px !important;
        width: 32px !important;
        height: 32px !important;
        max-width: 32px !important;
        max-height: 32px !important;
        background: transparent !important;
        border: none !important;
        cursor: pointer !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
        z-index: 10 !important;
        outline: none !important;
        bottom: auto !important;
        left: auto !important;
    }
    .pwa-banner-close::before {
        content: '✕' !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 20px !important;
        height: 20px !important;
        border-radius: 50% !important;
        background: rgba(0, 0, 0, 0.05) !important;
        font-size: 9px !important;
        color: #888 !important;
        font-weight: bold !important;
        transition: all 0.2s ease !important;
    }
    .pwa-banner-close:hover::before, .pwa-banner-close:active::before {
        background: rgba(0, 0, 0, 0.1) !important;
        color: #333 !important;
    }
    /* iOS Instruction Styles */
    .pwa-ios-instructions {
        background: #fdfcfb !important;
        border-top: 1px solid rgba(139, 26, 26, 0.05) !important;
        padding: 12px 16px !important;
        font-size: 12px !important;
        color: #444 !important;
        line-height: 1.4 !important;
    }
    .pwa-ios-instructions p {
        font-weight: 700 !important;
        margin: 0 0 8px 0 !important;
        color: #8B1A1A !important;
    }
    .pwa-ios-instructions ol {
        margin: 0 !important;
        padding-left: 18px !important;
    }
    .pwa-ios-instructions li {
        margin-bottom: 6px !important;
    }
    .pwa-ios-instructions li:last-child {
        margin-bottom: 0 !important;
    }
    .ios-share-icon-wrapper {
        display: inline-flex !important;
        vertical-align: middle !important;
        background: #ffffff !important;
        border: 1px solid #dcdcdc !important;
        border-radius: 4px !important;
        padding: 2px 4px !important;
        margin: 0 2px !important;
        color: #007aff !important;
        box-shadow: 0 1px 1px rgba(0,0,0,0.05) !important;
    }
    .ios-share-svg {
        display: block !important;
    }

    /* Fix Elementor entrance animations on mobile when JS execution is delayed (e.g. WP Rocket) */
    @media (max-width: 1024px) {
        .elementor-invisible {
            visibility: visible !important;
            opacity: 1 !important;
            animation: none !important;
            animation-name: none !important;
        }
    }
    </style>
    <?php
}

