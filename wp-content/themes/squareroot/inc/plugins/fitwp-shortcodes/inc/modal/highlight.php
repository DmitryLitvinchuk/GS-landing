<div class="fitsc-config">
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Background Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<?php FITSC_Helper::color_schemes( 'background' );  ?>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Custom Background Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="custom_background" type="text" colorpicker>
		</div>
	</div>
</div>

<div class="fitsc-preview">
	<div class="fitsc-preview-shortcode">
		<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode";
			$text .= FITSC_Helper::shortcode_atts( 'background', 'custom_background' );
			$text .= "]%SELECTION%[/$shortcode]";
			echo $text;
			?></pre>
	</div>
</div>
