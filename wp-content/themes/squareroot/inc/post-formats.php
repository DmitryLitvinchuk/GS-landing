<?php
add_filter( 'the_content', 'squareroot_post_formats_content' );

/**
 * Remove images in post content if it has post format 'image'
 *
 * @param string $content
 *
 * @return string
 * @since 1.0
 */
function squareroot_post_formats_content( $content ) {
	if ( has_post_format( 'image' ) ) {
		$content = preg_replace( '|<img[^>]*>|i', '', $content );
	}
	if ( has_post_format( 'link' ) ) {
		$url  = squareroot_meta( 'url' );
		$text = squareroot_meta( 'text' );
		if ( $url && $text ) {
			$content = "<p><a class='link' href='" . esc_url( $url ) . "'>$text</a></p>";
		}
	}
	if ( has_post_format( 'quote' ) ) {
		$quote      = squareroot_meta( 'quote' );
		$author     = squareroot_meta( 'author' );
		$author_url = squareroot_meta( 'author_url' );
		if ( $author_url ) {
			$author = "<a href='" . esc_url( $author_url ) . "'>$author</a>";
		}
		if ( $quote && $author ) {
			$content = "<blockquote>$quote<cite>$author</cite></blockquote>";
		}
	}

	return $content;
}

/********************squareroot_entry_top**********************/
add_action( 'squareroot_entry_top', 'squareroot_post_formats' );

/**
 * Show entry format images, video, gallery, audio, etc.
 * @return void
 */

