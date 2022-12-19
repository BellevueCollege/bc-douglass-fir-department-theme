<?php
/**
 * Featured In Content Slideshow
 *
 * @package Mayflower
 */

if ( is_front_page() ) :
	$mayflower_options = mayflower_get_options();
	if ( true === $mayflower_options['slider_toggle'] ) : ?>


		<div id="carousel-featured-in-content" class="carousel slide">
			<!-- Indicators -->
			<ol class="carousel-indicators">
			<?php
			$number    = 0;
			$the_query = new WP_Query(
				array(
					'post_type'      => 'slider',
					'posts_per_page' => ( $mayflower_options['slider_number_slides'] ),
				)
			);
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
				?>
					<li data-target="#carousel-featured-in-content" data-slide-to="<?php echo esc_attr( $number++ ); ?>" <?php echo 0 === $the_query->current_post ? 'class="active"' : ''; ?>></li>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
			</ol>


			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<?php
				$the_query = new WP_Query(
					array(
						'post_type'      => 'slider',
						'orderby'        => 'menu_order',
						'order'          => 'ASC',
						'posts_per_page' => $mayflower_options['slider_number_slides'],
					)
				);
				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					?>

					<div class="carousel-item <?php echo 0 === $the_query->current_post ? 'active' : ''; ?>">

						<?php
						// If url field has content, add the URL to the post thumbnail.
						$slider_ext_url = get_post_meta( $post->ID, '_slider_url', true );
						if ( ! empty( $slider_ext_url ) ) {
							?>
							<a href="<?php echo esc_url( $slider_ext_url ); ?>"><?php the_post_thumbnail( 'featured-in-content', array( 'class' => 'd-block w-100' ) ); ?></a>
						<?php } else { ?>
							<?php the_post_thumbnail( 'featured-in-content', array( 'class' => 'd-block w-100' ) ); ?>
						<?php } //end else ?>
						<?php
						// should we show title & excerpt?
						$mayflower_options = mayflower_get_options();
						if ( true === $mayflower_options['slider_title'] || true === $mayflower_options['slider_excerpt'] ) {
							?>
							<div class="carousel-caption d-block">
								<?php
								if ( true === $mayflower_options['slider_title'] ) {
									// If a post class has input, sanitize it and add it to the post class array.
									if ( ! empty( $slider_ext_url ) ) {
										?>
										<h2><a href="<?php echo esc_url( $slider_ext_url ); ?>"><?php the_title(); ?></a></h2>
									<?php } else { ?>
										<h2><?php the_title(); ?></h2>
									<?php } //end else ?>
									<?php
								} else {
									echo '<!-- No Title -->';
								}
								?>
								<?php if ( true === $mayflower_options['slider_excerpt'] ) { ?>
									<?php the_excerpt(); ?>
									<?php
								} else {
									echo '<!-- No Excerpt -->';
								}
								?>

							</div><!-- carousel-caption -->

							<?php } ?>
					</div><!-- item -->

					<?php
				endwhile;
				wp_reset_postdata();
				?>

			</div><!-- carousel-inner -->
			<!-- Controls -->
			<?php
			$published_posts = wp_count_posts( 'slider' )->publish;
			if ( $published_posts > 1 ) :
				?>
			<a class="carousel-control-prev" href="#carousel-featured-in-content" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous Slide</span>
			</a>
			<a class="carousel-control-next" href="#carousel-featured-in-content" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next Slide</span>
			</a>
		<?php endif; ?>
		</div>
	<?php endif; // slider toggle. ?>
<?php endif; // front page. ?>
