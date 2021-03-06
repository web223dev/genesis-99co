<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Remove the Genesis redirect on theme upgrade
 *
 * @since 2.3.29
 */
remove_action( 'genesis_upgrade', 'genesis_upgrade_redirect' );

/*
 * Force HTML5
 *
 * See: http://www.briangardner.com/code/add-html5-markup/
 *
 * @since 2.0.0
 */
add_theme_support( 'html5', array('caption', 'comment-form', 'comment-list', 'gallery', 'search-form') );

/*
 * Genesis 2.2 accessibility features
 *
 * See: https://github.com/copyblogger/genesis-sample/commit/7613301f5e89b6fad15bb3165f607406db7c7c91
 *
 * @since 2.3.17
 */
add_theme_support( 'genesis-accessibility', array('404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links') );

/*
 * Adds <meta> tags for mobile responsiveness.
 *
 * See: http://www.briangardner.com/code/add-viewport-meta-tag/
 *
 * @since 2.0.0
 */
add_theme_support( 'genesis-responsive-viewport' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array('footer-widgets', 'footer') );

/*
 * Add Genesis post format support.
 *
 * @since 2.0.9
 */
// add_theme_support( 'post-formats', array(
// 	'aside',
// 	'chat',
// 	'gallery',
// 	'image',
// 	'link',
// 	'quote',
// 	'status',
// 	'video',
// 	'audio'
// ));
// add_theme_support( 'genesis-post-format-images' );

/*
 * Add support for after entry widget.
 *
 * @since 2.3.33
 */
// add_theme_support( 'genesis-after-entry-widget-area' );

/*
 * Add Genesis footer widget areas.
 *
 * @since 2.0.1
 */
add_theme_support( 'genesis-footer-widgets', 4 );

/*
 * Add Genesis theme color scheme selection theme option.
 *
 * @since 2.0.11
 */
// add_theme_support(
// 	'genesis-style-selector',
// 	array(
// 		'bfg-red' => 'Red',
// 		'bfg-orange' => 'Orange'
// 	)
// );

/*
 * Declare WooCommerce support, using Genesis Connect for WooCommerce.
 *
 * See: http://wordpress.org/plugins/genesis-connect-woocommerce/
 *
 * @since 2.0.6
 */
// add_theme_support( 'genesis-connect-woocommerce' );

/*
 * Unregister default Genesis layouts.
 *
 * @since 1.x
 */
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
// genesis_unregister_layout( 'full-width-content' );

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/*
 * Unregister default Genesis sidebars.
 *
 * @since 1.x
 */
unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'sidebar' );

/*
 * Unregister default Genesis menus and add your own.
 *
 * @since 2.0.18
 */
// remove_theme_support( 'genesis-menus' );
// add_theme_support(
// 	'genesis-menus',
// 	array(
// 		'primary' => 'Primary Menu',
// 		'secondary' => 'Secondary Menu',
// 	)
// );

	add_action( 'widgets_init', 'nnco_remove_genesis_widgets', 20 );
	/**
	 * Disable some or all of the default Genesis widgets.
	 *
	 * @since 2.0.0
	 */
	function nnco_remove_genesis_widgets () {

	unregister_widget( 'Genesis_Featured_Page' );									// Featured Page
	unregister_widget( 'Genesis_User_Profile_Widget' );								// User Profile
	unregister_widget( 'Genesis_Featured_Post' );									// Featured Posts

}

	add_action( 'init', 'nnco_remove_layout_meta_boxes' );
	/**
	 * Remove the Genesis 'Layout Settings' meta box for posts and/or pages.
	 *
	 * @since 2.0.0
	 */
	function nnco_remove_layout_meta_boxes () {

	remove_post_type_support( 'post', 'genesis-layouts' );							// Posts
	remove_post_type_support( 'page', 'genesis-layouts' );							// Pages

}

/*
 * Remove the Genesis 'Layout Settings' meta box for terms
 *
 * @since 2.3.23
 */
remove_theme_support( 'genesis-archive-layouts' );

	add_action( 'init', 'nnco_remove_scripts_meta_boxes' );
	/**
	 * Remove the Genesis 'Scripts' meta box for posts and/or pages.
	 *
	 * @since 2.0.12
	 */
	function nnco_remove_scripts_meta_boxes () {

	remove_post_type_support( 'post', 'genesis-scripts' );							// Posts
	remove_post_type_support( 'page', 'genesis-scripts' );							// Pages

}

/*
 * Remove the Genesis user meta boxes
 *
 * @since 2.3.30
 */
remove_action( 'show_user_profile', 'genesis_user_options_fields' );
remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );

/*
 * Disable Genesis SEO
 *
 * @since 2.0.22
 */
remove_action( 'after_setup_theme', 'genesis_seo_compatibility_check' );
	add_action( 'after_setup_theme', 'nnco_maybe_disable_genesis_seo', 8 );
	function nnco_maybe_disable_genesis_seo () {

	genesis_disable_seo();

	//* Disable Genesis <title> generation
	if( genesis_detect_seo_plugins() && function_exists( 'seo_title_tag' ) ) {
		remove_filter( 'wp_title', 'genesis_default_title', 10, 3 );
		remove_action( 'genesis_title', 'wp_title' );
		add_action( 'genesis_title', 'seo_title_tag' );
	}

}

/*
 * Use HTML5 semantic headings
 *
 * @since 2.3.4
 */
// add_filter( 'genesis_pre_get_option_semantic_headings', '__return_true' );

/*
 * Set child theme text domain
 *
 * @since 2.3.33
 */
	// add_action( 'after_setup_theme', 'nnco_load_child_theme_textdomain' );
	function nnco_load_child_theme_textdomain () {

	load_child_theme_textdomain(
		CHILD_THEME_TEXT_DOMAIN,
		get_stylesheet_directory() . '/languages'
	);

}

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'menu-primary',
	'menu-secondary',
	'site-inner',
	'footer-widgets',
	'footer',
) );
