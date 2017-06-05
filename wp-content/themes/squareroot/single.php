<?php
/**
 * The Template for displaying all single posts.
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
						echo single_post_title();
						?>
					</h2>
					<?php echo $wp_query->post->post_excerpt; ?>
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
	<div class="container single-post">
		<div class="row">
			<?php
			if ( $squareroot_data['pp_layout'] == '1col-fixed' ) {
				?>
				<div class="col-md-12">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php squareroot_post_nav(); ?>

						<?php get_template_part( 'content', 'single' ); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
						?>

					<?php endwhile; // end of the loop. ?>
				</div>
				<?php
			} elseif ( $squareroot_data['pp_layout'] == '2c-r-fixed' ) {
				?>
				<div class="col-md-9">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php squareroot_post_nav(); ?>

						<?php get_template_part( 'content', 'single' ); ?>

						<?php //squareroot_post_nav(); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
						?>

					<?php endwhile; // end of the loop. ?>
				</div>
				<div class="col-md-3">
					<?php get_sidebar(); ?>
				</div>
				<?php
			} else {
				?>
				<div class="col-md-3">
					<?php get_sidebar(); ?>
				</div>
				<div class="col-md-9">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php squareroot_post_nav(); ?>

						<?php get_template_part( 'content', 'single' ); ?>

						<?php //squareroot_post_nav(); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
						?>

					<?php endwhile; // end of the loop. ?>
				</div>

				<?php
			}
			?>
		</div>
	</div>

	<?php get_footer(); ?>
</div>