<?php
/**
 * Plugin Name: 	Spectra
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/spectra
 * Author URI: 		http://rascals.eu
 * File:			post-types.php
 *
 * Register the Post types for SLider (spectra_slider), Portfolio (spectra_portfolio)
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
	PORTFOLIO

	Create a Custom Post type for managing portfolio items.
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'spectra_portfolio_post_type' ) ) :

function spectra_portfolio_post_type() {

	global $spectra_portfolio;

	/* Class arguments */
	$args = array( 
		'post_name' => 'spectra_portfolio', 
		'sortable' => true,
		'admin_path'  => plugin_dir_url( __FILE__ ),
		'admin_url'	 => plugin_dir_path( __FILE__ ),
		'admin_dir' => '',
		'textdomain' => SPECTRA_PLUGIN
	);

	/* Post Labels */
	$labels = array(
		'name' => _x( 'Portfolio', 'Post type - Portfolio', SPECTRA_PLUGIN ),
		'singular_name' => _x( 'Portfolio', 'Post type - Portfolio', SPECTRA_PLUGIN ),
		'add_new' => _x( 'Add New', 'Post type - Portfolio', SPECTRA_PLUGIN ),
		'add_new_item' => _x( 'Add New Portfolio Item', 'Post type - Portfolio', SPECTRA_PLUGIN ),
		'edit_item' => _x( 'Edit Portfolio Item', 'Post type - Portfolio', SPECTRA_PLUGIN ),
		'new_item' => _x( 'New Portfolio Item', 'Post type - Portfolio', SPECTRA_PLUGIN ),
		'view_item' => _x( 'View Portfolio Item', 'Post type - Portfolio', SPECTRA_PLUGIN ),
		'search_items' => _x( 'Search Items', 'Post type - Portfolio', SPECTRA_PLUGIN ),
		'not_found' =>  _x( 'No portfolio items found', 'Post type - Portfolio', SPECTRA_PLUGIN ),
		'not_found_in_trash' => _x( 'No portfolio items found in Trash', 'Post type - Portfolio', SPECTRA_PLUGIN ), 
		'parent_item_colon' => ''
	);

	/* Post Options */
	$options = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => _x( 'portfolios', 'SLUG', SPECTRA_PLUGIN ),
			'with_front' => false
		),
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields'),
		'menu_icon' => 'dashicons-portfolio'
	);

	/* Add Taxonomy */
	register_taxonomy('spectra_portfolio_cats', array('spectra_portfolio'), array(
		'hierarchical' => true,
		'label' => _x( 'Portfolio Categories', 'Post type - Portfolio', SPECTRA_PLUGIN ),
		'singular_label' => _x( 'category', 'Post type - Portfolio', SPECTRA_PLUGIN ),
		'query_var' => true,
		'rewrite' => array( 'slug' => _x( 'portfolio-categories', 'SLUG', SPECTRA_PLUGIN ) )
	));

	/* Add class instance */
	if ( class_exists( 'R_Custom_Post' ) ) {
		$spectra_portfolio = new R_Custom_Post( $args, $options );
	}

	/* Remove variables */
	unset( $args, $options );


	/* COLUMN LAYOUT
	 ---------------------------------------------------------------------- */
	add_filter( 'manage_edit-spectra_portfolio_columns', 'portfolio_columns' );

	function portfolio_columns( $columns ) {
		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => _x( 'Title', 'Post type - Portfolio', SPECTRA_PLUGIN ),
			'portfolio_preview' => _x( 'Portfolio Preview', 'Post type - Portfolio', SPECTRA_PLUGIN ),
			'portfolio_cats' => _x( 'Categories', 'Post type - Portfolio', SPECTRA_PLUGIN ),
			'date' => _x( 'Date', 'Post type - Portfolio', SPECTRA_PLUGIN )
		);

		return $columns;
	}

	add_action( 'manage_posts_custom_column', 'portfolio_display_columns' );

	function portfolio_display_columns( $column ) {

		global $post;
	
		switch ( $column ) {
			case 'portfolio_preview':
					if ( has_post_thumbnail( $post->ID ) ) {
						the_post_thumbnail( array( 60, 60 ) );
					}
				break;
			case 'portfolio_cats' :
				$genres = get_the_terms( $post->ID, 'spectra_portfolio_cats' );
				if ($genres) {
					foreach( $genres as $taxonomy ) {
						echo $taxonomy->name . ' ';
					}
				}
			break;
		}
	}


	/* COLUMN FILTER
	 ------------------------------------------------------------------------*/

	/* Add Filter */
	add_action('restrict_manage_posts', 'add_spectra_category_filter');

	function add_spectra_category_filter() {

		global $typenow, $spectra_portfolio;

		if ( $typenow == 'spectra_portfolio' ) {
			$args = array( 'name' => 'spectra_portfolio_cats' );
			$filters = get_taxonomies( $args );
			
			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				
				echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . _x( 'All Categories', 'Post type - Portfolio', SPECTRA_PLUGIN ) . '</option>';
				$spectra_portfolio->generate_taxonomy_options( $tax_slug, 0, 0 );
				echo "</select>";
			}
		}
	}

	/* Request Filter */
	add_action('request', 'spectra_category_filter');

	function spectra_category_filter( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'spectra_portfolio' && isset( $request['spectra_portfolio_cats'] ) ) {
			
		  	$term = get_term( $request['spectra_portfolio_cats'], 'spectra_portfolio_cats' );
			if ( isset( $term->name ) && $term) {
				$term = $term->name;
				$request['term'] = $term;
			}
			
		}
		return $request;
	}

}

