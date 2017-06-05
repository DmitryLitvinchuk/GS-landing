<?php
the_content();
?>
	<img class="port-ajax-loader" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" alt="loading ..." style="display:none;">

	<div id="loader"></div>

	<ul class="filter-menu">
		<li>
			<a href="#non" class="filter-current" data-filter="*"><?php esc_html_e( 'All', 'squareroot' ); ?></a>&nbsp;//&nbsp;
		</li>
		<?php
		$check_list = array();
		if ( get_post_meta( get_the_ID(), 'portfolio_section_number_por', true ) != '' ) { // overide number
			$args = array(
				'post_type'      => 'portfolio',
				'posts_per_page' => get_post_meta( get_the_ID(), 'portfolio_section_number_por', true )
			);
		} else {
			$args = array(
				'post_type' => 'portfolio'
			);
		}
		$pcats = get_post_meta( get_the_ID(), 'portfolio_section_category_portfolio', false );
		if ( $pcats ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'portfolio_filter',
				'field'    => 'ID',
				'terms'    => $pcats
			);
		}
		wp_reset_query();
		$gallery = new WP_Query( $args );

		if ( is_array( $gallery->posts ) && ! empty( $gallery->posts ) ) {
			foreach ( $gallery->posts as $gallery_post ) {
				$post_taxs = wp_get_post_terms( $gallery_post->ID, 'portfolio_filter', array( "fields" => "all" ) );
				if ( is_array( $post_taxs ) && ! empty( $post_taxs ) ) {
					foreach ( $post_taxs as $post_tax ) {
						if ( is_array( $pcats ) && ! empty( $pcats ) && ( in_array( $post_tax->term_id, $pcats ) || in_array( $post_tax->parent, $pcats ) ) ) {
							$portfolio_taxs[ urldecode( $post_tax->slug ) ] = $post_tax->name;
						}
						if ( empty( $pcats ) || ! isset( $pcats ) ) {
							$portfolio_taxs[ urldecode( $post_tax->slug ) ] = $post_tax->name;
						}
					}
				}
			}
		}

		$number  = count( $portfolio_taxs );
		$counter = 1;
		foreach ( $portfolio_taxs as $portfolio_tax_slug => $portfolio_tax_name ):
			if ( $counter == $number ) {
				?>
				<li>
					<a href="#non" data-filter=".<?php echo $portfolio_tax_slug; ?>"><?php echo $portfolio_tax_name; ?></a>
				</li>
				<?php
			} else {
				?>
				<li>
					<a href="#non" data-filter=".<?php echo $portfolio_tax_slug; ?>"><?php echo $portfolio_tax_name; ?></a>&nbsp;//&nbsp;
				</li>
				<?php
			}
			$counter ++;
		endforeach;
		?>
	</ul>
<?php

$list = '<ul class="filter-port row por_sec_1">';
while ( $gallery->have_posts() ): $gallery->the_post();
	$class_slug = '';
	$terms_id   = array();
	$item_cats  = get_the_terms( $post->ID, 'portfolio_filter' );
	if ( $item_cats ):
		foreach ( $item_cats as $item_cat ) {
			$class_slug .= $item_cat->slug . ' ';
		}
	endif;

	$list .= '<li class="item ' . $class_slug . ' col-md-4 col-sm-6">';
	$list .= '<figure>';

	$thumb_id  = get_post_thumbnail_id();
	$thumb_url = wp_get_attachment_image_src( $thumb_id, 'thumbnail-size', true );
	$list .= '<img src="' . $thumb_url[0] . '" alt="placeholder-img">';

	if ( get_post_meta( get_the_ID(), 'project_client_name', true ) != ""
	     || get_post_meta( get_the_ID(), 'project_client_sub_name', true ) != ""
	) {
		$title = get_post_meta( get_the_ID(), 'project_client_name', true );
		$sub   = get_post_meta( get_the_ID(), 'project_client_sub_name', true );
	} else {
		$sub = "More";
	}
	$link = $thumb_url[0];
	$list .= '<a href="javascript:void(0)" rel="external" class="portfolio-image ' . $post->ID . '">' . $title . '<span><em>' . $sub . '</em></span></a>';
	$list .= '</figure>';
	$list .= '</li>';
endwhile;
wp_reset_postdata();
$list .= '</ul>';
echo $list;

?>