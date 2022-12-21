<?php
/**
 * Basic Content Part
 *
 * @package BC Douglas Fir Theme
 */

?>
<!-- A Template Was Missing! Using parts/content to output content. -->
<h1><?php the_title(); ?></h1>
<div>
	<small>Date posted: <?php the_date(); ?></small>
</div>
<?php if ( has_post_thumbnail() ) : ?>
	<div class="pull-left wp-caption single-featured-thumb">
		<?php
		the_post_thumbnail( 'medium', array( 'class' => 'media-object' ) );
		if ( get_post( get_post_thumbnail_id() )->post_excerpt ) {
				$tn_id = get_post_thumbnail_id( $post->ID );
				$img   = wp_get_attachment_image_src( $tn_id, 'medium' );
				$width = $img[1];
			?>
			<p class="featured-caption media-object wp-caption-text" style="width:<?php echo esc_attr( $width . 'px' ); ?>"><?php echo wp_kses_post( get_post( get_post_thumbnail_id() )->post_excerpt ); ?></p>
		<?php } ?>
	</div>
<?php endif; ?>
<div>
	<?php the_content(); ?>
</div>
