<?php
/**
 * Video Post Format
 *
 * Output content into excerpt with minimal excerpting.
 *
 * @package BC Douglas Fir Theme
 */

// Load BC Douglas Fir Theme options into array.
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

	<div class="video-container">
		<?php the_content(); ?>
	</div>
</article>
<hr>
