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

    // Estilos de maquetación de la home (parche para Elementor V4 y contenedores optimizados)
    if ( is_front_page() ) {
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
					echo '<li><div class="linkedin-social"><a target="_blank" class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( get_permalink() ) . '&title=' . rawurlencode( esc_attr( get_the_title() ) ) . '&summary=&source=' . rawurlencode( esc_attr( get_the_excerpt() ) ) . '" title="LinkedIn"><i class="edu-linkedin"></i></a></div></li>';
					break;
				case 'instagram':
					echo '<li><div class="instagram-social"><a href="#" class="instagram" onclick="navigator.clipboard.writeText(window.location.href); alert(\'¡Enlace copiado! Ya puedes pegarlo y compartirlo en tu Instagram.\'); return false;" title="Instagram"><i class="fab fa-instagram"></i></a></div></li>';
					break;
				case 'tiktok':
					echo '<li><div class="tiktok-social"><a href="#" class="tiktok" onclick="navigator.clipboard.writeText(window.location.href); alert(\'¡Enlace copiado! Ya puedes pegarlo y compartirlo en tu TikTok.\'); return false;" title="TikTok"><i class="fab fa-tiktok"></i></a></div></li>';
					break;
			}
		}
		
		do_action( 'thim_after_social_list' );
		echo '</ul>';
	}
}

