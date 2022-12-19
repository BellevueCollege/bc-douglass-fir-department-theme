<?php
/**
 * Page Template Part
 *
 * @package Mayflower
 */

?>
<h1><?php the_title(); ?></h1>
<?php
if ( function_exists( 'post_and_page_asides_return_title' ) ) :
	get_template_part( 'parts/aside' );
endif;
?>
<article>
	<?php the_content(); ?>
	<div class="clearfix"></div>
	<p id="modified-date" class="text-right"><small>
	<?php
	esc_attr_e( 'Last Updated ', 'mayflower' );
	the_modified_date();
	?>
	</small></p>
</article>
