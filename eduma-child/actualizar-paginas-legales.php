<?php
/**
 * Script de actualización automática de maquetación y contenido de páginas legales.
 * Este archivo se eliminará automáticamente tras su ejecución.
 */

// Cargar WordPress desde la raíz (subir 3 niveles desde wp-content/themes/infosystem-child-theme)
$wp_load_path = dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';
if (!file_exists($wp_load_path)) {
    die('Error: No se pudo cargar wp-load.php');
}
require_once($wp_load_path);

global $wpdb;

// Estilos CSS comunes para maquetar bonito las páginas normativas
$common_css = '<style>
.legal-header {
    text-align: center;
    padding: 60px 20px;
    background: linear-gradient(135deg, #8B1A1A 0%, #4A0E0E 100%);
    color: #ffffff;
    border-radius: 12px;
    margin-bottom: 40px;
    border-bottom: 4px solid #D4880A;
}
.legal-header h1 {
    color: #ffffff !important;
    font-family: \'Merriweather\', Georgia, serif;
    font-size: clamp(1.8rem, 4vw, 2.6rem) !important;
    margin-bottom: 15px !important;
    font-weight: 800;
}
.legal-header p {
    color: #E8A020;
    font-size: 1.1rem;
    margin: 0;
    font-weight: 600;
}
.legal-container {
    max-width: 960px;
    margin: 0 auto 60px;
    padding: 45px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(139,26,26,0.05);
    border: 1px solid rgba(212,136,10,0.18);
    box-sizing: border-box;
}
@media (max-width: 768px) {
    .legal-container {
        padding: 24px;
        margin-bottom: 30px;
    }
}
.legal-section {
    margin-bottom: 35px;
    padding-bottom: 25px;
    border-bottom: 1px solid rgba(139,26,26,0.08);
}
.legal-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}
.legal-section h2 {
    color: #8B1A1A !important;
    font-family: \'Merriweather\', Georgia, serif;
    font-size: 1.4rem !important;
    margin-top: 0 !important;
    margin-bottom: 20px !important;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 700;
    line-height: 1.3;
}
.legal-section p, .legal-section li {
    font-size: 1.05rem;
    line-height: 1.75;
    color: #444444;
}
.legal-section ul {
    padding-left: 20px;
    margin-top: 10px;
    margin-bottom: 15px;
}
.legal-section li {
    margin-bottom: 8px;
}
.legal-card {
    background: #FDFBF7;
    border-left: 4px solid #D4880A;
    padding: 24px;
    border-radius: 6px;
    margin: 24px 0;
}
.legal-card ul {
    margin: 0;
    padding-left: 15px;
}
.legal-card li {
    margin-bottom: 10px;
}
.legal-card li:last-child {
    margin-bottom: 0;
}
.legal-section table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    margin-bottom: 15px;
}
.legal-section th, .legal-section td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #eeeeee;
}
.legal-section th {
    border-bottom: 2px solid #8B1A1A;
    font-weight: 700;
    color: #8B1A1A;
}
</style>';

// Contenido de Aviso Legal
$aviso_legal_html = $common_css . '
<div class="legal-header">
    <h1>Aviso Legal y Condiciones de Uso</h1>
    <p>Última actualización: Junio 2026</p>
