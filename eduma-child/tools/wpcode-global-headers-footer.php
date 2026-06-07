<?php
/**
 * WPCode — CSS global: TODAS las páginas con banner + menú Cursos.
 * Tipo: PHP snippet | Auto Insert: Site Wide Header (o ejecutar como PHP que imprime style)
 *
 * Alternativa más fácil: subir eduma-child/tools/mu-plugins/infosystem-global-ui-fix.php
 * a wp-content/mu-plugins/ en el servidor.
 */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'eduma_child_global_ui_fix_css' ) ) {
	$inc = get_stylesheet_directory() . '/inc/infosystem-global-headers-footer.php';
	if ( file_exists( $inc ) ) {
		require_once $inc;
	}
}

if ( function_exists( 'eduma_child_global_ui_fix_css' ) ) {
	echo '<style id="infosystem-global-ui-wpcode">' . eduma_child_global_ui_fix_css() . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} else {
	$banner = esc_url( content_url( '/uploads/2026/05/centrosinfosystem-banner.webp' ) );
	?>
	<style id="infosystem-global-ui-wpcode">
	body:not(.home) .top_heading .breadcrumbs-wrapper{display:none!important;height:0!important;overflow:hidden!important}
	body:not(.home) span.overlay-top-header{background-image:linear-gradient(135deg,rgba(139,26,26,.78),rgba(40,12,12,.65)),url("<?php echo esc_url( $banner ); ?>")!important;background-size:cover!important;background-position:center 35%!important}
	body:not(.home) .top_heading .page-title{color:#fff!important;text-shadow:0 2px 20px rgba(0,0,0,.35)}
	body:not(.home) .top_heading .top_site_main.style_heading_3{min-height:300px!important}
	#menu-item-16477 .thim-ekits-menu__icon,#menu-item-16477 .thim-ekits-menu__content{display:none!important;visibility:hidden!important;height:0!important;border:none!important}
	#menu-item-16477 .thim-ekits-menu__nav-link.active{outline:none!important;box-shadow:none!important;border:none!important}
	body.blog #sidebar,body.blog .widget-area{display:none!important}
	body.blog main.site-main.col-sm-9{width:100%!important;flex:0 0 100%!important}
	</style>
	<?php
}
