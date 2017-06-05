<?php
/**
 * Plugin Name: 	Spectra
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/spectra
 * Author URI: 		http://rascals.eu
 * File:			vc-extend.php
 * =========================================================================================================================================
 *
 * @package spectra-plugin
 * @since 1.0.0
 */

// Remove visual composer elements
if ( ! function_exists( 'spectra_remove_element' ) ) {

    function spectra_remove_element() {
        // vc_remove_element('vc_accordion_tab');
        // vc_remove_element('vc_accordion');
        // vc_remove_element('vc_button');
        vc_remove_element('vc_carousel');
        // vc_remove_element('vc_column_text');
        // vc_remove_element('vc_cta_button');
        // vc_remove_element('vc_facebook');
        // vc_remove_element('vc_button2');
        // vc_remove_element('vc_cta_button2');
        vc_remove_element('vc_flickr');
        // vc_remove_element('vc_gallery');
        // vc_remove_element('vc_gmaps');
        // vc_remove_element('vc_googleplus');
        vc_remove_element('vc_images_carousel');
        // vc_remove_element('vc_item');
        // vc_remove_element('vc_items');
        // vc_remove_element('vc_message');
        vc_remove_element('vc_pie');
        // vc_remove_element('vc_pinterest');
        vc_remove_element('vc_posts_grid');
        // vc_remove_element('vc_posts_slider');
        // vc_remove_element('vc_progress_bar');
        // vc_remove_element('vc_raw_html');
        // vc_remove_element('vc_separator');
        // vc_remove_element('vc_single_image');
        // vc_remove_element('vc_tab');
        // vc_remove_element('vc_tabs');
        // vc_remove_element('vc_teaser_grid');
        // vc_remove_element('vc_text_separator');
        // vc_remove_element('vc_toggle');
        // vc_remove_element('vc_tweetmeme');
        // vc_remove_element('vc_twitter');
        // vc_remove_element('vc_video');
        // vc_remove_element('vc_raw_js');
        // vc_remove_element('vc_tour');
        // vc_remove_element("vc_widget_sidebar");
        // vc_remove_element("vc_wp_search");
        // vc_remove_element("vc_wp_meta");
        // vc_remove_element("vc_wp_recentcomments");
        // vc_remove_element("vc_wp_calendar");
        // vc_remove_element("vc_wp_pages");
        // vc_remove_element("vc_wp_tagcloud");
        // vc_remove_element("vc_wp_custommenu");
        // vc_remove_element("vc_wp_text");
        // vc_remove_element("vc_wp_posts");
        // vc_remove_element("vc_wp_links");
        // vc_remove_element("vc_wp_categories");
        // vc_remove_element("vc_wp_archives");
        // vc_remove_element("vc_wp_rss");
        // vc_remove_element("vc_gallery");
        // vc_remove_element("vc_teaser_grid");
        // vc_remove_element("vc_button");
    }
    spectra_remove_element();
}

// Remove visual composer elements
if ( ! function_exists( 'spectra_remove_grid' ) ) {

    function spectra_remove_grid() {

        vc_remove_element("vc_basic_grid");
        vc_remove_element("vc_basic_grid_filter");
        vc_remove_element("vc_masonry_media_grid");
        vc_remove_element("vc_media_grid");
        vc_remove_element("vc_masonry_grid");
        vc_remove_element("vc_grid_item");

        function grid_elements_menu(){
            remove_menu_page( 'edit.php?post_type=vc_grid_item' );
            remove_submenu_page( 'vc-general', 'edit.php?post_type=vc_grid_item' );
            global $submenu;
            // var_dump($submenu);
             unset( $submenu['vc-general'][6] );
        }
        add_action( 'admin_menu', 'grid_elements_menu' );
      
    }
    spectra_remove_grid();
}

// Disable frontend editor
if ( function_exists( 'vc_disable_frontend' ) ){
    vc_disable_frontend();
}

// Disable customer notifications
if ( function_exists( 'vc_set_as_theme' ) ){
    vc_set_as_theme( $disable_updater = false );
}


/* ----------------------------------------------------------------------

    RECENT POSTS

/* ---------------------------------------------------------------------- */

function spectra_vc_recent_posts() {

    vc_map( array(
        "name" => __( "Recent Posts", SPECTRA_PLUGIN ),
        "base" => "recent_posts",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "description" => '',
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Title", SPECTRA_PLUGIN ),
                "param_name" => "title",
                "value" => '',
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Limit", SPECTRA_PLUGIN ),
                "param_name" => "limit",
                "value" => '4',
                "admin_label" => false
            ),
             array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Link", SPECTRA_PLUGIN ),
                "param_name" => "button_link",
                "value" => '',
                "description" => __( "URL to blog page.", SPECTRA_PLUGIN ),
                "admin_label" => false
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Display Posts Thumbnails", SPECTRA_PLUGIN ),
                "param_name" => "show_posts_thumbs",
                "value" => array( 'Yes, please' => '0' ),
                "admin_label" => false,
                "description" => __( "Display posts thumbnails.", SPECTRA_PLUGIN )
            ),
        )
   ) );
}