</div>
<div class="legal-container">
    <div class="legal-section">
        <h2>⚖️ 1. Datos Identificativos</h2>
        <p>En cumplimiento con el deber de información recogido en el artículo 10 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y del Comercio Electrónico (LSSI-CE), a continuación se detallan los datos del titular del sitio web:</p>
        <div class="legal-card">
            <ul>
                <li><strong>Razón Social:</strong> Centro Polivalente Infosystem Sociedad Limitada</li>
                <li><strong>Nombre Comercial:</strong> Centros InfoSystem</li>
                <li><strong>NIF:</strong> B13456249</li>
                <li><strong>Dirección Postal:</strong> Calle Cruz de Piedra, 13, 13730 Santa Cruz de Mudela (Ciudad Real)</li>
                <li><strong>Teléfono:</strong> +34 926 33 11 62</li>
                <li><strong>Email de contacto:</strong> info@cursosinfosystem.com / info@infosystem.net</li>
                <li><strong>Homologación oficial:</strong> Centro acreditado por la Junta de Comunidades de Castilla-La Mancha y el SEPE.</li>
            </ul>
        </div>
    </div>
    <div class="legal-section">
        <h2>👥 2. Condiciones de Uso del Portal</h2>
        <p>El acceso y/o uso de este portal web atribuye la condición de USUARIO, que acepta, desde dicho acceso y/o uso, las Condiciones Generales de Uso aquí reflejadas. Las presentes condiciones serán de aplicación independiente de las Condiciones Generales de Contratación que en su caso resulten de obligado cumplimiento.</p>
    </div>
    <div class="legal-section">
        <h2>🔒 3. Uso del Portal y Obligaciones</h2>
        <p>El portal proporciona acceso a multitud de informaciones, servicios, programas o datos (en adelante, "los contenidos") en Internet pertenecientes a Centro Polivalente Infosystem S.L. El USUARIO asume la responsabilidad del uso del portal. El USUARIO se compromete a hacer un uso adecuado de los contenidos y servicios que se ofrecen y a no emplearlos para:</p>
        <ul>
            <li>Incurrir en actividades ilícitas, ilegales o contrarias a la buena fe y al orden público.</li>
            <li>Difundir contenidos o propaganda de carácter racista, xenófobo, pornográfico-ilegal, de apología del terrorismo o atentatorio contra los derechos humanos.</li>
            <li>Provocar daños en los sistemas físicos y lógicos de Centros InfoSystem, de sus proveedores o de terceras personas.</li>
        </ul>
    </div>
    <div class="legal-section">
        <h2>📝 4. Propiedad Intelectual e Industrial</h2>
        <p>Centro Polivalente Infosystem S.L. por sí o como cesionaria, es propietaria de todos los derechos de propiedad intelectual e industrial de su página web, así como de los elementos contenidos en ella (a título enunciativo, imágenes, sonido, audio, vídeo, software o textos; marcas o logotipos, combinaciones de colores, estructura y diseño, selección de materiales usados, etc.).</p>
        <p>Quedan expresamente prohibidas la reproducción, la distribución y la comunicación pública, incluida su modalidad de puesta a disposición, de la totalidad o parte de los contenidos de esta página web, con fines comerciales, en cualquier soporte y por cualquier medio técnico, sin la autorización previa y por escrito de la empresa.</p>
    </div>
    <div class="legal-section">
        <h2>⚠️ 5. Exclusión de Garantías y Responsabilidad</h2>
        <p>Centros InfoSystem no se hace responsable, en ningún caso, de los daños y perjuicios de cualquier naturaleza que pudieran ocasionar, a título enunciativo: errores u omisiones en los contenidos, falta de disponibilidad del portal o la transmisión de virus o programas maliciosos o lesivos en los contenidos, a pesar de haber adoptado todas las medidas tecnológicas necesarias para evitarlo.</p>
    </div>
    <div class="legal-section">
        <h2>🔗 6. Enlaces y Hipervínculos</h2>
        <p>En el caso de que en este sitio web se dispusiesen enlaces o hipervínculos hacía otros sitios de Internet, Centros InfoSystem no ejercerá ningún tipo de control sobre dichos sitios y contenidos. En ningún caso asumirá responsabilidad alguna por los contenidos de algún enlace perteneciente a un sitio web ajeno, ni garantizará la disponibilidad técnica, calidad, fiabilidad, exactitud o constitucionalidad de cualquier material o información contenido en ninguno de dichos hipervínculos.</p>
    </div>
    <div class="legal-section">
        <h2>🇪🇸 7. Legislación Aplicable y Jurisdicción</h2>
        <p>La relación entre Centros InfoSystem y el USUARIO se regirá por la normativa española vigente y cualquier controversia se someterá a los Juzgados y Tribunales competentes de la provincia de Ciudad Real, renunciando expresamente a cualquier otro fuero que pudiera corresponderles.</p>
    </div>
