<div class="fitsc-config">
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Content', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<textarea ng-model="text"></textarea>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'CSS Animation', 'fitsc' ); ?></label>
			<div class="fitsc-controls">
				<select ng-model="css_animation">
					<?php
					FITSC_Helper::options( array(
						'' => __( 'No', 'fitsc' ),
						'top-to-bottom'      => __( 'Top to bottom', 'fitsc' ),
						'bottom-to-top'      => __( ' Bottom to top', 'fitsc' ),
						'left-to-right'      => __( ' Left to right', 'fitsc' ),
						'right-to-left'      => __( ' Right to left', 'fitsc' ),
						'appear'      => __( ' Appear from center', 'fitsc' )
					) );
					?>
				</select>
			</div>
	</div>
</div>

<div class="fitsc-preview">
	<div class="fitsc-preview-shortcode">
		<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode";
			$text .= FITSC_Helper::shortcode_atts(
				'css_animation'
			);
			$text .= "]{{text}}[/$shortcode]";
			echo $text;
			?></pre>
	</div>
</div>
