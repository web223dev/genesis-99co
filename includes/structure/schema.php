<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	add_filter( 'genesis_attr_search-form', 'nnco_unset_role_attribute' );
	add_filter( 'genesis_attr_sidebar-primary', 'nnco_unset_role_attribute' );
	/**
	 * Remove unnecessary role attributes.
	 *
	 * @since 2.3.17
	 *
	 * See: https://validator.w3.org/
	 */
	function nnco_unset_role_attribute ( $attributes ) {

	if( isset($attributes['role']) )
		unset($attributes['role']);

	return $attributes;

}
