<?php
class FITSC_Ajax
{
	/**
	 * Add ajax callbacks
	 *
	 * @return FITSC_Ajax
	 */
	function __construct()
	{
		$actions = array( 'get_icons', 'get_socials', 'get_modal' );
		foreach ( $actions as $action )
		{
			add_action( "wp_ajax_fitsc_$action", array( $this, $action ) );
		}

		require FITSC_INC . 'helper.php';
	}

	/**
	 * Get modal content for shortcode configuration
	 *
	 * @return void
	 */
	function get_modal()
	{
		if ( isset( $_GET['nonce'] ) && wp_verify_nonce( $_GET['nonce'], 'get-modal' ) && !empty( $_GET['shortcode'] ) )
		{
			$shortcode = str_replace( '-', '_', $_GET['shortcode'] );
			$file = FITSC_INC . 'modal/' . $_GET['shortcode'] . '.php';
			if ( file_exists( $file ) )
			{
				include FITSC_INC . 'modal/' . $_GET['shortcode'] . '.php';
			}
			else
			{
				// Allow themes/plugins add its own modal window content
				do_action( 'fitsc_get_modal', $shortcode );
			}
		}
		die;
	}

	/**
	 * Get list of all icons
	 *
	 * @return void
	 */
	function get_icons()
	{
		if ( empty( $_GET['nonce'] ) || !wp_verify_nonce( $_GET['nonce'], 'get-icons' ) )
			wp_send_json_error();

		// Allow themes to use their own icon fonts
		$icons = apply_filters( 'fitsc_icon_font_all', false );
		if ( empty( $icons ) )
		{
			// Default use FontAwesome icons
			$icons = file_get_contents( FITSC_INC . "tpl/icons.php" );
			$icons = array_filter( array_map( 'trim', explode( "\n", $icons ) ) );
		}

		$data = array();
		foreach ( $icons as $icon )
		{
			$data[] = array( 'class' => $icon );
		}
		wp_send_json_success( $data );
	}

	/**
	 * Get list of socials
	 *
	 * @return void
	 */
	function get_socials()
	{
		if ( empty( $_GET['nonce'] ) || !wp_verify_nonce( $_GET['nonce'], 'get-socials' ) )
			wp_send_json_error();

		// Allow themes to use their own icon fonts
		$icons = apply_filters( 'fitsc_icon_font_socials', false );
		if ( empty( $icons ) )
		{
			// Default use FontAwesome icons
			$icons = file_get_contents( FITSC_INC . "tpl/socials.php" );
			$icons = array_filter( array_map( 'trim', explode( "\n", $icons ) ) );
		}

		$data = array();
		foreach ( $icons as $icon )
		{
			$data[] = array( 'class' => $icon );
		}
		wp_send_json_success( $data );
	}
}

new FITSC_Ajax;