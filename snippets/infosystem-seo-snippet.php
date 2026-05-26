<?php
/**
 * Infosystem SEO - Schemas JSON-LD + Meta Tags avanzados
 *
 * Inyecta automáticamente:
 *  - EducationalOrganization + LocalBusiness (organización + 4 centros)
 *  - WebSite + SearchAction
 *  - BreadcrumbList dinámico
 *  - Course schema (productos WooCommerce de cursos subvencionados)
 *  - Article schema enriquecido (posts del blog)
 *  - FAQPage schema (página /preguntas-frecuentes/)
 *  - OpenGraph y Twitter Cards adicionales
 *
 * Compatible con Rank Math (no colisiona gracias a @id únicos).
 */

if (!defined('ABSPATH')) return;

/* =====================================================================
 * 1) HELPERS
 * ===================================================================== */

if (!function_exists('infosys_seo_base_url')) {
    function infosys_seo_base_url() {
        return untrailingslashit(home_url('/'));
    }
}

if (!function_exists('infosys_seo_logo_url')) {
    function infosys_seo_logo_url() {
        $att_id = attachment_url_to_postid(home_url('/wp-content/uploads/2026/04/InfoSystem-logo.png'));
        if ($att_id) {
            $url = wp_get_attachment_url($att_id);
            if ($url) return $url;
        }
        return home_url('/wp-content/uploads/2026/04/InfoSystem-logo.png');
    }
}

if (!function_exists('infosys_seo_get_centros')) {
    function infosys_seo_get_centros() {
        return [
            [
                'id' => 'santa-cruz-de-mudela',
                'name' => 'Infosystem Santa Cruz de Mudela',
                'street' => 'C. Cruz de Piedra, 13',
                'locality' => 'Santa Cruz de Mudela',
                'postal' => '13730',
                'lat' => 38.6411, 'lon' => -3.4683,
                'phone' => '+34 926 33 11 62',
            ],
            [
                'id' => 'viso-del-marques',
                'name' => 'Infosystem Viso del Marqués',
                'street' => 'Avda. Don Álvaro de Bazán s/n',
                'locality' => 'Viso del Marqués',
                'postal' => '13770',
                'lat' => 38.5170, 'lon' => -3.5611,
                'phone' => '+34 926 33 11 62',
            ],
            [
                'id' => 'fuente-del-fresno',
                'name' => 'Infosystem Fuente el Fresno',
                'street' => 'Plaza de España s/n',
                'locality' => 'Fuente el Fresno',
                'postal' => '13412',
                'lat' => 39.2369, 'lon' => -3.7783,
                'phone' => '+34 926 33 11 62',
            ],
            [
                'id' => 'membrilla',
                'name' => 'Infosystem Membrilla',
                'street' => 'C. Mayor s/n',
                'locality' => 'Membrilla',
                'postal' => '13230',
                'lat' => 38.9706, 'lon' => -3.3408,
                'phone' => '+34 926 33 11 62',
            ],
        ];
    }
}

if (!function_exists('infosys_seo_print_jsonld')) {
    function infosys_seo_print_jsonld($data) {
        echo "\n<script type=\"application/ld+json\">" . wp_json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "</script>\n";
    }
}

/* =====================================================================
 * 2) EducationalOrganization + 4 LocalBusiness (sucursales)
 * ===================================================================== */
