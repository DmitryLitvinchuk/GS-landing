<?php
/**
 * Muttley Framework
 *
 * @package     MuttleyBox
 * @subpackage  video
 * @author      Mariusz Rek
 * @version     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MuttleyBox_video' ) ) {

	class MuttleyBox_video extends MuttleyBox {

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

	            // Enqueue
				add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue' ) );         
	            
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
			if ( isset( self::$_option['std'] ) && self::$_option['std'] != '' ) {

				echo '<div class="_video" data-type="' . self::$_option['video_type'] . '" data-id="' . self::$_option['std'] . '" data-width="' . self::$_option['video_width'] . '" data-height="' . self::$_option['video_height'] . '" data-align="left" data-params="' .  self::$_option['params'] . '" data-cover="" style="width:' . self::$_option['video_width'] . 'px;height:' . self::$_option['video_height'] . 'px;"></div>';
			}
			echo '<div class="video-wrap input-group">';
			echo '<span class="input-group-addon"><i class="fa fa-' . self::$_option['video_type'] . '-square"></i></span>';
			echo '<input name="' . self::$_option['id'] . '" id="' . self::$_option['id'] . '" type="text" value="' . htmlspecialchars( self::$_option['std'] ) . '" class="video-input"/>';
			echo '</div>';
			echo '<div class="help-box">';
			$this->e_esc( self::$_option['desc'] );
			echo '</div>';
			echo '</div>';
			
		}
	}
}