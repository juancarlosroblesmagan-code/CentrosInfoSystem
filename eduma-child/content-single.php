<?php
/**
 * Template part for displaying single posts of child theme.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

// Calcular tiempo de lectura estimado
$content = get_post_field( 'post_content', get_the_ID() );
$word_count = str_word_count( strip_tags( $content ) );
$reading_time = ceil( $word_count / 200 ); // Promedio de 200 palabras por minuto
if ( $reading_time < 1 ) {
    $reading_time = 1;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'cis-single-post-article' ); ?>>
    <!-- Barra de progreso de lectura (Floating Progress Bar) -->
    <div class="cis-progress-container">
        <div class="cis-progress-bar" id="cisProgressBar"></div>
    </div>

    <div class="page-content-inner">
        
        <!-- Cabecera de artículo (Hero Header) -->
        <header class="entry-header cis-entry-header">
            <div class="cis-post-categories">
                <?php the_category( ' ' ); ?>
            </div>
            
            <?php the_title( '<h1 class="entry-title cis-entry-title">', '</h1>' ); ?>
            
            <div class="cis-author-meta-box">
                <div class="cis-author-avatar">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 48 ); ?>
                </div>
                <div class="cis-author-info">
                    <span class="cis-author-name">Por <strong><?php the_author(); ?></strong></span>
                    <div class="cis-meta-details">
                        <span class="cis-post-date"><i class="fa fa-calendar-alt"></i> <?php echo get_the_date('d \d\e F, Y'); ?></span>
                        <span class="cis-meta-divider">•</span>
                        <span class="cis-reading-time"><i class="fa fa-clock"></i> Lectura: <?php echo $reading_time; ?> min</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Imagen destacada principal si existe -->
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="cis-featured-image-wrapper">
                <?php the_post_thumbnail( 'full', array( 'class' => 'cis-featured-image' ) ); ?>
            </div>
        <?php endif; ?>

        <!-- Contenido del artículo -->
        <div class="entry-content cis-entry-content">
            <?php the_content(); ?>
            
            <?php
            wp_link_pages(
                array(
                    'before'      => '<div class="pagination loop-pagination">',
                    'after'       => '</div>',
                    'link_before' => '<span class="page-number">',
                    'link_after'  => '</span>',
                )
            );
            ?>
        </div>

        <!-- Banner de Llamada a la Acción (CTA) al final del artículo -->
        <div class="cis-content-cta-banner">
            <div class="cis-cta-badge">CONVOCATORIA ABIERTA</div>
            <h3>¿Quieres estudiar gratis en Castilla-La Mancha?</h3>
            <p>Mejora tu currículum y competencias profesionales con nuestros cursos 100% subvencionados por el SEPE y la Junta de Comunidades de CLM.</p>
            <div class="cis-cta-buttons">
                <a href="/cursos-subvencionados-castilla-la-mancha/" class="cis-btn-primary">Ver cursos gratuitos</a>
                <a href="/contacto/" class="cis-btn-outline">Solicitar información</a>
            </div>
        </div>

        <!-- Compartir y etiquetas -->
        <div class="entry-tag-share cis-entry-tag-share">
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    if ( get_the_tag_list() ) {
                        echo get_the_tag_list( '<p class="post-tag"><span>' . esc_html__( 'Etiquetas:', 'eduma-child' ) . '</span>', ', ', '</p>' );
                    }
                    ?>
                </div>
                <div class="col-sm-6 text-right">
                    <?php do_action( 'thim_social_share' ); ?>
                </div>
            </div>
        </div>

        <!-- Autor y posts relacionados -->
        <?php
        /**
         * thim_post_footer hook
         *
         * @hooked thim_about_author - 5
         * @hooked thim_post_nav - 15
         * @hooked thim_single_post_related - 25
         */
        do_action( 'thim_post_footer' );
        ?>

    </div>
</article>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var progressBar = document.getElementById('cisProgressBar');
    if (!progressBar) return;
    
    window.addEventListener('scroll', function() {
        var winScroll = document.documentElement.scrollTop || document.body.scrollTop;
        var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        var scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + "%";
    });
});
</script>
