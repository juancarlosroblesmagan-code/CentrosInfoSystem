<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

// Solo permitir ejecución local o bajo contraseña de seguridad por Plesk/CLI
if (php_sapi_name() !== 'cli' && (!isset($_GET['clave']) || $_GET['clave'] !== 'infosystem-recuperar')) {
    wp_die('Acceso denegado.');
}

// 1. Definir funciones de análisis de uso de formularios
function infosystem_find_form_usage($form_id) {
    global $wpdb;
    
    $form = get_post($form_id);
    if (!$form) return array();
    
    $id = $form->ID;
    $slug = $form->post_name;
    
    $usages = array();
    
    // Buscar en contenido de entradas/páginas/productos
    $posts = $wpdb->get_results($wpdb->prepare(
        "SELECT ID, post_title, post_type FROM {$wpdb->posts} WHERE post_status = 'publish' AND (post_content LIKE %s OR post_content LIKE %s OR post_content LIKE %s OR post_content LIKE %s)",
        "%id=\"{$id}\"%", "%id='{$id}'%", "%name=\"{$slug}\"%", "%name='{$slug}'%"
    ));
    foreach ($posts as $p) {
        $usages[] = "Página/Entrada: {$p->post_title} (ID: {$p->ID}, Tipo: {$p->post_type})";
    }
    
    // Buscar en metadatos de Elementor
    $meta = $wpdb->get_results($wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_elementor_data' AND (meta_value LIKE %s OR meta_value LIKE %s)",
        "%\"{$id}\"%", "%id=\\\"{$id}\\\"%"
    ));
    foreach ($meta as $m) {
        $p = get_post($m->post_id);
        if ($p && $p->post_status === 'publish') {
            $usages[] = "Elementor Widget: {$p->post_title} (ID: {$p->ID}, Tipo: {$p->post_type})";
        }
    }
    
    // Buscar en widgets
    $widgets = $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE 'widget_%'");
    foreach ($widgets as $w) {
        if (strpos($w->option_value, (string)$id) !== false || strpos($w->option_value, $slug) !== false) {
            $usages[] = "Widget: {$w->option_name}";
        }
    }
    
    // Buscar en la configuración global de WC Quote / Enquiry CF7
    $global_quote_form_id = get_option('contact_form_to_enquire_contact_form');
    if ((int)$global_quote_form_id === (int)$id) {
        $usages[] = "Configuración Global WooCommerce Quote (Plugin)";
    }
    
    // Buscar en la configuración de producto individual para WC Quote
    $pm = $wpdb->get_results($wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = 'contact_form_to_enquire_contact_form' AND meta_value = %s",
        (string)$id
    ));
    foreach ($pm as $m) {
        $p = get_post($m->post_id);
        if ($p && $p->post_status === 'publish') {
            $usages[] = "Ficha de Producto (WC Quote Override): {$p->post_title} (ID: {$p->ID})";
        }
    }
    
    return array_unique($usages);
}

// 2. Definir función de inyección de Akismet
function infosystem_add_akismet_to_layout($layout) {
    $pattern = '/\[(text\*|text|email\*|email|tel\*|tel)\s+([a-zA-Z0-9_\-]+)([^\]]*)\]/';
    
    $updated_layout = preg_replace_callback($pattern, function($matches) {
        $type = $matches[1];
        $name = $matches[2];
        $attrs = trim($matches[3]);
        
        $name_lower = strtolower($name);
        
        if (strpos($type, 'text') === 0 && (strpos($name_lower, 'name') !== false || strpos($name_lower, 'nombre') !== false)) {
            if (strpos($attrs, 'akismet:author') === false) {
                $attrs .= ' akismet:author';
            }
        }
        elseif (strpos($type, 'email') === 0 && (strpos($name_lower, 'email') !== false || strpos($name_lower, 'correo') !== false)) {
            if (strpos($attrs, 'akismet:author_email') === false) {
                $attrs .= ' akismet:author_email';
            }
        }
        elseif (strpos($type, 'tel') === 0 && (strpos($name_lower, 'phone') !== false || strpos($name_lower, 'tel') !== false || strpos($name_lower, 'movil') !== false)) {
            if (strpos($attrs, 'akismet:author_url') === false) {
                $attrs .= ' akismet:author_url';
            }
        }
        
        $attrs = preg_replace('/\s+/', ' ', $attrs);
        $attrs = trim($attrs);
        
        return "[{$type} {$name}" . ($attrs ? " " . $attrs : "") . "]";
    }, $layout);
    
    return $updated_layout;
}

