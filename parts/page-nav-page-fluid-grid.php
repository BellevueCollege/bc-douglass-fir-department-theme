<?php
/**
 * Nav Page Fluid Grid Template Part
 *
 * @package BC Douglas Fir Theme
 */

?>
<main id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<h1><?php the_title(); ?></h1>
		<?php
		if ( function_exists( 'post_and_page_asides_return_title' ) ) :
			get_template_part( 'parts/aside' );
		endif;
		?>
		<?php
		if ( '' !== $post->post_content ) :
			?>
			<article>
				<?php the_content(); ?>
			</article>
		<?php endif; ?>

	<?php endwhile; ?>

	<?php wp_reset_postdata(); ?>
	<?php require get_template_directory() . '/inc/nav-page/fluid-grid.php'; ?>
</main>