add_action('wp_head', 'infosys_seo_organization', 5);
function infosys_seo_organization() {
    $base = infosys_seo_base_url();
    $logo = infosys_seo_logo_url();
    $org = [
        '@context' => 'https://schema.org',
        '@type' => ['EducationalOrganization', 'LocalBusiness'],
        '@id' => $base . '/#infosys-organization',
        'name' => 'Infosystem — Centro de Educación Polivalente',
        'alternateName' => ['Infosystem', 'Centros Infosystem'],
        'description' => 'Centros de formación especialistas en formación gratuita subvencionada por el SEPE y la Junta de Castilla-La Mancha. Cursos para desempleados, trabajadores en activo, autónomos, formación dual y formación bonificada FUNDAE para empresas en Ciudad Real y toda Castilla-La Mancha.',
        'url' => $base,
        'logo' => $logo,
        'image' => $logo,
        'foundingDate' => '1995',
        'slogan' => 'Formación para el empleo en Castilla-La Mancha',
        'areaServed' => [
            ['@type' => 'AdministrativeArea', 'name' => 'Castilla-La Mancha'],
            ['@type' => 'AdministrativeArea', 'name' => 'Ciudad Real'],
            ['@type' => 'AdministrativeArea', 'name' => 'Toledo'],
            ['@type' => 'AdministrativeArea', 'name' => 'Albacete'],
            ['@type' => 'AdministrativeArea', 'name' => 'Cuenca'],
            ['@type' => 'AdministrativeArea', 'name' => 'Guadalajara'],
        ],
        'telephone' => '+34 926 33 11 62',
        'email' => 'info@infosystem.net',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'C. Cruz de Piedra, 13',
            'addressLocality' => 'Santa Cruz de Mudela',
            'addressRegion' => 'Ciudad Real',
            'postalCode' => '13730',
            'addressCountry' => 'ES',
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => 38.6411,
            'longitude' => -3.4683,
        ],
        'sameAs' => [
            'https://www.facebook.com/infosystem',
            'https://www.instagram.com/infosystem',
            'https://www.linkedin.com/company/infosystem',
        ],
        'department' => [],
        'knowsAbout' => [
            'Formación profesional para el empleo',
            'Cursos subvencionados SEPE',
            'Certificados de profesionalidad',
            'Formación bonificada FUNDAE',
            'Formación Dual',
            'Ofimática en la nube',
            'Marketing digital',
            'Gestión de negocios online',
        ],
        'hasCredential' => [
            '@type' => 'EducationalOccupationalCredential',
            'credentialCategory' => 'Centro homologado para la impartición de Formación Profesional para el Empleo',
            'recognizedBy' => [
                ['@type' => 'GovernmentOrganization', 'name' => 'SEPE - Servicio Público de Empleo Estatal'],
                ['@type' => 'GovernmentOrganization', 'name' => 'Junta de Comunidades de Castilla-La Mancha'],
                ['@type' => 'GovernmentOrganization', 'name' => 'FUNDAE - Fundación Estatal para la Formación en el Empleo'],
            ],
        ],
    ];
    foreach (infosys_seo_get_centros() as $c) {
        $org['department'][] = [
            '@type' => ['EducationalOrganization', 'LocalBusiness'],
            '@id' => $base . '/#infosys-centro-' . $c['id'],
            'name' => $c['name'],
            'image' => $logo,
            'telephone' => $c['phone'],
            'email' => 'info@infosystem.net',
            'url' => $base,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $c['street'],
                'addressLocality' => $c['locality'],
                'addressRegion' => 'Ciudad Real',
                'postalCode' => $c['postal'],
                'addressCountry' => 'ES',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $c['lat'],
                'longitude' => $c['lon'],
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday'],
                    'opens' => '09:00',
                    'closes' => '14:00',
                ],
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday'],
                    'opens' => '16:00',
                    'closes' => '20:00',
                ],
            ],
            'priceRange' => 'Gratuito',
            'parentOrganization' => ['@id' => $base . '/#infosys-organization'],
        ];
    }
    infosys_seo_print_jsonld($org);
}

/* =====================================================================
 * 3) WebSite + SearchAction (búsqueda interna como Sitelinks Searchbox)
 * ===================================================================== */
