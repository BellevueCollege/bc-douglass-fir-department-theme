<?php
/**
 * Mayflower Functions
 *
 * All the good stuff (or at least the require to where the good stuff is...)
 *
 * @package Mayflower
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) || die( 'Sorry, no direct access allowed' );

/**
 * Define constant used to bust style caches
 */
define( 'MAYFLOWER_STYLE_VERSION', '1.3.1' );

/*
 * Load theme options framework
 *
 * This legacy code is mainly from the Oenology theme.
 * TODO: Define new organizational schema and migrate content of functions.php
 *
 * theme-setup.php - sets theme functionality
 * wordpress-hooks.php - filters and functionality changes
 * plugin-hooks.php - filters and functionality changes for first- and third-party plugins
 * options-admin.php - defines Mayflower Admin Only option page -
 *					   consider migrating to customizer
 * options.php - theme options definition
 * options-customizer.php - translate options.php to customizer
 * network-options.php - Network Admin options pane
 */

/**
 * Theme Setup Hooks
 */
require get_template_directory() . '/inc/functions/theme-setup.php';

/**
 * Customizer Setup
 */
require get_template_directory() . '/inc/functions/options-customizer.php';

/*
* Load Mayflower Options into Variable
*
* There should be a better way of doing this, but this needs to be loaded up
* at this point, so that it can be used globally within the next includes
*/
$mayflower_options = mayflower_get_options();

/**
 * Globals Options Page Setup
 */
require get_template_directory() . '/inc/functions/globals-options.php';

/**
 * Globals Class and Functions
 */
require get_template_directory() . '/inc/functions/globals.php';

/**
 * WordPress Hooks used to configure WordPress for Mayflower
 */
require get_template_directory() . '/inc/functions/wordpress-hooks.php';

/**
 * Plugin Hooks used to configure various Plugins for Mayflower
 */
require get_template_directory() . '/inc/functions/plugin-hooks.php';


/**
 * Constants used by Classes shortcode
 */
define( 'CLASSESURL', '//www.bellevuecollege.edu/classes/All/' );
define( 'PREREQUISITEURL', '//www.bellevuecollege.edu/transfer/prerequisites/' );

/**
 * Load Bootstrap Navwalker (used for menus)
 */
require_once get_template_directory() . '/inc/wp-bootstrap-navwalker-4.0.2/class-wp-bootstrap-navwalker.php';

/**
 * Use Filter to Load Globals 4 Instead of Globals 3
 *
 * Replace 3 with 4 in URLs and paths.
 *
 * @since 3.0.0.
 *
 * @param string $path Globals Path.
 */
function mayflower_globals_4_filter( $path ) {
	return str_replace( '3', '4', $path );
}
add_filter( 'mayflower_globals_path', 'mayflower_globals_4_filter', 10, 3 );
add_filter( 'mayflower_globals_url', 'mayflower_globals_4_filter', 10, 3 );

/**
 * Load Mayflower Embedded Plugins
 *
 * These files provide plugin-like functionality embedded within Mayflower.
 *
 * @since 1.0
 */

/**
 * Mayflower Slider
 */
if ( true === $mayflower_options['slider_toggle'] ) {
	if ( file_exists( get_template_directory() . '/inc/mayflower-slider/slider.php' ) ) {
		require get_template_directory() . '/inc/mayflower-slider/slider.php';
	}
}

/**
 * Mayflower Staff
 */
if ( true === $mayflower_options['staff_toggle'] ) {
	if ( file_exists( get_template_directory() . '/inc/mayflower-staff/staff.php' ) ) {
		require get_template_directory() . '/inc/mayflower-staff/staff.php';
	}
}

/**
 * SEO Post Fields
 */
if ( file_exists( get_template_directory() . '/inc/mayflower-seo/mayflower_seo.php' ) ) {
	require get_template_directory() . '/inc/mayflower-seo/mayflower_seo.php';
}

/**
 * Course Description Shortcode
 */
if ( file_exists( get_template_directory() . '/inc/mayflower-course-descriptions/mayflower-course-descriptions.php' ) ) {
	require get_template_directory() . '/inc/mayflower-course-descriptions/mayflower-course-descriptions.php';
}


// Make this function pluggable.
if ( ! function_exists( 'mayflower_pagination' ) ) {
	/**
	 * Custom Pagination
	 *
	 * Output pagination using Globals/Mayflower styles.
	 * Function is pluggable and can be over-ridden from child themes.
	 */
	function mayflower_pagination() {
		$big = 999999999; // need an unlikely integer.

		$paginated_links = paginate_links(
			array(
				'base'               => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'             => '?paged=%#%',
				'current'            => max( 1, get_query_var( 'paged' ) ),
				'type'               => 'array',
				'prev_text'          => '<i class="fas fa-chevron-left" aria-hidden="true"></i><span class="sr-only">Previous Page</span>',
				'next_text'          => '<i class="fas fa-chevron-right" aria-hidden="true"></i><span class="sr-only">Next Page</span>',
				'before_page_number' => '<span class="sr-only">Page</span>',
			)
		);
		// Output Pagination.
		if ( $GLOBALS['wp_query']->max_num_pages > 1 ) { ?>
			<nav aria-label="Archive Pagination">
				<ul class="pagination justify-content-center">
					<?php
					foreach ( $paginated_links as $link ) {
						// Check if 'Current' class appears in string.
						$is_current = strpos( $link, 'current' );
						if ( false === $is_current ) {
							echo '<li class="page-item">';
							echo $link;
							echo '</li>';
						} else {
							echo '<li class="page-item active">';
							echo $link;
							echo '</li>';
						}
					}
					?>
				</ul>
			</nav>
			<?php
		}
	}
}


