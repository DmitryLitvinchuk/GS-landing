<?php
/**
 * Plugin Name:       Rascals Themes - Spectra Plugin
 * Plugin URI:        http://rascals.eu
 * Description:       This is a complimentary plugin for the "Spectra" WordPress theme. You can use it to create, manage and update Custom Posts Types. It also has some useful shortcodes available to use.
 * Version:           1.2.1
 * Author:            Mariusz Rek - Rascals Themes
 * Author URI:        http://rascals.eu
 * Text Domain:       spectra_plugin
 * License:           See "Licensing" Folder
 * License URI:       See "Licensing" Folder
 * Domain Path:       /languages
 */

// don't load directly
if ( ! defined( 'ABSPATH' ) ) die( '-1' );

/* ----------------------------------------------------------------------
	CONSTANTS
/* ---------------------------------------------------------------------- */

define( 'SPECTRA_PLUGIN', 'spectra_plugin' );


/* ----------------------------------------------------------------------
	MAKE THE PLUGIN AVAILABLE FOR TRANSLATION
/* ---------------------------------------------------------------------- */
load_plugin_textdomain( SPECTRA_PLUGIN, false, 'rascals_spectra_plugin/languages' );


/* ----------------------------------------------------------------------
	INCLUDE ALL THE FILES NEEDED
/* ---------------------------------------------------------------------- */

// Get panel options
$panel_options = get_option( 'spectra_panel_opts' );

// Post Types
require_once( plugin_dir_path( __FILE__ ) . 'includes/post-types/post-types.php' );

// Scamp Player
if ( $panel_options && isset( $panel_options['scamp_player'] ) && $panel_options['scamp_player'] === 'on' ) {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/post-types/scamp-player.php' );
}

// Metaboxes
require_once( plugin_dir_path( __FILE__ ) . 'includes/metaboxes/metaboxes.php' );

// Shortcodes
require_once( plugin_dir_path( __FILE__ ) . 'includes/shortcodes/shortcodes-helpers.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/shortcodes/shortcodes.php' );
if ( function_exists('vc_remove_element') ) {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/shortcodes/vc-extend.php' );
}

// Widgets
require_once( plugin_dir_path( __FILE__ ) . 'includes/widgets/widget-events.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/widgets/widget-tracks.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/widgets/widget-twitter.php' );