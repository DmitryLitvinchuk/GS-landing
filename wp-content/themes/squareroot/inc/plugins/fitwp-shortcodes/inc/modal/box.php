<div class="fitsc-config">
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Type', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<select ng-model="type">
				<?php
				FITSC_Helper::options( array(
					''        => __( 'Alert', 'fitsc' ),
					'success' => __( 'Success', 'fitsc' ),
					'error'   => __( 'Error', 'fitsc' ),
					'info'    => __( 'Info', 'fitsc' ),
				) );
				?>
			</select>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Content', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<textarea ng-model="content"></textarea>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Close Icon?', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<?php FITSC_Helper::checkbox_angular( 'close', true ); ?>
		</div>
	</div>
</div>

<div class="fitsc-preview">
	<div class="fitsc-preview-shortcode">
		<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode";
			$text .= FITSC_Helper::shortcode_atts( 'type', 'close' );
			$text .= "]{{content}}[/$shortcode]";
			echo $text;
		?></pre>
	</div>
</div>
