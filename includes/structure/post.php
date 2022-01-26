<?php

add_action( 'genesis_before', 'nnco_tracking_code' );

function nnco_tracking_code() {

if ( current_filter() == 'genesis_before' && is_single())

echo the_field('header_script');

}


if ( !defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

add_filter( 'gallery_style', 'nnco_gallery_style' );
/**
 * Remove the injected styles for the [gallery] shortcode.
 *
 * @since 1.x
 */
function nnco_gallery_style ( $css ) {

	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );

}

/*
 * Allow pages to have excerpts.
 *
 * @since 2.2.5
 */
// add_post_type_support( 'page', 'excerpt' );

add_filter( 'the_content_more_link', 'nnco_more_tag_excerpt_link' );
/**
 * Customize the excerpt text, when using the <!--more--> tag.
 *
 * See: http://my.studiopress.com/snippets/post-excerpts/
 *
 * @since 2.0.16
 */
function nnco_more_tag_excerpt_link () {

	return ' <a class="more-link" href="' . get_permalink() . '">' . __( 'Read more &rarr;', CHILD_THEME_TEXT_DOMAIN ) . '</a>';

}

add_filter( 'excerpt_more', 'nnco_truncated_excerpt_link' );
add_filter( 'get_the_content_more_link', 'nnco_truncated_excerpt_link' );
/**
 * Customize the excerpt text, when using automatic truncation.
 *
 * See: http://my.studiopress.com/snippets/post-excerpts/
 *
 * @since 2.0.16
 */
function nnco_truncated_excerpt_link () {

	return '...';

}

remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_header', 'genesis_do_post_title', 15 );

add_filter( 'genesis_post_info', 'nnco_post_info' );
/**
 * Customize the post info text.
 *
 * See:http://www.briangardner.com/code/customize-post-info/
 *
 * @since 2.0.0
 */
function nnco_post_info () {

	$postinfo = '[post_categories before="" sep=""]';
	$postinfo .= '<span class="entry-date">' . get_the_date() . ' &middot; </span>';
	$postinfo .= '<span class="entry-reading">' . nnco_reading_time() . ' &middot; </span>';
	$postinfo .= '[post_author_posts_link before="by " after=""]';

	return $postinfo;
	// Friendly note: use [post_author] to return the author's name, without an archive link

}

// remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
add_filter( 'genesis_post_meta', 'nnco_post_meta' );
/**
 * Customize the post meta text.
 *
 * See:http://www.briangardner.com/code/customize-post-meta/
 *
 * @since 2.0.0
 */
function nnco_post_meta () {

	return '[post_tags before="" sep=""]';

}

add_filter( 'genesis_prev_link_text', 'nnco_prev_link_text' );
/**
 * Customize the post navigation prev text
 * (Only applies to the 'Previous/Next' Post Navigation Technique, set in Genesis > Theme Options).
 *
 * @since 2.0.0
 */
function nnco_prev_link_text ( $text ) {

	return html_entity_decode( '&#10216;' ) . ' ';

}

add_filter( 'genesis_next_link_text', 'nnco_next_link_text' );
/**
 * Customize the post navigation next text
 * (Only applies to the 'Previous/Next' Post Navigation Technique, set in Genesis > Theme Options).
 *
 * @since 2.0.0
 */
function nnco_next_link_text ( $text ) {

	return ' ' . html_entity_decode( '&#10217;' );

}

/*
 * Remove the post title
 *
 * @since 2.0.9
 */
// remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

/*
 * Remove the post edit links (maybe you just want to use the admin bar)
 *
 * @since 2.0.9
 */
add_filter( 'edit_post_link', '__return_false' );

/*
 * Hide the author box
 *
 * @since 2.0.18
 */
// add_filter( 'get_the_author_genesis_author_box_single', '__return_false' );
add_filter( 'get_the_author_genesis_author_box_archive', '__return_false' );

/* Modify the author box title with a shortcode */
add_filter( 'genesis_author_box_title', 'author_box_title' );
function author_box_title () {
	$title = do_shortcode( '[post_author_posts_link before="Written by " after=""]' );

	return $title;
}

/*
 * Adjust the default WP password protected form to support keeping the input and submit on the same line
 *
 * @since 2.2.18
 */
