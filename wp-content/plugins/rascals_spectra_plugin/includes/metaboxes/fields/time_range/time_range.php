<?php
/**
 * Muttley Framework
 *
 * @package     MuttleyBox
 * @subpackage  time_range
 * @author      Mariusz Rek
 * @version     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MuttleyBox_time_range' ) ) {

	class MuttleyBox_time_range extends MuttleyBox {

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
			
			echo '<div class="box-row clearfix">';
			if ( isset( self::$_option['name'] ) && ( self::$_option['name'] != '' ) ) {	
				echo '<label for="' . self::$_option['id'][0]['id'] . '" >' . self::$_option['name'] . '</label>';
			}
			echo '<div class="time-range-wrap">';
			// Start
			echo '<div class="input-group time-range-start">';
			echo '<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>';
			echo '<input name="' . self::$_option['id'][0]['id'] . '" id="' . self::$_option['id'][0]['id'] . '" type="text" value="' . htmlspecialchars( self::$_option['id'][0]['std'] ) . '" class="timepicker-input"/>';
			echo '</div>';
			// End
			echo '<div class="input-group time-range-end">';
			echo '<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>';
			echo '<input name="' . self::$_option['id'][1]['id'] . '" id="' . self::$_option['id'][1]['id'] . '" type="text" value="' . htmlspecialchars( self::$_option['id'][1]['std'] ) . '" class="timepicker-input"/>';
			echo '</div>';
			echo '</div>';
			echo '<div class="help-box">';
			$this->e_esc( self::$_option['desc'] );
			echo '</div>';
			echo '</div>';

		}

	}
}