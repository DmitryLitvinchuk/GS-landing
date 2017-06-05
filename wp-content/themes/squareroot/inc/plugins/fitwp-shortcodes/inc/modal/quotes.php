<div class="fitsc-config">
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Author', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="author" ng-init="author = '<?php _e( 'Author', 'fitsc' ); ?>'" type="text">
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Content', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<textarea ng-model="text" ng-init="text = 'Content'"></textarea>
			<span class="wp_themeSkin"><span class="mce_link mceIcon"></span></span>
		</div>
	</div>
</div>

<div class="fitsc-preview">
	<div class="fitsc-preview-shortcode">
		<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode";
			$text .= FITSC_Helper::shortcode_atts(
				'author'
			);
			$text .= "]{{text}}[/$shortcode]";
			echo $text;
			?></pre>
	</div>
</div>