add_filter( 'the_password_form', 'nnco_password_form' );
function nnco_password_form ( $post = 0 ) {

	$post      = get_post( $post );
	$label     = 'pwbox-' . ( empty( $post->ID ) ? mt_rand() : $post->ID );
	$output    = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">';
	$autofocus = is_singular() ? 'autofocus' : '';
	$output .= '<input name="post_password" id="' . $label . '" type="password" size="20" placeholder="' . __( 'Password', CHILD_THEME_TEXT_DOMAIN ) . '" ' . $autofocus . '>';
	$output .= '<input type="submit" name="' . __( 'Submit', CHILD_THEME_TEXT_DOMAIN ) . '" value="' . esc_attr__( 'Submit' ) . '">';
	$output .= '</form>';

	return $output;

}

function nnco_reading_time () {
	global $post;
	$content     = get_post_field( 'post_content', $post->ID );
	$word_count  = str_word_count( strip_tags( $content ) );
	$readingtime = ceil( $word_count / 200 );

	if ( $readingtime === 1 ) {
		$timer = ' min read';
	}
	else {
		$timer = ' min read';
	}
	$totalreadingtime = $readingtime . $timer;

	return $totalreadingtime;
}

// Relative date & time
function nnco_relative_date () {
	return human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ago';
}

add_filter( 'get_the_date', 'nnco_relative_date' ); // for posts
add_filter( 'get_comment_date', 'nnco_relative_date' ); // for comments

/* Code to Display Featured Image on top of the post */
add_action( 'genesis_after_header', 'nnco_reading_position_indicator', 8 );
function nnco_reading_position_indicator () {
	if ( !is_singular( array('post', 'agents') ) ) {
		return;
	}
	?>
    <progress value="0"></progress>
<?php }

//add_action( 'genesis_before_loop', 'cb_post_top_leaderboard', 9 );
function cb_post_top_leaderboard () {
	if ( !is_singular( array('post', 'agents') ) ) {
		return;
	}
    $slug = get_post_field( 'post_name', get_post() );
	?>
    <div class="desktop-ads ads-top">
		<?php if(get_field('_99co_ad_article_top_desktop', 'option')): ?>
            <?php the_field('_99co_ad_article_top_desktop', 'option'); ?>
        <?php else: ?>
            <!--<div id="ad-desktop-leaderboard1" class="advertisement__container" data-js-options='{"networkCode": "4654", "adUnit1": "99co_desktop", "adUnit2": "blog", "adUnit3": "na", "adUnit4": "<?php echo $slug; ?>", "adUnit5": "leaderboard1", "device": "desktop", "sizes": [[970,250], [970,90], [728,90]]}'></div>-->

            <!-- /21958639431/99co/Insider-Article-Desktop-Leaderboard1 -->
           <div id='div-gpt-ad-1634891056096-0' style='min-width: 728px; min-height: 90px;'>
              <script>
                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1634891056096-0'); });
              </script>
            </div>
        <?php endif; ?>
    </div>
    <div class="tablet-ads ads-top">
        <?php if(get_field('_99co_ad_article_top_tablet', 'option')): ?>
		  <?php the_field('_99co_ad_article_top_tablet', 'option'); ?>
        <?php else: ?>
            <!--<div id="ad-tablet-leaderboard1" class="advertisement__container" data-js-options='{"networkCode": "4654", "adUnit1": "99co_desktop", "adUnit2": "blog", "adUnit3": "na", "adUnit4": "<?php echo $slug; ?>", "adUnit5": "leaderboard1", "device": "desktop", "sizes": [[970,250], [970,90], [728,90]]}'></div>-->

            <!-- /21958639431/99co/Insider-Article-Desktop-Leaderboard1 -->
            <div id='div-gpt-ad-1634891056096-0' style='min-width: 728px; min-height: 90px;'>
              <script>
                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1634891056096-0'); });
              </script>
            </div>
        <?php endif; ?>
    </div>
    <div class="mobile-ads ads-top">
        <?php if(get_field('_99co_ad_article_top_mobile', 'option')): ?>
		  <?php the_field('_99co_ad_article_top_mobile', 'option'); ?>
        <?php else: ?>
            <!--<div id="ad-mobile-leaderboard1" class="advertisement__container" data-js-options='{"networkCode": "4654", "adUnit1": "99co_mobileweb", "adUnit2": "blog", "adUnit3": "na", "adUnit4": "<?php echo $slug; ?>", "adUnit5": "leaderboard1", "device": "mobileweb", "sizes": [[320,100],[320,50]]}'></div>-->

            <!-- /21958639431/99co/Insider-Article-Mobile-Leaderboard -->
            <div id='div-gpt-ad-1634891875252-0' style='min-width: 320px; min-height: 50px;'>
              <script>
                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1634891875252-0'); });
              </script>
            </div>
        <?php endif; ?>
    </div>
	<?php
}

