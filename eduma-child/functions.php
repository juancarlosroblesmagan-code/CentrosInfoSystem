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

    /* Banner CTA Listo para impulsar tu carrera a ancho completo sin franja blanca */
    body.page-id-16705 .elementor-element-404043f7,
    body.page-slug-conocenos .elementor-element-404043f7,
    body.page-id-16705 .cis-about-page section.cis-about-cta-final,
    body.page-slug-conocenos .cis-about-page section.cis-about-cta-final,
    body .elementor-widget-html .cis-about-page section.cis-about-cta-final {
        width: 100vw !important;
        max-width: 100vw !important;
        margin-left: calc(50% - 50vw) !important;
        margin-right: calc(50% - 50vw) !important;
        box-sizing: border-box !important;
    }
    body.page-id-16705 .elementor-element-404043f7,
    body.page-slug-conocenos .elementor-element-404043f7 {
        padding: 0 !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    /* =========================================================================
     * SECCIÓN REGÍSTRATE Y EMPIEZA HOY MISMO (HOME): MAQUETACIÓN COMPACTA Y TARJETAS
     * ========================================================================= */
    /* Anular recorte forzado de 65vh y scroll interno del plugin woo-quote */
    .elementor-element-ba75f78 .wpcf7 form,
    .elementor-element-ba75f78 .wpcf7-form,
    body.home .wpcf7 form {
        max-height: none !important;
        height: auto !important;
        overflow: visible !important;
        padding: 0 !important;
    }

    /* Contenedor principal de la sección equilibrado */
    body.home .elementor-element-13251ef {
        padding: 45px 24px 50px 24px !important;
        align-items: stretch !important;
    }

    /* Columna izquierda (Contador y texto): tarjeta blanca elegante armonizada */
    body.home .elementor-element-e7657e1 {
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
        background: #ffffff !important;
        padding: 44px 30px !important;
        border-radius: 18px !important;
        border: 1px solid #eaeaea !important;
        box-shadow: 0 12px 40px rgba(0,0,0,0.07) !important;
        box-sizing: border-box !important;
        height: 100% !important;
    }

    body.home .elementor-element-f1b3b39 .thim-countdown {
        display: flex !important;
        flex-wrap: nowrap !important;
        justify-content: space-between !important;
        gap: 12px !important;
    }

    body.home .elementor-element-f1b3b39 .thim-countdown .counter-block {
        flex: 1 1 0 !important;
        min-width: 0 !important;
        margin: 0 !important;
    }

    /* Columna derecha (Formulario): TARJETA BLANCA CON MÁRGENES GENEROSOS Y SANGRE PERIMETRAL */
    body.home .elementor-element-ba75f78 {
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
        background: #ffffff !important;
        padding: 46px 42px 54px 42px !important;
        border-radius: 18px !important;
        border: 1px solid #eaeaea !important;
        box-shadow: 0 12px 40px rgba(0,0,0,0.07) !important;
        box-sizing: border-box !important;
        height: 100% !important;
    }

    body.home .elementor-element-ba75f78 > p {
        margin: 0 0 24px 0 !important;
        font-size: 15px !important;
        line-height: 1.55 !important;
        color: #475569 !important;
        font-weight: 500 !important;
    }

    /* Formulario en formato grid dentro de la tarjeta blanca */
    .elementor-element-ba75f78 form.wpcf7-form {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 15px 18px !important;
        background: transparent !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        box-sizing: border-box !important;
        width: 100% !important;
        margin: 0 !important;
    }

    .elementor-element-ba75f78 form.wpcf7-form > p {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }

    /* Fila 1: Nombre (1) y Email (2) */
    .elementor-element-ba75f78 form.wpcf7-form > p:nth-of-type(1) { grid-column: 1 !important; grid-row: 1 !important; }
    .elementor-element-ba75f78 form.wpcf7-form > p:nth-of-type(2) { grid-column: 2 !important; grid-row: 1 !important; }

    /* Fila 2: Teléfono (3) y Quiz/Verificación (5) */
    .elementor-element-ba75f78 form.wpcf7-form > p:nth-of-type(3) { grid-column: 1 !important; grid-row: 2 !important; }
    .elementor-element-ba75f78 form.wpcf7-form > p:nth-of-type(5) { 
        grid-column: 2 !important; 
        grid-row: 2 !important;
        display: flex !important;
        align-items: center !important;
    }

    /* Fila 3: Textarea consulta (4) */
    .elementor-element-ba75f78 form.wpcf7-form > p:nth-of-type(4) { grid-column: span 2 !important; grid-row: 3 !important; }

    /* Filas siguientes: RGPD, Checkboxes y Submit */
    .elementor-element-ba75f78 form.wpcf7-form > p:nth-of-type(6) { grid-column: span 2 !important; grid-row: 4 !important; }
    .elementor-element-ba75f78 form.wpcf7-form > .infosystem-rgpd-capa { grid-column: span 2 !important; grid-row: 5 !important; }
    .elementor-element-ba75f78 form.wpcf7-form > p:nth-of-type(7) { grid-column: span 2 !important; grid-row: 6 !important; }
    .elementor-element-ba75f78 form.wpcf7-form > .button-submit { grid-column: span 2 !important; grid-row: 7 !important; }
    .elementor-element-ba75f78 form.wpcf7-form > .wpcf7-response-output,
    .elementor-element-ba75f78 form.wpcf7-form > .akismet-fields-container {
        grid-column: span 2 !important;
    }

    /* Casillas de entrada (inputs) estilizadas con fondos nítidos y margen blanco perimetral */
    .elementor-element-ba75f78 .wpcf7 input[type="text"],
    .elementor-element-ba75f78 .wpcf7 input[type="email"],
    .elementor-element-ba75f78 .wpcf7 input[type="tel"] {
        width: 100% !important;
        height: 44px !important;
        padding: 10px 15px !important;
        border: 1.5px solid #dcdfe4 !important;
        border-radius: 9px !important;
        font-size: 14px !important;
        background: #ffffff !important;
        box-sizing: border-box !important;
        transition: border-color 0.2s, box-shadow 0.2s !important;
    }

    .elementor-element-ba75f78 .wpcf7 input:focus,
    .elementor-element-ba75f78 .wpcf7 textarea:focus {
        border-color: #8B1A1A !important;
        box-shadow: 0 0 0 3px rgba(139,26,26,0.12) !important;
        background: #ffffff !important;
        outline: none !important;
    }

    /* Quiz / Verificación inline en una sola línea */
    .elementor-element-ba75f78 .wpcf7-form-control-wrap[data-name="anti-spam"] label {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 6px !important;
        font-size: 11.5px !important;
        color: #475569 !important;
        font-weight: 500 !important;
        margin: 0 !important;
        width: 100% !important;
        white-space: nowrap !important;
    }
    .elementor-element-ba75f78 .wpcf7-form-control-wrap[data-name="anti-spam"] input {
        height: 44px !important;
        max-width: 58px !important;
        text-align: center !important;
        font-weight: 700 !important;
        border: 1.5px solid #dcdfe4 !important;
        background: #ffffff !important;
        border-radius: 9px !important;
    }

    /* Textarea con tamaño optimizado */
    .elementor-element-ba75f78 .wpcf7 textarea {
        width: 100% !important;
        height: 52px !important;
        min-height: 48px !important;
        padding: 10px 15px !important;
        border: 1.5px solid #dcdfe4 !important;
        border-radius: 9px !important;
        font-size: 14px !important;
        background: #ffffff !important;
        resize: vertical !important;
        box-sizing: border-box !important;
    }

    /* RGPD caja con espaciado limpio */
    .elementor-element-ba75f78 .infosystem-rgpd-capa {
        margin: 4px 0 6px 0 !important;
        padding: 8px 14px !important;
        font-size: 11px !important;
        line-height: 1.4 !important;
        background: #f8fafc !important;
        border-left: 3px solid #8B1A1A !important;
        border-radius: 6px !important;
        color: #64748b !important;
    }
    .elementor-element-ba75f78 .infosystem-rgpd-capa p {
        margin: 0 0 2px 0 !important;
    }
    .elementor-element-ba75f78 .infosystem-rgpd-capa p:last-child {
        margin: 0 !important;
    }

    /* Checkboxes */
    .elementor-element-ba75f78 .wpcf7-acceptance label,
    .elementor-element-ba75f78 .wpcf7-checkbox label {
        font-size: 12px !important;
        color: #475569 !important;
        display: flex !important;
        align-items: flex-start !important;
        gap: 8px !important;
        line-height: 1.3 !important;
        cursor: pointer !important;
    }
    .elementor-element-ba75f78 .wpcf7-acceptance input,
    .elementor-element-ba75f78 .wpcf7-checkbox input {
        margin-top: 1px !important;
    }

    /* Botón submit destacado con margen inferior para sangre limpia */
    .elementor-element-ba75f78 .button-submit {
        margin-top: 12px !important;
        margin-bottom: 6px !important;
    }
    .elementor-element-ba75f78 .button-submit p {
        margin: 0 !important;
    }
    .elementor-element-ba75f78 input.wpcf7-submit {
        width: 100% !important;
        background: linear-gradient(135deg, #8B1A1A 0%, #6d1313 100%) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 999px !important;
        font-size: 15px !important;
        font-weight: 700 !important;
        padding: 13px 24px !important;
        cursor: pointer !important;
        transition: all 0.25s ease !important;
        box-shadow: 0 4px 16px rgba(139,26,26,0.32) !important;
        letter-spacing: 0.3px !important;
    }
    .elementor-element-ba75f78 input.wpcf7-submit:hover {
        background: linear-gradient(135deg, #a31e1e 0%, #8B1A1A 100%) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(139,26,26,0.4) !important;
    }

    @media (max-width: 767px) {
        body.home .elementor-element-e7657e1,
        body.home .elementor-element-ba75f78 {
            padding: 28px 20px 34px 20px !important;
            border-radius: 16px !important;
        }
        .elementor-element-ba75f78 form.wpcf7-form {
            grid-template-columns: 1fr !important;
            gap: 12px !important;
        }
        .elementor-element-ba75f78 form.wpcf7-form > p {
            grid-column: 1 !important;
            grid-row: auto !important;
        }
        .elementor-element-ba75f78 form.wpcf7-form > .infosystem-rgpd-capa,
        .elementor-element-ba75f78 form.wpcf7-form > .button-submit {
            grid-column: 1 !important;
            grid-row: auto !important;
        }
    }

    /* Eliminar separación superior en el banner de Política de Calidad */
    .elementor-17765 .elementor-element.elementor-element-04b3f27,
    body.page-id-17765 .elementor > .e-con:first-child,
    body.page-id-17765 .elementor > .elementor-element:first-child {
        padding-top: 0 !important;
        --padding-top: 0px !important;
        margin-top: 0 !important;
    }

    /* =========================================================================
     * PÁGINA DE CONTACTO (/contacto/): MAQUETACIÓN LIMPIA, RESPIRACIÓN Y SIN SCROLL
     * ========================================================================= */
    body.page-id-16719 .infosystem-contact-layout,
    body.page-slug-contacto .infosystem-contact-layout {
        align-items: stretch !important;
        gap: 24px !important;
    }

    /* Columna 1: Panel visual con imagen adaptada 100% y leyenda flotante */
    body.page-id-16719 .infosystem-contact-panel--visual,
    body.page-slug-contacto .infosystem-contact-panel--visual {
        display: flex !important;
        flex-direction: column !important;
        height: 100% !important;
        padding: 0 !important;
        border-radius: 18px !important;
        overflow: hidden !important;
        position: relative !important;
        background: #111 !important;
    }
    body.page-id-16719 .infosystem-contact-panel--visual figure,
    body.page-id-16719 .infosystem-contact-panel--visual .wp-block-image {
        flex: 1 1 100% !important;
        display: flex !important;
        height: 100% !important;
        margin: 0 !important;
    }
    body.page-id-16719 .infosystem-contact-panel--visual img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        object-position: center 20% !important;
        border-radius: 18px 18px 0 0 !important;
    }
    body.page-id-16719 .infosystem-contact-visual-caption,
    body.page-slug-contacto .infosystem-contact-visual-caption {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        background: linear-gradient(0deg, rgba(15,10,10,0.92) 0%, rgba(15,10,10,0.65) 65%, transparent 100%) !important;
        padding: 24px 20px 18px 20px !important;
        color: #ffffff !important;
        z-index: 2 !important;
    }

    /* Columna 2: Panel de datos de contacto distribuido armoniosamente */
    body.page-id-16719 .infosystem-contact-panel--info,
    body.page-slug-contacto .infosystem-contact-panel--info {
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        border-radius: 18px !important;
        padding: 28px 24px !important;
    }
    body.page-id-16719 .infosystem-contact-hours,
    body.page-slug-contacto .infosystem-contact-hours {
        margin-top: auto !important;
    }

    /* Columna 3: Panel de formulario sin scroll y perfectamente estructurado */
    body.page-id-16719 .infosystem-contact-panel--form,
    body.page-slug-contacto .infosystem-contact-panel--form,
    .infosystem-contact-panel--form {
        height: auto !important;
        min-height: 0 !important;
        max-height: none !important;
        overflow: visible !important;
        padding: 28px 26px 32px 26px !important;
        border-radius: 18px !important;
    }

    /* Anular cualquier scroll interno forzado en Contact Form 7 */
    body.page-id-16719 .infosystem-contact-panel--form form.wpcf7-form,
    body.page-slug-contacto .infosystem-contact-panel--form form.wpcf7-form,
    body.page-id-16719 .wpcf7 form,
    body.page-slug-contacto .wpcf7 form,
    .infosystem-contact-panel--form .wpcf7 form {
        height: auto !important;
        max-height: none !important;
        overflow: visible !important;
        padding: 0 !important;
    }

    /* Espaciado de campos de texto y textarea compacta */
    body.page-id-16719 .infosystem-contact-panel--form .wpcf7-form > p,
    body.page-slug-contacto .infosystem-contact-panel--form .wpcf7-form > p {
        margin: 0 0 10px 0 !important;
    }
    body.page-id-16719 .infosystem-contact-panel--form textarea,
    body.page-slug-contacto .infosystem-contact-panel--form textarea {
        min-height: 85px !important;
        height: 85px !important;
        resize: vertical !important;
        margin-bottom: 0 !important;
    }

    /* Verificación anti-spam / quiz estilizada */
    body.page-id-16719 .infosystem-contact-panel--form .wpcf7-quiz-label,
    body.page-slug-contacto .infosystem-contact-panel--form .wpcf7-quiz-label {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        display: block !important;
        margin-bottom: 4px !important;
    }
    body.page-id-16719 .infosystem-contact-panel--form input.wpcf7-quiz,
    body.page-slug-contacto .infosystem-contact-panel--form input.wpcf7-quiz {
        height: 42px !important;
        border-radius: 10px !important;
        border: 1px solid #e2ddd8 !important;
        padding: 8px 14px !important;
        font-size: 14px !important;
        background: #fdfcfb !important;
    }

    /* Checkboxes agrupados con alineación perfecta */
    body.page-id-16719 .infosystem-contact-panel--form .wpcf7-acceptance label,
    body.page-id-16719 .infosystem-contact-panel--form .wpcf7-checkbox label,
    body.page-slug-contacto .infosystem-contact-panel--form .wpcf7-acceptance label,
    body.page-slug-contacto .infosystem-contact-panel--form .wpcf7-checkbox label {
        font-size: 12.5px !important;
        color: #334155 !important;
        display: flex !important;
        align-items: flex-start !important;
        gap: 9px !important;
        line-height: 1.38 !important;
        cursor: pointer !important;
        margin: 6px 0 !important;
    }
    body.page-id-16719 .infosystem-contact-panel--form .wpcf7-acceptance input[type="checkbox"],
    body.page-id-16719 .infosystem-contact-panel--form .wpcf7-checkbox input[type="checkbox"],
    body.page-slug-contacto .infosystem-contact-panel--form .wpcf7-acceptance input[type="checkbox"],
    body.page-slug-contacto .infosystem-contact-panel--form .wpcf7-checkbox input[type="checkbox"] {
        margin-top: 2px !important;
        flex-shrink: 0 !important;
        width: 16px !important;
        height: 16px !important;
        accent-color: #8B1A1A !important;
        cursor: pointer !important;
    }

    /* Caja de información RGPD (primera capa): limpia, elegante y bien integrada */
    body.page-id-16719 .infosystem-contact-panel--form .infosystem-rgpd-capa,
    body.page-slug-contacto .infosystem-contact-panel--form .infosystem-rgpd-capa {
        font-size: 11px !important;
        line-height: 1.45 !important;
        margin: 10px 0 16px 0 !important;
        background: #f8fafc !important;
        padding: 11px 14px !important;
        border-radius: 8px !important;
        border: 1px solid #e2e8f0 !important;
        border-left: 3px solid #8B1A1A !important;
        color: #64748b !important;
    }
    body.page-id-16719 .infosystem-contact-panel--form .infosystem-rgpd-capa p,
    body.page-slug-contacto .infosystem-contact-panel--form .infosystem-rgpd-capa p {
        margin: 0 0 3px 0 !important;
        font-size: 11px !important;
        line-height: 1.45 !important;
    }
    body.page-id-16719 .infosystem-contact-panel--form .infosystem-rgpd-capa p:last-child,
    body.page-slug-contacto .infosystem-contact-panel--form .infosystem-rgpd-capa p:last-child {
        margin: 0 !important;
    }
    body.page-id-16719 .infosystem-contact-panel--form .infosystem-rgpd-capa strong,
    body.page-slug-contacto .infosystem-contact-panel--form .infosystem-rgpd-capa strong {
        color: #1e293b !important;
        font-weight: 600 !important;
    }
    body.page-id-16719 .infosystem-contact-panel--form .infosystem-rgpd-capa a,
    body.page-slug-contacto .infosystem-contact-panel--form .infosystem-rgpd-capa a {
        color: #8B1A1A !important;
        text-decoration: underline !important;
        font-weight: 600 !important;
    }

    /* Botón de Enviar mensaje con acabado premium */
    body.page-id-16719 .infosystem-contact-panel--form .button-submit,
    body.page-slug-contacto .infosystem-contact-panel--form .button-submit {
        margin-top: 14px !important;
        margin-bottom: 6px !important;
        text-align: center !important;
    }
    body.page-id-16719 .infosystem-contact-panel--form .button-submit p,
    body.page-slug-contacto .infosystem-contact-panel--form .button-submit p {
        margin: 0 !important;
    }
    body.page-id-16719 .infosystem-contact-panel--form input.wpcf7-submit,
    body.page-slug-contacto .infosystem-contact-panel--form input.wpcf7-submit {
        width: 100% !important;
        background: linear-gradient(135deg, #8B1A1A 0%, #6d1313 100%) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 999px !important;
        font-size: 15px !important;
        font-weight: 700 !important;
        padding: 13px 24px !important;
        cursor: pointer !important;
        transition: all 0.25s ease !important;
        box-shadow: 0 4px 16px rgba(139,26,26,0.28) !important;
        letter-spacing: 0.3px !important;
    }
    body.page-id-16719 .infosystem-contact-panel--form input.wpcf7-submit:hover,
    body.page-slug-contacto .infosystem-contact-panel--form input.wpcf7-submit:hover {
        background: linear-gradient(135deg, #a31e1e 0%, #8B1A1A 100%) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(139,26,26,0.38) !important;
    }
    </style>

    <?php

}

/**
 * Reordenar armónicamente los elementos del formulario de contacto (/contacto/):
 * Agrupa las dos casillas de verificación juntas y sitúa la capa informativa RGPD
 * inmediatamente después de ambas casillas para una maquetación y UX perfectas.
 */
add_filter( 'wpcf7_form_elements', function( $elements ) {
    if ( strpos( $elements, 'infosystem-rgpd-capa' ) !== false && strpos( $elements, 'news-acceptance' ) !== false ) {
        if ( preg_match( '/<div class="infosystem-rgpd-capa"[^>]*>[\s\S]*?<\/div>/', $elements, $rgpd_m ) ) {
            $rgpd_block = $rgpd_m[0];
            $elements = str_replace( $rgpd_block, '', $elements );
            $elements = preg_replace(
                '/(<p><span class="wpcf7-form-control-wrap" data-name="news-acceptance">[\s\S]*?<\/p>)/',
                '$1' . "\n" . $rgpd_block,
                $elements
            );
        }
    }
    return $elements;
} );





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

    <!-- ===== CSS RESET DEL BANNER PWA — aísla del CSS del tema ===== -->

    <style id="pwa-banner-styles">

    #pwa-install-banner, #pwa-install-banner * {

        all: initial !important;

        box-sizing: border-box !important;

        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif !important;

    }

    #pwa-install-banner {

        display: none !important;

        position: fixed !important;

        bottom: 20px !important;

        left: 16px !important;

        right: 16px !important;

        z-index: 2147483647 !important;

        background: #ffffff !important;

        border-radius: 20px !important;

        box-shadow: 0 8px 32px rgba(0,0,0,0.20), 0 2px 8px rgba(0,0,0,0.10) !important;

        overflow: hidden !important;

        opacity: 0 !important;

        transform: translateY(24px) !important;

        transition: opacity 0.35s cubic-bezier(.4,0,.2,1), transform 0.35s cubic-bezier(.4,0,.2,1) !important;

        flex-direction: column !important;

        padding: 0 !important;

        margin: 0 !important;

        border: none !important;

        outline: none !important;

    }

    #pwa-banner-accent {

        display: block !important;

        width: 100% !important;

        height: 4px !important;

        background: linear-gradient(90deg, #8B1A1A 0%, #C0392B 40%, #D4880A 100%) !important;

        flex-shrink: 0 !important;

    }

    #pwa-banner-row {

        display: flex !important;

        flex-direction: row !important;

        align-items: center !important;

        gap: 12px !important;

        padding: 14px 16px 16px 16px !important;

        position: relative !important;

        width: 100% !important;

    }

    #pwa-banner-icon-wrap {

        display: flex !important;

        flex-shrink: 0 !important;

        width: 54px !important;

        height: 54px !important;

        border-radius: 14px !important;

        overflow: hidden !important;

        box-shadow: 0 2px 8px rgba(139,26,26,0.25) !important;

    }

    #pwa-banner-icon-wrap img {

        display: block !important;

        width: 54px !important;

        height: 54px !important;

        object-fit: cover !important;

        border-radius: 14px !important;

    }

    #pwa-banner-icon-fallback {

        display: flex !important;

        width: 54px !important;

        height: 54px !important;

        border-radius: 14px !important;

        background: linear-gradient(135deg, #8B1A1A 0%, #D4880A 100%) !important;

        align-items: center !important;

        justify-content: center !important;

        color: #ffffff !important;

        font-size: 20px !important;

        font-weight: 800 !important;

    }

    #pwa-banner-text {

        display: flex !important;

        flex-direction: column !important;

        flex: 1 !important;

        min-width: 0 !important;

        gap: 3px !important;

    }

    #pwa-banner-title {

        display: block !important;

        font-size: 15px !important;

        font-weight: 800 !important;

        color: #111111 !important;

        line-height: 1.25 !important;

        white-space: nowrap !important;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

    }

    #pwa-banner-subtitle {

        display: block !important;

        font-size: 12px !important;

        color: #666666 !important;

        line-height: 1.4 !important;

        white-space: nowrap !important;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

    }

    #pwa-install-action {

        display: inline-flex !important;

        align-items: center !important;

        justify-content: center !important;

        flex-shrink: 0 !important;

        background: linear-gradient(135deg, #8B1A1A 0%, #A52020 100%) !important;

        color: #ffffff !important;

        border: none !important;

        border-radius: 24px !important;

        padding: 10px 20px !important;

        font-size: 14px !important;

        font-weight: 700 !important;

        cursor: pointer !important;

        white-space: nowrap !important;

        box-shadow: 0 3px 10px rgba(139,26,26,0.38) !important;

        outline: none !important;

        line-height: 1 !important;

        height: auto !important;

        width: auto !important;

        text-decoration: none !important;

        letter-spacing: 0.2px !important;

    }

    #pwa-banner-close {

        display: flex !important;

        align-items: center !important;

        justify-content: center !important;

        position: absolute !important;

        top: 8px !important;

        right: 10px !important;

        background: none !important;

        border: none !important;

        cursor: pointer !important;

        padding: 0 !important;

        color: #bbbbbb !important;

        font-size: 18px !important;

        line-height: 1 !important;

        outline: none !important;

        width: auto !important;

        height: auto !important;

    }

    #pwa-banner-hint {

        display: none !important;

        padding: 10px 16px 14px !important;

        font-size: 12px !important;

        color: #555555 !important;

        line-height: 1.6 !important;

        border-top: 1px solid #f0f0f0 !important;

        background: #fafafa !important;

    }

    </style>



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

        var ua    = navigator.userAgent || '';

        var isIOS = /iphone|ipad|ipod/i.test(ua) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);

        var isAnd = /android/i.test(ua);

        if (!isIOS && !isAnd) return;



        var KEY    = 'pwa_v4';

        var banner = document.getElementById('pwa-install-banner');

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

            setTimeout(function() {

                if (banner) banner.style.setProperty('display', 'none', 'important');

            }, 380);

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

                    hint.innerHTML = '&#128072; Pulsa <b style="all:unset;font-weight:700;">Compartir</b> (&uarr;) en Safari y toca <b style="all:unset;font-weight:700;">&ldquo;A&ntilde;adir a pantalla de inicio&rdquo;</b>';

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



