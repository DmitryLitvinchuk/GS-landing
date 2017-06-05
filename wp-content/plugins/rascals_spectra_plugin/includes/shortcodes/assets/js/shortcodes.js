/**
 * Plugin Name: 	Spectra
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/spectra
 * Author URI: 		http://rascals.eu
 * File:			shortcodes.js
 * =========================================================================================================================================
 *
 * @package spectra-plugin
 * @since 1.0.0
 */

jQuery(document).ready(function($) {


	/* Enable Strict Mode
	 ---------------------------------------------------------------------- */

	"use strict";


	/* Intro Ticker
	 ---------------------------------------------------------------------- */
	function tick(){
		$( '#ticker li:first' ).slideUp({
			duration: 600, 
			complete: function(){
				$( this ).appendTo( $( '#ticker' ) ).slideDown();
			}
		});
	}
	if ( $( document ).data( 'ticker') == undefined ) {
		if ( $( '#ticker' ).length ) {
			$( document ).data( 'ticker', 'ready' );
			var ticker = setInterval( function(){ tick() }, 4000 );
		}
	}
	
	

});