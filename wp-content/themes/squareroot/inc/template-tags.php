<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Squareroot
 */

if ( ! function_exists( 'squareroot_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function squareroot_paging_nav() {
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'      => $pagenum_link,
			'format'    => $format,
			'total'     => $GLOBALS['wp_query']->max_num_pages,
			'current'   => $paged,
			'mid_size'  => 1,
			'add_args'  => array_map( 'urlencode', $query_args ),
			'prev_text' => __( '<', 'squareroot' ),
			'next_text' => __( '>', 'squareroot' ),
			'type'      => 'list'
		) );

		if ( $links ) :
			?>
			<div class="pagination loop-pagination">
				<?php echo $links; ?>
			</div>
			<!-- .pagination -->
		<?php
		endif;
	}
endif;

if ( ! function_exists( 'squareroot_post_nav' ) ) :
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function squareroot_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="navigation post-navigation" role="navigation">
			<!-- <h1 class="screen-reader-text"><?php _e( 'Post navigation', 'squareroot' ); ?></h1> -->

			<div class="nav-links">
				<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav"><i class="fa fa-angle-left"></i></span> %title', 'Previous post link', 'squareroot' ) );
				next_post_link( '<div class="nav-next">%link</div>', _x( '%title <span class="meta-nav"><i class="fa fa-angle-right"></i></span>', 'Next post link', 'squareroot' ) );
				?>
			</div>
			<!-- .nav-links -->
		</nav><!-- .navigation -->
	<?php
	}
endif;

if ( ! function_exists( 'squareroot_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function squareroot_posted_on() {
		global $squareroot_data;
		?>
		<ul class="entry-meta">
			<?php if ( $squareroot_data['show_date'] == 1 ) { ?>
				<li>
					<span><i class="fa fa-clock-o"></i> </span><a href="<?php the_permalink(); ?>"><?php the_time( $squareroot_data['date_format'] ); ?></a>
				</li>
			<?php
			}
			if ( $squareroot_data['show_author'] == 1 ) {
				?>
				<li><span><i class="fa fa-user"></i> </span></span><?php printf( '<a class="author" href="%1$s">%2$s</a>',
							esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
							esc_html( get_the_author() )
						); ?>
				</li>
			<?php
			}
			if ( $squareroot_data['show_category'] == 1 ) {
				?>
				<li>
					<span><i class="fa fa-pencil-square-o"></i> </span><?php the_category( ', ', '' ); ?>
				</li>
			<?php
			}
			if ( $squareroot_data['show_comment'] == 1 ) {
				?>
				<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) :
					?>
					<li>
						<?php comments_popup_link( __( '<i class="fa fa-comments-o"></i> 0', 'montana' ), __( '<i class="fa fa-comments-o"></i> 1', 'montana' ), __( '<i class="fa fa-comments-o"></i> %', 'montana' ) ); ?>
					</li>
				<?php
				endif;
			}
			edit_post_link( __( 'Edit', 'montana' ), ' <li class="edit-link">', '</li>' );
			?>
		</ul><?php
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function squareroot_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'squareroot_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'squareroot_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so squareroot_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so squareroot_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in squareroot_categorized_blog.
 */
function squareroot_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'squareroot_categories' );
}

add_action( 'edit_category', 'squareroot_category_transient_flusher' );
add_action( 'save_post', 'squareroot_category_transient_flusher' );