</div>';

// Contenido de Política de Privacidad
$privacidad_html = $common_css . '
<div class="legal-header">
    <h1>Política de Privacidad y Protección de Datos</h1>
    <p>Última actualización: Junio 2026</p>
</div>
<div class="legal-container">
    <div class="legal-section">
        <h2>👤 1. Responsable del Tratamiento de Datos</h2>
        <p>En cumplimiento del Reglamento (UE) 2016/679 (RGPD) y la Ley Orgánica 3/2018 (LOPDGDD), le informamos que el responsable del tratamiento de sus datos personales es:</p>
        <div class="legal-card">
            <ul>
                <li><strong>Identidad:</strong> Centro Polivalente Infosystem Sociedad Limitada</li>
                <li><strong>NIF:</strong> B13456249</li>
                <li><strong>Dirección:</strong> Calle Cruz de Piedra, 13, 13730 Santa Cruz de Mudela (Ciudad Real)</li>
                <li><strong>Teléfono:</strong> +34 926 33 11 62</li>
                <li><strong>Email:</strong> info@cursosinfosystem.com / info@infosystem.net</li>
            </ul>
        </div>
    </div>
    <div class="legal-section">
        <h2>🎯 2. ¿Con qué finalidad tratamos sus datos?</h2>
        <p>Tratamos la información que nos facilitan las personas interesadas con las siguientes finalidades:</p>
        <ul>
            <li>Gestionar y tramitar las solicitudes de información sobre nuestros cursos formativos.</li>
            <li>Gestionar las inscripciones y la matriculación oficial de los alumnos en los cursos gratuitos (subvencionados) y privados.</li>
            <li>Cumplir con las obligaciones de registro y control exigidas por la Junta de Comunidades de Castilla-La Mancha y el SEPE para los programas oficiales de formación para el empleo.</li>
        </ul>
    </div>
    <div class="legal-section">
        <h2>📋 3. Base de Legitimación</h2>
        <p>La legitimación para el tratamiento de sus datos varía según el contacto:</p>
        <ul>
            <li><strong>Consentimiento del interesado:</strong> Al enviar formularios de contacto, solicitar información o marcar explícitamente la casilla de consentimiento.</li>
            <li><strong>Relación precontractual/contractual:</strong> Al realizar el proceso de inscripción y matrícula en un curso.</li>
            <li><strong>Obligación legal:</strong> Para la tramitación oficial de la formación subvencionada ante las administraciones públicas competentes.</li>
        </ul>
    </div>
    <div class="legal-section">
        <h2>🛡️ 4. Plazo de Conservación de los Datos</h2>
        <p>Los datos personales proporcionados se conservarán durante el tiempo necesario para cumplir con la finalidad para la que se recaban y para determinar las posibles responsabilidades que se pudieran derivar de dicha finalidad. En el caso de cursos oficiales subvencionados, los plazos están determinados por la normativa autonómica y estatal de subvenciones públicas.</p>
    </div>
    <div class="legal-section">
        <h2>🏢 5. ¿A qué destinatarios se comunicarán sus datos?</h2>
        <p>Los datos personales no se comunicarán a terceros ajenos a la organización, salvo obligación legal. En el caso de alumnos inscritos en cursos subvencionados oficiales, los datos se comunicarán obligatoriamente a la Consejería de Economía, Empresas y Empleo de Castilla-La Mancha y al SEPE con el fin de tramitar su matrícula y titulación oficial.</p>
    </div>
    <div class="legal-section">
        <h2>🔑 6. Sus Derechos como Interesado</h2>
        <p>Usted tiene derecho a obtener confirmación sobre si estamos tratando datos personales que le conciernen, o no. Los interesados tienen derecho a:</p>
        <ul>
            <li>Acceder a sus datos personales.</li>
            <li>Solicitar la rectificación de los datos inexactos.</li>
            <li>Solicitar su supresión cuando, entre otros motivos, los datos ya no sean necesarios para los fines que fueron recogidos.</li>
            <li>Solicitar la limitación de su tratamiento, en cuyo caso únicamente los conservaremos para el ejercicio o la defensa de reclamaciones.</li>
            <li>Oponerse al tratamiento de sus datos.</li>
        </ul>
        <p>Para ejercer estos derechos, puede dirigir una comunicación escrita a <strong>info@cursosinfosystem.com</strong> o a nuestra dirección postal, acompañando copia de su DNI o documento equivalente para acreditar su identidad.</p>
    </div>
