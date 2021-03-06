<?php
/**
 * Post date template part.
 *
 * @package AMP
 */

?>
<div class="amp-wp-meta amp-wp-posted-on">
	<time datetime="<?php echo esc_attr( date( 'c', $this->get( 'post_published_timestamp' ) ) ); ?>">
		<?php
		echo esc_html(
			//sprintf(
				/* translators: %s: the human-readable time difference. */
			//	__( '%s ago', 'amp' ),
			//	human_time_diff( $this->get( 'post_published_timestamp' ), current_time( 'timestamp' ) )
			//)

			get_the_date()	
		);
		?>
	</time>
</div>