add_action( 'vc_before_init', 'spectra_vc_recent_posts' );


/* ----------------------------------------------------------------------

    POSTS CAROUSEL

/* ---------------------------------------------------------------------- */

function spectra_vc_posts_carousel() {

    vc_map( array(
        "name" => __( "Posts Carousel", SPECTRA_PLUGIN ),
        "base" => "posts_carousel",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "description" => '',
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Title", SPECTRA_PLUGIN ),
                "param_name" => "title",
                "value" => '',
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Limit", SPECTRA_PLUGIN ),
                "param_name" => "limit",
                "value" => '4',
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Visible Posts", SPECTRA_PLUGIN ),
                "param_name" => "visible_items",
                "value" => array( '' => '', '1' => '1', '2' => '2', '3' => '3', '4' => '4' ),
                "admin_label" => false,
                "description" => __( "Number of visible posts on screen.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Post IDs", SPECTRA_PLUGIN ),
                "param_name" => "posts_in",
                "value" => '',
                "admin_label" => false,
                "description" => __( "Fill this field with posts IDs separated by commas (,), to retrieve only them.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "exploded_textarea",
                "class" => "",
                "heading" => __( "Categories", SPECTRA_PLUGIN ),
                "param_name" => "categories_in",
                "value" => "",
                "description" => "Fill this field with categories names divided by linebreaks (Enter), to retrieve only them."
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Link", SPECTRA_PLUGIN ),
                "param_name" => "button_link",
                "value" => '',
                "description" => __( "URL to blog page.", SPECTRA_PLUGIN ),
                "admin_label" => false
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Display Posts Date", SPECTRA_PLUGIN ),
                "param_name" => "show_posts_date",
                "value" => array( 'Yes, please' => '0' ),
                "admin_label" => false,
                "description" => __( "Display posts date.", SPECTRA_PLUGIN )
            ),
        )
   ) );
}

add_action( 'vc_before_init', 'spectra_vc_posts_carousel' );


/* ----------------------------------------------------------------------

    POSTS GRID

/* ---------------------------------------------------------------------- */

function spectra_vc_posts_grid() {

    vc_map( array(
        "name" => __( "Posts Grid", SPECTRA_PLUGIN ),
        "base" => "posts_grid",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "description" => '',
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Title", SPECTRA_PLUGIN ),
                "param_name" => "title",
                "value" => '',
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Limit", SPECTRA_PLUGIN ),
                "param_name" => "limit",
                "value" => '4',
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Post IDs", SPECTRA_PLUGIN ),
                "param_name" => "posts_in",
                "value" => '',
                "admin_label" => false,
                "description" => __( "Fill this field with posts IDs separated by commas (,), to retrieve only them.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "exploded_textarea",
                "class" => "",
                "heading" => __( "Categories", SPECTRA_PLUGIN ),
                "param_name" => "categories_in",
                "value" => "",
                "description" => "Fill this field with categories names divided by linebreaks (Enter), to retrieve only them."
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Link", SPECTRA_PLUGIN ),
                "param_name" => "button_link",
                "value" => '',
                "description" => __( "URL to blog page.", SPECTRA_PLUGIN ),
                "admin_label" => false
            )
        )
   ) );
}

add_action( 'vc_before_init', 'spectra_vc_posts_grid' );


/* ----------------------------------------------------------------------

    EVENT COUNTDOWN

/* ---------------------------------------------------------------------- */

function spectra_vc_event_countdown() {

    vc_map( array(
        "name" => __( "Event Countdown", SPECTRA_PLUGIN ),
        "base" => "event_countdown",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "description" => __( "Working only with \"Stretch row and content (no paddings)\" ROW.", SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Title", SPECTRA_PLUGIN ),
                "param_name" => "title",
                "value" => '',
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Custom Event ID", SPECTRA_PLUGIN ),
                "param_name" => "custom_event_id",
                "value" => '0',
                "admin_label" => true
            )
        ),
   ) );
}

add_action( 'vc_before_init', 'spectra_vc_event_countdown' );


/* ----------------------------------------------------------------------

    PORTFOLIO

/* ---------------------------------------------------------------------- */

