<?php
/**
 * Video Post Format
 *
 * Output content into excerpt with minimal excerpting.
 *
 * @package Mayflower
 */

// Load Mayflower options into array.
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

	<div class="video-container">
		<?php the_content(); ?>
	</div>
</article>
<hr>
