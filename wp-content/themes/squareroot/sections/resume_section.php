<?php global $squareroot_data; ?>
<?php the_content(); ?>

<?php
global $post;
$rcats          = get_post_meta( get_the_ID(), 'resume_section_categories', true );
$rel_resume_ids = explode( ",", trim( $rcats, "," ) );

if ( $rcats ) {
	foreach ( $rel_resume_ids as $cat ) {

		$term = get_term_by( 'id', $cat, 'resume_filter' );

		echo '<div class="' . $term->name . ' timeline-cont clearfix">';
		echo '<span class="title"><strong>' . $term->name . '</strong></span>';
		// create a custom wordpress query
		$args = array(
			'post_type' => 'resume', // custom post type
			'tax_query' => array(
				array(
					'taxonomy' => 'resume_filter',
					'field'    => 'ID',
					'terms'    => $cat
				)
			)
		);
		query_posts( $args );

		$count = 1;

		// start the wordpress loop!
		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php
			//$date     = get_the_time( $squareroot_data['date_format'] );
			$date = get_post_meta( $post->ID, 'resume_date', true );
			if ( $date == '' ) {
				$date = get_the_time( $squareroot_data['date_format'] );
			} else {
				$date = get_post_meta( $post->ID, 'resume_date', true );
			}
			$taxonomy = strip_tags( get_the_term_list( $post->ID, 'resume_filter', '', ', ', '' ) );

			if ( $term->name == $taxonomy ) {
				if ( $count % 2 != 0 ) {
					echo '<div class="group group-' . $count . ' clearfix">';
					echo '<span class="date">' . $date . '</span>';
					echo '<span class="point-circle"></span>';

					echo '<div class="desc-box">';
					echo '<h4>' . get_the_title() . '</h4>';
					echo '<span class="sub-title">' . get_the_excerpt() . '</span>';
					echo '<p>' . get_the_content() . '</p>'; ?>

					<?php
					echo '</div>';
					echo '</div>';
				} else {
					echo '<div class="group group-' . $count . ' group-alter clearfix">';
					echo '<div class="desc-box">';
					echo '<h4>' . get_the_title() . '</h4>';
					echo '<span class="sub-title">' . get_the_excerpt() . '</span>';
					echo '<p>' . get_the_content() . '</p>';
					echo '</div>';
					echo '<span class="point-circle"></span>';
					echo '<span class="date">' . $date . '</span>';
					echo '</div>';
				}
				$count ++;

			}
			?>
		<?php endwhile; endif;
		wp_reset_query();// done our wordpress loop. Will start again for each category
		echo '</div>';
	}
} else {
	// get all the categories from the database
	$args = array(
		'taxonomy' => 'resume_filter',
	);

	$cats = get_categories( $args );
	foreach ( $cats as $cat ) {

		// setup the cateogory ID
		$cat_id = $cat->term_id;
		// Make a header for the cateogry
		echo '<div class="' . $cat->name . ' timeline-cont clearfix">';
		echo '<span class="title"><strong>' . $cat->name . '</strong></span>';
		// create a custom wordpress query

		query_posts( "post_type=resume&posts_per_page=-1" );
		$count = 1;

		// start the wordpress loop!
		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php
			$link_face     = get_post_meta( $post->ID, 'resume_facebook', true );
			$link_twitter  = get_post_meta( $post->ID, 'resume_twitter', true );
			$link_linkedin = get_post_meta( $post->ID, 'resume_linkedin', true );

			//$date     = get_the_time( $squareroot_data['date_format'] );
			$date = get_post_meta( $post->ID, 'resume_date', true );
			if ( $date == '' ) {
				$date = get_the_time( $squareroot_data['date_format'] );
			} else {
				$date = get_post_meta( $post->ID, 'resume_date', true );
			}

			$taxonomy = strip_tags( get_the_term_list( $post->ID, 'resume_filter', '', ', ', '' ) );

			if ( $cat->name == $taxonomy ) {
				if ( $count % 2 != 0 ) {
					echo '<div class="group group-' . $count . ' clearfix">';
					echo '<span class="date">' . $date . '</span>';
					echo '<span class="point-circle"></span>';

					echo '<div class="desc-box">';
					echo '<h4>' . get_the_title() . '</h4>';
					echo '<span class="sub-title">' . get_the_excerpt() . '</span>';
					echo '<p>' . get_the_content() . '</p>'; ?>

					<?php
					echo '</div>';
					echo '</div>';
				} else {
					echo '<div class="group group-' . $count . ' group-alter clearfix">';
					echo '<div class="desc-box">';
					echo '<h4>' . get_the_title() . '</h4>';
					echo '<span class="sub-title">' . get_the_excerpt() . '</span>';
					echo '<p>' . get_the_content() . '</p>';
					echo '</div>';
					echo '<span class="point-circle"></span>';
					echo '<span class="date">' . $date . '</span>';
					echo '</div>';
				}
				$count ++;

			}
			?>
		<?php endwhile; endif;
		wp_reset_query();// done our wordpress loop. Will start again for each category
		echo '</div>';
	}
} // done the foreach statement
// loop through the categries
?>
<?php if ( isset ( $count ) ) { ?>
	<div class="end-box clearfix">
		<span class="title end-of-box"><strong><?php esc_html_e( 'End', 'squareroot' ); ?></strong></span>
	</div>
<?php } ?>