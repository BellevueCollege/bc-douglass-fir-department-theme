<?php
/**
 * Top Navigation Part
 *
 * @package Mayflower
 */

/** Loading WordPress Custom Menu with Fallback to wp_list_pages **/
	wp_nav_menu(
		array(
			'theme_location'  => 'nav-top',
			'container'       => 'nav',
			'container_class' => 'row navbar navbar-dark bg-primary navbar-expand-md',
			'container_id'    => 'college-navbar',
			'menu_class'      => 'nav navbar-nav nav-fill flex-fill',
			'fallback_cb'     => 'false',
			'items_wrap'      => '<ul class="nav navbar-nav nav-fill flex-fill" id="main-nav"><li id="nav-top"><a class="nav-link" href="#top">Top ^</a></li>%3$s</ul>',
			'menu_id'         => 'main-nav',
			'depth'           => 1,
			'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
			'walker'          => new WP_Bootstrap_Navwalker(),
		)
	);

