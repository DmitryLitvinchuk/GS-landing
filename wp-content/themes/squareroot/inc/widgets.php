<?php

/********************************************************************
 * social_links
 ********************************************************************/
class squareroot_social_links extends WP_Widget {
	/**
	 * squareroot_social_links constructor.
	 */
	function __construct() {
		$widget_ops = array( 'classname' => 'social_links', 'description' => 'Social Links' );
		parent::__construct( 'widget_social_links', 'Squareroot: Social Links', $widget_ops );
	}

	function widget( $args, $instance ) {
		$link_face      = empty( $instance['link_face'] ) ? '' : apply_filters( 'widget_link_face', $instance['link_face'] );
		$link_twitter   = empty( $instance['link_twitter'] ) ? '' : apply_filters( 'widget_link_twitter', $instance['link_twitter'] );
		$link_google    = empty( $instance['link_google'] ) ? '' : apply_filters( 'widget_link_google', $instance['link_google'] );
		$link_dribble   = empty( $instance['link_dribble'] ) ? '' : apply_filters( 'widget_link_dribble', $instance['link_dribble'] );
		$link_linkedin  = empty( $instance['link_linkedin'] ) ? '' : apply_filters( 'widget_link_linkedin', $instance['link_linkedin'] );
		$link_pinterest = empty( $instance['link_pinterest'] ) ? '' : apply_filters( 'widget_link_pinterest', $instance['link_pinterest'] );
		$link_digg      = empty( $instance['link_digg'] ) ? '' : apply_filters( 'widget_link_digg', $instance['link_digg'] );
		$link_youtube   = empty( $instance['link_youtube'] ) ? '' : apply_filters( 'widget_link_youtube', $instance['link_youtube'] );
		$link_instagram = empty( $instance['link_instagram'] ) ? '' : apply_filters( 'widget_link_instagram', $instance['link_instagram'] );
		$link_snap      = empty( $instance['link_snap'] ) ? '' : apply_filters( 'widget_link_snap', $instance['link_snap'] );
		$target         = empty( $instance['target'] ) ? '' : $instance['target'];
		$class_custom   = empty( $instance['class_custom'] ) ? '' : apply_filters( 'widget_class_custom', $instance['class_custom'] );
		echo $args['before_widget'];
		?>
		<?php if ( $class_custom <> '' ) {
			echo '<div class="' . $class_custom . '">';
		}
		?>
		<ul class="socials">
			<?php
			if ( $link_face != '' ) {
				echo '<li><a class="facebook hasTooltip" target="' . $target . '" href="' . esc_url( $link_face ) . '" title="' . __( 'Facebooks', 'squareroot' ) . '"><i class="fa fa-facebook"></i></a></li>';
			}
			if ( $link_twitter != '' ) {
				echo '<li><a class="twitter hasTooltip" target="' . $target . '" href="' . esc_url( $link_twitter ) . '"  title="' . __( 'Twitter', 'squareroot' ) . '"><i class="fa fa-twitter"></i></a></li>';
			}
			if ( $link_google != '' ) {
				echo '<li><a class="google hasTooltip" target="' . $target . '" href="' . esc_url( $link_google ) . '"  title="' . __( 'Google', 'squareroot' ) . '"><i class="fa fa-google"></i></a></li>';
			}
			if ( $link_dribble != '' ) {
				echo '<li><a class="dribble hasTooltip" target="' . $target . '" href="' . esc_url( $link_dribble ) . '"  title="' . __( 'Dribble', 'squareroot' ) . '"><i class="fa fa-dribbble"></i></a></li>';
			}
			if ( $link_linkedin != '' ) {
				echo '<li><a class="linkedin hasTooltip" target="' . $target . '" href="' . esc_url( $link_linkedin ) . '"  title="' . __( 'Linkedin', 'squareroot' ) . '"><i class="fa fa-linkedin"></i></a></li>';
			}
			if ( $link_pinterest != '' ) {
				echo '<li><a class="pinterest hasTooltip" target="' . $target . '" href="' . esc_url( $link_pinterest ) . '"  title="' . __( 'Pinterest', 'squareroot' ) . '"><i class="fa fa-pinterest"></i></a></li>';
			}
			if ( $link_digg != '' ) {
				echo '<li><a class="digg hasTooltip" target="' . $target . '" href="' . esc_url( $link_digg ) . '"  title="' . __( 'Digg', 'squareroot' ) . '"><i class="fa fa-digg"></i></a></li>';
			}
			if ( $link_youtube != '' ) {
				echo '<li><a class="youtube hasTooltip" target="' . $target . '" href="' . esc_url( $link_youtube ) . '"  title="' . __( 'Youtube', 'squareroot' ) . '"><i class="fa fa-youtube"></i></a></li>';
			}
			if ( $link_instagram != '' ) {
				echo '<li><a class="instagram hasTooltip" target="' . $target . '" href="' . esc_url( $link_instagram ) . '"  title="' . __( 'Instagram', 'squareroot' ) . '"><i class="fa fa-instagram"></i></a></li>';
			}
			if ( $link_snap != '' ) {
				echo '<li><a class="snap hasTooltip" target="' . $target . '" href="' . esc_url( $link_snap ) . '"  title="' . __( 'Snapchat', 'squareroot' ) . '"><i class="fa fa-snapchat-ghost"></i></a></li>';
			}
			?>
		</ul>

		<?php if ( $class_custom <> '' ) {
			echo '</div>';
		} ?>

		<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['link_face']      = strip_tags( $new_instance['link_face'] );
		$instance['link_twitter']   = strip_tags( $new_instance['link_twitter'] );
		$instance['link_google']    = strip_tags( $new_instance['link_google'] );
		$instance['link_dribble']   = strip_tags( $new_instance['link_dribble'] );
		$instance['link_linkedin']  = strip_tags( $new_instance['link_linkedin'] );
		$instance['link_pinterest'] = strip_tags( $new_instance['link_pinterest'] );
		$instance['link_digg']      = strip_tags( $new_instance['link_digg'] );
		$instance['link_youtube']   = strip_tags( $new_instance['link_youtube'] );
		$instance['link_instagram'] = strip_tags( $new_instance['link_instagram'] );
		$instance['link_snap']      = strip_tags( $new_instance['link_snap'] );
		$instance['target']         = $new_instance['target'];
		$instance['class_custom']   = strip_tags( $new_instance['class_custom'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'          => '',
			'link_face'      => '',
			'link_twitter'   => '',
			'link_google'    => '',
			'link_dribble'   => '',
			'link_linkedin'  => '',
			'link_pinterest' => '',
			'link_digg'      => '',
			'link_youtube'   => '',
			'link_instagram' => '',
			'link_snap'      => '',
			'target'         => '',
			'class_custom'   => ''
		) );

		$link_face      = strip_tags( $instance['link_face'] );
		$link_twitter   = strip_tags( $instance['link_twitter'] );
		$link_google    = strip_tags( $instance['link_google'] );
		$link_dribble   = strip_tags( $instance['link_dribble'] );
		$link_linkedin  = strip_tags( $instance['link_linkedin'] );
		$link_pinterest = strip_tags( $instance['link_pinterest'] );
		$link_digg      = strip_tags( $instance['link_digg'] );
		$link_youtube   = strip_tags( $instance['link_youtube'] );
		$link_instagram = strip_tags( $instance['link_instagram'] );
		$link_snap      = strip_tags( $instance['link_snap'] );
		$target         = $instance['target'];
		$class_custom   = strip_tags( $instance['class_custom'] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_face' ); ?>"><?php _e( 'Facebook Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_face' ); ?>" name="<?php echo $this->get_field_name( 'link_face' ); ?>" value="<?php echo esc_attr( $link_face ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_twitter' ); ?>"><?php _e( 'Twitter Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_twitter' ); ?>" name="<?php echo $this->get_field_name( 'link_twitter' ); ?>" value="<?php echo esc_attr( $link_twitter ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_google' ); ?>"><?php _e( 'Google Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_google' ); ?>" name="<?php echo $this->get_field_name( 'link_google' ); ?>" value="<?php echo esc_attr( $link_google ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_dribble' ); ?>"><?php _e( 'Dribble Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_dribble' ); ?>" name="<?php echo $this->get_field_name( 'link_dribble' ); ?>" value="<?php echo esc_attr( $link_dribble ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_linkedin' ); ?>"><?php _e( 'Linkedin Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_linkedin' ); ?>" name="<?php echo $this->get_field_name( 'link_linkedin' ); ?>" value="<?php echo esc_attr( $link_linkedin ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'link_pinterest' ); ?>"><?php _e( 'Pinterest Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_pinterest' ); ?>" name="<?php echo $this->get_field_name( 'link_pinterest' ); ?>" value="<?php echo esc_attr( $link_pinterest ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'link_digg' ); ?>"><?php _e( 'Digg Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_digg' ); ?>" name="<?php echo $this->get_field_name( 'link_digg' ); ?>" value="<?php echo esc_attr( $link_digg ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_youtube' ); ?>"><?php _e( 'Youtube Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_youtube' ); ?>" name="<?php echo $this->get_field_name( 'link_youtube' ); ?>" value="<?php echo esc_attr( $link_youtube ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_instagram' ); ?>"><?php _e( 'Instagram Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_instagram' ); ?>" name="<?php echo $this->get_field_name( 'link_instagram' ); ?>" value="<?php echo esc_attr( $link_instagram ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_snap' ); ?>"><?php _e( 'Snapchat Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_snap' ); ?>" name="<?php echo $this->get_field_name( 'link_snap' ); ?>" value="<?php echo esc_attr( $link_snap ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'class_custom' ); ?>"><?php _e( 'CSS Class: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'class_custom' ); ?>" name="<?php echo $this->get_field_name( 'class_custom' ); ?>" value="<?php echo esc_attr( $class_custom ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>">Target:
				<select class='widefat' id="<?php echo $this->get_field_id( 'target' ); ?>"
						name="<?php echo $this->get_field_name( 'target' ); ?>" type="text">
					<option value='_blank'<?php echo ( $target == '_Blank' ) ? 'selected' : ''; ?>>
						_Blank
					</option>
					<option value='Normal'<?php echo ( $target == 'Normal' ) ? 'selected' : ''; ?>>
						Normal
					</option>
				</select>
			</label>
		</p>

		<?php
	}
}

register_widget( 'squareroot_social_links' );

class squareroot_select_links extends WP_Widget {
	/**
	 * squareroot_social_links constructor.
	 */
	function __construct() {
		$widget_ops = array( 'classname' => 'select', 'description' => 'Test Select' );
		parent::__construct( 'widget_select', 'Squareroot: Test Select', $widget_ops );
	}

