<div id="fitsc-menu-wrapper">
	<button id="fitsc-button" class="button"><i class="fa fa-code"></i><?php _e( 'Shortcodes', 'fitsc' ); ?>
	</button>
	<div id="fitsc-menu">
		<div class="fitsc-cols">
			<div class="fitsc-col">
				<h4 class="fitsc-heading"><?php _e( 'Text', 'fitsc' ); ?></h4>
				<ul>
					<li data-modal="highlight"><i class="fa fa-pencil"></i><?php _e( 'Highlight', 'fitsc' ); ?></li>
					<li data-command="superscript"><i class="fa fa-superscript"></i><?php _e( 'Superscript', 'fitsc' ); ?></li>
					<li data-command="subscript"><i class="fa fa-subscript"></i><?php _e( 'Subscript', 'fitsc' ); ?></li>
					<!--<li data-modal="list"><i class="fitsc-icon-custom-list"></i><?php _e( 'List', 'fitsc' ); ?></li>-->
					<!--<li data-modal="divider"><i class="fitsc-icon-divider"></i><?php _e( 'Divider', 'fitsc' ); ?></li>-->
					<!--<li data-modal="dropcap"><i class="fitsc-icon-dropcap"></i><?php _e( 'Drop cap', 'fitsc' ); ?></li>-->
					<!--<li data-modal="tooltip"><i class="fa fa-comment-o"></i><?php _e( 'Tooltip', 'fitsc' ); ?></li>-->
					<?php do_action( 'fitsc_menu_col1' ); ?>
				</ul>
			</div>
			<div class="fitsc-col">
				<h4 class="fitsc-heading"><?php _e( 'Elements', 'fitsc' ); ?></h4>
				<ul>
					<li data-modal="button"><i class="fa fa-search"></i><?php _e( 'Button', 'fitsc' ); ?></li>
					<!-- <li data-modal="box"><i class="fa fa-square-o"></i><?php _e( 'Box', 'fitsc' ); ?></li> -->
					<li data-modal="toggles"><i class="fa fa-angle-down"></i><?php _e( 'Toggles', 'fitsc' ); ?></li>
					<li data-modal="accordions"><i class="fa fa-angle-double-down"></i><?php _e( 'Accordions', 'fitsc' ); ?></li>
					<li data-modal="tabs"><i class="fa fa-folder-o"></i><?php _e( 'Tabs', 'fitsc' ); ?></li>
					<li data-modal="statistics"><i class="fa fa-tasks"></i><?php _e( 'Statistics', 'fitsc' ); ?></li>
					<li data-modal="promo-box"><i class="fa fa-check-square-o"></i><?php _e( 'Promo Box', 'fitsc' ); ?></li>
					<!-- <li data-modal="map"><i class="fa fa-map-marker"></i><?php _e( 'Map', 'fitsc' ); ?></li> -->

					<li data-modal="more"><i class="fa fa-map-marker"></i><?php _e( 'More', 'fitsc' ); ?></li>
					<li data-modal="text-block"><i class="fa fa-windows"></i><?php _e( 'Text Block', 'fitsc' ); ?></li>
					<?php do_action( 'fitsc_menu_col2' ); ?>
				</ul>
			</div>
			
			<div class="fitsc-col">
				<h4 class="fitsc-heading"><?php _e( 'Advanced', 'fitsc' ); ?></h4>
				<ul>
					<li data-modal="row"><i class="fa fa-arrows-h"></i><?php _e( 'Row', 'fitsc' ); ?></li>
					<li data-modal="column"><i class="fa fa-columns"></i><?php _e( 'Columns', 'fitsc' ); ?></li>
					<li data-modal="heading"><i class="fa fa-bars"></i><?php _e( 'Heading', 'fitsc' ); ?></li>
					<li data-modal="quotes"><i class="fa fa-quote-left"></i><?php _e( 'Quotes', 'fitsc' ); ?></li>
					<li data-modal="text-rotator"><i class="fa fa-text-width"></i><?php _e( 'Text Rotator', 'fitsc' ); ?></li>
					<li data-modal="carousel"><i class="fa fa-ellipsis-h"></i><?php _e( 'Carousel', 'fitsc' ); ?></li>
					<!-- <li data-modal="image"><i class="fa fa-picture-o"></i><?php _e( 'Image', 'fitsc' ); ?></li> -->
					<!-- <li data-modal="number"><i class="fa fa-square-o"></i><?php _e( 'Number', 'fitsc' ); ?></li> -->
					<li data-modal="icon-box"><i class="fa fa-square-o"></i><?php _e( 'Icon Box', 'fitsc' ); ?></li>
<!-- 					<li data-modal="box-callout"><i class="fa fa-bookmark-o"></i><?php _e( 'Callout Box', 'fitsc' ); ?></li>
					<li data-modal="box-services"><i class="fa fa-credit-card"></i><?php _e( 'Service Box', 'fitsc' ); ?></li> -->
					<li data-modal="box-contact"><i class="fa fa-envelope-o"></i><?php _e( 'Contact Box', 'fitsc' ); ?></li>
					<li data-modal="video"><i class="fa fa-video-camera"></i><?php _e( 'Video', 'fitsc' ); ?></li>
					<!-- <li data-modal="socials"><i class="fitsc-icon-socials"></i><?php _e( 'Socials', 'fitsc' ); ?></li>
					<li data-modal="person"><i class="fitsc-icon-person"></i><?php _e( 'Person', 'fitsc' ); ?></li>
					<li data-modal="testimonial"><i class="fitsc-icon-testimonial"></i><?php _e( 'Testimonial', 'fitsc' ); ?></li>
					<li data-modal="icon-box"><i class="fitsc-icon-icon-box"></i><?php _e( 'Icon Box', 'fitsc' ); ?></li>
					<li data-modal="column"><i class="fitsc-icon-column"></i><?php _e( 'Column', 'fitsc' ); ?></li>
					<li data-modal="widget-area"><i class="fa fa-cogs"></i><?php _e( 'Widget Area', 'fitsc' ); ?></li> -->
					<?php do_action( 'fitsc_menu_col3' ); ?>
				</ul>
			</div>
			
			<?php do_action( 'fitsc_menu_cols' ); ?>
		</div>
	</div>
</div>