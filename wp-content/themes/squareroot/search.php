<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Squareroot
 */

get_header();
global $squareroot_data;
?>

<div class="col-md-12 wrapper">
	<?php
	/***********custom Top Images*************/
	$background_heading = get_template_directory_uri() . "/images/Untitled-2.png";
	if ( $squareroot_data['custom_header_background'] <> '' ) {
		$background_heading = $squareroot_data['custom_header_background'];
	}
	$background_heading = 'style="background:url(' . $background_heading . '); background-attachment: fixed; background-size: cover; height: 190px;"';
	?>
	<div class="top_site_main" <?php echo $background_heading; ?> >
		<div class="container page-title-wrapper">
			<div class="page-title-captions ">
				<header class="entry-header">
					<h2 class="page-title">
						<?php
						printf( __( 'Search Results for: %s', 'squareroot' ), '<span>' . get_search_query() . '</span>' );
						?>
					</h2>
				</header>
				<!-- .page-header -->
			</div>
		</div>
	</div>
	<?php
	global $squareroot_data;
	if ( $squareroot_data['header_layout'] == "header_v2" ) {
		get_template_part( '/inc/header/' . $squareroot_data['header_layout'] );
	}
	?>
	<div class="container content-site-main">
		<div class="row">
			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>
			<div class="col-md-9">

				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'content', 'search' );
						?>

					<?php endwhile; ?>

					<?php squareroot_paging_nav(); ?>

				<?php else : ?>

					<?php get_template_part( 'content', 'none' ); ?>

				<?php endif; ?>
			</div>
		</div>

	</div>
	<?php get_footer(); ?>
</div>