	public function form( $instance ) {
		// PART 1: Extract the data from the instance variable
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title    = $instance['title'];
		$city     = $instance['city'];

		// PART 2-3: Display the fields
		?>
		<!-- PART 2: Widget Title field START -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
					   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
					   value="<?php echo attribute_escape( $title ); ?>" />
			</label>
		</p>
		<!-- Widget Title field END -->

		<!-- PART 3: Widget City field START -->
		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>">City:
				<select class='widefat' id="<?php echo $this->get_field_id( 'city' ); ?>"
						name="<?php echo $this->get_field_name( 'city' ); ?>" type="text">
					<option value='New York'<?php echo ( $city == 'New York' ) ? 'selected' : ''; ?>>
						New York
					</option>
					<option value='Los Angeles'<?php echo ( $city == 'Los Angeles' ) ? 'selected' : ''; ?>>
						Los Angeles
					</option>
					<option value='Boston'<?php echo ( $city == 'Boston' ) ? 'selected' : ''; ?>>
						Boston
					</option>
				</select>
			</label>
		</p>
		<!-- Widget City field END -->
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['city']  = $new_instance['city'];

		return $instance;
	}

	function widget( $args, $instance ) {
		// PART 1: Extracting the arguments + getting the values
		extract( $args, EXTR_SKIP );
		$title = empty( $instance['title'] ) ? ' ' : apply_filters( 'widget_title', $instance['title'] );
		$city  = empty( $instance['city'] ) ? '' : $instance['city'];

		// Before widget code, if any
		echo( isset( $before_widget ) ? $before_widget : '' );

		// PART 2: The title and the text output
		if ( !empty( $title ) ) {
			echo $before_title . $title . $after_title;
		};
		if ( !empty( $city ) ) {
			echo $city;
		}

		// After widget code, if any
		echo( isset( $after_widget ) ? $after_widget : '' );
	}
}

register_widget( 'squareroot_select_links' );