<?php
/**
 * 99.co Genesis Child.
 *
 * @since        1.0.0
 *
 * @copyright    Copyright (c) 2017, Contributors to 99.co Genesis Child project
 * @license      GPL-2.0+
 */

/*
 * Remove the primary and secondary menus
 *
 * @since 2.0.9
 */
remove_action( 'genesis_header', 'genesis_do_nav', 12 );
add_action( 'genesis_header', 'genesis_do_subnav', 12 );

/*
 * Agents Rotator
 *
 */
add_action( 'cb_content_area', 'cb_agents_hero' );
function cb_agents_hero() {
	$image = get_field( '_99co_agents_slider_background', 'option' );
	$size  = 'agent-banner-size';
	$thumb = $image[ 'sizes' ][ $size ];
	?>
    <div class="agents-section hero" style="background-image: url(<?php echo $thumb; ?>);">
        <div class="wrap">
            <div class="row middle-xs">
                <div class="col col-xs-12 col-lg-offset-1 col-lg-4 hero-welcome">
					<?php the_field( '_99co_agents_slider_content', 'option' ); ?>
                </div>
            </div>
        </div>
        <div class="overlay"></div>
    </div>
<?php }

/*
 * Home Popular
 *
 */
add_action( 'cb_content_area', 'cb_agents_popular' );
function cb_agents_popular() { ?>

    <div class="home-section popular">
        <div class="wrap">
            <h2><?php the_field( '_99co_section_1_title', 'option' ); ?></h2>
            <div class="lists-wrapper">
				<?php
				$args  = array(
					'post_type'      => 'agents',
					'posts_per_page' => '9',
					'post_status'    => 'publish',
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
                                <a href="<?php the_permalink(); ?>">
			                        <?php the_post_thumbnail( 'popular-size' ); ?>
                                </a>
                            </div>
                            <div class="overlay">
                                <div class="entry-category" style="background-color: <?php echo $categorycolour; ?>">
									<?php
									$categories = get_the_category();
									if ( !empty( $categories ) ) {
										echo '<a href="' . esc_url( get_category_link( $categories[ 0 ]->term_id ) ) . '">' . esc_html( $categories[ 0 ]->name ) . '</a>';
									}
									?>
                                </div>
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
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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

/*
 * Home Latest
 *
 */
add_action( 'cb_content_area', 'cb_agents_latest' );
function cb_agents_latest() { ?>

    <div class="home-section latest">
        <div class="wrap">
            <div class="row gutter-40">
                <div class="col col-xs-12 col-lg-8 main">
                    <h2><?php the_field( '_99co_section_2_title', 'option' ); ?></h2>
                    <div class="lists-wrapper">
						<?php
						$i     = 0;
						$args  = array(
							'post_type'      => 'agents',
							'posts_per_page' => '3',
							'post_status'    => 'publish',
						);
						$query = new WP_Query( $args );
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								global $post;

								if ( $i === 2 ) {
									echo get_agents_banner();
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
                                <div class="inner">
	                                <?php
	                                if ( get_field( '_99co_featured_video' ) ) {
		                                $class = 'image overlay-video';
	                                } else {
		                                $class = 'image';
	                                }
	                                if ( $value === 'full-width' ) {
		                                if ( get_the_post_thumbnail( $post->ID, 'latest-size' ) ) { ?>
                                            <div class="<?php echo $class; ?> <?php echo $value; ?>">
                                                <a href="<?php the_permalink(); ?>">
					                                <?php the_post_thumbnail( 'latest-size' ); ?>
                                                </a>
                                            </div>
		                                <?php }
	                                }
	                                if ( $value === 'left-align' || $value === 'right-align' ) {
		                                if ( get_the_post_thumbnail( $post->ID, 'thumbnail-size' ) ) { ?>
                                            <div class="<?php echo $class; ?> <?php echo $value; ?>">
                                                <a href="<?php the_permalink(); ?>">
					                                <?php the_post_thumbnail( 'thumbnail-size' ); ?>
                                                </a>
                                            </div>
		                                <?php }
	                                }
	                                ?>
                                    <header class="entry-header <?php echo $value; ?>">
                                        <div class="entry-category"
                                             style="background-color: <?php echo $categorycolour; ?>">
											<?php
											$categories = get_the_category();
											if ( !empty( $categories ) ) {
												echo '<a href="' . esc_url( get_category_link( $categories[ 0 ]->term_id ) ) . '">' . esc_html( $categories[ 0 ]->name ) . '</a>';
											}
											?>
                                        </div>
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
							<?php ++$i; }
						}
						wp_reset_postdata();
						?>

                        <div class="load-more">
                            <a href="#" class="btn" data-count="3" data-cat="0" data-type="agents" data-loading="0">Load
                                more</a>
                        </div>

                    </div>
                </div>
                <div class="col col-xs-12 col-lg-4 side">
                    <div class="widget widget_editors-picks">
                        <h2><?php the_field( '_99co_section_3_title', 'option' ); ?></h2>
						<?php

						$posts = get_field( '_99co_agents_editors_picks', 'option' );

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
					<?php $background = get_field( '_99co_agents_widget_background_colour', 'option' ); ?>
                    <div class="widget widget_promo" style="background-color: <?php echo $background; ?>">
						<?php
						$image   = get_field( '_99co_agents_widget_image', 'option' );

						if ( !empty( $image ) ):

							// vars
							$title = $image[ 'title' ];
							$alt   = $image[ 'alt' ];

							// thumbnail
							$size   = 'large';
							$thumb  = $image[ 'sizes' ][ $size ];
							$width  = $image[ 'sizes' ][ $size . '-width' ];
							$height = $image[ 'sizes' ][ $size . '-height' ];
							?>

                            <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>"
                                 height="<?php echo $height; ?>"/>

                            <a href="<?php the_field( '_99co_agents_widget_button_url', 'option' ); ?>"
                               class="btn"><?php the_field( '_99co_agents_widget_button', 'option' ); ?></a>
						
						<?php endif; ?>
                    </div>
					<?php
					genesis_widget_area( 'agents-sidebar', array(
						'before' => '<div class="home-side widget-area">',
						'after'  => '</div>',
					) );
					?>
                </div>
            </div>
        </div>
    </div>

<?php }

	remove_action( 'genesis_before_footer', 'nnco_do_cta', 8 );
	add_action( 'genesis_before_footer', 'nnco_do_agents_cta', 8 );

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
