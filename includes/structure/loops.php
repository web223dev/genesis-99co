<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
	add_action( 'genesis_before_loop', 'nnco_do_breadcrumbs' );
/*
 * Use WordPress SEO's breadcrumbs when available
 *
 * @since 2.3.11
 */
	function nnco_do_breadcrumbs () {

	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<p class="breadcrumbs">', '</p>' );
	} else {
		genesis_do_breadcrumbs();
	}

}

//* Add infinitescroll
add_action( 'wp_ajax_nopriv_infinitescroll_latest', 'infinitescroll_latest' );
add_action( 'wp_ajax_infinitescroll_latest', 'infinitescroll_latest' );
function infinitescroll_latest() {

	$type     = $_POST[ 'type' ];
	$offset   = $_POST[ 'offset' ];
	$category = $_POST[ 'category' ];
    $tag = $_POST[ 'tag' ];
    $author = $_POST[ 'author' ];
	if ($category) {
        $args     = array('post_type' => $type, 'cat' => $category, 'posts_per_page' => 5, 'offset' => $offset);
    } elseif ($author) {
        $args     = array('post_type' => $type, 'author' => $author, 'posts_per_page' => 5, 'offset' => $offset);
    } elseif ($tag) {
        $args     = array('post_type' => $type, 'tax_query' => array( array( 'taxonomy' => 'post_tag', 'field' => 'term_id', 'terms' => $tag) ), 'posts_per_page' => 5, 'offset' => $offset);
    } else {
        $args     = array('post_type' => $type, 'posts_per_page' => 5, 'offset' => $offset);
    }


	global $post;
	$skip          = 0;
	$i             = 0;
	$infinte_posts = get_posts( $args );

	foreach ( $infinte_posts as $post ) {
		setup_postdata( $post );

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
								<?php the_post_thumbnail( 'latest-size', array( 'class' => 'aligncenter' ) ); ?>
                            </a>
                        </div>
					<?php }
				}
				if ( $value === 'left-align' || $value === 'right-align' ) {
					if ( get_the_post_thumbnail( $post->ID, 'thumbnail-size' ) ) { ?>
                        <div class="<?php echo $class; ?> <?php echo $value; ?> desktop">
                            <a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'thumbnail-size', array( 'class' => 'aligncenter' ) ); ?>
                            </a>
                        </div>
                        <div class="<?php echo $class; ?> full-width mobile">
                            <a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'latest-size', array( 'class' => 'aligncenter' ) ); ?>
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
	<?php }
	exit;
}

//* Add infinitescroll
add_action( 'wp_ajax_nopriv_infinitescroll_search', 'infinitescroll_search' );
add_action( 'wp_ajax_infinitescroll_search', 'infinitescroll_search' );
function infinitescroll_search() {

    $type     = $_POST[ 'type' ];
    $offset   = $_POST[ 'offset' ];
    $search = $_POST[ 'search' ];

    $args     = array('post_type' => $type, 's' => $search, 'posts_per_page' => 5, 'offset' => $offset);

    global $post;
    $skip          = 0;
    $i             = 0;
    $infinte_posts = get_posts( $args );

    foreach ( $infinte_posts as $post ) {
        setup_postdata( $post );

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
    exit;
}
