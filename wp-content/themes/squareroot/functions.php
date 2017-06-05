<?php
/**
 * Squareroot functions and definitions
 *
 * @package Squareroot
 */

define( 'HOME_URL', trailingslashit( home_url() ) );
define( 'THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'THEME_URL', trailingslashit( get_template_directory_uri() ) );
define( 'THEME_VERSION', '2.8' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( !isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

/* Add theme option panel */
require_once( 'admin/index.php' ); // load theme option panel


require_once( 'inc/class-tgm-plugin-activation.php' );
add_action( 'tgmpa_register', 'squareroot_register_required_plugins' );
function squareroot_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'     => 'Meta Box',
			'slug'     => 'meta-box',
			'required' => true,
		),

		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => true,
		),

		array(
			'name'     => 'Category Order and Taxonomy Terms Order',
			'slug'     => 'taxonomy-terms-order',
			'required' => true,
		),

		array(
			'name'     => 'Pricing Table Plus',
			'slug'     => 'pricing-table-plus',
			'source'   => get_template_directory() . '/inc/plugins/pricing-table-plus.zip',
			'required' => true,
		),

		array(
			'name'     => 'Resume Post Type',
			'slug'     => 'resume',
			'source'   => get_template_directory() . '/inc/plugins/resume.zip',
			'required' => true,
		)
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'tgmpa',
		// Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',
		// Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins',
		// Menu slug.
		'parent_slug'  => 'themes.php',
		// Parent menu slug.
		'capability'   => 'edit_theme_options',
		// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,
		// Show admin notices or not.
		'dismissable'  => true,
		// If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',
		// If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,
		// Automatically activate plugins after installation or not.
		'message'      => '',
		// Message to output right before the plugins table.


		'strings' => array(
			'page_title'                      => __( 'Install Required Plugins', 'squareroot' ),
			'menu_title'                      => __( 'Install Plugins', 'squareroot' ),
			'installing'                      => __( 'Installing Plugin: %s', 'squareroot' ),
			// %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'squareroot' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'university-wp'
			),
			// %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'university-wp'
			),
			// %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
				'university-wp'
			),
			// %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'university-wp'
			),
			// %1$s = plugin name(s).
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'university-wp'
			),
			// %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
				'university-wp'
			),
			// %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'university-wp'
			),
			// %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'university-wp'
			),
			// %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
				'university-wp'
			),
			// %1$s = plugin name(s).
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'university-wp'
			),
			'update_link'                     => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'university-wp'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'university-wp'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'squareroot' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'squareroot' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'squareroot' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'squareroot' ),
			// %1$s = plugin name(s).
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'squareroot' ),
			// %1$s = plugin name(s).
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'squareroot' ),
			// %s = dashboard link.
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'squareroot' ),

			'nag_type' => 'updated',
			// Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		),
	);

	tgmpa( $plugins, $config );
}

if ( !function_exists( 'squareroot_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function squareroot_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Squareroot, use a find and replace
		 * to change 'squareroot' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'squareroot', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'squareroot' ),
		) );

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery', 'video', 'audio', 'quote', 'link' ) );

		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'squareroot_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Enable support for HTML5 markup.
		add_theme_support( 'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
			'caption',
		) );
	}
