<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Squareroot
 */

get_header(); ?>
	<div class="col-md-12 wrapper">
		<main id="main" class="site-main" role="main">
			<?php //get_template_part( 'inc/archive', 'top' ); ?>

			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<div class="page-404-content">
									<div class="left_404"><h2>404</h2></div>
									<div class="right_404">
										<p><?php _e( 'The page you requested was not found, and we have a fine quess why', 'squareroot' ); ?></p>
										<i><?php _e( 'If you typed the URL directly, please make sure the spelling is correct.<br/> If you clicked on link to get here, the link is outdated.', 'squareroot' ); ?></i>
									</div>
									<div class="clear"></div>
								</div>
								<!-- .page-content -->
							</div>
						</div>
					</div>
				</div>
				<!-- #content -->
			</div><!-- #primary -->
		</main>
	</div>
	<div class="clear"></div>
<?php get_footer();