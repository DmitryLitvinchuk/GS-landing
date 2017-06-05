<?php

/**
 * Plugin Name: Tracks Widget
 * Plugin URI: http://rascals.eu
 * Description: Display latest tweets from twitter.
 * Version: 1.0.0
 * Author: Rascals Themes
 * Author URI: http://rascals.eu
 */
 
class r_tracks_widget extends WP_Widget {

	/* Widget setup */ 
	function r_tracks_widget() {

		/* Widget settings */
		$widget_ops = array(
			'classname' => 'widget_r_tracks',
			'description' => _x( 'Display music tracks', 'Tracks Widget', SPECTRA_PLUGIN )
		);

		/* Widget control settings */
		$control_ops = array(
			'width' => 200,
			'height' => 200,
			'id_base' => 'r-tracks-widget'
		);
		
		/* Create the widget */
		if ( function_exists( 'spectra_tracklist' ) && function_exists( 'spectra_track' ) && function_exists( 'spectra_tracklist_grid' ) ) {
			parent::__construct( 'r-tracks-widget', _x( 'Tracks', 'Tracks Widget', SPECTRA_PLUGIN ), $widget_ops, $control_ops );
		}
		
	}

	/* Display the widget on the screen */ 
	function widget( $args, $instance ) {
		
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$tracks_id = $instance['tracks_id'];
		$type = ( $instance['type'] != '' ) ? $type = $instance['type'] : $type = 'single_track';
		$list_button = ( $instance['list_button'] != '' ) ? $list_button = '1' : $list_button = '0';
		$track_details = ( $instance['track_details'] != '' ) ? $track_details = '1' : $track_details = '0';
		$in_row = $instance['in_row'];
		
		echo $args['before_widget'];
		
		// Title
		if ( isset( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
		
		// Display tracks
	 	if ( $type == 'tracklist' ) {
			echo spectra_tracklist( $atts = array( 'id' => $tracks_id, 'style' => 'compact', 'track_action' => 'sp-play-track', 'list_button' => $list_button, 'list_button_action' => 'sp-play-list' ) );
		} else if ( $type == 'tracklist_grid' ) {
			echo spectra_tracklist_grid( $atts = array( 'id' => $tracks_id, 'track_action' => 'sp-play-track', 'list_button' => $list_button, 'list_button_action' => 'sp-play-list', 'in_row' => $in_row, 'track_meta' => $track_details ) );
		} else if ( $type == 'single_track' ) {
			echo spectra_track( $atts = array( 'id' => $tracks_id, 'style' => 'compact', 'track_action' => 'sp-play-track' ) );
		}

		echo $args['after_widget'];
		
	}

	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'tracks_id' ] = strip_tags( $new_instance[ 'tracks_id' ] );
		$instance[ 'type' ] = strip_tags( $new_instance[ 'type' ] );
		$instance[ 'list_button' ] = strip_tags( $new_instance[ 'list_button' ] );
		$instance[ 'in_row' ] = strip_tags( $new_instance[ 'in_row' ] );
		$instance[ 'track_details' ] = strip_tags( $new_instance[ 'track_details' ] );
		
		return $instance;
	}
	function form( $instance ) {
		global $wpdb;

		$defaults = array('title' => _x( 'Tracks', 'Tracks Widget', SPECTRA_PLUGIN ), 'tracks_id' => '', 'type' => 'single_track', 'list_button' => '', 'in_row' => '2', 'track_details' => '' );
		$instance = wp_parse_args( (array ) $instance, $defaults );
	      
		echo '<p>';
		echo '<label for="' . $this->get_field_id('title') . '">' . _x( 'Title:', 'Tracks Widget', SPECTRA_PLUGIN ) . '</label>';
		echo '<input id="' . $this->get_field_id('title') . '" type="text" name="' . $this->get_field_name('title') . '" value="' . $instance['title'] . '" class="widefat" />';
		echo '</p>';

		/* Get Audio Tracks  */
		$tracks = '';
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
	        echo '<p>';
			echo '<label for="' . $this->get_field_id('tracks_id') . '">' . _x( 'Select Tracks:', 'Tracks Widget', SPECTRA_PLUGIN ) . '</label>';
			echo '<select id="' . $this->get_field_id('tracks_id') . '" name="' . $this->get_field_name('tracks_id') . '" class="widefat">';
			foreach( $sql_tracks as $track_post ) {
	        	if ( $instance['tracks_id'] == $track_post->id ) {
	        		$selected = 'selected="selected"';
	        	} else {
	        		$selected = '';
	        	}
	            echo '<option ' . $selected . ' value="' . $track_post->id . '">' . $track_post->post_title . '</option>';
	        }
			echo '</select>';
			echo '</p>';
	    } else {
	    	echo _x( 'There are no tracks available.', 'Tracks Widget', SPECTRA_PLUGIN );
	    }

