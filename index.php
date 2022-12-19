<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 * This isn't used for most templates in Mayflower.
 *
 * @package Mayflower
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

				/*
				* Include the Post-Format-specific template for the content.
				* If you want to override this in a child theme, then include a file
				* called content-___.php (where ___ is the Post Format name) and that will be used instead.
				*/

				get_template_part( 'content', get_post_format() );

			endwhile;
			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'parts/content', 'none' );

		endif;
		?>
	</div>
<?php if ( bc_douglas_fir_has_active_sidebar() ) : ?>
	<?php
	get_sidebar();
endif;
?>


<?php get_footer(); ?>
