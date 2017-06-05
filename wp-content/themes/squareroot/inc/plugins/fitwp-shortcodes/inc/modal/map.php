<div ng-controller="Map">

	<div class="fitsc-config">

		<div class="fitsc-field">
			<label class="fitsc-label"><?php _e( 'Insert Map Using', 'fitsc' ); ?></label>

			<div class="fitsc-controls">
				<label>
					<input ng-model="type" name="fitsc_<?php echo $shortcode; ?>_type" type="radio" value="">
					<?php _e( 'Address', 'fitsc' ); ?>
				</label>
				<label>
					<input ng-model="type" name="fitsc_<?php echo $shortcode; ?>_type" type="radio" value="latlng">
					<?php _e( 'Coordinates', 'fitsc' ); ?>
				</label>
			</div>
		</div>

		<div class="fitsc-field" ng-show="type == ''">
			<label class="fitsc-label"><?php _e( 'Address', 'fitsc' ); ?></label>

			<div class="fitsc-controls">
				<input ng-model="address" type="text">
			</div>
		</div>
		<div class="fitsc-field" ng-show="type == 'latlng'">
			<label class="fitsc-label"><?php _e( 'Latitude', 'fitsc' ); ?></label>

			<div class="fitsc-controls">
				<input ng-model="latitude" type="text">
			</div>
		</div>
		<div class="fitsc-field" ng-show="type == 'latlng'">
			<label class="fitsc-label"><?php _e( 'Longtitude', 'fitsc' ); ?></label>

			<div class="fitsc-controls">
				<input ng-model="longtitude" type="text">
			</div>
		</div>

		<div class="fitsc-field">
			<label class="fitsc-label"><?php _e( 'Map type', 'fitsc' ); ?></label>

			<div class="fitsc-controls">
				<select ng-model="map_type">
					<?php
					FITSC_Helper::options( array(
						''          => __( 'Road', 'fitsc' ),
						'satellite' => __( 'Satellite', 'fitsc' ),
						'hybrid'    => __( 'Hybrid', 'fitsc' ),
						'terrain'   => __( 'Terrain', 'fitsc' ),
					) );
					?>
				</select>
			</div>
		</div>
		<div class="fitsc-field">
			<label class="fitsc-label"><?php _e( 'Width', 'fitsc' ); ?></label>

			<div class="fitsc-controls">
				<input ng-model="width" type="text" size="4">
				<select ng-model="width_unit">
					<?php
					FITSC_Helper::options( array(
						'%'  => '%',
						'px' => 'px',
					) );
					?>
				</select>
			</div>
		</div>
		<div class="fitsc-field">
			<label class="fitsc-label"><?php _e( 'Height', 'fitsc' ); ?></label>

			<div class="fitsc-controls">
				<input ng-model="height" type="text" size="4">
				<select ng-model="height_unit">
					<?php
					FITSC_Helper::options( array(
						'%'  => '%',
						'px' => 'px',
					) );
					?>
				</select>
			</div>
		</div>
		<div class="fitsc-field">
			<label class="fitsc-label"><?php _e( 'Marker Title', 'fitsc' ); ?></label>

			<div class="fitsc-controls">
				<input ng-model="marker_title" type="text">
			</div>
		</div>
		<div class="fitsc-field">
			<label class="fitsc-label"><?php _e( 'Info Window', 'fitsc' ); ?></label>

			<div class="fitsc-controls">
				<textarea ng-model="info_window"></textarea>
			</div>
		</div>

		<?php include FITSC_INC . 'tpl/advanced.php'; ?>

		<div ng-show="advanced">
			<div class="fitsc-field">
				<label class="fitsc-label"><?php _e( 'Map Controls', 'fitsc' ); ?></label>

				<div class="fitsc-controls">
					<label ng-repeat="control in controls">
						<input type="checkbox" ng-model="control.checked" value="{{control.value}}"> {{control.name}}<br>
					</label>
				</div>
			</div>
			<div class="fitsc-field">
				<label class="fitsc-label"><?php _e( 'Zoom', 'fitsc' ); ?></label>

				<div class="fitsc-controls">
					<select ng-model="zoom">
						<?php
						FITSC_Helper::options(  array(
							6  => 6,
							7  => 7,
							8  => 8,
							9  => 9,
							10 => 10,
							11 => 11,
							12 => 12,
							13 => 13,
							14 => 14,
							15 => 15,
							16 => 16,
						) );
						?>
					</select>
				</div>
			</div>
			<div class="fitsc-field">
				<label class="fitsc-label"><?php _e( 'Scrollwheel', 'fitsc' ); ?></label>

				<div class="fitsc-controls">
					<?php FITSC_Helper::checkbox_angular( 'scrollwheel' ); ?>
				</div>
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
					'map_type',
					'marker_title',
					'info_window',
					'zoom',
					'scrollwheel'
				);
				$text .= "{{type == '' && address && ( ' address=\"' + address + '\"' ) || ''}}";
				$text .= "{{type == 'latlng' && latitude && ( ' latitude=\"' + latitude + '\"' ) || ''}}";
				$text .= "{{type == 'latlng' && longtitude && ( ' longtitude=\"' + longtitude + '\"' ) || ''}}";
				$text .= "{{width && ( ' width=\"' + width + width_unit + '\"' ) || ''}}";
				$text .= "{{height && ( ' height=\"' + height + height_unit + '\"' ) || ''}}";
				$text .= "{{selected() && ( ' controls=\"' + selected() + '\"' ) || ''}}";
				$text .= ']';
				echo $text;
				?></pre>
		</div>
	</div>
</div>