<?php
/**
 * 99.co Genesis Child.
 *
 * @since        1.0.0
 *
 * @copyright    Copyright (c) 2017, Contributors to 99.co Genesis Child project
 * @license      GPL-2.0+
 */
	remove_action( 'genesis_before_footer', 'nnco_do_cta', 8 );
	add_action( 'genesis_before_footer', 'nnco_do_agents_cta', 8 );

genesis();
