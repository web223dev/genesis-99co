<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Initialize Genesis
require_once get_template_directory() . '/lib/init.php';

// Child theme definitions
define( 'CHILD_THEME_NAME', '99.co' );
define( 'CHILD_THEME_URL', 'https://www.99.co/' );
define( 'CHILD_THEME_TEXT_DOMAIN', 'nnco' );

// Developer Tools
require_once CHILD_DIR . '/includes/developer-tools.php';

// Genesis
require_once CHILD_DIR . '/includes/genesis.php';				// Customizations to Genesis-specific functions

// Admin
require_once CHILD_DIR . '/includes/admin/admin-functions.php';	// Customization to admin functionality
require_once CHILD_DIR . '/includes/admin/admin-views.php';		// Customizations to the admin area display
require_once CHILD_DIR . '/includes/admin/admin-branding.php';	// Admin view customizations that specifically involve branding
require_once CHILD_DIR . '/includes/admin/admin-options.php';	// For adding/editing theme options to Genesis
require_once CHILD_DIR . '/includes/options.php';

// Structure (corresponds to Genesis's lib/structure)
require_once CHILD_DIR . '/includes/structure/archive.php';
require_once CHILD_DIR . '/includes/structure/comments.php';
require_once CHILD_DIR . '/includes/structure/footer.php';
require_once CHILD_DIR . '/includes/structure/header.php';
require_once CHILD_DIR . '/includes/structure/layout.php';
require_once CHILD_DIR . '/includes/structure/loops.php';
require_once CHILD_DIR . '/includes/structure/menu.php';
require_once CHILD_DIR . '/includes/structure/post.php';
require_once CHILD_DIR . '/includes/structure/schema.php';
require_once CHILD_DIR . '/includes/structure/search.php';
require_once CHILD_DIR . '/includes/structure/sidebar.php';

// Shame
require_once CHILD_DIR . '/includes/shame.php';					// For new code snippets that haven't been sorted and commented yet

// this function goes in your functions.php file and requires google.js created in another gist
function google_load_file() {
		$this_post = get_queried_object();
		$author_id = $this_post->post_author;
		$name = get_the_author_meta('display_name', $author_id);
	
		wp_enqueue_script( 'author-tracking', get_stylesheet_directory_uri() . '/build/js/google.js', array(), '1.0.0', true );
		wp_localize_script( 'author-tracking', 'author', array( 'name' => $name ) );
}
add_action( 'wp_enqueue_scripts', 'google_load_file' );


add_filter( 'rss2_item', 'featured_image_in_feed' );
function featured_image_in_feed( $content ) {
    global $post;

    $output = '';
    $thumbnail_ID = get_post_thumbnail_id( $post->ID );
    $thumbnail = wp_get_attachment_image_src($thumbnail_ID, 'single-banner-size');
    $alttext = get_post_meta($thumbnail_ID, '_wp_attachment_image_alt', true);
    $output .= '<thumbnail>';
    $output .= '<url>'. $thumbnail[0] .'</url>';
    $output .= '<width>'. $thumbnail[1] .'</width>';
    $output .= '<height>'. $thumbnail[2] .'</height>';
    $output .= '<alttext>'. $alttext .'</alttext>';
    $output .= '</thumbnail>';

    echo $output;
}