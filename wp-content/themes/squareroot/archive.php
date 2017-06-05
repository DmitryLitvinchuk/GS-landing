<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package MONTANA
 */

get_header(); ?>
<?php
global $squareroot_data;
$w_side_a = $squareroot_data['sidebar-a-width'];
$w_side_b = $squareroot_data['sidebar-b-width'];
if ( $squareroot_data['layout'] == '1col-fixed' ) {
	$w_main = 12;
	$class  = "col-sm-" . $w_main;
} elseif ( $squareroot_data['layout'] == '2c-r-fixed' ) {
	$w_main = 12 - $w_side_b;
	$class  = "col-sm-" . $w_main;
} elseif ( $squareroot_data['layout'] == '2c-l-fixed' ) {
	$w_main = 12 - $w_side_a;
	$class  = "col-sm-" . $w_main;
} elseif ( $squareroot_data['layout'] == '3c-fixed' || $squareroot_data['layout'] == '3c-r-fixed' || $squareroot_data['layout'] == '3c-l-fixed' ) {
	$w_main = 12 - $w_side_a - $w_side_b;
	$class  = "col-sm-" . $w_main;
}

if ( isset ( $select_style ) ) {
	@$select_style = $select_style ? $select_style : '';
} else {
	$select_style = '';
}
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
						if ( single_cat_title( '', true ) ) {
							echo single_cat_title( '', true );
						} else {
							echo single_month_title( ' ' );
						}
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
	<?php get_template_part( 'inc/archive', 'top' ); ?>
	<div class="container content-site-main content-archive">
		<div class="row">
			<?php
			if ( $squareroot_data['layout'] == '2c-l-fixed' ) {
				?>
				<div class="col-sm-<?php echo $w_side_a ?>">
					<?php get_sidebar(); ?>
				</div>
				<?php
			} elseif ( $squareroot_data['layout'] == '3c-fixed' ) {
				?>
				<div class="col-sm-<?php echo $w_side_a ?>">
					<?php get_sidebar(); ?>
				</div>
				<?php
			} elseif ( $squareroot_data['layout'] == '3c-l-fixed' ) {
				?>
				<div class="col-sm-<?php echo $w_side_a ?>">
					<?php get_sidebar(); ?>
				</div>
				<div class="col-sm-<?php echo $w_side_b ?>">
					<?php get_sidebar( '2' ); ?>
				</div>
			<?php } ?>

			<div class="<?php echo $class; ?>">
				<?php if ( have_posts() ) : ?>
				<?php
				$class = '';
				if ( $select_style == 'grid_two_column' ) {
					echo "<div class='blog-grid row'>";
					$class = "width50 floatleft";
				} elseif ( $select_style == 'grid_three_column' ) {
					echo "<div class='blog-grid row'>";
					$class = "width33 floatleft";
				} elseif ( $select_style == 'grid_four_column' ) {
					echo "<div class='blog-grid row'>";
					$class = "width25 floatleft";
				} elseif ( $select_style == 'timeline' ) {
					echo "<div class='blog-timeline'>";

				} else {
					echo "<div class='blog-basic'>";
				}
				?>
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					if ( $select_style == 'grid_two_column' || $select_style == 'grid_three_column' || $select_style == 'grid_four_column' ) {
						echo '<div class="' . $class . '">';
						get_template_part( 'content', 'grid' );
						echo '</div>';
					} elseif ( $select_style == 'timeline' ) {
						get_template_part( 'content', 'timeline' );
					} else {
						get_template_part( 'content' );
					}

					?>
				<?php endwhile; ?>
			</div>
		<?php squareroot_paging_nav(); ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
			<?php
		endif;
		?>
		</div>
		<?php
		if ( $squareroot_data['layout'] == '2c-r-fixed' ) {
			?>
			<div class="col-sm-<?php echo $w_side_b ?>">
				<?php get_sidebar( '2' ); ?>
			</div>
			<?php
		}
		if ( $squareroot_data['layout'] == '3c-r-fixed' ) {
			?>
			<div class="col-sm-<?php echo $w_side_a ?>">
				<?php get_sidebar(); ?>
			</div>
			<div class="col-sm-<?php echo $w_side_b ?>">
				<?php get_sidebar( '2' ); ?>
			</div>
			<?php
		} elseif ( $squareroot_data['layout'] == '3c-fixed' ) {
			?>
			<div class="col-sm-<?php echo $w_side_b ?>">
				<?php get_sidebar( '2' ); ?>
			</div>
		<?php } ?>
	</div>
</div>
<!-- content-site-main-->

<?php get_footer(); ?>
