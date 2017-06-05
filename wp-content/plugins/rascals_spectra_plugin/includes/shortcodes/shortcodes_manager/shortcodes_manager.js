function init() {	
	tinyMCEPopup.resizeToInnerSize();
}

// Init functions
tinyMCEPopup.onInit.add(function(ed) {
 	
 	// Form
	$sc_panel = jQuery('form[name=shortcodes]');

	// Groups
	jQuery('.r-meta-group', $sc_panel).each(function(){
		var group = jQuery(this).val(),
			group = 'r-group-'+group;
		jQuery('.' + group, $sc_panel).show();
    });
										 
    jQuery('.r-meta-group', $sc_panel).change(function(){						 
		var group = jQuery(this).val(),
			main_group = jQuery(this).data('main-group'),
		group = 'r-group-'+group;
		jQuery('.' + main_group, $sc_panel).hide();
		jQuery('.' + group, $sc_panel).fadeIn(600);
	
	});

	jQuery('.sc-upload', $sc_panel).bind('click', window.parent.sm_upload_item);

});

// Insert shortcode
function insert_shortcode() {
	
	/* Variables */
	var output;
	var shortcode_panel = document.getElementById('shortcodes_panel');
	var audio_panel = document.getElementById('audio_panel');
	
	/* Audio player */
	if (audio_panel.className.indexOf('current') != -1) {

		var 
			
			tracks_id = document.getElementById('tracks_id').value,
			player_type = document.getElementById('player_type').value;

		if ( player_type == 'tracklist' ) {
			output = '[tracklist id="'+tracks_id+'" ]';
		} else {
			output = '[track id="'+tracks_id+'" ]';
		}

	}
	
	/* Shortcodes */
 	if (shortcode_panel.className.indexOf('current') != -1) {
		var shortcode = document.getElementById('shortcode').value;
		if (shortcode == 0 ){
			tinyMCEPopup.close();
		}

		/* ------------------------------------------ Columns ------------------------------------------ */

		/* Row */
		else if (shortcode == 'row'){
			output = '[row]<br><br>Insert your text here<br><br>[/row]';
		}

		/* Two columns */
		else if (shortcode == '2_columns'){
			output = '[1_2]<br><br>Insert your text here<br><br>[/1_2]<br><br>[1_2_last]<br><br>Insert your text here<br><br>[/1_2_last]';
		}
		/* Three columns */
		else if (shortcode == '3_columns'){
			output = '[1_3]<br><br>Insert your text here<br><br>[/1_3]<br><br>[1_3]<br><br>Insert your text here<br><br>[/1_3]<br><br>[1_3_last]<br><br>Insert your text here<br><br>[/1_3_last]';
		}
		/* Four columns */
		else if (shortcode == '4_columns'){
			output = '[1_4]<br><br>Insert your text here<br><br>[/1_4]<br><br>[1_4]<br><br>Insert your text here<br><br>[/1_4]<br><br>[1_4]<br><br>Insert your text here<br><br>[/1_4]<br><br>[1_4_last]<br><br>Insert your text here<br><br>[/1_4_last]';
		}
		/* 2/3 Column + 1/3 Column */
		else if (shortcode == '2_3_1_3_columns'){
			output = '[2_3]<br><br>Insert your text here<br><br>[/2_3]<br><br>[1_3_last]<br><br>Insert your text here<br><br>[/1_3_last]';
		}
		/* 1/3 Column + 2/3 Column */
		else if (shortcode == '1_3_2_3_columns'){
			output = '[1_3]<br><br>Insert your text here<br><br>[/1_3]<br><br>[2_3_last]<br><br>Insert your text here<br><br>[/2_3_last]';
		}
		/* 3/4 Column + 1/4 Column */
		else if (shortcode == '3_4_1_4_columns'){
			output = '[3_4]<br><br>Insert your text here<br><br>[/3_4]<br><br>[1_4_last]<br><br>Insert your text here<br><br>[/1_4_last]';
		}
		/* 1/4 Column + 3/4 Column */
		else if (shortcode == '1_4_3_4_columns'){
			output = '[1_4]<br><br>Insert your text here<br><br>[/1_4]<br><br>[3_4_last]<br><br>Insert your text here<br><br>[/3_4_last]';
		}

		/* ------------------------------------------ Intro ------------------------------------------ */

		/* Ticker */
		else if (shortcode == 'intro_ticker'){
			output = '[intro_ticker]<br>[tick]...TEXT...[/tick]<br>[tick]...TEXT...[/tick]<br>[tick]...TEXT...[/tick]<br>[/intro_ticker]';
		}


		/* ------------------------------------------ Typography ------------------------------------------ */

		/* Heading XL */
		else if (shortcode == 'heading_xl'){
			output = '[heading_xl align="center"] ... Text here... [/heading_xl]';
		}
		/* Heading L */
		else if (shortcode == 'heading_l'){
			output = '[heading_l align="center"] ... Text here... [/heading_l]';
		}
		/* Heading M */
		else if (shortcode == 'heading_m'){
			output = '[heading_m align="center"] ... Text here... [/heading_m]';
		}
		/* Subheading */
		else if (shortcode == 'subheading'){
			output = '[subheading align="center"] ... Text here... [/subheading]';
		}
		/* Subheading Top */
		else if (shortcode == 'subheading_top'){
			output = '[subheading_top align="center"] ... Text here... [/subheading_top]';
		}

		/* ------------------------------------------ Misc ------------------------------------------ */

		/* Ticker */
		else if (shortcode == 'divider'){
			output = '[divider]';
		}
	}
  		
	if (window.tinyMCE) {
		var inst = tinyMCE.activeEditor.id;
		tinyMCE.execCommand( 'mceInsertContent', false, output );
		// window.tinyMCE.execInstanceCommand(inst, 'mceInsertContent', false, output);
	  	tinyMCEPopup.editor.execCommand('mceRepaint');
	  	tinyMCEPopup.close();
  	}
  	return;
}