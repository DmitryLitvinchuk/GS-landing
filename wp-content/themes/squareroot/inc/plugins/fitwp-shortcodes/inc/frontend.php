<?php

class FITSC_Frontend {
	/**
	 * Hold all custom js code
	 *
	 * @var array
	 */
	public $js = array();

	/**
	 * Store the active status of current tab
	 *
	 * @var bool
	 */
	static $tab_active;

	static $intID;

	static $shortcodes_clone;

	/**
	 * Constructor
	 *
	 * @return FITSC_Frontend
	 */
	function __construct() {
		self::$intID = 0;


		// Enqueue shortcodes scripts and styles
		// High priority = enqueue before theme styles = theme can overwrite styles
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 1 );
		add_action( 'wp_footer', array( $this, 'footer' ), 1000 );

		// Register shortcodes
		$shortcodes             = array(
			'heading',
			'box_contact',
			'video',
			'carousel',
			'carousel_item',
			'icon_box',
			'more',
			'row',
			'row_inner',
			'column',
			'column_inner',
			'text_block',
			'statistics',
			'text_rotator',
			'quotes',
			'highlight',

			'button',
			'box',
			'toggles',
			'toggle',
			'accordions',
			'accordion',
			'tabs',
			'tab',
			'tooltip',
			'promo_box',
			'testimonial',
			'map',
			'widget_area',
		);
		self::$shortcodes_clone = $shortcodes;
		foreach ( $shortcodes as $shortcode ) {
			add_shortcode( $shortcode, array( $this, $shortcode ) );
		}
		add_shortcode( 'list', array( $this, 'custom_list' ) );

