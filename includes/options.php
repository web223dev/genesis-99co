<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( array(
		'page_title' => 'Theme General Settings',
		'menu_title' => 'Theme Settings',
		'menu_slug'  => 'theme-general-settings',
		'capability' => 'edit_posts',
		'redirect'   => false,
	) );

	acf_add_options_sub_page( array(
		'page_title'  => 'Theme Header Settings',
		'menu_title'  => 'Header',
		'parent_slug' => 'theme-general-settings',
	) );

	acf_add_options_sub_page( array(
		'page_title'  => 'Theme Blog Settings',
		'menu_title'  => 'Blog',
		'parent_slug' => 'theme-general-settings',
	) );

	acf_add_options_sub_page( array(
		'page_title'  => 'Theme Agents Settings',
		'menu_title'  => 'Agents',
		'parent_slug' => 'theme-general-settings',
	) );

	acf_add_options_sub_page( array(
		'page_title'  => 'Theme Footer Settings',
		'menu_title'  => 'Footer',
		'parent_slug' => 'theme-general-settings',
	) );

}

//* Register after post widget area
genesis_register_sidebar( array(
	'id'          => 'homepage-sidebar',
	'name'        => __( 'Homepage Sidebar', '99co' ),
	'description' => __( 'This is a widget area that comes below the Editors Picks on the Homepage', '99co' ),
) );

//* Register after post widget area
genesis_register_sidebar( array(
      'id'          => 'article-sidebar',
      'name'        => __( 'Article Sidebar', '99co' ),
      'description' => __( 'This is a widget area that comes below the Editors Picks on an Article', '99co' ),
) );

//* Register after post widget area
genesis_register_sidebar( array(
	'id'          => 'agents-sidebar',
	'name'        => __( 'Agents Sidebar', '99co' ),
	'description' => __( 'This is a widget area that comes below the Editors Picks on the Agents CPT', '99co' ),
) );

add_shortcode( 'mailchimp', 'get_mailchimp' );
function get_mailchimp() {
	$mailchimp = '<div class="entry-mailchimp"><div class="row middle-xs"><div class="col col-xs-12">';
	$mailchimp .= do_shortcode( '[gravityform id="1" title="true" description="true" tabindex="30"]' );
	$mailchimp .= '</div></div></div>';

	return $mailchimp;
}

add_shortcode( 'banner', 'get_banner' );
function get_banner( $code ) {

	if ( have_rows( '99co_blog_banner', 'option' ) ):

		while ( have_rows( '99co_blog_banner', 'option' ) ) : the_row();

			$shortcode = get_sub_field( 'shortcode', 'option' );

			$att = $code[ 'code' ];

			if ( $att === $shortcode ) {

				$image = get_sub_field( 'image', 'option' );

				if ( !empty( $image ) ) {

					// vars
					$url    = get_sub_field( 'link', 'option' );
					$target = get_sub_field( 'target', 'option' );

					$title = $image[ 'title' ];
					$alt   = $image[ 'alt' ];

					// thumbnail
					$size   = 'post-banner-size';
					$thumb  = $image[ 'sizes' ][ $size ];
					$width  = $image[ 'sizes' ][ $size . '-width' ];
					$height = $image[ 'sizes' ][ $size . '-height' ];

					$banner = '<div class="entry-banner"><div class="row center-xs"><div class="col col-xs-12">';
					$banner .= '<a href="' . $url . '" title="' . $title . '"';
					if ( $target ) {
						$banner .= ' target="blank"';
					}
					$banner .= '><img src="' . $thumb . '" alt="' . $alt . '" width="' . $width . '" height="' . $height . '" />';
					$banner .= '</a>';
					$banner .= '</div></div></div>';

					return $banner;

				}

			}

		endwhile;

	endif;

}