// Insert ads after X paragraph of single post content.
add_filter( 'the_content', 'prefix_insert_post_ads' );
function prefix_insert_post_ads( $content ) {

    $slug = get_post_field( 'post_name', get_post() );
    if(get_field('_99co_ad_article_top_mobile', 'option')):
        $ad_code = '<div class="mobile-ads ads-middle">' . get_field('_99co_ad_article_middle_mobile', 'option') . '</div>';
    else:
        //$ad_code = '<div class="mobile-ads ads-middle"><div id="ad-mobile-imu1" class="advertisement__container" data-js-options=\'{"networkCode": "4654", "adUnit1": "99co_mobileweb", "adUnit2": "blog", "adUnit3": "na", "adUnit4": "'. $slug.'", "adUnit5": "imu1", "device": "mobileweb", "sizes": [[300,250]]}\'></div></div>';

        $ad_code = '<!-- /21958639431/99co/Insider-Article-Mobile-MREC1 -->' +
                    '<div id=\'div-gpt-ad-1634891938847-0\' style=\'min-width: 300px; min-height: 50px;\'>' +
                      '<script>' +
                        'googletag.cmd.push(function() { googletag.display(\'div-gpt-ad-1634891938847-0\'); });' +
                      '</script>' +
                    '</div>';
    endif;

	$ad_para = intval(get_field('_99co_ad_article_middle_mobile_paragraph', 'option'));
	
	if (!$ad_para) {
		$ad_para = 3;
	}
	
	if ( is_single() && !is_admin() ) {
		//return prefix_insert_after_paragraph( $ad_code, $ad_para, $content );
	}
	
	return $content;
}

// Parent Function that makes the magic happen
function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
	$closing_p  = '</p>';
	$paragraphs = explode( $closing_p, $content );
	foreach ($paragraphs as $index => $paragraph) {

		if ( trim( $paragraph ) ) {
			$paragraphs[$index] .= $closing_p;
		}

		if ( $paragraph_id === $index + 1 ) {
			$paragraphs[$index] .= $insertion;
		}
	}

	return implode( '', $paragraphs );
}

/* Code to Display Featured Image on top of the post */
add_action( 'genesis_before_loop', 'nnco_featured_post_image', 8 );
function nnco_featured_post_image () {
	if ( !is_singular( array('post', 'agents') ) ) {
		return;
	}
	?>
    <div class="entry-image">
        <?php the_post_thumbnail( 'single-banner-size', array('class' => 'aligncenter') ); ?>
    </div>
<?php }

add_action( 'genesis_before_loop', 'nnco_post_row', 10 );
function nnco_post_row () {
	if ( !is_singular( array('post', 'agents') ) ) {
		return;
	}
	?>
    <div class="row gutter-40">
<?php }

add_action( 'genesis_before_entry', 'nnco_share_nav', 8 );
function nnco_share_nav () {
	if ( !is_singular( array('post', 'agents') ) ) {
		return;
	}
	?>
    <div class="col col-xs-12 col-lg-1 col-social">
        <ul class="social-media-nav__sticky">
            <li class="social-media-nav__facebook">
                <a target="_blank"
                   href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink(); ?>">
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
            </li>
            <li class="social-media-nav__twitter">
                <a target="_blank"
                   href="https://twitter.com/home?status=<?php echo get_the_title(); ?>%2C via @99dotco: <?php echo get_the_permalink(); ?>%2F">
                    <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
            </li>
            <li class="social-media-nav__linkedin">
                <a target="_blank"
                   href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_the_permalink(); ?>&amp;title=<?php echo get_the_title(); ?>">
                    <i class="fa fa-linkedin" aria-hidden="true"></i>
                </a>
            </li>
            <li class="social-media-nav__mail">
                <a href="mailto:?subject=<?php echo get_the_title(); ?>&amp;body=Hi,%0D%0A%0D%0AI thought you might like this article from 99.co:%0D%0A%0D%0A<?php echo strip_tags( get_the_excerpt() ); ?>%0D%0A%0D%0A<?php echo get_the_permalink(); ?>">
                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                </a>
            </li>
        </ul>
    </div>
<?php }

