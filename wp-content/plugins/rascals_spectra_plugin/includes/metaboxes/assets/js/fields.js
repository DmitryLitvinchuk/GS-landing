
/* When DOM is fully loaded */ 
jQuery(document).ready(function($) {


	/* Upload
	------------------------------------------------------------------------*/
	(function() {
		var 
			custom_uploader,
			target_input,
			media_container;
 
 
	    $( '.upload-image' ).on( 'click', function(e) {
	 
	        e.preventDefault();

	        // Media Container
			media_container = $( this ).parent().parent();

			// Target input
			target_input = media_container.find( 'input' );
	 
	        //If the uploader object has already been created, reopen the dialog
	        if ( custom_uploader ) {
	            custom_uploader.open();
	            return;
	        }
	 
	        //Extend the wp.media object
	        custom_uploader = wp.media.frames.file_frame = wp.media({
	            multiple: false,
	            library: { type: 'image' }
	        });
	 
	        // When a file is selected, grab the URL and set it as the text field's value
	        custom_uploader.on('select', function() {
	            attachment = custom_uploader.state().get( 'selection' ).first().toJSON();

	            var url = '';

	            if ( attachment.sizes == undefined ) {
	            	url = attachment.url;
	            }
				else if ( attachment.sizes.thumbnail == undefined ) {
					url = attachment.sizes.full.url;
				} else {
					url = attachment.sizes.thumbnail.url;
				}

	            // Preview
	            media_container.find( '.image-holder img' ).remove();
				media_container.find( '.image-holder' ).append( '<img src="' + url + '" alt="Image Preview">' );

				media_container.find( '.image-holder' ).addClass( 'is_image' );
				
				// Update ID
				target_input.val( attachment.id );
	        });

			custom_uploader.on( 'open', function() {
				var selection = custom_uploader.state().get( 'selection' ),
					id = target_input.val();

				if ( id !== '' ) {
					attachment = wp.media.attachment( id );
					attachment.fetch();
					selection.add( attachment ? [ attachment ] : [] );
				}

				// Multiple
				// ids = jQuery('#my_field_id').val().split(',');
				// ids.forEach(function(id) {
					// attachment = wp.media.attachment(id);
					// attachment.fetch();
				// 	selection.add( attachment ? [ attachment ] : [] );
				// }
			});

			//Open the uploader dialog
			custom_uploader.open();
	 
	    });

		// Remove image
		 $( '.remove-image' ).on( 'click', function(e) {

		 	e.preventDefault();

	 		var mc = $( this ).parent().parent();
	 		mc.find( '.image-holder img' ).remove();
	 		mc.find( 'input' ).val('');
	        mc.find( '.image-holder' ).removeClass( 'is_image' );
	    });
		
	})();


	/* Datepicker
	------------------------------------------------------------------------*/
	$( '.datepicker-input' ).datepicker( {
		'dateFormat': 'yy-mm-dd',
		beforeShow: function(input, inst) {
		    inst.dpDiv.addClass( '_datepicker' );
		}
	});


	/* Select Image
	------------------------------------------------------------------------*/
	$( 'ul.select-image img' ).on( 'click', function(event) {
											
		/* Variables */											
		var 
			box = $( this ).parent().parent().parent(),
			images = $( 'ul', box ),
			id = $( this ).data( 'image_id' );
			
		/* Remove class */
		$( 'img', images ).removeClass( 'selected-image' );
		
		/* Add class */
		$( this ).addClass( 'selected-image' );

		/* Add value */
		$( 'input', box ).val( id );
		
		/* Group */
		var group = id,
		    main_group = images.data( 'main-group' ),
		    group = 'group-'+group;
		    
			$( '.' + main_group ).fadeOut();
			$( '.' + group ).fadeIn();
			
		event.preventDefault();
	});
	
	$( 'ul.select-image.image-group' ).each( function() {
	    var container = $( this ).parent();
		    group = $( '.select-image-input', container ).val();
		    group = 'group-'+group;
			$('.' + group).show();
			
	});


	/* Range
	------------------------------------------------------------------------*/
	$( '.range' ).each( function() {
		var 
			input = $( this ).find( 'input' ),
			slider = $( this ).find( '.range-slider' ),
			val = input.val(),
			min = input.data( 'min' ),
			max = input.data( 'max' ),
			step = input.data( 'step' );

		slider.slider( {
			orientation: 'horizontal',
			range: 'min',
			animate: true,
			min: min,
			max: max,
			value: val,
			setp: step,
			slide: function( event, ui ) {
				input.val( ui.value );
			}
    	});
		
		// Focus out
		input.focusout( function() {
    		var val = $( this ).val();
    		slider.slider( 'value', val );
		});

	});


	/* Selected Group
	------------------------------------------------------------------------*/
	$( '.select-group' ).each( function() {
	    var group = $( this ).val();

	    	// strip out all whitespace
	    	group = group.replace( /\s/g, '_' );

	    	// convert the string to all lowercase
	    	group = group.toLowerCase();

	    	// Create group
		    group = 'group-' + group;
			$( '.' + group ).show();
	});
											 
	$( '.select-group' ).change( function() {
											 
		var group = $( this ).val(),
		    main_group = $( this ).data( 'main-group' );

		    // strip out all whitespace
	    	group =  group.replace( /\s/g, '_' );

	    	// convert the string to all lowercase
	    	group =  group.toLowerCase();
		    group = 'group-' + group;
		    
			$( '.' + main_group ).hide();
			$( '.' + group ).fadeIn();
	
	});


	/* EXTERNAL PLUGINS
	------------------------------------------------------------------------*/


	/* Color Picker
	------------------------------------------------------------------------*/
  
	$( '.colorpicker-input' ).each( function( i ) {
		var id = 'color_picker_' + i;
		$( this ).attr( 'id', id );
		$( '#' + id ).wpColorPicker();
	});
  

	/* Easy Link
	------------------------------------------------------------------------*/
	$('.easy-link').on( 'click', function( event ) {
	    $( this ).easyLink();
		event.preventDefault();
	});


	/* Media Manager
	------------------------------------------------------------------------*/
	if ( $('.mm-ids').length ) {
		$('.mm-ids').MediaManager();
	}


	/* Video
	------------------------------------------------------------------------*/
	if ( $('._video').length ) {
		$('._video').VideoGenerator();
	}


	/* Iframe generator
	------------------------------------------------------------------------*/
	if ( $('.generate-iframe').length ) {
		$('.generate-iframe').IframeGenerator();
	}


	/* Background generator
	------------------------------------------------------------------------*/
	if ( $('.generate-bg').length ) {
		$('.generate-bg').BgGenerator();
	}
	

	/* Multiselect
	------------------------------------------------------------------------*/
	if ( $( '.multiselect' ).length ) {

		$( '.multiselect' ).each( function() { 
			var id = $( this ).attr( 'id' );
			$( '#' + id ).multiSelect();
		});
	}
	


	/* Switch buttons
	------------------------------------------------------------------------*/

	$( '.switch-wrap > select' ).each( function( i, item ) {

		// Show groups
		if ( $( this ).hasClass( 'switch-group' ) && $( this ).val() == 'on' ) {

		    var main_group = $( this ).data('main-group'),
				group = $( this ).attr('id');

				group = '.group-' + group + '.' + main_group;

				$( group ).show();
		}

		$( item ).toggleSwitch( {
			highlight: $( item ).data('highlight'),
			width: 25,
			change: function( e, val ) {
				var 
					e = $( e.target ).parent().parent(),
					sel = e.find( 'select' ),
					val = sel.val();

				if ( val == undefined ) return;

				if ( sel.hasClass( 'switch-group' ) ) {
    				var main_group = sel.data('main-group'),
						group = sel.attr( 'id' ),
						group = '.group-' + group + '.' + main_group;

					if ( val == 'on' ) 
						$(group).fadeIn();
					else
						$(group).fadeOut();
				}
				}
		});
	});
	

});