</div>';

// Contenido de Política de Cookies
$cookies_html = $common_css . '
<div class="legal-header">
    <h1>Política de Cookies y Navegación Web</h1>
    <p>Última actualización: Junio 2026</p>
</div>
<div class="legal-container">
    <div class="legal-section">
        <h2>🍪 1. ¿Qué es una Cookie?</h2>
        <p>Una "cookie" es un pequeño archivo de texto que se descarga en su ordenador, tablet o smartphone al acceder a determinadas páginas web. Permiten a una web, entre otras cosas, almacenar y recuperar información sobre los hábitos de navegación de un usuario o de su equipo y facilitar su navegación.</p>
    </div>
    <div class="legal-section">
        <h2>🔍 2. Tipos de Cookies que Utiliza esta Web</h2>
        <p>Nuestra web utiliza cookies propias y de terceros para optimizar su experiencia de navegación:</p>
        <ul>
            <li><strong>Cookies Técnicas y de Seguridad:</strong> Son indispensables para el correcto funcionamiento del sitio. Permiten la navegación a través de la web, garantizan la seguridad y gestionan las sesiones de usuario en la zona privada o plataforma de cursos.</li>
            <li><strong>Cookies de Personalización:</strong> Permiten recordar las preferencias del usuario (como idioma, tamaño de letra, etc.) en futuras visitas.</li>
            <li><strong>Cookies de Análisis (de terceros):</strong> Recopilan información estadística anónima sobre el número de visitantes, duración de la visita, páginas más vistas, navegadores utilizados y origen de las visitas con el fin de mejorar nuestro portal.</li>
        </ul>
    </div>
    <div class="legal-section">
        <h2>⚙️ 3. Detalle de Cookies Utilizadas</h2>
        <p>En cumplimiento con las directrices de la Agencia Española de Protección de Datos (AEPD), detallamos las cookies empleadas:</p>
        <div class="legal-card">
            <table>
                <thead>
                    <tr>
                        <th>Origen</th>
                        <th>Cookie</th>
                        <th>Duración</th>
                        <th>Propósito</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Propias (WordPress)</td>
                        <td>wordpress_sec_ / wordpress_logged_in_</td>
                        <td>Sesión</td>
                        <td>Mantener la sesión del usuario iniciada de forma segura.</td>
                    </tr>
                    <tr>
                        <td>Propias (WooCommerce)</td>
                        <td>woocommerce_cart_hash / woocommerce_items_in_cart</td>
                        <td>Sesión</td>
                        <td>Recordar los cursos del carrito de compra o inscripción.</td>
                    </tr>
                    <tr>
                        <td>Terceros (Google)</td>
                        <td>_ga / _gid</td>
                        <td>Hasta 2 años</td>
                        <td>Google Analytics: análisis estadístico anónimo de visitas y tráfico.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="legal-section">
        <h2>🛠️ 4. ¿Cómo Administrar o Desactivar las Cookies?</h2>
        <p>Usted puede permitir, bloquear o eliminar las cookies instaladas en su equipo mediante la configuración de las opciones del navegador que utilice en su dispositivo. A continuación le facilitamos los enlaces oficiales de configuración para los principales navegadores:</p>
        <ul>
            <li><strong>Google Chrome:</strong> <a href="https://support.google.com/chrome/answer/95647?hl=es" target="_blank" rel="noopener">Configurar Cookies en Chrome</a></li>
            <li><strong>Apple Safari:</strong> <a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac" target="_blank" rel="noopener">Configurar Cookies en Safari</a></li>
            <li><strong>Mozilla Firefox:</strong> <a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias" target="_blank" rel="noopener">Configurar Cookies en Firefox</a></li>
            <li><strong>Microsoft Edge:</strong> <a href="https://support.microsoft.com/es-es/windows/eliminar-y-administrar-cookies-168dab11-0753-043d-7c16-ede5947fc64d" target="_blank" rel="noopener">Configurar Cookies en Edge</a></li>
        </ul>
    </div>