		// Type
		$options_type = array(
			array( 
				'value' => 'single_track', 
				'label' => 'Single track'
			), 
			array(
				'value' => 'tracklist', 
				'label' => 'Tracklist'
			),
			array(
				'value' => 'tracklist_grid', 
				'label' => 'Tracklist Grid'
			)
		);
		echo '<p>';
		echo '<label for="' . $this->get_field_id('type') . '">' . _x( 'Type:', 'Tracks Widget', SPECTRA_PLUGIN ) . '</label>';
		echo '<select id="' . $this->get_field_id('type') . '" name="' . $this->get_field_name('type') . '" class="widefat">';

		foreach( $options_type as $option ) {
				
			if ( $instance['type'] == $option['value'] ) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
				
     		echo '<option ' . $selected . ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
		}
		echo '</select>';
		echo '</p>';

		echo '<p>';
		if ( $instance[ 'list_button' ] ) {
			$checked = 'checked="checked"';
		} else {
			$checked = '';
		}
		echo '<input class="checkbox" type="checkbox" value="true" id="' . $this->get_field_id('list_button') . '" ' . $checked . ' name="' . $this->get_field_name('list_button') . '" />';
		echo '<label for="' . $this->get_field_id('list_button') . '"> ' . _x( 'Display list button', 'Tracks Widget', SPECTRA_PLUGIN ) . '</label>';
		echo '</p>';

		// Tracks per row
		$options_in_row = array(
			array( 
				'value' => '2', 
				'label' => '2'
			), 
			array(
				'value' => '3', 
				'label' => '3'
			),
			array(
				'value' => '4', 
				'label' => '4'
			),
			array(
				'value' => '5', 
				'label' => '5'
			)
		);
		echo '<h4>' . _x( 'Only for Tracklist Grid:', 'Tracks Widget', SPECTRA_PLUGIN ) . '</h4>';
		echo '<p>';
		echo '<label for="' . $this->get_field_id('in_row') . '">' . _x( 'Tracks Per Row:', 'Tracks Widget', SPECTRA_PLUGIN ) . '</label>';
		echo '<select id="' . $this->get_field_id('in_row') . '" name="' . $this->get_field_name('in_row') . '" class="widefat">';

		foreach( $options_in_row as $option ) {
				
			if ( $instance['in_row'] == $option['value'] ) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
				
     		echo '<option ' . $selected . ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
		}
		echo '</select>';
		echo '</p>';

		echo '<p>';
		if ( $instance[ 'track_details' ] ) {
			$checked = 'checked="checked"';
		} else {
			$checked = '';
		}
		echo '<input class="checkbox" type="checkbox" value="true" id="' . $this->get_field_id('track_details') . '" ' . $checked . ' name="' . $this->get_field_name('track_details') . '" />';
		echo '<label for="' . $this->get_field_id('track_details') . '"> ' . _x( 'Display track details', 'Tracks Widget', SPECTRA_PLUGIN ) . '</label>';
		echo '</p>';

	}
	
}

add_action( 'widgets_init', 'register_r_tracks_widget' );
function register_r_tracks_widget() {
    register_widget('r_tracks_widget');
}

?>