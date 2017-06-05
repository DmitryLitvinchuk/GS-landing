<?php
/**
 * Plugin Name: 	Spectra
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/spectra
 * Author URI: 		http://rascals.eu
 * File:			scamp-player.php
 *
 * Register the Post Types for Scamp Player and some functions
 *
 * =========================================================================================================================================
 *
 * @package spectra-plugin
 * @since 1.0.0
 */


/* ----------------------------------------------------------------------
	INIT CLASS
/* ---------------------------------------------------------------------- */
if ( ! class_exists( 'R_Custom_Post' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'classes/class-r-custom-posts.php' );
}


/* ----------------------------------------------------------------------
	TRACKS

	Create a Custom Post Type for managing audio tracks.
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'spectra_tracks_post_type' ) ) :

function spectra_tracks_post_type() {

	// Get panel options
	$panel_options = get_option( 'spectra_panel_opts' );

	/* Class arguments */
	$args = array( 
		'post_name' => 'spectra_tracks', 
		'sortable' => false,
		'admin_path'  => plugin_dir_url( __FILE__ ),
		'admin_url'	 => plugin_dir_path( __FILE__ ),
		'admin_dir' => '',
		'textdomain' => SPECTRA_PLUGIN
	);

	/* Post Labels */
	$labels = array(
		'name' => _x( 'Tracks', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
		'singular_name' => _x( 'Tracks', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
		'add_new' => _x( 'Add New', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
		'add_new_item' => _x( 'Add New Tracks', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
		'edit_item' => _x( 'Edit Tracks', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
		'new_item' => _x( 'New Tracks', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
		'view_item' => _x( 'View Tracks', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
		'search_items' => _x( 'Search Tracks', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
		'not_found' =>  _x( 'No tracks found', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
		'not_found_in_trash' => _x( 'No tracks found in Trash', 'Custom Posts - Tracks', SPECTRA_PLUGIN ), 
		'parent_item_colon' => ''
	);

	/* Post Options */
	$options = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => 'tracks',
			'with_front' => false,
		),
		'supports' => array('title', 'editor'),
		'menu_icon' => 'dashicons-format-audio'
	);

	/* Add class instance */
	if ( class_exists( 'R_Custom_Post' ) ) {
		$spectra_tracks = new R_Custom_Post( $args, $options );
	}

	/* Remove variables */
	unset( $args, $options );


	/* COLUMN LAYOUT
	 ---------------------------------------------------------------------- */
	add_filter( 'manage_edit-spectra_tracks_columns', 'tracks_columns' );

	function tracks_columns( $columns ) {
		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => _x( 'Title', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
			'tracks_id' => _x( 'Tracks ID', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
			'date' => _x( 'Date', 'Custom Posts - Tracks', SPECTRA_PLUGIN )
		);

		return $columns;
	}

	add_action( 'manage_posts_custom_column', 'tracks_display_columns' );

	function tracks_display_columns( $column ) {

		global $post;
		
		switch ($column) {
			case 'tracks_id':
			    the_ID();
			
			break;
		}
	}
}

add_action( 'init', 'spectra_tracks_post_type', 0 );
endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	SCAMP PLAYER SCRIPTS
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'scamp_player_scripts' ) ) :

function scamp_player_scripts() {

	// Get panel options
	$panel_options = get_option( 'spectra_panel_opts' );

	$plugin_folder = dirname( __FILE__ );

	// Player Styles
	wp_enqueue_style( 'scamp-player' , plugins_url( 'scamp-player/css/scamp.player.min.css' , $plugin_folder ) , array() , '1.0' , 'all' );

	if ( $panel_options['player_skin'] ) {
		wp_enqueue_style( 'scamp-player-skin' , plugins_url( 'scamp-player/css/scamp.player.' . $panel_options['player_skin'] . '.min.css' , $plugin_folder ) , array() , '1.0' , 'all' );
	}

	// Player Scripts
	wp_enqueue_script( 'soundcloud-sdk' , 'https://connect.soundcloud.com/sdk.js' , false , false , true );
	wp_enqueue_script( 'soundmanager2' , plugins_url( 'scamp-player/js/soundmanager2-nodebug-jsmin.js' , $plugin_folder ) , array( 'jquery' ) , '1.0' , true );
	wp_enqueue_script( 'iscroll' , plugins_url( 'scamp-player/js/iscroll.js' , $plugin_folder ) , array( 'jquery' ) , '1.0' , true );
	wp_enqueue_script( 'scamp-player' , plugins_url( 'scamp-player/jquery.scamp.player.min.js' , $plugin_folder ) , array( 'jquery' ) , '1.0' , true );
	wp_enqueue_script( 'scamp-player-init' , plugins_url( 'scamp-player/jquery.scamp.player-init.js' , $plugin_folder ) , array( 'jquery' ) , '1.0' , true );

	// Settings
	$panel_options['player_autoplay'] === 'on' ? $panel_options['player_autoplay'] = true : $panel_options['player_autoplay'] = false;
	$panel_options['player_random'] === 'on' ? $panel_options['player_random'] = true : $panel_options['player_random'] = false;
	$panel_options['player_loop'] === 'on' ? $panel_options['player_loop'] = true : $panel_options['player_loop'] = false;
	$panel_options['load_first_track'] === 'on' ? $panel_options['load_first_track'] = true : $panel_options['load_first_track'] = false;
	$panel_options['player_titlebar'] === 'on' ? $panel_options['player_titlebar'] = true : $panel_options['player_titlebar'] = false;
	isset( $panel_options['soundcloud_id'] ) && $panel_options['soundcloud_id'] !== '' ? $panel_options['soundcloud_id'] = $panel_options['soundcloud_id'] : $panel_options['soundcloud_id'] = '23f5c38e0aa354cdd0e1a6b4286f6aa4';

	$js_variables = array(
		'plugin_uri'     => plugins_url('scamp-player' , $plugin_folder ),
		'autoplay' => $panel_options['player_autoplay'],
		'random' => $panel_options['player_random'],
		'loop' => $panel_options['player_loop'],
		'load_first_track' => $panel_options['load_first_track'],
		'titlebar' => $panel_options['player_titlebar'],
		'soundcloud_id' => $panel_options['soundcloud_id'],
		'volume' => $panel_options['player_volume'],
		'play_label' => _x( 'Play', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
		'cover_label' => _x( 'Cover', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
		'title_label' => _x( 'Title/Artist', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
		'buy_label' => _x( 'Buy/Download', 'Custom Posts - Tracks', SPECTRA_PLUGIN ),
		'remove_label' => _x( 'Remove', 'Custom Posts - Tracks', SPECTRA_PLUGIN )
	);
	wp_localize_script( 'scamp-player-init', 'scamp_vars', $js_variables );

}
add_action( 'wp_enqueue_scripts' , 'scamp_player_scripts' );

endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	SCAMP PLAYER GET LIST ARRAY

 	return: array or false
 	example arrays returns:

	array(
	  	array (
			'custom' => boolean,
			'custom_url' => boolean / string,
			'title' => string,
			'release_url' => string,
			'release_target' => string, 
			'artists' => string,
			'artists_url' => string,
			'artists_target' => string,
			'cart_url' => string,
			'cart_target' => string,
			'free_download' => string,
			'links' => boolean / string,
			'cover' => boolean / string,
			'url' => string
		)
	)
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'scamp_player_get_list' ) ) :

	function scamp_player_get_list( $audio_post ) {

		// Get panel options
		$panel_options = get_option( 'spectra_panel_opts' );

		// Get panel options
		$audio_ids = get_post_meta( $audio_post, '_audio_tracks', true );

		if ( ! $audio_ids || $audio_ids == '' ) {
			 return false;
		}

		$count = 0;
		$ids = explode( '|', $audio_ids );
		$defaults = array(
			'custom' => false,
			'custom_url' => false,
			'title' => '',
			'artists' => false,
			'links' => false,
			'cover' => false,
			'release_url' => '',
			'release_target' => '', 
			'artists' => '',
			'artists_url' => '',
			'artists_target' => '',
			'cart_url' => '',
			'cart_target' => '',
			'free_download' => 'no'
		);

		$tracklist = array();

		/* Start Loop */
		foreach ( $ids as $id ) {

			// Vars 
			$title = '';
			$subtitle = '';

			/* Get image meta */
			$track = get_post_meta( $audio_post, '_audio_tracks_' . $id, true );

			/* Add default values */
			if ( isset( $track ) && is_array( $track ) ) {
				$track = array_merge( $defaults, $track );
			} else {
				$track = $defaults;
			}

			/* Check if track is custom */
		   	if ( wp_get_attachment_url( $id ) ) {
		      	$track_att = get_post( $id );
		      	$track['url'] = wp_get_attachment_url( $id );
		      	if ( $track['title'] == '' ) {
		      		$track['title'] = $track_att->post_title;
		      	}
		    } else {
				$track['url'] = $track['custom_url'];
				if ( $track['url'] == '' ) {
					continue;
				}
				if ( $track['title'] == '' ) {
					$track['title'] = __( 'Custom Title', SPECTRA_PLUGIN );
				}
				$track['custom'] = true;
		    }
		    
		    array_push( $tracklist, $track );
		}
		
		return $tracklist;
	}

endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	SCAMP PLAYER INIT
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'scamp_player_init' ) ) :

function scamp_player_init() {

	// Get panel options
	$panel_options = get_option( 'spectra_panel_opts' );

	// Player Classes
	$classes = '';

	// JS name
	$js_name = 'scamp_player';

	// Show Player on startup
	if ( $panel_options['show_player'] === 'on' ) {
		$classes .= 'sp-show-player';
	}

	// Show Tracklist on startup
	if ( $panel_options['show_tracklist'] === 'on' ) {
		$classes .= ' sp-show-list';
	}

	?>
	<script type="text/javascript">
		if ( undefined !== window.jQuery ) {
	    	// script dependent on jQuery
	    	var <?php echo esc_js( $js_name ) ?>;
		}
	</script>
	<div id="scamp_player" class="<?php echo esc_attr( $classes ); ?>">
		<?php  
			// Startup Tracklist
			if ( $panel_options['startup_tracklist'] !== 'none' ) {
				$startup_tracklist = scamp_player_get_list( $panel_options['startup_tracklist'] );
				if ( $startup_tracklist ) {
					foreach ( $startup_tracklist as $track ) {
						echo '<a href="' . esc_url( $track['url'] ) . '" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '">' . esc_html( $track['title'] ) . '</a>' ."\n";
					}
				}
			}

		?>
	</div>
	<?php
}
add_action( 'wp_footer', 'scamp_player_init' );

endif; // End check for function_exists()