endif; // squareroot_setup
add_action( 'after_setup_theme', 'squareroot_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function squareroot_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar A', 'squareroot' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer', 'squareroot' ),
		'id'            => 'footer',
		'description'   => 'Footer Widget Area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}

add_action( 'widgets_init', 'squareroot_widgets_init' );

/**
 * Enqueue the Open Sans font.
 */

global $squareroot_data;
if ( isset( $squareroot_data['google_body_font'] ) && isset( $squareroot_data['google_headings'] ) ) {
	$customfont  = '';
	$default     = array(
		'0',
	);
	$googlefonts = array(
		$squareroot_data['google_body_font'],
		$squareroot_data['google_headings'],
	);
	foreach ( $googlefonts as $googlefont ) {
		if ( !in_array( $googlefont, $default ) ) {
			$customfont = str_replace( ' ', '+', $googlefont ) . ':300,300italic,400,400italic,500,600,700,800|' . $customfont;
		}
	}
	if ( $customfont != "" ) {

		function google_fonts() {
			global $customfont;
			wp_enqueue_style( 'squareroot-googlefonts', '//fonts.googleapis.com/css?family=' . substr_replace( $customfont, '', - 1 ) );
		}

		add_action( 'wp_enqueue_scripts', 'google_fonts' );
	}
}

/**
 * Enqueue scripts and styles.
 */
function squareroot_scripts() {

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), THEME_VERSION );
	wp_enqueue_style( 'bootstrap', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css', array(), THEME_VERSION );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), THEME_VERSION );
	wp_enqueue_style( 'squareroot', get_template_directory_uri() . '/css/less/output.css', array(), THEME_VERSION );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'preloader', get_template_directory_uri() . '/js/main.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'owl.carousel.min', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'jquery.validate.min', get_template_directory_uri() . '/js/jquery.validate.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'magnific-popup.min', get_template_directory_uri() . '/js/magnific-popup.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'waypoints.min', get_template_directory_uri() . '/js/waypoints.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'jquery.isotope.min', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'jquery.parallax-1.1.3', get_template_directory_uri() . '/js/jquery.parallax-1.1.3.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'jquery.flexslider-min', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'SmoothScroll.min', get_template_directory_uri() . '/js/SmoothScroll.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'mapapi', 'https://maps.googleapis.com/maps/api/js?libraries=places&ver=2.1&key=AIzaSyC3_R8tINAZcTxbSkuQUIHhNRSqJ_aNQqo', array(), '', true );
	wp_enqueue_script( 'infobox', 'https://cdn.rawgit.com/googlemaps/v3-utility-library/master/infobox/src/infobox.js', array(), '', true );
	wp_enqueue_script( 'jsbootrap', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array(), '', true );
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '', true );

	wp_deregister_style( 'contact-form-7' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	}
}

add_action( 'wp_enqueue_scripts', 'squareroot_scripts' );

/**
 * Convert color from hex to rgb format
 *
 * @param $hex
 *
 * @return array
 */
function squareroot_hex2rgb( $hex ) {
	$hex = str_replace( "#", "", $hex );
	if ( strlen( $hex ) == 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}
	$rgb = array( $r, $g, $b );

	//return implode(",", $rgb); // returns the rgb values separated by commas
	return $rgb; // returns an array with the rgb values
}

/**
 * Limit the words number in a post in posts listing page
 *
 * @param $limit
 *
 * @return array|mixed|string
 */

function excerpt( $limit ) {
	$content = get_the_excerpt();
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );
	$content = explode( ' ', $content, $limit );
	array_pop( $content );
	$content = implode( " ", $content );
	$content = '<div class="excerpt">' . $content . '</div>';

	return $content;
}

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
//require get_template_directory() . '/inc/jetpack.php';

/* custom menu */

class squareroot_description_walker extends Walker_Nav_Menu {
	function start_el( &$output, $object, $depth = 0, $args = Array(), $current_object_id = 0 ) {
		global $wp_query;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes    = empty( $object->classes ) ? array() : (array) $object->classes;
		$icon_class = $classes[0];
		$classes    = array_slice( $classes, 1 );

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$attributes = !empty( $object->attr_title ) ? ' title="' . esc_attr( $object->attr_title ) . '"' : '';
		$attributes .= !empty( $object->target ) ? ' target="' . esc_attr( $object->target ) . '"' : '';
		$attributes .= !empty( $object->xfn ) ? ' rel="' . esc_attr( $object->xfn ) . '"' : '';

		if ( $icon_class != '' ) {
			$icon_classes = '<i class="fa-fw fa ' . $icon_class . '"></i>';
		} else {
			$icon_classes = '';
		}
		if ( $object->object == 'page' ) {
			$varpost         = get_post( $object->object_id );
			$separate_page   = get_post_meta( $object->object_id, "rnr_separate_page", true );
			$disable_menu    = get_post_meta( $object->object_id, "rnr_disable_section_from_menu", true );
			$current_page_id = get_option( 'page_on_front' );

			if ( ( $disable_menu != true ) && ( $varpost->ID != $current_page_id ) ) {
				$output .= $indent . '<li id="menu-item-' . $object->ID . '"' . $value . $class_names . '>';
				if ( $separate_page == true ) {
					$attributes .= !empty( $object->url ) ? ' href="' . esc_attr( $object->url ) . '"' : '';
				} else {
					if ( is_front_page() ) {
						$attributes .= ' href="#' . $varpost->post_name . '"';
					} else {
						$attributes .= ' href="' . home_url() . '#' . $varpost->post_name . '"';
					}
				}
				$object_output = $args->before;
				$object_output .= '<a' . $attributes . '>';
				$object_output .= $args->link_before . $icon_classes . '<span>' . apply_filters( 'the_title', $object->title, $object->ID ) . '</span>';
				$object_output .= $args->link_after;
				$object_output .= '</a>';
				$object_output .= $args->after;

				$output .= apply_filters( 'walker_nav_menu_start_el', $object_output, $object, $depth, $args );
			}
		} else {
			$output .= $indent . '<li id="menu-item-' . $object->ID . '"' . $value . $class_names . '>';

			$attributes .= !empty( $object->url ) ? ' href="' . esc_attr( $object->url ) . '"' : '';

			$object_output = $args->before;
			$object_output .= '<a' . $attributes . '>';
			$object_output .= $args->link_before . $icon_classes . '<span>' . apply_filters( 'the_title', $object->title, $object->ID ) . '</span>';
			$object_output .= $args->link_after;
			$object_output .= '</a>';
			$object_output .= $args->after;
			$output        .= apply_filters( 'walker_nav_menu_start_el', $object_output, $object, $depth, $args );
		}
	}
}

