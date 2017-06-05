<div class="fitsc-config">
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Row Inner', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<?php FITSC_Helper::checkbox_angular( 'row_inner' ); ?>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Width', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<select ng-model="width">
				<?php
				FITSC_Helper::options( array(
					''        => __( 'Full', 'fitsc' ),
					'boxed' => __( 'Boxed', 'fitsc' )
				) );
				?>
			</select>
		</div>
	</div>

	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Border', 'fitsc' ); ?></label>

		<div class="fitsc-controls">
			Top: <input ng-model="border_top" min="0" type="number" ng-style="{width: 16 + '%'}">
			Right: <input ng-model="border_right" min="0" type="number" ng-style="{width: 16 + '%'}">
			Bottom: <input ng-model="border_bottom" min="0" type="number" ng-style="{width: 16 + '%'}">
			Left: <input ng-model="border_left" min="0" type="number" ng-style="{width: 16 + '%'}"> px
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Border Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="border_color" type="text" colorpicker>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Border Radius', 'fitsc' ); ?></label>

		<div class="fitsc-controls">
			Top: <input ng-model="radius_top" min="0" type="number" ng-style="{width: 16 + '%'}">
			Right: <input ng-model="radius_right" min="0" type="number" ng-style="{width: 16 + '%'}">
			Bottom: <input ng-model="radius_bottom" min="0" type="number" ng-style="{width: 16 + '%'}">
			Left: <input ng-model="radius_left" min="0" type="number" ng-style="{width: 16 + '%'}">
				<select ng-model="radius_unit">
					<?php
					FITSC_Helper::options( array(
						''  => __( 'px', 'fitsc' ),
						'%' => __( '%', 'fitsc' ),
					) );
					?>
				</select>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Padding', 'fitsc' ); ?></label>

		<div class="fitsc-controls">
			Top: <input ng-model="padding_top" min="0" type="number" ng-style="{width: 16 + '%'}">
			Right: <input ng-model="padding_right" min="0" type="number" ng-style="{width: 16 + '%'}">
			Bottom: <input ng-model="padding_bottom" min="0" type="number" ng-style="{width: 16 + '%'}">
			Left: <input ng-model="padding_left" min="0" type="number" ng-style="{width: 16 + '%'}">
				<select ng-model="padding_unit">
					<?php
					FITSC_Helper::options( array(
						''  => 'px',
						'%' => '%'
					) );
					?>
				</select>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Margin', 'fitsc' ); ?></label>

		<div class="fitsc-controls">
			Top: <input ng-model="margin_top" type="number" ng-style="{width: 16 + '%'}">
			Right: <input ng-model="margin_right" type="number" ng-style="{width: 16 + '%'}">
			Bottom: <input ng-model="margin_bottom" type="number" ng-style="{width: 16 + '%'}">
			Left: <input ng-model="margin_left" type="number" ng-style="{width: 16 + '%'}">
				<select ng-model="margin_unit">
					<?php
					FITSC_Helper::options( array(
						''  => 'px',
						'%' => '%'
					) );
					?>
				</select>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Background Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="background_color" type="text" colorpicker>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Background Image URL', 'fitsc' ); ?></label>

		<div class="fitsc-controls">
			<input ng-model="background_url" type="text" style="width: 90%;">
			<button ng-model="image_upload_button" image-upload class="button">Upload</button>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Row Content', 'fitsc' ); ?></label>

		<div class="fitsc-controls">
			<textarea ng-model="text"></textarea>
		</div>
	</div>
	<div class="fitsc-field" ng-init="extra_class=''">
		<label class="fitsc-label"><?php _e( 'Extra Class', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="extra_class" ng-init="text = '<?php _e( '', 'fitsc' ); ?>'" type="text" style="width: 90%;">
		</div>
	</div>
</div>

<div class="fitsc-preview">
	<div class="fitsc-preview-shortcode">
		<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode";
			$text .= "{{row_inner && ( '_inner') || ''}}";

			$text .= FITSC_Helper::shortcode_atts(
				'width',
				'border_color',
				'background_color',
				'background_url',
				'extra_class'

			);
			//$text .= '<span ng-show="border_top || border_right || border_bottom || border_left"> border="<span ng-show="border_top">{{border_top}}</span><span ng-show="!border_top">0</span><span ng-show="border_right"> {{border_right}}</span><span ng-show="!border_right"> 0</span><span ng-show="border_bottom"> {{border_bottom}}</span><span ng-show="!border_bottom"> 0</span><span ng-show="border_left"> {{border_left}}</span><span ng-show="!border_left"> 0</span>"</span>';
			$text .= "<span ng-show=\"border_top|| border_top=='0' || border_right|| border_right=='0'  || border_bottom || border_bottom=='0' || border_left|| border_left=='0' \"> border=\"{{ (border_top == '0' || border_top) && ( '' + border_top + '' ) || 'n' }} {{ (border_right == '0' || border_right) && ( '' + border_right + '' ) || 'n' }} {{ (border_bottom == '0' || border_bottom) && ( '' + border_bottom + '' ) || 'n' }} {{ (border_left == '0' || border_left) && ( '' + border_left + '' ) || 'n' }}\"</span>";
			//$text .= '<span ng-show="radius_top || radius_right || radius_bottom || radius_left"> radius="<span ng-show="radius_top">{{radius_top}}{{radius_unit}}</span><span ng-show="!radius_top">0</span><span ng-show="radius_right"> {{radius_right}}{{radius_unit}}</span><span ng-show="!radius_right"> 0</span><span ng-show="radius_bottom"> {{radius_bottom}}{{radius_unit}}</span><span ng-show="!radius_bottom"> 0</span><span ng-show="radius_left"> {{radius_left}}{{radius_unit}}</span><span ng-show="!radius_left"> 0</span>"</span>';
			$text .= "<span ng-show=\"radius_top|| radius_top=='0' || radius_right|| radius_right=='0'  || radius_bottom || radius_bottom=='0' || radius_left|| radius_left=='0' \"> radius=\"{{ (radius_top == '0' || radius_top) && ( '' + radius_top + '' ) || 'n' }} {{ (radius_right == '0' || radius_right) && ( '' + radius_right + '' ) || 'n' }} {{ (radius_bottom == '0' || radius_bottom) && ( '' + radius_bottom + '' ) || 'n' }} {{ (radius_left == '0' || radius_left) && ( '' + radius_left + '' ) || 'n' }}\"</span>";
			//$text .= '<span ng-show="padding_top || padding_right || padding_bottom || padding_left"> padding="<span ng-show="padding_top">{{padding_top}}{{padding_unit}}</span><span ng-show="!padding_top">0</span><span ng-show="padding_right"> {{padding_right}}{{padding_unit}}</span><span ng-show="!padding_right"> 0</span><span ng-show="padding_bottom"> {{padding_bottom}}{{padding_unit}}</span><span ng-show="!padding_bottom"> 0</span><span ng-show="padding_left"> {{padding_left}}{{padding_unit}}</span><span ng-show="!padding_left"> 0</span>"</span>';
			$text .= "<span ng-show=\"padding_top|| padding_top=='0' || padding_right|| padding_right=='0'  || padding_bottom || padding_bottom=='0' || padding_left|| padding_left=='0' \"> padding=\"{{ (padding_top == '0' || padding_top) && ( '' + padding_top + '' ) || 'n' }} {{ (padding_right == '0' || padding_right) && ( '' + padding_right + '' ) || 'n' }} {{ (padding_bottom == '0' || padding_bottom) && ( '' + padding_bottom + '' ) || 'n' }} {{ (padding_left == '0' || padding_left) && ( '' + padding_left + '' ) || 'n' }}\"</span>";
			//$text .= '<span ng-show="margin_top || margin_right || margin_bottom || margin_left"> margin="<span ng-show="margin_top">{{margin_top}}{{margin_unit}}</span><span ng-show="!margin_top">0</span><span ng-show="margin_right"> {{margin_right}}{{margin_unit}}</span><span ng-show="!margin_right"> 0</span><span ng-show="margin_bottom"> {{margin_bottom}}{{margin_unit}}</span><span ng-show="!margin_bottom"> 0</span><span ng-show="margin_left"> {{margin_left}}{{margin_unit}}</span><span ng-show="!margin_left"> 0</span>"</span>';
			$text .= "<span ng-show=\"margin_top|| margin_top=='0' || margin_right|| margin_right=='0'  || margin_bottom || margin_bottom=='0' || margin_left|| margin_left=='0' \"> margin=\"{{ (margin_top == '0' || margin_top) && ( '' + margin_top + '' ) || 'n' }} {{ (margin_right == '0' || margin_right) && ( '' + margin_right + '' ) || 'n' }} {{ (margin_bottom == '0' || margin_bottom) && ( '' + margin_bottom + '' ) || 'n' }} {{ (margin_left == '0' || margin_left) && ( '' + margin_left + '' ) || 'n' }}\"</span>";
			$text .= "]{{text}}[/$shortcode";
			$text .= "{{row_inner && ( '_inner') || ''}}";
			$text .= "]";
			echo $text;
			?></pre>
	</div>
</div>