function spectra_vc_portfolio() {

    vc_map( array(
        "name" => __( "Portfolio", SPECTRA_PLUGIN ),
        "base" => "portfolio",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "description" => __( "Working only with \"Stretch row and content (no paddings)\" ROW.", SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Order By", SPECTRA_PLUGIN ),
                "param_name" => "order",
                "value" => array( '' => '', 'Custom' => 'menu_order', 'Title' => 'title', 'Date' => 'date' ),
                "admin_label" => false,
                "description" => __( "Select menu order.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Display Filter", SPECTRA_PLUGIN ),
                "param_name" => "filter",
                "value" => array( 'Yes, please' => '1' ),
                "admin_label" => false,
                "description" => __( "Display portfolio filter.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Portfolio Items", SPECTRA_PLUGIN ),
                "param_name" => "limit",
                "value" => '40',
                "admin_label" => false,
                "description" => __( "Number of portfolio items. Value '-1' display all items.", SPECTRA_PLUGIN )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'spectra_vc_portfolio' );


/* ----------------------------------------------------------------------

    EVENTS

/* ---------------------------------------------------------------------- */

function spectra_vc_events() {

    vc_map( array(
        "name" => __( "Events", SPECTRA_PLUGIN ),
        "base" => "events",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "description" => __( "Working only with \"Stretch row and content (no paddings)\" ROW.", SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Events Type", SPECTRA_PLUGIN ),
                "param_name" => "event_type",
                "value" => array( '' => '', 'Future Events' => 'future-events', 'Past Events' => 'past-events' ),
                "admin_label" => true,
                "description" => __( "Select events type.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Events Layout", SPECTRA_PLUGIN ),
                "param_name" => "layout",
                "value" => array(
                    '' => '',
                    'Mixed (List+Bricks)' => 'mixed', 
                    'List' => 'list',
                    'Bricks' => 'bricks'
                ),
                "admin_label" => true,
                "description" => __( "Select events layout.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Events Heading", SPECTRA_PLUGIN ),
                "param_name" => "events_heading",
                "value" => array( 'Yes, please' => '1' ),
                "admin_label" => false,
                "description" => __( "Display events heading.", SPECTRA_PLUGIN ),
                "dependency" => Array( 'element' => "layout", 'value' => array( 'mixed' ) )
            ),
             array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "List Events Number", SPECTRA_PLUGIN ),
                "param_name" => "featured_events",
                "value" => '3',
                "admin_label" => false,
                "description" => __( "Number of list events.", SPECTRA_PLUGIN ),
                "dependency" => Array( 'element' => "layout", 'value' => array( 'mixed' ) )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Events", SPECTRA_PLUGIN ),
                "param_name" => "limit",
                "value" => '40',
                "admin_label" => false,
                "description" => __( "Number of events items. Value '-1' display all items.", SPECTRA_PLUGIN )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'spectra_vc_events' );


/* ----------------------------------------------------------------------

    EVENTS TABLE

/* ---------------------------------------------------------------------- */

function spectra_vc_events_table() {

    vc_map( array(
        "name" => __( "Events Table", SPECTRA_PLUGIN ),
        "base" => "events_table",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "description" => "",
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Events Type", SPECTRA_PLUGIN ),
                "param_name" => "event_type",
                "value" => array( '' => '', 'Future Events' => 'future-events', 'Past Events' => 'past-events' ),
                "admin_label" => true,
                "description" => __( "Select events type.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Events", SPECTRA_PLUGIN ),
                "param_name" => "limit",
                "value" => '40',
                "admin_label" => false,
                "description" => __( "Number of events items. Value '-1' display all items.", SPECTRA_PLUGIN )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'spectra_vc_events_table' );


/* ----------------------------------------------------------------------

    SINGLE TRACK

/* ---------------------------------------------------------------------- */

function spectra_vc_single_track() {

    global $wpdb;

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
    $tracks[''] = 0;
    if ( $sql_tracks ) {
        $count = 0;
        foreach( $sql_tracks as $track_post ) {
            $tracks[$track_post->post_title] = $track_post->id;
            // $tracks = array_push($variable, $newValue);
            $count++;
        }
    }

    vc_map( array(
        "name" => __( "Single Track", SPECTRA_PLUGIN ),
        "base" => "track",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Track", SPECTRA_PLUGIN ),
                "param_name" => "id",
                "value" => $tracks,
                "admin_label" => true,
                "description" => __( "Select track ID.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Style", SPECTRA_PLUGIN ),
                "param_name" => "style",
                "value" => array( '' => '', 'Normal' => 'normal', 'Compact' => 'compact' ),
                "admin_label" => false,
                "description" => __( "Select player style.", SPECTRA_PLUGIN )
            )
      )
   ) );
}

add_action( 'vc_before_init', 'spectra_vc_single_track' );


/* ----------------------------------------------------------------------

    TRACKLIST GRID

/* ---------------------------------------------------------------------- */

function spectra_vc_tracklist_grid() {

    global $wpdb;

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
     $tracks[''] = 0;
    if ( $sql_tracks ) {
        $count = 0;
        foreach( $sql_tracks as $track_post ) {
            $tracks[$track_post->post_title] = $track_post->id;
            // $tracks = array_push($variable, $newValue);
            $count++;
        }
    }

    vc_map( array(
        "name" => __( "Tracklist Grid", SPECTRA_PLUGIN ),
        "base" => "tracklist_grid",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Tracklist", SPECTRA_PLUGIN ),
                "param_name" => "id",
                "value" => $tracks,
                "admin_label" => true,
                "description" => __( "Select track ID.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Tracks Per Row", SPECTRA_PLUGIN ),
                "param_name" => "in_row",
                "value" => array( '', '2', '3', '4', '5' ),
                "admin_label" => false
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Tracklist Details", SPECTRA_PLUGIN ),
                "param_name" => "track_meta",
                "value" => array( 'Yes, please' => '1' ),
                "admin_label" => false,
                "description" => __( "Display tracklist titles and artists.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Tracklist Button", SPECTRA_PLUGIN ),
                "param_name" => "list_button",
                "value" => array( 'Yes, please' => '1' ),
                "admin_label" => false,
                "description" => __( "Display tracklist button.", SPECTRA_PLUGIN )
            ),
        )
   ) );
}

add_action( 'vc_before_init', 'spectra_vc_tracklist_grid' );


/* ----------------------------------------------------------------------

    TRACKS CAROUSEL

/* ---------------------------------------------------------------------- */

function spectra_vc_tracks_carousel() {

    global $wpdb;

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
    $tracks[''] = 0;
    if ( $sql_tracks ) {
        $count = 0;
        foreach( $sql_tracks as $track_post ) {
            $tracks[$track_post->post_title] = $track_post->id;
            // $tracks = array_push($variable, $newValue);
            $count++;
        }
    }

    vc_map( array(
        "name" => __( "Tracks Carousel", SPECTRA_PLUGIN ),
        "base" => "tracks_carousel",
        "icon" => "",
        "class" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "description" => '',
        "params" => array(
             array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Title", SPECTRA_PLUGIN ),
                "param_name" => "title",
                "value" => '',
                "admin_label" => true
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Tracklist", SPECTRA_PLUGIN ),
                "param_name" => "id",
                "value" => $tracks,
                "admin_label" => true,
                "description" => __( "Select track ID.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Limit", SPECTRA_PLUGIN ),
                "param_name" => "limit",
                "value" => '4',
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Visible Tracks", SPECTRA_PLUGIN ),
                "param_name" => "visible_items",
                "value" => array( '' => '', '1' => '1', '2' => '2', '3' => '3', '4' => '4' ),
                "admin_label" => false,
                "description" => __( "Number of visible tracks on screen.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Link", SPECTRA_PLUGIN ),
                "param_name" => "button_link",
                "value" => '',
                "description" => __( "URL to blog page.", SPECTRA_PLUGIN ),
                "admin_label" => false
            )
        )
   ) );
}

add_action( 'vc_before_init', 'spectra_vc_tracks_carousel' );


/* ----------------------------------------------------------------------

    TRACKLIST

/* ---------------------------------------------------------------------- */

function spectra_vc_tracklist() {

    global $wpdb;

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
    $tracks[''] = 0;
    if ( $sql_tracks ) {
        $count = 0;
        foreach( $sql_tracks as $track_post ) {
            $tracks[$track_post->post_title] = $track_post->id;
            // $tracks = array_push($variable, $newValue);
            $count++;
        }
    }

    vc_map( array(
        "name" => __( "Tracklist", SPECTRA_PLUGIN ),
        "base" => "tracklist",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Tracklist", SPECTRA_PLUGIN ),
                "param_name" => "id",
                "value" => $tracks,
                "admin_label" => true,
                "description" => __( "Select track ID.", SPECTRA_PLUGIN )
            ),
             array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Style", SPECTRA_PLUGIN ),
                "param_name" => "style",
                "value" => array( '' => '', 'Normal' => 'normal', 'Compact' => 'compact' ),
                "admin_label" => false,
                "description" => __( "Select player style.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "Tracklist Button", SPECTRA_PLUGIN ),
                "param_name" => "list_button",
                "value" => array( 'Yes, please' => '1' ),
                "admin_label" => false,
                "description" => __( "Display tracklist button.", SPECTRA_PLUGIN )
            ),
        )
   ) );
}

