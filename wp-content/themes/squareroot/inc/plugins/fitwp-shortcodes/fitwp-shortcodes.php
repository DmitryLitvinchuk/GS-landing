<?php
/**
 * Plugin Name: FitWP Shortcodes
 * Plugin URI: http://fitwp.com
 * Description: A collections of shortcodes to be used in your theme
 * Author: The FitWP Team
 * Author URI: http://fitwp.com
 * Version: 0.2
 */

define( 'FITSC_URL', get_template_directory_uri() . '/inc/plugins/fitwp-shortcodes/' );
define( 'FITSC_INC', get_template_directory() . '/inc/plugins/fitwp-shortcodes/inc/' );

if ( !is_admin() )
	require_once FITSC_INC . 'frontend.php';
elseif ( !defined( 'DOING_AJAX' ) )
	require_once FITSC_INC . 'admin.php';
else
	require_once FITSC_INC . 'ajax.php';