add_action( 'genesis_before_entry', 'nnco_post_entry_col', 10 );
function nnco_post_entry_col () {
	if ( !is_singular( array('post', 'agents') ) ) {
		return;
	}
	?>
    <div class="col col-xs-12 col-lg-7 col-content">
<?php }

//add_action( 'genesis_entry_content', 'nnco_post_entry_col_end_whatsapp' );
function nnco_post_entry_col_end_whatsapp () {
    if ( !is_singular( array('post', 'agents') ) ) {
        return;
    }
    ?>
        <a href="https://go.99.co/WhatsAppSub" style="max-width: 100%;"><img src="../wp-content/uploads/2019/03/property_whatsapp_970x250.jpg" alt="Subscribe to 99.co via Whatsapp" /></a><br/><br/>
<?php }

add_action( 'genesis_after_entry', 'nnco_post_entry_col_end', 80 );
function nnco_post_entry_col_end () {
	if ( !is_singular( array('post', 'agents') ) ) {
		return;
	}
	?>
    </div>
<?php }

add_action( 'genesis_after_entry', 'nnco_single_sidebar', 90 );
function nnco_single_sidebar () {
	if ( !is_singular( array('post', 'agents') ) ) {
		return;
	}
    $slug = get_post_field( 'post_name', get_post() );
	?>
    <div class="col col-xs-12 col-lg-4 col-side">
        <div class="desktop-ads ads-side">
            <?php if(get_field('_99co_ad_article_sidebar_above_desktop', 'option')): ?>
		      <?php the_field('_99co_ad_article_sidebar_above_desktop', 'option'); ?>
            <?php else: ?>
                <!--<div id="ad-desktop-imu1" class="advertisement__container" data-js-options='{"networkCode": "4654", "adUnit1": "99co_desktop", "adUnit2": "blog", "adUnit3": "na", "adUnit4": "<?php echo $slug; ?>", "adUnit5": "imu1", "device": "desktop", "sizes": [[300,600],[300,250]]}'></div>-->

                <!-- /21958639431/99co/Insider-Article-Desktop-Sidebar1 -->
                <div id='div-gpt-ad-1634891115696-0' style='min-width: 300px; min-height: 250px;'>
                  <script>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1634891115696-0'); });
                  </script>
                </div>
            <?php endif; ?>
        </div>
        <div class="mobile-ads ads-bottom">
            <?php if(get_field('_99co_ad_article_bottom_mobile', 'option')): ?>
		      <?php the_field('_99co_ad_article_bottom_mobile', 'option'); ?>
            <?php else: ?>
                <!--<div id="ad-mobile-imu2" class="advertisement__container" data-js-options='{"networkCode": "4654", "adUnit1": "99co_mobileweb", "adUnit2": "blog", "adUnit3": "na", "adUnit4": "<?php echo $slug; ?>", "adUnit5": "imu2", "device": "mobileweb", "sizes": [[300,250]]}'></div>-->

                <!-- /21958639431/99co/Insider-Article-Mobile-MREC2 -->
                <div id='div-gpt-ad-1634891967622-0' style='min-width: 300px; min-height: 50px;'>
                  <script>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1634891967622-0'); });
                  </script>
                </div>
            <?php endif; ?>
        </div>
        <?php
        global $post;
        $related = get_field( '_99co_recommended_articles', $post->ID );
        if (!related) {
            $related = get_field('_99co_agents_editors_picks', 'option');
        }
        if( $related ) { ?>
        <div class="widget widget_editors-picks">
            <h4>Related articles</h4>
                <div class="recommended-articles">
                    <?php foreach( $related as $relate) {
                        // load all 'category' terms for the post
                        $terms = get_the_terms( get_the_ID(), 'category');
                        // we will use the first term to load ACF data from
                        if( !empty($terms) ) {
                            $term           = array_pop($terms);
                            $categorycolour = get_field('_99co_category_colour', $term );
                        }
                        ?>
                        <article class="entry entry-post">
                            <div class="inner">
                                <div class="entry-image left-align">
                                    <?php echo get_the_post_thumbnail( $relate->ID, 'thumbnail-size' ); ?>
                                </div>
                                <header class="entry-header left-align">
                                    <?php
                                    $categories = get_the_category($relate->ID);
                                    if ( !empty( $categories ) ) {
                                        foreach ($categories as $category) {
                                            echo '<div class="entry-category" style="background-color:'. $categorycolour .'"><a href="' . esc_url(get_category_link($category->term_id)) . '" style="color: ' . $categorycolour . '">' . esc_html($category->name) . '</a> </div>';
                                        }
                                    }
                                    ?>
                                    <h4 class="entry-title">
                                        <a href="<?php echo get_the_permalink($relate->ID); ?>"><?php echo get_the_title($relate->ID); ?></a>
                                    </h4>
                                    <div class="more-link">
                                        <a href="<?php echo get_the_permalink($relate->ID); ?>">Read full story</a>
                                    </div>
                                </header>
                            </div>
                        </article>
                    <?php } ?>
                </div>
                <?php wp_reset_postdata(); ?>
            </div>
        <?php } ?>
        
        <?php
        genesis_widget_area( 'article-sidebar', array(
	        'before' => '<div class="home-side widget-area">',
	        'after'  => '</div>',
        ) );
        ?>

        <section class="widget gform_widget">
            <div class="widget-wrap">
                <?php echo do_shortcode('[gravityform id="1" title="true" description="true"]'); ?>
            </div>
        </section>

        <div class="desktop-ads ads-side">
            <?php if(get_field('_99co_ad_article_sidebar_below_desktop', 'option')): ?>
                <?php the_field('_99co_ad_article_sidebar_below_desktop', 'option'); ?>
            <?php else: ?>
                <!--<div id="ad-desktop-imu2" class="advertisement__container" data-js-options='{"networkCode": "4654", "adUnit1": "99co_desktop", "adUnit2": "blog", "adUnit3": "na", "adUnit4": "<?php echo $slug; ?>", "adUnit5": "imu2", "device": "desktop", "sizes": [[300,250]]}'></div>-->

                <!-- /21958639431/99co/Insider-Article-Desktop-Sidebar2 -->
                <div id='div-gpt-ad-1634891140539-0' style='min-width: 300px; min-height: 250px;'>
                  <script>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1634891140539-0'); });
                  </script>
                </div>
            <?php endif; ?>
        </div>
        
    </div>
    <div class="col col-xs-12 col-lg-0 col-ads">

        <div class="tablet-ads ads-bottom">
            <?php if(get_field('_99co_ad_article_bottom_tablet', 'option')): ?>
                <?php the_field('_99co_ad_article_bottom_tablet', 'option'); ?>
            <?php else: ?>
                <!--<div id="ad-tablet-imu1" class="advertisement__container" data-js-options='{"networkCode": "4654", "adUnit1": "99co_desktop", "adUnit2": "blog", "adUnit3": "na", "adUnit4": "<?php echo $slug; ?>", "adUnit5": "imu1", "device": "desktop", "sizes": [[300,250]]}'></div>-->
                <!-- /21958639431/99co/Insider-Article-Desktop-Sidebar1 -->
                <div id='div-gpt-ad-1634891115696-0' style='min-width: 300px; min-height: 250px;'>
                  <script>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1634891115696-0'); });
                  </script>
                </div>
            <?php endif; ?>
        </div>
        
    </div>
<?php }

