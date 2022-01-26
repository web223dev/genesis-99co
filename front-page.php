<?php
/**
 * 99.co Genesis Child.
 *
 * @since        1.0.0
 *
 * @copyright    Copyright (c) 2017, Contributors to 99.co Genesis Child project
 * @license      GPL-2.0+
 */

//* Add front-page body class
add_filter( 'body_class', 'cb_body_class' );
function cb_body_class( $classes ) {

	$takeover = get_field( '_99co_homepage_takeover' );
	if ( $takeover ) {
		$classes[] = 'wings';
	}

	return $classes;

}

add_action( 'genesis_after_header', 'cb_home_takeover' );
function cb_home_takeover () {
	$takeover = get_field( '_99co_homepage_takeover' );

	if ( $takeover ) { ?>
        <div class="home-takeover">
            <?php
            $image_t = get_field( '_99co_takeover_top' );
            $size_t  = 'full';
            if ( $image_t ) { ?>
                <div class="takeover-top">
                    <?php echo wp_get_attachment_image( $image_t, $size_t ); ?>
                </div>
            <?php } ?>
        </div>
	<?php }
}

add_action( 'cb_content_area', 'cb_home_top_leaderboard' );
function cb_home_top_leaderboard () {

	$takeover = get_field( '_99co_homepage_takeover' );
	if ( $takeover ) {
		$image_l = get_field( '_99co_takeover_left' );
		$size_l  = 'full';
		if ( $image_l ) { ?>
            <div class="takeover-left">
				<?php echo wp_get_attachment_image( $image_l, $size_l ); ?>
            </div>
		<?php }
		$image_r = get_field( '_99co_takeover_right' );
		$size_r  = 'full';
		if ( $image_r ) { ?>
            <div class="takeover-right">
				<?php echo wp_get_attachment_image( $image_r, $size_r ); ?>
            </div>
		<?php }
	}
	?>
    
    
	<?php
}

/*
 * Home Rotator.
 */
add_action( 'cb_content_area', 'cb_home_rotator' );
function cb_home_rotator() { ?>
    
    <div class="home-section slider">
        <div class="lists-wrapper">
			<?php
			$args  = array(
				'post_type'      => 'post',
				'posts_per_page' => '6',
				'post_status'    => 'publish',
                'category_name' => '99dotco-picks'
			);
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					global $post;

					// load all 'category' terms for the post
					$terms = get_the_terms( get_the_ID(), 'category' );
					// we will use the first term to load ACF data from
					if ( !empty( $terms ) ) {
						$term           = array_pop( $terms );
						$categorycolour = get_field( '_99co_category_colour', $term );
					}

					?>
                    <div class="inner">
						<?php if ( get_field( '_99co_featured_video' ) ) {
							$class = 'image overlay-video';
						} else {
							$class = 'image';
						} ?>
                        <div class="<?php echo $class; ?>">
                            <a href="<?php the_permalink(); echo '?utm_source=blog&utm_medium=spotlight_carousel' ?>">
								<?php the_post_thumbnail( 'slider-size' ); ?>
                            </a>
                        </div>
                        <div class="overlay">
                            <header class="entry-header">
                                <?php
                                $categories = get_the_category();
                                if ( !empty( $categories ) ) {
                                    foreach ($categories as $category) {
                                        if ($category->slug != 'featured-posts' && $category->slug != '99dotco-picks') {
                                            echo '<div class="entry-category" style="background-color:' . $categorycolour . '"><a href="' . esc_url(get_category_link($category->term_id)) . '" style="color: ' . $categorycolour . '">' . esc_html($category->name) . '</a> </div>';
                                        }
                                    }
                                }
                                ?>
                                <h3 class="entry-title" itemprop="name">
                                    <a href="<?php the_permalink(); echo '?utm_source=blog&utm_medium=spotlight_carousel' ?>"><?php the_title(); ?></a>
                                </h3>
                                <div class="more-link">
                                    <a href="<?php the_permalink(); echo '?utm_source=blog&utm_medium=spotlight_carousel' ?>">Read more</a>
                                </div>
                            </header>
                        </div>
                    </div>
				<?php }
			}
			wp_reset_postdata();
			?>
        </div>
    </div>

<?php }

add_action( 'cb_content_area', 'cb_home_after_leaderboard' );
function cb_home_after_leaderboard () {
	?>
    <div class="desktop-ads ads-top">
		<?php the_field('_99co_ad_top_desktop', 'option'); ?>
    </div>
    <div class="tablet-ads ads-top">
        <?php the_field('_99co_ad_top_tablet', 'option'); ?>
    </div>
    <div class="mobile-ads ads-top">
        <?php the_field('_99co_ad_top_mobile', 'option'); ?>
    </div>
	<?php
}

