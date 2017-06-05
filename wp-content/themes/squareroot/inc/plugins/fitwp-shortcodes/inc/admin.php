<?php
class FITSC_Admin
{
	/**
	 * Constructor
	 *
	 * @return FITSC_Admin
	 */
	function __construct()
	{
		add_action( 'load-post.php', array( $this, 'init' ) );
		add_action( 'load-post-new.php', array( $this, 'init' ) );
	}

	/**
	 * Initialize
	 *
	 * @return void
	 */
	function init()
	{
		$screen = get_current_screen();

		// Supported post types, allow developers to add more
		$post_types = apply_filters( 'fitsc_post_types', array( 'post', 'page' ) );
		if ( !in_array( $screen->post_type, $post_types ) )
			return;

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ), 1 );
		add_action( 'media_buttons', array( $this, 'add_shortcode_button' ) );
		add_action( 'admin_footer', array( $this, 'modals' ) );
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * @return void
	 */
	function enqueue()
	{
		wp_enqueue_media();
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'fitsc-admin', FITSC_URL . 'css/admin.css' );

		wp_register_script( 'angularjs', 'http://ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js', '', '1.0.7', true );
		wp_enqueue_script( 'fitsc-app', FITSC_URL . 'js/app.js', array( 'angularjs', 'jquery', 'wp-color-picker' ), '', true );
		wp_enqueue_script( 'fitsc-admin', FITSC_URL . 'js/admin.js', array( 'jquery' ), '', true );

		$params = array();
		$params['mapControls'] = array();
		$controls = array(
			'zoom'        => __( 'Zoom', 'fitsc' ),
			'pan'         => __( 'Pan', 'fitsc' ),
			'scale'       => __( 'Scale', 'fitsc' ),
			'map_type'    => __( 'Map type', 'fitsc' ),
			'street_view' => __( 'Street view', 'fitsc' ),
			'rotate'      => __( 'Rotate', 'fitsc' ),
			'overview'    => __( 'Overview map', 'fitsc' ),
		);
		foreach ( $controls as $k => $v )
		{
			$params['mapControls'][] = array(
				'value'   => $k,
				'name'    => $v,
				'checked' => false,
			);
		}

		// Nonces
		$params['nonceGetModal'] = wp_create_nonce( 'get-modal' );
		$params['nonceGetIcons'] = wp_create_nonce( 'get-icons' );
		$params['nonceGetSocials'] = wp_create_nonce( 'get-socials' );

		wp_localize_script( 'fitsc-admin', 'FITSC', $params );

		do_action( 'fitsc_admin_enqueue' );
	}

	/**
	 * Add shortcode button next to media upload buttons
	 *
	 * @return void
	 */
	function add_shortcode_button()
	{
		include FITSC_INC . 'tpl/menu.php';
	}

	/**
	 * Popup HTML template
	 *
	 * @return void
	 */
	function modals()
	{
		include FITSC_INC . 'tpl/modals.php';
	}
}

new FITSC_Admin;