add_action( 'vc_before_init', 'spectra_vc_tracklist' );


/* ----------------------------------------------------------------------

    SLIDER

/* ---------------------------------------------------------------------- */

function spectra_vc_slider() {

    global $wpdb;

    /* Get Sliders  */
    $slider = array();
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
    $slider[''] = '';
    if ( $sql_slider ) {
        $count = 0;
        foreach( $sql_slider as $track_post ) {
            $slider[$track_post->post_title] = $track_post->id;
            // $slider = array_push($variable, $newValue);
            $count++;
        }
    }

    vc_map( array(
        "name" => __( "Slider", SPECTRA_PLUGIN ),
        "base" => "slider",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Select Slider ID", SPECTRA_PLUGIN ),
                "param_name" => "id",
                "value" => $slider,
                "description" => __( "Select slider ID.", SPECTRA_PLUGIN )
            )
        )
   ) );
}

add_action( 'vc_before_init', 'spectra_vc_slider' );


/* ----------------------------------------------------------------------

    DETAILS LIST

/* ---------------------------------------------------------------------- */

function spectra_vc_details_list() {

    vc_map( array(
        "name" => __( "Details List", SPECTRA_PLUGIN ),
        "base" => "details_list",
        "as_parent" => array( 'only' => 'detail' ),
        "content_element" => true,
        "show_settings_on_create" => false,
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Extra class name", SPECTRA_PLUGIN ),
                "param_name" => "el_class",
                "value" => '',
                "admin_label" => true,
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", SPECTRA_PLUGIN )
            ),
        ),
        "js_view" => 'VcColumnView'
        ) 
    );
}

