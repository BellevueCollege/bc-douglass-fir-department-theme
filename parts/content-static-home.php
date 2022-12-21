<?php
/**
 * Content Template for BC Douglas Fir Theme Static Homepage
 *
 * @package BC Douglas Fir Theme
 */

$bc_douglas_fir_options = bc_douglas_fir_get_options();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post(); ?>
	<h1 class="sr-only"><?php the_title(); ?></h1>
			<?php
			/**
			 * Prevent Empty Container from loading if there is no content
			 */
			if ( '' !== $post->post_content ) :
				?>
		<main data-swiftype-name="body" data-swiftype-type="text">
				<?php the_content(); ?>
		</main>
		<?php endif; ?>
		<?php
		/**
		 * Check if posts are displayed on static homepage
		 */
		if ( true === $bc_douglas_fir_options['blog_homepage_toggle'] ) :
			?>
		<div id="static-homepage-posts">

				<?php
				// Loop for posts.
				$args = array(
					'post_type'      => 'post',
					'order_by'       => 'date',
					'order'          => 'DESC',
					'posts_per_page' => $bc_douglas_fir_options['blog_number_posts'],
					'post_status'    => 'publish',
				);

				$loop = new WP_Query( $args );
				if ( $loop->have_posts() ) :
					while ( $loop->have_posts() ) :
						$loop->the_post();
						?>
						<?php get_template_part( 'format', get_post_format() ); ?>
				<?php endwhile; ?>
				<?php else : ?>
			<?php endif; ?>
				<?php wp_reset_postdata(); ?>

		</div>
		<?php endif; ?>
	<?php endwhile; else : ?>
	<p><?php esc_attr_e( 'Sorry, these aren\'t the bytes you are looking for.' ); ?></p>
	<?php endif; ?>
