<?php
/**
 * Plugin Name: 	Spectra
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/spectra
 * Author URI: 		http://rascals.eu
 * File:			metaboxes.php
 * =========================================================================================================================================
 *
 * @package spectra-plugin
 * @since 1.0.0
 */

/* ----------------------------------------------------------------------
	INIT CLASS
/* ---------------------------------------------------------------------- */
$panel_options = get_option( 'spectra_panel_opts' );

if ( ! class_exists( 'MuttleyBox' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'classes/MuttleyBox.php' );
}

global $wpdb;


/* ----------------------------------------------------------------------
	HELPERS
/* ---------------------------------------------------------------------- */

/* Get post/page data */
if ( isset( $_GET['post'] ) ) { 
	$template_name = get_post_meta( $_GET['post'], '_wp_page_template', true );
	$post_type = get_post_type( $_GET['post'] );
} else { 
	$template_name = '';
	$post_type = '';
}

/* Post per page */
$pp = get_option( 'posts_per_page' );

/* Get Audio Tracks  */
$tracks = array();
$tracks_post_type = 'spectra_tracks';
$tracks_query = $wpdb->prepare(
	"
    SELECT
		{$wpdb->posts}.id,
		{$wpdb->posts}.post_title
  	FROM 
		{$wpdb->posts}
  	WHERE
		{$wpdb->posts}.post_type = %s
	AND 
		{$wpdb->posts}.post_status = 'publish'
	",
	$tracks_post_type
);

$sql_tracks = $wpdb->get_results( $tracks_query );
  
if ( $sql_tracks ) {
	$count = 0;
	foreach( $sql_tracks as $track_post ) {
		$tracks[$count]['name'] = $track_post->post_title;
		$tracks[$count]['value'] = $track_post->id;
		$count++;
	}
}

// Intro Slider
$intro_slider = array( array( 'name' => '', 'value' => 'none' ) );
$slider_post_type = 'spectra_slider';
$slider_query = $wpdb->prepare(
	"
    SELECT
		{$wpdb->posts}.id,
		{$wpdb->posts}.post_title
  	FROM 
		{$wpdb->posts}
  	WHERE
		{$wpdb->posts}.post_type = %s
	AND 
		{$wpdb->posts}.post_status = 'publish'
	",
	$slider_post_type
);

$sql_slider = $wpdb->get_results( $slider_query );
  
if ( $sql_slider ) {
	$count = 1;
	foreach( $sql_slider as $slider_post ) {
		$intro_slider[$count]['name'] = $slider_post->post_title;
		$intro_slider[$count]['value'] = $slider_post->id;
		$count++;
	}
}


