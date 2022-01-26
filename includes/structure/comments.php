<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Remove comments frontend. Useful if replacing WP commenting with Disqus.
 *
 * @since 2.0.10
 */
// remove_action( 'genesis_comments', 'genesis_do_comments' );
// remove_action( 'genesis_comment_form', 'genesis_do_comment_form' );

/*
 * Remove pings frontend.
 *
 * @since 2.0.16
 */
// remove_action( 'genesis_pings', 'genesis_do_pings' );

/*
 * Remove the entire comments area frontend, including comments, reply form, and pings.
 *
 * @since 2.0.16
 */
// remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );

add_filter( 'comment_form_defaults', 'sp_comment_form_defaults' );
function sp_comment_form_defaults( $defaults ) {
	$defaults['title_reply'] = __( 'Leave a comment' );

	return $defaults;
}

//* Modify comments title text in comments
add_filter( 'genesis_title_comments', 'sp_genesis_title_comments' );
function sp_genesis_title_comments() {
	global $post;
	$title = '<h3>Comments (' . get_comments_number( $post->ID ) . ')</h3>';

	return $title;
}

add_filter( 'genesis_show_comment_date', 'jmw_show_comment_date_only' );
/**
 * Show date on comments without time or link.
 *
 * Stop the output of the Genesis core comment dates and outputs comments with date only
 * The genesis_show_comment_date filter was introduced in Genesis 2.2 (will not work with older versions)
 *
 * @author Jo Waltham
 *
 * @see http://www.jowaltham.com/customising-comment-date-genesis/
 *
 * @param bool $comment_date Whether to print the comment date or not
 *
 * @return bool Whether to print the comment date or not
 */
function jmw_show_comment_date_only( $comment_date ) {
	printf('<p %s><time %s>%s</time></p>',
		genesis_attr( 'comment-meta' ),
		genesis_attr( 'comment-time' ),
		esc_html( get_comment_date() )
	);
	// Return false so that the parent function doesn't output the comment date, time and link
	return false;
}

// First remove the genesis_default_list_comments function
remove_action( 'genesis_list_comments', 'genesis_default_list_comments' );

// Now add our own and specify our custom callback
	add_action( 'genesis_list_comments', 'nnco_default_list_comments' );
	function nnco_default_list_comments () {

	$args = array(
		'type'        => 'comment',
		'avatar_size' => 54, 'callback' => 'nnco_comment_callback',
	);

	$args = apply_filters( 'genesis_comment_list_args', $args );

	wp_list_comments( $args );

}

	/**
	 * Comment callback for {@link genesis_default_list_comments()} if HTML5 is not active.
	 *
	 * Does `genesis_before_comment` and `genesis_after_comment` actions.
	 *
	 * Applies `comment_author_says_text` and `genesis_comment_awaiting_moderation` filters.
	 *
	 * @since 1.0.0
	 *
	 * @param stdClass $comment comment object
	 * @param array    $args    comment args
	 * @param int      $depth   depth of current comment
	 */
	function nnco_comment_callback ( $comment, array $args, $depth ) {

	$GLOBALS['comment'] = $comment; ?>

<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	
	<?php do_action( 'genesis_before_comment' ); ?>
	
	<div class="comment-header">
		
		<div class="comment-meta commentmetadata">
			<?php printf( __( '%1$s at %2$s', 'genesis' ), get_comment_date(), get_comment_time() ); ?>
			<?php edit_comment_link( __( '(Edit)', 'genesis' ), '' ); ?>
		</div>
		
		<div class="comment-author vcard">
			<?php printf( __( '<cite class="fn">%s</cite>', 'genesis' ), get_comment_author_link() ); ?>
		</div>
	</div>
	
	<div class="comment-content">
		<?php if ( !$comment->comment_approved ) : ?>
			<p class="alert"><?php echo apply_filters( 'genesis_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'genesis' ) ); ?></p>
		<?php endif; ?>
		
		<?php comment_text(); ?>
	</div>
	
	<div class="reply">
		<?php comment_reply_link( array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']) ) ); ?>
	</div>
	
	<?php do_action( 'genesis_after_comment' );

	// No ending </li> tag because of comment threading.
}

/**
 * Change comment form textarea to use placeholder.
 *
 * @since  1.0.0
 *
 * @param array $args
 *
 * @return array
 */
function ea_comment_textarea_placeholder( $args ) {
	$args['comment_field']        = str_replace( 'textarea', 'textarea placeholder="Leave a comment..."', $args['comment_field'] );

	return $args;
}
add_filter( 'comment_form_defaults', 'ea_comment_textarea_placeholder' );
/**
 * Comment Form Fields Placeholder.
 */
function be_comment_form_fields( $fields ) {
	foreach( $fields as &$field ) {
		$field = str_replace( 'id="author"', 'id="author" placeholder="Name *"', $field );
		$field = str_replace( 'id="email"', 'id="email" placeholder="E-mail address *"', $field );
		$field = str_replace( 'id="url"', 'id="url" placeholder="Website"', $field );
	}

	return $fields;
}
add_filter( 'comment_form_default_fields', 'be_comment_form_fields' );
