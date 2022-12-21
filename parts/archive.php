<?php
/**
 * Post Archive Part
 *
 * @package BC Douglas Fir Theme
 */

?>
<h1 class="archive_title">
	<?php if ( is_category() ) { ?>
		<?php single_cat_title(); ?>
	<?php } elseif ( is_tag() ) { ?>
		<?php single_tag_title(); ?>
	<?php } elseif ( is_author() ) { ?>
		<?php
		$author = get_userdata( get_query_var( 'author' ) );
			esc_attr_e( 'Posts by ', 'bc-douglas-fir' );
			echo esc_attr( $author->display_name );
		?>
	<?php } elseif ( is_day() ) { ?>
		<?php the_time( 'l, F j, Y' ); ?>
	<?php } elseif ( is_month() ) { ?>
		<?php the_time( 'F Y' ); ?>
	<?php } elseif ( is_year() ) { ?>
		<?php the_time( 'Y' ); ?>
	<?php } else { ?>
		Archive<!-- No Page Title Available -->
	<?php } ?>
</h1>
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
			<?php get_template_part( 'format', get_post_format() ); ?>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>

	<?php bc_douglas_fir_pagination(); ?>
<?php else :
	get_template_part( 'parts/content', 'none' );
endif; ?>