add_action( 'init', 'spectra_portfolio_post_type', 0 );
endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	EVENTS

	Create a Custom Post type for managing events.
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'spectra_events_post_type' ) ) :

function spectra_events_post_type() {

	global $spectra_events, $pagenow, $current_date;

	/* Class arguments */
	$args = array( 
		'post_name' => 'spectra_events', 
		'sortable' => false,
		'admin_path'  => plugin_dir_url( __FILE__ ),
		'admin_url'	 => plugin_dir_path( __FILE__ ),
		'admin_dir' => '',
		'textdomain' => SPECTRA_PLUGIN
	);

	/* Post Labels */
	$labels = array(
		'name' => _x( 'Events', 'Post type - Events', SPECTRA_PLUGIN ),
		'singular_name' => _x( 'Events', 'Post type - Events', SPECTRA_PLUGIN ),
		'add_new' => _x( 'Add New', 'Post type - Events', SPECTRA_PLUGIN ),
		'add_new_item' => _x( 'Add New Event', 'Post type - Events', SPECTRA_PLUGIN ),
		'edit_item' => _x( 'Edit Event', 'Post type - Events', SPECTRA_PLUGIN ),
		'new_item' => _x( 'New Event', 'Post type - Events', SPECTRA_PLUGIN ),
		'view_item' => _x( 'View Event', 'Post type - Events', SPECTRA_PLUGIN ),
		'search_items' => _x( 'Search Items', 'Post type - Events', SPECTRA_PLUGIN ),
		'not_found' =>  _x( 'No slider events found', 'Post type - Events', SPECTRA_PLUGIN ),
		'not_found_in_trash' => _x( 'No events found in Trash', 'Post type - Events', SPECTRA_PLUGIN ), 
		'parent_item_colon' => ''
	);

	/* Post Options */
	$options = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => _x( 'events', 'SLUG', SPECTRA_PLUGIN ),
			'with_front' => false
		),
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields'),
		'menu_icon' => 'dashicons-calendar'
	);

	/* Add Taxonomy */
	register_taxonomy('spectra_event_type', array('spectra_events'), array(
		'hierarchical' => true,
		'label' => _x( 'Event Type', 'Post type - Events', SPECTRA_PLUGIN ),
		'singular_label' => _x( 'Event Type', 'Post type - Events', SPECTRA_PLUGIN ),
		'show_ui' => false,
		'query_var' => true,
		'capabilities' => array(
			'manage_terms' => 'manage_divisions',
			'edit_terms' => 'edit_divisions',
			'delete_terms' => 'delete_divisions',
			'assign_terms' => 'edit_posts'
		),
		'rewrite' => array('slug' => 'event-type'),
		'show_in_nav_menus' => false
	));

	/* Add Taxonomy */
	register_taxonomy( 'spectra_event_categories', array('spectra_events'), array(
		'hierarchical' => true,
		'label' => _x( 'Events Categories', 'Post type - Events', SPECTRA_PLUGIN ),
		'singular_label' => _x( 'Event Category', 'Post type - Events', SPECTRA_PLUGIN ),
		'query_var' => true,
		'rewrite' => array('slug' => _x( 'event-categories', 'SLUG', SPECTRA_PLUGIN ), )
	));

	/* Add class instance */
	if ( class_exists( 'R_Custom_Post' ) ) {
		$spectra_events = new R_Custom_Post( $args, $options );
	}

	/* Remove variables */
	unset( $args, $options );


	/*-------------------------------------------------------------------------------------*/


	/* Helpers Functions
	------------------------------------------------------------------------*/


	/* Insert default taxonomy
	 ------------------------------------------------------------------------*/
	function spectra_insert_taxonomy( $cat_name, $parent, $description, $taxonomy ) {
		global $wpdb;

		if ( ! term_exists( $cat_name, $taxonomy ) ) {
			$args = compact(
				$cat_name = esc_sql( $cat_name ),
				$cat_slug = sanitize_title( $cat_name ),
				$parent = 0,
				$description = ''
			);
			wp_insert_term( $cat_name, $taxonomy, $args );
			return;
		}
	  return;
	}


	/* Get Taxonomy ID
	 ------------------------------------------------------------------------*/
	function spectra_get_taxonomy_id( $cat_name, $taxonomy ) {
		
		$args = array(
			'hide_empty' => false
		);
		
		$taxonomies = get_terms( $taxonomy, $args );
		if ( $taxonomies ) {
			foreach( $taxonomies as $taxonomy ) {
				
				if ( $taxonomy->name == $cat_name ) {
					return $taxonomy->term_id;
				}
				
			}
		}
		
		return false;
	}

	/* Days left
	 ------------------------------------------------------------------------*/
	function spectra_days_left( $start_date, $end_date, $type ) {
		global $current_date;
		
		$now = strtotime( $current_date );
		$start_date = strtotime( $start_date );
		$end_date = strtotime( $end_date );
		
		/* Days left to start date */
		$hours_left_start = ( mktime(0, 0, 0, date( 'm', $start_date ), date( 'd', $start_date ), date( 'Y', $start_date ) ) - $now ) / 3600;
		$days_left_start = ceil( $hours_left_start / 24 );
		
		/* Days left to end date */
		$hours_left_end = ( mktime( 0, 0, 0, date( 'm', $end_date ), date( 'd', $end_date ), date( 'Y', $end_date ) ) - $now ) / 3600;
		$days_left_end = ceil( $hours_left_end / 24 );
		$days_number = ( $days_left_end - $days_left_start ) + 1;
		
		if ( $type == 'days' ) {
			return $days_number;
		}
		
		if ( $type == 'days_left' ) {
			
			/* If future events */
			if ( $days_left_end >= 0 ) {
			
				if ( $days_left_start == 0 ) {
					return '<span style="color:red;font-weight:bold">'. _x( 'Start Today', 'Post type - Events', SPECTRA_PLUGIN ) .'</span>';
				}
				elseif ( $days_left_start < 0 ) {
					return '<span style="color:red;font-weight:bold">' . _x( 'Continued', 'Post type - Events', SPECTRA_PLUGIN ) . '</span>';
				}
				elseif ( $days_left_start > 0 ) {
					return $days_left_start;
				}
			
			} else return '-- --';
		}
		
	}


	/* Settings
	------------------------------------------------------------------------*/
	$time_zone = 'local_time'; /* local_time, server_time, UTC */

	/* Timezone */
	$current_date = array();
	$current_date['local_time'] = date( 'Y-m-d', current_time( 'timestamp', 0 ) );
	$current_date['server_time'] = date( 'Y-m-d', current_time( 'timestamp', 1 ) );
	$current_date['UTC'] = date( 'Y-m-d' );
	$current_date = $current_date[ $time_zone ];

	/* Insert default taxonomy */
	if ( is_admin() ) {
		if ( ! term_exists( 'Future events', 'spectra_event_type' ) ) {
	    	spectra_insert_taxonomy( 'Future events', 0, '', 'spectra_event_type' );
		}
		if ( ! term_exists( 'Past events', 'spectra_event_type' ) ) {
	    	spectra_insert_taxonomy( 'Past events', 0, '', 'spectra_event_type' );
	    }
	}


	/* Column Layout
	------------------------------------------------------------------------*/
	add_filter( 'manage_edit-spectra_events_columns', 'spectra_events_columns' );

	function spectra_events_columns( $columns ) {
		global $current_date;
		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => _x( 'Event Title', 'Post type - Events', SPECTRA_PLUGIN ),
			'event_date' => _x( 'Event Date', 'Post type - Events', SPECTRA_PLUGIN ) . ' (' . $current_date . ')',
			'event_days' => _x( 'Days', 'Post type - Events', SPECTRA_PLUGIN ),
			'event_days_left' => _x( 'Days Left', 'Post type - Events', SPECTRA_PLUGIN ),
			'event_type' => _x( 'Event Type', 'Post type - Events', SPECTRA_PLUGIN ),
			'event_repeat' => _x( 'Event Repeat', 'Post type - Events', SPECTRA_PLUGIN ),
			'tax_events' => _x( 'Categories', 'Post type - Events', SPECTRA_PLUGIN ),
			'image_preview' => _x( 'Image Preview', 'Post type - Events', SPECTRA_PLUGIN )
		);

		return $columns;
	}

	add_action( 'manage_posts_custom_column', 'spectra_events_display_columns' );

	function spectra_events_display_columns( $column ) {
		global $post, $current_date;
		
		$today = strtotime( $current_date );
		
		switch ( $column ) {
			case 'event_date':
				$event_date_start = get_post_custom();
				$event_date_end = get_post_custom();
				echo $event_date_start['_event_date_start'][0] . ' - ' . $event_date_end['_event_date_end'][0];
			break;
			case 'event_days' :
				$event_date_start = get_post_custom();
				$event_date_end = get_post_custom();
				echo spectra_days_left( $event_date_start['_event_date_start'][0], $event_date_end['_event_date_end'][0], 'days' );
			break;
			case 'event_days_left' :
				$event_date_start = get_post_custom();
				$event_date_end = get_post_custom();
				echo spectra_days_left( $event_date_start['_event_date_start'][0], $event_date_end['_event_date_end'][0], 'days_left' );
			break;
			case 'event_type' :
					$taxonomies = get_the_terms( $post->ID, 'spectra_event_type' );
					$event_date_end = get_post_custom();
					if ( $taxonomies ) {
						foreach( $taxonomies as $taxonomy ) {
							if ( strtotime( $event_date_end['_event_date_end'][0] ) >= $today && $taxonomy->name == 'Future events' ) 
							    echo '<strong>' . $taxonomy->name . '</strong>';
							else 
							    echo $taxonomy->name;
						}
					}
			break;
			case 'event_repeat' :
					$custom = get_post_custom();
					if ( isset( $custom['_repeat_event'][0]) && $custom['_repeat_event'][0] != 'none' )
						echo ucfirst( $custom['_repeat_event'][0] );
					
			break;
			case 'tax_events' :
				$taxonomies = get_the_terms( $post->ID, 'spectra_event_categories' );
					if ( $taxonomies ) {
						foreach ( $taxonomies as $taxonomy ) {
							echo $taxonomy->name . ' ';
						}
					}
				break;
			case 'image_preview':
				if ( has_post_thumbnail( $post->ID ) ) {
					the_post_thumbnail( array( 60, 60 ) );
				}
			break;
		}
	}


	/* Menage Events
	------------------------------------------------------------------------*/
	function manage_events() {
		global $post, $current_date;
		
		$backup = $post;
		$today = strtotime( $current_date );
		$args = array(
			'post_type'     => 'spectra_events',
			'spectra_event_type' => 'Future events',
			'post_status'   => 'publish, pending, draft, future, private, trash',
			'numberposts'   => '-1',
			'orderby'       => 'meta_value',  
			'meta_key'      => '_event_date_end',
			'order'         => 'ASC',
		  	'meta_query' 	 => array(array('key' => '_event_date_end', 'value' => date('Y-m-d'), 'compare' => '<', 'type' => 'DATE')),
		  );
		$events = get_posts( $args );
		
	 	foreach( $events as $event ) {
			
			$event_date_start = get_post_meta( $event->ID, '_event_date_start', true );
			$event_date_end = get_post_meta( $event->ID, '_event_date_end', true );
			$repeat = get_post_meta( $event->ID, '_repeat_event', true );
			
			/* Move Events */

			// If is set repeat event
			if ( isset( $repeat ) && $repeat != 'none' ) {

				// Weekly
				if ( $repeat == 'weekly' ) {
					$every = get_post_meta( $event->ID, '_every', true );
					$weekly_days = get_post_meta( $event->ID, '_weekly_days', true );

					// Event length
					$start_date = strtotime( $event_date_start );
					$end_date = strtotime( $event_date_end );
					$date_diff = $end_date - $start_date;
					$event_length = floor( $date_diff / (60*60*24) );

					unset( $start_date, $end_date, $date_diff );
					//echo "Differernce is $event_length days";

					// Make dates array
					$weekly_dates  = array();
					$weekly_days_a = array();
					foreach ( $weekly_days as $key => $day ) {
						$start_date = strtotime( "+$every week $day $event_date_start" );
						$date_diff = $start_date - $today;
						$days = floor( $date_diff / (60*60*24) );
						$start_date = date( 'Y-m-d', $start_date );
						$end_date = strtotime( "+$event_length day $start_date" );
						$end_date = date( 'Y-m-d', $end_date );
						$weekly_dates[$key]['day'] = $day;
						$weekly_dates[$key]['days'] = $days;
						$weekly_dates[$key]['start_date'] = $start_date;
						$weekly_dates[$key]['end_date'] = $end_date;
						$weekly_days_a[] = $days;
					}
					// Next event date
					$ne = array_search( min( $weekly_days_a ), $weekly_days_a );
					//print_r($ne);

					// Update event date
					update_post_meta( $event->ID, '_event_date_start', $weekly_dates[$ne]['start_date'] );
					update_post_meta( $event->ID, '_event_date_end', $weekly_dates[$ne]['end_date'] );

				}
			} else {
				wp_set_post_terms( $event->ID, spectra_get_taxonomy_id( 'Past events', 'spectra_event_type' ), 'spectra_event_type', false );
			}
		}
		$post = $backup; 
		wp_reset_query();
	}


	/* Shelude Events
	 ------------------------------------------------------------------------*/
	if ( false === ( $event_task = get_transient( 'event_task' ) ) ) {
	    $current_time = time();
		manage_events();
		set_transient( 'event_task', $current_time, 60*60 );
	}
	//delete_transient('event_task');


	/* Save Events
	 ------------------------------------------------------------------------*/
	function save_postdata_events() {
	   	global $current_date;
		
		if ( isset( $_POST['post_ID'] ) ) {
			$post_id = $_POST['post_ID'];
		} else {
			return; 
		}

		// Inline editor
	 	if ( $_POST['action'] == 'inline-save' ) {
	 		return;
	 	}

	    if ( isset( $_POST['post_type'] ) && $_POST['post_type'] == 'spectra_events' ) {
				
	        $today = strtotime( $current_date );
		    $event_date_start = strtotime( get_post_meta( $post_id, '_event_date_start', true ) );
		   
		    $event_date_end = strtotime( get_post_meta( $post_id, '_event_date_end', true ) );
			
	        /* Add Default Date */
		    if ( ! $event_date_start ) {
		  	    add_post_meta( $post_id, '_event_date_start', date( 'Y-m-d', $today) );
		    }
		    if ( ! $event_date_end ) {
			    add_post_meta( $post_id, '_event_date_end', get_post_meta( $post_id, '_event_date_start', true ) );
		    }
		    if ( $event_date_end < $event_date_start ) {
			    update_post_meta( $post_id, '_event_date_end', get_post_meta( $post_id, '_event_date_start', true ) );
		    }
			
			$event_date_start = strtotime( get_post_meta($post_id, '_event_date_start', true ) );
		    $event_date_end = strtotime( get_post_meta($post_id, '_event_date_end', true ) );
			
			/* Add Default Term */
			$taxonomies = get_the_terms( $post_id, 'spectra_event_type' );
			if ( ! $taxonomies ) {
				wp_set_post_terms( $post_id, spectra_get_taxonomy_id( 'Future events', 'spectra_event_type' ), 'spectra_event_type', false );	
			}
		    if ( $event_date_end >= $today ) {
		  	    if ( is_object_in_term( $post_id, 'spectra_event_type', 'Past events' ) )
		        wp_set_post_terms( $post_id, spectra_get_taxonomy_id( 'Future events', 'spectra_event_type' ), 'spectra_event_type', false );	
		    } else {	
		        if ( is_object_in_term( $post_id, 'spectra_event_type', 'Future events' ) )
			    wp_set_post_terms( $post_id, spectra_get_taxonomy_id( 'Past events', 'spectra_event_type' ), 'spectra_event_type', false );
		    }
			
	    }
		
	}
	add_action( 'wp_insert_post', 'save_postdata_events' );


	/* Custom order
	 ------------------------------------------------------------------------*/
	function events_manager_order( $query ) {
		
		if ( is_admin() && isset( $query->query['post_type'] ) ) {
		    $post_type = $query->query['post_type'];
	    	if ($post_type == 'spectra_events') {
			   	$events_order = '_event_date_start';
				$query->query_vars['meta_key'] = $events_order;
				$query->query_vars['orderby'] = 'meta_value';
				$query->query_vars['order'] = 'asc';
				$query->query_vars['meta_query'] = array( array( 'key' => $events_order, 'value' => '1900-01-01', 'compare' => '>', 'type' => 'NUMERIC') );
	    	}
	  	}
	}
	add_filter( 'pre_get_posts', 'events_manager_order' );


	/* Event Type Filter
	------------------------------------------------------------------------*/
	function add_events_filter() {

	    global $typenow, $spectra_events;

	    if ($typenow == 'spectra_events') {
	        $args = array( 'name' => 'spectra_event_type' );
	        $filters = get_taxonomies( $args );

	        foreach ( $filters as $tax_slug ) {
	            $tax_obj = get_taxonomy( $tax_slug );
	            $tax_name = $tax_obj->labels->name;

	            echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . _x( 'All Types', 'Post type - Events', SPECTRA_PLUGIN ) . '</option>';
	            $spectra_events->generate_taxonomy_options( $tax_slug, 0, 0);
	            echo "</select>";
	        }
	    }
	}
	add_action('restrict_manage_posts', 'add_events_filter');

	/* Add Filter - Request */
	add_action('request', 'events_request');

	function events_request( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'spectra_events' && isset( $request['spectra_event_type'] ) ) {
			$term = get_term( $request['spectra_event_type'], 'spectra_event_type' );
			if ( isset( $term->name ) && $term ) {
				$term = $term->name;
				$request['term'] = $term;
			}
		}
		return $request;
	}


	/* Event Catory Filter
	------------------------------------------------------------------------*/
	function add_event_tax_filter() {

	    global $typenow, $spectra_events;

	    if ( $typenow == 'spectra_events' ) {
	       	$args = array( 'name' => 'spectra_event_categories' );
			$filters = get_taxonomies( $args );
			
			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				
				echo '<select name="' . $tax_slug. '" id="' . $tax_slug . '" class="postform">';
				echo '<option value="">' . _x( 'All Categories', 'Post type - Events', SPECTRA_PLUGIN ) . '</option>';
				$spectra_events->generate_taxonomy_options( $tax_slug, 0, 0);
				echo "</select>";
			}
	    }
	}
	add_action( 'restrict_manage_posts', 'add_event_tax_filter' );

	/* Add Filter - Request */
	function event_tax_request( $request ) {
		if ( is_admin() && isset( $request['post_type'] ) && $request['post_type'] == 'spectra_events' && isset( $request['spectra_event_categories'] ) ) {
			
		   $term = get_term( $request['spectra_event_categories'], 'spectra_event_categories' );
			if ( isset( $term->name ) && $term ) {
				$term = $term->name;
				$request['term'] = $term;
			}
			
		}
		return $request;
	}
	add_action( 'request', 'event_tax_request' );

}