/*using meta box*/
include 'metabox.php';

/* custom header */
include_once get_template_directory() . '/inc/custom-style.php';

require_once( get_template_directory() . '/inc/plugins/fitwp-shortcodes/fitwp-shortcodes.php' );

//include_once( get_template_directory() . '/inc/resume-post-type.php' );
include_once( get_template_directory() . '/inc/portfolio-post-type.php' ); // Portfolio Post Type


/** Register Scripts. */
add_action( 'wp_enqueue_scripts', 'squareroot_register_scripts', 1 );
function squareroot_register_scripts() {

	/** Register JavaScript Functions File */
	wp_register_script( 'functions-js', esc_url( trailingslashit( get_template_directory_uri() ) . 'js/function.js' ), array( 'jquery' ), '1.0', true );

	/** Localize Scripts */
	$php_array = array( 'admin_ajax' => admin_url( 'admin-ajax.php' ) );
	wp_localize_script( 'functions-js', 'php_array', $php_array );

}

/** Enqueue Scripts. */
add_action( 'wp_enqueue_scripts', 'squareroot_enqueue_scripts' );
function squareroot_enqueue_scripts() {

	/** Enqueue JavaScript Functions File */
	wp_enqueue_script( 'functions-js' );

}

add_action( 'wp_ajax_blog_init', 'squareroot_blog_init' );

add_action( 'wp_ajax_nopriv_blog_init', 'squareroot_blog_init' );

