<?php
/**
 * Generate custom.css file from Theme Options data
 * @return string
 */
function customcss() {
	global $squareroot_data;

	$linkcolor = $squareroot_data['body_link_color'];
	$font      = 'Arial, Helvetica, sans-serif';
	if ( $squareroot_data['google_body_font'] != 'Select Font' ) {
		$font = '"' . $squareroot_data['google_body_font'] . '", Arial, Helvetica, sans-serif';
	} elseif ( $squareroot_data['standard_body'] != 'Select Font' ) {
		$font = $squareroot_data['standard_body'];
	}
	$imgr_gtop    = squareroot_hex2rgb( $linkcolor );
	$bg_portfolio = 'rgba(' . $imgr_gtop[0] . ',' . $imgr_gtop[1] . ',' . $imgr_gtop[2] . ',0.8)';

	$custom_css = '
		.contact-details * {font-family:' . $font . ';}
		body{color: ' . $squareroot_data['body_color'] . '; font-family:' . $font . '; font-size: ' . $squareroot_data['body_font_size'] . 'px;font-weight:' . $squareroot_data['font_weight_body'] . '}
		h1{font-size: ' . $squareroot_data['font_size_h1'] . 'px; font-weight:' . $squareroot_data['font_weight_h1'] . '; font-style:' . $squareroot_data['font_style_h1'] . '; text-transform:' . $squareroot_data['text_transform_h1'] . ' }
		h2{font-size: ' . $squareroot_data['font_size_h2'] . 'px; font-weight:' . $squareroot_data['font_weight_h2'] . '; font-style:' . $squareroot_data['font_style_h2'] . '; text-transform:' . $squareroot_data['text_transform_h2'] . '}
		h3{font-size: ' . $squareroot_data['font_size_h3'] . 'px; font-weight:' . $squareroot_data['font_weight_h3'] . '; font-style:' . $squareroot_data['font_style_h3'] . '; text-transform:' . $squareroot_data['text_transform_h3'] . '}
		h4,.wpb_heading{font-size: ' . $squareroot_data['font_size_h4'] . 'px; font-weight:' . $squareroot_data['font_weight_h4'] . '; font-style:' . $squareroot_data['font_style_h4'] . '; text-transform:' . $squareroot_data['text_transform_h4'] . '}
		h5{font-size: ' . $squareroot_data['font_size_h5'] . 'px; font-weight:' . $squareroot_data['font_weight_h5'] . '; font-style:' . $squareroot_data['font_style_h5'] . '; text-transform:' . $squareroot_data['text_transform_h5'] . '}
		h6{font-size: ' . $squareroot_data['font_size_h6'] . 'px; font-weight:' . $squareroot_data['font_weight_h6'] . '; font-style:' . $squareroot_data['font_style_h6'] . '; text-transform:' . $squareroot_data['text_transform_h6'] . '}
		h1,h2,h3,h4,h5,h6,h1 a, h2 a, h3 a, h4 a, h5 a, h6 a{color: ' . $squareroot_data['headings_color'] . '}
		h1,h2,h3,h4,h5,h6{font-family: ' . $squareroot_data['google_headings'] . ';}
		ul.products li .item-product h3,ul.products li .item-product .price del{font-size: ' . ( $squareroot_data['body_font_size'] + 1 ) . 'px!important;}
		ul.products li .item-product .price{font-size: ' . ( $squareroot_data['body_font_size'] + 3 ) . 'px;}
		.summary_content .single-price .price{font-size: ' . ( $squareroot_data['body_font_size'] + 3 ) . 'px!important;}
		ul.products li .item-product .price .amount,.summary_content .single-price .price span.amount{color: ' . $linkcolor . '; }
		.site-footer .copyright {font-size: ' . ( $squareroot_data['body_font_size'] - 1 ) . 'px }
		.boxes_icon .inner_icon,.main-nav .inner-nav > li > a:hover > span:hover{color:  ' . $linkcolor . '}
		.wpcf7-submit{background: ' . $linkcolor . '}
		.sections .filter-menu li a.filter-current,.sections .filter-menu li a:hover{color:  ' . $linkcolor . ';border-bottom-color:' . $linkcolor . '}
		.main-nav .inner-nav > li > a:hover, .main-nav .inner-nav > li > .nav-active{background: ' . $linkcolor . '}
		.site-footer .footer .widget-title{font-size: ' . $squareroot_data['body_font_size'] . 'px}
		.view_all a:hover,.view_all a:hover:before,.post-formats-wrapper .flex-direction-nav  a:hover{border-color: ' . $linkcolor . '; color: ' . $linkcolor . '!important}
		.wapper_provide .provide_icon .inner_icon,.full_video .style1 .inner_icon .icon,.testimonials .testimonial_des a,
		.format-quote .box-header cite a:hover,.entry-header h3 a:hover,a.link,.comment_form label span,.portfolio_standard h4 a:hover,
		.entry-content-portfolio .entry-content-right li a:hover,
		.suppaMenu a.current-menu-item,.posts-container .meta li a:hover,.posts-container .posts_title a:hover{color: ' . $linkcolor . ';}
		.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce #content div.product .woocommerce-tabs ul.tabs li:hover a,
		 .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li:hover a{color: ' . $linkcolor . ';}
		.socials_portfolio a:hover,	.socials_portfolio a.facebooks,.main-nav-search-form input[type="submit"]:hover,#review_form #respond .form-submit input#submit{ background: ' . $linkcolor . '!important;}
		.main_menu_container .nav>li.current-menu-item>a,.main_menu_container .nav>li>a:focus,
		.main_menu_container .nav>li>a:hover,.post-navigation .nav-links a:hover,.entry-meta li a:hover{color: ' . $linkcolor . ' }
		.portfolio_hover{background: ' . $bg_portfolio . '}
		.nav_team a .inner_icon .icon:hover,.out_team_title h4 a:hover,.widget-sidebar-area .widget ul li a:hover,.post-navigation .nav-links a:hover .meta-nav{color:' . $linkcolor . ' }
		.boxes_icon_hover .wapper_box_icon:hover .boxes_icon,.boxes_icon_hover .wapper_box_icon:hover .inner_icon,.post-navigation .nav-links a:hover .meta-nav,blockquote{border-color:' . $linkcolor . '!important }
		.boxes_icon_hover .wapper_box_icon:hover .inner_icon .icon i,.boxes_icon_hover .wapper_box_icon:hover .boxes_content .boxes_title{color:' . $linkcolor . '!important }
		#main_menu li .sub-menu a:hover{color:  ' . $linkcolor . '}
		#nav-toggle:hover span, #nav-toggle:hover span:before, #nav-toggle:hover span:after{background: ' . $linkcolor . '!important; }
		' . $squareroot_data['css_custom'] . '
	';
	$custom_css .= '.fitsc-accordion.fitsc-active .fitsc-title, .fitsc-toggle.fitsc-active .fitsc-title{color: ' . $linkcolor . ';}';
	$custom_css .= '.fitsc-nav li.fitsc-active {box-shadow: 0px -3px 0px 0px ' . $linkcolor . ';-moz-box-shadow:0px -3px 0px 0px ' . $linkcolor . ';-webkit-box-shadow:0px -3px 0px 0px ' . $linkcolor . ';}li.fitsc-active a {color: ' . $linkcolor . ';}';
	$custom_css .= '.close-footer i{background:' . $squareroot_data['contact_btn_color'] . '!important;}';
	$custom_css .= '.close-footer i:hover{background:' . $squareroot_data['contact_btn_hover_color'] . '!important;}';
	$custom_css .= '.footer-active{background:rgba(' . implode( ",", squareroot_hex2rgb( $squareroot_data['contact_bg_color'] ) ) . ',0.86);}';

	$custom_css .= '.page-foot {background: ' . $squareroot_data['bg_footer_color'] . '!important;color: ' . $squareroot_data['text_footer_color'] . '!important;}';

	$custom_css .= '#header_2 nav a.nav-active, #header_2 nav a:hover{color: ' . $linkcolor . ';}';
	$custom_css .= '#header_3.h3_bg nav a.nav-active, #header_3.h3_bg nav a:hover{color: ' . $linkcolor . ';}';
	$custom_css .= '#header_3 nav a.nav-active, #header_3 nav a:hover{color: ' . $linkcolor . ';}';
	//$custom_css .= '.section .contact-form .inputs.contact-submit input:hover{background: '.$linkcolor.';}';


	$custom_css .= '.minimal .highlight.featured h3{background: ' . $linkcolor . ' !important;}';
	$custom_css .= '.minimal .highlight.featured .features ul, .minimal .highlight.featured h4, .minimal .highlight.featured h3{border-color: ' . $linkcolor . ' !important;}';
	$custom_css .= '.minimal .highlight.featured .pt-button, .minimal .pt-button:hover{border-color: ' . $linkcolor . ' !important;}';
	$custom_css .= '.minimal .pt-button:hover, .minimal .pt-button:active, .minimal .highlight.featured .pt-button{background: ' . $linkcolor . ' !important;}';
	// Remove all tab & newline characters
	$custom_css = str_replace( "\n", '', $custom_css );
	$custom_css = str_replace( "\t", '', $custom_css );

	return $custom_css;
}