add_action('wp_head', 'infosys_seo_website', 6);
function infosys_seo_website() {
    $base = infosys_seo_base_url();
    infosys_seo_print_jsonld([
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        '@id' => $base . '/#infosys-website',
        'name' => 'Infosystem',
        'alternateName' => 'Centros Infosystem',
        'url' => $base,
        'publisher' => ['@id' => $base . '/#infosys-organization'],
        'inLanguage' => 'es-ES',
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => [
                '@type' => 'EntryPoint',
                'urlTemplate' => $base . '/?s={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ]);
}

/* =====================================================================
 * 4) BreadcrumbList (dinámico)
 * ===================================================================== */
add_action('wp_head', 'infosys_seo_breadcrumbs', 7);
function infosys_seo_breadcrumbs() {
    if (is_front_page() || is_home() && !is_paged()) return;
    $base = infosys_seo_base_url();
    $items = [['name' => 'Inicio', 'url' => $base . '/']];

    if (is_singular('post')) {
        $items[] = ['name' => 'Blog', 'url' => $base . '/blog/'];
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_singular('product')) {
        $items[] = ['name' => 'Cursos gratis subvencionados', 'url' => $base . '/cursos-subvencionados-castilla-la-mancha/'];
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_page()) {
        $page = get_post();
        if ($page && $page->post_parent) {
            $ancestors = array_reverse(get_post_ancestors($page->ID));
            foreach ($ancestors as $a_id) {
                $items[] = ['name' => get_the_title($a_id), 'url' => get_permalink($a_id)];
            }
        }
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_category() || is_tag() || is_tax()) {
        $term = get_queried_object();
        if ($term && !is_wp_error($term)) {
            $items[] = ['name' => single_term_title('', false), 'url' => get_term_link($term)];
        }
    } elseif (is_post_type_archive('product') || (function_exists('is_shop') && is_shop())) {
        $items[] = ['name' => 'Cursos gratis subvencionados', 'url' => $base . '/cursos-subvencionados-castilla-la-mancha/'];
    } elseif (is_home()) {
        $items[] = ['name' => 'Blog', 'url' => $base . '/blog/'];
    } else {
        return;
    }

    $itemList = [];
    foreach ($items as $i => $item) {
        $itemList[] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => wp_strip_all_tags($item['name']),
            'item' => $item['url'],
        ];
    }

    infosys_seo_print_jsonld([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        '@id' => (is_singular() ? get_permalink() : home_url(add_query_arg([],$GLOBALS['wp']->request))) . '#breadcrumb',
        'itemListElement' => $itemList,
    ]);
}

/* =====================================================================
 * 5) Course schema para productos WooCommerce (cursos)
 * ===================================================================== */
add_action('wp_head', 'infosys_seo_course_schema', 8);
function infosys_seo_course_schema() {
    if (!is_singular('product')) return;
    if (!function_exists('wc_get_product')) return;
    global $post;
    $product = wc_get_product($post->ID);
    if (!$product) return;

    $base = infosys_seo_base_url();
    $url = get_permalink($post->ID);
    $title = wp_strip_all_tags($product->get_name());
    $desc = wp_strip_all_tags($product->get_short_description() ?: $product->get_description());
    $desc = trim(wp_trim_words($desc, 60));
    $img = wp_get_attachment_url($product->get_image_id()) ?: infosys_seo_logo_url();

    $course = [
        '@context' => 'https://schema.org',
        '@type' => 'Course',
        '@id' => $url . '#infosys-course',
        'name' => $title,
        'description' => $desc,
        'url' => $url,
        'image' => $img,
        'provider' => [
            '@type' => 'EducationalOrganization',
            '@id' => $base . '/#infosys-organization',
            'name' => 'Infosystem — Centro de Educación Polivalente',
            'sameAs' => $base,
        ],
        'inLanguage' => 'es-ES',
        'isAccessibleForFree' => true,
        'educationalLevel' => 'Beginner',
        'teaches' => $title,
        'audience' => [
            '@type' => 'EducationalAudience',
            'educationalRole' => 'student',
        ],
        'courseCode' => 'INFOSYS-' . $post->ID,
        'coursePrerequisites' => 'Estar inscrito como trabajador o desempleado en el SEPE',
        'hasCourseInstance' => [
            '@type' => 'CourseInstance',
            'courseMode' => ['online', 'blended'],
            'courseWorkload' => 'PT60H',
            'inLanguage' => 'es-ES',
            'location' => [
                '@type' => 'VirtualLocation',
                'url' => $url,
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'EUR',
                'availability' => 'https://schema.org/InStock',
                'category' => 'Curso subvencionado SEPE / Junta de Castilla-La Mancha',
                'url' => $url,
                'validFrom' => date('Y-m-d', strtotime('-1 month')),
            ],
        ],
        'offers' => [
            '@type' => 'Offer',
            'price' => '0',
            'priceCurrency' => 'EUR',
            'availability' => 'https://schema.org/InStock',
            'category' => 'Subvencionado SEPE / JCCM',
            'url' => $url,
        ],
    ];

    infosys_seo_print_jsonld($course);
}

/* =====================================================================
 * 6) Article schema enriquecido para posts del blog
 * ===================================================================== */
add_action('wp_head', 'infosys_seo_article_schema', 9);
function infosys_seo_article_schema() {
    if (!is_singular('post')) return;
    global $post;
    $base = infosys_seo_base_url();
    $url = get_permalink($post->ID);
    $img = get_the_post_thumbnail_url($post->ID, 'full') ?: infosys_seo_logo_url();
    $excerpt = wp_strip_all_tags(get_the_excerpt($post));
    if (!$excerpt) $excerpt = wp_trim_words(wp_strip_all_tags($post->post_content), 35);

    $author = get_userdata($post->post_author);
    $author_name = $author ? $author->display_name : 'Infosystem';

    infosys_seo_print_jsonld([
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        '@id' => $url . '#infosys-article',
        'mainEntityOfPage' => $url,
        'headline' => wp_strip_all_tags(get_the_title($post)),
        'description' => $excerpt,
        'image' => $img,
        'datePublished' => get_the_date('c', $post),
        'dateModified' => get_the_modified_date('c', $post),
        'author' => [
            '@type' => 'Organization',
            '@id' => $base . '/#infosys-organization',
            'name' => $author_name,
            'url' => $base,
        ],
        'publisher' => [
            '@type' => 'Organization',
            '@id' => $base . '/#infosys-organization',
            'name' => 'Infosystem — Centro de Educación Polivalente',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => infosys_seo_logo_url(),
                'width' => 464,
                'height' => 241,
            ],
        ],
        'inLanguage' => 'es-ES',
        'articleSection' => 'Formación para el empleo',
    ]);
}

/* =====================================================================
 * 7) FAQPage schema en /preguntas-frecuentes/
 * Escanea el contenido buscando H3 (pregunta) seguido de párrafo (respuesta)
 * ===================================================================== */
add_action('wp_head', 'infosys_seo_faq_schema', 10);
function infosys_seo_faq_schema() {
    if (!is_page('preguntas-frecuentes')) return;
    global $post;
    if (!$post) return;
    $content = apply_filters('the_content', $post->post_content);
    $faqs = [];
    if (preg_match_all('/<h3[^>]*>(.*?)<\/h3>\s*([\s\S]*?)(?=<h3|<h2|$)/i', $content, $m)) {
        foreach ($m[1] as $i => $q) {
            $q = trim(wp_strip_all_tags($q));
            $a = trim(wp_strip_all_tags($m[2][$i]));
            $a = preg_replace('/\s+/', ' ', $a);
            if ($q !== '' && $a !== '') {
                $faqs[] = [
                    '@type' => 'Question',
                    'name' => $q,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $a,
                    ],
                ];
            }
        }
    }
    if (count($faqs) < 2) return;

    infosys_seo_print_jsonld([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        '@id' => get_permalink($post->ID) . '#infosys-faq',
        'inLanguage' => 'es-ES',
        'mainEntity' => $faqs,
    ]);
}

