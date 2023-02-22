<?php
/**
 * Staff Page Template Part
 *
 * @package BC Douglas Fir Theme
 */

?>
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		if ( '' === $post->post_content ) :
			?>
	<!-- Don't display empty the_content or surround divs -->
		<div class="page-content">
			<h1><?php the_title(); ?></h1>
		</div><!-- page-content -->
			<?php else : ?>
	<!-- Do stuff when the_content has content -->
		<div class="page-content">
			<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
		</div><!-- page-content -->

	<?php endif; ?>

	<?php endwhile; else : ?>
	<p><?php esc_attr_e( 'Sorry, these aren\'t the bytes you are looking for.' ); ?></p>
	<?php endif; ?>

<?php
// Ensure BC Douglas Fir Theme Options are available to loaded file.
$bc_douglas_fir_options = bc_douglas_fir_get_options();
?>
<?php require get_template_directory() . '/inc/staff/output.php'; ?>
