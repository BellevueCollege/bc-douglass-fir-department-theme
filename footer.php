<?php
/**
 * Footer Content
 *
 * @package Mayflower
 */

$globals = new Globals();
?>
	</div><!-- row -->
</div><!-- #main .container --><!--noindex-->

<?php

$globals->footer_legal();

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
