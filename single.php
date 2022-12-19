<?php
/**
 * The Single Post Template File
 *
 * This displays all single posts.
 *
 * @package Mayflower
 */

get_header(); ?>
<?php
/**
 * Load Variables
 */
$bc_douglas_fir_options = bc_douglas_fir_get_options();
$current_layout    = $bc_douglas_fir_options['default_layout'];
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
		/*
		 * Get Single Template Part
		 *
		 * Check for post type. Look within 'parts/' directory.
		 */
		$format = get_post_format();
		if ( $format ) {
			get_template_part( 'parts/single', $format );
		} else {
			get_template_part( 'parts/single', get_post_type() );
		}
		?>
	</div>
<?php if ( bc_douglas_fir_has_active_sidebar() ) : ?>
	<?php
	get_sidebar();
endif;
?>


<?php get_footer(); ?>