// ============================================================

// 19. DETALLES DEL CURSO - METABOX PARA UBICACIÓN Y FECHAS (WooCommerce)
// ============================================================
add_action( 'add_meta_boxes', 'infosystem_add_course_meta_box' );
function infosystem_add_course_meta_box() {
    add_meta_box(
        'infosystem_course_details',
        'Detalles del Curso (Ubicación, Fechas y Estado)',
        'infosystem_course_details_callback',
        'product',
        'normal',
        'high'
    );
}

// Helpers para conversión de fechas
function infosystem_format_date_to_input( $date_str ) {
    if ( empty( $date_str ) ) return '';
    if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date_str ) ) {
        return $date_str;
    }
    if ( preg_match( '/^(\d{2})\/(\d{2})\/(\d{4})$/', $date_str, $matches ) ) {
        return $matches[3] . '-' . $matches[2] . '-' . $matches[1];
    }
    $timestamp = strtotime( $date_str );
    if ( $timestamp ) {
        return date( 'Y-m-d', $timestamp );
    }
    return $date_str;
}

function infosystem_format_date_to_display( $date_str ) {
    if ( empty( $date_str ) ) return '';
    if ( preg_match( '/^\d{2}\/\d{2}\/\d{4}$/', $date_str ) ) {
        return $date_str;
    }
    if ( preg_match( '/^(\d{4})-(\d{2})-(\d{2})$/', $date_str, $matches ) ) {
        return $matches[3] . '/' . $matches[2] . '/' . $matches[1];
    }
    $timestamp = strtotime( $date_str );
    if ( $timestamp ) {
        return date( 'd/m/Y', $timestamp );
    }
    return $date_str;
}

/**
 * Comprueba si un curso/producto está finalizado (automáticamente según fechas o forzado manual).
 */
function infosystem_is_course_finished( $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    if ( ! $post_id ) {
        return false;
    }

    $forced_status = get_post_meta( $post_id, '_curso_estado_forzado', true );
    if ( 'finalizado' === $forced_status ) {
        return true;
    }
    if ( 'activo' === $forced_status ) {
        return false;
    }

    $end_date_raw = get_post_meta( $post_id, '_fecha_fin', true );
    if ( empty( $end_date_raw ) ) {
        return false;
    }

    $end_timestamp = false;
    $date_trimmed  = trim( $end_date_raw );

    if ( preg_match( '/^(\d{4})-(\d{2})-(\d{2})$/', $date_trimmed, $m ) ) {
        $end_timestamp = mktime( 23, 59, 59, (int) $m[2], (int) $m[3], (int) $m[1] );
    } elseif ( preg_match( '/^(\d{2})[\/\-](\d{2})[\/\-](\d{4})$/', $date_trimmed, $m ) ) {
        $end_timestamp = mktime( 23, 59, 59, (int) $m[2], (int) $m[1], (int) $m[3] );
    } else {
        $t = strtotime( $date_trimmed );
        if ( $t ) {
            $end_timestamp = mktime( 23, 59, 59, (int) date( 'm', $t ), (int) date( 'd', $t ), (int) date( 'Y', $t ) );
        }
    }

    if ( ! $end_timestamp ) {
        return false;
    }

    return ( current_time( 'timestamp' ) > $end_timestamp );
}

