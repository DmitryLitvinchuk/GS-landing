<?php

function squareroot_custom_styles() {
	?>
	<style type="text/css">
		<?php
		$args=array(
			'post_type'			=> 'page',
			'order'				=> 'ASC',
			'orderby'			=> 'menu_order',
			'posts_per_page'	=> '-1'
			);
		$main_query = new WP_Query($args);

		$classpost = "";
		if( have_posts() ) :
			while ($main_query->have_posts()) : $main_query->the_post();

		$post_id = get_the_ID();

		if (get_post_meta($post_id, "rnr_assign_type", true) == "fullwidth-section") {
			$color = get_post_meta($post_id, "full-color", true);
			$post = get_post($post_id);
			$slug = $post->post_name;
		?>
		.<?php echo $slug ?> {
			background: <?php echo $color; ?>;
			/*padding-top: 40px;
			padding-bottom: 40px;*/
		}

		<?php
		} 


		if ( has_post_thumbnail()) {
			if (empty($slider_meta)) {
				$att=get_post_thumbnail_id();
				$image_src = wp_get_attachment_image_src( $att, 'full' );
				$image_src = $image_src[0]; ?>

		<?php if (get_post_meta($post_id, "rnr_assign_type", true) == "parallax-section") { ?>

		<?php
		$post = get_post($post_id);
		$slug = $post->post_name;

		if ($classpost != "") {
			$classpost .= ", ";
		}
		$classpost .= ".".$slug;

		?>
		.<?php echo $slug ?> {
			background: url('<?php echo $image_src; ?>');
			background-attachment: fixed;
			background-size: cover;
		}

		<?php } ?>

		<?php if (get_post_meta($post_id, "rnr_assign_type", true) == "home-section") { ?>
		<?php
		$post = get_post($post_id);
		$slug = $post->post_name;

		if ($classpost != "") {
			$classpost .= ", ";
		}
		$classpost .= ".".$slug;
		?>
		body #<?php echo $slug ?> {
			background: url('<?php echo $image_src; ?>') center top;
			color: #fff;
			background-size: cover;
			position: relative;
			height: 100%;
			overflow: hidden;
		}

		<?php } ?>

		<?php
	}
}

endwhile;
endif; ?>
		<?php if ($classpost != "") { ?>
		@media only screen and (max-width: 767px) {
		<?php echo $classpost; ?> {
			background-attachment: scroll !important;
			background-position: top center !important;
			background-size: cover;
		}
		}

		<?php } ?>

		<?php
		if ( is_user_logged_in() ) { ?>
		#header_2.h-fixed {
			top: 32px !important;
		}

		@media screen and (min-width: 767px) {
			.main-nav .inner-nav {
				top: 97px !important;
			}
		}

		@media screen and (max-width: 767px) {
			.main-nav .inner-nav {
				top: 107px !important;
			}
		}

		@media screen and (max-width: 600px) {
			#wpadminbar {
				position: fixed !important;
			}
		}

		<?php
	} ?>
		#nav-toggle {
			cursor: pointer;
			display: block;
			width: 100%;
			height: 100%;
			padding: 10px 35px 16px 0px;
		}

		#nav-toggle span, #nav-toggle span:before, #nav-toggle span:after {
			cursor: pointer;
			border-radius: 1px;
			height: 3px;
			width: 26px;
			background: #151d2a;
			position: absolute;
			display: block;
			content: '';
		}

		#nav-toggle span:before {
			top: -7px;
		}

		#nav-toggle span:after {
			bottom: -7px;
		}

		#nav-toggle span, #nav-toggle span:before, #nav-toggle span:after {
			transition: all 200ms ease-in-out;
		}

		#nav-toggle.active span {
			background-color: transparent;
		}

		#nav-toggle.active span:before, #nav-toggle.active span:after {
			top: 0;
		}

		#nav-toggle.active span:before {
			transform: rotate(45deg);
		}

		#nav-toggle.active span:after {
			transform: translateY(-10px) rotate(-45deg);
			top: 10px;
		}

		a#nav-toggle:hover span:before, a#nav-toggle:hover span:after, a#nav-toggle:hover span {
			background: rgb(148, 148, 148);
		}

		li.nav-control:hover .active span {
			background: white !important;
		}

	</style>
	<?php
}

add_action( 'wp_head', 'squareroot_custom_styles', 100 );

function squareroot_custom_scripts() {
	?>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {

			<?php

			$args = array(
				'post_type'      => 'page',
				'order'          => 'ASC',
				'orderby'        => 'menu_order',
				'posts_per_page' => '-1'
			);
			$main_query = new WP_Query( $args );

			if( have_posts() ) :
			while ($main_query->have_posts()) : $main_query->the_post();
			$post_id = get_the_ID();
			if (get_post_meta( $post_id, "rnr_assign_type", true ) == "parallax-section") {
			$post = get_post( $post_id );
			$slug = $post->post_name;?>
			$('#<?php echo $slug; ?>').parallax("50%", 0.2);
			<?php    }


			if (get_post_meta( $post_id, "rnr_assign_type", true ) == "home-section") {
			$post = get_post( $post_id );
			$slug = $post->post_name;?>
			$('#<?php echo $slug; ?>').parallax("50%", 0.3);
			<?php
			}
			endwhile;
			endif;
			?>
			$('.top_site_main').parallax("50%", 0.2);
		});
	</script>
<?php }

add_action( 'wp_footer', 'squareroot_custom_scripts', 20 );
?>