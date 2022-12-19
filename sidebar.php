<?php
/**
 * Sidebar Content
 *
 * Render content for widgetized sidebars (left or right)
 *
 * @package Mayflower
 */

?>
<div class="sidebar col-md-3 <?php echo 'sidebar-content' === mayflower_get_option( 'default_layout' ) ? 'sidebarleft' : 'sidebarright'; ?>">

		<?php if ( is_active_sidebar( 'top-global-widget-area' ) ) : ?>
			<?php dynamic_sidebar( 'top-global-widget-area' ); ?>
		<?php endif; ?>

		<?php
		// Hook to allow display of more widget areas.
		mayflower_display_sidebar();
		?>

		<?php if ( is_active_sidebar( 'page-widget-area' ) ) : ?>
			<?php
			if ( ! mayflower_is_blog() ) {
				dynamic_sidebar( 'page-widget-area' );}
			?>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'blog-widget-area' ) ) : ?>
			<?php if ( mayflower_is_blog() ) : ?>
				<?php dynamic_sidebar( 'blog-widget-area' ); ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'global-widget-area' ) ) : ?>
			<?php dynamic_sidebar( 'global-widget-area' ); ?>
		<?php endif; ?>

</div><!-- col-md-3 -->
