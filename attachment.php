<?php
/**
 * Attachment Template File
 *
 * Displays File Attachments
 *
 * @package Mayflower
 */

get_header(); ?>
<?php
/**
 * Load Variables
 */
global $mayflower_brand;
$bc_douglas_fir_options = bc_douglas_fir_get_options();
$current_layout    = $bc_douglas_fir_options['default_layout'];
$description       = $post->post_content;
$caption           = $post->post_excerpt;
?>

		<?php if ( bc_douglas_fir_has_active_sidebar() ) : ?>
			<div class="col-md-9 order-1
			<?php
			if ( 'sidebar-content' !== $current_layout ) {
				?>
				order-md-0<?php } ?>">
		<?php else : // Full Width Container. ?>
			<div class="col-md-12">
		<?php endif; ?>

				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post(); /* Template format for images */
						?>
					<main role="main">
											<?php
											/*
											 * Check if attachment is an image
											 */
											if ( wp_attachment_is_image( $post->id ) ) :
												?>
							<h1><?php the_title(); ?></h1>
							<div class="wp-block-image">
								<figure class="aligncenter">
									<a href="<?php echo esc_url( wp_get_attachment_url( $post->id ) ); ?>" rel="attachment">
												<?php echo wp_get_attachment_image( get_the_ID(), 'large', false, array( 'class' => 'attachment-large img-fluid' ) ); ?>
									</a>
												<?php if ( ! empty( $caption ) ) { ?>
											<figcaption><?php echo wp_kses_post( $caption ); ?></figcaption>
									<?php } ?>
								</figure>
							</div>
												<?php if ( ! empty( $description ) ) { ?>
								<hr>
								<p><?php echo wp_kses_post( $description ); ?></p>
							<?php } ?>
												<?php
												/*
												* If attachment is non-image
												*/
											else :
												?>
							<h1>Download File</h1>
							<div class="media">
								<div class="media-left">
												<?php echo wp_get_attachment_image( $post->id, 'thumbnail', true, array( 'class' => 'media-object' ) ); ?>
								</div>
								<div class="media-body">
									<h4 class="media-heading"><a href="<?php echo esc_url( wp_get_attachment_url( $post->ID ) ); ?>"><?php the_title(); ?></a></h4>
												<?php if ( ! empty( $description ) ) { ?>
										<p><?php echo wp_kses_post( $description ); ?></p>
									<?php } ?>
								</div>
							</div>

						<?php endif; ?>

					</main><!-- content-padding -->

									<?php endwhile; ?>

					<?php
					wp_reset_query();
endif;
				?>
			</div>
		<?php if ( bc_douglas_fir_has_active_sidebar() ) : ?>
			<?php
			get_sidebar();
		endif;
		?>

<?php get_footer(); ?>
