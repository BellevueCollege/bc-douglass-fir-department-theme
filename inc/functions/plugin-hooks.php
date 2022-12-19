<?php
/**
 * All Plugin Hooks
 *
 * @package Mayflower
 */

defined( 'ABSPATH' ) || die( 'Sorry, no direct access allowed' );

/*
 * Plugin Hooks are hooks and filters specific to plugins used by BC
 * This allows for customization of these plugins within Mayflower
 */

/*
 * TablePress Changes
 *
 */

/*
 * Disable TablePress default stylesheet
 *
 */
add_filter( 'tablepress_use_default_css', '__return_false' );

/**
 * Add 'table' class to tablepress tables
 *
 * @param array  $classes List of classes.
 * @param string $table_id Current Table ID?.
 */
function mayflower_tablepress_classes( $classes, $table_id ) {
	$classes[] = 'table';
	return $classes;
}
add_filter( 'tablepress_table_css_classes', 'mayflower_tablepress_classes', 10, 2 );

/**
 * Wrap tablepress tables in a div
 *
 * @param string $data Tablepress output.
 */
function mayflower_tablepress_output( $data ) {
	$data = '<div class="mayflower-tablepress-wrap">' . $data . '</div>';
	return $data;
}
add_filter( 'tablepress_table_output', 'mayflower_tablepress_output', 10, 2 );

/**
 * Pantheon Advanced Cache config
 *
 * These filters and actions improve cache clearing when using
 * the Pantheon Advanced Page Cache plugin
 *
 * @link https://github.com/pantheon-systems/pantheon-advanced-page-cache
 */
add_filter(
	'pantheon_wp_main_query_surrogate_keys',
	function( $keys ) {
		global $post;

		// Top Global Sidebar Widget Area.
		if ( is_active_sidebar( 'top-global-widget-area' ) ||
		is_active_sidebar( 'global-widget-area' ) ||
		is_active_sidebar( 'page-widget-area' ) ||
		is_active_sidebar( 'blog-widget-area' ) ) {
			// Add general sidebar key.
			$keys[] = 'sidebar';
		}

		// If page has children, and has page template applied, add post ids to parent.
		if ( is_page() ) {
			// Load child pages.
			$children = get_pages(
				array(
					'child_of' => $post->ID,
				)
			);

			// Check if page has children, and has template applied.
			if ( ( count( $children ) > 0 ) && is_page_template() ) {
				// Add keys to current page.
				foreach ( $children as $child ) {
					$keys[] = 'post-' . $child->ID;
				}
			}
		}

		// Return all keys.
		return $keys;
	}
);

// Clear pages with sidebars when sidebars are updated.
add_action(
	'update_option_sidebars_widgets',
	function() {
		if ( function_exists( 'pantheon_wp_clear_edge_keys' ) ) {
			pantheon_wp_clear_edge_keys( array( 'sidebar' ) );
		}
	}
);


/**
 * Gravity Forms Overrides
 */
/**
 * Gravity Forms Tab Index override
 *
 * Start tab index at position 9 so we don't conflict with skip to links or wp admin bar
 */
add_filter( 'gform_tabindex', '__return_false' );

/**
 * Filter GravityForms buttons
 *
 * Function from https://github.com/pbc-web/gravityforms-add-button-class/
 * This function accepts an extra 'new classes' perameter, and should not be
 * used with a filter directly.
 *
 * @param string $button Button.
 * @param object $form Current form. TODO - Add details.
 * @param array  $new_classes New Classes.
 */
function mayflower_gf_add_class_to_button( $button, $form, $new_classes ) {

	preg_match( "/class='[\.a-zA-Z_ -]+'/", $button, $classes );
	if ( is_array( $classes ) && $button ) {
		$classes[0]    = substr( $classes[0], 0, -1 );
		$classes[0]   .= ' ';
		$classes[0]   .= esc_attr( $new_classes );
		$classes[0]   .= "'";
		$button_pieces = preg_split(
			"/class='[\.a-zA-Z_ -]+'/",
			$button,
			-1,
			PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
		);

		return $button_pieces[0] . $classes[0] . $button_pieces[1];
	} else {
		return $button;
	}
}

/**
 * Filter GravityForms submit button to add Bootstrap classes
 *
 * @param string $button Button.
 * @param string $form Form.
 */
function mayflower_gf_add_class_to_submit_button( $button, $form ) {
	$new_classes = 'btn btn-primary';
	return mayflower_gf_add_class_to_button( $button, $form, $new_classes );
}
add_filter( 'gform_submit_button', 'mayflower_gf_add_class_to_submit_button', 10, 2 );
/**
 * Filter GravityForms next button to add Bootstrap classes
 *
 * @param string $button Button.
 * @param string $form Form.
 */
function mayflower_gf_add_class_to_next_button( $button, $form ) {
	$new_classes = 'btn btn-primary';
	return mayflower_gf_add_class_to_button( $button, $form, $new_classes );
}
add_filter( 'gform_next_button', 'mayflower_gf_add_class_to_next_button', 10, 2 );

/**
 * Filter GravityForms previous button to add Bootstrap classes
 *
 * @param string $button Button.
 * @param string $form Form.
 */
function mayflower_gf_add_class_to_previous_button( $button, $form ) {
	$new_classes = 'btn btn-outline-secondary';
	return mayflower_gf_add_class_to_button( $button, $form, $new_classes );
}
add_filter( 'gform_previous_button', 'mayflower_gf_add_class_to_previous_button', 10, 2 );

/**
 * Filter GravityForms Save button to add Bootstrap classes
 *
 * @param string $button Button.
 * @param string $form Form.
 */
function mayflower_gf_add_class_to_save_button( $button, $form ) {
	$new_classes = 'btn btn-link';
	return mayflower_gf_add_class_to_button( $button, $form, $new_classes );
}
add_filter( 'gform_savecontinue_link', 'mayflower_gf_add_class_to_save_button', 10, 2 );