/* ----------------------------------------------------------------------
	INTRO
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Intro Options', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_intro_options', 
	'page' => array(
		'post', 
		'page',
		'spectra_portfolio',
		'spectra_events',
		'spectra_gallery'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post', 
		'default',
		'page-templates/portfolio.php',
		'page-templates/events.php',
		'page-templates/events-all.php',
		'page-templates/blog.php',
		'page-templates/blog-grid.php',
		'page-templates/modular.php',
		'page-templates/fullscreen.php',
		'page-templates/gallery.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);	

// Intro type
$intro_type = array(
	array( 'name' => _x( 'None', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'intro_none' ),
	array( 'name' => _x( 'Page Title', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'intro_page_title' ),
	array( 'name' => _x( 'Content', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'intro_content' ),
	array( 'name' => _x( 'Full Screen Image', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'intro_full_image' ),
	array( 'name' => _x( 'Full Screen Image with Content', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'intro_full_image_content' ),
	array( 'name' => _x( 'Image', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'intro_image' ),
	array( 'name' => _x( 'Full Screen Slider', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'intro_full_slider' ),
	array( 'name' => _x( 'Slider', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'intro_slider' ),
	array( 'name' => _x( 'YouTube Background', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'intro_youtube' ),
	array( 'name' => _x( 'Google Map', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'gmap' )
);
/* Special options only for Fullscreen template */
if ( $template_name == 'page-templates/fullscreen.php' ) {
	$intro_type = array(
		array( 'name' => _x( 'Full Screen Image', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'intro_full_image' ),
		array( 'name' => _x( 'Full Screen Image with Content', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'intro_full_image_content' ),
		array( 'name' => _x( 'Full Screen Slider', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'intro_full_slider' )
	);
}

/* Meta options */
$meta_options = array(
	array(
		'name' => _x( 'Intro Type', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_intro_type',
		'type' => 'select',
		'std' => 'intro_none',
	  	'options' => $intro_type,
		'group' => 'intro_type',
		'desc' => _x( 'Select intro.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Image', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => array(
			array( 'id' => '_intro_image', 'std' => '')
		),
		'type' => 'add_image',
		'button_title' => _x( 'Add Image', 'Metaboxes', SPECTRA_PLUGIN ),
		'desc' => _x( 'Intro image.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_full_image', 'intro_image', 'intro_full_image_content', 'intro_youtube' )
	),
	array(
		'name' => _x( 'Height', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_min_height',
		'type' => 'range',
		'min' => 100,
		'max' => 1200,
		'unit' => _x( 'px', 'Metaboxes', SPECTRA_PLUGIN ),
		'std' => '500',
		'desc' => _x( 'Intro section min. height.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_slider', 'intro_image', 'intro_slider', 'intro_youtube' )
	),
	array(
		'name' => _x( 'Overlay', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_overlay',
		'type' => 'select',
		'std' => 'disabled',
		'options' => array(
			array( 'name' => _x( 'Disabled', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'disabled' ),
			array( 'name' => _x( 'Opacity Black', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'black' ),
			array( 'name' => _x( 'Animated Noise', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'noise' ),
			array( 'name' => _x( 'Dots', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'dots' )
		),
		'desc' => _x( 'Select overlay type.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_slider', 'intro_image', 'intro_full_image', 'intro_full_slider', 'intro_full_image_content', 'intro_youtube' )
	),
	array(
		'name' => _x( 'Image Effect', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_image_effect',
		'type' => 'select',
		'std' => 'disabled',
		'options' => array(
			array( 'name' => _x( 'Disabled', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'disabled' ),
			array( 'name' => _x( 'Zoom', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'zoom' ),
			array( 'name' => _x( 'Parallax', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'parallax' )
		),
		'desc' => _x( 'Select Image effect.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_image', 'intro_full_image', 'intro_full_image_content' )
	),
	array(
		'name' => _x( 'Animated', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_animated',
		'type' => 'switch_button',
		'std' => 'off',
		'desc' => _x( 'Enable animated effects.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_slider', 'intro_full_slider', 'intro_image', 'intro_full_image', 'intro_full_image_content', 'intro_youtube' )
	),
	array(
		'name' => _x( 'Zoom Effect', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_zoom_effect',
		'type' => 'switch_button',
		'std' => 'off',
		'desc' => _x( 'If this opion is on, you should see zoom effect on intro section.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_slider', 'intro_full_slider' )
	),
	array(
		'name' => _x( 'Scroll Button', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_scroll_button',
		'type' => 'switch_button',
		'std' => 'off',
		'desc' => _x( 'If this opion is on, you should see scroll_button on intro section.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_image', 'intro_full_image', 'intro_full_image_content', 'intro_youtube' )
	),
	array(
		'name' => _x( 'Intro Title', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_intro_title',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '40',
		'desc' => _x( 'Add intro title.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_image', 'intro_full_image', 'intro_youtube' )
	),
	array(
		'name' => _x( 'Intro Subtitle', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_intro_subtitle',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '40',
		'desc' => _x( 'Add intro subtitle.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_image', 'intro_full_image', 'intro_youtube' )
	),

	// Slider
	array(
		'name' => _x( 'Slider', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_slider_id',
		'type' => 'select_array',
		'options' => $intro_slider,
		'std' => '',
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_full_slider', 'intro_slider' ),
		'desc' => _x( 'Select your slider; images min width must be 1920. If there are no sliders available, then you can add a slider and images using Slider custom posts menu on the left.', 'Metaboxes', SPECTRA_PLUGIN )
	),

	// Background
	array(
		'name' => _x( 'Background', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_intro_bg',
		'type' => 'bg_generator',
		'std' => '',
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_content' ),
		'desc' => _x( 'Generate intro background.', 'Metaboxes', SPECTRA_PLUGIN )
	),

	// Content
	array(
		'name' => _x( 'Intro Content', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_intro_content',
		'type' => 'textarea',
		'tinymce' => 'true',
		'height' => '200',
		'std' => '',
		'height' => '100',
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_content', 'intro_full_image_content' ),
		'desc' => _x( 'Add text to the intro section below the title.', 'Metaboxes', SPECTRA_PLUGIN )
	),

	// Map
	array(
		'name' => _x( 'Address', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_map_address',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => 'Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia',
		'height' => '40',
		'desc' => _x( 'Add address to Google Map.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'intro_type',
		'group_name' => array( 'gmap' )
	),

	// YouTube
	array(
		'name' => _x( 'YouTube ID', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_yt_id',
		'type' => 'video',
		'video_type' => 'youtube',
  		'video_width' => '288',
  		'video_height' => '180',
  		'params' => '',
		'std' => 'BsekcY04xvQ',
		'desc' => _x( 'Add YouTube movie ID.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'intro_type',
		'group_name' => array( 'intro_youtube' )
	)


);

/* Add class instance */
$intro_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	LAYOUT
/* ---------------------------------------------------------------------- */

/* Sidebars Array */
if ( isset( $panel_options[ 'custom_sidebars' ] ) ) {
	$s_list = $panel_options[ 'custom_sidebars' ];
} else {
	$s_list = null;
}
if ( isset( $panel_options[ 'default_layout' ] ) ) {
	$default_layout = $panel_options[ 'default_layout' ];
} else {
	$default_layout = 'wide';
}


/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Layout Options', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_layout_options', 
	'page' => array(
		'post',
		'page',
		'spectra_portfolio',
		'spectra_events'
	), 
	'context' => 'side', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'default',
		'page-templates/blog.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
	array(
		'name' => _x( 'Layout', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_layout',
		'type' => 'select_image',
		'std' => $default_layout,
		'images' => array(
			array( 'id' => 'main-right', 'image' => plugin_dir_url( __FILE__ ) .  'assets/images/icons/sidebar_left.png'),
			array( 'id' => 'main-left', 'image' => plugin_dir_url( __FILE__ ) .  'assets/images/icons/sidebar_right.png'),
			array( 'id' => 'wide', 'image' => plugin_dir_url( __FILE__ ) .  'assets/images/icons/wide.png')
		),
		'group' => 'layout',
		'desc' => _x( 'Choose the page layout.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Custom Sidebar', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_custom_sidebar',
		'type' => 'select_array',
		'array' => $s_list,
		'key' => 'name',
		'options' => array(
			array( 'value' => '_default', 'name' => _x( 'Primary Sidebar', 'Metaboxes', SPECTRA_PLUGIN ) )
		),
		'desc' => _x( 'Select custom or primary sidebar.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'layout',
		'group_name' => array( 'main-left', 'main-right' ),
	)
);

/* Add class instance */
$page_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	PAGE
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Page Options', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_page_options', 
	'page' => array(
		'page'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'default'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
	array(
		'name' => _x( 'Page Subtitle', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_page_subtitle',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '40',
		'desc' => _x( 'Add subtitle below the main page heading.', 'Metaboxes', SPECTRA_PLUGIN )
	),
);

/* Add class instance */
$page_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );



/* ----------------------------------------------------------------------
	BLOG - POST FORMATS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Post Format Options', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_post_format_options', 
	'page' => array(
		'post'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'default'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
	array(
		'name' => _x( 'Post Format', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_post_format',
		'std' => 'content',
		'type' => 'select',
		'options' => array(
			array( 'name' => _x( 'Standard', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'pf_standard' ),
			array( 'name' => _x( 'Image', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'pf_image' ),
			array( 'name' => _x( 'Gallery', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'pf_gallery' ),
			array( 'name' => _x( 'Video', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'pf_video' ),
			array( 'name' => _x( 'Quote', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'pf_quote' ),
			array( 'name' => _x( 'Link', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'pf_link' ),
			array( 'name' => _x( 'Audio', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'pf_audio' ),
			array( 'name' => _x( 'Audio - Single Track', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'pf_audio_single' ),
			array( 'name' => _x( 'Audio - Soundcloud', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'pf_audio_sc' )
		),
		'group' => 'post_format',
		'desc' => _x( 'Select post format type.', 'Metaboxes', SPECTRA_PLUGIN )
	),

	// Gallery 
	array(
		'name' => _x( 'Gallery Slider', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_gallery_slider_id',
		'type' => 'select_array',
		'options' => $intro_slider,
		'std' => '',
		'desc' => _x( 'Select slider; If there are no sliders available, then you can add a slider and images using Slider custom posts menu on the left. Select your slider. If there are no sliders available, then you can add a slider and images using Slider custom posts menu on the left. NOTE: Only working with GALLERY post format.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_gallery' )
	),

	// YouTube
	array(
		'name' => _x( 'Video YouTube', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_video_yt_id',
		'type' => 'video',
		'video_type' => 'youtube',
  		'video_width' => '288',
  		'video_height' => '180',
  		'params' => '',
		'std' => '',
		'desc' => _x( 'Add YouTube movie ID. NOTE: Only working with VIDEO post format.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_video' )
	),

	// Vimeo
	array(
		'name' => _x( 'Video Vimeo', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_video_vimeo_id',
		'type' => 'video',
		'video_type' => 'vimeo',
  		'video_width' => '288',
  		'video_height' => '180',
  		'params' => '',
		'std' => '',
		'desc' => _x( 'Add Vimeo movie ID. NOTE: Only working with VIDEO post format.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_video' )
		
	),

	// Audio Soundcloud
	array(
		'name' => _x( 'Soundcloud Audio', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_sc_iframe',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '100',
		'desc' => _x( 'Paste iframe code from soundcloud track. NOTE: Only working with AUDIO post format.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_audio_sc' )
	),

	//  Audio Tracks
	array(
		'name' => _x( 'Audio Tracks', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_pf_tracks_id',
		'type' => 'select_array',
		'options' => $tracks,
		'std' => '',
		'desc' => _x( 'Select your tracks; If there are no tracks available, then you can add a audio tracks using TRACKS custom posts menu on the left.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'post_format',
		'group_name' => array( 'pf_audio', 'pf_audio_single' )
	),
);

/* Add class instance */
$page_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	SLIDER
/* ---------------------------------------------------------------------- */

/* Slider Images */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Slider Images', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_slider_images', 
	'page' => array(
		'spectra_slider'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
	array( 
		// 'name' => _x( 'Images', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_custom_slider',
		'type' => 'media_manager',
		'media_type' => 'slider', // images / audio / slider
		'msg_text' => _x( 'Currently you don\'t have any images, you can add them by clicking on the button below.', 'Metaboxes', SPECTRA_PLUGIN ),
		'btn_text' => _x( 'Add Images', 'Metaboxes', SPECTRA_PLUGIN ),
		'desc' => _x( 'Add images to slider.', 'Metaboxes', SPECTRA_PLUGIN )
	)
);

/* Add class instance */
$page_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* Slider Options */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Slider Options', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_slider_options', 
	'page' => array(
		'spectra_slider'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
	array(
		'name' => _x( 'Navigation', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_slider_nav',
		'type' => 'switch_button',
		'std' => 'on',
		'desc' => _x( 'If this opion is on, then you should see the slider navigation.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Pagination', 'Metaboxes', SPECTRA_PLUGIN ),
		'std' => 'on',
		'type' => 'switch_button',
		'id' => '_slider_pagination',
		'desc' => _x( 'If this opion is on, then you should see the slider pagination.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Animation Speed', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_slider_speed',
		'type' => 'range',
		'min' => 200,
		'max' => 2000,
		'unit' => 'ms',
		'std' => '500',
		'desc' => _x( 'Slider animation speed.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Pause Time', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_slider_pause_time',
		'type' => 'range',
		'min' => 0,
		'max' => 20000,
		'unit' => 'ms',
		'std' => '3000',
		'desc' => _x( 'Determines how long each slide will be shown.  NOTE: Value "0" disable slider timer.', 'Metaboxes', SPECTRA_PLUGIN )
	),
);

/* Add class instance */
$page_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	PORTFOLIO - TEMPLATE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Portfolio Options', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_portfolio_options', 
	'page' => array(
		'page'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'page-templates/portfolio.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
	array(
		'name' => _x( 'Portfolio Limit', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_limit',
		'type' => 'range',
		'min' => $pp,
		'max' => 100,
		'unit' => _x( 'items', 'Metaboxes', SPECTRA_PLUGIN ),
		'std' => '40',
		'desc' => _x( 'Number of portfolio items limit.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Show Categories Filter', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_portfolio_filter',
		'type' => 'switch_button',
		'std' => 'on',
		'desc' => _x( 'If this option is disabled, then categories filter navigation disappears.', 'Metaboxes', SPECTRA_PLUGIN )
	)
);

/* Add class instance */
$portfolio_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	PORTFOLIO - POST TYPE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Thumbnails Options', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_thumbnails_options', 
	'page' => array(
		'spectra_portfolio'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
	array(
		'name' => _x( 'Thumbnails Type', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_thumb_type',
		'std' => 'project_link',
		'type' => 'select',
		'options' => array(
			array( 'name' => _x( 'Image', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'image' ),
			array( 'name' => _x( 'Project link', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'project_link' ),
			array( 'name' => _x( 'Audio', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'audio' ),
			array( 'name' => _x( 'Image lightbox', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'lightbox_image' ),
			array( 'name' => _x( 'Video lightbox', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'lightbox_video' ),
			array( 'name' => _x( 'Soundcloud lightbox', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'lightbox_soundcloud' ),
			array( 'name' => _x( 'Custom link', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'custom_link' )
		),
		'group' => 'thumb_type',
		'desc' => _x( 'Select thumbnail type.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Video Link', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_video_link',
		'type' => 'text',
		'main_group' => 'thumb_type',
		'group_name' => array( 'lightbox_video' ),
		'desc' => _x( 'Eneter video link e.g: https://www.youtube.com/watch?v=BsekcY04xvQ', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Iframe Code', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_thumb_iframe',
		'type' => 'iframe_generator',
		'std' => '',
		'main_group' => 'thumb_type',
		'group_name' => array( 'lightbox_soundcloud' ),
		'desc' => _x( 'Generate iframe code.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Lightbox Image', 'Metaboxes', SPECTRA_PLUGIN ),
		'type' => 'text',
		'id' => '_lightbox_image',
		'main_group' => 'thumb_type',
		'group_name' => array( 'lightbox_image' ),
		'desc' => _x( 'Paste the full URL (include http://) of your image. If this box is empty, then original image will be displayed in lightbox window.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Custom Link URL', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_link_url',
		'type' => 'easy_link',
		'main_group' => 'thumb_type',
		'group_name' => array( 'custom_link' ),
		'desc' => _x( 'Paste the full URL (include http://) of your link or click and select it from your site.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array( 
		'name' => _x( 'Link Target', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_target',
		'type' => 'switch_button',
		'std' => 'off',
		'main_group' => 'thumb_type',
		'group_name' => array( 'custom_link' ),
		'desc' => _x( 'Open link in new window.', 'Metaboxes', SPECTRA_PLUGIN ),
	),
	array(
		'name' => _x( 'Lightbox Group', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_lightbox_group',
		'type' => 'text',
		'main_group' => 'thumb_type',
		'group_name' => array( 'lightbox_image','lightbox_video','lightbox_soundcloud' ),
		'desc' => _x( 'Enter the group name if you want to change the lightbox window images. Navigation arrows will be shown in a group of portfolios.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	

	// Slider
	array(
		'name' => _x( 'Audio Tracks', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_tracks_id',
		'type' => 'select_array',
		'options' => $tracks,
		'std' => '',
		'main_group' => 'thumb_type',
		'group_name' => array( 'audio' ),
		'desc' => _x( 'Select your tracks; If there are no tracks available, then you can add a audio tracks using TRACKS custom posts menu on the left.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Thumbnail Subtitle', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_thumb_subtitle',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '40',
		'desc' => _x( 'Add thumbnail subtitle.', 'Metaboxes', SPECTRA_PLUGIN ),
	),
	array(
		'name' => _x( 'Badge', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_badge',
		'type' => 'select',
		'options' => array(
			array( 'name' => '', 'value' => 'none' ),
			array( 'name' => _x( 'New', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'new' ),
			array( 'name' => _x( 'Free', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'free' ),
			array( 'name' => _x( 'Custom', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'custom' )
		),
		'group' => 'thumb_badge',
		'desc' => _x( 'Add a badge to your portfolio item.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Badge Text', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_badge_text',
		'type' => 'text',
		'std' => 'BEST!',
		'desc' => _x( 'Add badge text.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'thumb_badge',
		'group_name' => array( 'custom' )
	),
	array( 
		'name' => _x( 'Color', 'Admin Panel' ),
		'id' => '_badge_color',
		'type' => 'color',
		'std' => '#eeeeee',
		'desc' => _x( 'Select badge color.', SPECTRA_PLUGIN ),
		'main_group' => 'thumb_badge',
		'group_name' => array( 'custom' )
	)

);

/* Add class instance */
$portfolio_thumbnails_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	AUDIO - POST TYPE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Audio Tracks', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_audio_options', 
	'page' => array(
		'spectra_tracks'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
	array( 
		// 'name' => _x( 'Images', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_audio_tracks',
		'type' => 'media_manager',
		'media_type' => 'audio', // images / audio / slider
		'msg_text' => _x( 'Currently you don\'t have any audio tracks, you can add them by clicking on the button below.', 'Metaboxes', SPECTRA_PLUGIN ),
		'btn_text' => _x( 'Add Tracks', 'Metaboxes', SPECTRA_PLUGIN ),
		'desc' => __( 'Add audio tracks.', SPECTRA_PLUGIN  ) . '<br>' . __( 'NOTE: Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple items.', SPECTRA_PLUGIN )
	)
);

/* Add class instance */
$tracks_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
/* Gallery Album Template
------------------------------------------------------------------------*/

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Albums Options', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_albums_options', 
	'page' => array(
		'page'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'page-templates/gallery.php',
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);


/* Meta options */
$meta_options = array(

	array(
		'name' => _x( 'Albums Layout', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_gallery_layout',
		'type' => 'select_image',
		'std' => '3',
		'images' => array(
			array('id' => '2', 'image' => plugin_dir_url( __FILE__ ) .  'assets/images/icons/2_col.png'),
			array('id' => '3', 'image' => plugin_dir_url( __FILE__ ) .  'assets/images/icons/3_col.png'),
			array('id' => '4', 'image' => plugin_dir_url( __FILE__ ) .  'assets/images/icons/4_col.png')
		),
		'desc' => _x( 'Choose the releases layout.', 'Metaboxes', SPECTRA_PLUGIN )
	),  
	array(
		'name' => _x( 'Albums Per Page', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_limit',
		'type' => 'range',
		'min' => $pp,
		'max' => 100,
		'unit' => _x( 'albums', 'Metaboxes', SPECTRA_PLUGIN ),
		'std' => '8',
		'desc' => _x( 'Number of albums to be displayed per page.', 'Metaboxes', SPECTRA_PLUGIN )
	)
);

/* Add class instance */
$album_template_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	GALLERY - POST TYPE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Album Images', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_gallery_options', 
	'page' => array(
		'spectra_gallery'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
	array( 
		// 'name' => _x( 'Images', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_gallery_ids',
		'type' => 'media_manager',
		'media_type' => 'images', // images / audio / slider
		'msg_text' => _x( 'Currently you don\'t have any photos, you can add them by clicking on the button below.', 'Metaboxes', SPECTRA_PLUGIN ),
		'btn_text' => _x( 'Add Photos', 'Metaboxes', SPECTRA_PLUGIN ),
		'desc' => __( 'Add audio tracks.', SPECTRA_PLUGIN  ) . '<br>' . __( 'NOTE: Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple items.', SPECTRA_PLUGIN )
	)
);

/* Add class instance */
$gallery_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );

/* ALBUM OPTIONS */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Album Options', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_album_options', 
	'page' => array(
		'spectra_gallery'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
	array(
		'name' => _x( 'Images Limit', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_limit',
		'type' => 'range',
		'min' => $pp,
		'max' => 200,
		'unit' => '',//_x( 'events', 'Metaboxes', SPECTRA_PLUGIN ),
		'std' => '20',
		'desc' => _x( 'Number of images limit on page.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Images per Row', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_images_per_row',
		'type' => 'range',
		'min' => 2,
		'max' => 5,
		'unit' => '',//_x( 'events', 'Metaboxes', SPECTRA_PLUGIN ),
		'std' => '4',
		'desc' => _x( 'Number of images per row.', 'Metaboxes', SPECTRA_PLUGIN )
	),	
);

/* Add class instance */
$gallery_album_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );




/* ----------------------------------------------------------------------
	EVENTS - TEMPLATE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Events Options', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_evens_options', 
	'page' => array(
		'page'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'page-templates/events.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
					  
	array(
		'name' => _x( 'Events Type', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_event_type',
		'type' => 'select',
		'std' => 'future-events',
		'options' => array(
			array('name' => _x( 'Future events', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'future-events'),
			array('name' => _x( 'Events archive', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'past-events')
		),
		'group' => 'events_type',
		'desc' => _x( 'Choose the events type.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Events Limit', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_limit',
		'type' => 'range',
		'min' => $pp,
		'max' => 200,
		'unit' => '',//_x( 'events', 'Metaboxes', SPECTRA_PLUGIN ),
		'std' => '10',
		'desc' => _x( 'Number of events limit.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Events Layout', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_events_layout',
		'type' => 'select',
		'std' => 'list',
		'options' => array(
			array('name' => _x( 'List', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'list'),
			array('name' => _x( 'Bricks', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'bricks'),
			array('name' => _x( 'Mixed (List+Bricks)', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'mixed'),
		),
		'group' => 'events_layout',
		'desc' => _x( 'Select Events Layout.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array( 
		'name' => _x( 'Show Heading', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_events_heading',
		'type' => 'switch_button',
		'std' => 'off',
		'desc' => _x( 'Show headings "More Events" between list and bricks events.', 'Metaboxes', SPECTRA_PLUGIN ),
		'main_group' => 'events_layout',
		'group_name' => array('mixed')
	)
);

/* Add class instance */
$event_date_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	EVENTS ALL - TEMPLATE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Events Options', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_evens_options', 
	'page' => array(
		'page'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'page-templates/events-all.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
					  
	array(
		'name' => _x( 'Events Limit', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_limit',
		'type' => 'range',
		'min' => $pp,
		'max' => 200,
		'unit' => '',//_x( 'events', 'Metaboxes', SPECTRA_PLUGIN ),
		'std' => '10',
		'desc' => _x( 'Number of events limit.', 'Metaboxes', SPECTRA_PLUGIN )
	)
);

/* Add class instance */
$event_date_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	EVENTS - POST TYPE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Event Date', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_event_date_options', 
	'page' => array(
		'spectra_events'
	), 
	'context' => 'side', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
					  
	array(
		'name' => _x( 'Event Date', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => array(
			array('id' => '_event_date_start', 'std' => date('Y-m-d')),
			array('id' => '_event_date_end', 'std' => date('Y-m-d'))
		),
		'type' => 'date_range',
		'desc' => _x( 'Enter the event date; eg 2010-09-11', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Event Time', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => array(
			array('id' => '_event_time_start', 'std' => '21:00'),
			array('id' => '_event_time_end', 'std' => '00:00')
		),
		'type' => 'time_range',
		'desc' => _x( 'Enter the event time; eg 21:00', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Repeat', 'Metaboxes', SPECTRA_PLUGIN ),
		'type' => 'select',
		'id' => '_repeat_event',
		'std' => 'default',
		'options' => array(
			array('name' => _x( 'None', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'none'),
			array('name' => _x( 'Weekly', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'weekly')
			//array('name' => _x( 'Monthly', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'monthly'),
		),
		'group' => 'repeat_event',
		'desc' => _x( 'Repeat event.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Every', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_every',
		'type' => 'range',
		'min' => 1,
		'max' => 52,
		'unit' => _x( 'week(s)', 'Metaboxes', SPECTRA_PLUGIN ),
		'std' => '1',
		'main_group' => 'repeat_event',
		'group_name' => array('weekly'),
		'desc' => _x( 'Repeat event every week(s).', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Day(s)', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_weekly_days',
		'type' => 'multiselect',
		'std' => array('monday', 'saturday'),
		'options' => array(
			array('name' => _x( 'Monday', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'monday'),
			array('name' => _x( 'Tuesday', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'tuesday'),
			array('name' => _x( 'Wednesday', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'wednesday'),
			array('name' => _x( 'Thursday', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'thursday'),
			array('name' => _x( 'Friday', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'friday'),
			array('name' => _x( 'Saturday', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'saturday'),
			array('name' => _x( 'Sunday', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'sunday'),
		),
		'main_group' => 'repeat_event',
		'group_name' => array('weekly'),
		'desc' => _x( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple items.', 'Metaboxes', SPECTRA_PLUGIN )
		),
);

/* Add class instance */
$event_date_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	EVENTS - POST TYPE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Event Options', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_event_options', 
	'page' => array(
		'spectra_events'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);

/* Meta options */
$meta_options = array(
	array(
		'name' => _x( 'Big Event Image', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => array(
			array( 'id' => '_event_image', 'std' => '')
		),
		'type' => 'add_image',
		'button_title' => _x( 'Add Image', 'Metaboxes', SPECTRA_PLUGIN ),
		'desc' => _x( 'Big event image for events list, 1920x573px.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array( 
		'name' => _x( 'Show Countdown Header', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_countdown',
		'type' => 'switch_button',
		'std' => 'off',
		'desc' => _x( 'Show countdown header instead default header.', 'Metaboxes', SPECTRA_PLUGIN ),
	),
	array(
		'name' => _x( 'Event Address', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_event_address',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '40',
		'desc' => _x( 'Event location address.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Ticket URL', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_ticket_url',
		'type' => 'easy_link',
		'desc' => _x( 'Paste the full URL (include http://) of your link or click and select it from your site.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array( 
		'name' => _x( 'Link Target', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_ticket_target',
		'type' => 'switch_button',
		'std' => 'off',
		'desc' => _x( 'Open link in new window.', 'Metaboxes', SPECTRA_PLUGIN ),
	),
);

/* Add class instance */
$event_date_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	FOOTER MODULES
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Footer Modules', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_footer_modules_options', 
	'page' => array(
		'post', 
		'page',
		'spectra_portfolio',
		'spectra_events'
	), 
	'context' => 'normal', 
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post', 
		'default',
		'page-templates/portfolio.php',
		'page-templates/events.php',
		'page-templates/events-all.php',
		'page-templates/blog.php',
		'page-templates/blog-grid.php',
		'page-templates/modular.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN
);

$fm_desc = '';

// Mailchimp
if ( ! function_exists( 'mailchimpSF_signup_form' ) ) {
	$fm_desc .= '<br>' . _x( 'NOTE: Newsletter is not displayed because MAILCHIMP plugin is not installed or activated.', 'Metaboxes', SPECTRA_PLUGIN );
}

/* Meta options */
$meta_options = array(
	array(
		'name' => _x( 'Foter Modules', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_footer_module',
		'std' => 'project_link',
		'type' => 'select',
		'options' => array(
			array( 'name' => '', 'value' => 'none' ),
			array( 'name' => _x( 'MailChimp Newsletter', 'Metaboxes', SPECTRA_PLUGIN ), 'value' => 'mailchimp' )
		),
		'group' => 'footer_module',
		'desc' => _x( 'Select footer module.', 'Metaboxes', SPECTRA_PLUGIN ) . $fm_desc
	)
);

/* Add class instance */
$fm_options_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );


/* ----------------------------------------------------------------------
	SHARE OPTIONS
/* ---------------------------------------------------------------------- */

/* Meta info */ 
$meta_info = array(
	'title' => _x( 'Share Options', 'Metaboxes', SPECTRA_PLUGIN ), 
	'id' =>'r_share_options', 
	'page' => array(
		'post', 
		'page',
		'spectra_portfolio',
		'spectra_events',
		'spectra_gallery'
	), 
	'context' => 'side',
	'priority' => 'high', 
	'callback' => '', 
	'template' => array( 
		'post', 
		'default',
		'page-templates/portfolio.php',
		'page-templates/events.php',
		'page-templates/events-all.php',
		'page-templates/blog.php',
		'page-templates/blog-grid.php',
		'page-templates/modular.php',
		'page-templates/fullscreen.php',
		'page-templates/gallery.php'
	),
	'admin_path'  => plugin_dir_url( __FILE__ ),
	'admin_uri'	 => plugin_dir_path( __FILE__ ),
	'admin_dir' => '',
	'textdomain' => SPECTRA_PLUGIN

);	


/* Meta options */
$meta_options = array(

	array(
		'name' => _x( 'Image', 'Metaboxes', SPECTRA_PLUGIN ),
		'type' => 'add_image',
		'id' => array(
			array('id' => 'share_image', 'std' => '')
		),
		'button_title' => _x('Add Image', 'Metaboxes', SPECTRA_PLUGIN ),
		'desc' => _x('Use images that are at least 1200 x 630 pixels for the best display on high resolution devices. At the minimum, you should use images that are 600 x 315 pixels to display link page posts with larger images. If share data isn\'t visible on Facebook, please use this link:', 'Metaboxes', SPECTRA_PLUGIN ) . '<br>'.'<a href="https://developers.facebook.com/tools/debug/" target="_blank">Facbook Debuger</a>'
	),
	array(
		'name' => _x( 'Title', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_share_title',
		'type' => 'text',
		'std' => '',
		'desc' => _x( 'A clear title without branding or mentioning the domain itself.', 'Metaboxes', SPECTRA_PLUGIN )
	),
	array(
		'name' => _x( 'Short Description', 'Metaboxes', SPECTRA_PLUGIN ),
		'id' => '_share_description',
		'type' => 'textarea',
		'tinymce' => 'false',
		'std' => '',
		'height' => '80',
		'desc' => _x( 'A clear description, at least two sentences long.', 'Metaboxes', SPECTRA_PLUGIN )
	)

);

/* Add class instance */
$fb_box = new MuttleyBox( $meta_options, $meta_info );

/* Remove variables */
unset( $meta_options, $meta_info );