function squareroot_blog_init() {

	global $squareroot_data;

	if ( isset( $_POST['os'] ) ) {
		$offset = $_POST['os'];
	} else {
		$offset = 2;
	}

	$arr   = array();
	$count = $offset + 1;

	$haspost     = false;
	$step        = 2;
	$arr['data'] = "";

	query_posts( "posts_per_page=$step&offset=$offset" );

	if ( have_posts() ) : while ( have_posts() ) : the_post();
		$subtitle = '';
		if ( $count % 2 != 0 ) {
			$arr['data'] .= '<div class="group group-' . $count . ' clearfix">';
			$arr['data'] .= '<span class="date">' . get_the_time( $squareroot_data['date_format'] ) . '</span>';
			$arr['data'] .= '<span class="point-circle"></span>';
			$arr['data'] .= '<div class="desc-box blog-box">';
			if ( has_post_thumbnail() ) {
				$arr['data'] .= '<figure>';
				$arr['data'] .= '<a href="' . esc_url( get_the_permalink() ) . '">';
				$arr['data'] .= get_the_post_thumbnail();
				$arr['data'] .= '</a>';
				$arr['data'] .= '</figure>';
			}
			$arr['data'] .= '<div class="paddingme">';
			$arr['data'] .= '<h4>' . get_the_title() . '</h4>';
			$arr['data'] .= '<span class="sub-title">' . $subtitle . '</span>';
			$arr['data'] .= '<p>' . wp_trim_words( get_the_content(), $num_words = 30, $more = null ) . '</p>';
			$arr['data'] .= '<p><a href="' . esc_url( get_the_permalink() ) . '" class="read-more-link">' . esc_html__( 'Read More', 'squareroot' ) . '</a></p>';
			$arr['data'] .= '</div>';
			$arr['data'] .= '</div>';
			$arr['data'] .= '</div>';
		} else {
			$arr['data'] .= '<div class="group group-' . $count . ' group-alter clearfix">';
			$arr['data'] .= '<div class="desc-box blog-box">';
			if ( has_post_thumbnail() ) {
				$arr['data'] .= '<figure>';
				$arr['data'] .= '<a href="' . esc_url( get_the_permalink() ) . '">';
				$arr['data'] .= get_the_post_thumbnail();
				$arr['data'] .= '</a>';
				$arr['data'] .= '</figure>';
			}
			$arr['data'] .= '<div class="paddingme">';
			$arr['data'] .= '<h4>' . get_the_title() . '</h4>';
			$arr['data'] .= '<span class="sub-title">' . $subtitle . '</span>';
			$arr['data'] .= '<p>' . wp_trim_words( get_the_content(), $num_words = 30, $more = null ) . '</p>';
			$arr['data'] .= '<p><a href="' . esc_url( get_the_permalink() ) . '" class="read-more-link">' . esc_html__( 'Read More', 'squareroot' ) . '</a></p>';
			$arr['data'] .= '</div>';
			$arr['data'] .= '</div>';
			$arr['data'] .= '<span class="point-circle"></span>';
			$arr['data'] .= '<span class="date">' . get_the_time( $squareroot_data['date_format'] ) . '</span>';
			$arr['data'] .= '</div>';
		}
		$count ++;

		$haspost = true;
	endwhile; endif;

	if ( !$haspost ) {
		$arr['haspost'] = false;
	} else {
		$arr['haspost'] = true;
	}

	wp_send_json( $arr );

	exit;
}


