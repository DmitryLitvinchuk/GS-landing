<?php
/**
 * @package Squareroot
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<a href="<?php the_permalink(); ?>"> <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?></a>

		<!-- <div class="entry-meta"> -->
		<?php squareroot_posted_on(); ?>
		<!-- </div> -->
		<!-- .entry-meta -->
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php
		if ( get_post_type() == "portfolio" ) {
			$id          = get_the_ID();
			$slider_meta = get_post_meta( $id, 'project_item_slides', false );
			$slider_meta = array_filter( $slider_meta );
			if ( ! empty( $slider_meta ) ) {
				?>

				<?php global $wpdb, $post;
				if ( ! is_array( $slider_meta ) ) {
					$slider_meta = ( array ) $slider_meta;
				}
				if ( ! empty( $slider_meta ) ) {
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
							echo '<div class="post-formats-wrapper"><div class="flexslider"><ul class="slides">';
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
						echo '</ul></div></div>';
					}
				} ?>

				<?php
			} else if ( get_post_meta( get_the_ID(), 'project_video_embed', true ) != "" ) {
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
			} else {
				do_action( 'squareroot_entry_top', 'blog_full' );
			}

		} else {
			do_action( 'squareroot_entry_top', 'blog_full' );
		}
		the_content();

		?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'squareroot' ),
			'after'  => '</div>',
		) );
		?>
	</div>
	<!-- .entry-content -->

	<footer class="entry-footer">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'squareroot' ) );
			if ( $categories_list && squareroot_categorized_blog() ) :
				?>
				<span class="cat-links">
		<?php printf( __( 'This entry was posted in %1$s', 'squareroot' ), $categories_list ); ?>
	</span>
			<?php endif; // End if categories ?>

			<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'squareroot' ) );
			if ( $tags_list ) :
				?>
				<span class="tags-links">
		<?php printf( __( 'and tagged %1$s', 'squareroot' ), $tags_list ); ?>
	</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php edit_post_link( __( 'Edit', 'squareroot' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
	<!-- .entry-footer -->
</article><!-- #post-## -->