function infosystem_course_details_callback( $post ) {
    wp_nonce_field( 'infosystem_save_course_details', 'infosystem_course_details_nonce' );
    
    $location   = get_post_meta( $post->ID, '_centro_imparticion', true );
    $start_date = get_post_meta( $post->ID, '_fecha_inicio', true );
    $end_date   = get_post_meta( $post->ID, '_fecha_fin', true );
    $forced     = get_post_meta( $post->ID, '_curso_estado_forzado', true );
    if ( empty( $forced ) ) {
        $forced = 'auto';
    }

    $start_date_input = infosystem_format_date_to_input( $start_date );
    $end_date_input   = infosystem_format_date_to_input( $end_date );
    $is_finished      = infosystem_is_course_finished( $post->ID );

    $predefined_centers = array(
        'CENTROS INFOSYSTEM | Santa Cruz de Mudela'   => array( 'CENTROS INFOSYSTEM | Santa Cruz de Mudela', 'Santa Cruz de Mudela' ),
        'CENTROS FORMACIÓN LAGUNA | Viso del Marqués' => array( 'CENTROS FORMACIÓN LAGUNA | Viso del Marqués', 'Viso del Marqués' ),
        'CENTROS INFOSYSTEM | Fuente el Fresno'       => array( 'CENTROS INFOSYSTEM | Fuente el Fresno', 'Fuente el Fresno' ),
        'CENTROS FORMACIÓN LAGUNA | Membrilla'        => array( 'CENTROS FORMACIÓN LAGUNA | Membrilla', 'Membrilla' ),
        'Online / Aula Virtual'                       => array( 'Online / Aula Virtual' )
    );

    $is_custom_location = ! empty( $location );
    foreach ( $predefined_centers as $key => $values ) {
        if ( in_array( $location, $values, true ) ) {
            $is_custom_location = false;
            break;
        }
    }
    ?>
    <style>
        .infosystem-meta-field { margin-bottom: 15px; }
        .infosystem-meta-field label { display: block; font-weight: bold; margin-bottom: 5px; }
        .infosystem-meta-field input, .infosystem-meta-field select { width: 100%; max-width: 420px; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; }
        .infosystem-status-indicator {
            max-width: 420px;
            padding: 12px 15px;
            border-radius: 6px;
            font-size: 13px;
            margin-top: 10px;
        }
        .status-ind-finished {
            background: #FBEBEB;
            border-left: 4px solid #8B1A1A;
            color: #8B1A1A;
        }
        .status-ind-active {
            background: #EAF7ED;
            border-left: 4px solid #27AE60;
            color: #1E8449;
        }

    </style>

    <div class="infosystem-meta-field">
        <label for="course_location">Lugar de impartición:</label>
        <select name="course_location" id="course_location">
            <option value="">-- Seleccionar centro --</option>
            <?php foreach ($predefined_centers as $display_val => $match_vals) : ?>
                <option value="<?php echo esc_attr($display_val); ?>" <?php selected( in_array( $location, $match_vals, true ) ); ?>><?php echo esc_html($display_val); ?></option>
            <?php endforeach; ?>
            <option value="custom" <?php selected( $is_custom_location ); ?>>Ubicación personalizada...</option>
        </select>
        <p class="description" style="margin-top:5px;">O introduce una personalizada a continuación si has seleccionado "Ubicación personalizada":</p>
        <input type="text" name="course_location_custom" id="course_location_custom" placeholder="Ej. CENTROS INFOSYSTEM | Ciudad Real..." value="<?php echo esc_attr( $is_custom_location ? $location : '' ); ?>">
    </div>

    <div class="infosystem-meta-field">
        <label for="course_start_date">Fecha de inicio:</label>
        <input type="date" name="course_start_date" id="course_start_date" value="<?php echo esc_attr( $start_date_input ); ?>">
    </div>

    <div class="infosystem-meta-field">
        <label for="course_end_date">Fecha de finalización:</label>
        <input type="date" name="course_end_date" id="course_end_date" value="<?php echo esc_attr( $end_date_input ); ?>">
    </div>

    <div class="infosystem-meta-field">
        <label for="curso_estado_forzado">Estado de finalización:</label>
        <select name="curso_estado_forzado" id="curso_estado_forzado">
            <option value="auto" <?php selected( $forced, 'auto' ); ?>>Automático según fechas (Recomendado)</option>
            <option value="finalizado" <?php selected( $forced, 'finalizado' ); ?>>Forzar como FINALIZADO</option>
            <option value="activo" <?php selected( $forced, 'activo' ); ?>>Forzar como ACTIVO / EN CURSO</option>
        </select>
        <p class="description">Al poner la fecha de inicio y la fecha final, al pasar la fecha final aparecerá automáticamente la banda "FINALIZADO" en el banner e imágenes del curso.</p>

        <?php if ( ! empty( $end_date_input ) || 'auto' !== $forced ) : ?>
            <div class="infosystem-status-indicator <?php echo $is_finished ? 'status-ind-finished' : 'status-ind-active'; ?>">
                <strong>Estado resultante del curso:</strong> 
                <?php if ( $is_finished ) : ?>
                    <span style="font-weight: 700;">🔴 FINALIZADO</span> (se muestra automáticamente la banda en el banner y catálogo)
                <?php else : ?>
                    <span style="font-weight: 700;">🟢 ACTIVO / PRÓXIMO</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

add_action( 'save_post_product', 'infosystem_save_course_details' );
function infosystem_save_course_details( $post_id ) {
    if ( ! isset( $_POST['infosystem_course_details_nonce'] ) || ! wp_verify_nonce( $_POST['infosystem_course_details_nonce'], 'infosystem_save_course_details' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $location = isset( $_POST['course_location'] ) ? sanitize_text_field( $_POST['course_location'] ) : '';
    if ( 'custom' === $location && ! empty( $_POST['course_location_custom'] ) ) {
        $location = sanitize_text_field( $_POST['course_location_custom'] );
    }

    update_post_meta( $post_id, '_centro_imparticion', $location );

    if ( isset( $_POST['course_start_date'] ) ) {
        update_post_meta( $post_id, '_fecha_inicio', sanitize_text_field( $_POST['course_start_date'] ) );
    }
    if ( isset( $_POST['course_end_date'] ) ) {
        update_post_meta( $post_id, '_fecha_fin', sanitize_text_field( $_POST['course_end_date'] ) );
    }
    if ( isset( $_POST['curso_estado_forzado'] ) ) {
        update_post_meta( $post_id, '_curso_estado_forzado', sanitize_text_field( $_POST['curso_estado_forzado'] ) );
    }
}

// ============================================================
// 20. MOSTRAR DETALLES DEL CURSO EN LA FICHA DE PRODUCTO
// ============================================================
add_action( 'woocommerce_single_product_summary', 'infosystem_display_course_details', 45 );
function infosystem_display_course_details() {
    global $post;

    $location   = get_post_meta( $post->ID, '_centro_imparticion', true );
    $start_date = get_post_meta( $post->ID, '_fecha_inicio', true );
    $end_date   = get_post_meta( $post->ID, '_fecha_fin', true );

    if ( empty( $location ) && empty( $start_date ) && empty( $end_date ) ) {
        return;
    }

    $formatted_start = infosystem_format_date_to_display( $start_date );
    $formatted_end   = infosystem_format_date_to_display( $end_date );
    $is_finished     = infosystem_is_course_finished( $post->ID );

    echo '<style>
        .infosystem-course-details-card {
            margin: 35px 0 !important;
            padding: 24px 28px !important;
            background: linear-gradient(135deg, #FAF7F2 0%, #F5EFE6 100%) !important;
            border: 1px solid rgba(139, 26, 26, 0.08) !important;
            border-left: 5px solid #8B1A1A !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 30px rgba(139, 26, 26, 0.04), 0 1px 3px rgba(0, 0, 0, 0.02) !important;
            box-sizing: border-box !important;
            width: 100% !important;
            display: block !important;
            transition: all 0.3s ease !important;
        }
        .infosystem-course-details-card:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 12px 35px rgba(139, 26, 26, 0.08), 0 2px 5px rgba(0, 0, 0, 0.03) !important;
            border-color: rgba(139, 26, 26, 0.15) !important;
        }
        .infosystem-course-details-card .detail-row {
            display: flex !important;
            align-items: center !important;
            margin-bottom: 20px !important;
        }
        .infosystem-course-details-card .detail-row:last-child {
            margin-bottom: 0 !important;
        }
        .infosystem-course-details-card .detail-icon-wrap {
            width: 42px !important;
            height: 42px !important;
            border-radius: 50% !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            background-color: rgba(139, 26, 26, 0.07) !important;
            color: #8B1A1A !important;
            margin-right: 16px !important;
            flex-shrink: 0 !important;
            font-size: 18px !important;
            transition: background-color 0.3s ease !important;
        }
        .infosystem-course-details-card:hover .detail-icon-wrap {
            background-color: rgba(139, 26, 26, 0.12) !important;
        }
        .infosystem-course-details-card .detail-content {
            flex-grow: 1 !important;
        }
        .infosystem-course-details-card .detail-label {
            display: block !important;
            font-size: 10px !important;
            text-transform: uppercase !important;
            letter-spacing: 1.5px !important;
            color: #8B1A1A !important;
            font-weight: 700 !important;
            margin-bottom: 4px !important;
            opacity: 0.85 !important;
            line-height: 1 !important;
        }
        .infosystem-course-details-card .detail-value {
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #2C2C2C !important;
            line-height: 1.3 !important;
        }
        .infosystem-course-details-card .date-range {
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 8px 12px !important;
        }
        .infosystem-course-details-card .date-item {
            font-size: 15px !important;
            font-weight: 500 !important;
            color: #555555 !important;
        }
        .infosystem-course-details-card .date-item strong {
            font-weight: 700 !important;
            color: #2C2C2C !important;
        }
        .infosystem-course-details-card .date-separator {
            color: #CCCCCC !important;
            font-weight: 400 !important;
            font-size: 14px !important;
        }
        .badge-status-finalizado-tag {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            background: linear-gradient(135deg, #A92525 0%, #8B1A1A 100%) !important;
            color: #ffffff !important;
            font-size: 12px !important;
            font-weight: 800 !important;
            letter-spacing: 1px !important;
            text-transform: uppercase !important;
            padding: 4px 12px !important;
            border-radius: 4px !important;
            box-shadow: 0 2px 6px rgba(139,26,26,0.3) !important;
        }
        @media (max-width: 480px) {
            .infosystem-course-details-card {
                padding: 20px 22px !important;
            }
            .infosystem-course-details-card .detail-row {
                align-items: flex-start !important;
            }
            .infosystem-course-details-card .detail-icon-wrap {
                width: 36px !important;
                height: 36px !important;
                font-size: 16px !important;
                margin-right: 12px !important;
                margin-top: 2px !important;
            }
            .infosystem-course-details-card .detail-value {
                font-size: 15px !important;
            }
            .infosystem-course-details-card .date-range {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 4px !important;
            }
            .infosystem-course-details-card .date-separator {
                display: none !important;
            }
        }

    </style>';

    echo '<div class="infosystem-course-details-card">';

    if ( ! empty( $location ) ) {
        echo '<div class="detail-row location-row">';
        echo '<div class="detail-icon-wrap">📍</div>';
        echo '<div class="detail-content">';
        echo '<span class="detail-label">Lugar de impartición</span>';
        echo '<span class="detail-value">' . esc_html( $location ) . '</span>';
        echo '</div>';
        echo '</div>';
    }

    if ( ! empty( $formatted_start ) || ! empty( $formatted_end ) ) {
        echo '<div class="detail-row date-row">';
        echo '<div class="detail-icon-wrap">📅</div>';
        echo '<div class="detail-content">';
        echo '<span class="detail-label">Fechas del curso</span>';
        echo '<div class="detail-value date-range">';

        $has_start = ! empty( $formatted_start );
        $has_end   = ! empty( $formatted_end );

        if ( $has_start ) {
            echo '<span class="date-item">Inicio: <strong>' . esc_html( $formatted_start ) . '</strong></span>';
        }
        if ( $has_start && $has_end ) {
            echo '<span class="date-separator">|</span>';
        }
        if ( $has_end ) {
            echo '<span class="date-item">Finaliza: <strong>' . esc_html( $formatted_end ) . '</strong></span>';
        }

        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    if ( $is_finished ) {
        echo '<div class="detail-row status-row">';
        echo '<div class="detail-icon-wrap" style="color: #8B1A1A; background-color: rgba(139,26,26,0.12);">✓</div>';
        echo '<div class="detail-content">';
        echo '<span class="detail-label">Estado del curso</span>';
        echo '<div class="detail-value"><span class="badge-status-finalizado-tag">✓ Curso Finalizado</span></div>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
}

// ============================================================
// 21. BANDA "FINALIZADO" EN EL BANNER Y MINIATURAS DE CURSOS
// ============================================================

// A) Banda en miniaturas del catálogo de cursos (/cursos/, tienda, categorías, etc.)
add_action( 'woocommerce_before_shop_loop_item_title', 'infosystem_output_catalog_ribbon_finalizado', 9 );
function infosystem_output_catalog_ribbon_finalizado() {
    global $product;
    if ( ! $product ) {
        return;
    }
    if ( infosystem_is_course_finished( $product->get_id() ) ) {
        echo '<div class="infosystem-course-ribbon ribbon-finalizado"><span>FINALIZADO</span></div>';
    }
}

// B) Banda en la imagen destacada/galería de la ficha del curso
add_action( 'woocommerce_before_single_product_summary', 'infosystem_output_single_course_image_ribbon', 5 );
function infosystem_output_single_course_image_ribbon() {
    global $post;
    if ( ! $post ) {
        return;
    }
    if ( infosystem_is_course_finished( $post->ID ) ) {
        echo '<div class="infosystem-course-ribbon ribbon-finalizado"><span>FINALIZADO</span></div>';
    }
}

// C) Banda en el banner superior del curso (Top Banner de cabecera)
add_action( 'wp_footer', 'infosystem_course_top_banner_ribbon_script', 99 );
function infosystem_course_top_banner_ribbon_script() {
    if ( ! is_singular( 'product' ) ) {
        return;
    }
    global $post;
    if ( ! $post || ! infosystem_is_course_finished( $post->ID ) ) {
        return;
    }
    ?>
    <script>
    (function() {
        function injectCourseBannerRibbon() {
            var bannerWrapper = document.querySelector('.top_heading .banner-wrapper') || document.querySelector('.top_site_main .page-title-wrapper') || document.querySelector('.top_site_main');
            if (bannerWrapper && !document.querySelector('.infosystem-top-banner-ribbon')) {
                var ribbon = document.createElement('div');
                ribbon.className = 'infosystem-top-banner-ribbon';
                ribbon.innerHTML = '<span class="ribbon-badge-text"><span class="ribbon-badge-icon">✓</span> FINALIZADO</span>';
                var heading = bannerWrapper.querySelector('.heading_title') || bannerWrapper.querySelector('h1');
                if (heading) {
                    heading.parentNode.insertBefore(ribbon, heading);
                } else {
                    bannerWrapper.insertBefore(ribbon, bannerWrapper.firstChild);
                }
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', injectCourseBannerRibbon);
        } else {
            injectCourseBannerRibbon();
        }
        setTimeout(injectCourseBannerRibbon, 300);
    })();
    </script>
    <?php
}

// D) Estilos CSS globales para las bandas de cursos finalizados
add_action( 'wp_head', 'infosystem_courses_ribbon_styles', 99 );
function infosystem_courses_ribbon_styles() {
    ?>
    <style id="infosystem-course-ribbons-css">
    .product_thumb,
    .content__product,
    .woocommerce-product-gallery,
    .thim-course-media {
        position: relative !important;
        overflow: hidden !important;
    }

    .infosystem-course-ribbon.ribbon-finalizado {
        position: absolute !important;
        top: 20px !important;
        right: -38px !important;
        transform: rotate(45deg) !important;
        background: linear-gradient(135deg, #B22222 0%, #8B1A1A 100%) !important;
        color: #ffffff !important;
        font-size: 11px !important;
        font-weight: 800 !important;
        letter-spacing: 1.5px !important;
        text-transform: uppercase !important;
        padding: 6px 44px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4) !important;
        z-index: 99 !important;
        pointer-events: none !important;
        text-align: center !important;
        line-height: 1.2 !important;
        border-top: 1px solid rgba(255, 255, 255, 0.35) !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.25) !important;
    }

    .infosystem-top-banner-ribbon {
        display: inline-block !important;
        margin-bottom: 14px !important;
    }

    .infosystem-top-banner-ribbon .ribbon-badge-text {
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        background: linear-gradient(135deg, #B22222 0%, #8B1A1A 100%) !important;
        color: #ffffff !important;
        font-size: 13px !important;
        font-weight: 800 !important;
        letter-spacing: 2px !important;
        text-transform: uppercase !important;
        padding: 7px 18px !important;
        border-radius: 30px !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4) !important;
        border: 1.5px solid rgba(255, 255, 255, 0.4) !important;
    }

    .infosystem-top-banner-ribbon .ribbon-badge-icon {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 18px !important;
        height: 18px !important;
        background: rgba(255, 255, 255, 0.25) !important;
        border-radius: 50% !important;
        font-size: 11px !important;
    }

    </style>
    <?php
}

/**
 * =========================================================================
 * BANNER DE COOKIES EN ESPAÑOL (Punto 11 - Cumplimiento RGPD / LSSI-CE)
 * =========================================================================
 * Traduce los botones y textos del banner de cookies (thim-core) a español:
 * ACEPTAR | RECHAZAR | CONFIGURAR (Guardar preferencias).
 * Elimina cualquier término en inglés (Accept, Reject, Preferences, Customise, etc.).
 */
add_filter( 'gettext', function( $translated_text, $text, $domain ) {
    $clean = trim( $text );
    if ( strcasecmp( $clean, 'Customise' ) === 0 || strcasecmp( $clean, 'Customize' ) === 0 ) {
        return 'Configurar';
    }
    if ( strcasecmp( $clean, 'Reject All' ) === 0 ) {
        return 'Rechazar';
    }
    if ( strcasecmp( $clean, 'Accept All' ) === 0 ) {
        return 'Aceptar';
    }
    if ( strcasecmp( $clean, 'Save My Preferences' ) === 0 ) {
        return 'Guardar preferencias';
    }
    if ( strcasecmp( $clean, 'Consent Preferences' ) === 0 ) {
        return 'Preferencias de cookies';
    }
    if ( strcasecmp( $clean, 'Close' ) === 0 ) {
        return 'Cerrar';
    }
    return $translated_text;
}, 99, 3 );

// Actualiza el texto legal y enlace de la primera capa del banner de cookies con entidades HTML seguras
add_filter( 'option_thim_cookie_consent_message', function( $value ) {
    return '<p>Utilizamos cookies propias y de terceros para fines anal&iacute;ticos y para mostrarle publicidad personalizada en base a un perfil elaborado a partir de sus h&aacute;bitos de navegaci&oacute;n. Puede configurar o rechazar las cookies haciendo clic en &laquo;Configurar&raquo; o &laquo;Rechazar&raquo;. Para m&aacute;s informaci&oacute;n, consulte nuestra <a href="https://centrosinfosystem.com/politica-de-cookies/">Pol&iacute;tica de Cookies</a>.</p>';
} );

// Actualiza el texto de configuración/personalización de cookies con entidades HTML seguras
add_filter( 'option_thim_cookie_customise_consent_mess', function( $value ) {
    return '<h4 class="heading-top">Personalizar las preferencias de cookies</h4><p>Utilizamos cookies para facilitar la navegaci&oacute;n y el uso de ciertas funciones. Encontrar&aacute; informaci&oacute;n detallada sobre todas las cookies en cada categor&iacute;a de consentimiento a continuaci&oacute;n.</p><p>{{necesario}}<br />{{anal&iacute;tico}}<br />{{anuncios}}<br />{{funcional}}</p>';
} );

// Reemplazo en búfer de salida para atributos HTML de thimcookie
add_action( 'template_redirect', function() {
    ob_start( function( $html ) {
        if ( ! is_string( $html ) ) return $html;
        $html = str_replace( 'title="Consent Preferences"', 'title="Preferencias de cookies"', $html );
        $html = str_replace( 'title="Close"', 'title="Cerrar"', $html );
        return $html;
    } );
} );

// Script de soporte en pie de página para garantizar interactividad inmediata
add_action( 'wp_footer', function() {
    ?>
    <script>
    (function() {
        var map = {
            'Customise': 'Configurar',
            'Customize': 'Configurar',
            'Reject All': 'Rechazar',
            'Accept All': 'Aceptar',
            'Save My Preferences': 'Guardar preferencias',
            'Consent Preferences': 'Preferencias de cookies'
        };
        function fixCookieLabels() {
            var banner = document.getElementById('thimcookie-banner');
            var modal = document.getElementById('thimcookie-customise');
            var revisit = document.querySelector('.thimcookie-btn-revisit');
            if (revisit) {
                var title = revisit.getAttribute('title');
                if (title && map[title]) {
                    revisit.setAttribute('title', map[title]);
                }
            }
            [banner, modal].forEach(function(el) {
                if (!el) return;
                var btns = el.querySelectorAll('button');
                btns.forEach(function(b) {
                    var txt = b.textContent.trim();
                    if (map[txt]) {
                        b.textContent = map[txt];
                    }
                });
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fixCookieLabels);
        } else {
            fixCookieLabels();
        }
        setTimeout(fixCookieLabels, 500);
        setTimeout(fixCookieLabels, 1500);
    })();
    </script>
    <?php
}, 99 );

/**
 * =========================================================================
 * ELIMINAR SIDEBAR / LATEST POSTS EN TODAS LAS PÁGINAS (ANCHO COMPLETO 100%)
 * =========================================================================
 * Desactiva el sidebar en todas las páginas para que no se muestre el widget
 * 'Latest Posts' y expande el contenido a pantalla completa (100%).
 */
add_filter( 'is_active_sidebar', function( $is_active, $sidebar_id ) {
    if ( is_page() ) {
        return false;
    }
    return $is_active;
}, 99, 2 );

add_action( 'wp_head', function() {
    if ( is_page() ) {
        ?>
        <style id="infosystem-fullwidth-pages">
        /* Quitar sidebar "Latest Posts" en todas las páginas de la web y forzar ancho completo */
        body.page #sidebar,
        body.page .widget-area,
        body.page .sticky-sidebar,
        body.page .col-sm-3.sticky-sidebar,
        body.page aside.col-sm-3,
        body.page aside#secondary {
            display: none !important;
            width: 0 !important;
            max-width: 0 !important;
            flex: 0 0 0% !important;
            overflow: hidden !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        body.page main.site-main,
        body.page .col-sm-9,
        body.page #main.site-main {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding-left: 15px !important;
            padding-right: 15px !important;
        }

        body.page .site-content .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            width: 100% !important;
            display: block !important;
        }
        
        /* ===== QUITAR BANNER SUPERIOR SOBRANTE EN POLÍTICA DE PRIVACIDAD ===== */
        body.page-id-3 .top_heading,
        body.privacy-policy .top_heading,
        body.page-slug-politica-de-privacidad .top_heading {
            display: none !important;
            height: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            overflow: hidden !important;
        }

        /* ==========================================================================
           GLOBAL DARK FOOTER - Centros InfoSystem (Template 8920)
           Diseño oscuro premium, amplios márgenes, espaciado generoso y tipografía nítida
           ========================================================================== */
        .thim-ekit__footer,
        .thim-ekit__footer__inner,
        .elementor-8920 {
            background-color: #121217 !important;
            color: #cbd5e1 !important;
            position: relative !important;
            width: 100% !important;
        }

        .thim-ekit__footer {
            border-top: 3px solid #8B1A1A !important;
            margin-top: 0 !important;
        }

        /* Contenedor principal de 4 columnas (fa9308a) con amplio espaciado */
        .elementor-8920 .elementor-element-fa9308a {
            padding: clamp(65px, 6vw, 90px) 24px clamp(45px, 5vw, 65px) 24px !important;
            max-width: 1240px !important;
            margin: 0 auto !important;
            box-sizing: border-box !important;
        }

        .elementor-8920 .elementor-element-fa9308a > .e-con-inner {
            display: grid !important;
            grid-template-columns: 1.35fr 1.05fr 0.95fr 1.3fr !important;
            gap: clamp(28px, 3.5vw, 55px) !important;
            align-items: start !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Columna 1: Logo, descripción y redes */
        .elementor-8920 .elementor-element-8f4e313 {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            width: 100% !important;
        }

        /* Logo con badge blanco limpio para máximo contraste y nitidez */
        .elementor-8920 .elementor-element-69f4823 {
            margin-bottom: 20px !important;
        }
        .elementor-8920 .elementor-element-69f4823 img {
            background: #ffffff !important;
            padding: 9px 15px !important;
            border-radius: 8px !important;
            max-width: 175px !important;
            height: auto !important;
            display: inline-block !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4) !important;
        }

        /* Texto descriptivo de la columna 1 */
        .elementor-8920 .elementor-element-col0_desc_txt p,
        .elementor-8920 .elementor-element-col0_desc_txt {
            color: #94a3b8 !important;
            font-size: 14.5px !important;
            line-height: 1.7 !important;
            margin: 0 0 22px 0 !important;
            max-width: 320px !important;
        }

        /* Iconos de redes sociales */
        .elementor-8920 .thim-social-media {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            gap: 12px !important;
            padding: 0 !important;
            margin: 0 !important;
            list-style: none !important;
        }

        .elementor-8920 .thim-social-media li {
            margin: 0 !important;
            padding: 0 !important;
        }

        .elementor-8920 .thim-social-media li a {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 40px !important;
            height: 40px !important;
            border-radius: 50% !important;
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #cbd5e1 !important;
            font-size: 16px !important;
            text-decoration: none !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .elementor-8920 .thim-social-media li a:hover {
            background: #8B1A1A !important;
            border-color: #8B1A1A !important;
            color: #ffffff !important;
            transform: translateY(-3px) !important;
            box-shadow: 0 6px 18px rgba(139, 26, 26, 0.45) !important;
        }

        /* Encabezados de columnas (Cursos, Empresa, Centros y contacto) */
        .elementor-8920 .sc_heading,
        .elementor-8920 .sc_heading .title,
        .elementor-8920 h4.title {
            color: #ffffff !important;
            font-size: 17.5px !important;
            font-weight: 700 !important;
            letter-spacing: -0.2px !important;
            margin: 0 0 22px 0 !important;
            text-transform: none !important;
            position: relative !important;
            padding-bottom: 12px !important;
            line-height: 1.3 !important;
        }

        .elementor-8920 .sc_heading .title::after,
        .elementor-8920 h4.title::after {
            content: '' !important;
            position: absolute !important;
            left: 0 !important;
            bottom: 0 !important;
            width: 32px !important;
            height: 2.5px !important;
            background: #D4880A !important;
            border-radius: 2px !important;
        }

        /* Listas de enlaces y datos de contacto */
        .elementor-8920 .elementor-element-fa9308a .thim-header-info {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 13px !important;
        }

        .elementor-8920 .elementor-element-fa9308a .thim-header-info li {
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.5 !important;
        }

        .elementor-8920 .elementor-element-fa9308a .thim-header-info li a {
            color: #cbd5e1 !important;
            font-size: 14.5px !important;
            line-height: 1.55 !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: flex-start !important;
            gap: 10px !important;
            transition: all 0.2s ease !important;
        }

        .elementor-8920 .elementor-element-fa9308a .thim-header-info li a:hover {
            color: #F3B33D !important;
            transform: translateX(4px) !important;
        }

        /* Iconos de contacto (mapa, teléfono, home, sobre) */
        .elementor-8920 .elementor-element-fa9308a .thim-header-info li a span i,
        .elementor-8920 .elementor-element-fa9308a .thim-header-info li a i {
            color: #D4880A !important;
            font-size: 15px !important;
            margin-top: 3px !important;
            flex-shrink: 0 !important;
        }

        /* Enlace de correo protegido */
        .elementor-8920 a.infosystem-protected-email {
            color: #cbd5e1 !important;
            font-size: 14.5px !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
        }
        .elementor-8920 a.infosystem-protected-email:hover {
            color: #F3B33D !important;
            transform: translateX(4px) !important;
        }

        /* Separador horizontal (de57ca8) */
        .elementor-8920 .elementor-element-de57ca8 {
            max-width: 1240px !important;
            margin: 0 auto !important;
            padding: 0 24px !important;
            box-sizing: border-box !important;
        }
        .elementor-8920 .elementor-element-4aa622e .elementor-divider-separator {
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
            margin: 0 !important;
        }

        /* Barra inferior / Colophon (7963a78): Copyright a la izquierda, Enlaces legales a la derecha */
    .elementor-8920 .elementor-element-7963a78 {
        background-color: #0b0b0e !important;
        border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
        padding: 22px 24px 24px 24px !important;
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
    }

    .elementor-8920 .elementor-element-7963a78 > .e-con-inner {
        max-width: 1240px !important;
        margin: 0 auto !important;
        display: flex !important;
        flex-direction: row !important;
        justify-content: space-between !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 20px !important;
    }

    /* Contenedor Copyright (izquierda) */
    .elementor-8920 .elementor-element-57a5349 {
        flex: 0 1 auto !important;
        width: auto !important;
        max-width: 100% !important;
    }

    /* Texto de copyright y autoría */
    .elementor-8920 .elementor-element-82009ac p {
        color: #64748b !important;
        font-size: 13.5px !important;
        margin: 0 !important;
        line-height: 1.6 !important;
    }

    .elementor-8920 .elementor-element-82009ac a {
        color: #D4880A !important;
        font-weight: 600 !important;
        text-decoration: none !important;
    }
    .elementor-8920 .elementor-element-82009ac a:hover {
        color: #F3B33D !important;
    }

    /* Contenedor Enlaces legales (derecha) */
    .elementor-8920 .elementor-element-570f796 {
        flex: 0 1 auto !important;
        width: auto !important;
        max-width: 100% !important;
        margin-left: auto !important;
    }

    .elementor-8920 .elementor-element-570f796 .thim-header-info {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 18px !important;
        margin: 0 !important;
        padding: 0 !important;
        list-style: none !important;
    }

    .elementor-8920 .elementor-element-570f796 .thim-header-info li {
        margin: 0 !important;
        padding: 0 !important;
        display: inline-flex !important;
    }

    .elementor-8920 .elementor-element-570f796 .thim-header-info li a {
        color: #94a3b8 !important;
        font-size: 13px !important;
        text-decoration: none !important;
        transition: color 0.2s ease !important;
        white-space: nowrap !important;
    }

    .elementor-8920 .elementor-element-570f796 .thim-header-info li a:hover {
        color: #D4880A !important;
    }

        /* Enlaces legales (Aviso Legal, Privacidad, Cookies, Calidad) */
        .elementor-8920 .elementor-element-570f796 .thim-header-info {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            gap: clamp(14px, 2vw, 24px) !important;
            align-items: center !important;
        }

        .elementor-8920 .elementor-element-570f796 .thim-header-info li {
            margin: 0 !important;
            padding: 0 !important;
        }

        .elementor-8920 .elementor-element-570f796 .thim-header-info li a {
            color: #94a3b8 !important;
            font-size: 13px !important;
            text-decoration: none !important;
            transition: color 0.2s ease !important;
        }

        .elementor-8920 .elementor-element-570f796 .thim-header-info li a:hover {
            color: #ffffff !important;
            text-decoration: underline !important;
        }

        /* Responsive Footer */
        @media (max-width: 1024px) {
            .elementor-8920 .elementor-element-fa9308a > .e-con-inner {
                grid-template-columns: 1fr 1fr !important;
                gap: 40px !important;
            }
        }

        @media (max-width: 640px) {
            .elementor-8920 .elementor-element-fa9308a > .e-con-inner {
                grid-template-columns: 1fr !important;
                gap: 34px !important;
            }
            .elementor-8920 .elementor-element-7963a78 > .e-con-inner {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 16px !important;
            }
        }

</style>
        <?php
    }
}, 99 );

/**
 * =========================================================================
 * GLOBAL DARK FOOTER - Centros InfoSystem (Template 8920)
 * =========================================================================
 * Diseño oscuro premium con 4 columnas amplias, espaciado generoso
 * y maquetación perfecta sin cortes ni quiebres de línea forzados.
 */
add_action( 'wp_head', function() {
    ?>
    <style id="infosystem-global-dark-footer">
    /* Fondo general del footer y contorno superior */
    .thim-ekit__footer,
    .thim-ekit__footer__inner,
    .elementor-8920 {
        background-color: #121217 !important;
        color: #cbd5e1 !important;
        position: relative !important;
        width: 100% !important;
    }

    .thim-ekit__footer {
        border-top: 3px solid #8B1A1A !important;
        margin-top: 0 !important;
    }

    /* Contenedor principal de 4 columnas (fa9308a) con amplio espaciado */
    .elementor-8920 .elementor-element-fa9308a {
        padding: clamp(65px, 6vw, 90px) 24px clamp(45px, 5vw, 65px) 24px !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 auto !important;
        box-sizing: border-box !important;
    }

    .elementor-8920 .elementor-element-fa9308a > .e-con-inner {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        justify-content: space-between !important;
        align-items: flex-start !important;
        gap: clamp(24px, 3.2vw, 50px) !important;
        width: 100% !important;
        max-width: 1240px !important;
        margin: 0 auto !important;
        box-sizing: border-box !important;
    }

    /* Anular restricciones porcentuales heredadas en las 4 columnas */
    .elementor-8920 .elementor-element-fa9308a > .e-con-inner > .e-con,
    .elementor-8920 .elementor-element-8f4e313,
    .elementor-8920 .elementor-element-d5cd98c,
    .elementor-8920 .elementor-element-6075de2,
    .elementor-8920 .elementor-element-9fd9676 {
        min-width: 0 !important;
        box-sizing: border-box !important;
    }

    /* Columna 1: Logo, descripción y redes (~28% del ancho) */
    .elementor-8920 .elementor-element-8f4e313 {
        flex: 0 0 28% !important;
        width: 28% !important;
        max-width: 320px !important;
        min-width: 250px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
    }

    /* Logo con badge blanco limpio para máximo contraste y nitidez */
    .elementor-8920 .elementor-element-69f4823 {
        margin-bottom: 20px !important;
    }
    .elementor-8920 .elementor-element-69f4823 img {
        background: #ffffff !important;
        padding: 9px 15px !important;
        border-radius: 8px !important;
        max-width: 175px !important;
        height: auto !important;
        display: inline-block !important;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4) !important;
    }

    /* Texto descriptivo de la columna 1 */
    .elementor-8920 .elementor-element-col0_desc_txt p,
    .elementor-8920 .elementor-element-col0_desc_txt {
        color: #94a3b8 !important;
        font-size: 14.5px !important;
        line-height: 1.7 !important;
        margin: 0 0 22px 0 !important;
        max-width: 290px !important;
    }

    /* Iconos de redes sociales */
    .elementor-8920 .thim-social-media {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap !important;
        gap: 12px !important;
        padding: 0 !important;
        margin: 0 !important;
        list-style: none !important;
    }

    .elementor-8920 .thim-social-media li {
        margin: 0 !important;
        padding: 0 !important;
    }

    .elementor-8920 .thim-social-media li a {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 40px !important;
        height: 40px !important;
        border-radius: 50% !important;
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #cbd5e1 !important;
        font-size: 16px !important;
        text-decoration: none !important;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
    }

    .elementor-8920 .thim-social-media li a:hover {
        background: #8B1A1A !important;
        border-color: #8B1A1A !important;
        color: #ffffff !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 6px 18px rgba(139, 26, 26, 0.45) !important;
    }

    /* Columna 2: Cursos (~23% del ancho, espacio suficiente para no cortar) */
    .elementor-8920 .elementor-element-d5cd98c {
        flex: 0 0 23% !important;
        width: 23% !important;
        min-width: 220px !important;
    }

    /* Columna 3: Empresa (~17% del ancho) */
    .elementor-8920 .elementor-element-6075de2 {
        flex: 0 0 17% !important;
        width: 17% !important;
        min-width: 160px !important;
    }

    /* Columna 4: Centros y contacto (~32% del ancho, datos de contacto amplios) */
    .elementor-8920 .elementor-element-9fd9676 {
        flex: 0 0 32% !important;
        width: 32% !important;
        min-width: 280px !important;
    }

    /* Encabezados de columnas (Cursos, Empresa, Centros y contacto) */
    .elementor-8920 .sc_heading,
    .elementor-8920 .sc_heading .title,
    .elementor-8920 h4.title {
        color: #ffffff !important;
        font-size: 17.5px !important;
        font-weight: 700 !important;
        letter-spacing: -0.2px !important;
        margin: 0 0 22px 0 !important;
        text-transform: none !important;
        position: relative !important;
        padding-bottom: 12px !important;
        line-height: 1.3 !important;
        white-space: nowrap !important;
        display: inline-block !important;
    }

    .elementor-8920 .sc_heading .title::after,
    .elementor-8920 h4.title::after {
        content: '' !important;
        position: absolute !important;
        left: 0 !important;
        bottom: 0 !important;
        width: 32px !important;
        height: 2.5px !important;
        background: #D4880A !important;
        border-radius: 2px !important;
    }

    /* Listas de enlaces y datos de contacto */
    .elementor-8920 .elementor-element-fa9308a .thim-header-info {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 13px !important;
        width: 100% !important;
    }

    .elementor-8920 .elementor-element-fa9308a .thim-header-info li {
        margin: 0 !important;
        padding: 0 !important;
        line-height: 1.5 !important;
        width: 100% !important;
    }

    .elementor-8920 .elementor-element-fa9308a .thim-header-info li a {
        color: #cbd5e1 !important;
        font-size: 14.5px !important;
        line-height: 1.55 !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: flex-start !important;
        gap: 10px !important;
        transition: all 0.2s ease !important;
        white-space: normal !important;
        word-break: normal !important;
        overflow-wrap: normal !important;
    }

    .elementor-8920 .elementor-element-fa9308a .thim-header-info li a:hover {
        color: #F3B33D !important;
        transform: translateX(4px) !important;
    }

    /* Iconos de contacto (mapa, teléfono, home, sobre) */
    .elementor-8920 .elementor-element-fa9308a .thim-header-info li a span i,
    .elementor-8920 .elementor-element-fa9308a .thim-header-info li a i {
        color: #D4880A !important;
        font-size: 15px !important;
        margin-top: 3px !important;
        flex-shrink: 0 !important;
    }

    /* Enlace de correo protegido con icono de sobre perfectamente alineado */
    .elementor-8920 a.infosystem-protected-email {
        color: #cbd5e1 !important;
        font-size: 14.5px !important;
        line-height: 1.55 !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: flex-start !important;
        gap: 10px !important;
        transition: all 0.2s ease !important;
        white-space: nowrap !important;
    }
    .elementor-8920 a.infosystem-protected-email::before {
        content: "\e919" !important;
        font-family: "thim-ekits" !important;
        speak: never;
        font-style: normal !important;
        font-weight: 400 !important;
        font-variant: normal !important;
        text-transform: none !important;
        line-height: 1 !important;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #D4880A !important;
        font-size: 15px !important;
        width: 28.75px !important;
        min-width: 28.75px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        flex-shrink: 0 !important;
        margin-top: 2px !important;
    }
    .elementor-8920 a.infosystem-protected-email:hover {
        color: #F3B33D !important;
        transform: translateX(4px) !important;
    }
    .elementor-8920 a.infosystem-protected-email:hover::before {
        color: #F3B33D !important;
    }

    /* Enlace de teléfono (no partirse) */
    .elementor-8920 a[href^="tel:"] {
        color: #cbd5e1 !important;
        font-size: 14.5px !important;
        text-decoration: none !important;
        transition: all 0.2s ease !important;
        white-space: nowrap !important;
    }
    .elementor-8920 a[href^="tel:"]:hover {
        color: #F3B33D !important;
        transform: translateX(4px) !important;
    }

    /* Separador horizontal (de57ca8) */
    .elementor-8920 .elementor-element-de57ca8 {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        background: transparent !important;
        box-sizing: border-box !important;
    }
    .elementor-8920 .elementor-element-de57ca8 > .e-con-inner {
        max-width: 1240px !important;
        margin: 0 auto !important;
        padding: 0 24px !important;
        box-sizing: border-box !important;
    }
    .elementor-8920 .elementor-element-4aa622e .elementor-divider-separator {
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        margin: 0 !important;
    }

    /* Barra inferior / Colophon (7963a78): Copyright a la izquierda, Enlaces legales a la derecha */
    .elementor-8920 .elementor-element-7963a78 {
        background-color: #0b0b0e !important;
        border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
        padding: 22px 24px 24px 24px !important;
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
    }

    .elementor-8920 .elementor-element-7963a78 > .e-con-inner {
        max-width: 1240px !important;
        margin: 0 auto !important;
        display: flex !important;
        flex-direction: row !important;
        justify-content: space-between !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 20px !important;
    }

    /* Contenedor Copyright (izquierda) */
    .elementor-8920 .elementor-element-57a5349 {
        flex: 0 1 auto !important;
        width: auto !important;
        max-width: 100% !important;
    }

    /* Texto de copyright y autoría */
    .elementor-8920 .elementor-element-82009ac p {
        color: #64748b !important;
        font-size: 13.5px !important;
        margin: 0 !important;
        line-height: 1.6 !important;
    }

    .elementor-8920 .elementor-element-82009ac a {
        color: #D4880A !important;
        font-weight: 600 !important;
        text-decoration: none !important;
    }
    .elementor-8920 .elementor-element-82009ac a:hover {
        color: #F3B33D !important;
    }

    /* Contenedor Enlaces legales (derecha) */
    .elementor-8920 .elementor-element-570f796 {
        flex: 0 1 auto !important;
        width: auto !important;
        max-width: 100% !important;
        margin-left: auto !important;
    }

    .elementor-8920 .elementor-element-570f796 .thim-header-info {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 18px !important;
        margin: 0 !important;
        padding: 0 !important;
        list-style: none !important;
    }

    .elementor-8920 .elementor-element-570f796 .thim-header-info li {
        margin: 0 !important;
        padding: 0 !important;
        display: inline-flex !important;
    }

    .elementor-8920 .elementor-element-570f796 .thim-header-info li a {
        color: #94a3b8 !important;
        font-size: 13px !important;
        text-decoration: none !important;
        transition: color 0.2s ease !important;
        white-space: nowrap !important;
    }

    .elementor-8920 .elementor-element-570f796 .thim-header-info li a:hover {
        color: #D4880A !important;
    }

    /* Enlaces legales (Aviso Legal, Privacidad, Cookies, Calidad) */
    .elementor-8920 .elementor-element-570f796 .thim-header-info {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap !important;
        gap: clamp(14px, 2vw, 24px) !important;
        align-items: center !important;
    }

    .elementor-8920 .elementor-element-570f796 .thim-header-info li {
        margin: 0 !important;
        padding: 0 !important;
    }

    .elementor-8920 .elementor-element-570f796 .thim-header-info li a {
        color: #94a3b8 !important;
        font-size: 13px !important;
        text-decoration: none !important;
        transition: color 0.2s ease !important;
    }

    .elementor-8920 .elementor-element-570f796 .thim-header-info li a:hover {
        color: #ffffff !important;
        text-decoration: underline !important;
    }

    /* Responsive Footer Tablet */
    @media (max-width: 1024px) {
        .elementor-8920 .elementor-element-fa9308a > .e-con-inner {
            flex-wrap: wrap !important;
            gap: 40px !important;
        }
        .elementor-8920 .elementor-element-8f4e313,
        .elementor-8920 .elementor-element-d5cd98c,
        .elementor-8920 .elementor-element-6075de2,
        .elementor-8920 .elementor-element-9fd9676 {
            width: calc(50% - 20px) !important;
            max-width: calc(50% - 20px) !important;
            flex: 0 0 calc(50% - 20px) !important;
            min-width: 0 !important;
        }
    }

    /* Responsive Footer Móvil */
    @media (max-width: 640px) {
        .elementor-8920 .elementor-element-fa9308a > .e-con-inner {
            flex-direction: column !important;
            gap: 36px !important;
        }
        .elementor-8920 .elementor-element-8f4e313,
        .elementor-8920 .elementor-element-d5cd98c,
        .elementor-8920 .elementor-element-6075de2,
        .elementor-8920 .elementor-element-9fd9676 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 1 1 100% !important;
        }
        .elementor-8920 .elementor-element-7963a78 > .e-con-inner {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 16px !important;
        }
    }

    </style>
    <?php
}, 999 );


// ============================================================
// 20. WIDGET FLOTANTE WHATSAPP (8:00h - 20:00h) + CHATBOT IA FUERA DE HORARIO
// ============================================================


/**
 * Infosystem - Widget Flotante de WhatsApp + Chatbot IA Fuera de Horario (Diseño Circular Elegante)
 *
 * Horario activo: 08:00h a 20:00h (Europe/Madrid) -> Atención directa por WhatsApp (+34 619 06 19 33)
 * Fuera de horario: 20:00h a 08:00h -> Chatbot con IA para resolver dudas y agendar citas a info@centrosinfosystem.com
 *
 * @package EdumaChild
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. REGISTRO DE ENDPOINTS REST API
add_action( 'rest_api_init', 'infosystem_register_bot_rest_routes' );

function infosystem_register_bot_rest_routes() {
    register_rest_route( 'infosystem/v1', '/bot-chat', array(
        'methods'             => 'POST',
        'callback'            => 'infosystem_handle_bot_chat',
        'permission_callback' => '__return_true',
    ) );

    register_rest_route( 'infosystem/v1', '/bot-schedule', array(
        'methods'             => 'POST',
        'callback'            => 'infosystem_handle_bot_schedule',
        'permission_callback' => '__return_true',
    ) );
}

/**
 * Procesa mensajes del chatbot (vía Gemini API o motor de conocimiento local)
 */
function infosystem_handle_bot_chat( WP_REST_Request $request ) {
    $params = $request->get_json_params();
    $message = isset( $params['message'] ) ? sanitize_text_field( $params['message'] ) : '';

    if ( empty( $message ) ) {
        return new WP_REST_Response( array( 'reply' => 'Por favor, escribe tu consulta o duda.' ), 200 );
    }

    // 1. Comprobar si hay clave de Google Gemini API configurada
    $gemini_key = defined( 'GEMINI_API_KEY' ) ? GEMINI_API_KEY : get_option( 'infosystem_gemini_api_key', '' );
    
    if ( ! empty( $gemini_key ) ) {
        $ai_reply = infosystem_call_gemini_api( $message, $gemini_key );
        if ( ! empty( $ai_reply ) ) {
            return new WP_REST_Response( array( 'reply' => $ai_reply ), 200 );
        }
    }

    // 2. Motor de respuesta inteligente estructurado (Fallback 100% fiable sin coste)
    $reply = infosystem_local_smart_reply( $message );
    return new WP_REST_Response( array( 'reply' => $reply ), 200 );
}

/**
 * Llamada a la API oficial de Google Gemini (Free Tier)
 */
function infosystem_call_gemini_api( $user_message, $api_key ) {
    $system_prompt = "Eres el Asistente Virtual Inteligente de 'Centros Infosystem' (Centro de Educación Polivalente en Castilla-La Mancha).
Horario de atención humana presencial y WhatsApp: 8:00h a 20:00h.
Teléfono y WhatsApp: +34 619 06 19 33.
Teléfono fijo: +34 926 33 11 62.
Email: info@centrosinfosystem.com.
Sede principal: Calle Cruz de Piedra, 13, 13730 Santa Cruz de Mudela (Ciudad Real) y centros asociados en la provincia.
Cursos: 100% gratuitos y subvencionados por el SEPE y la Junta de Comunidades de Castilla-La Mancha (JCCM). Ofrecemos Certificados de Profesionalidad oficiales en Gestión Contable, Ofimática, Informática, Formación Ocupacional, etc.
Destinatarios: Personas desempleadas, trabajadoras o autónomas en Castilla-La Mancha.
Objetivo: Responde con amabilidad, en español, de forma concisa y profesional (máximo 2-3 párrafos). Si el usuario desea matricularse o ser contactado, invítale a usar el botón de 'Agendar llamada' del chat o dejar un mensaje al WhatsApp 619 06 19 33 o info@centrosinfosystem.com.";

    $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . urlencode( $api_key );

    $payload = array(
        'contents' => array(
            array(
                'role'  => 'user',
                'parts' => array(
                    array( 'text' => $system_prompt . "\n\nPregunta del usuario: " . $user_message )
                )
            )
        ),
        'generationConfig' => array(
            'temperature'     => 0.4,
            'maxOutputTokens' => 350,
        )
    );

    $response = wp_remote_post( $endpoint, array(
        'headers' => array( 'Content-Type' => 'application/json' ),
        'body'    => wp_json_encode( $payload ),
        'timeout' => 15,
    ) );

    if ( is_wp_error( $response ) ) {
        return false;
    }

    $body = json_decode( wp_remote_retrieve_body( $response ), true );
    if ( ! empty( $body['candidates'][0]['content']['parts'][0]['text'] ) ) {
        return trim( $body['candidates'][0]['content']['parts'][0]['text'] );
    }

    return false;
}

/**
 * Motor de conocimiento local de Centros Infosystem
 */
function infosystem_local_smart_reply( $msg ) {
    $m = mb_strtolower( $msg, 'UTF-8' );

    // Detección de intención
    if ( strpos( $m, 'precio' ) !== false || strpos( $m, 'cuesta' ) !== false || strpos( $m, 'gratis' ) !== false || strpos( $m, 'coste' ) !== false || strpos( $m, 'pagar' ) !== false ) {
        return "¡Todos nuestros cursos son <strong>100% gratuitos y subvencionados</strong>! Están financiados por la Junta de Comunidades de Castilla-La Mancha y el SEPE, por lo que no tienen ningún coste para ti. Incluyen material oficial y expedición de Certificado de Profesionalidad.";
    }

    if ( strpos( $m, 'horario' ) !== false || strpos( $m, 'abierto' ) !== false || strpos( $m, 'hora' ) !== false || strpos( $m, 'atienden' ) !== false ) {
        return "Nuestro horario de atención personalizada en oficinas, teléfono y WhatsApp es de <strong>Lunes a Viernes de 08:00h a 20:00h</strong>. Fuera de este horario, puedes pulsar en <strong>'Agendar llamada'</strong> para que te llamemos a primera hora, o dejarnos tu consulta en info@centrosinfosystem.com.";
    }

    if ( strpos( $m, 'donde' ) !== false || strpos( $m, 'dirección' ) !== false || strpos( $m, 'direccion' ) !== false || strpos( $m, 'sede' ) !== false || strpos( $m, 'ubicacion' ) !== false || strpos( $m, 'centros' ) !== false ) {
        return "Nuestra sede principal se encuentra en <strong>Calle Cruz de Piedra, 13, Santa Cruz de Mudela (Ciudad Real)</strong>. También impartimos formación y disponemos de aulas homologadas en diversos centros de la provincia. ¡Puedes agendar una visita o llamarnos al <strong>+34 619 06 19 33</strong>!";
    }

    if ( strpos( $m, 'requisito' ) !== false || strpos( $m, 'paro' ) !== false || strpos( $m, 'trabajador' ) !== false || strpos( $m, 'desempleado' ) !== false || strpos( $m, 'autonomo' ) !== false ) {
        return "Disponemos de programas formativos dirigidos tanto a <strong>personas desempleadas</strong> inscritas en el SEPE/CLM, como a <strong>trabajadores en activo y autónomos</strong> que buscan mejorar su perfil profesional. Para saber qué curso se adapta a tu situación, pulsa en 'Agendar llamada' y te orientaremos sin compromiso.";
    }

    if ( strpos( $m, 'curso' ) !== false || strpos( $m, 'ofimatica' ) !== false || strpos( $m, 'gestion' ) !== false || strpos( $m, 'informatica' ) !== false || strpos( $m, 'catalogo' ) !== false ) {
        return "Contamos con una amplia oferta de <strong>Certificados de Profesionalidad</strong> en áreas como Gestión Contable y Administrativa, Ofimática Avanzada, Informática, Competencias Digitales y sectores clave. Puedes consultar todo el catálogo en la sección <strong>Cursos</strong> del menú superior o solicitar que te enviemos el programa completo a tu email.";
    }

    if ( strpos( $m, 'contacto' ) !== false || strpos( $m, 'telefono' ) !== false || strpos( $m, 'llamar' ) !== false || strpos( $m, 'cita' ) !== false || strpos( $m, 'agendar' ) !== false || strpos( $m, 'apuntar' ) !== false ) {
        return "¡Estaremos encantados de atenderte! Puedes pulsar el botón <strong>'📅 Agendar que me llamen'</strong> aquí abajo para indicarnos tu teléfono y hora preferida, o si lo prefieres, escribirnos directamente al correo <strong>info@centrosinfosystem.com</strong> o llamar al <strong>+34 619 06 19 33</strong> a partir de las 8:00h.";
    }

    return "Gracias por contactar con Centros Infosystem. Fuera de nuestro horario habitual (8:00h - 20:00h), puedo ayudarte con información de nuestros cursos 100% subvencionados por el SEPE/JCCM, requisitos y sedes. También puedes pulsar en <strong>'📅 Agendar que me llamen'</strong> para que un asesor contacte contigo en cuanto abramos.";
}

/**
 * Procesa la solicitud de agendamiento de llamada / cita
 */
function infosystem_handle_bot_schedule( WP_REST_Request $request ) {
    $params = $request->get_json_params();

    $nombre   = isset( $params['nombre'] ) ? sanitize_text_field( $params['nombre'] ) : '';
    $telefono = isset( $params['telefono'] ) ? sanitize_text_field( $params['telefono'] ) : '';
    $email    = isset( $params['email'] ) ? sanitize_email( $params['email'] ) : '';
    $horario  = isset( $params['horario'] ) ? sanitize_text_field( $params['horario'] ) : 'Indiferente';
    $curso    = isset( $params['curso'] ) ? sanitize_text_field( $params['curso'] ) : 'Información general';

    if ( empty( $nombre ) || empty( $telefono ) ) {
        return new WP_REST_Response( array(
            'success' => false,
            'message' => 'Por favor, indícanos al menos tu nombre y un teléfono de contacto.'
        ), 400 );
    }

    $to = 'info@centrosinfosystem.com';
    $subject = '=?UTF-8?B?' . base64_encode( '[Infosystem Web] Nueva solicitud de cita/llamada (Asistente IA)' ) . '?=';

    $body = "<h2>Nueva solicitud de contacto desde el Asistente Virtual Web</h2>\n";
    $body .= "<p>Se ha recibido una petición de llamada/cita fuera de horario laboral:</p>\n";
    $body .= "<ul>\n";
    $body .= "<li><strong>Nombre:</strong> " . esc_html( $nombre ) . "</li>\n";
    $body .= "<li><strong>Teléfono:</strong> <a href='tel:" . esc_attr( preg_replace( '/[^0-9+]/', '', $telefono ) ) . "'>" . esc_html( $telefono ) . "</a></li>\n";
    if ( ! empty( $email ) ) {
        $body .= "<li><strong>Email:</strong> " . esc_html( $email ) . "</li>\n";
    }
    $body .= "<li><strong>Franja preferida de llamada:</strong> " . esc_html( $horario ) . "</li>\n";
    $body .= "<li><strong>Interés formativo / Curso:</strong> " . esc_html( $curso ) . "</li>\n";
    $body .= "<li><strong>Fecha y hora de registro:</strong> " . current_time( 'd/m/Y H:i' ) . "</li>\n";
    $body .= "</ul>\n";
    $body .= "<p style='color:#666;font-size:12px;'>Este mensaje ha sido generado automáticamente por el Asistente Inteligente de centrosinfosystem.com</p>";

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Centros Infosystem Web <info@centrosinfosystem.com>',
    );
    if ( ! empty( $email ) ) {
        $headers[] = 'Reply-To: ' . $email;
    }

    $sent = wp_mail( $to, $subject, $body, $headers );

    return new WP_REST_Response( array(
        'success' => true,
        'message' => '¡Solicitud registrada correctamente! Nuestro equipo se pondrá en contacto contigo a primera hora. También puedes escribirnos a info@centrosinfosystem.com o enviar un WhatsApp al 619 06 19 33.'
    ), 200 );
}

// 2. RENDERIZADO DEL WIDGET EN EL FRONTEND
add_action( 'wp_footer', 'infosystem_render_whatsapp_bot', 99 );

function infosystem_render_whatsapp_bot() {
    if ( is_admin() || ( function_exists( 'elementor_location_exits' ) && false ) ) {
        return;
    }

    // Calcular si estamos en horario activo según hora de Madrid (8:00 a 20:00)
    $tz = new DateTimeZone( 'Europe/Madrid' );
    $now = new DateTime( 'now', $tz );
    $hour = (int) $now->format( 'H' );
    $is_active = ( $hour >= 8 && $hour < 20 );
    $wa_number = '34619061933';
    $wa_display = '+34 619 06 19 33';
    ?>
    <!-- INFOSYSTEM WHATSAPP & ASISTENTE IA WIDGET (DISEÑO CIRCULAR ELEGANTE) -->
    <div id="infosystem-wa-widget" class="infosystem-wa-widget" data-active="<?php echo $is_active ? '1' : '0'; ?>">
        <!-- Tooltip flotante discreto -->
        <div id="infosystem-wa-tooltip" class="infosystem-wa-tooltip">
            <span id="infosystem-wa-tooltip-text"><?php echo $is_active ? '¿Tienes dudas? Chatea con nosotros' : '¿Dudas sobre cursos? Pregunta a la IA'; ?></span>
            <button type="button" id="infosystem-wa-tooltip-close" aria-label="Cerrar aviso">×</button>
        </div>

        <!-- Botón Flotante Circular Launcher (FAB) -->
        <button id="infosystem-wa-launcher" class="infosystem-wa-launcher" type="button" aria-label="Abrir WhatsApp o Asistente de Centros Infosystem">
            <span class="infosystem-wa-badge-text"><?php echo $is_active ? '🟢 8h-20h' : '🌙 IA 24h'; ?></span>
            <span class="infosystem-wa-icon">
                <!-- SVG WhatsApp Oficial Limpio -->
                <svg viewBox="0 0 32 32" width="32" height="32" fill="#ffffff">
                    <path d="M16 2a13.9 13.9 0 0 0-12 21L2 30l7.2-1.9A14 14 0 1 0 16 2zm0 25.5a11.5 11.5 0 0 1-5.9-1.6l-.4-.3-4.4 1.1 1.2-4.2-.3-.5A11.5 11.5 0 1 1 16 27.5zm6.4-8.6c-.4-.2-2.1-1-2.4-1.2s-.6-.2-.8.2-.9 1.2-1.1 1.4-.4.2-.8 0a9.8 9.8 0 0 1-2.9-1.8 10.9 10.9 0 0 1-2-2.5c-.2-.4 0-.6.2-.8s.4-.4.5-.6.2-.4.3-.6 0-.4 0-.6-.8-1.9-1.1-2.6c-.3-.7-.6-.6-.8-.6h-.7c-.2 0-.7.1-1.1.5s-1.5 1.5-1.5 3.6 1.5 4.2 1.7 4.5 3 4.6 7.3 6.4c1 .4 1.8.7 2.4.9 1 .3 2 .3 2.7.2.8-.1 2.5-1 2.8-2s.4-1.8.3-2-.5-.3-.9-.5z"/>
                </svg>
            </span>
        </button>

        <!-- Ventana Modal de Chat -->
        <div id="infosystem-wa-modal" class="infosystem-wa-modal" aria-hidden="true">
            <!-- Header Modal -->
            <div class="infosystem-wa-modal-header">
                <div class="infosystem-wa-header-info">
                    <div class="infosystem-wa-avatar">
                        <img src="https://centrosinfosystem.com/wp-content/uploads/2020/03/centrosinfosystem-fabicon-1-180x180.png" alt="Centros Infosystem" class="infosystem-wa-avatar-img">
                        <span class="infosystem-wa-avatar-status <?php echo $is_active ? 'status-online' : 'status-ai'; ?>"></span>
                    </div>
                    <div class="infosystem-wa-titles">
                        <h4>Centros Infosystem</h4>
                        <p class="infosystem-wa-status-label">
                            <?php if ( $is_active ) : ?>
                                <span class="dot-green">●</span> En directo · Asesoría de 8:00h a 20:00h
                            <?php else : ?>
                                <span class="dot-amber">●</span> Asistente IA · Fuera de horario (8h a 20h)
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                <button id="infosystem-wa-close" class="infosystem-wa-close-btn" type="button" aria-label="Cerrar ventana">×</button>
            </div>

            <!-- Cuerpo Modal: Modo Horario Diurno (8:00h a 20:00h) -->
            <div id="infosystem-mode-active" class="infosystem-wa-body <?php echo $is_active ? 'is-visible' : 'is-hidden'; ?>">
                <div class="infosystem-wa-speech-bubble">
                    <p>¡Hola! 👋 Te damos la bienvenida a <strong>Centros Infosystem</strong>.</p>
                    <p>Nuestro equipo de admisiones y orientación formativa está disponible ahora mismo para informarte sobre <strong>cursos 100% subvencionados</strong> (SEPE/JCCM), requisitos y matriculación.</p>
                </div>

                <div class="infosystem-wa-actions">
                    <a href="https://wa.me/<?php echo esc_attr( $wa_number ); ?>?text=Hola%20Centros%20Infosystem,%20me%20gustar%C3%ADa%20recibir%20informaci%C3%B3n%20sobre%20los%20cursos%20subvencionados." 
                       target="_blank" rel="noopener noreferrer" class="infosystem-wa-btn-primary">
                        <svg viewBox="0 0 32 32" width="20" height="20" fill="currentColor">
                            <path d="M16 2a13.9 13.9 0 0 0-12 21L2 30l7.2-1.9A14 14 0 1 0 16 2zm0 25.5a11.5 11.5 0 0 1-5.9-1.6l-.4-.3-4.4 1.1 1.2-4.2-.3-.5A11.5 11.5 0 1 1 16 27.5z"/>
                        </svg>
                        <span>Chatear por WhatsApp (<?php echo esc_html( $wa_display ); ?>)</span>
                    </a>

                    <a href="tel:<?php echo esc_attr( $wa_number ); ?>" class="infosystem-wa-btn-secondary">
                        📞 Llamar por teléfono (+34 619 06 19 33)
                    </a>
                </div>

                <div class="infosystem-wa-quick-questions">
                    <p class="infosystem-wa-quick-title">Preguntas frecuentes rápidas:</p>
                    <button type="button" class="infosystem-wa-chip" data-msg="Hola, quiero información sobre los cursos disponibles en Infosystem">📚 Cursos disponibles</button>
                    <button type="button" class="infosystem-wa-chip" data-msg="Hola, ¿cuáles son los requisitos para acceder a los cursos 100% gratuitos?">❓ Requisitos de acceso</button>
                    <button type="button" class="infosystem-wa-chip" data-msg="Hola, me gustaría información sobre las sedes de Centros Infosystem en Ciudad Real y Mudela">📍 Sedes y centros</button>
                </div>

                <div class="infosystem-wa-footer-links">
                    <span>Email directo: <a href="mailto:info@centrosinfosystem.com">info@centrosinfosystem.com</a></span>
                </div>
            </div>

            <!-- Cuerpo Modal: Modo Fuera de Horario (20:00h a 08:00h) con Chatbot IA y Agendamiento -->
            <div id="infosystem-mode-night" class="infosystem-wa-body <?php echo ! $is_active ? 'is-visible' : 'is-hidden'; ?>">
                <div class="infosystem-wa-night-notice">
                    <span class="moon-icon">🌙</span>
                    <div>
                        <strong>Atención personalizada: 8:00h a 20:00h</strong>
                        <p>Fuera de horario, nuestro Asistente con IA te ayuda a resolver dudas y agendar citas.</p>
                    </div>
                </div>

                <div id="infosystem-chat-messages" class="infosystem-chat-messages">
                    <div class="chat-msg bot-msg">
                        ¡Hola! Soy el <strong>Asistente Virtual con IA</strong> de Centros Infosystem.
                        Puedo responder tus dudas sobre nuestros cursos 100% gratuitos o <strong>ayudarte a agendar una llamada</strong> para cuando nuestro equipo inicie jornada a las 8:00h.
                    </div>
                </div>

                <!-- Botones de Acción Rápida del Bot -->
                <div id="infosystem-bot-pills" class="infosystem-bot-pills">
                    <button type="button" class="bot-pill pill-schedule" id="btn-show-schedule">📅 Agendar que me llamen</button>
                    <button type="button" class="bot-pill" data-ask="¿Los cursos son 100% gratuitos?">💶 ¿Son gratuitos?</button>
                    <button type="button" class="bot-pill" data-ask="¿Qué cursos tenéis disponibles?">🎓 Cursos disponibles</button>
                    <button type="button" class="bot-pill" data-ask="¿Dónde están vuestros centros formativos?">📍 Dónde estamos</button>
                </div>

                <!-- Formulario Embebido de Agendamiento -->
                <div id="infosystem-schedule-card" class="infosystem-schedule-card" style="display:none;">
                    <div class="schedule-card-header">
                        <h5>📅 Agendar llamada con Asesor</h5>
                        <button type="button" id="btn-close-schedule" class="schedule-card-close" aria-label="Cerrar formulario">×</button>
                    </div>
                    <form id="infosystem-schedule-form">
                        <div class="schedule-field">
                            <label for="sched-name">Tu nombre *</label>
                            <input type="text" id="sched-name" required placeholder="Ej. Carlos Martínez">
                        </div>
                        <div class="schedule-field">
                            <label for="sched-phone">Teléfono de contacto *</label>
                            <input type="tel" id="sched-phone" required placeholder="Ej. 619 06 19 33">
                        </div>
                        <div class="schedule-field">
                            <label for="sched-time">Horario preferido de llamada</label>
                            <select id="sched-time">
                                <option value="Mañana (08:00 - 14:00)">Mañana (08:00 a 14:00)</option>
                                <option value="Tarde (14:00 - 20:00)">Tarde (14:00 a 20:00)</option>
                                <option value="Lo antes posible">Lo antes posible (desde las 8:00)</option>
                            </select>
                        </div>
                        <div class="schedule-field">
                            <label for="sched-course">Curso de interés (opcional)</label>
                            <input type="text" id="sched-course" placeholder="Ej. Gestión Contable, Ofimática...">
                        </div>
                        <button type="submit" id="sched-submit-btn" class="sched-submit-btn">Solicitar llamada a primera hora</button>
                        <p id="sched-feedback" class="sched-feedback"></p>
                    </form>
                </div>

                <!-- Input del Chat -->
                <form id="infosystem-chat-form" class="infosystem-chat-input-bar">
                    <input type="text" id="infosystem-chat-input" placeholder="Escribe tu pregunta aquí..." autocomplete="off">
                    <button type="submit" id="infosystem-chat-send" class="infosystem-chat-send-btn" aria-label="Enviar mensaje">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="send-icon-svg">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2" fill="#ffffff"></polygon>
                        </svg>
                    </button>
                </form>

                <!-- Canales Alternativos Fuera de Horario -->
                <div class="infosystem-night-fallbacks">
                    <a href="https://wa.me/<?php echo esc_attr( $wa_number ); ?>?text=Hola,%20les%20dejo%20este%20mensaje%20fuera%20de%20horario%20para%20que%20me%20respondan%20en%20cuanto%20abran." 
                       target="_blank" rel="noopener noreferrer" class="night-link-wa">
                        💬 Dejar mensaje en WhatsApp
                    </a>
                    <span>·</span>
                    <a href="mailto:info@centrosinfosystem.com" class="night-link-mail">✉️ info@centrosinfosystem.com</a>
                </div>
            </div>
        </div>
    </div>

    <!-- ESTILOS Y COMPORTAMIENTO NATIVO ELEGANTE (WPO & SIN BLOQUEO) -->
    <style id="infosystem-wa-styles">
        .infosystem-wa-widget {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 999999;
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        /* Tooltip flotante refinado */
        .infosystem-wa-tooltip {
            position: absolute;
            bottom: 74px;
            right: 0;
            background: #ffffff;
            color: #1e293b;
            padding: 8px 14px 8px 16px;
            border-radius: 999px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.14);
            border: 1px solid rgba(212, 136, 10, 0.28);
            font-size: 12.5px;
            font-weight: 600;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: wa-float-subtle 3s ease-in-out infinite alternate;
            pointer-events: auto;
            cursor: pointer;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .infosystem-wa-tooltip::after {
            content: '';
            position: absolute;
            bottom: -6px;
            right: 24px;
            width: 11px;
            height: 11px;
            background: #ffffff;
            transform: rotate(45deg);
            border-bottom: 1px solid rgba(212, 136, 10, 0.28);
            border-right: 1px solid rgba(212, 136, 10, 0.28);
        }
        .infosystem-wa-tooltip button {
            background: transparent;
            border: none;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }
        .infosystem-wa-tooltip button:hover { color: #475569; }
        @keyframes wa-float-subtle {
            0% { transform: translateY(0); }
            100% { transform: translateY(-4px); }
        }

        /* Botón Circular Launcher (FAB) */
        .infosystem-wa-launcher {
            position: relative;
            width: 60px;
            height: 60px;
            border-radius: 50% !important;
            padding: 0 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(140deg, #25D366 0%, #128C7E 100%) !important;
            box-shadow: 0 10px 26px -2px rgba(18, 140, 126, 0.52), 0 4px 12px rgba(0, 0, 0, 0.15) !important;
            border: 2.5px solid rgba(255, 255, 255, 0.5) !important;
            cursor: pointer;
            outline: none;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }
        .infosystem-wa-launcher:hover {
            transform: translateY(-4px) scale(1.06) !important;
            box-shadow: 0 16px 32px -2px rgba(18, 140, 126, 0.62), 0 6px 16px rgba(0, 0, 0, 0.18) !important;
        }
        .infosystem-wa-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
        }

        /* Badge elegante micro-pill */
        .infosystem-wa-badge-text {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #0f172a;
            color: #fbbf24;
            border: 1.5px solid #d97706;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 999px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.28);
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .infosystem-wa-widget[data-active="1"] .infosystem-wa-badge-text {
            background: #ffffff;
            color: #0f766e;
            border: 1.5px solid #25D366;
            box-shadow: 0 3px 8px rgba(37, 211, 102, 0.35);
        }

        /* Modal Container */
        .infosystem-wa-modal {
            display: none;
            position: absolute;
            bottom: 74px;
            right: 0;
            width: 375px;
            max-width: calc(100vw - 36px);
            height: 540px;
            max-height: calc(100vh - 110px);
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 16px 45px rgba(0, 0, 0, 0.22);
            overflow: hidden;
            flex-direction: column;
            border: 1px solid rgba(212, 136, 10, 0.22);
            box-sizing: border-box;
            opacity: 0;
            transform: translateY(15px) scale(0.96);
            transition: opacity 0.25s ease, transform 0.25s ease;
        }
        .infosystem-wa-modal.is-open {
            display: flex;
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Header */
        .infosystem-wa-modal-header {
            background: linear-gradient(135deg, #8B1A1A 0%, #520F0F 100%);
            color: #ffffff;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #D4880A;
        }
        .infosystem-wa-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .infosystem-wa-avatar {
            position: relative;
            width: 44px;
            height: 44px;
            background: #ffffff;
            border: 2px solid #D4880A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            flex-shrink: 0;
            overflow: visible;
        }
        .infosystem-wa-avatar-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }
        .infosystem-wa-avatar-status {
            position: absolute;
            bottom: -1px;
            right: -1px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid #8B1A1A;
            z-index: 2;
        }
        .status-online { background: #25D366; }
        .status-ai { background: #F3B33D; }

        .infosystem-wa-titles h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            font-family: 'Merriweather', Georgia, serif;
        }
        .infosystem-wa-status-label {
            margin: 2px 0 0 0;
            font-size: 11.5px;
            color: #f1f5f9;
            opacity: 0.92;
        }
        .dot-green { color: #4ade80; font-size: 13px; }
        .dot-amber { color: #fde047; font-size: 13px; }

        .infosystem-wa-close-btn {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 26px;
            line-height: 1;
            cursor: pointer;
            padding: 4px 8px;
            opacity: 0.8;
            transition: opacity 0.2s;
        }
        .infosystem-wa-close-btn:hover { opacity: 1; }

        /* Body */
        .infosystem-wa-body {
            padding: 18px;
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            background: #f8fafc;
            box-sizing: border-box;
        }
        .infosystem-wa-body.is-hidden { display: none !important; }
        .infosystem-wa-body.is-visible { display: flex !important; }

        .infosystem-wa-speech-bubble {
            background: #ffffff;
            padding: 15px 16px;
            border-radius: 14px 14px 14px 3px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
            font-size: 13.5px;
            line-height: 1.5;
            color: #334155;
            margin-bottom: 16px;
            border-left: 3.5px solid #8B1A1A;
        }
        .infosystem-wa-speech-bubble p { margin: 0 0 8px 0; }
        .infosystem-wa-speech-bubble p:last-child { margin: 0; }

        .infosystem-wa-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 16px;
        }
        .infosystem-wa-btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: linear-gradient(135deg, #25D366 0%, #1ebd5a 100%);
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 700;
            padding: 13px 18px;
            border-radius: 999px;
            text-decoration: none !important;
            box-shadow: 0 4px 14px rgba(37, 211, 102, 0.35);
            transition: all 0.2s ease;
        }
        .infosystem-wa-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(37, 211, 102, 0.45);
        }
        .infosystem-wa-btn-secondary {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            color: #475569 !important;
            font-size: 13px;
            font-weight: 600;
            padding: 10px 14px;
            border-radius: 999px;
            border: 1px solid #cbd5e1;
            text-decoration: none !important;
            transition: background 0.2s;
        }
        .infosystem-wa-btn-secondary:hover { background: #f1f5f9; color: #1e293b !important; }

        .infosystem-wa-quick-questions {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
        }
        .infosystem-wa-quick-title {
            font-size: 11.5px;
            font-weight: 700;
            color: #64748b;
            margin: 0 0 8px 0;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .infosystem-wa-chip {
            display: block;
            width: 100%;
            text-align: left;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            color: #334155;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12.5px;
            margin-bottom: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .infosystem-wa-chip:hover {
            background: #f8fafc;
            border-color: #8B1A1A;
            color: #8B1A1A;
            transform: translateX(3px);
        }
        .infosystem-wa-footer-links {
            text-align: center;
            font-size: 11.5px;
            color: #94a3b8;
            margin-top: 10px;
        }
        .infosystem-wa-footer-links a { color: #8B1A1A; text-decoration: none; font-weight: 600; }

        /* MODO NOCHE / ASISTENTE IA */
        .infosystem-wa-night-notice {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fef3c7;
            border-left: 3.5px solid #d97706;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 12px;
            font-size: 12px;
            color: #92400e;
            line-height: 1.35;
        }
        .infosystem-wa-night-notice .moon-icon { font-size: 18px; }
        .infosystem-wa-night-notice p { margin: 2px 0 0 0; }

        .infosystem-chat-messages {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 9px;
            padding-right: 4px;
            margin-bottom: 10px;
        }
        .chat-msg {
            max-width: 85%;
            padding: 10px 14px;
            font-size: 13px;
            line-height: 1.45;
            border-radius: 14px;
            word-wrap: break-word;
        }
        .bot-msg {
            align-self: flex-start;
            background: #ffffff;
            color: #1e293b;
            border-radius: 14px 14px 14px 2px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .user-msg {
            align-self: flex-end;
            background: #8B1A1A;
            color: #ffffff;
            border-radius: 14px 14px 2px 14px;
        }

        .infosystem-bot-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 10px;
        }
        .bot-pill {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #334155;
            font-size: 11.5px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 999px;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .bot-pill:hover {
            border-color: #8B1A1A;
            color: #8B1A1A;
            background: #fdf2f2;
        }
        .pill-schedule {
            background: #fef2f2;
            border-color: #8B1A1A;
            color: #8B1A1A;
            font-weight: 700;
        }

        /* Input bar */
        .infosystem-chat-input-bar {
            display: flex;
            gap: 6px;
            margin-bottom: 10px;
        }
        .infosystem-chat-input-bar input {
            flex: 1;
            height: 38px;
            border: 1.5px solid #cbd5e1;
            border-radius: 999px;
            padding: 0 14px;
            font-size: 13px;
            background: #ffffff;
            outline: none;
            transition: border-color 0.2s;
        }
        .infosystem-chat-input-bar input:focus {
            border-color: #8B1A1A;
        }
        .infosystem-chat-input-bar button,
        button.infosystem-chat-send-btn,
        #infosystem-chat-send {
            width: 40px !important;
            height: 40px !important;
            min-width: 40px !important;
            max-width: 40px !important;
            border-radius: 50% !important;
            background: linear-gradient(135deg, #8B1A1A 0%, #6e1313 100%) !important;
            color: #ffffff !important;
            border: 1.5px solid rgba(255, 255, 255, 0.4) !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
            box-shadow: 0 3px 10px rgba(139, 26, 26, 0.35) !important;
            transition: all 0.2s ease !important;
            flex-shrink: 0 !important;
        }
        .infosystem-chat-input-bar button:hover,
        button.infosystem-chat-send-btn:hover,
        #infosystem-chat-send:hover {
            background: linear-gradient(135deg, #a12020 0%, #7e1616 100%) !important;
            transform: scale(1.05) !important;
            box-shadow: 0 4px 14px rgba(139, 26, 26, 0.45) !important;
        }
        .infosystem-chat-send-btn .send-icon-svg {
            display: block !important;
            width: 18px !important;
            height: 18px !important;
            margin-left: 2px !important;
            filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.3)) !important;
        }

        /* Schedule Card Form */
        .infosystem-schedule-card {
            background: #ffffff;
            border: 1.5px solid #D4880A;
            border-radius: 14px;
            padding: 14px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 10px;
        }
        .schedule-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .schedule-card-header h5 {
            margin: 0;
            font-size: 13.5px;
            color: #8B1A1A;
            font-weight: 700;
        }
        .schedule-card-close {
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #64748b;
        }
        .schedule-field {
            margin-bottom: 8px;
        }
        .schedule-field label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 3px;
        }
        .schedule-field input, .schedule-field select {
            width: 100%;
            height: 34px;
            padding: 0 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 12.5px;
            box-sizing: border-box;
            outline: none;
        }
        .schedule-field input:focus, .schedule-field select:focus {
            border-color: #8B1A1A;
        }
        .sched-submit-btn {
            width: 100%;
            height: 38px;
            background: linear-gradient(135deg, #8B1A1A 0%, #6d1313 100%);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 4px;
            transition: background 0.2s;
        }
        .sched-submit-btn:hover { background: #5a0e0e; }
        .sched-feedback {
            font-size: 11.5px;
            margin: 6px 0 0 0;
            text-align: center;
        }
        .sched-feedback.success { color: #16a34a; font-weight: 600; }
        .sched-feedback.error { color: #dc2626; }

        .infosystem-night-fallbacks {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 11.5px;
            color: #64748b;
            padding-top: 6px;
            border-top: 1px solid #e2e8f0;
        }
        .night-link-wa { color: #15803d; font-weight: 600; text-decoration: none; }
        .night-link-mail { color: #8B1A1A; font-weight: 600; text-decoration: none; }
    </style>

    <script id="infosystem-wa-js">
    (function() {
        // Determinación horaria dinámica (Europe/Madrid)
        function checkMadridActiveHours() {
            try {
                var d = new Intl.DateTimeFormat('es-ES', { timeZone: 'Europe/Madrid', hour: 'numeric', hour12: false });
                var h = parseInt(d.format(new Date()), 10);
                return (h >= 8 && h < 20);
            } catch (e) {
                var localH = new Date().getHours();
                return (localH >= 8 && localH < 20);
            }
        }

        var widget = document.getElementById('infosystem-wa-widget');
        var launcher = document.getElementById('infosystem-wa-launcher');
        var modal = document.getElementById('infosystem-wa-modal');
        var closeBtn = document.getElementById('infosystem-wa-close');
        var modeActive = document.getElementById('infosystem-mode-active');
        var modeNight = document.getElementById('infosystem-mode-night');
        var tooltip = document.getElementById('infosystem-wa-tooltip');
        var tooltipClose = document.getElementById('infosystem-wa-tooltip-close');
        var tooltipText = document.getElementById('infosystem-wa-tooltip-text');

        function updateWidgetHours() {
            var active = checkMadridActiveHours();
            widget.setAttribute('data-active', active ? '1' : '0');
            var badgeText = launcher.querySelector('.infosystem-wa-badge-text');
            var statusDot = modal.querySelector('.infosystem-wa-avatar-status');
            var statusLabel = modal.querySelector('.infosystem-wa-status-label');

            if (active) {
                badgeText.innerHTML = '🟢 8h-20h';
                statusDot.className = 'infosystem-wa-avatar-status status-online';
                statusLabel.innerHTML = '<span class="dot-green">●</span> En directo · Asesoría de 8:00h a 20:00h';
                if (tooltipText) tooltipText.textContent = '¿Tienes dudas? Chatea con nosotros';
                modeActive.classList.add('is-visible');
                modeActive.classList.remove('is-hidden');
                modeNight.classList.remove('is-visible');
                modeNight.classList.add('is-hidden');
            } else {
                badgeText.innerHTML = '🌙 IA 24h';
                statusDot.className = 'infosystem-wa-avatar-status status-ai';
                statusLabel.innerHTML = '<span class="dot-amber">●</span> Asistente IA · Fuera de horario (8h a 20h)';
                if (tooltipText) tooltipText.textContent = '¿Dudas sobre cursos? Pregunta a la IA';
                modeActive.classList.remove('is-visible');
                modeActive.classList.add('is-hidden');
                modeNight.classList.add('is-visible');
                modeNight.classList.remove('is-hidden');
            }
        }

        // Toggle modal
        launcher.addEventListener('click', function() {
            if (tooltip) tooltip.style.display = 'none';
            updateWidgetHours();
            var isOpen = modal.classList.contains('is-open');
            if (isOpen) {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
            } else {
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
            }
        });

        if (tooltip) {
            tooltip.addEventListener('click', function(e) {
                if (e.target !== tooltipClose) {
                    launcher.click();
                }
            });
        }
        if (tooltipClose) {
            tooltipClose.addEventListener('click', function(e) {
                e.stopPropagation();
                tooltip.style.display = 'none';
            });
        }

        closeBtn.addEventListener('click', function() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        });

        // Chips diurnos preparan mensaje de WhatsApp
        var chips = document.querySelectorAll('.infosystem-wa-chip');
        chips.forEach(function(chip) {
            chip.addEventListener('click', function() {
                var text = encodeURIComponent(this.getAttribute('data-msg'));
                window.open('https://wa.me/34619061933?text=' + text, '_blank', 'noopener,noreferrer');
            });
        });

        // Toggle Formulario de Agendar en Chatbot
        var btnShowSched = document.getElementById('btn-show-schedule');
        var btnCloseSched = document.getElementById('btn-close-schedule');
        var schedCard = document.getElementById('infosystem-schedule-card');
        if (btnShowSched && schedCard) {
            btnShowSched.addEventListener('click', function() {
                schedCard.style.display = 'block';
                document.getElementById('sched-name').focus();
            });
        }
        if (btnCloseSched && schedCard) {
            btnCloseSched.addEventListener('click', function() {
                schedCard.style.display = 'none';
            });
        }

        // Enviar Formulario de Agendamiento
        var schedForm = document.getElementById('infosystem-schedule-form');
        if (schedForm) {
            schedForm.addEventListener('submit', function(e) {
                e.preventDefault();
                var feedback = document.getElementById('sched-feedback');
                var submitBtn = document.getElementById('sched-submit-btn');
                submitBtn.disabled = true;
                submitBtn.textContent = 'Enviando solicitud...';
                feedback.className = 'sched-feedback';
                feedback.textContent = '';

                var payload = {
                    nombre: document.getElementById('sched-name').value,
                    telefono: document.getElementById('sched-phone').value,
                    horario: document.getElementById('sched-time').value,
                    curso: document.getElementById('sched-course').value
                };

                fetch('/wp-json/infosystem/v1/bot-schedule', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Solicitar llamada a primera hora';
                    if (data.success) {
                        feedback.className = 'sched-feedback success';
                        feedback.textContent = '¡Cita solicitada! Te llamaremos al teléfono facilitado.';
                        setTimeout(function() {
                            schedCard.style.display = 'none';
                            schedForm.reset();
                            appendChatMessage('bot', '✅ <strong>¡Solicitud de cita registrada con éxito!</strong> Nos pondremos en contacto contigo en el horario solicitado (' + payload.horario + ') al teléfono <strong>' + payload.telefono + '</strong>. Si necesitas algo urgente, puedes escribirnos a info@centrosinfosystem.com.');
                        }, 1200);
                    } else {
                        feedback.className = 'sched-feedback error';
                        feedback.textContent = data.message || 'Ocurrió un error al enviar.';
                    }
                })
                .catch(function() {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Solicitar llamada a primera hora';
                    feedback.className = 'sched-feedback error';
                    feedback.textContent = 'No se pudo conectar con el servidor. Inténtalo por email.';
                });
            });
        }

        // Enviar Mensajes en Chatbot
        var chatMessages = document.getElementById('infosystem-chat-messages');
        var chatForm = document.getElementById('infosystem-chat-form');
        var chatInput = document.getElementById('infosystem-chat-input');

        function appendChatMessage(sender, html) {
            var div = document.createElement('div');
            div.className = 'chat-msg ' + (sender === 'user' ? 'user-msg' : 'bot-msg');
            div.innerHTML = html;
            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function handleUserQuestion(text) {
            if (!text || !text.trim()) return;
            appendChatMessage('user', text);
            chatInput.value = '';

            // Mostrar estado "pensando"
            var typing = document.createElement('div');
            typing.className = 'chat-msg bot-msg';
            typing.id = 'bot-typing-indicator';
            typing.textContent = 'Escribiendo...';
            chatMessages.appendChild(typing);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            fetch('/wp-json/infosystem/v1/bot-chat', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: text })
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                var t = document.getElementById('bot-typing-indicator');
                if (t) t.remove();
                appendChatMessage('bot', data.reply || 'He recibido tu mensaje. Si deseas que te llamemos, pulsa en "📅 Agendar que me llamen".');
            })
            .catch(function() {
                var t = document.getElementById('bot-typing-indicator');
                if (t) t.remove();
                appendChatMessage('bot', 'No he podido procesar la respuesta en este momento. Por favor, pulsa en <strong>"📅 Agendar que me llamen"</strong> o déjanos un mensaje en WhatsApp al <strong>619 06 19 33</strong>.');
            });
        }

        if (chatForm) {
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                handleUserQuestion(chatInput.value);
            });
        }

        // Pills fuera de horario
        var botPills = document.querySelectorAll('.infosystem-bot-pills .bot-pill[data-ask]');
        botPills.forEach(function(pill) {
            pill.addEventListener('click', function() {
                handleUserQuestion(this.getAttribute('data-ask'));
            });
        });

        // Comprobación inicial
        updateWidgetHours();
        setInterval(updateWidgetHours, 60000);
    })();
    </script>
    <?php
}
