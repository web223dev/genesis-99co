<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * 99.co Genesis Child.
 *
 * @since        1.0.0
 *
 * @copyright    Copyright (c) 2017, Contributors to 99.co Genesis Child project
 * @license      GPL-2.0+
 */

/*
 * Home Latest.
 */
add_action( 'cb_content_area', 'cb_search_latest' );
function cb_search_latest() { ?>

    <div class="archive-section">

        <div class="desktop-ads ads-top">
            <?php the_field('_99co_ad_ros_top_desktop', 'option'); ?>
        </div>

        <div class="tablet-ads ads-top">
            <?php the_field('_99co_ad_ros_top_tablet', 'option'); ?>
        </div>

        <div class="row gutter-40">
            <div class="col col-xs-12 col-lg-8">

                <div class="mobile-ads ads-top">
                    <?php the_field('_99co_ad_ros_top_mobile', 'option'); ?>
                </div>

                <div class="archive-description">
                    <?php
                    $title = sprintf( '<h1 class="archive-title">%s “%s”</h1>', apply_filters( 'genesis_search_title_text', __( 'Search results for', CHILD_THEME_TEXT_DOMAIN ) ), get_search_query() );
                    echo apply_filters( 'genesis_search_title_output', $title ) . "\n";
                    global $wp_query;
                    $total_results = $wp_query->found_posts;
                    $posts = get_option( 'posts_per_page' );
                    echo sprintf( '<div class="archive-results">%s results</div>', $total_results);
                    ?>
                </div>

                <div class="lists-wrapper">
                    <?php
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            global $post;

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
                                        <?php the_post_thumbnail( 'slider-size' ); ?>
                                    </div>
                                    <header class="entry-header left-align">
                                        <?php
                                        $categories = get_the_category();
                                        if ( !empty( $categories ) ) {
                                            foreach ($categories as $category) {
                                                echo '<div class="entry-category" style="background-color:'. $categorycolour .'"><a href="' . esc_url(get_category_link($category->term_id)) . '" style="color: ' . $categorycolour . '">' . esc_html($category->name) . '</a> </div>';
                                            }
                                        }
                                        ?>
                                        <p class="entry-meta">
                                            <?php printf( _x( '%s ago', '%s = human-readable time difference', '99co' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
                                            &middot;
                                            by <?php the_author_posts_link(); ?>
                                        </p>
                                        <h4 class="entry-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                        <div class="entry-content">
                                            <?php the_excerpt(); ?>
                                        </div>
                                        <div class="more-link">
                                            <a href="<?php the_permalink(); ?>">Read full story</a>
                                        </div>
                                    </header>
                                </div>
                            </article>
                        <?php }
                    }
                    wp_reset_postdata();
                    ?>

                    <div class="load-more">
                        <a href="#" class="btn" data-count="<?php echo $posts; ?>" data-search="<?php echo get_search_query(); ?>" data-type="post" data-loading="0">Load more</a>
                    </div>
                
                </div>
            </div>
            <div class="col col-xs-12 col-lg-4 side">

                <?php /* Removed 01/02/2019
                <div class="desktop-ads ads-side">
                    <?php the_field('_99co_ad_ros_sidebar_above_desktop', 'option'); ?>
                </div>
                **/
                ?>

                <div class="widget widget_editors-picks">
                    <h2>Recommended articles</h2>
                    <?php

                    $posts = get_field('_99co_picks', 'option');

                    if( $posts ): ?>
                        <ol>
                            <?php foreach( $posts as $post): ?>
                                <?php setup_postdata($post); ?>
                                <?php
                                // load all 'category' terms for the post
                                $terms = get_the_terms( get_the_ID(), 'category');
                                // we will use the first term to load ACF data from
                                if( !empty($terms) ) {
                                    $term           = array_pop($terms);
                                    $categorycolour = get_field('_99co_category_colour', $term );
                                }
                                ?>
                                <li style="color: <?php echo $categorycolour; ?>; border-color: <?php echo $categorycolour; ?>">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
                <?php
                $background = get_field('_99co_widget_background_colour', 'option');
                if ($background) { ?>
                    <div class="widget widget_promo" style="background-color: <?php echo $background; ?>">
                        <?php
                        $image = get_field('_99co_widget_image', 'option');

                        if( !empty($image) ):

                            // vars
                            $title = $image['title'];
                            $alt   = $image['alt'];

                            // thumbnail
                            $size   = 'large';
                            $thumb  = $image['sizes'][ $size ];
                            $width  = $image['sizes'][ $size . '-width' ];
                            $height = $image['sizes'][ $size . '-height' ];
                            ?>

                            <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />

                            <a href="<?php the_field('_99co_widget_button_url', 'option'); ?>" class="btn"><?php the_field('_99co_widget_button', 'option'); ?></a>

                        <?php endif; ?>
                    </div>
                <?php }

                genesis_widget_area( 'agents-sidebar', array(
                    'before' => '<div class="home-side widget-area">',
                    'after'  => '</div>',
                ) );
                ?>

                <div class="desktop-ads ads-side">
                    <?php the_field('_99co_ad_ros_sidebar_below_desktop', 'option'); ?>
                </div>

            </div>
        </div>

        <div class="tablet-ads ads-bottom">
            <?php the_field('_99co_ad_ros_bottom_tablet', 'option'); ?>
        </div>

        <div class="mobile-ads ads-bottom">
            <?php the_field('_99co_ad_ros_bottom_mobile', 'option'); ?>
        </div>

        <!--<div class="widget desktop-ads">
            <a href="https://go.99.co/WhatsAppSub"><img src="/singapore/insider/wp-content/uploads/2019/03/property_whatsapp_625x1250.jpg" /></a>
        </div>-->

    </div>

<?php }

/**
 * Add attributes for site-inner element, since we're removing 'content'.
 *
 * @param array $attributes existing attributes
 *
 * @return array amended attributes
 */
function cb_site_inner_attr( $attributes ) {

	// Add a class of 'full' for styling this .site-inner differently
	$attributes['class'] .= ' full';

	// Add the attributes from .entry, since this replaces the main entry
	$attributes = wp_parse_args( $attributes, genesis_attributes_entry( array() ) );

	return $attributes;
}
add_filter( 'genesis_attr_site-inner', 'cb_site_inner_attr' );

// Build the page
get_header();
do_action( 'cb_content_area' );
get_footer();