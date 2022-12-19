<?php
/**
 * Featured Image Post Format
 *
 * Output the featured image large at the top of the post
 *
 * @package Mayflower
 */

// Load Mayflower options into array.
$bc_douglas_fir_options = bc_douglas_fir_get_options();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
	<h2 <?php post_class(); ?>>
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h2>
	<?php
	// Check if post date or author should be displayed.
	if ( $bc_douglas_fir_options['display_post_author'] || $bc_douglas_fir_options['display_post_date'] ) :
		?>
		<p class="entry-date">
			<?php
			// Check if post date should be displayed.
			if ( $bc_douglas_fir_options['display_post_date'] ) :
				?>
				<?php
				esc_attr_e( 'Date posted: ', 'bc-douglas-fir' );
				echo get_the_date();
				?>
				<?php
			endif;
			// Check if post author should be displayed.
			if ( $bc_douglas_fir_options['display_post_author'] ) :
				?>
				&nbsp;<span class="pull-right"><?php esc_attr_e( 'Author: ', 'bc-douglas-fir' ); ?><?php the_author(); ?></span>
			<?php endif; ?>
		</p>
	<?php endif; ?>
	<?php
	if ( has_post_thumbnail() ) :

		$tn_id = get_post_thumbnail_id( $post->ID );
		$img   = wp_get_attachment_image_src( $tn_id, 'large' );
		$width = $img[1];
		?>
		<div class="wp-block-image">
			<figure class="aligncenter">
				<?php the_post_thumbnail( 'large' ); ?>
				<?php if ( get_post( get_post_thumbnail_id() )->post_excerpt ) : ?>
					<figcaption class="featured-caption wp-caption-text"><?php echo wp_kses_post( get_post( get_post_thumbnail_id() )->post_excerpt ); ?></figcaption>
				<?php endif; ?>
			</figure><!-- wp-caption -->
		</div>
	<?php endif; ?>
	<?php the_excerpt(); ?>
</article>
<hr>



