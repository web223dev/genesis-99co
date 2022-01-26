<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

// add_filter( 'genesis_footer_output', 'nnco_footer_creds_text' );
/**
 * Custom footer 'creds' text.
 *
 * @since 2.0.0
 */
function nnco_footer_creds_text () {

	return '<p>' . __( 'Copyright', CHILD_THEME_TEXT_DOMAIN ) . ' [footer_copyright] [footer_childtheme_link] &middot; [footer_genesis_link] [footer_studiopress_link] &middot; [footer_wordpress_link] &middot; [footer_loginout]</p>';

}

// add_action( 'wp_footer', 'nnco_disable_pointer_events_on_scroll', 99 );
/**
 * Disable pointer events when scrolling. Be careful using this with CSS :hover-enabled menus.
 *
 * See: https://gist.github.com/ossreleasefeed/7768761
 *
 * @since 2.0.20
 */
function nnco_disable_pointer_events_on_scroll () {

	ob_start();
	?>
    <script>
        if (window.addEventListener) {
            var root = document.documentElement;
            var timer;

            window.addEventListener('scroll', function () {
                clearTimeout(timer);

                if (!root.style.pointerEvents) {
                    root.style.pointerEvents = 'none';
                }

                timer = setTimeout(function () {
                    root.style.pointerEvents = '';
                }, 250);
            }, false);
        }
    </script>
	<?php
	$output = ob_get_clean();
	echo preg_replace( '/\s+/', ' ', $output ) . "\n";

}

//* Customise footer
add_action( 'genesis_before_footer', 'nnco_do_cta', 8 );
function nnco_do_cta () { ?>
    <div class="footer-cta row center-xs middle-xs start-lg">
        <div class="col col-xs-12 col-md-6 bottom-xs-40 bottom-lg-0">
			<?php if ( get_field( '_99co_cta', 'option' ) ) {
				the_field( '_99co_cta', 'option' );
			} ?>
        </div>
        <div class="col col-xs-12 col-md-6 text-xs-center col-links">
			<?php if ( get_field( '_99co_cta_ios', 'option' ) ) { ?>
                <a href="<?php the_field( '_99co_cta_ios', 'option' ); ?>" class="icon-ios" target="_blank">Download on the App Store</a>
			<?php } ?>
			<?php if ( get_field( '_99co_cta_android', 'option' ) ) { ?>
                <a href="<?php the_field( '_99co_cta_android', 'option' ); ?>" class="icon-android" target="_blank">Get it on Google Play</a>
			<?php } ?>
        </div>
    </div>
<?php }

//* Customise footer
function nnco_do_agents_cta () { ?>
    <div class="footer-cta row">
        <div class="col col-xs-12 col-md-4 col-pro row">
            <div class="inner">
                <h3>Be a Real Estate PRO</h3>
                <p>Join one of our upcoming trainings for a walkthrough with some of our experts. You can sign up for our in-house trainings or alternatively, you may contact your relationship manager to schedule a session especially for your team.</p>
                <p><a class="btn" href="#">Sign up now</a></p>
            </div>
        </div>
        <div class="col col-xs-12 col-md-8 col-app row">
            <div class="inner">
				<?php if ( get_field( '_99co_cta', 'option' ) ) {
					the_field( '_99co_cta', 'option' );
				} ?>
                <p>
					<?php if ( get_field( '_99co_cta_ios', 'option' ) ) { ?>
                        <a href="<?php the_field( '_99co_cta_ios', 'option' ); ?>" class="icon-ios" target="_blank">Download on the App Store</a>
					<?php } ?>
					<?php if ( get_field( '_99co_cta_android', 'option' ) ) { ?>
                        <a href="<?php the_field( '_99co_cta_android', 'option' ); ?>" class="icon-android" target="_blank">Get it on Google Play</a>
					<?php } ?>
                </p>
            </div>
        </div>
    </div>
<?php }

//* Customise footer
remove_action( 'genesis_footer', 'genesis_do_footer', 10 );
add_action( 'genesis_footer', 'nnco_do_footer', 8 );
function nnco_do_footer () { ?>
    <div class="footer-credits row">
        <div class="col col-xs-12 col-sm-8">
            <p>&copy; <?php echo date( 'Y' ); ?> <?php echo CHILD_THEME_NAME; ?>, All Rights Reserved.</p>
        </div>
        <div class="col col-xs-12 col-sm-4">
            <p>Website by <a class="cb" target="_blank" href="https://www.chillybin.com.sg" rel="nofollow"><span>WordPress Blog Design</span></a>
        </div>
    </div>
<?php }

/*
 * Filter the footer-widgets context of the genesis_structural_wrap to add a div before the closing wrap div.
 *
 * @param  	string  $output 		 	The markup to be returned
 * @param  	string  $original_output 	Set to either 'open' or 'close'
 *
 * @return  string 	The footer markup
 */
add_filter( 'genesis_structural_wrap-footer-widgets', 'nnco_footer_widgets_flexington_row', 10, 2 );
function nnco_footer_widgets_flexington_row ( $output, $original_output ) {
	if ( 'open' === $original_output ) {
		$output = $output . '<div class="row gutter-40">';
	}
    elseif ( 'close' === $original_output ) {
		$output = '</div>' . $output;
	}

	return $output;
}

/*
 * Filter the footer-widget markup to add flexington column classes
 *
 * @param  	string  $output 		 	The markup to be returned
 * @param  	int 	$footer_widgets 	The number of footer widgets via add_theme_support( 'genesis-footer-widgets', 4 );
 *
 * @return  string 	The footer markup
 */
add_filter( 'genesis_footer_widget_areas', 'nnco_footer_widget_flexington_cols', 10, 2 );
function nnco_footer_widget_flexington_cols ( $output, $footer_widgets ) {
	switch ( $footer_widgets ) {
		case '1':
			$classes = 'widget-area col col-xs-12 center-xs"';
			break;
		case '2':
			$classes = 'widget-area col col-xs-12 bottom-xs-20 col-sm-6"';
			break;
		case '3':
			$classes = 'widget-area col col-xs-12 bottom-xs-20 col-sm-6 col-md-4 bottom-md-40"';
			break;
		case '4':
			$classes = 'widget-area col col-xs-12 bottom-xs-0 col-sm-6 col-md-3 bottom-md-40"';
			break;
		case '6':
			$classes = 'widget-area col col-xs-6 bottom-xs-20 col-sm-4 col-md-2 bottom-md-40"';
			break;
	}
	$output = str_replace( 'widget-area"', $classes, $output );

	return $output;
}
