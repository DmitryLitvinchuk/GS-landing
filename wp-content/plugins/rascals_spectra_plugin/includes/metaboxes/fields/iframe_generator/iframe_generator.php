<?php
/**
 * Muttley Framework
 *
 * @package     MuttleyBox
 * @subpackage  iframe_generator
 * @author      Mariusz Rek
 * @version     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MuttleyBox_iframe_generator' ) ) {
	class MuttleyBox_iframe_generator extends MuttleyBox {

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
			
	      	if ( isset( self::$_option['std'] ) && self::$_option['std'] != '' ) {
	      		$display_i = 'display:block;';
				$display_g = 'display:none;';
				$display_d = 'display:inline-block;';
			} else { 
				$display_i = 'display:none;';
				$display_g = 'display:inline-block;';
				$display_d = 'display:none;';
			}

			echo '<div class="iframe-generator-wrap" style="' . $display_i . '" data-widget="#_' . self::$_option['type'] . '">';
			echo '<input type="text" id="' . self::$_option['id'] . '" name="' . self::$_option['id'] . '" class="iframe-generator-input" value="' . stripslashes( self::$_option['std'] ) . '" />';
			echo '</div>';

			echo '<button class="_button generate-iframe" style="' . $display_g . '"><i class="fa icon fa-magic"></i>' . _x('Generate Iframe', 'MuttleyBox Class', $this->textdomain ) . '</button>';
			
			echo '<button class="_button ui-button-delete delete-iframe" style="' . $display_d . '"><i class="fa icon fa-trash-o"></i>' . _x('Remove', 'MuttleyBox Class', $this->textdomain ) . '</button>';

			echo '<p class="msg msg-error" style="display:none;">' . _x( 'Error: Content does not contain the iframe.', 'MuttleyBox Class', $this->textdomain ) . '</p>';
			
			echo '<div class="help-box">';
			$this->e_esc( self::$_option['desc'] );
			echo '</div>';
			echo '</div>';
			
		}
		
		
		/* Widget
		---------------------------------------------- */
		private function widget() {
		  
			echo '<div id="_' . self::$_option['type'] . '" style="display:none" class="_iframe-generator">';
			echo '<input type="hidden" autofocus="autofocus" />';
			echo 
				'<div class="dialog-row">
				<label for="iframe-content">' . _x( 'Iframe Code', 'MuttleyBox Class', $this->textdomain ) . '
				</label>';
			echo '<textarea id="iframe-content" name="iframe_content"></textarea>';
			echo '<p class="help-box">' . _x( 'Paste Iframe code here..', 'MuttleyBox Class', $this->textdomain ) . '</p></div>';
			echo '</div>';

		}

	}
}