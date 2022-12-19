<?php
/**
 * Post and Page Aside Template (Deprecated)
 *
 * @package Mayflower
 */

$ppa_title   = post_and_page_asides_return_title();
$ppa_content = post_and_page_asides_return_content();
$ppa_type    = post_and_page_asides_return_type();

if ( ! empty( $ppa_content ) ) : ?>
	<aside class="pull-right col-sm-5 col-md-4 col-xs-12" id="ppa-aside">
		<div class="panel
		<?php
		switch ( $ppa_type ) {
			case 'primary':
				echo 'panel-primary';
				break;
			case 'success':
				echo 'panel-success';
				break;
			case 'info':
				echo 'panel-info';
				break;
			case 'warning':
				echo 'panel-warning';
				break;
			case 'danger':
				echo 'panel-danger';
				break;
			default:
				echo 'panel-default';
				break;
		}
		?>
			">
			<div class="panel-heading">
				<h2 class="panel-title"><?php echo wp_kses_post( $ppa_title ); ?></h2>
			</div>
			<div class="panel-body">
				<?php echo wp_kses_post( $ppa_content ); ?>
			</div>
		</div>
	</aside>
<?php endif; ?>
