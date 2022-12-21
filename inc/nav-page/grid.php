<?php
/**
 * Shared Navigation Page Grid Template
 *
 * Used by both Page Template and Block
 *
 * @package BC Douglas Fir Theme
 */

?>
<section class="nav-page">
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

	// number of columns.
	$column_num = 3;
	$count      = 0;

	while ( $loop->have_posts() ) :
		$loop->the_post();
		$count++;
		if ( 1 === $count ) {
			echo '<div class="row mb-4">';
		}
		?>


		<div class="col-md-4">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>

				<?php if ( has_post_thumbnail() ) { ?>
					<a class="card-img-top" href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( 'home-small-ad', array( 'class' => 'card-img-top' ) ); ?>
					</a>
				<?php } ?>
				<div class="card-body">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php
						the_excerpt();
						edit_post_link( 'edit', '', '', '', 'btn btn-light btn-sm float-right' );
					?>
				</div>
			</article><!-- content-padding .nav-page -->
		</div><!-- col-md-4 -->
		<?php if ( $count === $column_num ) { ?>
			</div> <!-- .row -->
			<?php
			$count = 0;
		}
		?>

	<?php endwhile; ?>
	<?php if ( $count > 0 ) { ?>
		</div> <!-- .row -->
	<?php } ?>

	<?php wp_reset_postdata(); ?>
</section>
