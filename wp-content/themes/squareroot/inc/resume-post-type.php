<?php
/* resume Custom Post Type */


function resume_register() {

	global $smof_data;

	$labels = array(
		'name'               => __( 'Resume', 'rocknrolla' ),
		'singular_name'      => __( 'My Resume Item', 'rocknrolla' ),
		'add_new'            => __( 'Add New Item', 'rocknrolla' ),
		'add_new_item'       => __( 'Add New My Resume Item', 'rocknrolla' ),
		'edit_item'          => __( 'Edit My Resume Item', 'rocknrolla' ),
		'new_item'           => __( 'Add New My Resume Item', 'rocknrolla' ),
		'view_item'          => __( 'View Item', 'rocknrolla' ),
		'search_items'       => __( 'Search My Resume', 'rocknrolla' ),
		'not_found'          => __( 'No resume items found', 'rocknrolla' ),
		'not_found_in_trash' => __( 'No resume items found in trash', 'rocknrolla' )
	);

	$args = array(
		'labels'          => $labels,
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'rewrite'         => array( 'slug' => 'resume-item' ),
		'supports'        => array( 'title', 'editor', 'thumbnail', 'comments' )
	);

	register_post_type( 'resume', $args );
}

register_taxonomy(
	'resume_filter', 'resume',
	array(
		'hierarchical' => true,
		'labels'       => array(
			'name'                       => __( 'Resume Categories', 'rocknrolla' ),
			'singular_name'              => __( 'My Resume Category', 'rocknrolla' ),
			'search_items'               => __( 'Search My Resume Categories', 'rocknrolla' ),
			'popular_items'              => __( 'Popular My Resume Categories', 'rocknrolla' ),
			'all_items'                  => __( 'All My Resume Categories', 'rocknrolla' ),
			'edit_item'                  => __( 'Edit My Resume Category', 'rocknrolla' ),
			'update_item'                => __( 'Update My Resume Category', 'rocknrolla' ),
			'add_new_item'               => __( 'Add New My Resume Category', 'rocknrolla' ),
			'new_item_name'              => __( 'New My Resume Category Name', 'rocknrolla' ),
			'separate_items_with_commas' => __( 'Separate My Resume Categories With Commas', 'rocknrolla' ),
			'add_or_remove_items'        => __( 'Add or Remove My Resume Categories', 'rocknrolla' ),
			'choose_from_most_used'      => __( 'Choose From Most Used My Resume Categories', 'rocknrolla' ),
			'parent'                     => __( 'Parent My Resume Category', 'rocknrolla' )
		),
		'query_var'    => true,
		'rewrite'      => true
	)
);

/**
 * Add Columns to My Resume Edit Screen
 * http://wptheming.com/2010/07/column-edit-pages/
 */

function resume_edit_columns( $resume_columns ) {
	$resume_columns = array(
		"cb"        => "<input type=\"checkbox\" />",
		"title"     => __( 'Title', 'rocknrolla' ),
		"thumbnail" => __( 'Thumbnail', 'rocknrolla' ),
		"author"    => __( 'Author', 'rocknrolla' ),
		"date"      => __( 'Date', 'rocknrolla' ),
	);

	return $resume_columns;
}

function resume_column_display( $resume_columns, $post_id ) {

	// Code from: http://wpengineer.com/display-post-thumbnail-post-page-overview

	switch ( $resume_columns ) {

		// Display the thumbnail in the column view
		case "thumbnail":
			$width        = (int) 75;
			$height       = (int) 75;
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

			// Display the featured image in the column view if possible
			if ( $thumbnail_id ) {
				$thumb = wp_get_attachment_image( $thumbnail_id, array( $width, $height ), true );
			}
			if ( isset( $thumb ) ) {
				echo $thumb;
			} else {
				echo __( 'None', 'rocknrolla' );
			}
			break;

		// Display the resume tags in the column view
		case "resume_filter":

			if ( $category_list = get_the_term_list( $post_id, 'resume_filter', '', ', ', '' ) ) {
				echo $category_list;
			} else {
				echo __( 'None', 'rocknrolla' );
			}
			break;
	}
}

// Adds Custom Post Type
add_action( 'init', 'resume_register' );

// Adds columns in the admin view for thumbnail and taxonomies
add_filter( 'manage_edit-resume_columns', 'resume_edit_columns' );
add_action( 'manage_posts_custom_column', 'resume_column_display', 10, 2 );


add_post_type_support( 'resume', 'excerpt' );
add_post_type_support( 'resume', 'custom-fields' );
?>