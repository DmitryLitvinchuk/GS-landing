<?php global $squareroot_data; ?>
<!-- <header id="header_2" class="affix-top" data-spy="affix" data-offset-top="600"> -->
<header id="header_3" class="h-top">
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
		<nav role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
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
			</div>
			<!-- End Nav -->
		</nav>
	</div>
</header>