/* =====================================================================
 * 8) OpenGraph y Twitter Cards adicionales (complementan a Rank Math)
 * ===================================================================== */
add_action('wp_head', 'infosys_seo_meta_extra', 4);
function infosys_seo_meta_extra() {
    echo "<meta property=\"og:locale\" content=\"es_ES\" />\n";
    echo "<meta property=\"og:site_name\" content=\"Infosystem — Centro de Educación Polivalente\" />\n";
    echo "<meta name=\"geo.region\" content=\"ES-CR\" />\n";
    echo "<meta name=\"geo.placename\" content=\"Santa Cruz de Mudela, Ciudad Real, Castilla-La Mancha\" />\n";
    echo "<meta name=\"geo.position\" content=\"38.6411;-3.4683\" />\n";
    echo "<meta name=\"ICBM\" content=\"38.6411, -3.4683\" />\n";

    if (is_singular('post')) {
        echo "<meta property=\"article:section\" content=\"Formación para el empleo\" />\n";
        $tags = get_the_tags();
        if ($tags) {
            foreach ($tags as $t) {
                echo "<meta property=\"article:tag\" content=\"" . esc_attr($t->name) . "\" />\n";
            }
        }
    }
}

/* =====================================================================
 * 9) Asegurar canonical correcto en cursos (productos)
 * ===================================================================== */
add_filter('woocommerce_canonical_product_url', function($url, $product) {
    return get_permalink($product->get_id());
}, 10, 2);
