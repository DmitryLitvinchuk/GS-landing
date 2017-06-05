<?php

/**
 * Plugin Name: Events Widget
 * Plugin URI: http://rascals.eu
 * Description: Display latest tweets from twitter.
 * Version: 1.0.0
 * Author: Rascals Themes
 * Author URI: http://rascals.eu
 */
 
class r_events_widget extends WP_Widget {

	/* Widget setup */ 
	function r_events_widget() {

		/* Widget settings */
		$widget_ops = array(
			'classname' => 'widget_r_events',
			'description' => _x( 'Display events', 'Events Widget', SPECTRA_PLUGIN )
		);

		/* Widget control settings */
		$control_ops = array(
			'width' => 200,
			'height' => 200,
			'id_base' => 'r-events-widget'
		);
		
		/* Create the widget */
		if ( function_exists( 'spectra_events_table' ) ) {
			parent::__construct( 'r-events-widget', _x( 'Events', 'Events Widget', SPECTRA_PLUGIN ), $widget_ops, $control_ops );
		}
		
	}

	/* Display the widget on the screen */ 
	function widget( $args, $instance ) {
		
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$event_type = ( $instance['event_type'] != '' ) ? $event_type = $instance['event_type'] : $event_type = 'single_track';
		$limit = ( $instance['limit'] != '' ) ? $limit = $instance['limit'] : $limit = '40';
		
		echo $args['before_widget'];

		// Title
		if ( isset( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
		
		// Display events
		echo spectra_events_table( $atts = array( 'event_type' => $event_type, 'limit' => $limit ) );

		echo $args['after_widget'];

	}

	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'event_type' ] = strip_tags( $new_instance[ 'event_type' ] );
		$instance[ 'limit' ] = strip_tags( $new_instance[ 'limit' ] );		
		return $instance;
	}
	function form( $instance ) {
		global $wpdb;

		$defaults = array('title' => _x( 'Events', 'Events Widget', SPECTRA_PLUGIN ), 'event_type' => 'single_track', 'limit' => '40' );
		$instance = wp_parse_args( (array ) $instance, $defaults );
	      
		echo '<p>';
		echo '<label for="' . $this->get_field_id('title') . '">' . _x( 'Title:', 'Events Widget', SPECTRA_PLUGIN ) . '</label>';
		echo '<input id="' . $this->get_field_id('title') . '" type="text" name="' . $this->get_field_name('title') . '" value="' . $instance['title'] . '" class="widefat" />';
		echo '</p>';

		// Type
		$options_event_type = array(
			array( 
				'value' => 'future-events', 
				'label' => 'Future Events'
			), 
			array(
				'value' => 'past-events', 
				'label' => 'Past Events'
			)
		);
		echo '<p>';
		echo '<label for="' . $this->get_field_id('event_type') . '">' . _x( 'Type:', 'Events Widget', SPECTRA_PLUGIN ) . '</label>';
		echo '<select id="' . $this->get_field_id('event_type') . '" name="' . $this->get_field_name('event_type') . '" class="widefat">';

		foreach( $options_event_type as $option ) {
				
			if ( $instance['event_type'] == $option['value'] ) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
				
     		echo '<option ' . $selected . ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
		}
		echo '</select>';
		echo '</p>';

		// Limit
		echo '<p>';
		echo '<label for="' . $this->get_field_id('limit') . '">' . _x( 'Limit:', 'Events Widget', SPECTRA_PLUGIN ) . '</label>';
		echo '<input id="' . $this->get_field_id('limit') . '" type="text" name="' . $this->get_field_name('limit') . '" value="' . $instance['limit'] . '" class="widefat" />';
		echo '</p>';
	
	}
	
}

add_action( 'widgets_init', 'register_r_events_widget' );
function register_r_events_widget() {
    register_widget('r_events_widget');
}

?>