		add_filter( 'the_content', array( $this, 'shortcodes_formatter' ) );
		add_filter( 'widget_text', array( $this, 'shortcodes_formatter' ) );

	}

	function shortcodes_formatter( $content ) {
		$block = join( "|", self::$shortcodes_clone );

		// opening tag
		$rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );

		// closing tag
		$rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)/", "[/$2]", $rep );

		return $rep;
	}

	public function getCSSAnimation( $css_animation ) {
		$output = '';
		if ( $css_animation != '' ) {
			$output = ' am_animate_when_almost_visible am_' . $css_animation;
		}

		return $output;
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * Allow themes to overwrite shortcode script/style
	 * - false: use plugin (default) script/style
	 * - true: no js/css file is enqueued
	 * - string: URL of custom js/css file, which will be enqueued
	 *
	 * @return void
	 */
	function enqueue() {
		$script = apply_filters( 'fitsc_custom_script', false );
		if ( false === $script ) {
			$script = FITSC_URL . 'js/frontend.js';
		}
		if ( is_string( $script ) ) {
			wp_enqueue_script( 'fitsc', $script, array( 'jquery' ), '', true );
		}

		//		$style = apply_filters( 'fitsc_custom_style', false );
		//		if ( false === $style ) {
		//			$style = FITSC_URL . 'css/frontend.css';
		//		}
		//		if ( is_string( $style ) ) {
		//			wp_enqueue_style( 'fitsc', $style );
		//		}
	}

	/**
	 * Display custom js code
	 *
	 * @return void
	 */
	function footer() {
		// Load Google maps only when needed
		echo '<script>if ( typeof google !== "object" || typeof google.maps !== "object" )
				document.write(\'<script src="//maps.google.com/maps/api/js?sensor=false"><\/script>\')</script>';
		echo '<script>jQuery(function($){' . implode( '', $this->js ) . '} )</script>';
	}

	/**
	 * Remove empty <br>, <p> tags
	 *
	 * @param  string $text
	 *
	 * @return string
	 */
	function cleanup( $text ) {
		return str_replace( array( '<br>', '<br />', '<p></p>' ), '', $text );
	}

	/**
	 * Show dropcap shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function dropcap( $atts, $content ) {
		extract( shortcode_atts( array(
			'type' => '',
		), $atts ) );

		return '<span class="fitsc-dropcap' . ( $type ? " fitsc-$type" : '' ) . '">' . $content . '</span>';
	}

	/**
	 * Show highlight shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function highlight( $atts, $content ) {
		extract( shortcode_atts( array(
			'background'        => '',
			'custom_background' => '',
		), $atts ) );

		return sprintf(
			'<span class="fitsc-highlight%s"%s>' . do_shortcode( $content ) . '</span>',
			$background && ! $custom_background ? " fitsc-background-$background" : '',
			$custom_background ? " style=\"background:$custom_background\"" : ''
		);
	}

	/**
	 * Show list shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function custom_list( $atts, $content ) {
		extract( shortcode_atts( array(
			'icon'       => '',
			'icon_color' => '',
		), $atts ) );
		$content = apply_filters( 'fitsc_content', $content );
		$content = str_replace( '<li>', '<li><i class="' . $icon . '"></i>', $content );
		$content = str_replace( '<ul', "<ul class='fitsc-list fitsc-$icon_color'", $content );

		return $content;
	}

	/**
	 * Show divider shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function divider( $atts, $content ) {
		extract( shortcode_atts( array(
			'type' => '',
		), $atts ) );

		return '<hr class="fitsc-divider' . ( $type ? " fitsc-$type" : '' ) . '">';
	}

	/**
	 * Show button shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function button( $atts, $content ) {
		extract( shortcode_atts( array(
			'link'          => '#',
			'color'         => '',
			'opacity'       => '',
			'size'          => '',
			'icon'          => '',
			'icon_position' => '',

			'id'         => '',
			'nofollow'   => '',
			'background' => '',
			'text_color' => '',
			'target'     => '',
			'align'      => '',

			'position' => '',
			//'position_unit'         => '',

			'full'  => '',
			'class' => '',
		), $atts ) );

		$classes = array( 'fitsc-button' );
		if ( $full ) {
			$classes[] = 'fitsc-full';
		}
		if ( $class ) {
			$classes[] = $class;
		}
		if ( 'right' == $icon_position ) {
			$classes[] = 'fitsc-icon-right';
		}
		if ( $color ) {
			$classes[] = "fitsc-background-$color";
		} else {
			$classes[] = "fitsc-btn-defaults";
		}
		if ( $align ) {
			$classes[] = "fitsc-align-$align";
		}
		if ( $size ) {
			$classes[] = "fitsc-$size";
		}
		$classes = implode( ' ', $classes );
		$style   = '';
		if ( $background ) {
			$style .= "background:$background;";
		}
		if ( $text_color ) {
			$style .= "color:$text_color;";
		}
		if ( $opacity ) {
			$style .= "opacity:$opacity;";
		}

		$content = apply_filters( 'fitsc', $content );
		$html    = "<a href='" . esc_url( $link ) . "' data-text='$content'  class='$classes'" .
		           ( $id ? " id='$id'" : '' ) .
		           ( $nofollow ? " rel='nofollow'" : '' ) .
		           ( $target ? " target='$target'" : '' ) .
		           ( $style ? " style='$style'" : '' ) .
		           '><span>';

		if ( $icon ) {
			$icon    = '<i class="' . $icon . '"></i>';
			$content = $icon_position == 'right' ? ( $content . $icon ) : ( $icon . $content );
		}
		$html .= $content . '</span></a>';
		if ( $align == 'center' ) {
			$position_temp = "";
			if ( $position != "" ) {
				$position = explode( " ", $position );
				if ( $position[0] != "" && $position[0] != 'none' ) {
					if ( is_numeric( $position[0] ) ) {
						$position_temp .= "top: " . $position[0] . "px;";
					} else {
						$position_temp .= "top: " . $position[0] . ";";
					}
				} else {
					$position_temp .= "";
				}

				if ( $position[1] != "" && $position[1] != 'none' ) {
					if ( is_numeric( $position[1] ) ) {
						$position_temp .= " right:" . $position[1] . "px;";
					} else {
						$position_temp .= " right:" . $position[1] . ";";
					}
				} else {
					$position_temp .= "";
				}

				if ( $position[2] != "" && $position[2] != 'none' ) {
					if ( is_numeric( $position[2] ) ) {
						$position_temp .= " bottom: " . $position[2] . "px;";
					} else {
						$position_temp .= " bottom: " . $position[2] . ";";
					}
				} else {
					$position_temp .= "";
				}

				if ( $position[3] != "" && $position[3] != 'none' ) {
					if ( is_numeric( $position[3] ) ) {
						$position_temp .= " left: " . $position[3] . "px;";
					} else {
						$position_temp .= " left: " . $position[3] . ";";
					}
				} else {
					$position_temp .= "";
				}
				$position_temp .= "position:relative;";
			}
			$html = '<div style="text-align:center;' . $position_temp . '">' . $html . '</div>';
		}

		return $html;
	}

	/**
	 * Show styled boxes shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function box( $atts, $content ) {
		extract( shortcode_atts( array(
			'type'  => '',
			'close' => '',
		), $atts ) );
		$classes = array( 'fitsc-box' );
		if ( $type ) {
			$classes[] = "fitsc-$type";
		}
		if ( $close ) {
			$classes[] = "fitsc-close";
			$close     = '<div class="fitsc-close">x</div>';
		}

		return '<div class="' . implode( ' ', $classes ) . '">' . $close . '<div class="fitsc-text">' . apply_filters( 'fitsc_content', $content ) . '</div></div>';
	}

	/**
	 * Show toggles shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function toggles( $atts, $content ) {
		// Get all toggle titles
		preg_match_all( '#\[toggle [^\]]*?title=[\'"]?(.*?)[\'"]#', $content, $matches );

		if ( empty( $matches[1] ) ) {
			return '';
		}

		return sprintf(
			'<div class="fitsc-toggles">%s</div>',
			do_shortcode( $content )
		);
	}

	/**
	 * Show toggle shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function toggle( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' => '',
		), $atts ) );
		if ( ! $title || ! $content ) {
			return '';
		}

		return sprintf( '
			<div class="fitsc-toggle">
				<div class="fitsc-title">%s</div>
				<div class="fitsc-content">%s</div>
			</div>',
			$title,
			apply_filters( 'fitsc_content', $content )
		);
	}

	/**
	 * Show tabs shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function tabs( $atts, $content ) {
		extract( shortcode_atts( array(
			'type' => '',
		), $atts ) );

		// Get all tab titles
		preg_match_all( '#\[tab [^\]]*?\]#', $content, $matches );

		if ( empty( $matches ) ) {
			return '';
		}

		$tpl = '<li%s><a href="#">%s%s</a></li>';
		$lis = '';
		foreach ( $matches[0] as $k => $match ) {
			$tab_atts = shortcode_parse_atts( substr( $match, 1, - 1 ) );
			$tab_atts = shortcode_atts( array(
				'title' => '',
				'icon'  => '',
			), $tab_atts );
			$lis .= sprintf(
				$tpl,
				$k ? '' : ' class="fitsc-active"',
				$tab_atts['icon'] ? '<i class="' . $tab_atts['icon'] . '"></i>' : '',
				$tab_atts['title']
			);
		}

		self::$tab_active = true;

		return sprintf(
			'<div class="fitsc-tabs%s">
				<ul class="fitsc-nav">%s</ul>
				<div class="fitsc-content">%s</div>
			</div>',
			$type ? " fitsc-$type" : '',
			$lis,
			do_shortcode( $content )
		);
	}

	/**
	 * Show tab shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function tab( $atts, $content ) {
		$class            = 'fitsc-tab' . ( self::$tab_active ? ' fitsc-active' : '' );
		self::$tab_active = false;

		return sprintf(
			'<div class="%s">%s</div>',
			$class,
			apply_filters( 'fitsc_content', $content )
		);
	}

	/**
	 * Show accordions shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function accordions( $atts, $content ) {
		// Get all toggle titles
		preg_match_all( '#\[accordion [^\]]*?title=[\'"]?(.*?)[\'"]#', $content, $matches );

		if ( empty( $matches[1] ) ) {
			return '';
		}

		return sprintf(
			'<div class="fitsc-accordions">%s</div>',
			do_shortcode( $content )
		);
	}

	/**
	 * Show accordion shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function accordion( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' => '',
		), $atts ) );
		if ( ! $title || ! $content ) {
			return '';
		}

		return sprintf( '
			<div class="fitsc-accordion">
				<div class="fitsc-title">%s</div>
				<div class="fitsc-content">%s</div>
			</div>',
			$title,
			apply_filters( 'fitsc_content', $content )
		);
	}

	/**
	 * Show tooltip shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function tooltip( $atts, $content ) {
		$atts = shortcode_atts( array(
			'content' => '',
			'link'    => '#',
		), $atts );

		return sprintf( '<a class="fitsc-tooltip" href="%s" title="%s">%s</a>', $atts['link'], $atts['content'], apply_filters( 'fitsc_content', $content ) );
	}

	/**
	 * Show progress bar shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function statistics( $atts, $content ) {
		extract( shortcode_atts( array(
			'text'    => '',
			'percent' => 100,
			'type'    => '',
			'style'   => '',
		), $atts ) );

		if ( $style == 1 ) { // Horizontal
			return sprintf( '
				<div class="fitsc-progress-bar%s">
					<div class="fitsc-title">%s</div>
					<div class="fitsc-percent-wrapper"><div class="fitsc-percent fitsc-percent-%s" data-percentage="%s"></div></div>
				</div>',
				$type ? " fitsc-$type" : '',
				$text,
				$percent,
				$percent
			);
		} else if ( $style == "" ) { // Cycle
			$temp = '<div class="ichart">';
			$temp .= '<div data-percent="' . $percent . '" class="chart-draw">';
			$temp .= '<em>' . $percent . '%</em>';
			$temp .= '<span class="sub">' . $text . '</span>';
			$temp .= '</div>';
			$temp .= '</div>';

			$post_id = get_the_ID();
			$post    = get_post( $post_id );
			$slug    = $post->post_name;
			if ( ! isset( $GLOBALS[ $slug ] ) ) {
				$GLOBALS[ $slug ] = $slug;
				$temp .= '<script type="text/javascript">
						jQuery(document).ready(function($){
							$(".' . $slug . '").waypoint({
								handler    : function () {
									// Update chart
									$(".chart-draw").each(function () {
										var s = $(this);
										// Addition callback function for step added customarily in easypiechart
										s.data("easyPieChart").update(s.attr("data-percent"), function (percent) {
											s.find("em").text(Math.round(percent) + "%");
										});
									});
								},
								triggerOnce: true,
								offset     : "90%"
							});   
						});               
					</script>';
			}

			return $temp;
		} else { // number
			$temp = '<div class="statistic_number">';
			$temp .= '<span class="num">' . $percent . '</span>';
			$temp .= '<span>' . $text . '</span>';
			$temp .= '</div>';

			$post_id = get_the_ID();
			$post    = get_post( $post_id );
			$slug    = $post->post_name;
			if ( ! isset( $GLOBALS[ $slug ] ) ) {
				$GLOBALS[ $slug ] = $slug;
				$temp .= '<script type="text/javascript">
						jQuery(document).ready(function($){
							function animateStats() {
							var $stats = $(".statistic_number").find(".num");
							var arr = [];
							$stats.each(function (i) {
								arr[i] = $(this).text();
							});
							$(".statistic_number").waypoint({
								handler    : function () {
									$stats.each(function (i) {
										var $s = $(this);
										$({tmp: 0}).animate({tmp: arr[i]}, {
											duration: 1200,
											easing  : "swing",
											step    : function () {
												$s.text(Math.ceil(this.tmp));
											}
										});
									});
								},
								triggerOnce: true,
								offset     : "90%",
							});
						}

						animateStats();
					});               
					</script>';
			}

			return $temp;
		}


	}

	/**
	 * Show promo box shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function promo_box( $atts, $content ) {
		extract( shortcode_atts( array(
			'type'             => '',
			'heading'          => '',
			'text'             => '',
			'button1_text'     => '',
			'button1_link'     => '',
			'button1_color'    => '',
			'button1_target'   => '',
			'button1_nofollow' => '',
			'button2_text'     => '',
			'button2_link'     => '',
			'button2_color'    => '',
			'button2_target'   => '',
			'button2_nofollow' => '',
		), $atts ) );

		$button1 = "<a href='" . esc_url( $button1_link ) . "'" .
		           ( $button1_color ? " class='fitsc-button fitsc-large fitsc-background-$button1_color'" : '' ) .
		           ( $button1_nofollow ? " rel='nofollow'" : '' ) .
		           ( $button1_target ? " target='$button1_target'" : '' ) .
		           ">$button1_text</a>";

		$button2 = '';
		if ( $type == 'two-buttons' ) {
			$button2 = "<a href='" . esc_url( $button2_link ) . "'" .
			           ( $button2_color ? " class='fitsc-button fitsc-large fitsc-background-$button2_color'" : '' ) .
			           ( $button2_nofollow ? " rel='nofollow'" : '' ) .
			           ( $button2_target ? " target='$button2_target'" : '' ) .
			           ">$button2_text</a>";
		}

		$content = sprintf( '
			<div class="fitsc-content">
				<h3 class="fitsc-heading">%s</h3>
				<p class="fitsc-text">%s</p>
			</div>',
			$heading,
			$text
		);
		$buttons = sprintf( '
			<div class="fitsc-buttons">%s %s</div>',
			$button1,
			$button2
		);

		$html = sprintf( '
			<div class="fitsc-promo-box-wrap">
				<div class="fitsc-promo-box%s">%s</div>
			</div>',
			$type ? " fitsc-$type" : '',
			$type ? $content . $buttons : $buttons . $content
		);

		return $html;
	}

	/**
	 * Show socials shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function socials( $atts, $content ) {
		$html = '<ul class="fitsc-socials">';
		foreach ( $atts as $k => $v ) {
			$class = str_replace( '_', '-', $k );
			$html .= sprintf(
				'<li>
					<a href="%1$s" class="fitsc-%2$s"><i class="%2$s"></i></a>
				</li>',
				$v,
				$class
			);
		}
		$html .= '</ul>';

		return $html;
	}

	/**
	 * Show person shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function person( $atts, $content ) {
		$atts = array_merge( array(
			'name'     => '',
			'position' => '',
			'photo'    => '',
		), $atts );
		$meta = sprintf( '
			<div class="fitsc-meta">
				<div class="fitsc-name">%s</div>
				<div class="fitsc-position">%s</div>
			</div>',
			$atts['name'],
			$atts['position']
		);
		unset( $atts['name'], $atts['position'] );

		$html = '<div class="fitsc-person">';
		$html .= '<div class="fitsc-photo">';
		$html .= '<img src="' . $atts['photo'] . '">';
		unset( $atts['photo'] );
		$html .= '<ul class="fitsc-socials">';
		foreach ( $atts as $k => $v ) {
			$class = str_replace( '_', '-', $k );
			$html .= sprintf(
				'<li>
					<a href="%1$s" class="fitsc-%2$s"><i class="%2$s"></i></a>
				</li>',
				$v,
				$class
			);
		}
		$html .= '</ul>';
		$html .= '</div>';
		$html .= $meta;
		$html .= '</div>';

		return $html;
	}

	/**
	 * Show testimonial shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function testimonial( $atts, $content ) {
		extract( shortcode_atts( array(
			'name'  => '',
			'info'  => '',
			'photo' => '',
		), $atts ) );

		$html = sprintf( '
			<div class="fitsc-testimonial">
				<img src="%s" class="fitsc-photo">
				<div class="fitsc-text">
					%s
					<div class="fitsc-name">%s</div>
					<div class="fitsc-info">%s</div>
				</div>
			</div>',
			$photo,
			apply_filters( 'fitsc_content', $content ),
			$name,
			$info
		);

		return $html;
	}

	/**
	 * Show column shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 * @see    https://github.com/justintadlock/grid-columns/blob/master/grid-columns.php
	 */
	/*
	function column( $atts, $content = null)
	{
		// Allowed grids can be 2, 3, 4, 5, or 12 columns
		static $allowed_grids = array( 2, 3, 4, 5, 12 );

		static $is_first_column = true;
		static $is_last_column = false;

		// The current grid
		static $grid = 4;

		// The current total number of columns in the grid
		static $span = 0;

		if ( $content === null )
			return '';

		$atts = shortcode_atts( array(
			'grid'  => 4,
			'span'  => 1,
			'push'  => 0,
			'class' => ''
		), $atts );

		// Make sure the grid is in the allowed grids array
		if ( $is_first_column && in_array( $atts['grid'], $allowed_grids ) )
			$grid = absint( $atts['grid'] );

		$atts['span'] = $grid >= $atts['span'] ? absint( $atts['span'] ) : 1;
		$atts['push'] = $grid >= $atts['push'] + $atts['span'] + $span ? absint( $atts['push'] ) : 0;

		// Add to the total $span
		$span = $span + $atts['span'] + $atts['push'];

		// Column classes
		$column_classes = array( 'fitsc-column', "fitsc-span-{$atts['span']}" );
		if ( $atts['push'] )
			$column_classes[] = "fitsc-push-{$atts['push']}";

		// Add user-input custom class(es)
		if ( !empty( $atts['class'] ) )
		{
			if ( !is_array( $atts['class'] ) )
				$atts['class'] = preg_split( '#\s+#', $atts['class'] );
			$column_classes = array_merge( $column_classes, $atts['class'] );
		}

		if ( $is_first_column )
			$column_classes[] = 'fitsc-first';

		// If the $span property is greater than (shouldn't be) or equal to the $grid property
		if ( $span >= $grid )
		{
			$column_classes[] = 'fitsc-last';
			$is_last_column = true;
		}

		// Sanitize and join all classes
		$column_class = implode( ' ', array_map( 'sanitize_html_class', array_unique( $column_classes ) ) );

		$html = '';

		// If this is the first column
		if ( $is_first_column )
		{
			$html .= "<div class='fitsc-grid fitsc-grid-$grid'>";

			// Set the $is_first_column property back to false
			$is_first_column = false;
		}

		// Add the current column to the output
		$html .= '<div class="' . $column_class . '">' . apply_filters( 'fitsc_content', $content ) . '</div>';

		// If this is the last column
		if ( $is_last_column )
		{
			$html .= '</div>';

			// Reset
			$is_first_column = true;
			$is_last_column = false;
			$grid = 4;
			$span = 0;
		}

		return $html;
	}
	*/
	/**
	 * Show icon box shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	// function icon_box( $atts, $content )
	// {
	// 	extract( shortcode_atts( array(
	// 		'type'          => 'basic',
	// 		'icon'          => '',
	// 		'icon_position' => 'top',
	// 		'image'         => '',
	// 		'title'         => '',
	// 		'link'          => '',
	// 		'more_text'     => '',
	// 		'more_link'     => '',
	// 	), $atts ) );

	// 	$icon = $icon ? "<i class='$icon'></i>" : '';
	// 	$more = '';
	// 	if ( $more_text )
	// 	{
	// 		$more = $more_text;
	// 		if ( $more_link )
	// 			$more = "<a href='".$more_link."' class='fitsc-more'>$more</a>";
	// 	}
	// 	$content = apply_filters( 'fitsc_content', $content );
	// 	if ( $type != 'image' )
	// 	{
	// 		if ( $link )
	// 			$title = "<a href='".$link."'>$title</a>";
	// 		$title = $type != 'basic' ? "<h4>$title</h4>" : "<h4>$icon $title</h4>";
	// 	}
	// 	else
	// 	{
	// 		$title = "<h4>$title</h4>";
	// 	}

	// 	$classes = array( 'fitsc-icon-box', "fitsc-$type" );
	// 	switch ( $type )
	// 	{
	// 		case 'basic':
	// 			$html = $title . $content . $more;
	// 			break;
	// 		case 'no-border':
	// 			$classes[] = "fitsc-$icon_position";
	// 			$html = "$icon<div class='fitsc-text'>{$title}{$content}{$more}</div>";
	// 			break;
	// 		case 'border':
	// 			$classes[] = "fitsc-$icon_position";
	// 			$html = $icon . $title . $content . $more;
	// 			break;
	// 		case 'middle':
	// 			$html = $title . $icon . $content;
	// 			break;
	// 		case 'image':
	// 			$html = "
	// 				<div class='fitsc-icon'>$icon</div>
	// 				<div class='fitsc-image'><img src='$image'></div>
	// 				<div class='fitsc-text'>{$title}{$content}</div>
	// 			";
	// 			if ( $link )
	// 				$html = "<a href='".esc_url($link)."'>$html</a>";
	// 			break;
	// 	}

	// 	return '<div class="' . implode( ' ', $classes ) . '">' . $html . '</div>';
	// }

	/**
	 * Show map shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function map( $atts, $content ) {
		static $counter = 0;
		$counter ++;

		extract( shortcode_atts( array(
			'type'         => '',
			'address'      => '',
			'latitude'     => '',
			'longtitude'   => '',
			'map_type'     => '',
			'marker_title' => '',
			'info_window'  => '',
			'zoom'         => 8,
			'width'        => '100%',
			'height'       => '400px',
			'scrollwheel'  => '',
			'controls'     => '',
		), $atts ) );

		$width  = intval( $width ) ? $width : '100%';
		$height = intval( $height ) ? $height : '400px';

		$html = sprintf( '<div style="width:%s;height:%s" id="sls-map-%s"></div>', $width, $height, $counter );
		$js   = '( function() {';

		switch ( $map_type ) {
			case 'satellite':
				$map_type = 'google.maps.MapTypeId.SATELLITE';
				break;
			case 'hybrid':
				$map_type = 'google.maps.MapTypeId.HYBRID';
				break;
			case 'terrain':
				$map_type = 'google.maps.MapTypeId.TERRAIN';
				break;
			default:
				$map_type = 'google.maps.MapTypeId.ROADMAP';
		}

		$controls = array_filter( explode( ',', $controls . ',' ) );
		$js .= '
			var latLng = new google.maps.LatLng( -34.397, 150.644 );
			var map = new google.maps.Map( document.getElementById( "sls-map-' . $counter . '" ), {
				zoom: ' . $zoom . ',
				center: latLng,
				mapTypeId: ' . $map_type . ',
				panControl: ' . ( in_array( 'pan', $controls ) ? 'true' : 'false' ) . ',
				zoomControl: ' . ( in_array( 'zoom', $controls ) ? 'true' : 'false' ) . ',
				mapTypeControl: ' . ( in_array( 'map_type', $controls ) ? 'true' : 'false' ) . ',
				scaleControl: ' . ( in_array( 'scale', $controls ) ? 'true' : 'false' ) . ',
				streetViewControl: ' . ( in_array( 'street_view', $controls ) ? 'true' : 'false' ) . ',
				rotateControl: ' . ( in_array( 'rotate', $controls ) ? 'true' : 'false' ) . ',
				overviewMapControl: ' . ( in_array( 'overview', $controls ) ? 'true' : 'false' ) . ',
				scrollwheel: ' . ( $scrollwheel ? 'true' : 'false' ) . '
			} );
			var marker = new google.maps.Marker( {
				position: latLng,
				map: map
			} );
		';

		if ( $marker_title ) {
			$js .= '
				marker.setTitle( "' . $marker_title . '" );
			';
		}

		if ( $info_window ) {
			$js .= '
				var infoWindow = new google.maps.InfoWindow( {
					content: "' . $info_window . '"
				} );

				google.maps.event.addListener( marker, "click", function()
				{
					infoWindow.open( map, marker );
				} );
			';
		}

		if ( 'latlng' == $type && $latitude && $longtitude ) {
			$js .= '
				latLng = new google.maps.LatLng( ' . $latitude . ', ' . $longtitude . ' );
				map.setCenter( latLng );
				marker.setPosition( latLng );
			';
		} elseif ( $address ) {
			$js .= '
				var geocoder = new google.maps.Geocoder();
				geocoder.geocode( {
					address: "' . $address . '"
				}, function( results )
				{
					var loc = results[0].geometry.location;
					latLng = new google.maps.LatLng( loc.lat(), loc.lng() );
					map.setCenter( latLng );
					marker.setPosition( latLng );
				} );
			';
		}

		$js .= '} )();';

		$this->js[] = $js;

		return $html;
	}

	/**
	 * Show widget_area shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function widget_area( $atts, $content ) {
		extract( shortcode_atts( array(
			'id' => '',
		), $atts ) );
		if ( ! $id ) {
			return '';
		}

		ob_start();
		dynamic_sidebar( $id );

		return ob_get_clean();
	}


	/**
	 * New Shortcode Squareroot
	 **/
	/********************/
	// function info( $atts, $content = null ) {
	// 	extract( shortcode_atts(array(
	// 		"name" => '',
	// 		"major" => '',
	// 	), $atts) );

	// 	$temp = '<header class="big-title">';
	// 	$temp .= '<h1 class="big-head"><span>' . $name;
	// 	$temp .= '<span class="sub-span"><span>' . $major . '</span></span>';
	// 	$temp .= '</span></h1>';
	// 	$temp .= '</header>';
	// 	return $temp;
	// }

	// function link( $atts, $content = null ) {
	// 	extract( shortcode_atts(array(
	// 		"link_url" => '',
	// 		"icon" => '',
	// 	), $atts) );

	// 	if ($link_url == "") {
	// 		$link_url = "#";
	// 	}
	// 	if ($icon == "") {
	// 		$icon = "";
	// 	}else {
	// 		$icon = '<i class="fa '.$icon.'"></i> ';
	// 	}
	// 	$temp = '<div class="cv-btn"><a href="' . esc_url($link_url) . '">'.$icon. do_shortcode( $content ).'</a></div>';

	// 	return $temp;
	// }

	function more( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'text' => '',
		), $atts ) );

		$temp = '<div class="learn-more"><a href="#about"><div class="text">' . $text . '</div><div class="icon"><i class="fa  fa-chevron-down"></i></div></a></div>';

		return $temp;
	}

	/* Row shortcode */
	function row( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'width'            => '',
			'border'           => '',
			'border_color'     => '',
			'radius'           => '',
			'padding'          => '',
			'margin'           => '',
			'extra_class'      => '',
			'background_color' => '',
			'background_url'   => ''
		), $atts ) );

		$html       = "";
		$background = "";

		$border_temp       = "";
		$border_color_temp = "";
		if ( $border ) {
			$border = explode( " ", $border );
			if ( $border_color != "" ) {
				$border_color_temp .= " " . $border_color . " solid;";
			} else {
				$border_color_temp .= " solid;";
			}

			if ( $border[0] != "" && $border[0] != 'n' ) {
				if ( is_numeric( $border[0] ) ) { // default px unit
					$border_temp .= "border-top: " . $border[0] . "px" . $border_color_temp;
				} else {// other unit
					$border_temp .= "border-top: " . $border[0] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

			if ( $border[1] != "" && $border[1] != 'n' ) {
				if ( is_numeric( $border[1] ) ) {
					$border_temp .= " border-right:" . $border[1] . "px" . $border_color_temp;
				} else {
					$border_temp .= " border-right:" . $border[1] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

			if ( $border[2] != "" && $border[2] != 'n' ) {
				if ( is_numeric( $border[2] ) ) {
					$border_temp .= " border-bottom: " . $border[2] . "px" . $border_color_temp;
				} else {
					$border_temp .= " border-bottom: " . $border[2] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

			if ( $border[3] != "" && $border[3] != 'n' ) {
				if ( is_numeric( $border[3] ) ) {
					$border_temp .= " border-left: " . $border[3] . "px" . $border_color_temp;
				} else {
					$border_temp .= " border-left: " . $border[3] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

		}

		// if ($border_color != "") {
		// 	$border_temp .= "border-color:".$border_color.";border-style:solid;";
		// }

		$radius_temp = "";
		if ( $radius != "" ) {
			$radius = explode( " ", $radius );
			if ( $radius[0] != "" && $radius[0] != 'n' ) {
				if ( is_numeric( $radius[0] ) ) {
					$radius_temp .= "border-top-left-radius: " . $radius[0] . "px;";
				} else {
					$radius_temp .= "border-top-left-radius: " . $radius[0] . ";";
				}
			} else {
				$radius_temp .= "";
			}

			if ( $radius[1] != "" && $radius[1] != 'n' ) {
				if ( is_numeric( $radius[1] ) ) {
					$radius_temp .= " border-top-right-radius: " . $radius[1] . "px;";
				} else {
					$radius_temp .= " border-top-right-radius: " . $radius[1] . ";";
				}
			} else {
				$radius_temp .= "";
			}

			if ( $radius[2] != "" && $radius[2] != 'n' ) {
				if ( is_numeric( $radius[2] ) ) {
					$radius_temp .= " border-bottom-right-radius: " . $radius[2] . "px;";
				} else {
					$radius_temp .= " border-bottom-right-radius: " . $radius[2] . ";";
				}
			} else {
				$radius_temp .= "";
			}

			if ( $radius[3] != "" && $radius[3] != 'n' ) {
				if ( is_numeric( $radius[3] ) ) {
					$radius_temp .= " border-bottom-left-radius: " . $radius[3] . "px;";
				} else {
					$radius_temp .= " border-bottom-left-radius: " . $radius[3] . ";";
				}
			} else {
				$radius_temp .= "";
			}
		}

		$padding_temp = "";
		if ( $padding != "" ) {
			$padding = explode( " ", $padding );
			if ( $padding[0] != "" && $padding[0] != 'n' ) {
				if ( is_numeric( $padding[0] ) ) {
					$padding_temp .= "padding-top: " . $padding[0] . "px;";
				} else {
					$padding_temp .= "padding-top: " . $padding[0] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[1] != "" && $padding[1] != 'n' ) {
				if ( is_numeric( $padding[1] ) ) {
					$padding_temp .= " padding-right: " . $padding[1] . "px;";
				} else {
					$padding_temp .= " padding-right: " . $padding[1] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[2] != "" && $padding[2] != 'n' ) {
				if ( is_numeric( $padding[2] ) ) {
					$padding_temp .= " padding-bottom: " . $padding[2] . "px;";
				} else {
					$padding_temp .= " padding-bottom: " . $padding[2] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[3] != "" && $padding[3] != 'n' ) {
				if ( is_numeric( $padding[3] ) ) {
					$padding_temp .= " padding-left: " . $padding[3] . "px;";
				} else {
					$padding_temp .= " padding-left: " . $padding[3] . ";";
				}
			} else {
				$padding_temp .= "";
			}
		}

		$margin_temp = "";
		if ( $margin != "" ) {
			$margin = explode( " ", $margin );
			if ( $margin[0] != "" && $margin[0] != 'n' ) {
				if ( is_numeric( $margin[0] ) ) {
					$margin_temp .= "margin-top: " . $margin[0] . "px;";
				} else {
					$margin_temp .= "margin-top: " . $margin[0] . ";";
				}
			} else {
				$margin_temp .= "";
			}

			if ( $margin[1] != "" && $margin[1] != 'n' ) {
				if ( is_numeric( $margin[1] ) ) {
					$margin_temp .= " margin-right: " . $margin[1] . "px;";
				} else {
					$margin_temp .= " margin-right: " . $margin[1] . ";";
				}
			} else {
				$margin_temp .= "";
			}

			if ( $margin[2] != "" && $margin[2] != 'n' ) {
				if ( is_numeric( $margin[2] ) ) {
					$margin_temp .= " margin-bottom: " . $margin[2] . "px;";
				} else {
					$margin_temp .= " margin-bottom: " . $margin[2] . ";";
				}
			} else {
				$margin_temp .= "";
			}

			if ( $margin[3] != "" && $margin[3] != 'n' ) {
				if ( is_numeric( $margin[3] ) ) {
					$margin_temp .= " margin-left: " . $margin[3] . "px;";
				} else {
					$margin_temp .= " margin-left: " . $margin[3] . ";";
				}
			} else {
				$margin_temp .= "";
			}
		}

		if ( $background_color != "" ) {
			$background_color = 'background:' . $background_color . ';';
		}

		if ( $background_url != "" ) {
			$background_url = 'background:url(' . $background_heading . ');';
		}
		/* add*/
		if ( $background_color != "" || $background_url != "" || $border_temp != "" || $radius_temp != "" || $padding_temp != "" || $margin_temp != "" ) {
			$background = ' style="' . $background_color . $background_url . $border_temp . $radius_temp . $padding_temp . $margin_temp . '"';
		}
		if ( $extra_class ) {
			$extra_class = " " . $extra_class;
		}
		if ( $width == "boxed" ) {
			$html .= '<div class="container' . $extra_class . '"' . $background . '>';
		} else {
			$html .= '<div class="row-fullwidth box-shadow' . $extra_class . '"' . $background . '>';
		}
		$html .= do_shortcode( $content ) . '</div>';

		return $html;
	}

	/* Row shortcode */
	function row_inner( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'width'            => '',
			'border'           => '',
			'border_color'     => '',
			'radius'           => '',
			'padding'          => '',
			'extra_class'      => '',
			'margin'           => '',
			'background_color' => '',
			'background_url'   => ''
		), $atts ) );

		$html       = "";
		$background = "";

		$border_temp       = "";
		$border_color_temp = "";
		if ( $border ) {
			$border = explode( " ", $border );
			if ( $border_color != "" ) {
				$border_color_temp .= " " . $border_color . " solid;";
			} else {
				$border_color_temp .= " solid;";
			}

			if ( $border[0] != "" && $border[0] != 'n' ) {
				if ( is_numeric( $border[0] ) ) { // default px unit
					$border_temp .= "border-top: " . $border[0] . "px" . $border_color_temp;
				} else {// other unit
					$border_temp .= "border-top: " . $border[0] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

			if ( $border[1] != "" && $border[1] != 'n' ) {
				if ( is_numeric( $border[1] ) ) {
					$border_temp .= " border-right:" . $border[1] . "px" . $border_color_temp;
				} else {
					$border_temp .= " border-right:" . $border[1] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

			if ( $border[2] != "" && $border[2] != 'n' ) {
				if ( is_numeric( $border[2] ) ) {
					$border_temp .= " border-bottom: " . $border[2] . "px" . $border_color_temp;
				} else {
					$border_temp .= " border-bottom: " . $border[2] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

			if ( $border[3] != "" && $border[3] != 'n' ) {
				if ( is_numeric( $border[3] ) ) {
					$border_temp .= " border-left: " . $border[3] . "px" . $border_color_temp;
				} else {
					$border_temp .= " border-left: " . $border[3] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

		}

		// if ($border_color != "") {
		// 	$border_temp .= "border-color:".$border_color.";border-style:solid;";
		// }

		$radius_temp = "";
		if ( $radius != "" ) {
			$radius = explode( " ", $radius );
			if ( $radius[0] != "" && $radius[0] != 'n' ) {
				if ( is_numeric( $radius[0] ) ) {
					$radius_temp .= "border-top-left-radius: " . $radius[0] . "px;";
				} else {
					$radius_temp .= "border-top-left-radius: " . $radius[0] . ";";
				}
			} else {
				$radius_temp .= "";
			}

			if ( $radius[1] != "" && $radius[1] != 'n' ) {
				if ( is_numeric( $radius[1] ) ) {
					$radius_temp .= " border-top-right-radius: " . $radius[1] . "px;";
				} else {
					$radius_temp .= " border-top-right-radius: " . $radius[1] . ";";
				}
			} else {
				$radius_temp .= "";
			}

			if ( $radius[2] != "" && $radius[2] != 'n' ) {
				if ( is_numeric( $radius[2] ) ) {
					$radius_temp .= " border-bottom-right-radius: " . $radius[2] . "px;";
				} else {
					$radius_temp .= " border-bottom-right-radius: " . $radius[2] . ";";
				}
			} else {
				$radius_temp .= "";
			}

			if ( $radius[3] != "" && $radius[3] != 'n' ) {
				if ( is_numeric( $radius[3] ) ) {
					$radius_temp .= " border-bottom-left-radius: " . $radius[3] . "px;";
				} else {
					$radius_temp .= " border-bottom-left-radius: " . $radius[3] . ";";
				}
			} else {
				$radius_temp .= "";
			}
		}

		$padding_temp = "";
		if ( $padding != "" ) {
			$padding = explode( " ", $padding );
			if ( $padding[0] != "" && $padding[0] != 'n' ) {
				if ( is_numeric( $padding[0] ) ) {
					$padding_temp .= "padding-top: " . $padding[0] . "px;";
				} else {
					$padding_temp .= "padding-top: " . $padding[0] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[1] != "" && $padding[1] != 'n' ) {
				if ( is_numeric( $padding[1] ) ) {
					$padding_temp .= " padding-right: " . $padding[1] . "px;";
				} else {
					$padding_temp .= " padding-right: " . $padding[1] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[2] != "" && $padding[2] != 'n' ) {
				if ( is_numeric( $padding[2] ) ) {
					$padding_temp .= " padding-bottom: " . $padding[2] . "px;";
				} else {
					$padding_temp .= " padding-bottom: " . $padding[2] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[3] != "" && $padding[3] != 'n' ) {
				if ( is_numeric( $padding[3] ) ) {
					$padding_temp .= " padding-left: " . $padding[3] . "px;";
				} else {
					$padding_temp .= " padding-left: " . $padding[3] . ";";
				}
			} else {
				$padding_temp .= "";
			}
		}

		$margin_temp = "";
		if ( $margin != "" ) {
			$margin = explode( " ", $margin );
			if ( $margin[0] != "" && $margin[0] != 'n' ) {
				if ( is_numeric( $margin[0] ) ) {
					$margin_temp .= "margin-top: " . $margin[0] . "px;";
				} else {
					$margin_temp .= "margin-top: " . $margin[0] . ";";
				}
			} else {
				$margin_temp .= "";
			}

			if ( $margin[1] != "" && $margin[1] != 'n' ) {
				if ( is_numeric( $margin[1] ) ) {
					$margin_temp .= " margin-right: " . $margin[1] . "px;";
				} else {
					$margin_temp .= " margin-right: " . $margin[1] . ";";
				}
			} else {
				$margin_temp .= "";
			}

			if ( $margin[2] != "" && $margin[2] != 'n' ) {
				if ( is_numeric( $margin[2] ) ) {
					$margin_temp .= " margin-bottom: " . $margin[2] . "px;";
				} else {
					$margin_temp .= " margin-bottom: " . $margin[2] . ";";
				}
			} else {
				$margin_temp .= "";
			}

			if ( $margin[3] != "" && $margin[3] != 'n' ) {
				if ( is_numeric( $margin[3] ) ) {
					$margin_temp .= " margin-left: " . $margin[3] . "px;";
				} else {
					$margin_temp .= " margin-left: " . $margin[3] . ";";
				}
			} else {
				$margin_temp .= "";
			}
		}

		if ( $background_color != "" ) {
			$background_color = 'background:' . $background_color . ';';
		}

		if ( $background_url != "" ) {
			$background_url = 'background:url(' . $background_heading . ');';
		}
		/* add*/
		if ( $background_color != "" || $background_url != "" || $border_temp != "" || $radius_temp != "" || $padding_temp != "" || $margin_temp != "" ) {
			$background = ' style="' . $background_color . $background_url . $border_temp . $radius_temp . $padding_temp . $margin_temp . '"';
		}

		if ( $extra_class ) {
			$extra_class = " " . $extra_class;
		}
		if ( $width == "boxed" ) {
			$html .= '<div class="container' . $extra_class . '"' . $background . '>';
		} else {
			$html .= '<div class="row-fullwidth box-shadow' . $extra_class . '"' . $background . '>';
		}

		$html .= do_shortcode( $content ) . '</div>';

		return $html;
	}

	function column( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'width'            => '',
			'border'           => '',
			'border_color'     => '',
			'radius'           => '',
			'padding'          => '',
			'margin'           => '',
			'background_color' => '',
			'background_url'   => '',
			'extra_class'      => ''
		), $atts ) );

		$border_temp       = "";
		$border_color_temp = "";
		if ( $border ) {
			$border = explode( " ", $border );
			if ( $border_color != "" ) {
				$border_color_temp .= " " . $border_color . " solid;";
			} else {
				$border_color_temp .= " solid;";
			}

			if ( $border[0] != "" && $border[0] != 'n' ) {
				if ( is_numeric( $border[0] ) ) { // default px unit
					$border_temp .= "border-top: " . $border[0] . "px" . $border_color_temp;
				} else {// other unit
					$border_temp .= "border-top: " . $border[0] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

			if ( $border[1] != "" && $border[1] != 'n' ) {
				if ( is_numeric( $border[1] ) ) {
					$border_temp .= " border-right:" . $border[1] . "px" . $border_color_temp;
				} else {
					$border_temp .= " border-right:" . $border[1] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

			if ( $border[2] != "" && $border[2] != 'n' ) {
				if ( is_numeric( $border[2] ) ) {
					$border_temp .= " border-bottom: " . $border[2] . "px" . $border_color_temp;
				} else {
					$border_temp .= " border-bottom: " . $border[2] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

			if ( $border[3] != "" && $border[3] != 'n' ) {
				if ( is_numeric( $border[3] ) ) {
					$border_temp .= " border-left: " . $border[3] . "px" . $border_color_temp;
				} else {
					$border_temp .= " border-left: " . $border[3] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

		}

		// if ($border_color != "") {
		// 	$border_temp .= "border-color:".$border_color.";border-style:solid;";
		// }

		$radius_temp = "";
		if ( $radius != "" ) {
			$radius = explode( " ", $radius );
			if ( $radius[0] != "" && $radius[0] != 'n' ) {
				if ( is_numeric( $radius[0] ) ) {
					$radius_temp .= "border-top-left-radius: " . $radius[0] . "px;";
				} else {
					$radius_temp .= "border-top-left-radius: " . $radius[0] . ";";
				}
			} else {
				$radius_temp .= "";
			}

			if ( $radius[1] != "" && $radius[1] != 'n' ) {
				if ( is_numeric( $radius[1] ) ) {
					$radius_temp .= " border-top-right-radius: " . $radius[1] . "px;";
				} else {
					$radius_temp .= " border-top-right-radius: " . $radius[1] . ";";
				}
			} else {
				$radius_temp .= "";
			}

			if ( $radius[2] != "" && $radius[2] != 'n' ) {
				if ( is_numeric( $radius[2] ) ) {
					$radius_temp .= " border-bottom-right-radius: " . $radius[2] . "px;";
				} else {
					$radius_temp .= " border-bottom-right-radius: " . $radius[2] . ";";
				}
			} else {
				$radius_temp .= "";
			}

			if ( $radius[3] != "" && $radius[3] != 'n' ) {
				if ( is_numeric( $radius[3] ) ) {
					$radius_temp .= " border-bottom-left-radius: " . $radius[3] . "px;";
				} else {
					$radius_temp .= " border-bottom-left-radius: " . $radius[3] . ";";
				}
			} else {
				$radius_temp .= "";
			}
		}

		$padding_temp = "";
		if ( $padding != "" ) {
			$padding = explode( " ", $padding );
			if ( $padding[0] != "" && $padding[0] != 'n' ) {
				if ( is_numeric( $padding[0] ) ) {
					$padding_temp .= "padding-top: " . $padding[0] . "px;";
				} else {
					$padding_temp .= "padding-top: " . $padding[0] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[1] != "" && $padding[1] != 'n' ) {
				if ( is_numeric( $padding[1] ) ) {
					$padding_temp .= " padding-right: " . $padding[1] . "px;";
				} else {
					$padding_temp .= " padding-right: " . $padding[1] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[2] != "" && $padding[2] != 'n' ) {
				if ( is_numeric( $padding[2] ) ) {
					$padding_temp .= " padding-bottom: " . $padding[2] . "px;";
				} else {
					$padding_temp .= " padding-bottom: " . $padding[2] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[3] != "" && $padding[3] != 'n' ) {
				if ( is_numeric( $padding[3] ) ) {
					$padding_temp .= " padding-left: " . $padding[3] . "px;";
				} else {
					$padding_temp .= " padding-left: " . $padding[3] . ";";
				}
			} else {
				$padding_temp .= "";
			}
		}

		$margin_temp = "";
		if ( $margin != "" ) {
			$margin = explode( " ", $margin );
			if ( $margin[0] != "" && $margin[0] != 'n' ) {
				if ( is_numeric( $margin[0] ) ) {
					$margin_temp .= "margin-top: " . $margin[0] . "px;";
				} else {
					$margin_temp .= "margin-top: " . $margin[0] . ";";
				}
			} else {
				$margin_temp .= "";
			}

			if ( $margin[1] != "" && $margin[1] != 'n' ) {
				if ( is_numeric( $margin[1] ) ) {
					$margin_temp .= " margin-right: " . $margin[1] . "px;";
				} else {
					$margin_temp .= " margin-right: " . $margin[1] . ";";
				}
			} else {
				$margin_temp .= "";
			}

			if ( $margin[2] != "" && $margin[2] != 'n' ) {
				if ( is_numeric( $margin[2] ) ) {
					$margin_temp .= " margin-bottom: " . $margin[2] . "px;";
				} else {
					$margin_temp .= " margin-bottom: " . $margin[2] . ";";
				}
			} else {
				$margin_temp .= "";
			}

			if ( $margin[3] != "" && $margin[3] != 'n' ) {
				if ( is_numeric( $margin[3] ) ) {
					$margin_temp .= " margin-left: " . $margin[3] . "px;";
				} else {
					$margin_temp .= " margin-left: " . $margin[3] . ";";
				}
			} else {
				$margin_temp .= "";
			}
		}

		if ( $background_color != "" ) {
			$background_color = 'background:' . $background_color . ';';
		}

		if ( $background_url != "" ) {
			$background_url = 'background:url(' . $background_heading . ');';
		}
		/* add*/
		$background = "";
		if ( $background_color != "" || $background_url != "" || $border_temp != "" || $radius_temp != "" || $padding_temp != "" || $margin_temp != "" ) {
			$background = ' style="' . $background_color . $background_url . $border_temp . $radius_temp . $padding_temp . $margin_temp . '"';
		}

		$fraction      = $width;
		$fractionParts = explode( '/', $fraction );
		$numerator     = $fractionParts[0];
		$denominator   = $fractionParts[1];

		$arr         = simplify( $numerator, $denominator ); // Array(2,5)
		$numerator   = $arr[0];
		$denominator = $arr[1];

		if ( 12 % $denominator == 0 ) {
			$number = ( 12 / $denominator ) * $numerator;
			$temp   = '<div class="col-md-' . $number . ' col-sm-' . $number . ' ' . $extra_class . '"' . $background . '>' . do_shortcode( $content ) . '</div>';
		} else {
			$temp = '<div class="col-md-3 col-sm-3 col-xs-12"' . $background . '>' . do_shortcode( $content ) . '</div>';
		}

		return $temp;
	}

	function column_inner( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'width'            => '',
			'border'           => '',
			'border_color'     => '',
			'radius'           => '',
			'padding'          => '',
			'margin'           => '',
			'background_color' => '',
			'background_url'   => '',
			'extra_class'      => ''
		), $atts ) );

		$border_temp       = "";
		$border_color_temp = "";
		if ( $border ) {
			$border = explode( " ", $border );
			if ( $border_color != "" ) {
				$border_color_temp .= " " . $border_color . " solid;";
			} else {
				$border_color_temp .= " solid;";
			}

			if ( $border[0] != "" && $border[0] != 'n' ) {
				if ( is_numeric( $border[0] ) ) { // default px unit
					$border_temp .= "border-top: " . $border[0] . "px" . $border_color_temp;
				} else {// other unit
					$border_temp .= "border-top: " . $border[0] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

			if ( $border[1] != "" && $border[1] != 'n' ) {
				if ( is_numeric( $border[1] ) ) {
					$border_temp .= " border-right:" . $border[1] . "px" . $border_color_temp;
				} else {
					$border_temp .= " border-right:" . $border[1] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

			if ( $border[2] != "" && $border[2] != 'n' ) {
				if ( is_numeric( $border[2] ) ) {
					$border_temp .= " border-bottom: " . $border[2] . "px" . $border_color_temp;
				} else {
					$border_temp .= " border-bottom: " . $border[2] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

			if ( $border[3] != "" && $border[3] != 'n' ) {
				if ( is_numeric( $border[3] ) ) {
					$border_temp .= " border-left: " . $border[3] . "px" . $border_color_temp;
				} else {
					$border_temp .= " border-left: " . $border[3] . $border_color_temp;
				}
			} else {
				$border_temp .= "";
			}

		}

		// if ($border_color != "") {
		// 	$border_temp .= "border-color:".$border_color.";border-style:solid;";
		// }

		$radius_temp = "";
		if ( $radius != "" ) {
			$radius = explode( " ", $radius );
			if ( $radius[0] != "" && $radius[0] != 'n' ) {
				if ( is_numeric( $radius[0] ) ) {
					$radius_temp .= "border-top-left-radius: " . $radius[0] . "px;";
				} else {
					$radius_temp .= "border-top-left-radius: " . $radius[0] . ";";
				}
			} else {
				$radius_temp .= "";
			}

			if ( $radius[1] != "" && $radius[1] != 'n' ) {
				if ( is_numeric( $radius[1] ) ) {
					$radius_temp .= " border-top-right-radius: " . $radius[1] . "px;";
				} else {
					$radius_temp .= " border-top-right-radius: " . $radius[1] . ";";
				}
			} else {
				$radius_temp .= "";
			}

			if ( $radius[2] != "" && $radius[2] != 'n' ) {
				if ( is_numeric( $radius[2] ) ) {
					$radius_temp .= " border-bottom-right-radius: " . $radius[2] . "px;";
				} else {
					$radius_temp .= " border-bottom-right-radius: " . $radius[2] . ";";
				}
			} else {
				$radius_temp .= "";
			}

			if ( $radius[3] != "" && $radius[3] != 'n' ) {
				if ( is_numeric( $radius[3] ) ) {
					$radius_temp .= " border-bottom-left-radius: " . $radius[3] . "px;";
				} else {
					$radius_temp .= " border-bottom-left-radius: " . $radius[3] . ";";
				}
			} else {
				$radius_temp .= "";
			}
		}

		$padding_temp = "";
		if ( $padding != "" ) {
			$padding = explode( " ", $padding );
			if ( $padding[0] != "" && $padding[0] != 'n' ) {
				if ( is_numeric( $padding[0] ) ) {
					$padding_temp .= "padding-top: " . $padding[0] . "px;";
				} else {
					$padding_temp .= "padding-top: " . $padding[0] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[1] != "" && $padding[1] != 'n' ) {
				if ( is_numeric( $padding[1] ) ) {
					$padding_temp .= " padding-right: " . $padding[1] . "px;";
				} else {
					$padding_temp .= " padding-right: " . $padding[1] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[2] != "" && $padding[2] != 'n' ) {
				if ( is_numeric( $padding[2] ) ) {
					$padding_temp .= " padding-bottom: " . $padding[2] . "px;";
				} else {
					$padding_temp .= " padding-bottom: " . $padding[2] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[3] != "" && $padding[3] != 'n' ) {
				if ( is_numeric( $padding[3] ) ) {
					$padding_temp .= " padding-left: " . $padding[3] . "px;";
				} else {
					$padding_temp .= " padding-left: " . $padding[3] . ";";
				}
			} else {
				$padding_temp .= "";
			}
		}

		$margin_temp = "";
		if ( $margin != "" ) {
			$margin = explode( " ", $margin );
			if ( $margin[0] != "" && $margin[0] != 'n' ) {
				if ( is_numeric( $margin[0] ) ) {
					$margin_temp .= "margin-top: " . $margin[0] . "px;";
				} else {
					$margin_temp .= "margin-top: " . $margin[0] . ";";
				}
			} else {
				$margin_temp .= "";
			}

			if ( $margin[1] != "" && $margin[1] != 'n' ) {
				if ( is_numeric( $margin[1] ) ) {
					$margin_temp .= " margin-right: " . $margin[1] . "px;";
				} else {
					$margin_temp .= " margin-right: " . $margin[1] . ";";
				}
			} else {
				$margin_temp .= "";
			}

			if ( $margin[2] != "" && $margin[2] != 'n' ) {
				if ( is_numeric( $margin[2] ) ) {
					$margin_temp .= " margin-bottom: " . $margin[2] . "px;";
				} else {
					$margin_temp .= " margin-bottom: " . $margin[2] . ";";
				}
			} else {
				$margin_temp .= "";
			}

			if ( $margin[3] != "" && $margin[3] != 'n' ) {
				if ( is_numeric( $margin[3] ) ) {
					$margin_temp .= " margin-left: " . $margin[3] . "px;";
				} else {
					$margin_temp .= " margin-left: " . $margin[3] . ";";
				}
			} else {
				$margin_temp .= "";
			}
		}

		if ( $background_color != "" ) {
			$background_color = 'background:' . $background_color . ';';
		}

		if ( $background_url != "" ) {
			$background_url = 'background:url(' . $background_heading . ');';
		}
		/* add*/
		$background = "";
		if ( $background_color != "" || $background_url != "" || $border_temp != "" || $radius_temp != "" || $padding_temp != "" || $margin_temp != "" ) {
			$background = ' style="' . $background_color . $background_url . $border_temp . $radius_temp . $padding_temp . $margin_temp . '"';
		}

		$fraction      = $width;
		$fractionParts = explode( '/', $fraction );
		$numerator     = $fractionParts[0];
		$denominator   = $fractionParts[1];

		$arr         = simplify( $numerator, $denominator ); // Array(2,5)
		$numerator   = $arr[0];
		$denominator = $arr[1];

		if ( 12 % $denominator == 0 ) {
			$number = ( 12 / $denominator ) * $numerator;
			$temp   = '<div class="col-md-' . $number . ' col-sm-' . $number . ' ' . $extra_class . '"' . $background . '>' . do_shortcode( $content ) . '</div>';
		} else {
			$temp = '<div class="col-md-3 col-sm-3 col-xs-12"' . $background . '>' . do_shortcode( $content ) . '</div>';
		}

		return $temp;
	}

	// function title( $atts, $content = null ) {
	// 	$temp = '<h3 class="titleless">' . do_shortcode( $content ) . '</h3>';
	// 	return $temp;
	// }

	// function extrainfo( $atts, $content = null ) {
	// 	$temp = '<div class="extra-info"><div class="container">' . do_shortcode( $content ) . '</div></div>';
	// 	return $temp;
	// }

	// function extra( $atts, $content = null ) {
	// 	$temp = '<span class="head">' . $atts['head'] . '</span>';
	// 	$temp .= '<span>' . $content . '</span>';
	// 	return $temp;
	// }

	/* Fantastic header */
	function heading( $atts, $content = null ) {
		extract( shortcode_atts( array(
			"style"     => '',
			"title"     => '',
			"size_tit"  => '',
			"size_des"  => '',
			"tit_color" => '',
			"des_color" => ''
		), $atts ) );

		$css = "";

		$post_id = get_the_ID();
		$post    = get_post( $post_id );
		self::$intID ++;
		$tp   = str_replace( "-", "_", $post->post_name );
		$slug = "hd_" . $tp . "_" . self::$intID;

		if ( $style == 4 ) {//4
			$temp = "";
			$temp .= '<header class="big-title ' . $slug . '">';

			$temp .= '<h1 class="big-head"><span>' . $title . '<span class="sub-span"><span>' . do_shortcode( $content ) . '</span></span></span></h1></header>';

			if ( $tit_color ) {
				$tit_color = '.' . $slug . '.big-title span{color: ' . $tit_color . ';}.' . $slug . ' .big-head > span:before,.' . $slug . ' .big-head > span:after{background: ' . $tit_color . ';}';
			}
			if ( $des_color ) {
				$des_color = '.' . $slug . '.big-title span .sub-span > span{color: ' . $des_color . ';}.' . $slug . '.big-title span .sub-span > span:before,.' . $slug . '.big-title span .sub-span > span:after{background: ' . $des_color . ';}';
			}
			if ( $tit_color || $des_color ) {
				$css .= '<style>' . $tit_color . $des_color . '</style>';
			}

			return $temp . $css;

		}

		if ( $size_tit == "" && $title != "" ) {
			$title = '<h2 class="h_tit">' . $title . '</h2>';
		} else {
			$title = '<h' . $size_tit . ' class="h_tit">' . $title . "</h" . $size_tit . ">";
		}

		if ( $content != "" ) {
			$ct = '<h2 class="h_tit">' . do_shortcode( $content ) . '</h2>';
		} else {
			$ct = '<h' . $size_tit . ' class="h_tit">' . do_shortcode( $content ) . "</h" . $size_tit . ">";
		}

		if ( $style != "" ) {
			if ( $style == 2 ) { //2
				$temp = '<header class="heading_2 ' . $slug . '">';
				//$temp .= $title;
				$temp .= $ct;
				$temp .= '</header>';

				if ( $tit_color ) {
					$tit_color = '.' . $slug . '.heading_2 .h_tit{color: ' . $tit_color . ';}.' . $slug . '.heading_2 .h_tit:before{background: ' . $tit_color . ';}';
					$css .= '<style>' . $tit_color . '</style>';
				}


			} else if ( $style == 3 ) {//3
				$temp = '<header class="heading_3 ' . $slug . '">';
				//$temp .= $title;
				$temp .= $ct;
				$temp .= '</header>';

				if ( $tit_color ) {
					$tit_color = '.' . $slug . '.heading_3 .h_tit{color: ' . $tit_color . ';}.' . $slug . '.heading_3 .h_tit:before,.' . $slug . '.heading_3 .h_tit:after{border-top: 1px solid ' . $tit_color . ';border-bottom: 1px solid ' . $tit_color . ';}';
					$css .= '<style>' . $tit_color . '</style>';
				}
			} else {//5
				$temp = '<header class="heading_5 ' . $slug . '">';
				//$temp .= $title;
				$temp .= $ct;
				$temp .= '</header>';

				if ( $tit_color ) {
					$tit_color = '.' . $slug . '.heading_5 .h_tit{color: ' . $tit_color . ';}.' . $slug . '.heading_5 .h_tit {border: 2px ' . $tit_color . ' solid;padding: 10px;}.' . $slug . '.heading_5 {text-align: center;display: table;margin: 0 auto;}';
					$css .= '<style>' . $tit_color . '</style>';
				}
			}

		} else { //1
			if ( $size_des == "" && $content != "" ) {
				$content = '<h3 class="d_tit"><span>/</span>' . do_shortcode( $content ) . "<h3>";
			} else if ( $content ) {
				$content = "<h" . $size_des . ' class="d_tit"><span>/</span>' . do_shortcode( $content ) . "</h" . $size_des . ">";
			} else {

			}

			$temp = '<header class="heading ' . $slug . '">';
			$temp .= $title;
			$temp .= $content;
			$temp .= '</header>';

			if ( $tit_color ) {
				$tit_color = '.' . $slug . '.heading .h_tit{color: ' . $tit_color . ';border-bottom: 1px solid ' . $tit_color . ';}.' . $slug . '.heading .h_tit:before{background: ' . $tit_color . ';}';
			}
			if ( $des_color ) {
				$des_color = '.' . $slug . '.heading .d_tit{color: ' . $des_color . ';}';
			}
			if ( $tit_color || $des_color ) {
				$css .= '<style>' . $tit_color . $des_color . '</style>';
			}
		}


		return $temp . $css;
	}

	// function author( $atts, $content = null ) {
	// 	$temp = '<div class="author-info">' . do_shortcode( $content ) . '</div>';

	// 	return $temp;
	// }

	// function subheader( $atts, $content = null ) {
	// 	$temp = '<div class="info row">' . do_shortcode( $content ) . '</div>';

	// 	return $temp;
	// }

	// function figure( $atts, $content = null ) {
	// 	$temp = '<figure class="col-md-4 col-sm-5 author-pic">';
	// 	$temp .= '<img src="' . $atts['img'] . '" alt="' . $content . '">';
	// 	$temp .= '</figure>';

	// 	return $temp;
	// }

	// function desc( $atts, $content = null ) {
	// 	$temp = '<div class="desc col-md-8 col-sm-7">';
	// 	$temp .= '<p>' . $atts['fdesc'] . '</p><br>';
	// 	$temp .= '<p>' . $content . '</p></div>';

	// 	return $temp;
	// }

	// function sqheader( $atts, $content = null){
	// 	$sq_header = '<div class="sq-header">';
	// 	$sq_header .= '<h3>'. do_shortcode($content) .'</h3>';
	// 	$sq_header .= '</div>';
	// 	return $sq_header;
	// }

	/* center block*/
	// function center_block ($atts, $content = null) {
	// 	extract( shortcode_atts(array(
	// 			"background" => ''
	// 	), $atts) );
	// 	if ($background != "") {
	// 		$background = 'style="background: '.$background.';"';
	// 	}else {
	// 		$background = "";
	// 	}
	// 	$center_block = '<div class="center-block" '.$background.'>';
	// 	$center_block .= do_shortcode($content);
	// 	$center_block .= '</div>';
	// 	return $center_block;
	// }
	function text_rotator( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'effect'     => '',
			'background' => '',
			'color'      => '',
			'padding'    => ''
		), $atts ) );


		if ( $effect <> '' ) {
			$effect = 'text_rotator_' . $effect;
		} else {
			$effect = 'text_rotator_fade';
		}

		$padding_temp = "";
		if ( $padding != "" ) {
			$padding = explode( " ", $padding );
			if ( $padding[0] != "" && $padding[0] != 'n' ) {
				if ( is_numeric( $padding[0] ) ) {
					$padding_temp .= "padding-top: " . $padding[0] . "px;";
				} else {
					$padding_temp .= "padding-top: " . $padding[0] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[1] != "" && $padding[1] != 'n' ) {
				if ( is_numeric( $padding[1] ) ) {
					$padding_temp .= " padding-right: " . $padding[1] . "px;";
				} else {
					$padding_temp .= " padding-right: " . $padding[1] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[2] != "" && $padding[2] != 'n' ) {
				if ( is_numeric( $padding[2] ) ) {
					$padding_temp .= " padding-bottom: " . $padding[2] . "px;";
				} else {
					$padding_temp .= " padding-bottom: " . $padding[2] . ";";
				}
			} else {
				$padding_temp .= "";
			}

			if ( $padding[3] != "" && $padding[3] != 'n' ) {
				if ( is_numeric( $padding[3] ) ) {
					$padding_temp .= " padding-left: " . $padding[3] . "px;";
				} else {
					$padding_temp .= " padding-left: " . $padding[3] . ";";
				}
			} else {
				$padding_temp .= "";
			}
		}

		if ( $color != "" ) {
			$color = "color:" . $color . ";";
		}
		if ( $background != "" ) {
			$background = "background:" . $background . ";";
		}

		$style = "";
		if ( $background != "" || $color != "" || $padding_temp != "" ) {
			$style .= ' style="' . $padding_temp . $background . $color . '"';
		}

		$html = '<span class="' . $effect . '"' . $style . '>' . $content . '</span>';
		wp_enqueue_script( 'simple-text-rotator', get_template_directory_uri() . '/js/jquery.simple-text-rotator.js', array( 'jquery' ), '', false );

		return $html;
	}

	/** QUOTES **/
	function quotes( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'author' => ''
		), $atts ) );
		$center_block = '<div class="sr_quote"><p><i class="fa fa-quote-left"></i>';
		$center_block .= do_shortcode( $content );
		$center_block .= '<i class="fa fa-quote-right"></i></p>';
		$center_block .= '<div class="sr_quote-author">- ' . $author . ' -</div>';
		$center_block .= '</div>';

		return $center_block;
	}
	/********************/


	/* Callout Box */
	// function box_callout ($atts, $content = null) {
	// 	extract( shortcode_atts(array(
	// 			"title" => 'Callout Title',
	// 			"btn_title" => 'Purchase Now',
	// 			"btn_url" => '#'
	// 	), $atts) ); 
	// 	$callout = '<div class="callout-block">';
	// 	$callout .= '<h3>'.$title.'</h3>';
	// 	$callout .= '<div class="callout-button">';
	// 	$callout .= '<a class="button btn-middle btn-black" href="'. esc_url($btn_url) .'" target="_blank">'. $btn_title .'</a>';
	// 	$callout .= '</div>';
	// 	$callout .= '</div>';
	// 	return $callout;
	// }
	/* Service Box */
	// function box_services( $atts, $content = null ) {
	function icon_box( $atts, $content = null ) {
		extract( shortcode_atts( array(
			"style"            => '',
			"box_border"       => '',
			"box_border_color" => '',
			"box_bg_color"     => '',
			//"box_padding" => '',
			"title"            => '',
			"title_size"       => '',
			"title_color"      => '',
			"title_bg_color"   => '',
			"title_padding"    => '',
			"desc_padding"     => '',
			"link"             => '',
			//"des" => '',
			"icon_type"        => '',
			"icon"             => '',
			"icon_url"         => '',
			"icon_width"       => '',
			"icon_height"      => '',

			"icon_margin"  => '',
			"icon_padding" => '',

			"icon_size"         => '',
			"icon_color"        => '',
			"icon_bg_color"     => '',
			"icon_border"       => '',
			"icon_border_color" => '',
			"icon_radius"       => '',
			"icon_position"     => '',
			"icon_effect"       => '',
			"icon_eff_color"    => '',
		), $atts ) );

		/* 
		* support effect: icon-effect-1, icon-effect-2, icon-effect-3
		*/
		$array = array(
			'icon-effect-1' => 'first',
			'icon-effect-2' => 'second',
			'icon-effect-3' => 'third',
			'icon-effect-4' => 'fourth',
			// 'icon-effect-5' => 'fifth',
			// 'icon-effect-6' => 'sixth',
			// 'icon-effect-7' => 'seventh',
			// 'icon-effect-8' => 'eighth'
		);

		$post_id = get_the_ID();
		$post    = get_post( $post_id );

		self::$intID ++;
		$tp   = str_replace( "-", "_", $post->post_name );
		$slug = "ie_" . $tp . "_" . self::$intID;


		if ( $icon_effect && $icon_effect != "random" ) {
			$effect      = " " . array_search( $icon_effect, $array ) . " " . $slug;
			$effect_name = "." . array_search( $icon_effect, $array ) . "." . $slug;
		} else if ( $icon_effect && $icon_effect == "random" ) {
			$rand_keys   = array_rand( $array, 1 );
			$effect      = " " . $rand_keys . " " . $slug;
			$effect_name = "." . $rand_keys . "." . $slug;
		} else {
			$effect = "";
		}

		if ( $icon_position != "top" ) {
			if ( ! $icon_type ) {// font awesome
				if ( $icon_size || $icon_border || $icon_width ) {
					if ( $icon_width ) {
						$width = intval( $icon_width );
					} else {
						$width = 0;
					}

					$icon_size_temp = $width + ( $icon_size ? intval( $icon_size ) : 20 ) + intval( $icon_border ) + 20;
					$width_content  = ' style="width: calc(100% - ' . $icon_size_temp . 'px);"';
				} else {
					$width_content = ' style="width: calc(100% - 40px);"';
				}
			} else {// custom image
				if ( $icon_url || $icon_border ) {
					if ( $icon_url ) {
						if ( $icon_width ) {
							$width = intval( $icon_width );
						} else {
							$data  = getimagesize( $icon_url );
							$width = intval( $data[0] );
						}
					} else {
						$width = 0;
					}


					$icon_size_temp = $width + intval( $icon_border ) + 20;
					$width_content  = ' style="width: calc(100% - ' . $icon_size_temp . 'px);"';
				} else {
					$width_content = ' style="width: calc(100% - 40px);"';
				}

			}
		} else {
			$width_content = "";
		}

		$icon_position = " icon_" . $icon_position;

		if ( $box_border ) {
			$box_border = "border:" . $box_border . "px;border-style: solid;";
		}
		if ( $box_border_color ) {
			$box_border_color = "border-color:" . $box_border_color . ";";
		}
		if ( $box_bg_color ) {
			$box_bg_color = "background:" . $box_bg_color . ";";
		}
		if ( $box_border || $box_border_color || $box_bg_color ) {
			$css = ' style="' . $box_border . $box_border_color . $box_bg_color . '"';
		} else {
			$css = "";
		}

		$temp = '<div class="icon_box' . $icon_position . $effect . '"' . $css . '>';
		if ( $link ) {
			$temp .= '<a href="' . $link . '">';
		}
		if ( $icon || $icon_url ) {
			if ( $icon_size ) {
				$icon_size = "font-size:" . $icon_size . "px;";
			}
			if ( $icon_color ) {
				$icon_color = "color:" . $icon_color . ";";
			}
			if ( $icon_bg_color ) {
				$icon_bg_color = "background:" . $icon_bg_color . ";";
			}
			if ( $icon_radius ) {
				$radius = explode( " ", $icon_radius );
				if ( is_numeric( $radius[0] ) ) {
					$icon_radius = "border-radius:" . $icon_radius . "px;";
				} else {
					$icon_radius = "border-radius:" . $icon_radius . ";";
				}
			}
			if ( $icon_border ) {
				$icon_border = "border:" . $icon_border . "px;border-style: solid;";
			}
			if ( $icon_border_color ) {
				$icon_border_color = "border-color:" . $icon_border_color . ";";
			}

			$padding_temp = "";
			// if ($icon_padding != "") {
			// 	$padding = explode(" ", $icon_padding);
			// 	if ($padding[0] != "" && $padding[0] != 0) {
			// 		if (is_numeric($padding[0])) {
			// 			$padding_temp .= $padding[0]."px";
			// 		}else {
			// 			$padding_temp .= $padding[0];
			// 		}
			// 	}

			// 	$padding_temp = "padding: ".$padding_temp.";";
			// }

			$css_p       = "";
			$margin_temp = "";
			// if ($icon_margin != "") {
			// 	$margin = explode(" ", $icon_margin);
			// 	if ($margin[0] != "" && $margin[0] != 0) {
			// 		if (is_numeric($margin[0])) {
			// 			$margin_temp .= $margin[0]."px";
			// 		}else {
			// 			$margin_temp .= $margin[0];
			// 		}
			// 	}else {
			// 		$margin_temp .= "0";
			// 	}

			// 	if ($margin[1] != "" && $margin[1] != 0) {
			// 		if (is_numeric($margin[1])) {
			// 			$margin_temp .= " ".$margin[1]."px";
			// 		}else {
			// 			$margin_temp .= " ".$margin[1];
			// 		}
			// 	}else {
			// 		$margin_temp .= " 0";
			// 	}

			// 	if ($margin[2] != "" && $margin[2] != 0) {
			// 		if (is_numeric($margin[2])) {
			// 			$margin_temp .= " ".$margin[2]."px";
			// 		}else {
			// 			$margin_temp .= " ".$margin[2];
			// 		}
			// 	}else {
			// 		$margin_temp .= " 0";
			// 	}

			// 	if ($margin[3] != "" && $margin[3] != 0) {
			// 		if (is_numeric($margin[3])) {
			// 			$margin_temp .= " ".$margin[3]."px";
			// 		}else {
			// 			$margin_temp .= " ".$margin[3];
			// 		}
			// 	}else {
			// 		$margin_temp .= " 0";
			// 	}

			// 	$margin_temp = "margin: ".$margin_temp.";";
			// }
			// if ($margin_temp) {
			// 	$css_p = ' style="'.$margin_temp.'"';
			// }else $css_p = "";

			$icon_wh = "";
			// if(!$icon_type) {
			if ( $icon_width ) {
				$icon_width = " width:" . $icon_width . "px;";
			}
			if ( $icon_height ) {
				$icon_height = " height:" . $icon_height . "px;";
			}
			if ( $icon_width || $icon_height ) {
				$icon_wh = $icon_width . $icon_height;
			}
			// }

			if ( $icon_size || $icon_color || $icon_bg_color || $icon_radius || $icon_border || $icon_border_color || $padding_temp || $icon_wh ) {
				$css = ' style="' . $icon_size . $icon_color . $icon_bg_color . $icon_radius . $icon_border . $icon_border_color . $padding_temp . $icon_wh . '"';
			} else {
				$css = "";
			}

			$temp .= '<div class="ib_icon"' . $css_p . '>';
			if ( $icon_type ) {
				$temp .= '<img src="' . $icon_url . '"' . $css . '>';
			} else {
				$temp .= '<i class="' . $icon . '"' . $css . '></i>';
			}
			$temp .= '</div>';
		}

		if ( $title || $content ) {
			$temp .= '<div class="ib_content"' . $width_content . '>';
			if ( $title ) {
				if ( $title_color ) {
					$title_color = "color:" . $title_color . ";";
				}
				if ( $title_bg_color ) {
					$title_bg_color = "background:" . $title_bg_color . ";";
				}
				$padding_temp = "";
				if ( $title_padding != "" ) {
					$padding = explode( " ", $title_padding );
					if ( $padding[0] != "" && $padding[0] != 0 ) {
						if ( is_numeric( $padding[0] ) ) {
							$padding_temp .= $padding[0] . "px";
						} else {
							$padding_temp .= $padding[0];
						}
					}

					$padding_temp = "padding: " . $padding_temp . ";";
				}
				if ( $title_color || $title_bg_color || $padding_temp ) {
					$css = ' style="' . $title_color . $title_bg_color . $padding_temp . '"';
				} else {
					$css = "";
				}

				if ( $title_size != "" ) {
					$temp .= '<h' . $title_size . ' class="ib_title"' . $css . '>' . $title . '</h' . $title_size . '>';
				} else {
					$temp .= '<h2 class="ib_title"' . $css . '>' . $title . '</h2>';
				}
			}
			if ( $content ) {
				$padding_temp = "";
				if ( $desc_padding != "" ) {
					$padding = explode( " ", $desc_padding );
					if ( $padding[0] != "" && $padding[0] != 0 ) {
						if ( is_numeric( $padding[0] ) ) {
							$padding_temp .= $padding[0] . "px";
						} else {
							$padding_temp .= $padding[0];
						}
					}

					$padding_temp = "padding: " . $padding_temp . ";";
				}
				if ( $title_color || $title_bg_color || $padding_temp ) {
					$css = ' style="' . $padding_temp . '"';
				} else {
					$css = "";
				}
				$temp .= '<div class="ib_description"' . $css . '>' . do_shortcode( $content ) . '</div>';
			}
			$temp .= '</div>';
		}
		if ( $link ) {
			$temp .= '</a>';
		}
		$temp .= '</div>';

		if ( $effect ) {
			if ( ! $icon_radius ) {
				$icon_radius = 'border-radius: inherit;';
			}
			if ( $icon_eff_color ) {
				$main_color = $icon_eff_color;
			} else {
				$main_color = "#000";
			}
			$style_icon = '<style>' . $effect_name . ' i {background: ' . $main_color . ';}' . $effect_name . ' i:after {' . $icon_radius . 'box-shadow: 0 0 0 4px ' . $main_color . ';}</style>';
		} else {
			$style_icon = '';
		}
		$temp .= $style_icon;

		return $temp;
	}

	/* Contact Box*/
	function box_contact( $atts, $content = null ) {

		extract( shortcode_atts( array(
			"line1"      => '',
			"line2"      => '',
			"line3"      => '',
			"background" => ''
		), $atts ) );

		if ( $background != '' ) {
			$background = 'style="background:' . $background . '"';
		}

		$sr_contact_box = '<div class="contact-details" ' . $background . '>';
		$sr_contact_box .= '<h2>' . $email . '</h2>';
		$sr_contact_box .= '<h1>' . $telephone . '</h1>';
		$sr_contact_box .= '<h2>' . $address . '</h2>';
		$sr_contact_box .= '</div>';

		return $sr_contact_box;

	}

	/* Video */
	function video( $atts ) {
		extract( shortcode_atts( array(
			'type'     => '',
			'id'       => '',
			'autoplay' => '',
			'width'    => '',
			'height'   => ''
		), $atts ) );

		if ( $height && ! $width ) {
			$width = intval( $height * 16 / 9 );
		}
		if ( ! $height && $width ) {
			$height = intval( $width * 9 / 16 );
		}
		if ( ! $height && ! $width ) {
			$height = 315;
			$width  = 560;
		}

		$autoplay = ( $autoplay == 'yes' ? '1' : false );

		if ( $type == "vimeo" ) {
			$rnr_video = "<div class='video-embed'><iframe src='http://player.vimeo.com/video/$id?autoplay=$autoplay&amp;title=0&amp;byline=0&amp;portrait=0' width='$width' height='$height' class='iframe'></iframe></div>";
		} else {
			$rnr_video = "<div class='video-embed'><iframe src='http://www.youtube.com/embed/$id?autoplay=$autoplay;HD=1;rel=0;showinfo=0' width='$width' height='$height' class='iframe'></iframe></div>";
		}

		if ( ! empty( $id ) ) {
			return $rnr_video;
		}
	}

	function carousel( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'btn_top'      => '',
			'btn_bottom'   => '',
			'btn_sides'    => '',
			'pag_position' => '',

			'auto_play' => '',
			'item_view' => '',
		), $atts ) );
		$temp    = "";
		$post_id = get_the_ID();
		$post    = get_post( $post_id );

		self::$intID ++;
		$tp   = str_replace( "-", "_", $post->post_name );
		$slug = "owl_" . $tp . "_" . self::$intID;
		$sla  = $post->post_name;

		$btn_custom = "";

		if ( $btn_top ) {
			$temp .= '<div class="arrows">';
			$temp .= '<span class="back"><i class="fa fa-angle-left"></i></span> <span class="next"><i class="fa fa-angle-right"></i></span>';
			$temp .= '</div>';

			$btn_custom .= 'var $pagination_top_' . $slug . ' = $("#' . $slug . '").prev(".arrows"),
				$next_top_' . $slug . ' = $pagination_top_' . $slug . '.find(".next"),
				$back_top_' . $slug . ' = $pagination_top_' . $slug . '.find(".back");

			$next_top_' . $slug . '.click(function () {

				' . $slug . '.trigger("owl.next");
			});
			$back_top_' . $slug . '.click(function () {
				' . $slug . '.trigger("owl.prev");
			});
			';
		}
		$temp .= '<div id="' . $slug . '">';
		$temp .= do_shortcode( $content );
		$temp .= '</div>';
		if ( $btn_bottom ) {
			$temp .= '<div class="arrows">';
			$temp .= '<span class="back"><i class="fa fa-angle-left"></i></span> <span class="next"><i class="fa fa-angle-right"></i></span>';
			$temp .= '</div>';

			$btn_custom .= 'var $pagination_bottom_' . $slug . ' = $("#' . $slug . '").next(".arrows"),
				$next_bottom_' . $slug . ' = $pagination_bottom_' . $slug . '.find(".next"),
				$back_bottom_' . $slug . ' = $pagination_bottom_' . $slug . '.find(".back");

			$next_bottom_' . $slug . '.click(function () {

				' . $slug . '.trigger("owl.next");
			});
			$back_bottom_' . $slug . '.click(function () {
				' . $slug . '.trigger("owl.prev");
			});
			';
		}


		if ( ! isset( $GLOBALS[ $slug ] ) ) {
			$GLOBALS[ $slug ] = $slug;

			$carousel_config = 'itemsDesktop : [1000,2], itemsDesktopSmall : [900,1], itemsTablet: [600,1], itemsMobile : false,slideSpeed : 300,paginationSpeed : 400';
			if ( $item_view == "" || $item_view == 1 ) {
				$carousel_config .= ',singleItem: true';
			} else {
				$carousel_config .= ",items: $item_view";
			}
			if ( $auto_play ) {
				$carousel_config .= ",autoPlay: true";
			} else {
				$carousel_config .= ",autoPlay: false";
			}

			if ( ! $pag_position ) {
				$carousel_config .= ",pagination: false";
			} else {
				$carousel_config .= ",pagination: true";
			}
			if ( $pag_position == "top" ) {
				$carousel_config .= ",afterInit : function(elem){var that = this; that.owlControls.prependTo(elem);}";
			}
			if ( $btn_sides ) {
				$carousel_config .= ",navigation: true,navigationText: [\"<i class='fa fa-angle-left'></i>\",\"<i class='fa fa-angle-right'></i>\"]";
			}

			$carousel_config = "{" . $carousel_config . "}";

			$temp .= '<script type="text/javascript">
					jQuery(document).ready(function($){
						var ' . $slug . ' = $("#' . $slug . '");
						' . $slug . '.owlCarousel(' . $carousel_config . ');
					' . $btn_custom . '
					});               
					</script>';

		}

		return $temp;
	}

	function carousel_item( $atts, $content = null ) {
		$temp = '<div class="item">';
		$temp .= do_shortcode( $content );
		$temp .= '</div>';

		return $temp;
	}

	function text_block( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'css_animation' => ''
		), $atts ) );

		if ( $css_animation ) {
			$css_animation = ' class= "' . $this->getCSSAnimation( $css_animation ) . '"';
		}

		return '<div' . $css_animation . '>' . do_shortcode( $content ) . '</div>';
	}
}

new FITSC_Frontend;

/**** ****/
function gcd( $a, $b ) {
	$a = abs( $a );
	$b = abs( $b );
	if ( $a < $b ) {
		list( $b, $a ) = Array( $a, $b );
	}
	if ( $b == 0 ) {
		return $a;
	}
	$r = $a % $b;
	while ( $r > 0 ) {
		$a = $b;
		$b = $r;
		$r = $a % $b;
	}

	return $b;
}

function simplify( $num, $den ) {
	$g = gcd( $num, $den );

	return Array( $num / $g, $den / $g );
}