<div class="fitsc-config">
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Type', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<select ng-model="type">
				<?php
				FITSC_Helper::options( array(
					'' => __( 'Youtube', 'fitsc' ),
					'vimeo'      => __( 'Vimeo', 'fitsc' )
				) );
				?>
			</select>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Auto Play', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<select ng-model="autoplay">
				<?php
				FITSC_Helper::options( array(
					'' => __( 'No', 'fitsc' ),
					'yes'      => __( 'Yes', 'fitsc' )
				) );
				?>
			</select>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Video ID', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="id" type="text" ng-init="id = 'GUEZCxBcM78'">
			<span class="wp_themeSkin"><span class="mce_link mceIcon"></span></span>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Width', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="width" ng-init="width = '<?php _e( '560', 'fitsc' ); ?>'" type="text">
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Height', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="height" ng-init="height = '<?php _e( '315', 'fitsc' ); ?>'" type="text">
		</div>
	</div>
</div>

<div class="fitsc-preview">
	<div class="fitsc-preview-shortcode">
		<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode";
			$text .= FITSC_Helper::shortcode_atts(
				'type',
				'id',
				'autoplay',
				'width',
				'height'
			);
			$text .= "]{{text}}[/$shortcode]";
			echo $text;
			?></pre>
	</div>
</div>
