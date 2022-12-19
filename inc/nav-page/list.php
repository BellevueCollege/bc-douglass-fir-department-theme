<?php
/**
 * Shared Navigation Page List Template
 *
 * Used by both Page Template and Block
 *
 * @package Mayflower
 */

?>

<section class="content-padding nav-page nav-page-list">
	<?php
	// Use Gutenberg attribute if available (in editor), or use get_the_ID if not.
	$attributes['pageID'] = empty( $attributes['pageID'] ) ? get_the_ID() : $attributes['pageID'];

	$args = array(
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
		?>
		<article <?php post_class(); ?>>
			<h2 <?php post_class(); ?>>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>

			<div class="media">
				<?php if ( has_post_thumbnail() ) { ?>
					<div class="pull-left wp-caption">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'media-object' ) ); ?>
						</a>
					</div><!-- wp-caption -->
				<?php } ?>

				<div class="media-body">
					<div class="media-content content-padding">
						<?php the_excerpt(); ?>
						<?php edit_post_link( 'edit', '<small>', '</small>' ); ?>
					</div><!-- media-content -->
				</div><!-- media-body -->
			</div><!-- media -->
		</article>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
</section><!-- content-padding .nav-page -->
