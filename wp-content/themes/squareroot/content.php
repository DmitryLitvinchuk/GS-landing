<?php
/**
 * @package SQUAREROOT
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'squareroot_entry_top', 'archive_medium' ); ?>
	<div class="entry-content">
		<?php
		if ( has_post_format( 'link' ) && squareroot_meta( 'url' ) && squareroot_meta( 'text' ) ) {
			$url  = squareroot_meta( 'url' );
			$text = squareroot_meta( 'text' );
			if ( $url && $text ) {
				echo '<header class="entry-header">
					<div class="format-icon"><span class="fa fa-link"></span></div>
					<div class="box-header">
						<p><a class="link" href="' . $url . '">' . $text . '</a></p>
					</div>
				</header>';

			}
		} elseif ( has_post_format( 'quote' ) && squareroot_meta( 'quote' ) && squareroot_meta( 'author_url' ) ) {
			$quote      = squareroot_meta( 'quote' );
			$author     = squareroot_meta( 'author' );
			$author_url = squareroot_meta( 'author_url' );
			if ( $author_url ) {
				$author = ' <a href=' . $author_url . '>' . $author . '</a>';
			}
			if ( $quote && $author ) {
				echo '
					<header class="entry-header">
					<div class="format-icon"><i class="icon-format-quote"></i></div>
					<div class="box-header">
						<blockquote>' . $quote . '</blockquote>
						<cite>' . $author . '</cite>
					</div>
					</header>
					<div class="entry-summary">
						<div class="read-more"><a href="' . get_permalink( get_the_ID() ) . '" class="btn btn-black">' . __( 'READ MORE', 'squareroot' ) . '</a></div>
					 ';
				squareroot_posted_on();
				echo '</div>';
			}
		} else {
			?>
			<header class="entry-header">
				<?php do_action( 'squareroot_icon' ); ?>
				<div class="box-header">
					<h3><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					<?php squareroot_posted_on(); ?>
				</div>
			</header>
			<!-- .entry-header -->
			<div class="entry-summary">

				<?php
				global $squareroot_data;
				$length = $squareroot_data['excerpt_length_blog'];
				echo '<p>' . excerpt( $length ) . '</p>';
				?>
				<div class="read-more">
					<a href="<?php the_permalink(); ?>" class="button btn-black"><?php _e( 'READ MORE', 'squareroot' ); ?></a>
				</div>
			</div><!-- .entry-summary -->
		<?php }; ?>

	</div>
</article><!-- #post-## -->
