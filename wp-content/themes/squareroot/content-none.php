<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Squareroot
 */
?>

<section class="no-results not-found">
	<div class="container">
		<div class="row">
			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Nothing Found', 'squareroot' ); ?></h1>
			</header>
			<!-- .page-header -->

			<div class="page-content">
				<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

					<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'squareroot' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

				<?php elseif ( is_search() ) : ?>

					<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'squareroot' ); ?></p>
					<?php get_search_form(); ?>

					<?php
				else : ?>

					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'squareroot' ); ?></p>
					<?php get_search_form(); ?>

				<?php endif; ?>
			</div>
			<!-- .page-content -->
		</div>
	</div>
</section><!-- .no-results -->
