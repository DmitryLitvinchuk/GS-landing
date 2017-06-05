<?php

/**
 * Muttley Framework
 * A simple, Wordpress Metabox Framework
 *
 * @package         MuttleyBox
 * @author          Mariusz Rek
 * @copyright       2015 Muttley Framework
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
    die;
}

if ( ! class_exists( 'MuttleyBox' ) ) {

	global $muttley_box_fired;

	$muttley_box_fired = true;

	class MuttleyBox {
		
		protected $options;
		protected $args = array();
		protected $extensions = array();
		protected $box;
		protected $admin_path;
		protected $admin_uri;
		protected $textdomain = 'muttleybox';
		

		/**
         * Panel Constructor.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
        */
		public function __construct( $options, $box ) {

			global $muttley_box_fired;

	 		/* Set options */
			$this->options = $options;
			$this->box = $box;

	    	/* Set paths */

			/* Set path */
			if ( $this->box['admin_path'] == '' ) {
				$_path = get_template_directory_uri();
			} else {
				$_path = $this->box['admin_path'];
			}
			$this->args[ 'admin_path' ] = $_path . $this->box['admin_dir'];

			/* Set URI path */
			if ( $this->box['admin_uri'] == '' ) {
				$_path_uri = get_template_directory();
			} else {
				$_path_uri = $this->box['admin_uri'];
			}
			$this->args['admin_uri'] = $_path_uri . $this->box['admin_dir'];

			/* --- Scripts --- */
			add_action( 'load-post.php', array( &$this, 'load_post' ) );
			add_action( 'load-post-new.php', array( &$this, 'load_post' ) );

			/* --- Class Actions --- */

			/* init */
			add_action( 'admin_menu', array( &$this, 'init' ) );

			/* Save post */
			add_action( 'save_post', array( &$this, 'save_postdata' ) );

			/* --- Functions --- */

			/* Resize function */
			if ( ! function_exists( 'mr_image_resize' ) ) {
				include_once( $this->args['admin_uri']. '/functions/mr-image-resize.php' );
			}

			/* --- Extensions --- */
			foreach ( $this->options as $option ) {

				// Extension Class Name
				$class_name = 'MuttleyBox_' . $option['type'];

				if ( ! method_exists( $this, $option['type'] ) ) {

					// Include Extensions
					$file = $option['type'] . '.php';
					if ( file_exists( $this->args['admin_uri'] . '/fields/' . $option['type'] . '/' . $file  ) ) {
						require_once( $this->args['admin_uri'] . '/fields/' . $option['type'] . '/' . $file );
						if ( class_exists( $class_name ) ) {
							$this->extensions[$option['type']] = new $class_name( $option, $this->args, $this->options );
						}
					}

				} 
			}

		}


		/**
         * Init Function.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
        */
		function init() {	
			$this->create();
		}


		/**
         * Load Post
         *
         * @since       1.0.0
         * @access      public
         * @return      void
        */
		function load_post() {
			global $post;

			/* Get screen object */
			$screen = get_current_screen();
			$page = false;

			/* Checking if a box is also to be displayed on the page */
			if ( in_array( 'page', $this->box['page'] ) )
				$page = true;

			if ( in_array( $screen->post_type, $this->box['page'] ) ) {

				/* Add scripts only on page */
				if ( $page ) {

					// If page exist
					if ( isset( $_GET['post'] ) ) 
						$template_name = get_post_meta( $_GET['post'], '_wp_page_template', true );
			        else 
			        	$template_name = '';

			        if ( $template_name == 'default' || $template_name == '' ) 
			        	$template_name = 'default';

			        // Display a box on the page with selected template
			        if ( in_array( $template_name, $this->box['template'] ) )
			        	$this->enqueue();
			        
				} else {
					$this->enqueue();
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
		private function enqueue() {

			global $muttley_box_fired;

			/* Thickbox */
		   	wp_enqueue_style('thickbox');
			wp_enqueue_script('thickbox');
			wp_enqueue_script('media-upload');

			/* Media */
			// wp_enqueue_media();

			/* UI */
			wp_enqueue_style( 'muttley_box_ui_css', $this->args[ 'admin_path' ] . '/assets/css/jquery-ui.css', false, '2013-11-01', 'screen' );

			/* Metabox stylesheet */
			wp_enqueue_style( 'muttley_box_css', $this->args[ 'admin_path' ] . '/assets/css/box.css', false, '2013-11-01', 'screen' );

			/* Metabox fonts */
			wp_enqueue_style( 'muttley_box_font', $this->args[ 'admin_path' ] . '/assets/css/font-awesome.css', false, '2013-11-01', 'screen' );

			/* Metabox javascripts */
			wp_enqueue_script( 'muttley_box_js', $this->args[ 'admin_path' ] . '/assets/js/fields.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-dialog', 'jquery-ui-widget', 'jquery-ui-sortable', 'jquery-ui-droppable', 'jquery-ui-slider', 'jquery-ui-draggable', 'jquery-ui-datepicker'), '2013-11-01', true );

		}


		/**
         * Create Function.
         * Create metabox
         *
         * @since       1.0.0
         * @access      public
         * @return      void
        */
		private function create() {
			if ( function_exists( 'add_meta_box' ) && is_array( $this->box['template'] ) ) {
				foreach ( $this->box['template'] as $template ) {
					if ( isset( $_GET['post'] ) ) $template_name = get_post_meta( $_GET['post'], '_wp_page_template', true );
			        else $template_name = '';
			
					if ( $template == 'default' && $template_name == '' ) $template_name = 'default';
					else if ($template == 'post') $template = '';
					
					if ( $template == $template_name ) {
						if ( is_array( $this->box['page'] ) ) {
							foreach ( $this->box['page'] as $area ) {	
								if ( $this->box['callback'] == '' ) $this->box['callback'] = 'display';
								
								add_meta_box ( 	
									$this->box['id'], 
									$this->box['title'],
									array( &$this, $this->box['callback'] ),
									$area, $this->box['context'], 
									$this->box['priority']
								);  
							}
						}  
					}
				}
			}
		}


		/**
         * Save Post Data Function.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
        */
		function save_postdata()  {

			if ( isset( $_POST['post_ID'] ) ) {
				
				if ( ! isset( $_POST['post_type'] ) ) {
					return;
				}

				$post_id = $_POST['post_ID'];
				
				foreach ( $this->options as $option ) {
					
					/* Verify */
					if ( isset( $_POST[$this->box['id'] . '_noncename'] ) && ! wp_verify_nonce( $_POST[$this->box['id'] . '_noncename'], plugin_basename(__FILE__) ) ) {	
						return $post_id;
					}
					
					if ( 'page' == $_POST['post_type'] ) {
						if ( ! current_user_can( 'edit_page', $post_id ) )
							return $post_id;
					} else {
						if ( ! current_user_can( 'edit_post', $post_id ) )
							return $post_id;
					}
					
					// For Array IDs
					if ( is_array( $option['id'] ) ) {
						foreach ( $option['id'] as $option_id ) {
							if ( isset( $_POST[ $option_id['id'] ] ) ) {
							    $data = $_POST[ $option_id['id'] ];

								if ( get_post_meta( $post_id , $option_id['id'] ) == '' )
									add_post_meta( $post_id, $option_id['id'], $data, true );
								
								elseif ( $data != get_post_meta( $post_id , $option_id['id'], true ) )
									update_post_meta( $post_id, $option_id['id'], $data );
								
								elseif ( $data == '' )
									delete_post_meta( $post_id , $option_id['id'], get_post_meta( $post_id , $option_id['id'], true ) );
						    }
						}
					} else {
						if ( isset( $_POST[ $option['id'] ] ) ) {
							$data = $_POST[ $option['id'] ];

							if ( get_post_meta( $post_id, $option['id']) == '' )
								add_post_meta( $post_id, $option['id'], $data, true );
							
							elseif ( $data != get_post_meta( $post_id, $option['id'], true ) )
								update_post_meta( $post_id, $option['id'], $data );
							
							elseif ( $data == '' )
								delete_post_meta( $post_id, $option['id'], true );
						}
					}
				}
			}
		}


		/**
         * Display Fields.
         *
         * @since       1.0.1
         * @access      public
         * @return      void
        */
		function display() {	
		
			global $post;
	        $count = 1;
			$css_class = '';
			$array_size = count( $this->options );

			foreach ( $this->options as $option ) {
					
				if ( is_array( $option['id'] ) ) {
					foreach ( $option['id'] as $i => $option_id ) {
						$meta_box_value = get_post_meta( $post->ID, $option_id['id'], true );
						if ( isset( $meta_box_value ) && $meta_box_value != '' ) $option['id'][$i]['std'] = $meta_box_value;
						if ( ! isset( $option_id['std'] ) ) $option['id'][$i]['std'] = '';
					}
					
			    } else {
					$meta_box_value = get_post_meta( $post->ID, $option['id'], true );
					if ( isset( $meta_box_value ) && $meta_box_value != '' ) $option['std'] = $meta_box_value;
					if ( !isset( $option['std'] ) ) $option['std'] = '';
			    }
				
				/* Groups */
				if ( isset( $option['group_name'] ) ) {
					$group = '';
					foreach ( $option['group_name'] as $group_value ) {

						// strip out all whitespace
						$group_value = preg_replace( '/\s/', '_', $group_value );

						// convert the string to all lowercase
						$group_value = strtolower( $group_value );
					    $group .= ' group-' . $group_value;
					}
					$group .= ' main-group-' . $option['main_group'];
					$style = 'style="display:none"';
				} else { 
					$group = '';
					$style = '';
				}
				
				echo '<div class="muttleybox ' . $group . '" ' . $style . '>';

				if ( method_exists( $this, $option['type'] ) ) {
					call_user_func( array( &$this, $option['type'] ), $option );
				} else {

					// Extensions
					$instance = $this->extensions[ $option['type'] ];
					$class_name = 'MuttleyBox_' . $option['type'];

					if ( is_object( $instance ) ) {
						if ( class_exists( $class_name ) && $instance instanceof $class_name ) {
							$o = new $instance( $option, $this->args, $this->options );
							$o->render();
						}
					}

				}


				echo '</div>';
				
				$count++;
				
			}
			
			/* Security field */
			echo'<input type="hidden" name="' . $this->box['id'] . '_noncename" id="' . $this->box['id'] . '_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';  

		}
		

		/* Helper Functions
		---------------------------------------------- */

		/* ESC
		---------------------------------------------- */
		public function esc( $option ) {

			if ( is_string( $option ) ) {
				$option = preg_replace( array('/<(\?|\%)\=?(php)?/', '/(\%|\?)>/'), array('',''), $option );
			}

			return $option;
		}


		/* ESC Echo
		---------------------------------------------- */
		public function e_esc( $option ) {

			if ( is_string( $option ) ) {
				$option = preg_replace( array('/<(\?|\%)\=?(php)?/', '/(\%|\?)>/'), array('',''), $option );
			}

			print $option;
		}


		/* Image exist
		---------------------------------------------- */
		public function get_image( $img ) {

			// Check image src or image ID
			if ( is_numeric( $img ) ) {
		    	$image_att = wp_get_attachment_image_src( $img, 'full' );
			   	if ( $image_att[0] )
			   		return $image_att[0];
			   	else 
			   		return false;
			}

			//define upload path & dir
		   	$upload_info = wp_upload_dir();
			$upload_dir = $upload_info['basedir'];
			$upload_url = $upload_info['baseurl'];

			// check if $img_url is local
			if( strpos( $img, $upload_url ) === false ) return false;

			//define path of image
			$rel_path = str_replace( $upload_url, '', $img);
			$img_path = $upload_dir . $rel_path;

			$image = @getimagesize( $img_path );
			if ( $image ) return $img;
			else return false;

		}


		/* Image resize
		---------------------------------------------- */
		public function img_resize( $width, $height, $src, $crop = 'c', $retina = false ) {

			$image = $this->get_image( $src );

			// If icon
		   	if ( strpos( $src, ".ico" ) !== false )
		   		return $src;

		   	// If image src exists
			if ( $image ) {
				if ( function_exists( 'mr_image_resize' ) )
					return mr_image_resize( $image, $width, $height, true, $crop, $retina );
				else 
					return $image;
			}
			return false;
		}


		/* Get image by URL
		---------------------------------------------- */
		public function get_image_by_url( $image_url, $size = 'thumbnail' ) {
		 	global $wpdb;

		    $attachment_query = $wpdb->prepare(
		        "
		        SELECT
		            {$wpdb->posts}.id
		        FROM 
		            {$wpdb->posts}
		        WHERE
		            {$wpdb->posts}.post_type = 'attachment'
		        AND
		            {$wpdb->posts}.guid = %s
		        ",
		        $image_url

		    );

			$attachment = $wpdb->get_results( $attachment_query, ARRAY_N );
		    
			if ( is_array( $attachment ) && ! empty( $attachment ) ) {
				$attachment_url = wp_get_attachment_image_src( $attachment[0][0], $size );
				return $attachment_url[0];
			} else {
				return false;
			}
		}

	} // end class

}