</div>';

// Función para generar la estructura JSON de Elementor
function gen_elementor_data($html) {
    $elementor_structure = array(
        array(
            'id' => uniqid(),
            'elType' => 'container',
            'settings' => array(
                'content_width' => 'full',
                'gap' => 'no',
                'padding' => array(
                    'top' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'right' => '0',
                    'unit' => 'px',
                    'isLinked' => true
                )
            ),
            'elements' => array(
                array(
                    'id' => uniqid(),
                    'elType' => 'widget',
                    'widgetType' => 'text-editor',
                    'settings' => array(
                        'editor' => $html
                    ),
                    'elements' => array()
                )
            ),
            'isInner' => false
        )
    );
    return json_encode($elementor_structure);
}

// Mapeo de slugs de páginas a su correspondiente contenido y títulos
$pages_to_update = array(
    'aviso-legal' => array('title' => 'Aviso legal', 'html' => $aviso_legal_html),
    'politica-de-privacidad' => array('title' => 'Política de privacidad', 'html' => $privacidad_html),
    'politica-de-cookies' => array('title' => 'Política de Cookies', 'html' => $cookies_html)
);

echo "<html><head><title>Actualización de Páginas Legales</title>";
echo "<style>body{font-family:Arial,sans-serif;background:#F8F5F0;color:#2C2C2C;padding:40px;} .box{background:#fff;border-radius:8px;padding:30px;max-width:600px;margin:0 auto;box-shadow:0 4px 20px rgba(139,26,26,0.15);border-top:5px solid #8B1A1A;} h2{color:#8B1A1A;margin-top:0;} .success{color:#D4880A;font-weight:bold;margin-bottom:10px;}</style></head><body>";
echo "<div class='box'>";
echo "<h2>Actualización de Páginas Legales (Aviso, Privacidad, Cookies)</h2>";

foreach ($pages_to_update as $slug => $data) {
    // Buscar la página por su slug (post_name)
    $page = get_page_by_path($slug);
    
    // Si es política de cookies, también probar sin 'de-' por si acaso
    if (!$page && $slug === 'politica-de-cookies') {
        $page = get_page_by_path('politica-cookies');
    }
    
    if ($page) {
        $post_id = $page->ID;
        
        // 1. Actualizar el contenido HTML fallback en la tabla wp_posts
        $wpdb->update(
            "{$wpdb->prefix}posts",
            array(
                'post_content' => $data['html'],
                'post_title' => $data['title']
            ),
            array('ID' => $post_id)
        );
        
        // 2. Establecer la plantilla de Elementor Ancho Completo para quitar la barra lateral
        update_post_meta($post_id, '_wp_page_template', 'elementor_header_footer');
        
        // 3. Forzar el modo de edición con Elementor
        update_post_meta($post_id, '_elementor_edit_mode', 'builder');
        
        // 4. Actualizar los bloques JSON de Elementor
        $elementor_data = gen_elementor_data($data['html']);
        update_post_meta($post_id, '_elementor_data', $elementor_data);
        
        echo "<div class='success'>✓ Actualizada con éxito: " . esc_html($data['title']) . " (ID: {$post_id})</div>";
    } else {
        echo "<div style='color:red;'>✗ No se encontró la página con el slug: {$slug}</div>";
    }
}

// Limpiar la caché CSS de Elementor para regenerar estilos
if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->posts_css_manager->clear_cache();
    echo "<p>✓ Caché CSS de Elementor regenerada correctamente.</p>";
}

echo "<p style='margin-top:20px;font-style:italic;color:#666;'>El script se autoliquidará ahora por motivos de seguridad...</p>";
echo "</div></body></html>";

// Autoliquidar el archivo por seguridad
@unlink(__FILE__);
