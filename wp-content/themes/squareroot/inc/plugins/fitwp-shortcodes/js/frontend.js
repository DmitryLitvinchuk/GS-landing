jQuery( function ( $ )
{
	var $body = $( 'body' );

	// Tabs
	$( '.fitsc-tabs' ).each( function ()
	{
		var $this = $( this ),
			$ul = $this.children( 'ul' ),
			$lis = $ul.children(),
			$content = $this.children( 'div' ),
			$divs = $content.children();

		$lis.filter( ':first' ).addClass( 'fitsc-active' );
		$divs.filter( ':first' ).addClass( 'fitsc-active' );

		$ul.on( 'click', 'li', function ()
		{
			$lis.removeClass( 'fitsc-active' );
			$( this ).addClass( 'fitsc-active' );

			$divs.removeClass( 'fitsc-active' )
				.filter( ':eq(' + $lis.index( this ) + ')' ).addClass( 'fitsc-active' );

			return false;
		} );

		// Tabs vertical
		if ( ( $this ).hasClass( 'fitsc-vertical' ) )
		{
			$content.css( 'marginLeft', $ul.width() );
		}
	} );

	// Accordions
	$body.on( 'click', '.fitsc-accordion .fitsc-title', function ()
	{
		var $this = $( this ),
			$parent = $this.parent(),
			$pane = $this.siblings(),
			$others = $parent.siblings();

		if ( $parent.hasClass( 'fitsc-active' ) )
		{
			$pane.slideUp();
			$parent.removeClass( 'fitsc-active' );
		}
		else
		{
			$others.removeClass( 'fitsc-active' ).find( '.fitsc-content' ).slideUp();
			$parent.addClass( 'fitsc-active' );
			$pane.slideDown();
		}
	} );

	// Toggles
	$body.on( 'click', '.fitsc-toggle .fitsc-title', function ()
	{
		var $this = $( this ),
			$parent = $this.parent(),
			$pane = $this.siblings();

		if ( $parent.hasClass( 'fitsc-active' ) )
		{
			$pane.slideUp();
			$parent.removeClass( 'fitsc-active' );
		}
		else
		{
			$parent.addClass( 'fitsc-active' );
			$pane.slideDown();
		}
	} );

	// Progress bars
	$( '.fitsc-percent' ).each( function ()
	{
		var $this = $( this ),
			percentage = $this.data( 'percentage' );

		$this.css( 'width', '0' );
		$this.animate( {
			width: percentage + '%'
		}, 3000 );
	} );

	// Box close
	$body.on( 'click', '.fitsc-box .fitsc-close', function ()
	{
		$( this ).parent().slideUp( 500 );
	} );
} );
