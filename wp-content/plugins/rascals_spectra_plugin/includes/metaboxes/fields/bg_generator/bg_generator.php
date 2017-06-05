<?php
/**
 * Muttley Framework
 *
 * @package     MuttleyBox
 * @subpackage  bg_generator
 * @author      Mariusz Rek
 * @version     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MuttleyBox_bg_generator' ) ) {

	class MuttleyBox_bg_generator extends MuttleyBox {

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

	            // Ajax
	            add_action( 'wp_ajax_easy_link_ajax', array( &$this, 'easy_link_ajax' ) );            
	            
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
			
			// Admin Footer
			add_action( 'admin_footer', array( &$this, 'admin_footer' ) );

			wp_enqueue_script( 'wp-color-picker' );
	    	wp_enqueue_style( 'wp-color-picker' );

	    	$path = self::$_args['admin_path'];

			// Load script
			$handle = self::$_option['type'] . '.js';
			if ( ! wp_script_is( $handle, 'enqueued' ) ) {
				wp_enqueue_script( $handle, $path . '/fields/' . self::$_option['type'] . '/' . self::$_option['type'] . '.js', false, false, true );
			}
			
		}


		/**
         * Render HTML code in admin footer
         *
         * @since 		1.0.0
         * @access  	public
        */
		public function admin_footer() {
			$this->widget();
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
			echo '<div class="clear"></div>';
			if ( !isset( self::$_option['std'] ) || self::$_option['std'] == '' ) {
				$display_i = 'display:none;';
				$display_d = 'display:none;';
				$display_g = 'display:inline-block;';
			}
			else {
				$display_i = 'display:block;';
				$display_d = 'display:inline-block;';
				$display_g = 'display:none;';
			}
			echo '<div class="bg-generator-wrap" style="' . $display_i  . '" data-widget="#_' . self::$_option['type'] . '"><input type="text" id="' . self::$_option['id'] . '" name="' . self::$_option['id'] . '" class="bg-generator-input" value="' . stripslashes(self::$_option['std']) . '" /></div>';
			echo '<button class="_button generate-bg" style="' . $display_g . '"><i class="fa icon fa-magic"></i>' . _x('Generate Background', 'MuttleyBox Class', $this->textdomain ) . '</button>';
			
			echo '<button class="_button ui-button-delete delete-bg" style="' . $display_d . '"><i class="fa icon fa-trash-o"></i>' . _x('Remove', 'MuttleyBox Class', $this->textdomain ) . '</button>';
			
			echo '<div class="help-box">';
			$this->e_esc( self::$_option['desc'] );
			echo '</div>';
			echo '</div>';
			
		}


		/* Widget
		---------------------------------------------- */
		private function widget() {
		  
			echo '<div id="_' . self::$_option['type'] . '" style="display:none">';
		    echo '<input type="hidden" autofocus="autofocus" />';

			/* Backround type */
			echo '<div class="dialog-row">
			      <label for="bg-type">' . _x('Background Type', 'MuttleyBox Class', $this->textdomain ) . '</label>
			      <select name="bg_type" id="bg-type" size="1" class="bg-type">
				  <option value="empty"></option>
			      <option value="none">None</option>
				  <option value="color">Color</option>
				  <option value="image">Image</option>
				  </select>
		          <p class="help-box">' . _x('Select background type.', 'MuttleyBox Class', $this->textdomain ) . '</p>
				  </div>';
			
			/* Color */
			echo '
			<div class="color-group" style="display:none">
			<div class="dialog-row">
			<label for="bg-color">' . _x('Color', 'MuttleyBox Class', $this->textdomain ) . '</label>
			<label for="bg-color-transparent" class="checkbox-label">' . _x('Transparent: ', 'MuttleyBox Class', $this->textdomain ) . ' <input type="checkbox" id="bg-color-transparent" name="bg_color_transparent" value="" /></label>
			<div class="clear" style="margin-top:10px;"></div>
			<input type="text" id="bg-color" name="bg_color" value="#ffffff" class="colorpicker-input"/>
			<div class="clear"></div>
			<p class="help-box">' . _x('Select background color.', 'MuttleyBox Class', $this->textdomain ) . '</p>
			</div>
			</div>';
			
			/* File */
			$hidden_class = 'r-hidden';
			echo '
			<div class="dialog-row file-group" style="display:none">
			
			<div class="dialog-row">
			<label for="bg-file">' . _x('File URL ', 'MuttleyBox Class', $this->textdomain ) . '</label>
			<input type="text" id="bg-file" name="bg_file" value="http://" class="image-input" onBlur="if (this.value == \'\') this.value = \'http://\'" onFocus="if (this.value == \'http://\') this.value = \'\';"/>
			<p class="help-box">' . _x('Enter image URL for your background.', 'MuttleyBox Class', $this->textdomain ) . '</p>
			</div>
			<div class="dialog-row">
			<label for="bg-pos">' . _x('Position', 'MuttleyBox Class', $this->textdomain ) . '</label>
			      <select name="bg_pos" id="bg-pos" size="1" class="bg-pos">
			      <option value="left top">left top</option>
				  <option value="left center">left center</option>
				  <option value="left bottom">left bottom</option>
				  <option value="right top">right top</option>
				  <option value="right center">right center</option>
				  <option value="right bottom">right bottom</option>
				  <option value="center top">center top</option>
				  <option value="center center">center center</option>
				  <option value="center bottom">center bottom</option>
				  <option value="custom">custom position</option>
				  </select>
		          <p class="help-box">' . _x('The first value is the horizontal position and the second value is the vertical. The top left corner is 0 0. Units can be pixels (0px 0px) or any other CSS units. If you specify only one value, the other value will be 50%. You can mix % and positions', 'MuttleyBox Class', $this->textdomain ) . '</p>
			</div>
			
			<div class="dialog-row custom-pos-group" style="display:none">
			<label for="bg-custom-pos">' . _x('Custom', 'MuttleyBox Class', $this->textdomain ) . '</label>
			<input type="text" id="bg-custom-pos" name="bg_custom_pos" value="50% 50%" class="image-input"/>
			</div>
			
			<div class="dialog-row">
			<label for="bg-repeat">' . _x('Repeat', 'MuttleyBox Class', $this->textdomain ) . '</label>
			      <select name="bg_repeat" id="bg-repeat" size="1" class="bg-repeat">
			      <option value="repeat">repeat</option>
				  <option value="repeat-x">repeat-x</option>
				  <option value="repeat-y">repeat-y</option>
				  <option value="no-repeat">no-repeat</option>
				  </select>
		          <p class="help-box">' . _x('The background-repeat property sets if/how a background image will be repeated.', 'MuttleyBox Class', $this->textdomain ) . '</p>
			</div>
			
			<div class="dialog-row">
			<label for="bg-att">' . _x('Attachment', 'MuttleyBox Class', $this->textdomain ) . '</label>
			      <select name="bg_attt" id="bg-att" size="1" class="bg-att">
			      <option value="scroll">scroll</option>
				  <option value="fixed">fixed</option>
				  </select>
		          <p class="help-box">' . _x('The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.', 'MuttleyBox Class', $this->textdomain ) . '</p>
			</div>
			
			
			</div>';
			
		    echo '</div>';

		}


	}
}