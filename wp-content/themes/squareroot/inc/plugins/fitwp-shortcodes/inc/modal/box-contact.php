<div class="fitsc-config">
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Email', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="email" ng-init="email = '<?php _e( 'your-email@domain.com', 'fitsc' ); ?>'" type="text">
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Phone', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="telephone" type="text" ng-init="telephone = '0123456789'">
			<span class="wp_themeSkin"><span class="mce_link mceIcon"></span></span>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Address', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="address" type="text" ng-init="address = 'Your Address'">
			<span class="wp_themeSkin"><span class="mce_link mceIcon"></span></span>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Background Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="background" type="text" colorpicker>
		</div>
	</div>
</div>

<div class="fitsc-preview">
	<div class="fitsc-preview-shortcode">
		<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode";
			$text .= FITSC_Helper::shortcode_atts(
				'email',
				'telephone',
				'address',
				'background'
			);
			$text .= "]{{text}}[/$shortcode]";
			echo $text;
			?></pre>
	</div>
</div>
