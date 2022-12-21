<?php
/**
 * Sidebar Content
 *
 * Render content for widgetized sidebars (left or right)
 *
 * @package BC Douglas Fir Theme
 */

?>
<div class="sidebar col-md-3 <?php echo 'sidebar-content' === bc_douglas_fir_get_option( 'default_layout' ) ? 'sidebarleft' : 'sidebarright'; ?>">

		<?php if ( is_active_sidebar( 'top-global-widget-area' ) ) : ?>
			<?php dynamic_sidebar( 'top-global-widget-area' ); ?>
		<?php endif; ?>

		<?php
		// Hook to allow display of more widget areas.
		bc_douglas_fir_display_sidebar();
		?>

		<?php if ( is_active_sidebar( 'page-widget-area' ) ) : ?>
			<?php
			if ( ! bc_douglas_fir_is_blog() ) {
				dynamic_sidebar( 'page-widget-area' );}
			?>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'blog-widget-area' ) ) : ?>
			<?php if ( bc_douglas_fir_is_blog() ) : ?>
				<?php dynamic_sidebar( 'blog-widget-area' ); ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'global-widget-area' ) ) : ?>
			<?php dynamic_sidebar( 'global-widget-area' ); ?>
		<?php endif; ?>

</div><!-- col-md-3 -->
