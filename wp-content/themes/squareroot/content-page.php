<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Squareroot
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<a href="<?php the_permalink(); ?>"> <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?></a>
	</header>

	<!-- 	<div>
			<div class="row"> -->
	<div class="entry-content">
		<?php
		$post_name = $post->post_name;
		$post_id   = get_the_ID();

		// parallax section
		if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "parallax-section" ) {
			?>
			<!-- START PARALLAX SECTION -->
			<div id="<?php echo $post_name; ?>" class="<?php echo $post_name; ?> parallax">
				<div class="overlay">
					<div>
						<?php the_content(); ?>
					</div>
					<!-- END CONTAINER -->
				</div>
			</div>
			<!-- END PARALLAX SECTION -->
			<?php
		}else {
		?>


		<?php if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "portfolio-section" || "portfolio2-section" || "portfolio3-section" ) { ?>
		<div id="<?php echo $post_name; ?>" class="<?php echo $post_name; ?> sections"><!-- SECTION -->
			<?php } else {
			if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "home-section" ) {
			?>
			<div id="<?php echo $post_name; ?>" class="home sections"><!-- SECTION -->
				<?php } else { ?>
				<div id="<?php echo $post_name; ?>" class="<?php echo $post_name; ?> section"><!-- SECTION -->
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
							<div>
								<?php get_template_part( 'sections/portfolio_section' ); ?>
							</div>
							<?php
						} else {
							if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "portfolio2-section" ) {
								?>
								<div>
									<?php get_template_part( 'sections/portfolio2_section' ); ?>
								</div>
								<?php
							} else {
								if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "portfolio3-section" ) {
									?>
									<div>
										<?php get_template_part( 'sections/portfolio3_section' ); ?>
									</div>
									<?php
								} else {
									if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "resume-section" ) {
										?>
										<div class="timeline">
											<?php get_template_part( 'sections/resume_section' ); ?>
										</div>
										<?php
									} else {
										if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "blog-section" ) {
											?>
											<div class="timeline">
												<?php get_template_part( 'sections/blog_section' ); ?>
											</div>
											<?php
										} else {
											if ( get_post_meta( $post_id, "rnr_assign_type", true ) == "fullwidth-section" ) {
												?>
												<?php the_content();
											} else {
												?>
												<div>
													<?php
													the_content();
													?>
												</div>

												<?php
											}
										}
									}
								}
							}
						}
					} ?>
				</div>
				<!--END SECTION -->
				<?php
				} ?>
				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'squareroot' ),
					'after'  => '</div>',
				) );
				?>
			</div>
			<!-- .entry-content -->
			<footer class="entry-footer">
				<?php edit_post_link( __( 'Edit', 'squareroot' ), '<span class="edit-link">', '</span>' ); ?>
			</footer>
			<!-- .entry-footer -->
			<!-- 		</div>
				</div> -->
</article><!-- #post-## -->
