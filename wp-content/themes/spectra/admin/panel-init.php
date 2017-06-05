<?php

/* Iclude Panel Class */
if( ! class_exists( 'MuttleyPanel' ) ) 
	get_template_part( 'admin/classes/MuttleyPanel' );

/* Create Panel */
get_template_part( 'admin/panel', 'main' );

?>