function squareroot_post_formats( $size ) {
	$html = '';

	switch ( get_post_format() ) {
		case 'image':
			$image = squareroot_get_image( array(
				'size'     => $size,
				'format'   => 'src',
				'meta_key' => 'image',
				'echo'     => false,
			) );
			if ( ! $image ) {
				break;
			}

			$html = sprintf(
				'<a class="post-image" href="%1$s" title="%2$s"><img src="%3$s" alt="%2$s"></a>',
				get_permalink(),
				the_title_attribute( 'echo=0' ),
				$image
			);
			break;
		case 'gallery':
			$images = squareroot_meta( 'images', "type=image&size=$size" );

			if ( empty( $images ) ) {
				break;
			}
			wp_enqueue_script( 'squareroot-flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), '', false );
			$html .= '<div class="flexslider">';
			$html .= '<ul class="slides">';
			foreach ( $images as $image ) {
				$html .= sprintf(
					'<li><a href="%s" class="hover-gradient"><img src="%s" alt="gallery"></a></li>',
					get_permalink(),
					$image['url']
				);
			}
			$html .= '</ul>';
			$html .= '</div>';
			break;
		case 'audio':
			$audio = squareroot_meta( 'audio' );
			if ( ! $audio ) {
				break;
			}

			// If URL: show oEmbed HTML or jPlayer
			if ( filter_var( $audio, FILTER_VALIDATE_URL ) ) {
				wp_enqueue_style( 'squareroot-pixel-industry', get_template_directory_uri() . '/js/jplayer/skin/pixel-industry/pixel-industry.min.css', array(), true );
				wp_enqueue_script( 'squareroot-jplayer', get_template_directory_uri() . '/js/jplayer/jquery.jplayer.min.js', array( 'jquery' ), '', true );
				// Try oEmbed first
				if ( $oembed = @wp_oembed_get( $audio ) ) {
					$html .= $oembed;
				} // Use jPlayer
				else {
					$id = uniqid();
					$html .= "<div data-player='$id' class='jp-jplayer' data-audio='$audio'></div>";
					$html .= squareroot_jplayer( $id );
				}
			} // If embed code: just display
			else {
				$html .= $audio;
			}
			break;
		case 'video':
			$video = squareroot_meta( 'video' );
			if ( ! $video ) {
				break;
			}
			// If URL: show oEmbed HTML
			if ( filter_var( $video, FILTER_VALIDATE_URL ) ) {
				if ( $oembed = @wp_oembed_get( $video ) ) {
					$html .= $oembed;
				}
			} // If embed code: just display
			else {
				$html .= $video;
			}
			break;
		default:
			$thumb = get_the_post_thumbnail( get_the_ID(), $size );
			if ( empty( $thumb ) ) {
				return;
			}
			$html .= '<a class="post-image" href="' . esc_url( get_permalink() ) . '">';
			$html .= $thumb;
			$html .= '</a>';
	}
	if ( $html && ! is_single() ) {
		//echo '<div class="feater-post col-md-5"><div class="post-formats-wrapper">'.$html.'</div></div>';
		echo '<div class="feater-post col-md-5">' . $html . '</div>';
	} else if ( is_single() ) {
		echo '<div class="post-formats-wrapper">' . $html . '</div>';
	} else {
		echo "";
	}
}

/**
 * Display jPlayer container HTML for audio player
 *
 * @param string $id Player ID
 *
 * @return string
 */
function squareroot_jplayer( $id = 'jp_container_1' ) {
	ob_start();
	?>
	<div id="<?php echo $id; ?>" class="jp-audio">
		<div class="jp-type-playlist">
			<div class="jp-gui jp-interface">
				<ul class="jp-controls">
					<li>
						<a href="javascript:;" class="jp-previous" tabindex="1"><?php _e( 'previous', 'squareroot' ); ?></a>
					</li>
					<li><a href="javascript:;" class="jp-play" tabindex="1"><?php _e( 'play', 'squareroot' ); ?></a>
					</li>
					<li><a href="javascript:;" class="jp-pause" tabindex="1"><?php _e( 'pause', 'squareroot' ); ?></a>
					</li>
					<li><a href="javascript:;" class="jp-next" tabindex="1"><?php _e( 'next', 'squareroot' ); ?></a>
					</li>
					<li><a href="javascript:;" class="jp-stop" tabindex="1"><?php _e( 'stop', 'squareroot' ); ?></a>
					</li>
					<li>
						<a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><?php _e( 'mute', 'squareroot' ); ?></a>
					</li>
					<li>
						<a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><?php _e( 'unmute', 'squareroot' ); ?></a>
					</li>
					<li>
						<a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume"><?php _e( 'max volume', 'squareroot' ); ?></a>
					</li>
				</ul>
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-volume-bar">
					<div class="jp-volume-bar-value"></div>
				</div>
				<div class="jp-time-holder">
					<div class="jp-current-time"></div>
					<div class="jp-duration"></div>
				</div>
				<ul class="jp-toggles">
					<li>
						<a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle"><?php _e( 'shuffle', 'squareroot' ); ?></a>
					</li>
					<li>
						<a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off"><?php _e( 'shuffle off', 'squareroot' ); ?></a>
					</li>
					<li>
						<a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat"><?php _e( 'repeat', 'squareroot' ); ?></a>
					</li>
					<li>
						<a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"><?php _e( 'repeat off', 'squareroot' ); ?></a>
					</li>
				</ul>
			</div>
			<div class="jp-no-solution">
				<?php printf( __( '<span>Update Required</span> To play the media you will need to either update your browser to a recent version or update your <a href="%s" target="_blank">Flash plugin</a>.', 'squareroot' ), 'http://get.adobe.com/flashplayer/' ); ?>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}


/**
 * Display post formats icon
 *
 * @param bool $link Link icon to post format archive?
 * @param bool $echo Display or return value
 *
 * @return void|string
 *
 * @since 1.0
 */
add_action( 'squareroot_icon', 'squareroot_format_icon' );
function squareroot_format_icon( $link = false, $echo = true ) {
	$icons  = array(
		'standard' => 'standard',
		'audio'    => 'audio',
		'video'    => 'video',
		'image'    => 'image',
		'gallery'  => 'gallery',
		'link'     => 'link',
		'quote'    => 'quote',
		'aside'    => 'aside',
		'status'   => 'status',
		'chat'     => 'chat',
	);
	$format = get_post_format();
	$icon   = isset( $icons[ $format ] ) ? $icons[ $format ] : 'standard';
	if ( $format == 'standard' && has_post_thumbnail() ) {
		$icon = 'standard';
	}
	$icon  = "<i class='icon-format-$icon'></i>";
	$class = ( get_post_type() == 'post' ? 'format' : 'format' ) . '-icon';
	if ( $link ) {
		$icon = "<a class='$class' href='" . get_post_format_link( $format ) . "'>$icon</a>";
	} else {
		$icon = "<div class='$class'>$icon</div>";
	}
	if ( $echo ) {
		echo $icon;
	} else {
		return $icon;
	}
}

/**
 * Get post thumbnail src based on post formats
 * @return void
 */
function squareroot_post_thumbnail_src( $size ) {
	$src = '';
	switch ( get_post_format() ) {
		case 'gallery':
			$images = squareroot_meta( 'images', "type=image&size=$size" );

			if ( empty( $images ) ) {
				break;
			}

			$image = current( $images );
			$src   = $image['url'];
			break;
		default:
			$src = squareroot_get_image( array(
				'size'     => $size,
				'format'   => 'src',
				'meta_key' => 'image',
				'echo'     => false,
			) );
			break;
	}

	return $src;
}

function squareroot_meta( $key, $args = array(), $post_id = null ) {
	if ( ! function_exists( 'rwmb_meta' ) ) {
		return false;
	}

	return rwmb_meta( $key, $args, $post_id );
}

function squareroot_get_image( $args = array() ) {
	$default = apply_filters(
		'squareroot_get_image_default_args',
		array(
			'post_id'  => get_the_ID(),
			'size'     => 'thumbnail',
			'format'   => 'html', // html or src
			'attr'     => '',
			'meta_key' => '',
			'scan'     => true,
			'default'  => '',
			'echo'     => true,
		)
	);

	$args = wp_parse_args( $args, $default );

	if ( ! $args['post_id'] ) {
		$args['post_id'] = get_the_ID();
	}

	// Get image from cache
	$key         = md5( serialize( $args ) );
	$image_cache = wp_cache_get( $args['post_id'], 'squareroot_get_image' );

	if ( ! is_array( $image_cache ) ) {
		$image_cache = array();
	}

	if ( empty( $image_cache[ $key ] ) ) {
		// Get post thumbnail
		if ( has_post_thumbnail( $args['post_id'] ) ) {
			$id   = get_post_thumbnail_id();
			$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
			list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
		}

		// Get the first image in the custom field
		if ( ! isset( $html, $src ) && $args['meta_key'] ) {
			$id = get_post_meta( $args['post_id'], $args['meta_key'], true );

			// Check if this post has attached images
			if ( $id ) {
				$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
				list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
			}
		}

		// Get the first attached image
		if ( ! isset( $html, $src ) ) {
			$image_ids = array_keys( get_children( array(
				'post_parent'    => $args['post_id'],
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
			) ) );

			// Check if this post has attached images
			if ( ! empty( $image_ids ) ) {
				$id   = $image_ids[0];
				$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
				list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
			}
		}

		// Get the first image in the post content
		if ( ! isset( $html, $src ) && ( $args['scan'] ) ) {
			preg_match( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $args['post_id'] ), $matches );

			if ( ! empty( $matches ) ) {
				$html = $matches[0];
				$src  = $matches[1];
			}
		}

		// Use default when nothing found
		if ( ! isset( $html, $src ) && ! empty( $args['default'] ) ) {
			if ( is_array( $args['default'] ) ) {
				$html = @$args['html'];
				$src  = @$args['src'];
			} else {
				$html = $src = $args['default'];
			}
		}

		// Still no images found?
		if ( ! isset( $html, $src ) ) {
			return false;
		}

		$output = 'html' === strtolower( $args['format'] ) ? $html : $src;

		$image_cache[ $key ] = $output;
		wp_cache_set( $args['post_id'], $image_cache, 'squareroot_get_image' );
	} // If image already cached
	else {
		$output = $image_cache[ $key ];
	}

	$output = apply_filters( 'squareroot_get_image', $output, $args );

	if ( ! $args['echo'] ) {
		return $output;
	}

	echo $output;
}
