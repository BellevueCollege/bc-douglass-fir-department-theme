<?php
/**
 * Board of Trustees Agenda Archive Part
 *
 * @package Mayflower
 */

foreach ( posts_by_year() as $yr => $posts_in_yr ) : ?>
	<h1><?php echo wp_kses_post( $yr ); ?></h1>
	<ul>
		<?php
		foreach ( $posts_in_yr as $post ) :
			setup_postdata( $post );
			?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<?php
					$value = get_post_meta( get_the_ID(), 'meeting_date', true );
					if ( ! empty( $value ) ) {
						$display_date = gmdate( 'F j, Y', strtotime( $value ) );
						echo esc_attr( $display_date );
					}
					?>
				</a>
				<?php
				$special_meeting = get_post_meta( get_the_ID(), 'special_meeting', true );
				$special         = '';
				if ( $special_meeting ) {
					$special = '&nbsp;(Special Meeting)';
					echo wp_kses_post( $special );
				}
				?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endforeach; ?>

<?php
/**
 * Display Posts by Year
 *
 * @return array $years;
 */
function posts_by_year() {
	// array to use for results.
	$years = array();

	// get posts from WP.
	$posts = get_posts(
		array(
			'numberposts' => -1,
			'meta_key'    => 'meeting_date',
			'orderby'     => 'meta_value',
			'order'       => 'DESC',
			'post_type'   => 'agendas',
			'post_status' => 'publish',
		)
	);

	// loop through posts, populating $years arrays.
	foreach ( $posts as $post ) {
		if ( isset( $post->meeting_date ) && ! empty( $post->meeting_date ) ) {
			$years[ gmdate( 'Y', strtotime( $post->meeting_date ) ) ][] = $post;
		}
	}

	// reverse sort by year.
	krsort( $years );
	return $years;
}
