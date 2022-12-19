<?php
/**
 * Mayflower Options (Customizer Implementation)
 *
 * This file builds out all settings within the Theme Customizer
 *
 * @package Mayflower
 */

// Make pluggable.
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Mayflower_Customize_Misc_Control' ) ) {
	/**
	 * Class to add additional headings/info to the Customizer
	 *
	 * From http://coreymckrill.com/blog/2014/01/09/adding-arbitrary-html-to-a-wordpress-theme-customizer-section/
	 */
	class Mayflower_Customize_Misc_Control extends WP_Customize_Control {
		/**
		 * Settings
		 *
		 * @var string $settings Settings.
		 */
		public $settings = 'blogname';

		/**
		 * Description
		 *
		 * @var string $description Description.
		 */
		public $description = '';

		/**
		 * Render out the content to HTML
		 */
		public function render_content() {
			switch ( $this->type ) {
				default:
				case 'text':
					echo '<p class="description">' . esc_html( $this->description ) . '</p>';
					break;

				case 'heading':
					echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
					break;

				case 'line':
					echo '<hr />';
					break;
			}
		}
	}
}

/**
 * Array of default values
 *
 * WordPress does not pass out default values
 * for settings that have not been configured.
 */

$mayflower_theme_option_defaults = array(
	'mayflower_brand'        => 'lite',
	'global_nav_selection'   => 'nav-home',
	'ga_code'                => '',
	'default_layout'         => 'sidebar-content',
	'staff_toggle'           => false,
	'staff_layout'           => 'list-view',
	'staff_picture_toggle'   => true,
	'staff_phone_toggle'     => true,
	'staff_location_toggle'  => true,
	'staff_hours_toggle'     => true,
	'staff_bio_toggle'       => true,
	'staff_more_toggle'      => false,
	'display_post_date'      => true,
	'display_post_author'    => false,
	'slider_toggle'          => false,
	'slider_layout'          => 'featured-in-content',
	'slider_number_slides'   => '5',
	'slider_title'           => true,
	'slider_excerpt'         => true,
	'slider_order'           => 'menu_order',
	'blog_homepage_toggle'   => true,
	'blog_number_posts'      => '5',
	'facebook'               => '',
	'twitter'                => '',
	'linkedin'               => '',
	'youtube'                => '',
	'instagram'              => '',
	'hide_searchform'        => false,
	'limit_searchform_scope' => false,
	'custom_search_url'      => '',
	'custom_search_scope'    => '',
	'custom_search_api_key'  => '',
);

/**
 * Pass panels, settings, and controls into customizer
 *
 * WordPress does not pass out default values
 * for settings that have not been configured.
 *
 * @global $mayflower_theme_option_defaults
 * @param unknown $wp_customize Customize.
 */
