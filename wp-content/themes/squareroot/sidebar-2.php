<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Squareroot
 */
?>
<div id="secondary-2" class="widget-area" role="complementary">
	<?php if ( ! dynamic_sidebar( 'sidebar-2' ) ) : ?>

		<aside id="search-2" class="widget widget_search">
			<?php get_search_form(); ?>
		</aside>

		<aside id="archives-2" class="widget">
			<h1 class="widget-title"><?php _e( 'Archives', 'squareroot' ); ?></h1>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</aside>

		<aside id="meta-2" class="widget">
			<h1 class="widget-title"><?php _e( 'Meta', 'squareroot' ); ?></h1>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</aside>

	<?php endif; // end sidebar widget area ?>
</div><!-- #secondary -->
