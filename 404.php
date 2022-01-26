<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

remove_action( 'genesis_loop_else', 'genesis_do_noposts' );
remove_action( 'genesis_loop', 'genesis_do_loop' );

remove_action( 'genesis_before_footer', 'nnco_post_mailchimp_sticky', 6 );
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
remove_action( 'genesis_before_footer', 'nnco_do_cta', 8 );

remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'nnco_do_footer', 8 );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

add_action( 'genesis_loop', 'nnco_404' );
/**
 * Better default 404 text.
 *
 * See: https://yoast.com/404-error-pages-wordpress/
 *
 * @since 2.3.2
 */
function nnco_404 () {
    ?>

	<div class="row center-xs middle-xs gutter-40">
        
        <div class="col col-xs-12 col-lg-6">
            <h1 class="entry-title">Whoops!</h1>
            <p>We couldn't find the page you were looking for...</p>
            <a class="btn btn-solid btn-desktop" href="/">Go back</a>
        </div>
        <div class="col col-xs-12 col-lg-6">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/build/images/404.svg" width="520" height="438" alt="illustration of a dog sleeping near a tv with the words 404 on it" class="aligncenter">
            <a class="btn btn-solid btn-mobile" href="/">Go back</a>
        </div>
	
    </div>
    <?php
}

genesis();
