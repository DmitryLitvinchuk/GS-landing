<?php

/**
 * Muttley Framework
 *
 * @package     MuttleyBox
 * @subpackage  posts
 * @author      Mariusz Rek
 * @version     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MuttleyBox_posts' ) ) {

	class MuttleyBox_posts extends MuttleyBox {

		private static $_initialized = false;
		private static $_args;
		private static $_saved_options;
		private static $_option;


		/**
         * Field Constructor.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
        */
		public function __construct( $option, $args, $saved_options ) {

			// Variables
			self::$_args = $args;
			self::$_saved_options = $saved_options;
			self::$_option = $option;
			
			// Only for first instance
			if ( ! self::$_initialized ) {
	            self::$_initialized = true; 

	            // Multiple
	        	if ( isset( self::$_option['multiple'] ) && self::$_option['multiple'] ) {

	        		// Enqueue
					add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue' ) ); 
	        	}
	        }

		}


		/**
         * Enqueue Function.
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
        */
		public function enqueue() {

			$path = self::$_args['admin_path'];

			// Load script
			$handle = self::$_option['type'] . '.js';
			if ( ! wp_script_is( $handle, 'enqueued' ) ) {
				wp_enqueue_script( $handle, $path . '/fields/' . self::$_option['type'] . '/' . self::$_option['type'] . '.js', false, false, true );
			}

			// Load style
			$handle_css = self::$_option['type'] . '.css';
			if ( ! wp_style_is( $handle, 'enqueued' ) ) {
				wp_enqueue_style( $handle, $path . '/fields/' . self::$_option['type'] . '/' . self::$_option['type'] . '.css' );
			}
			
		}


		/**
         * Field Render Function.
         * Takes the vars and outputs the HTML
         *
         * @since 		1.0.0
         * @access  	public
        */
		public function render() {

			if ( isset( self::$_saved_options[self::$_option['id']] ) ) {
				self::$_option['std'] = self::$_saved_options[self::$_option['id']];
			}
		
			echo '<div class="box-row clearfix">';
			if ( isset( self::$_option['name'] ) && ( self::$_option['name'] != '' ) ) {	
				echo '<label for="' . self::$_option['id'] . '" >' . self::$_option['name'] . '</label>';
			}

			// Multiple or single
			if ( isset( self::$_option['multiple'] ) && self::$_option['multiple'] ) {
				echo '<select name="' . self::$_option['id'] . '[]" id="' . self::$_option['id'] . '" multiple="multiple" size="6"  class="multiselect">';
			} else {
				echo '<select name="' . self::$_option['id'] . '" id="' . self::$_option['id'] . '" size="1">';
			}

			if (isset( self::$_option['options'] ) ) {
				foreach ( self::$_option['options'] as $option ) {

					// Multiple or single
					if ( isset( self::$_option['multiple'] ) && self::$_option['multiple'] ) {
						if ( isset( self::$_option['std'] ) && in_array( $option['value'], self::$_option['std'] )) $selected = 'selected="selected"';
						else $selected = '';
					} else {
						if ( isset( self::$_option['std'] ) && self::$_option['std'] == $option['name'] ) $selected = 'selected="selected"';
						else $selected = '';
					}

					echo '<option ' . $selected . ' value="' . $option['value'] . '">' . $option['name'] . '</option>';
				}
			}
			
			if ( post_type_exists( self::$_option['post_type'] ) ) {

				$posts = get_posts( array('post_type' => self::$_option['post_type'], 'showposts' => -1 ) ); 
				if ( isset( $posts ) && is_array( $posts ) ) {
					foreach ( $posts as $post ) {

						// Multiple or single
						if ( isset( self::$_option['multiple'] ) && self::$_option['multiple'] ) {
							if ( in_array( $post->ID, self::$_option['std'] )) $selected = 'selected="selected"';
							else $selected = '';
						} else {
							if ( $post->ID == self::$_option['std'] ) $selected = 'selected="selected"';
							else $selected = '';
						}

						$option = '<option ' . $selected . ' value="' . $post->ID . '">';
						$option .= $post->post_title;
						$option .= '</option>';
						$this->e_esc( $option );
					}
				}
			}
			
			echo '</select>';
			echo '<div class="clear"></div>';
			echo '<div class="help-box">';
			$this->e_esc( self::$_option['desc'] );
			echo '</div>';
			echo '</div>';

		}

	}
}