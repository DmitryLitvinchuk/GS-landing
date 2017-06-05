<?php

/**
 * SMOF Option filters
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Jonah Dahlquist
 */

/**
 * Filter URLs from uploaded media fields and replaces them with keywords.
 * This is to keep from storing the site URL in the database to make
 * migrations easier.
 *
 * @since 1.4.0
 *
 * @param $squareroot_data Options array
 *
 * @return array
 */
function of_filter_save_media_upload( $squareroot_data ) {

	if ( ! is_array( $squareroot_data ) ) {
		return $squareroot_data;
	}

	foreach ( $squareroot_data as $key => $value ) {
		if ( is_string( $value ) ) {
			$squareroot_data[$key] = str_replace(
				array(
					site_url( '', 'http' ),
					site_url( '', 'https' ),
				),
				array(
					'[site_url]',
					'[site_url_secure]',
				),
				$value
			);
		}
	}

	return $squareroot_data;
}

add_filter( 'of_options_before_save', 'of_filter_save_media_upload' );

/**
 * Filter URLs from uploaded media fields and replaces the site URL keywords
 * with the actual site URL.
 *
 * @since 1.4.0
 *
 * @param $squareroot_data Options array
 *
 * @return array
 */
function of_filter_load_media_upload( $squareroot_data ) {

	if ( ! is_array( $squareroot_data ) ) {
		return $squareroot_data;
	}

	foreach ( $squareroot_data as $key => $value ) {
		if ( is_string( $value ) && preg_match( "/\[site_url(_secure)?\]/", $value ) ) {
			$squareroot_data[$key] = str_replace(
				array(
					'[site_url]',
					'[site_url_secure]',
				),
				array(
					site_url( '', 'http' ),
					site_url( '', 'https' ),
				),
				$value
			);
		}
	}

	return $squareroot_data;
}

add_filter( 'of_options_after_load', 'of_filter_load_media_upload' );
