<?php
/**
 * Infosystem - Widget Flotante de WhatsApp + Chatbot IA Fuera de Horario
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
    <!-- INFOSYSTEM WHATSAPP & ASISTENTE IA WIDGET -->
    <div id="infosystem-wa-widget" class="infosystem-wa-widget" data-active="<?php echo $is_active ? '1' : '0'; ?>">
        <!-- Botón Flotante Launcher -->
        <button id="infosystem-wa-launcher" class="infosystem-wa-launcher" type="button" aria-label="Abrir WhatsApp o Asistente de Centros Infosystem">
            <span class="infosystem-wa-status-badge <?php echo $is_active ? 'active-hours' : 'night-hours'; ?>"></span>
            <span class="infosystem-wa-icon">
                <!-- SVG WhatsApp Oficial -->
                <svg viewBox="0 0 32 32" width="34" height="34" fill="#ffffff">
                    <path d="M16 2a13.9 13.9 0 0 0-12 21L2 30l7.2-1.9A14 14 0 1 0 16 2zm0 25.5a11.5 11.5 0 0 1-5.9-1.6l-.4-.3-4.4 1.1 1.2-4.2-.3-.5A11.5 11.5 0 1 1 16 27.5zm6.4-8.6c-.4-.2-2.1-1-2.4-1.2s-.6-.2-.8.2-.9 1.2-1.1 1.4-.4.2-.8 0a9.8 9.8 0 0 1-2.9-1.8 10.9 10.9 0 0 1-2-2.5c-.2-.4 0-.6.2-.8s.4-.4.5-.6.2-.4.3-.6 0-.4 0-.6-.8-1.9-1.1-2.6c-.3-.7-.6-.6-.8-.6h-.7c-.2 0-.7.1-1.1.5s-1.5 1.5-1.5 3.6 1.5 4.2 1.7 4.5 3 4.6 7.3 6.4c1 .4 1.8.7 2.4.9 1 .3 2 .3 2.7.2.8-.1 2.5-1 2.8-2s.4-1.8.3-2-.5-.3-.9-.5z"/>
                </svg>
            </span>
            <span class="infosystem-wa-badge-text"><?php echo $is_active ? 'WhatsApp' : 'IA 24h'; ?></span>
        </button>

        <!-- Ventana Modal de Chat -->
        <div id="infosystem-wa-modal" class="infosystem-wa-modal" aria-hidden="true">
            <!-- Header Modal -->
            <div class="infosystem-wa-modal-header">
                <div class="infosystem-wa-header-info">
                    <div class="infosystem-wa-avatar">
                        <span>IS</span>
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
                    <button type="submit" id="infosystem-chat-send" aria-label="Enviar mensaje">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
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

    <!-- ESTILOS Y COMPORTAMIENTO NATIVO (WPO & SIN BLOQUEO) -->
    <style id="infosystem-wa-styles">
        .infosystem-wa-widget {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 999999;
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        .infosystem-wa-launcher {
            display: flex;
            align-items: center;
            gap: 9px;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            color: #ffffff;
            border: none;
            border-radius: 999px;
            padding: 11px 18px 11px 13px;
            cursor: pointer;
            box-shadow: 0 6px 22px rgba(18, 140, 126, 0.42);
            transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.25s ease;
        }
        .infosystem-wa-launcher:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 10px 28px rgba(18, 140, 126, 0.52);
        }
        .infosystem-wa-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
        }
        .infosystem-wa-badge-text {
            font-size: 14.5px;
            font-weight: 700;
            letter-spacing: 0.2px;
            white-space: nowrap;
        }
        .infosystem-wa-status-badge {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #4ade80;
            box-shadow: 0 0 0 2.5px rgba(255, 255, 255, 0.85);
            animation: pulse-green 2s infinite;
        }
        .infosystem-wa-status-badge.night-hours {
            background: #fbbf24;
            animation: pulse-amber 2.5s infinite;
        }
        @keyframes pulse-green {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(74, 222, 128, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(74, 222, 128, 0); }
        }
        @keyframes pulse-amber {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(251, 191, 36, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(251, 191, 36, 0); }
        }

        /* Modal Container */
        .infosystem-wa-modal {
            display: none;
            position: absolute;
            bottom: 70px;
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
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.15);
            border: 1.5px solid #D4880A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
            color: #ffffff;
            letter-spacing: 0.5px;
        }
        .infosystem-wa-avatar-status {
            position: absolute;
            bottom: -1px;
            right: -1px;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            border: 2px solid #8B1A1A;
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
        .infosystem-chat-input-bar button {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #8B1A1A;
            color: #ffffff;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }
        .infosystem-chat-input-bar button:hover {
            background: #6e1313;
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

        function updateWidgetHours() {
            var active = checkMadridActiveHours();
            widget.setAttribute('data-active', active ? '1' : '0');
            var badge = launcher.querySelector('.infosystem-wa-status-badge');
            var badgeText = launcher.querySelector('.infosystem-wa-badge-text');
            var statusDot = modal.querySelector('.infosystem-wa-avatar-status');
            var statusLabel = modal.querySelector('.infosystem-wa-status-label');

            if (active) {
                badge.className = 'infosystem-wa-status-badge active-hours';
                badgeText.textContent = 'WhatsApp';
                statusDot.className = 'infosystem-wa-avatar-status status-online';
                statusLabel.innerHTML = '<span class="dot-green">●</span> En directo · Asesoría de 8:00h a 20:00h';
                modeActive.classList.add('is-visible');
                modeActive.classList.remove('is-hidden');
                modeNight.classList.remove('is-visible');
                modeNight.classList.add('is-hidden');
            } else {
                badge.className = 'infosystem-wa-status-badge night-hours';
                badgeText.textContent = 'IA 24h';
                statusDot.className = 'infosystem-wa-avatar-status status-ai';
                statusLabel.innerHTML = '<span class="dot-amber">●</span> Asistente IA · Fuera de horario (8h a 20h)';
                modeActive.classList.remove('is-visible');
                modeActive.classList.add('is-hidden');
                modeNight.classList.add('is-visible');
                modeNight.classList.remove('is-hidden');
            }
        }

        // Toggle modal
        launcher.addEventListener('click', function() {
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
