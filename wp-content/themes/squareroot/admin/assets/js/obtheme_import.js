/**
 * File: OBtheme import
 * Description: Action import data demo, demo files to make site as demo site
 * Author: Andy Ha (tu@wpbriz.com)
 * Copyright 2007-2014 wpbriz.com. All rights reserved.
 */

/**
 * Function import
 * Call ajax to process
 * @constructor
 */



function OBtheme_import() {
	jQuery(document).ready(function () {
		jQuery.ajax({
			type   : 'POST',
			data   : 'makesite=true&action=obtheme_makesite&type=core',
			url    : ajaxurl,
			success: function (html) {
			},
			error  : function (html) {

			}
		});
	});
}

/**
 * Function remove demo data
 * @constructor
 */
function OBtheme_remove() {

}
