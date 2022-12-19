<?php
/**
 * Footer Content
 *
 * @package Mayflower
 */

global $mayflower_brand;
$globals = new Globals();
?>
	</div><!-- row -->
</div><!-- #main .container --><!--noindex-->

<?php

if ( 'lite' === $mayflower_brand ) {
	$globals->footer_legal();
} else {
	$globals->footer();
}
wp_footer();
?>

<!--
	<?php
	$mayflower_version = wp_get_theme();
	echo esc_attr( $mayflower_version->get( 'Name' ) . ' version ' . $mayflower_version->get( 'Version' ) );
	?>

-->
<!--endnoindex-->
</body>
</html>