add_action( 'wp_ajax_portfolio_init', 'squareroot_portfolio_init' );
add_action( 'wp_ajax_nopriv_portfolio_init', 'squareroot_portfolio_init' );
function squareroot_portfolio_init() {
	if ( isset( $_POST['os'] ) ) {
		$id = $_POST['os'];
	} else {
		exit;
	}
	$data = "";
	$link = "#";
	query_posts( array( 'post__in' => array( $id ), 'post_type' => 'portfolio' ) );
	if ( have_posts() ) : while ( have_posts() ) : the_post();
		$data          .= get_the_content();
		$link          = get_post_meta( $id, 'project_link', true );
		$project_title = get_post_meta( $id, 'project_client_name', true );
		$client        = get_post_meta( $id, 'project_client_sub_name', true );
		?>
		<div id="closeProject">
			<a href="javascript:void(0)" style="display: inline;"><i class="fa fa-times"></i></a>
		</div>
		<?php
		$slider_meta = get_post_meta( $id, 'project_item_slides', false );
		if ( !empty( $slider_meta ) ) {
			?>

			<?php global $wpdb, $post;
			if ( !is_array( $slider_meta ) ) {
				$slider_meta = ( array ) $slider_meta;
			}
			if ( !empty( $slider_meta ) ) {
				$slider_meta = implode( ',', $slider_meta );
				$images      = $wpdb->get_col( "
                                SELECT ID FROM $wpdb->posts
                                WHERE post_type = 'attachment'
                                AND ID IN ( $slider_meta )
                                ORDER BY menu_order ASC
                                " );
				$counter     = 0;
				foreach ( $images as $att ) {
					if ( $counter == 0 ) {
						echo '<div class="flexslider"><ul class="slides">';
					}
					// Get image's source based on size, can be 'thumbnail', 'medium', 'large', 'full' or registed post thumbnails sizes
					$image_src  = wp_get_attachment_image_src( $att, 'full' );
					$image_src2 = wp_get_attachment_image_src( $att, '' );
					$image_src  = $image_src[0];
					$image_src2 = $image_src2[0];
					// Show image
					echo '<li><img src="' . esc_url( $image_src ) . '"/></li>';
					$counter ++;
				}
				if ( $counter != 0 ) {
					echo '</ul></div>';
				}
			} ?>

			<?php
		} else {
			////
			if ( get_post_meta( get_the_ID(), 'project_video_type', true ) == 'vimeo' && get_post_meta( get_the_ID(), 'project_video_embed', true ) != "" ) {
				echo '<div id="portfolio-video"><iframe src="http://player.vimeo.com/video/' . get_post_meta( get_the_ID(), 'project_video_embed', true ) . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="920" height="540" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
			} else {
				if ( get_post_meta( get_the_ID(), 'project_video_type', true ) == 'youtube' && get_post_meta( get_the_ID(), 'project_video_embed', true ) != "" ) {
					echo '<div id="portfolio-video"><iframe width="920" height="540" src="http://www.youtube.com/embed/' . get_post_meta( get_the_ID(), 'project_video_embed', true ) . '" frameborder="0" allowfullscreen></iframe></div>';
				} else {
					if ( has_post_thumbnail() ) {
						the_post_thumbnail();
					}
				}
			}
		}
	endwhile; endif;

	echo '<h3><span><b>' . esc_html__( 'PROJECT DESCRIPTION', 'squareroot' ) . '</b></span></h3>';
	echo $data;
	echo '<div class="project-details"> <h3><span><b>' . esc_html__( 'PROJECT DETAILS', 'squareroot' ) . '</b></span></h3>';
	echo '<p><strong>' . esc_html__( 'Project:', 'squareroot' ) . '</strong> ' . $project_title . '</p>';
	echo '<p><strong>' . esc_html__( 'Client:', 'squareroot' ) . '</strong> ' . $client . '</p></div>';
	echo '<div class="pabutton"><a href="' . esc_url( $link ) . '" target="_blank" class="pbutton">' . esc_html__( 'View Project', 'squareroot' ) . '</a></div>';
	exit;
}

require_once( get_template_directory() . '/inc/post-formats.php' );

function squareroot_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract( $args, EXTR_SKIP );
	if ( 'div' == $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}
	?>
	<<?php echo $tag ?><?php comment_class( 'description_comment' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>">
	<?php endif; ?>
	<div class="des_blog">
		<div class="avatar"><?php
			if ( $args['avatar_size'] != 0 ) {
				echo get_avatar( $comment, $args['avatar_size'] );
			}
			?></div>
		<div class="comment_content">
			<?php printf( __( '<cite class="fn">%s</cite> <span>says:</span>', 'squareroot' ), get_comment_author_link() ) ?>
			<br />
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'squareroot' ) ?></em>
			<?php endif; ?>
			<div class="comment_date">
				<?php
				printf(/* __('%1$s at %2$s'), */
					get_comment_date(), get_comment_time() )
				?>
				<?php edit_comment_link( __( '(Edit)', 'squareroot' ), '', '' ); ?>

				<?php comment_reply_link( array_merge( $args, array(
					'add_below' => $add_below,
					'depth'     => $depth,
					'max_depth' => $args['max_depth']
				) ) ) ?>
			</div>


			<div class="comment_text"><?php comment_text() ?></div>
		</div>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
		</div>
	<?php endif; ?>
	<?php
}

/**
 * Function add Theme Options
 */
function squareroot_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array(
		'parent' => 'site-name',
		// use 'false' for a root menu, or pass the ID of the parent menu
		'id'     => 'smof_options',
		// link ID, defaults to a sanitized title value
		'title'  => __( 'Theme Options', 'squareroot' ),
		// link title
		'href'   => admin_url( 'themes.php?page=optionsframework' ),
		// name of file
		'meta'   => false
		// array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
	) );
}

add_action( 'wp_before_admin_bar_render', 'squareroot_admin_bar_render' );


/**
 * widget that act independently of the theme templates.
 */
require get_template_directory() . '/inc/widgets.php';

//oder by ID backend post
add_filter( 'get_the_categories', 'get_the_category_sort_by_id' );
function get_the_category_sort_by_id( $categories ) {
	usort( $categories, '_usort_terms_by_ID' );

	return $categories;
}


function get_custom_field( $field_name ) {
	return get_post_meta( get_the_ID(), $field_name, true );
}