add_action( 'genesis_after_loop', 'nnco_post_row_end', 10 );
function nnco_post_row_end () {
	if ( !is_singular( array('post', 'agents') ) ) {
		return;
	}
	?>
    </div>
<?php }

add_action( 'genesis_before_footer', 'nnco_post_mailchimp_sticky', 6 );
function nnco_post_mailchimp_sticky () {
	if ( is_post_type_archive( 'agents' ) && is_singular( 'agents' ) ) {
		if ( get_field( '99co_agents_cta_replace', 'option' ) ) { ?>
            <div class="entry-subscribe sticky animated fadeInUp">
                <div class="wrap">
                    <div class="row center-xs">
                        <div class="col col-xs-12 col-lg-6">
                            <div class="row center-xs">
                                <div class="col col-xs-12 col-lg-8">
                                    <h3><?php the_field( '99co_agents_cta', 'option' ); ?></h3>
                                </div>
                                <div class="col col-xs-12 col-lg-4">
                                    <a href="<?php the_field( '99co_agents_cta_button_url', 'option' ); ?>" class="btn" target="_blank"><?php the_field( '99co_agents_cta_button', 'option' ); ?></a>
                                </div>
                            </div>
                        </div>
                        <span class="close"></span>
                    </div>
                </div>
            </div>
		<?php } else { ?>
            <div class="entry-subscribe sticky animated fadeInUp">
                <div class="wrap">
                    <div class="row center-xs">
                        <div class="col col-xs-12 col-lg-6">
							<?php echo do_shortcode( '[gravityform id="2" title="true" description="false"]' ); ?>
                        </div>
                        <span class="close"></span>
                    </div>
                </div>
            </div>
		<?php } ?>
	<?php } else { ?>
        <div class="entry-subscribe sticky animated fadeInUp">
            <div class="wrap">
                <div class="row center-xs">
                    <div class="col col-xs-12 col-lg-6">
						<?php echo do_shortcode( '[gravityform id="2" title="true" description="false"]' ); ?>
                    </div>
                    <span class="close"></span>
                </div>
            </div>
        </div>
	<?php }
}