add_action( 'vc_before_init', 'spectra_vc_details_list' );

function spectra_vc_detail() {

    vc_map( array(
        "name" => __( "Detail", SPECTRA_PLUGIN ),
        "base" => "detail",
        "as_child" => array( 'only' => 'details_list' ),
        "content_element" => true,
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Label", SPECTRA_PLUGIN ),
                "param_name" => "label",
                "value" => '',
                "admin_label" => true,
                "description" => __( "Type detail label.", SPECTRA_PLUGIN )
            ),
             array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Value", SPECTRA_PLUGIN ),
                "param_name" => "value",
                "value" => '',
                "admin_label" => true,
                "description" => __( "Type detail value.", SPECTRA_PLUGIN )
            ),
      )
   ) );
}

add_action( 'vc_before_init', 'spectra_vc_detail' );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_details_list extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_detail extends WPBakeryShortCode {
    }
}


/* ----------------------------------------------------------------------

    BUTTONS

/* ---------------------------------------------------------------------- */

function spectra_vc_buttons() {

    vc_map( array(
        "name" => __( "Buttons", SPECTRA_PLUGIN ),
        "base" => "buttons",
        "as_parent" => array( 'only' => 'button' ),
        "content_element" => true,
        "show_settings_on_create" => false,
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Extra class name", SPECTRA_PLUGIN ),
                "param_name" => "el_class",
                "value" => '',
                "admin_label" => true,
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", SPECTRA_PLUGIN )
            ),
        ),
        "js_view" => 'VcColumnView'
        ) 
    );
}
add_action( 'vc_before_init', 'spectra_vc_buttons' );

function spectra_vc_button() {

    // Get icons
    if ( function_exists( 'spectra_get_icons' ) ) {
        $icons  = spectra_get_icons();
    } else {
        $icons = array();
    }


    vc_map( array(
        "name" => __( "Button", SPECTRA_PLUGIN ),
        "base" => "button",
        "as_child" => array( 'only' => 'buttons' ),
        "content_element" => true,
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Title", SPECTRA_PLUGIN ),
                "param_name" => "title",
                "value" => 'Button Title',
                "admin_label" => true,
                "description" => __( "Button title.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Link", SPECTRA_PLUGIN ),
                "param_name" => "link",
                "value" => '#',
                "admin_label" => false,
                "description" => __( "Button LINK.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Size", SPECTRA_PLUGIN ),
                "param_name" => "size",
                "value" => array( '' => '', 'Large' => 'large', 'Medium' => 'medium', 'Small' => 'small' ),
                "admin_label" => false,
                "description" => __( "Select button size.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Icon", SPECTRA_PLUGIN ),
                "param_name" => "icon",
                "value" => $icons,
                "admin_label" => false,
                "description" => __( "Select icon.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Icon Size", SPECTRA_PLUGIN ),
                "param_name" => "icon_size",
                "value" => '14',
                "admin_label" => false,
                "description" => __( "icon size (px).", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => __( "New Window", SPECTRA_PLUGIN ),
                "param_name" => "target",
                "value" => array( 'New window' => '0' ),
                "admin_label" => false,
                "description" => __( "Open link in new window/tab.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => __( "Background Color", SPECTRA_PLUGIN ),
                "param_name" => "bg_color",
                "value" => '#f4624a',
                "admin_label" => false,
                "description" => __( "Background Color.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => __( "Text Color", SPECTRA_PLUGIN ),
                "param_name" => "text_color",
                "value" => '#ffffff',
                "admin_label" => false,
                "description" => __( "Text Color.", SPECTRA_PLUGIN )
            )
        )
   ));
}

add_action( 'vc_before_init', 'spectra_vc_button' );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_buttons extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_button extends WPBakeryShortCode {
    }
}


