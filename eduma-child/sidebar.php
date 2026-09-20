<?php
/**
 * The sidebar containing the main widget area or a custom high-converting sidebar for single posts.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

// Si es un artículo de blog, mostrar la barra lateral súper optimizada y orientada a conversión
if ( is_single() && get_post_type() === 'post' ) :
    $sticky_sidebar = ! empty( get_theme_mod( 'thim_sticky_sidebar', true ) ) ? ' sticky-sidebar' : '';
    ?>
    <div id="sidebar" class="widget-area col-sm-3<?php echo esc_attr( $sticky_sidebar ); ?>" role="complementary">
        
        <!-- Widget: Buscador -->
        <aside class="widget widget_search cis-sidebar-widget">
            <h3 class="widget-title">Buscar artículos</h3>
            <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <label>
                    <span class="screen-reader-text">Buscar:</span>
                    <input type="search" class="search-field" placeholder="Escribe y pulsa Enter..." value="" name="s" />
                </label>
                <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
            </form>
        </aside>

        <!-- Widget: CTA de Cursos Subvencionados (Conversión Directa) -->
        <aside class="widget cis-sidebar-widget cis-cta-widget">
            <div class="cis-cta-widget-badge">100% SUBVENCIONADOS</div>
            <h3 class="widget-title">Fórmate Gratis</h3>
            <p>Accede a certificados de profesionalidad oficiales sin coste para ti. Formación presencial y aula virtual.</p>
            
            <div class="cis-featured-courses-list">
                <a href="/cursos-subvencionados-castilla-la-mancha/" class="cis-featured-course-item">
                    <span class="course-dot"></span>
                    <span>Ofimática en la Nube (Google)</span>
                </a>
                <a href="/cursos-subvencionados-castilla-la-mancha/" class="cis-featured-course-item">
                    <span class="course-dot"></span>
                    <span>Gestión de Negocios Online</span>
                </a>
                <a href="/cursos-subvencionados-castilla-la-mancha/" class="cis-featured-course-item">
                    <span class="course-dot"></span>
                    <span>Atención Sociosanitaria</span>
                </a>
            </div>

            <a href="/cursos-subvencionados-castilla-la-mancha/" class="cis-cta-widget-btn">Ver Catálogo de Cursos</a>
        </aside>

        <!-- Widget: Artículos Destacados -->
        <aside class="widget widget_list-post cis-sidebar-widget">
            <h3 class="widget-title">Artículos de interés</h3>
            <?php
            $recent_posts = new WP_Query( array(
                'posts_per_page'      => 4,
                'post__not_in'        => array( get_the_ID() ),
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true
            ) );
            
            if ( $recent_posts->have_posts() ) :
                echo '<ul class="cis-recent-posts-list">';
                while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
                    ?>
                    <li>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="post-thumb">
                                <?php the_post_thumbnail( array( 60, 60 ) ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="post-info">
                            <a href="<?php the_permalink(); ?>" class="post-title"><?php the_title(); ?></a>
                            <span class="post-date"><?php echo get_the_date('d M, Y'); ?></span>
                        </div>
                    </li>
                    <?php
                endwhile;
                echo '</ul>';
                wp_reset_postdata();
            endif;
            ?>
        </aside>

    </div><!-- #secondary -->
    <?php
    return;
endif;

// Comportamiento por defecto para el resto de páginas
if ( ! is_active_sidebar( 'sidebar' ) ) {
    return;
}
$sticky_sidebar = ! empty( get_theme_mod( 'thim_sticky_sidebar', true ) ) ? ' sticky-sidebar' : '';
if ( get_theme_mod( 'thim_header_style', 'header_v1' ) == 'header_v4' ) {
    $sticky_sidebar .= ' sidebar_' . get_theme_mod( 'thim_header_style' );
}
?>
<div id="sidebar" class="widget-area col-sm-3<?php echo esc_attr( $sticky_sidebar ); ?>" role="complementary">
    <?php dynamic_sidebar( 'sidebar' ); ?>
</div><!-- #secondary -->