function mayflower_register_theme_customizer( $wp_customize ) {
	global $mayflower_theme_option_defaults;

	/**
	 * Sanitize boolean
	 *
	 * @param boolean $input Input.
	 * @return boolean True or False.
	 */
	function sanitize_boolean( $input ) {
		if ( $input ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Sanitize URL
	 *
	 * @param string $input Input.
	 * @return string URL.
	 */
	function sanitize_ext_url( $input ) {
		return esc_url_raw(
			$input,
			array(
				'http',
				'https',
			)
		);
	}

	/**
	 * Create panels and sections
	 */
	$wp_customize->add_panel(
		'bc-douglas-fir',
		array(
			'title'       => __( 'Mayflower Theme' ),
			'description' => __( "<p>These settings center around the Bellevue College 'Mayflower' theme.</p>", 'bc-douglas-fir' ),
			'priority'    => 160, // Mixed with top-level-section hierarchy.
		)
	);
	$wp_customize->add_section(
		'mayflower_home',
		array(
			'title'    => __( 'Home Page Settings', 'bc-douglas-fir' ),
			'panel'    => 'bc-douglas-fir',
			'priority' => 31,
		)
	);
	$wp_customize->add_section(
		'mayflower_general',
		array(
			'title'    => __( 'General Settings', 'bc-douglas-fir' ),
			'panel'    => 'bc-douglas-fir',
			'priority' => 30,
		)
	);
	$wp_customize->add_section(
		'mayflower_social',
		array(
			'title'       => __( 'Social Media Settings', 'bc-douglas-fir' ),
			'panel'       => 'bc-douglas-fir',
			'description' => __( 'To display icons for social media sites, paste in URLs to your page on each platform in the spaces provided. If you leave one empty, it will not display. <strong>Only applies to Mayflower Lite branding.</strong>', 'bc-douglas-fir' ),
			'priority'    => 32,
		)
	);
	$wp_customize->add_section(
		'mayflower_admin_options',
		array(
			'title'      => __( 'Administrator Only ', 'bc-douglas-fir' ),
			'panel'      => 'bc-douglas-fir',
			'capability' => 'unfiltered_html', // Limit this section to Super-Admin only.
			'priority'   => 33,
		)
	);

	/**
	 * Customizer Settings and Controls
	 */

	/**
	 * General Settings
	 */
	$wp_customize->add_setting(
		'theme_mayflower_options[mayflower_brand]',
		array(
			'type'              => 'option',
			'capability'        => 'unfiltered_html', // Targeted for super admins only.
			'default'           => $mayflower_theme_option_defaults['mayflower_brand'],
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[global_nav_selection]',
		array(
			'type'              => 'option',
			'capability'        => 'unfiltered_html', // Targeted for super admins only.
			'default'           => $mayflower_theme_option_defaults['global_nav_selection'],
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[ga_code]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['ga_code'],
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[default_layout]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['default_layout'],
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[staff_toggle]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['staff_toggle'],
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[staff_layout]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['staff_layout'],
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[staff_picture_toggle]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['staff_picture_toggle'],
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[staff_phone_toggle]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['staff_phone_toggle'],
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[staff_location_toggle]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['staff_location_toggle'],
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[staff_hours_toggle]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['staff_hours_toggle'],
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[staff_bio_toggle]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['staff_bio_toggle'],
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[staff_more_toggle]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['staff_more_toggle'],
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[display_post_date]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['display_post_date'],
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[display_post_author]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['display_post_author'],
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'mayflower_brand',
			array(
				'label'       => __( 'Mayflower Branding', 'bc-douglas-fir' ),
				'description' => __( 'Which branding of Mayflower Theme should be used for this site?', 'bc-douglas-fir' ),
				'section'     => 'mayflower_general',
				'settings'    => 'theme_mayflower_options[mayflower_brand]',
				'type'        => 'radio',
				'choices'     => array(
					'branded' => __( 'Branded: Main college branding', 'bc-douglas-fir' ),
					'lite'    => __( 'Lite - Department branding', 'bc-douglas-fir' ),
				),
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'global_nav_selection',
			array(
				'label'       => __( 'Global Nav Selection', 'bc-douglas-fir' ),
				'description' => __( 'If <strong>branded</strong>, select which website area this site appears under', 'bc-douglas-fir' ),
				'section'     => 'mayflower_general',
				'settings'    => 'theme_mayflower_options[global_nav_selection]',
				'type'        => 'select',
				'choices'     => array(
					'nav-none'       => __( 'none', 'bc-douglas-fir' ),
					'nav-home'       => __( 'Home', 'bc-douglas-fir' ),
					'nav-classes'    => __( 'Classes', 'bc-douglas-fir' ),
					'nav-programs'   => __( 'Programs of Study', 'bc-douglas-fir' ),
					'nav-enrollment' => __( 'Enrollment', 'bc-douglas-fir' ),
					'nav-services'   => __( 'Services', 'bc-douglas-fir' ),
					'nav-campuslife' => __( 'Campus Life', 'bc-douglas-fir' ),
					'nav-about'      => __( 'About Us', 'bc-douglas-fir' ),
				),
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'ga_code',
			array(
				'label'       => __( 'Google Analytics Tracking ID', 'bc-douglas-fir' ),
				'description' => __( 'Should start with UA-[...]', 'bc-douglas-fir' ),
				'section'     => 'mayflower_general',
				'settings'    => 'theme_mayflower_options[ga_code]',
				'type'        => 'text',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'default_layout',
			array(
				'label'    => __( 'Site Layout', 'bc-douglas-fir' ),
				'section'  => 'mayflower_general',
				'settings' => 'theme_mayflower_options[default_layout]',
				'type'     => 'radio',
				'choices'  => array(
					'sidebar-content' => __( 'Sidebar left, Content right', 'bc-douglas-fir' ),
					'content-sidebar' => __( 'Sidebar right, Content left', 'bc-douglas-fir' ),
				),
			)
		)
	);
	$wp_customize->add_control(
		new Mayflower_Customize_Misc_Control(
			$wp_customize,
			'mayflower_staff-heading',
			array(
				'section' => 'mayflower_general',
				'label'   => __( 'Staff Section', 'bc-douglas-fir' ),
				'type'    => 'heading',
			)
		)
	);
	$wp_customize->add_control(
		new Mayflower_Customize_Misc_Control(
			$wp_customize,
			'mayflower_staff-desc',
			array(
				'section'     => 'mayflower_general',
				'description' => __( 'Turn on a new Staff area of the dashboard to enter employee listings', 'bc-douglas-fir' ),
				'type'        => 'text',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'staff_toggle',
			array(
				'label'    => __( 'Turn on Staff feature?', 'bc-douglas-fir' ),
				'section'  => 'mayflower_general',
				'settings' => 'theme_mayflower_options[staff_toggle]',
				'type'     => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'staff_layout',
			array(
				'label'    => __( 'Staff Layout', 'bc-douglas-fir' ),
				'section'  => 'mayflower_general',
				'settings' => 'theme_mayflower_options[staff_layout]',
				'type'     => 'radio',
				'choices'  => array(
					'list-view' => __( 'List View', 'bc-douglas-fir' ),
					'grid-view' => __( 'Grid View', 'bc-douglas-fir' ),
				),
			)
		)
	);
	$wp_customize->add_control(
		new Mayflower_Customize_Misc_Control(
			$wp_customize,
			'mayflower_staff-info-all-heading',
			array(
				'section' => 'mayflower_general',
				'label'   => __( 'Staff Information', 'bc-douglas-fir' ),
				'type'    => 'heading',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'staff_picture_toggle',
			array(
				'label'    => __( 'List Staff Picture', 'bc-douglas-fir' ),
				'section'  => 'mayflower_general',
				'settings' => 'theme_mayflower_options[staff_picture_toggle]',
				'type'     => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'staff_more_toggle',
			array(
				'label'    => __( 'List Staff "More About" Link', 'bc-douglas-fir' ),
				'section'  => 'mayflower_general',
				'settings' => 'theme_mayflower_options[staff_more_toggle]',
				'type'     => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new Mayflower_Customize_Misc_Control(
			$wp_customize,
			'mayflower_staff-info-list-heading',
			array(
				'section' => 'mayflower_general',
				'label'   => __( 'Staff Information - List View Layout Only', 'bc-douglas-fir' ),
				'type'    => 'heading',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'staff_phone_toggle',
			array(
				'label'    => __( 'List Staff Phone Number', 'bc-douglas-fir' ),
				'section'  => 'mayflower_general',
				'settings' => 'theme_mayflower_options[staff_phone_toggle]',
				'type'     => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'staff_location_toggle',
			array(
				'label'    => __( 'List Staff Office Location', 'bc-douglas-fir' ),
				'section'  => 'mayflower_general',
				'settings' => 'theme_mayflower_options[staff_location_toggle]',
				'type'     => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'staff_hours_toggle',
			array(
				'label'    => __( 'List Staff Office Hours', 'bc-douglas-fir' ),
				'section'  => 'mayflower_general',
				'settings' => 'theme_mayflower_options[staff_hours_toggle]',
				'type'     => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'staff_bio_toggle',
			array(
				'label'    => __( 'List Staff Biography', 'bc-douglas-fir' ),
				'section'  => 'mayflower_general',
				'settings' => 'theme_mayflower_options[staff_bio_toggle]',
				'type'     => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new Mayflower_Customize_Misc_Control(
			$wp_customize,
			'mayflower_post-heading',
			array(
				'section' => 'mayflower_general',
				'label'   => __( 'Post Display Settings', 'bc-douglas-fir' ),
				'type'    => 'heading',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'display_post_date',
			array(
				'label'    => __( 'Display Date on Posts', 'bc-douglas-fir' ),
				'section'  => 'mayflower_general',
				'settings' => 'theme_mayflower_options[display_post_date]',
				'type'     => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'display_post_author',
			array(
				'label'    => __( 'Display Author on Posts', 'bc-douglas-fir' ),
				'section'  => 'mayflower_general',
				'settings' => 'theme_mayflower_options[display_post_author]',
				'type'     => 'checkbox',
			)
		)
	);

	/*
	 * Home Page Settings
	 */
	$wp_customize->add_setting(
		'theme_mayflower_options[slider_toggle]',
		array(
			'type'    => 'option',
			'default' => $mayflower_theme_option_defaults['slider_toggle'],
		// TODO: Needs Sanitization.
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[slider_layout]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['slider_layout'],
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[slider_number_slides]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['slider_number_slides'],
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[slider_title]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['slider_title'],
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[slider_excerpt]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['slider_excerpt'],
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[slider_order]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['slider_order'],
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[blog_homepage_toggle]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['blog_homepage_toggle'],
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[blog_number_posts]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['blog_number_posts'],
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control(
		new Mayflower_Customize_Misc_Control(
			$wp_customize,
			'mayflower_slider-heading',
			array(
				'section'         => 'mayflower_home',
				'label'           => __( 'Home Page Slider', 'bc-douglas-fir' ),
				'type'            => 'heading',
				'active_callback' => 'is_front_page',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'slider_toggle',
			array(
				'label'           => __( 'Enable Home Page Slider feature?', 'bc-douglas-fir' ),
				'section'         => 'mayflower_home',
				'settings'        => 'theme_mayflower_options[slider_toggle]',
				'type'            => 'checkbox',
				'active_callback' => 'is_front_page',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'slider_layout',
			array(
				'label'           => __( 'Slider Layout', 'bc-douglas-fir' ),
				'section'         => 'mayflower_home',
				'settings'        => 'theme_mayflower_options[slider_layout]',
				'active_callback' => 'is_front_page',
				'type'            => 'radio',
				'choices'         => array(
					'featured-full'       => __( '100% width, featured above content', 'bc-douglas-fir' ),
					'featured-in-content' => __( 'Featured inside content area', 'bc-douglas-fir' ),
				),
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'slider_number_slides',
			array(
				'label'           => __( 'How many slides should we show?', 'bc-douglas-fir' ),
				'section'         => 'mayflower_home',
				'settings'        => 'theme_mayflower_options[slider_number_slides]',
				'active_callback' => 'is_front_page',
				'type'            => 'select',
				'choices'         => array(
					'1'  => __( '1', 'bc-douglas-fir' ),
					'2'  => __( '2', 'bc-douglas-fir' ),
					'3'  => __( '3', 'bc-douglas-fir' ),
					'4'  => __( '4', 'bc-douglas-fir' ),
					'5'  => __( '5', 'bc-douglas-fir' ),
					'6'  => __( '6', 'bc-douglas-fir' ),
					'7'  => __( '7', 'bc-douglas-fir' ),
					'8'  => __( '8', 'bc-douglas-fir' ),
					'9'  => __( '9', 'bc-douglas-fir' ),
					'10' => __( '10', 'bc-douglas-fir' ),
					'11' => __( '11', 'bc-douglas-fir' ),
					'12' => __( '12', 'bc-douglas-fir' ),
					'13' => __( '13', 'bc-douglas-fir' ),
				),
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'slider_title',
			array(
				'label'           => __( 'Show slider title?', 'bc-douglas-fir' ),
				'section'         => 'mayflower_home',
				'settings'        => 'theme_mayflower_options[slider_title]',
				'active_callback' => 'is_front_page',
				'type'            => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'slider_excerpt',
			array(
				'label'           => __( 'Show slider excerpt?', 'bc-douglas-fir' ),
				'section'         => 'mayflower_home',
				'settings'        => 'theme_mayflower_options[slider_excerpt]',
				'active_callback' => 'is_front_page',
				'type'            => 'checkbox',
			)
		)
	);

	/*
	 The slider order functionality is not implimented.
	 * Control has been commented to avoid confusion.

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'slider_order',
			array(
				'label'          => __( 'Slide Order', 'bc-douglas-fir' ),
				'section'        => 'mayflower_home',
				'settings'       => 'theme_mayflower_options[slider_order]',
				'type'           => 'radio',
				'choices'        => array(
					'menu_order'       => __( 'Sort Order (as set)', 'bc-douglas-fir' ),
					'rand' => __( 'Randomized', 'bc-douglas-fir' ),
				)
			)
		)
	);
	*/

	$wp_customize->add_control(
		new Mayflower_Customize_Misc_Control(
			$wp_customize,
			'mayflower_blog-line',
			array(
				'section'         => 'mayflower_home',
				'type'            => 'line',
				'active_callback' => 'is_front_page',
			)
		)
	);
	$wp_customize->add_control(
		new Mayflower_Customize_Misc_Control(
			$wp_customize,
			'mayflower_blog-heading',
			array(
				'section'         => 'mayflower_home',
				'label'           => __( 'Blog Posts on Home Page', 'bc-douglas-fir' ),
				'active_callback' => 'is_front_page',
				'type'            => 'heading',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'blog_homepage_toggle',
			array(
				'label'           => __( 'Enable blog posts on home page?', 'bc-douglas-fir' ),
				'description'     => __( 'Show recent blog posts below home page content. Only applies if homepage is set to a static page.', 'bc-douglas-fir' ),
				'section'         => 'mayflower_home',
				'settings'        => 'theme_mayflower_options[blog_homepage_toggle]',
				'active_callback' => 'is_front_page',
				'type'            => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'blog_number_posts',
			array(
				'label'           => __( 'Number of blog posts', 'bc-douglas-fir' ),
				'description'     => __( 'How many blog posts should display below page content?', 'bc-douglas-fir' ),
				'section'         => 'mayflower_home',
				'settings'        => 'theme_mayflower_options[blog_number_posts]',
				'active_callback' => 'is_front_page',
				'type'            => 'select',
				'choices'         => array(
					'1'  => __( '1', 'bc-douglas-fir' ),
					'2'  => __( '2', 'bc-douglas-fir' ),
					'3'  => __( '3', 'bc-douglas-fir' ),
					'4'  => __( '4', 'bc-douglas-fir' ),
					'5'  => __( '5', 'bc-douglas-fir' ),
					'6'  => __( '6', 'bc-douglas-fir' ),
					'7'  => __( '7', 'bc-douglas-fir' ),
					'8'  => __( '8', 'bc-douglas-fir' ),
					'9'  => __( '9', 'bc-douglas-fir' ),
					'10' => __( '10', 'bc-douglas-fir' ),
				),
			)
		)
	);

	/*
	 * Social Media Settings
	 */
	$wp_customize->add_setting(
		'theme_mayflower_options[facebook]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['facebook'],
			'sanitize_callback' => 'sanitize_ext_url',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[twitter]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['twitter'],
			'sanitize_callback' => 'sanitize_ext_url',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[linkedin]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['linkedin'],
			'sanitize_callback' => 'sanitize_ext_url',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[youtube]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['youtube'],
			'sanitize_callback' => 'sanitize_ext_url',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[instagram]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['instagram'],
			'sanitize_callback' => 'sanitize_ext_url',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'facebook',
			array(
				'label'    => __( 'Facebook', 'bc-douglas-fir' ),
				'section'  => 'mayflower_social',
				'settings' => 'theme_mayflower_options[facebook]',
				'type'     => 'text',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'twitter',
			array(
				'label'    => __( 'Twitter', 'bc-douglas-fir' ),
				'section'  => 'mayflower_social',
				'settings' => 'theme_mayflower_options[twitter]',
				'type'     => 'text',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'linkedin',
			array(
				'label'    => __( 'LinkedIn', 'bc-douglas-fir' ),
				'section'  => 'mayflower_social',
				'settings' => 'theme_mayflower_options[linkedin]',
				'type'     => 'text',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'youtube',
			array(
				'label'    => __( 'YouTube', 'bc-douglas-fir' ),
				'section'  => 'mayflower_social',
				'settings' => 'theme_mayflower_options[youtube]',
				'type'     => 'text',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'instagram',
			array(
				'label'    => __( 'Instagram', 'bc-douglas-fir' ),
				'section'  => 'mayflower_social',
				'settings' => 'theme_mayflower_options[instagram]',
				'type'     => 'text',
			)
		)
	);
	/**
	 * Admin Only Settings
	 */
	$wp_customize->add_setting(
		'theme_mayflower_options[hide_searchform]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['hide_searchform'],
			'transport'         => 'refresh',
			'capability'        => 'unfiltered_html', // Limit this section to Super-Admin only.
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[limit_searchform_scope]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['limit_searchform_scope'],
			'transport'         => 'refresh',
			'capability'        => 'unfiltered_html', // Limit this section to Super-Admin only.
			'sanitize_callback' => 'sanitize_boolean',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[custom_search_scope]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['custom_search_scope'],
			'transport'         => 'refresh',
			'capability'        => 'unfiltered_html', // Limit this section to Super-Admin only.
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_setting(
		'theme_mayflower_options[custom_search_url]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['custom_search_url'],
			'transport'         => 'refresh',
			'capability'        => 'unfiltered_html', // Limit this section to Super-Admin only.
			'sanitize_callback' => 'esc_url',
		)
	);
	$wp_customize->add_setting(
		'theme_mayflower_options[custom_search_api_key]',
		array(
			'type'              => 'option',
			'default'           => $mayflower_theme_option_defaults['custom_search_api_key'],
			'transport'         => 'refresh',
			'capability'        => 'unfiltered_html', // Limit this section to Super-Admin only.
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'hide_searchform',
			array(
				'label'       => __( 'Hide Search Form', 'bc-douglas-fir' ),
				'description' => __( 'Hide Search in Mayflower Lite', 'bc-douglas-fir' ),
				'section'     => 'mayflower_admin_options',
				'settings'    => 'theme_mayflower_options[hide_searchform]',
				'type'        => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'limit_searchform_scope',
			array(
				'label'       => __( 'Limit Search Form Scope', 'bc-douglas-fir' ),
				'description' => __( 'Limit search results to pages within the subsite', 'bc-douglas-fir' ),
				'section'     => 'mayflower_admin_options',
				'settings'    => 'theme_mayflower_options[limit_searchform_scope]',
				'type'        => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'custom_search_scope',
			array(
				'label'       => __( 'Custom Search Scope', 'bc-douglas-fir' ),
				'description' => __( 'Use a custom search scope instead the current site. Comma separated list of URL or URL parts.', 'bc-douglas-fir' ),
				'section'     => 'mayflower_admin_options',
				'settings'    => 'theme_mayflower_options[custom_search_scope]',
				'type'        => 'text',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'custom_search_url',
			array(
				'label'       => __( 'Custom Search URL', 'bc-douglas-fir' ),
				'description' => __( 'Allows definition of a custom URL for search (instead of passing a filter)', 'bc-douglas-fir' ),
				'section'     => 'mayflower_admin_options',
				'settings'    => 'theme_mayflower_options[custom_search_url]',
				'type'        => 'url',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'custom_search_api_key',
			array(
				'label'       => __( 'Custom Search API Key', 'bc-douglas-fir' ),
				'description' => __( 'Allows definition of a custom public API key for autofill. Required if custom URL is defined. ', 'bc-douglas-fir' ),
				'section'     => 'mayflower_admin_options',
				'settings'    => 'theme_mayflower_options[custom_search_api_key]',
				'type'        => 'text',
			)
		)
	);
}

add_action( 'customize_register', 'mayflower_register_theme_customizer' );

/**
 * Disable custom icon
 *
 * @param object $wp_customize Customizer object.
 */
function mf_remove_icon_customtizer( $wp_customize ) {
	$wp_customize->remove_control( 'site_icon' );
}
add_action( 'customize_register', 'mf_remove_icon_customtizer', 20, 1 );


/**
 * Load options and merge with defaults array
 *
 * Returns array of all mayflower options.
 */
function bc_douglas_fir_get_options() {
	/* Globalize $mayflower_theme_option_defaults */
	global $mayflower_theme_option_defaults;

	/* Merge theme options and theme options defaults */
	$bc_douglas_fir_options = wp_parse_args( get_option( 'theme_mayflower_options', array() ), $mayflower_theme_option_defaults );

	/* return all values */
	return $bc_douglas_fir_options;
}

/**
 * Return value of option
 *
 * Pass option key to get option value.
 *
 * @param string $option Option name.
 * @return string Option value from Mayflower Options.
 */
function bc_douglas_fir_get_option( $option ) {
	$bc_douglas_fir_options = bc_douglas_fir_get_options();
	$option            = $bc_douglas_fir_options[ $option ];
	return $option;
}