// 3. Definir función de traducción de mensajes
function infosystem_translate_message_to_spanish($key, $current_val) {
    $english_defaults = array(
        'mail_sent_ok' => array('Thank you for your message. It has been sent.'),
        'mail_sent_ng' => array('There was an error trying to send your message. Please try again later.'),
        'validation_error' => array('One or more fields have an error. Please check and try again.'),
        'spam' => array('There was an error trying to send your message. Please try again later.'),
        'accept_terms' => array('You must accept the terms and conditions before sending your message.'),
        'invalid_required' => array('The field is required.', 'This field is required.'),
        'invalid_too_long' => array('The field is too long.', 'This field is too long.'),
        'invalid_too_short' => array('The field is too short.', 'This field is too short.'),
        'upload_failed' => array('There was an unknown error uploading the file.'),
        'upload_file_type' => array('You are not allowed to upload files of this type.'),
        'upload_file_too_large' => array('The uploaded file is too large.'),
        'upload_failed_replace' => array('There was an error uploading the file. Replacing failed.'),
        'invalid_email' => array('The e-mail address entered is invalid.', 'The email address entered is invalid.'),
        'invalid_tel' => array('The telephone number entered is invalid.', 'The phone number entered is invalid.'),
        'invalid_url' => array('The URL entered is invalid.'),
        'invalid_number' => array('The number entered is invalid.'),
        'number_too_small' => array('The number is too small.'),
        'number_too_large' => array('The number is too large.'),
        'invalid_date' => array('The date format entered is invalid.'),
        'date_too_early' => array('The date is too early.'),
        'date_too_late' => array('The date is too late.'),
        'quiz_answer_expressing_error' => array('Your answer is not correct.'),
        'captcha_not_matching_error' => array('Your entered code is incorrect.')
    );
    
    $spanish_replacements = array(
        'mail_sent_ok' => 'Muchas gracias por tu mensaje. Ha sido enviado correctamente.',
        'mail_sent_ng' => 'Ocurrió un error al intentar enviar tu mensaje. Por favor, inténtalo de nuevo más tarde.',
        'validation_error' => 'Uno o más campos tienen un error. Por favor, revísalos e inténtalo de nuevo.',
        'spam' => 'Ocurrió un error al intentar enviar tu mensaje. Por favor, inténtalo de nuevo más tarde.',
        'accept_terms' => 'Por favor, acepta los términos y condiciones antes de enviar tu mensaje.',
        'invalid_required' => 'Este campo es obligatorio.',
        'invalid_too_long' => 'El campo es demasiado largo.',
        'invalid_too_short' => 'El campo es demasiado corto.',
        'upload_failed' => 'Ocurrió un error desconocido al subir el archivo.',
        'upload_file_type' => 'No tienes permitido subir archivos de este tipo.',
        'upload_file_too_large' => 'El archivo subido es demasiado grande.',
        'upload_failed_replace' => 'Ocurrió un error al subir el archivo. Ha fallado el reemplazo.',
        'invalid_email' => 'La dirección de correo electrónico parece no ser válida.',
        'invalid_tel' => 'El número de teléfono parece no ser válido.',
        'invalid_url' => 'La dirección URL parece no ser válida.',
        'invalid_number' => 'El número parece no ser válido.',
        'number_too_small' => 'El número es demasiado pequeño.',
        'number_too_large' => 'El número es demasiado grande.',
        'invalid_date' => 'El formato de fecha parece no ser válido.',
        'date_too_early' => 'La fecha es demasiado temprana.',
        'date_too_late' => 'La fecha es demasiado tardía.',
        'quiz_answer_expressing_error' => 'La respuesta a la pregunta de seguridad es incorrecta.',
        'captcha_not_matching_error' => 'El código de seguridad ingresado no coincide.'
    );
    
    $current_trimmed = trim($current_val);
    $should_replace = false;
    
    if (empty($current_trimmed)) {
        $should_replace = true;
    } elseif (isset($english_defaults[$key])) {
        foreach ($english_defaults[$key] as $eng) {
            if (strcasecmp($current_trimmed, $eng) === 0) {
                $should_replace = true;
                break;
            }
        }
    }
    
    if ($should_replace && isset($spanish_replacements[$key])) {
        return $spanish_replacements[$key];
    }
    
    return $current_val;
}

// 4. Iniciar ejecución
echo "=== PROCESO DE MANTENIMIENTO CONTACT FORM 7 + AKISMET ===\n\n";

$forms = get_posts(array(
    'post_type' => 'wpcf7_contact_form',
    'posts_per_page' => -1,
    'post_status' => 'any'
));

foreach ($forms as $f) {
    echo "Analizando Formulario ID {$f->ID}: '{$f->post_title}'...\n";
    $usages = infosystem_find_form_usage($f->ID);
    
    if (empty($usages)) {
        echo "➔ ESTADO: NO UTILIZADO. Procediendo a borrar...\n";
        wp_delete_post($f->ID, true);
        echo "✔ Borrado con éxito.\n";
    } else {
        echo "➔ ESTADO: EN USO.\n";
        echo "  Usado en:\n";
        foreach ($usages as $u) {
            echo "    - $u\n";
        }
        
        // A. Actualizar Layout (Inyectar Akismet)
        $layout = get_post_meta($f->ID, '_form', true);
        $new_layout = infosystem_add_akismet_to_layout($layout);
        if ($layout !== $new_layout) {
            update_post_meta($f->ID, '_form', $new_layout);
            echo "  ✔ Layout actualizado con etiquetas Akismet.\n";
        } else {
            echo "  ➔ Layout ya protegido con Akismet.\n";
        }
        
        // B. Actualizar Mensajes a Español
        $messages = get_post_meta($f->ID, '_messages', true);
        if (is_array($messages)) {
            $updated_count = 0;
            foreach ($messages as $key => $val) {
                $new_val = infosystem_translate_message_to_spanish($key, $val);
                if ($val !== $new_val) {
                    $messages[$key] = $new_val;
                    $updated_count++;
                }
            }
            if ($updated_count > 0) {
                update_post_meta($f->ID, '_messages', $messages);
                echo "  ✔ Traducidos {$updated_count} mensajes de validación a Español.\n";
            } else {
                echo "  ➔ Todos los mensajes de validación ya están en Español.\n";
            }
        }
    }
    echo "--------------------------------------------------\n";
}

echo "\n=== PROCESO COMPLETADO CON ÉXITO ===\n";
