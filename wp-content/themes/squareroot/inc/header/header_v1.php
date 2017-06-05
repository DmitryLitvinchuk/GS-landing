<?php global $squareroot_data; ?>
<header id="header" class="page-head clearfix">
	<div class="container">
		<div class="site-logo">
			<a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php
				$site_title = esc_attr( get_bloginfo( 'name', 'display' ) );
				if ( $squareroot_data['site_logo'] == '' ) {
					$width  = 0;
					$height = 0;
				} else {
					$data   = getimagesize( $squareroot_data['site_logo'] );
					$width  = $data[0];
					$height = $data[1];
				}

				echo '<img src="' . $squareroot_data['site_logo'] . '" alt="' . $site_title . '" width="' . $width . '" height="' . $height . '"/>';
				?>
			</a>
		</div>
		<nav>
			<ul class="main-nav">
				<li class="nav-control">

					<a id="nav-toggle" href="#"><span></span></a>
					<ul class="inner-nav">
						<?php
						if ( has_nav_menu( 'primary' ) ) {
							wp_nav_menu( array(
								'theme_location' => 'primary',
								'container'      => false,
								'items_wrap'     => '%3$s',
								'walker'         => new squareroot_description_walker(),
								'depth'          => 0
							) );
						} else {
							$menuParameters = array(
								'container'   => false,
								'echo'        => false,
								'items_wrap'  => '%3$s',
								'link_before' => '<i class="fa fa-circle-o"></i><span>',
								'link_after'  => '</span>',
								'depth'       => 0,
							);

							echo strip_tags( wp_nav_menu( $menuParameters ), '<li><a><i><span>' );
						}
						?>
					</ul>
				</li>
			</ul>
			<!-- End Nav -->
		</nav>
	</div>
</header>