function get_archive_banner() {

	if ( have_rows( '99co_blog_archive_banner', 'option' ) ):

		while ( have_rows( '99co_blog_archive_banner', 'option' ) ) : the_row();

			$image = get_sub_field( 'image', 'option' );

			if ( !empty( $image ) ) {

				// vars
				$url    = get_sub_field( 'link', 'option' );
				$target = get_sub_field( 'target', 'option' );

				$title = $image[ 'title' ];
				$alt   = $image[ 'alt' ];

				// thumbnail
				$size   = 'archive-banner-size';
				$thumb  = $image[ 'sizes' ][ $size ];
				$width  = $image[ 'sizes' ][ $size . '-width' ];
				$height = $image[ 'sizes' ][ $size . '-height' ];

				$banner = '<div class="inner-banner"><div class="row center-xs"><div class="col col-xs-12">';
				$banner .= '<a href="' . $url . '" title="' . $title . '"';
				if ( $target ) {
					$banner .= ' target="blank"';
				}
				$banner .= '><img src="' . $thumb . '" alt="' . $alt . '" width="' . $width . '" height="' . $height . '" />';
				$banner .= '</a>';
				$banner .= '</div></div></div>';

				return $banner;

			}

		endwhile;

	endif;

}

if ( !function_exists( '99co_agents' ) ) {

	// Register Custom Post Type
	function _99co_agents() {

		$labels = array(
			'name'                  => _x( 'Agents', 'Post Type General Name', '99co' ),
			'singular_name'         => _x( 'Agent', 'Post Type Singular Name', '99co' ),
			'menu_name'             => __( 'Agents', '99co' ),
			'name_admin_bar'        => __( 'Agent', '99co' ),
			'archives'              => __( 'Item Archives', '99co' ),
			'attributes'            => __( 'Item Attributes', '99co' ),
			'parent_item_colon'     => __( 'Parent Item:', '99co' ),
			'all_items'             => __( 'All Items', '99co' ),
			'add_new_item'          => __( 'Add New Item', '99co' ),
			'add_new'               => __( 'Add New', '99co' ),
			'new_item'              => __( 'New Item', '99co' ),
			'edit_item'             => __( 'Edit Item', '99co' ),
			'update_item'           => __( 'Update Item', '99co' ),
			'view_item'             => __( 'View Item', '99co' ),
			'view_items'            => __( 'View Items', '99co' ),
			'search_items'          => __( 'Search Item', '99co' ),
			'not_found'             => __( 'Not found', '99co' ),
			'not_found_in_trash'    => __( 'Not found in Trash', '99co' ),
			'featured_image'        => __( 'Featured Image', '99co' ),
			'set_featured_image'    => __( 'Set featured image', '99co' ),
			'remove_featured_image' => __( 'Remove featured image', '99co' ),
			'use_featured_image'    => __( 'Use as featured image', '99co' ),
			'insert_into_item'      => __( 'Insert into item', '99co' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', '99co' ),
			'items_list'            => __( 'Items list', '99co' ),
			'items_list_navigation' => __( 'Items list navigation', '99co' ),
			'filter_items_list'     => __( 'Filter items list', '99co' ),
		);
		$args   = array(
			'label'               => __( 'Agent', '99co' ),
			'description'         => __( 'Agents', '99co' ),
			'labels'              => $labels,
			'supports'            => array('title', 'editor', 'revisions', 'thumbnail'),
			'taxonomies'          => array('category', 'post_tag'),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( 'agents', $args );

	}

	add_action( 'init', '_99co_agents', 0 );

}

function get_agents_banner() {

	if ( have_rows( '_99co_agents_archive_banner', 'option' ) ):

		while ( have_rows( '_99co_agents_archive_banner', 'option' ) ) : the_row();

			$image = get_sub_field( 'image', 'option' );

			if ( !empty( $image ) ) {

				// vars
				$url    = get_sub_field( 'link', 'option' );
				$target = get_sub_field( 'target', 'option' );

				$title = $image[ 'title' ];
				$alt   = $image[ 'alt' ];

				// thumbnail
				$size   = 'archive-banner-size';
				$thumb  = $image[ 'sizes' ][ $size ];
				$width  = $image[ 'sizes' ][ $size . '-width' ];
				$height = $image[ 'sizes' ][ $size . '-height' ];

				$banner = '<div class="inner-banner"><div class="row center-xs"><div class="col col-xs-12">';
				$banner .= '<a href="' . $url . '" title="' . $title . '"';
				if ( $target ) {
					$banner .= ' target="blank"';
				}
				$banner .= '><img src="' . $thumb . '" alt="' . $alt . '" width="' . $width . '" height="' . $height . '" />';
				$banner .= '</a>';
				$banner .= '</div></div></div>';

				return $banner;

			}

		endwhile;

	endif;

}
