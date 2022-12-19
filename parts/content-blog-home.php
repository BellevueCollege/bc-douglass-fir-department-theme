<?php
/**
 * Blog Home (Archive) Part
 *
 * @package Mayflower
 */

// Loop for posts.
$mf_paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args  = array(
	'paged'       => $mf_paged,
	'post_type'   => 'post',
	'order_by'    => 'date',
	'order'       => 'DESC',
	'post_status' => 'publish',
);

$loop = new WP_Query( $args );
if ( $loop->have_posts() ) :
	while ( $loop->have_posts() ) :
		$loop->the_post(); ?>
			<?php get_template_part( 'format', get_post_format() ); ?>
	<?php endwhile; ?>

	<?php wp_reset_postdata(); ?>

	<?php bc_douglas_fir_pagination(); ?>

<?php else : ?>
	<?php
endif;
