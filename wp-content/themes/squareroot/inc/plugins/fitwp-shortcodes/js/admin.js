// Common jQuery action
jQuery( function ( $ )
{
	jQuery.fn.visibleText = function() {
		return $.map(this.contents(), function(el) {
		if (el.nodeType === 3) {
			return $(el).text();
		}
		if ($(el).is(':visible')) {
			return $(el).visibleText();
	    }
		}).join('');
	};

	var $wrap = $( 'body' ),
		$menu = $( '#fitsc-menu' ),
		$modal = $( '#fitsc-modal' );

	// Set menu width
	var $cols = $menu.find( '.fitsc-cols' ),
		width = parseInt( $cols.children().first().css( 'width' ).replace( 'px', '' ) ),
		num = $cols.children().length;
	$cols.width( num * width );

	// Toggle menu
	$wrap.on( 'click', function ( e )
	{
		if ( $( e.target ).is( '#fitsc-button' ) )
		{
			$menu.toggle();
			return false;
		}
		$menu.hide();
	} );

	// Execute commands
	$menu.on( 'click', 'li', function ()
	{
		var ed = tinyMCE.activeEditor,
			$this = $( this ),
			data;

		// Store current editor for further reference
		FITSC.editor = ed;

		if ( data = $this.data( 'command' ) )
		{
			ed.execCommand( data, false );
		}
		else if ( data = $this.data( 'wrap' ) )
		{
			window.send_to_editor( $this.data( 'before' ) + getSelectedText( ed ) + $this.data( 'after' ) );
		}
		else if ( data = $this.data( 'modal' ) )
		{
			$modal.show();
			jQuery(".fitsc-modal-header").find("h2").html("Insert "+$this.text()+" Shortcode");
			window.fitscModal( data );
		}
	} );

	// Close modal
	$( '#fitsc-close' ).click( function ()
	{
		$modal.hide();
		return false;
	} );

	// Insert shortcode to editor
	$( '#fitsc-insert' ).click( function ( e )
	{
		e.preventDefault();
		var code = $modal.find( '.fitsc-preview-shortcode .fitsc-preview-content' ).visibleText();
		window.send_to_editor( code );
		$modal.hide();
	} );

	// Add .fitsc-active to label when its input is checked
	$wrap.on( 'change', 'label input', function ()
	{
		$( this ).parent().addClass( 'fitsc-active' ).siblings().removeClass( 'fitsc-active' );
	} );

	/**
	 * Get selected text
	 *
	 * @param TinyMCE ed
	 *
	 * @return string
	 */
	function getSelectedText( ed )
	{
		// If editor is active
		if ( ed && !ed.isHidden() )
			return ed.selection.getContent();

		// Else get content from selected text
		// @see http://stackoverflow.com/a/16036818
		var value = '',
			content = document.getElementById( 'content' );

		// IE
		if ( document.selection )
		{
			// For browsers like Internet Explorer
			content.focus();
			var selection = document.selection.createRange();
			value = selection.text;
		}
		// Firefox, Chrome, Opera
		else if ( content.selectionStart || content.selectionStart == '0')
		{
			var start = content.selectionStart,
				end = content.selectionEnd;
			value = content.value.substring( start, end );
		}
		return value;
	}
} );