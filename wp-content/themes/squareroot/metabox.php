<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */


add_filter( 'rwmb_meta_boxes', 'squareroot_register_meta_boxes' );

/**
 * Register meta boxes
 *
 * @return array
 */
function squareroot_register_meta_boxes( $meta_boxes ) {
	/**
	 * Prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	$prefix = '';

	// Template Page Portfolio Setting
	$cat_name = array();
	$cats     = get_terms( 'portfolio_filter' );

	if ( count( $cats ) > 0 ) {
		foreach ( $cats as $cat ) {
			$cat_name[ $cat->term_id ] = $cat->name;
		}
	}

	/* ----------------------------------------------------- */
	// portfolio Settings
	/* ----------------------------------------------------- */
	$meta_boxes[] = array(
		'id'         => 'portfoliosettings',
		'title'      => 'Page Settings',
		'pages'      => array( 'page' ),
		'context'    => 'normal',
		'priority'   => 'high',

		// List of meta fields

		// List of meta fields
		'fields'     => array(
			// CHECKBOX
			array(
				'name' => __( 'Open as a Separate Page', 'squareroot' ),
				'id'   => "{$prefix}rnr_separate_page",
				'type' => 'checkbox',
				// Value can be 0 or 1
				'std'  => 0,
			),
			// CHECKBOX
			array(
				'name' => __( 'Disable section from menu', 'squareroot' ),
				'id'   => "{$prefix}rnr_disable_section_from_menu",
				'type' => 'checkbox',
				// Value can be 0 or 1
				'std'  => 0,
			),
			// SELECT BOX
			array(
				'name'        => __( 'Assign current page as', 'squareroot' ),
				'id'          => "{$prefix}rnr_assign_type",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => array(
					'home-section'       => __( 'Home Section', 'squareroot' ),
					'parallax-section'   => __( 'Parallax Section', 'squareroot' ),
					'portfolio-section'  => __( 'Portfolio Section', 'squareroot' ),
					'portfolio2-section' => __( 'Portfolio2 Section', 'squareroot' ),
					'portfolio3-section' => __( 'Portfolio3 Section', 'squareroot' ),
					'resume-section'     => __( 'Resume Section', 'squareroot' ),
					'blog-section'       => __( 'Blog Section', 'squareroot' ),
					'contact-section'    => __( 'Contact Section', 'squareroot' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'select',
				'placeholder' => __( 'Select a Section', 'select' ),
			),
			// HIDDEN
			array(
				'id'   => "{$prefix}hidden",
				'type' => 'hidden',
				// Hidden field must have predefined value
				'std'  => __( 'Hidden value', 'squareroot' ),
			),
			array(
				'name'     => __( 'Portfolio Categories', 'squareroot' ),
				'id'       => "{$prefix}portfolio_section_category_portfolio",
				'type'     => 'select',
				'desc'     => 'Leave empty if you want to get all.',
				'multiple' => true,
				'options'  => $cat_name,
			),
			array(
				'name' => __( 'Number', 'squareroot' ),
				'id'   => "{$prefix}portfolio_section_number_por",
				'type' => 'number',
				'desc' => 'Number of portfolios. This will override number in Settings',
				'min'  => 0,
			),
			// HIDDEN
			array(
				'id'   => "{$prefix}hidden",
				'type' => 'hidden',
				// Hidden field must have predefined value
				'std'  => __( 'Hidden value', 'squareroot' ),
			),
			array(
				'name'       => __( 'Blog Categories', 'squareroot' ),
				'id'         => "{$prefix}blog_section_categories",
				'type'       => 'taxonomy_advanced',
				// Can this be cloned?
				'clone'      => false,
				// Taxonomy name
				'taxonomy'   => 'category',
				// How to show taxonomy: 'checkbox_list' (default) or 'checkbox_tree', 'select_tree', select_advanced or 'select'. Optional
				'field_type' => 'checkbox_tree',
				// Additional arguments for get_terms() function. Optional
				'query_args' => array(),
				'desc'       => __( 'Select blog categories', 'squareroot' ),
				'class'      => 'thim_mtb_blog_section_setting',
			),
			array(
				'name'       => __( 'Resume Categories', 'squareroot' ),
				'id'         => "{$prefix}resume_section_categories",
				'type'       => 'taxonomy_advanced',
				// Can this be cloned?
				'clone'      => false,
				// Taxonomy name
				'taxonomy'   => 'resume_filter',
				// How to show taxonomy: 'checkbox_list' (default) or 'checkbox_tree', 'select_tree', select_advanced or 'select'. Optional
				'field_type' => 'checkbox_tree',
				// Additional arguments for get_terms() function. Optional
				'query_args' => array(),
				'desc'       => __( 'Select resume categories', 'squareroot' ),
				'class'      => 'thim_mtb_resume_section_setting',
			),
			array(
				'name' => __( 'Number', 'squareroot' ),
				'id'   => "{$prefix}blog_section_number_por",
				'type' => 'number',
				'desc' => 'Number of blog.',
				'min'  => 2,
			),
			// COLOR
			// array(
			// 	'name' => __( 'Background Color', 'squareroot' ),
			// 	'id'   => "{$prefix}full-color",
			// 	'type' => 'color',
			// ),
			array(
				'name' => __( 'Margin Top', 'squareroot' ),
				'id'   => "{$prefix}margin_top",
				'type' => 'number',
				'desc' => 'Margin top of this section. The value must be greater than or equal 0.',
				'min'  => 0,
			),
			array(
				'name' => __( 'Margin Bottom', 'squareroot' ),
				'id'   => "{$prefix}margin_bottom",
				'type' => 'number',
				'desc' => 'Margin Bottom of this section. The value must be greater than or equal 0.',
				//'std'  => 40,
				'min'  => 0,
			),
			array(
				'name' => __( 'Padding Top', 'squareroot' ),
				'id'   => "{$prefix}padding_top",
				'type' => 'number',
				'desc' => 'Padding top of this section. The value must be greater than or equal 0.',
				'min'  => 0,
			),
			array(
				'name' => __( 'Padding Bottom', 'squareroot' ),
				'id'   => "{$prefix}padding_bottom",
				'type' => 'number',
				'desc' => 'Padding Bottom of this section. The value must be greater than or equal 0.',
				//'std'  => 40,
				'min'  => 0,
			),
		),
		'validation' => array(
			'rules'    => array(
				"{$prefix}password" => array(
					'required'  => true,
					'minlength' => 7,
				),
			),
			// optional override of default jquery.validate messages
			'messages' => array(
				"{$prefix}password" => array(
					'required'  => __( 'Password is required', 'squareroot' ),
					'minlength' => __( 'Password must be at least 7 characters', 'squareroot' ),
				),
			)
		)
	);

	/* ----------------------------------------------------- */
	/* Portfolio Post Type Metaboxes
	/* ----------------------------------------------------- */
	$meta_boxes[] = array(
		'id'      => 'portfolio_info',
		'title'   => 'Project Details',
		'pages'   => array( 'portfolio' ),
		'context' => 'normal',

		'fields' => array(
			array(
				'name'  => 'Project Title',
				'id'    => $prefix . 'project_client_name',
				'desc'  => 'Leave empty if you do not want to show this.',
				'clone' => false,
				'type'  => 'text',
				'std'   => ''
			),
			array(
				'name'  => 'Sub Title',
				'id'    => $prefix . 'project_client_sub_name',
				'desc'  => 'Leave empty if you do not want to show this.',
				'clone' => false,
				'type'  => 'text',
				'std'   => ''
			),
			array(
				'name'  => 'Project link',
				'id'    => $prefix . 'project_link',
				'desc'  => 'URL to the Project if available (Do not forget the http://)',
				'clone' => false,
				'type'  => 'text',
				'std'   => ''
			),
		)
	);

	/* ----------------------------------------------------- */
	// Project Slides Metabox
	/* ----------------------------------------------------- */
	$meta_boxes[] = array(
		'id'      => 'project_slides',
		'title'   => 'Project Image Slides',
		'pages'   => array( 'portfolio' ),
		'context' => 'normal',

		'fields' => array(
			// IMAGE ADVANCED (WP 3.5+)
			array(
				'name'             => 'Project Slider Images',
				'desc'             => 'Upload up to 20 project images for a slideshow - or only one to display a single image. <br /><br /><strong>Notice:</strong> The Preview Image will be the Image set as Featured Image.',
				'id'               => $prefix . 'project_item_slides',
				'type'             => 'image_advanced',
				'max_file_uploads' => 20,
			),

		)
	);
	/* ----------------------------------------------------- */
	// Project Video Metabox
	/* ----------------------------------------------------- */
	$meta_boxes[] = array(
		'id'      => 'project_video',
		'title'   => 'Project Video',
		'pages'   => array( 'portfolio' ),
		'context' => 'normal',

		'fields' => array(
			array(
				'name'     => 'Video Type',
				'id'       => $prefix . 'project_video_type',
				'type'     => 'select',
				'options'  => array(
					'youtube' => 'Youtube',
					'vimeo'   => 'Vimeo',
				),
				'multiple' => false,
				'std'      => array( 'no' )
			),
			array(
				'name' => 'Video URL or own Embedd Code<br />(Audio Embedd Code is possible, too)',
				'id'   => $prefix . 'project_video_embed',
				'desc' => 'Just paste the ID of the video (E.g. http://www.youtube.com/watch?v=<strong>GUEZCxBcM78</strong>) you want to show, or insert own Embed Code. <br />This will show the Video <strong>INSTEAD</strong> of the Image Slider.<br /><strong>Of course you can also insert your Audio Embedd Code!</strong><br /><br /><strong>Notice:</strong> The Preview Image will be the Image set as Featured Image..',
				'type' => 'textarea',
				'std'  => "",
				'cols' => "40",
				'rows' => "8"
			)
		)
	);

	/* ----------------------------------------------------- */
	// Post Format
	/* ----------------------------------------------------- */
	$meta_boxes[] = array(
		'title'  => __( 'Post Format: Image', 'squareroot' ),
		'id'     => 'montana-meta-box-post-format-image',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name'             => __( 'Image', 'squareroot' ),
				'id'               => 'image',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
			),
		),
	);
	$meta_boxes[] = array(
		'title'  => __( 'Post Format: Gallery', 'squareroot' ),
		'id'     => 'montana-meta-box-post-format-gallery',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => __( 'Images', 'squareroot' ),
				'id'   => 'images',
				'type' => 'image_advanced',
			),
		),
	);
	$meta_boxes[] = array(
		'title'  => __( 'Post Format: Video', 'squareroot' ),
		'id'     => 'montana-meta-box-post-format-video',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => __( 'Video URL or Embeded Code', 'squareroot' ),
				'id'   => 'video',
				'type' => 'textarea',
			),
		)
	);
	$meta_boxes[] = array(
		'title'  => __( 'Post Format: Audio', 'squareroot' ),
		'id'     => 'montana-meta-box-post-format-audio',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => __( 'Audio URL or Embeded Code', 'squareroot' ),
				'id'   => 'audio',
				'type' => 'textarea',
			),
		)
	);
	$meta_boxes[] = array(
		'title'  => __( 'Post Format: Quote', 'squareroot' ),
		'id'     => 'montana-meta-box-post-format-quote',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => __( 'Quote', 'squareroot' ),
				'id'   => 'quote',
				'type' => 'textarea',
			),
			array(
				'name' => __( 'Author', 'squareroot' ),
				'id'   => 'author',
				'type' => 'text',
			),
			array(
				'name' => __( 'Author URL', 'squareroot' ),
				'id'   => 'author_url',
				'type' => 'url',
			),
		)
	);
	$meta_boxes[] = array(
		'title'  => __( 'Post Format: Link', 'squareroot' ),
		'id'     => 'montana-meta-box-post-format-link',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => __( 'URL', 'squareroot' ),
				'id'   => 'url',
				'type' => 'url',
			),
			array(
				'name' => __( 'Text', 'squareroot' ),
				'id'   => 'text',
				'type' => 'text',
			),
		)
	);

	return $meta_boxes;
}

/* ----------------------------------------------------- */
// Post Format include
/* ----------------------------------------------------- */
add_action( 'admin_enqueue_scripts', 'squareroot_admin_script_meta_box' );

/**
 * Enqueue script for handling actions with meta boxes
 *
 * @return void
 * @since 1.0
 */
function squareroot_admin_script_meta_box() {
	$screen = get_current_screen();
	if ( ! in_array( $screen->post_type, array( 'post', 'page', 'portfolio' ) ) ) {
		return;
	}

	wp_enqueue_script( 'squareroot-meta-box', get_template_directory_uri() . '/js/admin/meta-boxes.js', array( 'jquery' ), '', true );
}