/**
 * Mayflower Is Blog function
 *
 * Returns true if the current page is a blog page
 * Filterable via mayflower_is_blog
 *
 * @return boolean $output True if is a blog page, else False.
 */
function mayflower_is_blog() {
	$output = false;

	if ( is_home() || is_archive() || is_singular( 'post' ) || is_post_type_archive( 'post' ) ) {
		$output = true;
	} else {
		$output = false;
	}

	/**
	 * Filter which pages are considered blogs.
	 *
	 * @param boolean $output.
	 */
	$output = apply_filters( 'mayflower_is_blog', $output );

	// Return filtered output.
	return $output;
}

/**
 * Has Active Sidebar function
 *
 * Check if sidebar widgets are present.
 * Filterable via mayflower_active_sidebar
 *
 * @return boolean  True if current page has an active sidebar.
 */
function has_active_sidebar() {
	$sidebar_is_active = false;

	// Default functionality.
	if ( mayflower_is_blog() ) {
		if ( is_active_sidebar( 'top-global-widget-area' ) ||
			is_active_sidebar( 'blog-widget-area' ) ||
			is_active_sidebar( 'global-widget-area' ) ) {
			$sidebar_is_active = true;
		} else {
			$sidebar_is_active = false;
		}
	} else {
		if ( is_active_sidebar( 'top-global-widget-area' ) ||
			is_active_sidebar( 'page-widget-area' ) ||
			is_active_sidebar( 'global-widget-area' ) ) {
			$sidebar_is_active = true;
		} else {
			$sidebar_is_active = false;
		}
	}

	// Disable sidebar if page template is full-width.
	if ( is_page_template( 'page-full-width.php' ) ) {
		$sidebar_is_active = false;
	}

	/**
	 * Add mayflower_active_sidebar filter
	 *
	 * Allows plugins and themes to override
	 * active sidebar state
	 *
	 * @param boolean $sidebar_is_active.
	 */
	$sidebar_is_active = apply_filters( 'mayflower_active_sidebar', $sidebar_is_active );

	return $sidebar_is_active;
}


/**
 * Mayflower Display Sidebar hook.
 *
 * Hooks in above Static in sidebar.php. Allow plugins or child themes to
 * add widgets to the sidebar, above other widget areas.
 */
function mayflower_display_sidebar() {
	do_action( 'mayflower_display_sidebar' );
}

/**
 * Is Multisite Home function
 *
 * Return true if on the multisite root homepage
 * Filterable via mayflower_is_multisite_home
 *
 * @return boolean $output True if on the Multisite homepage, else False.
 */
function is_multisite_home() {
	$output = false;

	if ( is_main_site() && is_front_page() ) {
		$output = true;
	} else {
		$output = false;
	}

	/**
	 * Filter Is Multisite Home
	 *
	 * @param boolean $output.
	 */
	$output = apply_filters( 'mayflower_is_multisite_home', $output );

	// Return filtered output.
	return $output;
}

/**
 * Mayflower Trimmed URL function
 *
 * Return trimmed URL (for example, www.bellevuecollege.edu/sample ).
 * Used for Swiftype.
 *
 * @link https://stackoverflow.com/a/4357691 Inspiration for this class.
 * @link https://github.com/BellevueCollege/bc-st-search-client Primary plugin that uses this.
 * @return string $output Trimmed URL of current site.
 */
function mayflower_trimmed_url() {
	$site_url = get_site_url( null, '', 'https' );
	$parsed   = wp_parse_url( $site_url );
	$output   = $parsed['host'] . $parsed['path'];

	/**
	 * Filter Mayflower Trimmed URL
	 *
	 * @param string $output Trimmed URL.
	 */
	$output = apply_filters( 'mayflower_trimmed_url', $output );

	// Return filtered output.
	return $output;
}


/**
 * Set $mayflower_brand variable
 *
 * Used in page templates.
 * TODO: move to function
 */
$mayflower_brand     = mayflower_get_option( 'mayflower_brand' );
$mayflower_brand_css = '';
if ( 'lite' === $mayflower_brand ) {
	$mayflower_brand_css = 'globals-lite';
} else {
	$mayflower_brand_css = 'globals-branded';
}


/**
 * Mayflower CPT Update Post Order action hook
 *
 * Save post order on custom post order page used by Staff and Slider
 */
function mayflower_cpt_update_post_order() {

	$post_type = isset( $_POST['postType'] ) ? wp_unslash( $_POST['postType'] ) : null;
	$order     = isset( $_POST['order'] ) ? wp_unslash( $_POST['order'] ) : null;

	/**
	*    Expect: $sorted = array(
	*                menu_order => post-XX
	*            );
	*/
	foreach ( $order as $menu_order => $post_id ) {
		$post_id    = intval( str_ireplace( 'post-', '', $post_id ) );
		$menu_order = intval( $menu_order );
		wp_update_post(
			array(
				'ID'         => $post_id,
				'menu_order' => $menu_order,
			)
		);
	}
	die( '1' );
}
add_action( 'wp_ajax_mayflower_cpt_update_post_order', 'mayflower_cpt_update_post_order' );

/**
 * Sitewide Notice
 */
function mayflower_sitewide_notice() {
	if ( class_exists( 'MFSN' ) && MFSN::active() ) {
		?>
		<div class="sitewide-notice container">
			<div class="alert alert-danger">
				<?php MFSN::display(); ?>
			</div>
		</div>
		<?php
	}
}