add_action( 'init', 'spectra_events_post_type', 0 );
endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	SLIDER

	Create a Custom Post type for managing Slides.
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'spectra_slider_post_type' ) ) :

function spectra_slider_post_type() {

	/* Class arguments */
	$args = array( 
		'post_name' => 'spectra_slider', 
		'sortable' => false,
		'admin_path'  => plugin_dir_url( __FILE__ ),
		'admin_url'	 => plugin_dir_path( __FILE__ ),
		'admin_dir' => '',
		'textdomain' => SPECTRA_PLUGIN
	);

	/* Post Labels */
	$labels = array(
		'name' => _x( 'Slider', 'Post type - Slider', SPECTRA_PLUGIN ),
		'singular_name' => _x( 'Slider', 'Post type - Slider', SPECTRA_PLUGIN ),
		'add_new' => _x( 'Add New', 'Post type - Slider', SPECTRA_PLUGIN ),
		'add_new_item' => _x( 'Add New Slider Item', 'Post type - Slider', SPECTRA_PLUGIN ),
		'edit_item' => _x( 'Edit Slider Item', 'Post type - Slider', SPECTRA_PLUGIN ),
		'new_item' => _x( 'New Slider Item', 'Post type - Slider', SPECTRA_PLUGIN ),
		'view_item' => _x( 'View Slider Item', 'Post type - Slider', SPECTRA_PLUGIN ),
		'search_items' => _x( 'Search Items', 'Post type - Slider', SPECTRA_PLUGIN ),
		'not_found' =>  _x( 'No slider items found', 'Post type - Slider', SPECTRA_PLUGIN ),
		'not_found_in_trash' => _x( 'No slider items found in Trash', 'Post type - Slider', SPECTRA_PLUGIN ), 
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
			'slug' => _x( 'sliders', 'SLUG', SPECTRA_PLUGIN ),
			'with_front' => false
		),
		'supports' => array('title', 'editor'),
		'menu_icon' => 'dashicons-slides'
	);

	/* Add class instance */
	if ( class_exists( 'R_Custom_Post' ) ) {
		$spectra_slider = new R_Custom_Post( $args, $options );
	}

	/* Remove variables */
	unset( $args, $options );


	/* COLUMN LAYOUT
	 ---------------------------------------------------------------------- */
	add_filter( 'manage_edit-spectra_slider_columns', 'slider_columns' );

	function slider_columns( $columns ) {
		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => _x( 'Title', 'Post type - Slider', SPECTRA_PLUGIN ),
			'slider_id' => _x( 'Slider ID', 'Post type - Slider', SPECTRA_PLUGIN ),
			'date' => _x( 'Date', 'Post type - Slider', SPECTRA_PLUGIN )
		);

		return $columns;
	}

	add_action( 'manage_posts_custom_column', 'slider_display_columns' );

	function slider_display_columns( $column ) {

		global $post;
		
		switch ($column) {
			case 'slider_id':
			    the_ID();
			
			break;
		}
	}
}

