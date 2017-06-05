<?php global $squareroot_data; ?>
<?php the_content(); ?>

<?php
$number_post = get_post_meta( get_the_ID(), 'blog_section_number_por', true );

$bcats        = get_post_meta( get_the_ID(), 'blog_section_categories', true );
$rel_blog_ids = explode( ",", trim( $bcats, "," ) );

if ( $bcats ) {
	// loop through the categries
	foreach ( $rel_blog_ids as $cat ) {
		// setup the cateogory ID
		//$cat_id = $cat->term_id;

		// Make a header for the cateogry
		echo '<div class="' . get_cat_name( $cat ) . ' timeline-cont clearfix" id="fblog">';
		echo '<span class="title"><strong>' . get_cat_name( $cat ) . '</strong></span>';
		// create a custom wordpress query
		query_posts( "cat=$cat&posts_per_page=$number_post" );

		$count = 1;

		// start the wordpress loop!
		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php // create our link now that the post is setup ?>
			<?php
			if ( ! empty( $post->post_excerpt ) ) :
				$subtitle = get_the_excerpt();
			else :
				$subtitle = "";
			endif;

			if ( $count % 2 != 0 ) {
				echo '<div class="group group-' . $count . ' clearfix">';
				echo '<span class="date">' . get_the_time( $squareroot_data['date_format'] ) . '</span>';
				echo '<span class="point-circle"></span>';

				echo '<div class="desc-box blog-box">';

				if ( has_post_thumbnail() ) {
					echo '<figure>';
					echo '<a href="' . esc_url( get_the_permalink() ) . '">';
					the_post_thumbnail();
					echo '</a>';
					echo '</figure>';
				}
				echo '<div class="paddingme">';
				echo '<h4>' . get_the_title() . '</h4>';
				echo '<span class="sub-title">' . $subtitle . '</span>';
				echo '<p>' . wp_trim_words( get_the_content(), $num_words = 30, $more = null ) . '</p>';
				echo '<p><a href="' . esc_url( get_the_permalink() ) . '" class="read-more-link">' . esc_html__( 'Read More', 'squareroot' ) . '</a></p>';
				echo '</div>';

				echo '</div>';
				echo '</div>';
			} else {
				echo '<div class="group group-' . $count . ' group-alter clearfix">';
				echo '<div class="desc-box blog-box">';

				if ( has_post_thumbnail() ) {
					echo '<figure>';
					echo '<a href="' . esc_url( get_the_permalink() ) . '">';
					the_post_thumbnail();
					echo '</a>';
					echo '</figure>';
				}

				echo '<div class="paddingme">';
				echo '<h4>' . get_the_title() . '</h4>';
				echo '<span class="sub-title">' . $subtitle . '</span>';
				echo '<p>' . wp_trim_words( get_the_content(), $num_words = 30, $more = null ) . '</p>';
				echo '<p><a href="' . esc_url( get_the_permalink() ) . '" class="read-more-link">' . esc_html__( 'Read More', 'squareroot' ) . '</a></p>';
				echo '</div>';

				echo '</div>';
				echo '<span class="point-circle"></span>';
				echo '<span class="date">' . get_the_time( $squareroot_data['date_format'] ) . '</span>';
				echo '</div>';
			}
			$count ++;
			?>
		<?php endwhile; endif; // done our wordpress loop. Will start again for each category
		wp_reset_query();
		?>
		</div>
	<?php } // done the foreach statement
} else {
	// get all the categories from the database
	$cats = get_categories();

// loop through the categries
	foreach ( $cats as $cat ) {
		// setup the cateogory ID
		$cat_id = $cat->term_id;
		// Make a header for the cateogry
		echo '<div class="' . $cat->name . ' timeline-cont clearfix" id="fblog">';
		echo '<span class="title"><strong>' . $cat->name . '</strong></span>';
		// create a custom wordpress query
		query_posts( "cat=$cat_id&posts_per_page=$number_post" );
		$count = 1;
		// start the wordpress loop!
		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php // create our link now that the post is setup ?>
			<?php
			if ( ! empty( $post->post_excerpt ) ) :
				$subtitle = get_the_excerpt();
			else :
				$subtitle = "";
			endif;

			if ( $count % 2 != 0 ) {
				echo '<div class="group group-' . $count . ' clearfix">';
				echo '<span class="date">' . get_the_time( $squareroot_data['date_format'] ) . '</span>';
				echo '<span class="point-circle"></span>';

				echo '<div class="desc-box blog-box">';

				if ( has_post_thumbnail() ) {
					echo '<figure>';
					echo '<a href="' . esc_url( get_the_permalink() ) . '">';
					the_post_thumbnail();
					echo '</a>';
					echo '</figure>';
				}
				echo '<div class="paddingme">';
				echo '<h4>' . get_the_title() . '</h4>';
				echo '<span class="sub-title">' . $subtitle . '</span>';
				echo '<p>' . wp_trim_words( get_the_content(), $num_words = 30, $more = null ) . '</p>';
				echo '<p><a href="' . esc_url( get_the_permalink() ) . '" class="read-more-link">' . esc_html__( 'Read More', 'squareroot' ) . '</a></p>';
				echo '</div>';

				echo '</div>';
				echo '</div>';
			} else {
				echo '<div class="group group-' . $count . ' group-alter clearfix">';
				echo '<div class="desc-box blog-box">';

				if ( has_post_thumbnail() ) {
					echo '<figure>';
					echo '<a href="' . esc_url( get_the_permalink() ) . '">';
					the_post_thumbnail();
					echo '</a>';
					echo '</figure>';
				}

				echo '<div class="paddingme">';
				echo '<h4>' . get_the_title() . '</h4>';
				echo '<span class="sub-title">' . $subtitle . '</span>';
				echo '<p>' . wp_trim_words( get_the_content(), $num_words = 30, $more = null ) . '</p>';
				echo '<p><a href="' . esc_url( get_the_permalink() ) . '" class="read-more-link">' . esc_html__( 'Read More', 'squareroot' ) . '</a></p>';
				echo '</div>';

				echo '</div>';
				echo '<span class="point-circle"></span>';
				echo '<span class="date">' . get_the_time( $squareroot_data['date_format'] ) . '</span>';
				echo '</div>';
			}
			$count ++;
			?>
		<?php endwhile; endif; // done our wordpress loop. Will start again for each category
		wp_reset_query();
		?>
		</div>
	<?php } // done the foreach statement
}
?>

<div id="more-box" class="end-box clearfix">
	<span class="title">
		<strong class="loadname"><?php esc_html_e( 'End', 'squareroot' ); ?></strong>
	</span>
</div>
<!--<div id="more-box" class="end-box clearfix">-->
<!--	<a href="javascript:void(0)" id="2" class="moreblog">-->
<!--        <span class="title">-->
<!--        <strong class="loadname">--><?php //esc_html_e( 'Load more', 'squareroot' ); ?><!--</strong>-->
<!--        </span>-->
<!--	</a>-->
<!--</div>-->