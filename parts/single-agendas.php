<?php
/**
 * Board of Trustees Agenda Single View
 *
 * @link https://github.com/BellevueCollege/trustees-agenda
 * @package Mayflower
 */

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post(); ?>
	<main role="main">
		<h1>
		<?php
		the_title();
		$value = get_post_meta( get_the_ID(), 'meeting_date', true );

		if ( ! empty( $value ) ) {
			$display_date = gmdate( 'F j, Y', strtotime( $value ) );

			?>
		<br /><?php echo esc_attr( $display_date ); ?></h1>
			<?php } ?>
		</h1>
			<?php
			$content = the_content();
			if ( '' !== $content ) {
				echo wp_kses_post( $content );
			}
			?>
	</main>

			<?php
endwhile;
	wp_reset_postdata();
endif;