/*
 * Home Popular
 *
 */
add_action( 'cb_content_area', 'cb_home_popular' );
function cb_home_popular() {
	if ( get_field( '_99co_section_1_toggle' ) ) { ?>

        <div class="home-section popular">
            <div class="wrap">
                <h2><?php the_field( '_99co_section_1_title' ); ?></h2>
                <div class="lists-wrapper">
					<?php
					$args  = array(
						'post_type' => 'post', 'posts_per_page' => '5', 'post_status' => 'publish',
					);
					$query = new WP_Query( $args );
					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();
							global $post;

							// load all 'category' terms for the post
							$terms = get_the_terms( get_the_ID(), 'category' );
							// we will use the first term to load ACF data from
							if ( !empty( $terms ) ) {
								$term           = array_pop( $terms );
								$categorycolour = get_field( '_99co_category_colour', $term );
							}

							?>
                            <div class="inner">
								<?php if ( get_field( '_99co_featured_video' ) ) {
									$class = 'image overlay-video';
								}
								else {
									$class = 'image';
								} ?>
                                <div class="<?php echo $class; ?>">
                                    <a href="<?php the_permalink();?>">
										<?php the_post_thumbnail( 'popular-size' ); ?>
                                    </a>
                                </div>
                                <div class="overlay">
                                    <?php
                                    $categories = get_the_category();
                                    if ( !empty( $categories ) ) {
                                        foreach ($categories as $category) {
                                            echo '<div class="entry-category" style="background-color:'. $categorycolour .'"><a href="' . esc_url(get_category_link($category->term_id)) . '" style="color: ' . $categorycolour . '">' . esc_html($category->name) . '</a> </div>';
                                        }
                                    }
                                    ?>
                                </div>
                                <header class="entry-header">
                                    <p class="entry-meta" itemprop="name">
										<?php printf( _x( '%s ago', '%s = human-readable time difference', '99co' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
                                        &middot;
										<?php echo nnco_reading_time(); ?>
                                        &middot;
                                        by <?php the_author_posts_link(); ?>
                                    </p>
                                    <h4 class="entry-title" itemprop="name">
                                        <a href="<?php the_permalink(); ?>">
											<?php
											$title = get_the_title();
											echo mb_strimwidth( $title, 0, 60, '...' );
											?>
                                        </a>
                                    </h4>
                                    <div class="more-link">
                                        <a href="<?php the_permalink(); ?>">Read full story</a>
                                    </div>
                                </header>
                            </div>
						<?php }
					}
					wp_reset_postdata();
					?>
                </div>
            </div>
        </div>
	<?php }
}

/*
 * Home Latest
 *
 */