add_action( 'init', 'spectra_slider_post_type', 0 );
endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	GALLERY

	Create a Custom Post type for managing gallery.
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'spectra_gallery_post_type' ) ) :

function spectra_gallery_post_type() {

	/* Class arguments */
	$args = array( 
		'post_name' => 'spectra_gallery', 
		'sortable' => false,
		'admin_path'  => plugin_dir_url( __FILE__ ),
		'admin_url'	 => plugin_dir_path( __FILE__ ),
		'admin_dir' => '',
		'textdomain' => SPECTRA_PLUGIN
	);

	/* Post Labels */
	$labels = array(
		'name' => _x( 'Gallery', 'Post type - Gallery', SPECTRA_PLUGIN ),
		'singular_name' => _x( 'Gallery', 'Post type - Gallery', SPECTRA_PLUGIN ),
		'add_new' => _x( 'Add New', 'Post type - Gallery', SPECTRA_PLUGIN ),
		'add_new_item' => _x( 'Add New Gallery Album', 'Post type - Gallery', SPECTRA_PLUGIN ),
		'edit_item' => _x( 'Edit Gallery Album', 'Post type - Gallery', SPECTRA_PLUGIN ),
		'new_item' => _x( 'New Gallery Album', 'Post type - Gallery', SPECTRA_PLUGIN ),
		'view_item' => _x( 'View Gallery Album', 'Post type - Gallery', SPECTRA_PLUGIN ),
		'search_items' => _x( 'Search Items', 'Post type - Gallery', SPECTRA_PLUGIN ),
		'not_found' =>  _x( 'No gallery albums found', 'Post type - Gallery', SPECTRA_PLUGIN ),
		'not_found_in_trash' => _x( 'No gallery albums found in Trash', 'Post type - Gallery', SPECTRA_PLUGIN ), 
		'parent_item_colon' => ''
	);

	/* Post Options */
	$options = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'capability_type' => 'post',
		'query_var' => true,
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => _x( 'photos', 'SLUG', SPECTRA_PLUGIN ),
			'with_front' => false
		),
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields'),
		'menu_icon' => 'dashicons-camera'
	);

	/* Add class instance */
	if ( class_exists( 'R_Custom_Post' ) ) {
		$spectra_gallery = new R_Custom_Post( $args, $options );
	}

	/* Remove variables */
	unset( $args, $options );


	/* COLUMN LAYOUT
	 ---------------------------------------------------------------------- */
	add_filter( 'manage_edit-spectra_gallery_columns', 'gallery_columns' );

	function gallery_columns( $columns ) {
		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => _x( 'Title', 'Post type - Gallery', SPECTRA_PLUGIN ),
			'gallery_preview' => _x( 'Album Cover', 'Post type - Gallery', SPECTRA_PLUGIN ),
			'gallery_id' => _x( 'Gallery ID', 'Post type - Gallery', SPECTRA_PLUGIN ),
			'date' => _x( 'Date', 'Post type - Gallery', SPECTRA_PLUGIN )
		);

		return $columns;
	}

	add_action( 'manage_posts_custom_column', 'gallery_display_columns' );

	function gallery_display_columns( $column ) {

		global $post;
		
		switch ($column) {
			case 'gallery_preview':
				if ( has_post_thumbnail( $post->ID ) ) {
					the_post_thumbnail( array( 60, 60 ) );
				}
				break;
			case 'gallery_id':
			    the_ID();
			
			break;
		}
	}
}

add_action( 'init', 'spectra_gallery_post_type', 0 );

/* Pagination fix */
function spectra_gallery_disable_canonical_redirect( $query ) {
	
    if ( ! is_home() && ! is_404() && isset( $query->query_vars['post_type'] ) && 'spectra_gallery' == $query->query_vars['post_type'] ) {
        remove_filter( 'template_redirect', 'redirect_canonical' );
    }

}
add_action( 'parse_query', 'spectra_gallery_disable_canonical_redirect' );
endif; // End check for function_exists()