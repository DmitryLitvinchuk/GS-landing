<div class="fitsc-config">
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Text', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="text" ng-init="text = '<?php _e( 'Simple, Customizable, Light Weight, Easy', 'fitsc' ); ?>'" type="text" style="width: 100%;padding: 3px;margin: 0;">
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Effect', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<select ng-model="effect">
				<?php
				FITSC_Helper::options( array(
					'' => __( 'Random', 'fitsc' ),
					''      => __( 'fade', 'fitsc' ),
					'flipCube' => __( 'flipCube', 'fitsc' ),
					'flipUp' => __( 'flipUp', 'fitsc' ),
					'spin' => __( 'spin', 'fitsc' )
				) );
				?>
			</select>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Background Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="background" type="text" colorpicker>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Text Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="color" type="text" colorpicker>
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
</div>

<div class="fitsc-preview">
	<div class="fitsc-preview-shortcode">
		<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode";
			$text .= FITSC_Helper::shortcode_atts(
				'effect',
				'background',
				'color'
			);
			//$text .= '<span ng-show="padding_top || padding_right || padding_bottom || padding_left"> padding="<span ng-show="padding_top">{{padding_top}}{{padding_unit}}</span><span ng-show="!padding_top">0</span><span ng-show="padding_right"> {{padding_right}}{{padding_unit}}</span><span ng-show="!padding_right"> 0</span><span ng-show="padding_bottom"> {{padding_bottom}}{{padding_unit}}</span><span ng-show="!padding_bottom"> 0</span><span ng-show="padding_left"> {{padding_left}}{{padding_unit}}</span><span ng-show="!padding_left"> 0</span>"</span>';
			$text .= "<span ng-show=\"padding_top|| padding_top=='0' || padding_right|| padding_right=='0'  || padding_bottom || padding_bottom=='0' || padding_left|| padding_left=='0' \"> padding=\"{{ (padding_top == '0' || padding_top) && ( '' + padding_top + '' ) || 'n' }} {{ (padding_right == '0' || padding_right) && ( '' + padding_right + '' ) || 'n' }} {{ (padding_bottom == '0' || padding_bottom) && ( '' + padding_bottom + '' ) || 'n' }} {{ (padding_left == '0' || padding_left) && ( '' + padding_left + '' ) || 'n' }}\"</span>";
			$text .= "]{{text}}[/$shortcode]";
			echo $text;
			?></pre>
	</div>
</div>
