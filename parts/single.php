<?php
/**
 * Single Template for Posts
 *
 * @package Mayflower
 */

// Load Mayflower options into array.
$mayflower_options = mayflower_get_options();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post(); ?>
	<main id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="main">
		<h1><?php the_title(); ?></h1>
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
					the_date();
					?>
					<?php
					endif;
				// Check if post author should be displayed.
				if ( $mayflower_options['display_post_author'] ) :
					?>
					&nbsp;<span class="pull-right"><?php esc_attr_e( 'Author: ', 'mayflower' ); ?><?php the_author_posts_link(); ?></span>
				<?php endif; ?>
			</p>
			<?php endif; ?>

			<?php
			if ( function_exists( 'post_and_page_asides_return_title' ) ) :
				get_template_part( 'parts/aside' );
			endif;
			?>
		<article>

			<?php if ( has_post_thumbnail() && 'video' !== get_post_format() ) : ?>

				<?php
				if ( get_post_format() === 'image' ) : // Output for Image posts.

					$tn_id = get_post_thumbnail_id( $post->ID );
					$img   = wp_get_attachment_image_src( $tn_id, 'large' );
					$width = $img[1];
					?>
					<div class="wp-block-image">
						<figure class="aligncenter">
							<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?>
							<?php if ( get_post( get_post_thumbnail_id() )->post_excerpt ) : ?>
								<figcaption class="featured-caption wp-caption-text"><?php echo wp_kses_post( get_post( get_post_thumbnail_id() )->post_excerpt ); ?></figcaption>
							<?php endif; ?>
						</figure><!-- wp-caption -->
					</div>

				<?php else :  // Output for Standard Posts. ?>

					<?php
					if ( get_post( get_post_thumbnail_id() )->post_excerpt ) :

						$tn_id = get_post_thumbnail_id( $post->ID );
						$img   = wp_get_attachment_image_src( $tn_id, 'medium' );
						$width = $img[1];
						?>

						<figure class="img-thumbnail alignleft wp-caption">
							<?php the_post_thumbnail( 'medium' ); ?>
							<figcaption class="featured-caption wp-caption-text" style="width:<?php echo esc_attr( $width . 'px' ); ?>"><?php echo wp_kses_post( get_post( get_post_thumbnail_id() )->post_excerpt ); ?></figcaption>
						</figure><!-- wp-caption. -->
					<?php else : ?>
						<?php the_post_thumbnail( 'medium', array( 'class' => 'img-thumbnail alignleft' ) ); ?>
					<?php endif; ?>

				<?php endif; ?>

			<?php endif; ?>

				<?php the_content(); ?>
			<div class="clearfix"></div>
			<p id="modified-date" class="text-right"><small>
			<?php
			esc_attr_e( 'Last Updated ', 'mayflower' );
			the_modified_date();
			?>
			</small></p>
		</article>
	</main>
		<?php endwhile; ?>

	<?php wp_reset_postdata();
endif; ?>
