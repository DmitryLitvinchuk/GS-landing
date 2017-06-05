<?php
/* portfolio Custom Post Type */


function portfolio_register() {

	global $smof_data;

	$labels = array(
		'name'               => __( 'Portfolio', 'squareroot' ),
		'singular_name'      => __( 'Portfolio Item', 'squareroot' ),
		'add_new'            => __( 'Add New Item', 'squareroot' ),
		'add_new_item'       => __( 'Add New Portfolio Item', 'squareroot' ),
		'edit_item'          => __( 'Edit Portfolio Item', 'squareroot' ),
		'new_item'           => __( 'Add New Portfolio Item', 'squareroot' ),
		'view_item'          => __( 'View Item', 'squareroot' ),
		'search_items'       => __( 'Search Portfolio', 'squareroot' ),
		'not_found'          => __( 'No portfolio items found', 'squareroot' ),
		'not_found_in_trash' => __( 'No portfolio items found in trash', 'squareroot' )
	);

	$args = array(
		'labels'          => $labels,
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'rewrite'         => array( 'slug' => 'portfolio-item' ),
		'supports'        => array( 'title', 'editor', 'thumbnail', 'comments' )
	);

	register_post_type( 'portfolio', $args );
}

register_taxonomy(
	'portfolio_filter', 'portfolio',
	array(
		'hierarchical' => true,
		'labels'       => array(
			'name'                       => __( 'Portfolio Categories', 'squareroot' ),
			'singular_name'              => __( 'Portfolio Category', 'squareroot' ),
			'search_items'               => __( 'Search Portfolio Categories', 'squareroot' ),
			'popular_items'              => __( 'Popular Portfolio Categories', 'squareroot' ),
			'all_items'                  => __( 'All Portfolio Categories', 'squareroot' ),
			'edit_item'                  => __( 'Edit Portfolio Category', 'squareroot' ),
			'update_item'                => __( 'Update Portfolio Category', 'squareroot' ),
			'add_new_item'               => __( 'Add New Portfolio Category', 'squareroot' ),
			'new_item_name'              => __( 'New Portfolio Category Name', 'squareroot' ),
			'separate_items_with_commas' => __( 'Separate Portfolio Categories With Commas', 'squareroot' ),
			'add_or_remove_items'        => __( 'Add or Remove Portfolio Categories', 'squareroot' ),
			'choose_from_most_used'      => __( 'Choose From Most Used Portfolio Categories', 'squareroot' ),
			'parent'                     => __( 'Parent Portfolio Category', 'squareroot' )
		),
		'query_var'    => true,
		'rewrite'      => true
	)
);

/**
 * Add Columns to Portfolio Edit Screen
 * http://wptheming.com/2010/07/column-edit-pages/
 */

function portfolio_edit_columns( $portfolio_columns ) {
	$portfolio_columns = array(
		"cb"        => "<input type=\"checkbox\" />",
		"title"     => __( 'Title', 'squareroot' ),
		"thumbnail" => __( 'Thumbnail', 'squareroot' ),
		"author"    => __( 'Author', 'squareroot' ),
		"date"      => __( 'Date', 'squareroot' ),
	);

	return $portfolio_columns;
}

function portfolio_column_display( $portfolio_columns, $post_id ) {

	// Code from: http://wpengineer.com/display-post-thumbnail-post-page-overview

	switch ( $portfolio_columns ) {

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
				echo __( 'None', 'squareroot' );
			}
			break;

		// Display the portfolio tags in the column view
		case "portfolio_filter":

			if ( $category_list = get_the_term_list( $post_id, 'portfolio_filter', '', ', ', '' ) ) {
				echo $category_list;
			} else {
				echo __( 'None', 'squareroot' );
			}
			break;
	}
}

// Adds Custom Post Type
add_action( 'init', 'portfolio_register' );

// Adds columns in the admin view for thumbnail and taxonomies
add_filter( 'manage_edit-portfolio_columns', 'portfolio_edit_columns' );
add_action( 'manage_posts_custom_column', 'portfolio_column_display', 10, 2 );