add_filter( 'gform_field_value_99co_mailchimp_property_type', 'nnco_add_99co_mailchimp_property_type' );
function nnco_add_99co_mailchimp_property_type ( $value ) {
	global $post;
	$mc_value = get_field( '_99co_mailchimp_property_type', $post->ID );

	return $mc_value;
}

add_filter( 'gform_field_value_99co_mailchimp_property_name', 'nnco_add_99co_mailchimp_property_name' );
function nnco_add_99co_mailchimp_property_name ( $value ) {
	global $post;
	$mc_value = get_field( '_99co_mailchimp_property_name', $post->ID );

	return $mc_value;
}

add_filter( 'gform_field_value_99co_mailchimp_location', 'nnco_add_99co_mailchimp_location' );
function nnco_add_99co_mailchimp_location ( $value ) {
	global $post;
	$mc_value = get_field( '_99co_mailchimp_location', $post->ID );

	return $mc_value;
}

add_filter( 'gform_field_value_99co_mailchimp_district', 'nnco_add_99co_mailchimp_district' );
function nnco_add_99co_mailchimp_district ( $value ) {
	global $post;
	$mc_value = get_field( '_99co_mailchimp_district', $post->ID );

	return $mc_value;
}

/*
 * Recommended articles
 *
 */
// add_action( 'genesis_after_loop', 'nnco_blog_recommended', 20 );
// Added to sidebar with custom fuciton after first ad.
function nnco_blog_recommended () {
	if ( is_single() ) {
		global $post;
		$posts = get_field( '_99co_recommended_articles', $post->ID );
		if ( $posts ) { ?>
            <div class="entry-recommended">
                <div class="wrap">
                    <h3>Related articles</h3>
                    <div class="lists-wrapper">
						<?php if ( $posts ) {

							foreach ( $posts as $p ):

								// load all 'category' terms for the post
								$terms = get_the_terms( get_the_ID(), 'category' );
								// we will use the first term to load ACF data from
								if ( !empty( $terms ) ) {
									$term           = array_pop( $terms );
									$categorycolour = get_field( '_99co_category_colour', $term );
								}
								?>
                                <div class="inner">
									<?php if ( get_field( '_99co_featured_video', $p->ID ) ) {
										$class = 'image overlay-video';
									}
									else {
										$class = 'image';
									} ?>
                                    <div class="<?php echo $class; ?>">
                                        <a href="<?php echo get_the_permalink( $p->ID ); ?>">
											<?php echo get_the_post_thumbnail( $p->ID, 'archive-size' ); ?>
                                        </a>
                                    </div>
                                    <div class="overlay">
                                        <div class="entry-category" style="background-color: <?php echo $categorycolour; ?>">
											<?php
                                            if ( !empty( $categories ) ) {
                                                foreach ($categories as $category) {
                                                    echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" style="color: ' . $categorycolour . '">' . esc_html($category->name) . '</a>';
                                                }
                                            }
											?>
                                        </div>
                                    </div>
                                    <header class="entry-header">
                                        <p class="entry-meta" itemprop="name">
											<?php printf( _x( '%s ago', '%s = human-readable time difference', '99co' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
                                            &middot;
                                            by <?php the_author_posts_link(); ?>
                                        </p>
                                        <h4 class="entry-title" itemprop="name">
                                            <a href="<?php echo get_the_permalink( $p->ID ); ?>">
												<?php
												$title = get_the_title( $p->ID );
												echo mb_strimwidth( $title, 0, 60, '...' );
												?>
                                            </a>
                                        </h4>
                                        <div class="more-link">
                                            <a href="<?php echo get_the_permalink( $p->ID ); ?>">Read full story</a>
                                        </div>
                                    </header>
                                </div>
							<?php endforeach;
						} ?>
                    </div>
                </div>
            </div>
		
		<?php }
	}
}
