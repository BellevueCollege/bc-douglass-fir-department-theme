<?php
/**
 * Template for displaying post type for the student-programs plugin.
 *
 * @link https://github.com/BellevueCollege/student-programs
 * @package Mayflower
 */

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$program_name          = get_post_meta( get_the_ID(), 'program_name', true );
		$program_description   = get_post_meta( get_the_ID(), 'program_description', true );
		$program_contact_name  = get_post_meta( get_the_ID(), 'program_contact_name', true );
		$program_contact_email = get_post_meta( get_the_ID(), 'program_contact_email', true );
		$program_contact_phone = get_post_meta( get_the_ID(), 'program_contact_phone', true );
		$office_location       = get_post_meta( get_the_ID(), 'Office_location', true );
		$office_hours          = get_post_meta( get_the_ID(), 'office_hours', true );
		$program_url           = get_post_meta( get_the_ID(), 'program_url', true );
		$budget_document_link  = get_post_meta( get_the_ID(), 'budget_document_link', true );


		?>


		<main role="main">
			<h1><?php the_title(); ?></h1>

			<ul>

				<?php if ( ! empty( $program_contact_name ) ) : ?>
					<li>Program Contact Name: <strong><?php echo esc_attr( $program_contact_name ); ?></strong></li>
				<?php endif; ?>

				<?php if ( ! empty( $program_contact_email ) ) : ?>
					<li>Program Contact Email: <strong><a href="mailto:<?php echo esc_attr( $program_contact_email ); ?>"><?php echo esc_attr( $program_contact_email ); ?></a></strong></li>
				<?php endif; ?>

				<?php if ( ! empty( $program_contact_phone ) ) : ?>
				<li>Program Contact Phone: <strong><?php echo esc_attr( $program_contact_phone ); ?></strong></li>
				<?php endif; ?>

				<?php if ( ! empty( $office_location ) ) : ?>
					<li>Office Location: <strong><?php echo esc_attr( $office_location ); ?></strong></li>
				<?php endif; ?>

				<?php if ( ! empty( $office_hours ) ) : ?>
					<li>Office Hours: <strong><?php echo esc_attr( $office_hours ); ?></strong></li>
				<?php endif; ?>

				<?php if ( ! empty( $program_url ) ) : ?>
					<li>Program Website: <strong><a href="<?php echo esc_url( $program_url ); ?>"> <?php echo esc_url( $program_url ); ?> </a></strong></li>
				<?php endif; ?>

			</ul>

			<?php the_content(); ?>
			<?php if ( ! empty( $budget_document_link ) ) : ?>
				<p><a href="<?php echo esc_url( $budget_document_link ); ?>" target="_blank">View Current Budget Information (opens in new window)</a></p>
			<?php endif; ?>
			<div class="clearfix"></div>
			<p id="modified-date" class="text-right"><small>
			<?php
			esc_attr_e( 'Last Updated ', 'bc-douglas-fir' );
			the_modified_date();
			?>
			</small></p>
		</main>

		<?php
	endwhile;
	wp_reset_postdata();
endif;
