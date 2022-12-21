<?php
/**
 * Template Name: Full Width (No Sidebar)
 *
 * @package BC Douglas Fir Theme
 */

get_header();
?>

<div class="col-md-12">
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
get_footer();

