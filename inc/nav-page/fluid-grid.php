<?php
/**
 * Shared Navigation Page Fluid Grid Template
 *
 * Used by both Page Template and Block
 *
 * @package BC Douglas Fir Theme
 */

?>
<section class="child-pages fluid-grid">
	<div class="grid-sizer"></div>
	<?php
	$attributes['pageID'] = empty( $attributes['pageID'] ) ? get_the_ID() : $attributes['pageID'];
	$args                 = array(
		'post_type'      => 'page',
		'posts_per_page' => -1,
		'order'          => 'ASC',
		'orderby'        => 'menu_order title',
		'post_status'    => 'publish',
		'post_parent'    => $attributes['pageID'],
	);

	$loop = new WP_Query( $args );

	while ( $loop->have_posts() ) :
		$loop->the_post();
		$image_data = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium_large' );
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'card mb-3' ); ?> style="max-width: <?php echo esc_attr( $image_data[1] ); ?>px">

			<?php if ( has_post_thumbnail() ) { ?>
				<a class="card-img-top" href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'medium_large', array( 'class' => 'card-img-top' ) ); ?>
				</a>
			<?php } ?>
				<div class="card-body">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php
					the_excerpt();
					edit_post_link( 'edit', '<small>', '</small>' );
				?>
			</div>
		</article><!-- content-padding .nav-page -->

	<?php endwhile; ?>

	<?php wp_reset_postdata(); ?>
</section>