add_action( 'cb_content_area', 'cb_home_latest' );
function cb_home_latest() { ?>

    <div class="home-section latest">
        <div class="wrap">
            <div class="row gutter-40">
                <div class="col col-xs-12 col-lg-8 main">
                    <h2><?php the_field( '_99co_section_2_title' ); ?></h2>
                    <div class="lists-wrapper">
						<?php
						$i     = 0;
						$posts = get_option( 'posts_per_page' );
                        $excluded = array(23716);
						$args  = array(
							'post_type'      => 'post',
							'posts_per_page' => $posts,
							'post_status'    => 'publish',
                            'category__not_in'=> $excluded,
						);
						$query = new WP_Query( $args );
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								global $post;

								if ( $i === 2 ) {
									echo get_archive_banner();
								}

								// load all 'category' terms for the post
								$terms = get_the_terms( get_the_ID(), 'category' );
								// we will use the first term to load ACF data from
								if ( !empty( $terms ) ) {
									$term           = array_pop( $terms );
									$categorycolour = get_field( '_99co_category_colour', $term );
								}

								$imagealignment = get_field_object( '_99co_featured_image' );
								$value          = $imagealignment[ 'value' ];
								$label          = $imagealignment[ 'choices' ][ $value ];

								?>
                                <article class="entry entry-post" id="<?php echo $post->ID; ?>">
                                    <div class="inner">
                                        <?php
                                        if ( get_field( '_99co_featured_video' ) ) {
                                            $class = 'entry-image overlay-video';
                                        } else {
                                            $class = 'entry-image';
                                        }
                                        if ( $value === 'full-width' ) {
                                            if ( get_the_post_thumbnail( $post->ID, 'latest-size' ) ) { ?>
                                                <div class="<?php echo $class; ?> <?php echo $value; ?> desktop">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail( 'latest-size' ); ?>
                                                    </a>
                                                </div>
                                            <?php }
                                        }
                                        if ( $value === 'left-align' || $value === 'right-align' ) {
                                            if ( get_the_post_thumbnail( $post->ID, 'thumbnail-size' ) ) { ?>
                                                <div class="<?php echo $class; ?> <?php echo $value; ?> desktop">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail( 'thumbnail-size' ); ?>
                                                    </a>
                                                </div>
                                                <div class="<?php echo $class; ?> full-width mobile">
                                                    <a href="<?php the_permalink(); ?>">
			                                            <?php the_post_thumbnail( 'latest-size' ); ?>
                                                    </a>
                                                </div>
                                            <?php }
                                        }
                                        ?>
                                        <header class="entry-header <?php echo $value; ?>">
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
                                                <?php echo nnco_reading_time(); ?>
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
								<?php ++$i;
							}
						}
						wp_reset_postdata();
						?>

                        <div class="load-more">
                            <a href="#" class="btn" data-count="<?php echo $posts; ?>" data-cat="0" data-type="post" data-loading="0">Load more</a>
                        </div>

                    </div>
                </div>
                <div class="col col-xs-12 col-lg-4 side">
                    <div class="widget widget_editors-picks">
                        <h2><?php the_field( '_99co_section_3_title' ); ?></h2>
						<?php

						$posts = get_field( '_99co_picks', 'option' );

						if ( $posts ): ?>
                            <ol>
								<?php foreach ( $posts as $post ): ?>
									<?php setup_postdata( $post ); ?>
									<?php
									// load all 'category' terms for the post
									$terms = get_the_terms( get_the_ID(), 'category' );
									// we will use the first term to load ACF data from
									if ( !empty( $terms ) ) {
										$term           = array_pop( $terms );
										$categorycolour = get_field( '_99co_category_colour', $term );
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

                    $sidebar_sky = get_field('_99co_ad_sidebar_desktop_skyscraper', 'option');

                    if (!$sidebar_sky) {

	                    $background = get_field( '_99co_widget_background_colour', 'option' );
	                    $top        = get_field( '_99co_widget_top_content', 'option' );
	                    $bottom     = get_field( '_99co_widget_bottom_content', 'option' );
	                    $image      = get_field( '_99co_widget_image', 'option' );

	                    if ( !empty( $image ) ):

		                    // vars
		                    $title  = $image[ 'title' ];
		                    $alt    = $image[ 'alt' ];

		                    // thumbnail
		                    $size   = 'large';
		                    $thumb  = $image[ 'sizes' ][ $size ];
		                    $width  = $image[ 'sizes' ][ $size . '-width' ];
		                    $height = $image[ 'sizes' ][ $size . '-height' ];
		                    ?>
                            <div class="widget widget_promo" style="background-color: <?php echo $background; ?>">
			
			                    <?php echo $top; ?>

                                <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>"/>
			
			                    <?php echo $bottom; ?>

                                <a href="<?php the_field( '_99co_widget_button_url', 'option' ); ?>" class="btn"><?php the_field( '_99co_widget_button', 'option' ); ?></a>

                            </div>
	                    <?php endif;
                    } else { ?>
                        <div class="desktop-ads ads-side">
		                    <?php the_field('_99co_ad_sidebar_desktop_skyscraper', 'option'); ?>
                        </div>
                    <?php } ?>
                    
					<?php
                    genesis_widget_area( 'homepage-sidebar', array(
						'before' => '<div class="home-side widget-area">',
						'after'  => '</div>',
					) );
					?>

                    <div class="desktop-ads ads-side">
		                <?php the_field('_99co_ad_sidebar_desktop_mrec', 'option'); ?>
                    </div>
                    <div class="mobile-ads ads-side">
		                <?php the_field('_99co_ad_sidebar_mobile', 'option'); ?>
                    </div>

                    <!--<div class="widget desktop-ads">
                        <a href="https://go.99.co/WhatsAppSub"><img src="/singapore/insider/wp-content/uploads/2019/03/property_whatsapp_625x1250.jpg" /></a>
                    </div>-->

                </div>

                <div class="col col-xs-12 col-lg-0 ads">
                    <div class="tablet-ads ads-bottom">
			            <?php the_field('_99co_ad_bottom_tablet', 'option'); ?>
                    </div>
                    <div class="mobile-ads ads-bottom">
		                <?php the_field('_99co_ad_bottom_mobile', 'option'); ?>
                    </div>
                </div>
                
            </div>
        </div>
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
	$attributes[ 'class' ] .= ' full';

	// Add the attributes from .entry, since this replaces the main entry
	$attributes = wp_parse_args( $attributes, genesis_attributes_entry( array() ) );

	return $attributes;
}

add_filter( 'genesis_attr_site-inner', 'cb_site_inner_attr' );

// Build the page
get_header();
do_action( 'cb_content_area' );
get_footer();
