<div class="fitsc-config">
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Text', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="text" type="text">
		</div>
	</div>
</div>

<div class="fitsc-preview">
	<div class="fitsc-preview-shortcode">
		<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode";
			$text .= FITSC_Helper::shortcode_atts('text');
			$text .= ']';
			echo $text;
		?></pre>
	</div>
</div>
