jQuery( function ( $ )
{
	checkboxToggle();
	togglePostFormatMetaBoxes();
 	togglePortfolioSettings();
	togglePortfolioTestimonial();

	fullwidthToggle();

	function fullwidthToggle() {
		if ($( "#rnr_assign_type" ).length) {
			if ($( "#rnr_assign_type" ).val().substring(0, 9) != "portfolio" || !$( "#rnr_assign_type" ).val() ) {
				$( '[id^="portfolio_section_"]' ).closest('.rwmb-field').hide();
			}
			$( "#rnr_assign_type" ).on('change', function() {
				if (this.value.substring(0, 9) == "portfolio") {
					$( '[id^="portfolio_section_"]' ).closest('.rwmb-field').show();
				}else {
					$( '[id^="portfolio_section_"]' ).closest('.rwmb-field').hide();
				}
			});
		}
	}
	/**
	 * Show, hide a <div> based on a checkbox
	 *
	 * @return void
	 * @since 1.0
	 */
	function checkboxToggle()
	{
		$( 'body' ).on( 'change', '.checkbox-toggle input', function()
		{
			var $this = $( this ),
				$toggle = $this.closest( '.checkbox-toggle' ),
				action;
			if ( !$toggle.hasClass( 'reverse' ) )
				action = $this.is( ':checked' ) ? 'slideDown' : 'slideUp';
			else
				action = $this.is( ':checked' ) ? 'slideUp' : 'slideDown';

			$toggle.next()[action]();
		} );
		$( '.checkbox-toggle input' ).trigger( 'change' );
	}

	/**
	 * Show, hide post format meta boxes
	 *
	 * @return void
	 * @since 1.0
	 */
	function togglePostFormatMetaBoxes()
	{
		var $input = $( 'input[name=post_format]' ),
			$metaBoxes = $( '[id^="montana-meta-box-post-format-"]' ).hide();

		// Don't show post format meta boxes for portfolio
		if ( $( '#post_type' ).val() == 'portfolio' )
			return;

		$input.change( function ()
		{
			$metaBoxes.hide();
			$( '#montana-meta-box-post-format-' + $( this ).val() ).show();
		} );
		$input.filter( ':checked' ).trigger( 'change' );
	}

	/**
	 * Show contact meta box for contact page template only
	 *
	 * @return void
	 * @since 1.0
	 */

	function togglePortfolioSettings()
	{
		$( '#page_template' ).change(function ()
		{
			$( '#montana-meta-box-template-page-portfolio' )[$( this ).val() == 'page-templates/portfolio.php' ? 'show' : 'hide']();
			$( '#display-settings .hidden-layout-portfolio' )[$( this ).val() == 'page-templates/portfolio.php' ? 'hide' : 'show']();

		} ).trigger( 'change' );
	}

	/**
	 * Display type for portfolio
	 *
	 * @return void
	 * @since 1.0
	 */
	function togglePortfolioTestimonial()
	{
		var $display = $( 'input[name=display]' ),
			$testimonial = $( '#portfolio-testimonial' );
		$display.change( function ()
		{
			$testimonial[$( this ).val() == 'simple' ? 'show' : 'hide']();
		} );
		$display.filter( ':checked' ).trigger( 'change' );
	}
} );