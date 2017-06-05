<?php
/**
 * Muttley Framework
 *
 * @package     MuttleyBox
 * @subpackage  select_image
 * @author      Mariusz Rek
 * @version     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MuttleyBox_select_image' ) ) {

	class MuttleyBox_select_image extends MuttleyBox {

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

			if ( isset( self::$_saved_options[self::$_option['id']] ) ) {
				self::$_option['std'] = self::$_saved_options[self::$_option['id']];
			}
			
			if ( isset( self::$_option['group'] ) && self::$_option['group'] != '' ) {
				$group_class = 'select-group';
				$group_id = self::$_option['group'];
			} else {
				$group_class = '';
				$group_id = '';
			}
			
			echo '<div class="box-row clearfix">';
			if ( isset( self::$_option['name'] ) && ( self::$_option['name'] != '' ) ) {	
				echo '<label for="' . self::$_option['id'] . '" >' . self::$_option['name'] . '</label>';
			}

			echo '<input type="hidden" name="' . self::$_option['id'] . '" id="' . self::$_option['id'] . '" value="' . self::$_option['std'] . '" class="select-image-input"/>';

			echo '<ul data-main-group="main-group-' . $group_id . '" class="select-image ' . $group_class . '">';
			
			foreach( self::$_option['images'] as $image ) {
				
				if ( self::$_option['std'] == $image['id'] ) 
					$selected = 'class="selected-image"';
				else 
					$selected = '';
				echo '<li><img src="' . $image['image'] . '" alt="' . $image['image'] . '" data-image_id="' . $image['id'] . '" ' . $selected . ' /></li>';
			}
			
			echo '</ul>';
			echo '<div class="clear"></div>';
			echo '<div class="help-box">';
			$this->e_esc( self::$_option['desc'] );
			echo '</div>';
			echo '</div>';


			
		

		}
	}
}