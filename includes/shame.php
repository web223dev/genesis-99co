<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );
