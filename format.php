<?php
/**
 * Default Post Format
 *
 * @package Mayflower
 */

$mayflower_options = mayflower_get_options();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
	<h2 <?php post_class(); ?>>
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h2>
	<?php
	// Check if post date or author should be displayed.
	if ( $mayflower_options['display_post_author'] || $mayflower_options['display_post_date'] ) :
		?>
		<p class="entry-date">
			<?php
			// Check if post date should be displayed.
			if ( $mayflower_options['display_post_date'] ) :
				?>
				<?php
				esc_attr_e( 'Date posted: ', 'mayflower' );
				echo get_the_date();
				?>
				<?php
			endif;
			// Check if post author should be displayed.
			if ( $mayflower_options['display_post_author'] ) :
				?>
				&nbsp;<span class="pull-right"><?php esc_attr_e( 'Author: ', 'mayflower' ); ?><?php the_author(); ?></span>
			<?php endif; ?>
		</p>
	<?php endif; ?>
	<?php
	if ( has_post_thumbnail() ) :

		if ( get_post( get_post_thumbnail_id() )->post_excerpt ) :

			$tn_id = get_post_thumbnail_id( $post->ID );
			$img   = wp_get_attachment_image_src( $tn_id, 'medium' );
			$width = $img[1];
			?>

			<figure class="img-thumbnail alignleft wp-caption">
				<?php the_post_thumbnail( 'medium' ); ?>
				<figcaption class="featured-caption wp-caption-text"><?php echo wp_kses_post( get_post( get_post_thumbnail_id() )->post_excerpt ); ?></figcaption>
			</figure><!-- wp-caption -->
		<?php else : ?>
			<?php the_post_thumbnail( 'medium', array( 'class' => 'img-thumbnail alignleft' ) ); ?>
		<?php endif; ?>
	<?php endif; ?>
	<?php the_excerpt(); ?>
</article>
<hr>