/* ----------------------------------------------------------------------

    STATS

/* ---------------------------------------------------------------------- */

function spectra_vc_stats() {

    vc_map( array(
        "name" => __( "Stats List", SPECTRA_PLUGIN ),
        "base" => "stats",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Timer", SPECTRA_PLUGIN ),
                "param_name" => "timer",
                "value" => "10000",
                "description" => __( "Timer in ms.", SPECTRA_PLUGIN ),
            ),
            array(
                "type" => "exploded_textarea",
                "class" => "",
                "heading" => __( "Stats", SPECTRA_PLUGIN ),
                "param_name" => "stats",
                "value" => "1876|gigs,1200|happy peoples,1266|releases,2356|coffees per year,1076|red buls per year,2009|year of creation",
                "description" => __( "Enter stats, stat numeric value|stat name. NOTE: The minimum number of stats is 6.", SPECTRA_PLUGIN ),
            )
      )
    ));
}

add_action( 'vc_before_init', 'spectra_vc_stats' );


/* ----------------------------------------------------------------------

    PROCESS STEPS

/* ---------------------------------------------------------------------- */

function spectra_vc_proces_steps() {

    vc_map( array(
        "name" => __( "Process Steps", SPECTRA_PLUGIN ),
        "base" => "process_steps",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "attach_image",
                "class" => "",
                "heading" => __( "Image 01", SPECTRA_PLUGIN ),
                "param_name" => "image_1"
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Link 01", SPECTRA_PLUGIN ),
                "param_name" => "link_1",
                "value" => "none"
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Link Target 01", SPECTRA_PLUGIN ),
                "param_name" => "link_target_1",
                "value" => array(
                    '' => '',
                    "Self"   => "_self",
                    "Blank" => "_blank"
                )
            ),
            array(
                "type" => "attach_image",
                "class" => "",
                "heading" => __( "Image 02", SPECTRA_PLUGIN ),
                "param_name" => "image_2"
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Link 02", SPECTRA_PLUGIN ),
                "param_name" => "link_2",
                "value" => "none"
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Link Target 02", SPECTRA_PLUGIN ),
                "param_name" => "link_target_2",
                "value" => array(
                    '' => '',
                    "Self"   => "_self",
                    "Blank" => "_blank"
                )
            ),
            array(
                "type" => "attach_image",
                "class" => "",
                "heading" => __( "Image 03", SPECTRA_PLUGIN ),
                "param_name" => "image_3"
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Link 03", SPECTRA_PLUGIN ),
                "param_name" => "link_3",
                "value" => "none"
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Link Target 03", SPECTRA_PLUGIN ),
                "param_name" => "link_target_3",
                "value" => array(
                    '' => '',
                    "Self"   => "_self",
                    "Blank" => "_blank"
                )
            ),
            array(
                "type" => "attach_image",
                "class" => "",
                "heading" => __( "Image 04", SPECTRA_PLUGIN ),
                "param_name" => "image_4"
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Link 04", SPECTRA_PLUGIN ),
                "param_name" => "link_4",
                "value" => "none"
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Link Target 04", SPECTRA_PLUGIN ),
                "param_name" => "link_target_4",
                "value" => array(
                    '' => '',
                    "Self"   => "_self",
                    "Blank" => "_blank"
                )
            ),
      )
    ));
}

add_action( 'vc_before_init', 'spectra_vc_proces_steps' );


/* ----------------------------------------------------------------------

    PRICING COLUMN

/* ---------------------------------------------------------------------- */

