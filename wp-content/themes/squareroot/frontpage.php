<?php get_header();

/*
Template name: Frontpage Template
*/
?>
<?php
$current_page_id = get_option( 'page_on_front' );

if ( ( $locations = get_nav_menu_locations() ) && $locations['primary'] ) {
	$menu       = wp_get_nav_menu_object( $locations['primary'] );
	$menu_items = wp_get_nav_menu_items( $menu->term_id );

	$test_include = array();
	foreach ( $menu_items as $item ) {
		if ( $item->object == 'page' ) {
			$test_include[] = $item->object_id;
		}
	}

	if ( function_exists( 'CPTOrderPosts' ) ) {
		remove_filter( 'posts_orderby', 'CPTOrderPosts', 99);
	}

	$main_query = new WP_Query( array( 'post_type'      => 'page',
	                                   'post__in'       => $test_include,
	                                   'posts_per_page' => count( $test_include ),
	                                   'orderby'        => 'post__in'
	) );
	if ( function_exists( 'CPTOrderPosts' ) ) {
		add_filter( 'posts_orderby', 'CPTOrderPosts', 99, 2 );
	}
} else {

	$args       = array(
		'post_type'      => 'page',
		'order'          => 'ASC',
		'orderby'        => 'menu_order',
		'posts_per_page' => '-1'
	);
	$main_query = new WP_Query( $args );
}

if ( have_posts() ) :
while ( $main_query->have_posts() ) :
$main_query->the_post();

global $post;

$post_name     = $post->post_name;
$post_id       = get_the_ID();
$separate_page = get_post_meta( $post_id, "rnr_separate_page", true );
if ( ( $separate_page != true ) && ( $post_id != $current_page_id ) ) {
?>
<?php

$css_temp = "";
if ( get_post_meta( $post_id, "margin_top", true ) != "" ) {
	$css_temp .= "margin-top:" . get_post_meta( $post_id, "margin_top", true ) . "px;";
}
if ( get_post_meta( $post_id, "margin_bottom", true ) != "" ) {
	$css_temp .= "margin-bottom:" . get_post_meta( $post_id, "margin_bottom", true ) . "px;";
}
if ( get_post_meta( $post_id, "padding_top", true ) != "" ) {
	$css_temp .= "padding-top:" . get_post_meta( $post_id, "padding_top", true ) . "px;";
}
if ( get_post_meta( $post_id, "padding_bottom", true ) != "" ) {
	$css_temp .= "padding-bottom:" . get_post_meta( $post_id, "padding_bottom", true ) . "px;";
}
if ( $css_temp != "" ) {
	$css_temp = ' style="' . $css_temp . '"';
}

// parallax section
if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "parallax-section" ) {
	?>
	<!-- START PARALLAX SECTION -->
	<div id="<?php echo $post_name; ?>" class="<?php echo $post_name; ?> parallax"<?php echo $css_temp; ?>>
		<div class="overlay">
			<!-- <div class="container"> -->
			<?php the_content(); ?>
			<!-- </div> -->
			<!-- END CONTAINER -->
		</div>
	</div>
	<!-- END PARALLAX SECTION -->
	<?php
}else {
?>


<?php if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "portfolio-section" || get_post_meta( $post_id, "rnr_assign_type", true ) == "portfolio2-section" || get_post_meta( $post_id, "rnr_assign_type", true ) == "portfolio3-section" ) { ?>
<div id="<?php echo $post_name; ?>" class="<?php echo $post_name; ?> sections"<?php echo $css_temp; ?>><!-- SECTION -->
	<?php } else {
	if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "home-section" ) {
	?>
	<div id="<?php echo $post_name; ?>" class="home sections"<?php echo $css_temp; ?>><!-- SECTION -->
		<?php } else { ?>
		<div id="<?php echo $post_name; ?>" class="<?php echo $post_name; ?> section"<?php echo $css_temp; ?>><!-- SECTION -->
			<?php
			}
			} ?>

			<?php
			if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "home-section" ) {
				?>
				<?php get_template_part( 'sections/home_section' );
			} else {
				if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "portfolio-section" ) {
					?>
					<div class="container">
						<?php get_template_part( 'sections/portfolio_section' ); ?>
					</div>
					<?php
				} else {
					if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "resume-section" ) {
						?>
						<div class="timeline container">
							<?php get_template_part( 'sections/resume_section' ); ?>
						</div>
						<?php
					} else {
						if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "blog-section" ) {
							?>
							<div class="timeline container">
								<?php get_template_part( 'sections/blog_section' ); ?>
							</div>
							<?php
						} else {
							if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "fullwidth-section" ) {
								?>
								<?php the_content();
							} else {
								if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "contact-section" ) {
									?>
									<?php get_template_part( 'sections/contact_section' ); ?>
									<?php
								} else {
									if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "portfolio2-section" ) {
										?>
										<div class="container">
											<?php get_template_part( 'sections/portfolio2_section' ); ?>
										</div>
										<?php
									} else {
										if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "portfolio3-section" ) {
											?>
											<div class="container">
												<?php get_template_part( 'sections/portfolio3_section' ); ?>
											</div>
											<?php
										} else {
											?>
											<!-- <div class="container"> -->
											<?php
											the_content();
											?>
											<!-- </div> -->

											<?php
										}
										?>
										<?php
									}
									?>
									<?php
								}
							}
						}
					}
				}
			} ?>
		</div>
		<!--END SECTION -->
		<?php
		if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "home-section" ) {
			if ( $squareroot_data['header_layout'] == "header_v2" ) {
				get_template_part( '/inc/header/' . $squareroot_data['header_layout'] );
			}
		}
		}
		}
		endwhile;
		endif;
		?>
		<?php get_footer(); ?>
