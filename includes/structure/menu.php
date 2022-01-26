<?php

	if ( !defined( 'ABSPATH' ) ) {
		exit;
	} // Exit if accessed directly

	/*
	 * Remove the primary and secondary menus
	 *
	 * @since 2.0.9
	 */
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_header', 'genesis_do_nav', 12 );
	remove_action( 'genesis_after_header', 'genesis_do_subnav' );

	/*
	 * Limit menu depth
	 *
	 * @since 2.3.31
	 */
	add_filter( 'wp_nav_menu_args', 'nnco_limit_menu_depth' );
	function nnco_limit_menu_depth ( $args ) {

		if ( !in_array( $args[ 'theme_location' ], array('primary', 'secondary'), true ) ) {
			return $args;
		}

		$args[ 'depth' ] = 2;

		return $args;

	}

	// Add Social Widget Area for Primay Nav
	genesis_register_sidebar( array(
		'id' => 'nav-social-menu', 'name' => __( 'Nav Social Menu' ), 'description' => __( 'This is the nav social menu section.' ),
	) );

	// Add Search to Primary / Secondary Nav
	add_filter( 'wp_nav_menu_items', 'genesis_search_primary_nav_menu', 10, 2 );
	function genesis_search_primary_nav_menu ( $menu, stdClass $args ) {
		if ( 'primary' !== $args->theme_location ) {
			return $menu;
		}
		if ( genesis_get_option( 'nav_extras' ) ) {
			return $menu;
		}
		ob_start();
		echo '<li id="menu-item-social" class="custom-social menu-item">';
		genesis_widget_area( 'nav-social-menu' );
		$social = ob_get_clean();
		echo '</li>';

		return $menu . $social;
	}

	// Add Search to = Secondary Nav
	add_filter( 'wp_nav_menu_items', 'genesis_search_secondary_nav_menu', 10, 2 );
	function genesis_search_secondary_nav_menu ( $menu, stdClass $args ) {
		if ( 'secondary' !== $args->theme_location ) {
			return $menu;
		}
		if ( genesis_get_option( 'nav_extras' ) ) {
			return $menu;
		}
		ob_start();
		echo '<li id="menu-item-social" class="custom-social menu-item">';
		genesis_widget_area( 'nav-social-menu' );
		$social = ob_get_clean();
		echo '</li>';

		return $menu . $social;
	}

	// Define our responsive menu settings.
	function nnco_header_responsive_menu_settings () {

		$settings = array(
			'mainMenu' => __( 'Menu', 'nnco' ), 'menuIconClass' => 'dashicons-before dashicons-menu', 'subMenu' => __( 'Submenu', 'nnco' ), 'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2', 'menuClasses' => array(
				'combine'   => array(
					'.nav-header-left', '.nav-header-right',
				), 'others' => array(
					'.nav-primary',
				),
			),
		);

		return $settings;

	}

	add_filter( 'supersideme_get_menus', 'prefix_get_supersideme_menus' );
	/**
	 * Replace and reorder the array of navigational menus in the SuperSide Me menu panel.
	 *
	 * @param $menus
	 *
	 * @return array
	 */
	function prefix_get_supersideme_menus ( $menus ) {
		if ( is_post_type_archive( 'agents' ) || is_singular( 'agents' ) ) {
			return array(
				'secondary' => 'Agent Navigation Menu',
			);
		} else {
			return array(
				'header-right' => 'Header Right Navigation Menu'
			);
		}
	}