function spectra_vc_pricing_column() {

    vc_map( array(
        "name" => __( "Pricing Column", SPECTRA_PLUGIN ),
        "base" => "pricing_column",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Title", SPECTRA_PLUGIN ),
                "param_name" => "title",
                "value" => __( "Basic Plan", SPECTRA_PLUGIN ),
                "description" => "",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Price", SPECTRA_PLUGIN ),
                "param_name" => "price",
                "description" => ""
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Currency", SPECTRA_PLUGIN ),
                "param_name" => "currency",
                "description" => ""
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Price Period", SPECTRA_PLUGIN ),
                "param_name" => "period",
                "description" => ""
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Link", SPECTRA_PLUGIN ),
                "param_name" => "link",
                "description" => ""
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Target", SPECTRA_PLUGIN ),
                "param_name" => "target",
                "value" => array(
                    "" => "",
                    "Self" => "_self",
                    "Blank" => "_blank",
                    "Parent" => "_parent"
                ),
                "description" => ""
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Button Text", SPECTRA_PLUGIN ),
                "param_name" => "button_text",
                "description" => ""
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Important", SPECTRA_PLUGIN ),
                "param_name" => "important",
                "value" => array(
                    '' => '',
                    "No" => "no",
                    "Yes" => "yes"
                ),
                "description" => ""
            ),
            array(
                "type" => "exploded_textarea",
                "class" => "",
                "heading" => __( "Content", SPECTRA_PLUGIN ),
                "param_name" => "list",
                "value" => "2x option 1,Free option 2,Unlimited option 3,Unlimited option 4,1x option 5",
                "description" => ""
            )
      )
    ));
}

add_action( 'vc_before_init', 'spectra_vc_pricing_column' );


/* ----------------------------------------------------------------------

    ICON COLUMN

/* ---------------------------------------------------------------------- */

function spectra_vc_icon_column() {

    // Get icons
    if ( function_exists( 'spectra_get_icons' ) ) {
        $icons  = spectra_get_icons();
    } else {
        $icons = array();
    }

    vc_map( array(
        "name" => __( "Icon Column", SPECTRA_PLUGIN ),
        "base" => "icon_column",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Title", SPECTRA_PLUGIN ),
                "param_name" => "title",
                "value" => __( "Total Responsiveness", SPECTRA_PLUGIN ),
                "description" => "",
                "admin_label" => true
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Icon", SPECTRA_PLUGIN ),
                "param_name" => "icon",
                "value" => $icons,
                "admin_label" => false,
                "description" => __( "Select icon.", SPECTRA_PLUGIN )
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Icon Place", SPECTRA_PLUGIN ),
                "param_name" => "icon_place",
                "value" => array(
                    '' => '',
                    "Left" => "icon_left",
                    "Right" => "icon_right",
                    'Top' => 'icon_top'
                ),
                "description" => ""
            ),
            array(
                "type" => "textarea_html",
                "class" => "",
                "heading" => __( "Content", SPECTRA_PLUGIN ),
                "param_name" => "content",
                "value" => "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.",
                "description" => ""
            )
      )
    ));
}

add_action( 'vc_before_init', 'spectra_vc_icon_column' );


/* ----------------------------------------------------------------------

    TWITTER LIST

/* ---------------------------------------------------------------------- */

function spectra_vc_tweets_list() {

    // Get icons
    if ( function_exists( 'spectra_get_icons' ) ) {
        $icons  = spectra_get_icons();
    } else {
        $icons = array();
    }

    vc_map( array(
        "name" => __( "Tweets List", SPECTRA_PLUGIN ),
        "base" => "tweets_list",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Username", SPECTRA_PLUGIN ),
                "param_name" => "username",
                "value" => "",
                "description" => "Twitter username.",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "API Key", SPECTRA_PLUGIN ),
                "param_name" => "api_key",
                "value" => "",
                "description" => 'Twitter app API Key.<br><a href="http://dev.twitter.com/apps">Find or Create your Twitter App</a>',
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "API Secret", SPECTRA_PLUGIN ),
                "param_name" => "api_secret",
                "value" => "",
                "description" => 'Twitter app API Secret Key.<br><a href="http://dev.twitter.com/apps">Find or Create your Twitter App</a>',
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Replies", SPECTRA_PLUGIN ),
                "param_name" => "replies",
                "value" => array(
                    '' => '',
                    "No" => "no",
                    "Yes" => "yes"
                ),
                "description" => "Show Twitter replies."
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Number of Tweets", SPECTRA_PLUGIN ),
                "param_name" => "limit",
                "value" => array( '' => '', "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12", "13" => "13", "14" => "14", "15" => "15", "16" => "16", "17" => "17", "18" => "18", "19" => "19", "20" => "20"
                ),
                "description" => "Number of Tweets."
            )
           
      )
    ));
}

add_action( 'vc_before_init', 'spectra_vc_tweets_list' );


/* ----------------------------------------------------------------------

    TWITTER SLIDER

/* ---------------------------------------------------------------------- */

