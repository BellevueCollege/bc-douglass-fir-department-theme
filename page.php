<?php
/**
 * Page Template File
 *
 * Output page content.
 *
 * @package BC Douglas Fir Theme
 */

get_header();
?>
<?php if ( bc_douglas_fir_has_active_sidebar() ) : ?>
	<div class="col-md-9 order-1 <?php echo 'sidebar-content' === bc_douglas_fir_get_option( 'default_layout' ) ? '' : 'order-md-0'; ?>">
<?php else : // Full Width Container. ?>
	<div class="col-md-12">
<?php endif; ?>
		<?php if ( have_posts() ) : ?>
			<?php
			// Start the loop.
			while ( have_posts() ) :
				the_post();
				?>
				<main id="post-<?php the_ID(); ?>" <?php post_class( '' ); ?> role="main">
					<?php get_template_part( 'parts/page' ); ?>
				</main>
				<?php
			endwhile;
			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'parts/content', 'none' );

		endif;
		?>
	</div>
<?php
if ( bc_douglas_fir_has_active_sidebar() ) {
	get_sidebar();
}

get_footer();
?>
