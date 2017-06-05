<?php
/**
 * File: OBtheme import
 * Description: Action import data demo, demo files to make site as demo site
 * Author: Andy Ha (tu@wpbriz.com)
 * Copyright 2007-2014 wpbriz.com. All rights reserved.
 */

function obtheme_makesite() {
	if ( isset( $_REQUEST['makesite'] ) && current_user_can( 'manage_options' ) ) {

		require_once OB_INC . 'import' . DIRECTORY_SEPARATOR . 'ob_import.php';
		die;
	}
}

?>