function spectra_vc_tweets_slider() {

    // Get icons
    if ( function_exists( 'spectra_get_icons' ) ) {
        $icons  = spectra_get_icons();
    } else {
        $icons = array();
    }

    vc_map( array(
        "name" => __( "Tweets Slider", SPECTRA_PLUGIN ),
        "base" => "tweets_slider",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Username", SPECTRA_PLUGIN ),
                "param_name" => "username",
                "value" => "",
                "description" => "Twitter username.",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "API Key", SPECTRA_PLUGIN ),
                "param_name" => "api_key",
                "value" => "",
                "description" => 'Twitter app API Key.<br><a href="http://dev.twitter.com/apps">Find or Create your Twitter App</a>',
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "API Secret", SPECTRA_PLUGIN ),
                "param_name" => "api_secret",
                "value" => "",
                "description" => 'Twitter app API Secret Key.<br><a href="http://dev.twitter.com/apps">Find or Create your Twitter App</a>',
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Replies", SPECTRA_PLUGIN ),
                "param_name" => "replies",
                "value" => array(
                    '' => '',
                    "No" => "no",
                    "Yes" => "yes"
                ),
                "description" => "Show Twitter replies."
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Number of Tweets", SPECTRA_PLUGIN ),
                "param_name" => "limit",
                "value" => array( '' => '', "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12", "13" => "13", "14" => "14", "15" => "15", "16" => "16", "17" => "17", "18" => "18", "19" => "19", "20" => "20"
                ),
                "description" => "Number of Tweets."
            )
           
      )
    ));
}

add_action( 'vc_before_init', 'spectra_vc_tweets_slider' );


/* ----------------------------------------------------------------------

    GOOGLE MAPS

/* ---------------------------------------------------------------------- */

function spectra_vc_google_maps() {

    // Get icons
    if ( function_exists( 'spectra_get_icons' ) ) {
        $icons  = spectra_get_icons();
    } else {
        $icons = array();
    }

    vc_map( array(
        "name" => __( "Google Maps", SPECTRA_PLUGIN ),
        "base" => "google_maps",
        "class" => "",
        "icon" => "",
        "category" => __( 'by Rascals', SPECTRA_PLUGIN ),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Height", SPECTRA_PLUGIN ),
                "param_name" => "height",
                "value" => __( "400", SPECTRA_PLUGIN ),
                "description" => "Map height (px).",
                "admin_label" => false
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Address", SPECTRA_PLUGIN ),
                "param_name" => "address",
                "value" => __( "Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia", SPECTRA_PLUGIN ),
                "description" => 'Map address.',
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __( "Depth", SPECTRA_PLUGIN ),
                "param_name" => "depth",
                "value" => __( "15", SPECTRA_PLUGIN ),
                "description" => 'Zoom depth.',
                "admin_label" => false
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Zoom Control", SPECTRA_PLUGIN ),
                "param_name" => "zoom_control",
                "value" => array(
                    '' => '',
                    "No" => "false",
                    "Yes" => "true"
                ),
                "description" => "Zoom control."
            ),
           array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __( "Scroll Whell", SPECTRA_PLUGIN ),
                "param_name" => "scrollwheel",
                "value" => array(
                    '' => '',
                    "No" => "false",
                    "Yes" => "true"
                ),
                "description" => "Mouse scroll whell."
            )
           
      )
    ));
}
add_action( 'vc_before_init', 'spectra_vc_google_maps' );


/* ----------------------------------------------------------------------

    ROW EXTEND

/* ---------------------------------------------------------------------- */
vc_add_param( "vc_row", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => __( "Section Overlay",  SPECTRA_PLUGIN ),
    "param_name" => "overlay",
    "value" => array(
        '' => '',
        "None" => "none",
        "Opacity Black" => "black",
        "Dots"  => "dots",
        "Animated Noise" => "noise"
    ),
    "dependency" => Array( 'element' => "full_width", 'value' => array( 'stretch_row', 'stretch_row_content', 'stretch_row_content_no_spaces' ) )
));
vc_add_param( "vc_row", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => __( "Section Sign",  SPECTRA_PLUGIN ),
    "param_name" => "section_sign",
    '' => '',
    "value" => array(
        "No" => "no",
        "Yes" => "yes"
    ),
    "dependency" => 
        Array( 
            'element' => "full_width", 
            'value' => array( 
                'stretch_row', 
                'stretch_row_content', 
                'stretch_row_content_no_spaces' )
        ),
    "description" => __( "Display small sign on top of the section.", SPECTRA_PLUGIN ),
));
vc_add_param( "vc_row", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => __( "Sign Icon",  SPECTRA_PLUGIN ),
    "param_name" => "sign_icon",
    "value" => spectra_get_icons(),
    "dependency" => Array( 'element' => "section_sign", 'value' => array( 'yes' ) )
));
vc_add_param( "vc_row", array(
    "type" => "colorpicker",
    "class" => "",
    "heading" => __( "Sign Background Color",  SPECTRA_PLUGIN ),
    "param_name" => "sign_icon_bg",
    "value" => '#f4624a',
    "dependency" => Array( 'element' => "section_sign", 'value' => array( 'yes' ) )
));