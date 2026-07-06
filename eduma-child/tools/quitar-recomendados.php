<?php
/**
 * Script de Utilidad Anti-Gravity
 * Remueve el bloque "Recomendamos: HipotecaXpert | VipOfertas" del footer en producción.
 */

define('WP_USE_THEMES', false);
require_once __DIR__ . '/wp-load.php';

// Verificar que se ejecuta con privilegios o que se ejecuta conscientemente
if ( php_sapi_name() !== 'cli' && (!isset($_GET['clave']) || $_GET['clave'] !== 'quitar-enlaces') ) {
    die('Acceso denegado. Para ejecutar este script, accede a: quitar-recomendados.php?clave=quitar-enlaces');
}

$widget_text = get_option('widget_text');

if ($widget_text && is_array($widget_text)) {
    $found = false;
    foreach ($widget_text as $id => $widget) {
        if (isset($widget['text']) && (strpos($widget['text'], 'HipotecaXpert') !== false || strpos($widget['text'], 'VipOfertas') !== false)) {
            
            // Reemplazar el bloque de recomendación usando una expresión regular robusta
            $clean_text = preg_replace('/<p[^>]*>\s*<strong[^>]*>Recomendamos:<\/strong>.*?<\/p>/si', '', $widget['text']);
            
            // En caso de que no coincida exactamente por saltos de línea particulares, aplicar un reemplazo alternativo
            if ($clean_text === $widget['text']) {
                $clean_text = str_replace(
                    '<p style="margin:0;color:#ccc;">' . "\n" .
                    '        <strong style="color:#D4880A;">Recomendamos:</strong>' . "\n" .
                    '        <a href="https://hipotecaxpert.com" target="_blank" rel="noopener nofollow" style="color:#ffb606;text-decoration:none;font-weight:500;">HipotecaXpert</a> |' . "\n" .
                    '        <a href="https://vipofertas.es" target="_blank" rel="noopener nofollow" style="color:#ffb606;text-decoration:none;font-weight:500;">VipOfertas</a>' . "\n" .
                    '    </p>', 
                    '', 
                    $widget['text']
                );
            }
            
            $widget_text[$id]['text'] = $clean_text;
            $found = true;
        }
    }
    
    if ($found) {
        update_option('widget_text', $widget_text);
        echo "<h3>[ÉXITO] El bloque 'Recomendamos' ha sido eliminado de la base de datos de producción.</h3>";
        
        // Limpiar caché de WP Rocket si está activo
        if (function_exists('rocket_clean_domain')) {
            rocket_clean_domain();
            echo "<p>[WP ROCKET] Caché del dominio limpiada correctamente.</p>";
        }
        
        echo "<p><strong>IMPORTANTE:</strong> Por favor, borra este archivo (<code>quitar-recomendados.php</code>) de tu servidor por motivos de seguridad.</p>";
    } else {
        echo "<h3>[AVISO] No se encontró el texto de recomendaciones en los widgets. Es posible que ya haya sido eliminado.</h3>";
    }
} else {
    echo "<h3>[ERROR] No se pudo leer la configuración de los widgets de texto.</h3>";
}
