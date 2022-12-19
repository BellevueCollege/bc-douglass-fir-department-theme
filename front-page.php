<?php
/**
 * Front Page Template File
 *
 * Loads Blog and Static Homepages in Mayflower
 *
 * @package Mayflower
 */

get_header(); ?>

<?php
/**
 * Load Featured Slideshow Full Width
 *
 * Load if selected, or if there is no sidebar.
 */
if ( ! ( has_active_sidebar() ) ||
	( 'featured-full' === $mayflower_options['slider_layout'] &&
	'true' == $mayflower_options['slider_toggle'] ) ) { ?>
	<div class="col-12 order-2 order-md-0 carousel-col p-0"><?php get_template_part( 'parts/featured-full' ); ?></div>
<?php } ?>
	<?php if ( has_active_sidebar() ) : ?>
		<div class="col-md-9 order-3 <?php echo 'sidebar-content' === mayflower_get_option( 'default_layout' ) ? '' : 'order-md-0'; ?>">
	<?php else : // Full Width Container. ?>
		<div class="col-md-12 order-3">
	<?php endif; ?>
			<main role="main">
				<?php
				/**
				 * Load Featured Slideshow in Content
				 */
				if ( has_active_sidebar() &&
					'true' == $mayflower_options['slider_toggle'] &&
					'featured-in-content' === $mayflower_options['slider_layout'] ) {
					get_template_part( 'parts/featured-in-content' );
					?>
					<?php
				}
				/**
				 * Check if static homepage is set
				 */
				if ( 'page' === get_option( 'show_on_front' ) ) {
					/*
					* Check if using page template
					*
					* Page templates are over-ridden by using front-page.php
					* Continue as normal if using full-width template.
					*/
					if ( is_page_template() && ! is_page_template( 'page-full-width.php' ) ) {
						/*
						* Load page template
						*
						* Look for file matching template name within parts/ directory
						**/
						$template_name = str_replace( '.php', '', get_page_template_slug() );
						get_template_part( "parts/$template_name" );
					} else {
						get_template_part( 'parts/content', 'static-home' );
					}
				} else {
					get_template_part( 'parts/content', 'blog-home' );
				}
				?>
			</main>

	</div>
	<?php if ( has_active_sidebar() ) : ?>
		<?php
		get_sidebar();
	endif;
	?>
<?php get_footer(); ?>
