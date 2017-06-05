	<div class="fitsc-config">
			
			<div class="fitsc-field">
				<label class="fitsc-label"><?php _e( 'Button Navigation Position', 'fitsc' ); ?></label>

				<div class="fitsc-controls">
					<label>
						<!-- <input ng-model="selector_style" name="block.fitsc_<?php echo $shortcode; ?>_type_{{block.id}}" type="radio" value=""> -->
						 <input type="checkbox" ng-model="btn_top">
						<?php _e( 'Top', 'fitsc' ); ?>
					</label>&nbsp;
					<label>
						<!-- <input ng-model="selector_style" name="block.fitsc_<?php echo $shortcode; ?>_type_{{block.id}}" type="radio" value="1"> -->
						<input type="checkbox" ng-model="btn_bottom">
						<?php _e( 'Bottom', 'fitsc' ); ?>
					</label>&nbsp;
					<label>
						<!-- <input ng-model="selector_style" name="block.fitsc_<?php echo $shortcode; ?>_type_{{block.id}}" type="radio" value="2"> -->
						<input type="checkbox" ng-model="btn_sides">
						<?php _e( 'Sides', 'fitsc' ); ?>
					</label>
				</div>
			</div>
			<div class="fitsc-field">
				<label class="fitsc-label"><?php _e( 'Pagging Navigation Position', 'fitsc' ); ?></label>

				<div class="fitsc-controls">
					<label>
						<input ng-model="pag_position" name="fitsc_<?php echo $shortcode; ?>_type_{{block.id}}" type="radio" value="">
						 <!-- <input type="checkbox" ng-model="pag_top"> -->
						<?php _e( 'None', 'fitsc' ); ?>
					</label>&nbsp;
					<label>
						<input ng-model="pag_position" name="fitsc_<?php echo $shortcode; ?>_type_{{block.id}}" type="radio" value="top">
						 <!-- <input type="checkbox" ng-model="pag_top"> -->
						<?php _e( 'Top', 'fitsc' ); ?>
					</label>&nbsp;
					<label>
						<input ng-model="pag_position" name="fitsc_<?php echo $shortcode; ?>_type_{{block.id}}" type="radio" value="bottom">
						<!-- <input type="checkbox" ng-model="pag_bottom"> -->
						<?php _e( 'Bottom', 'fitsc' ); ?>
					</label>&nbsp;
					
				</div>
			</div>
			<div class="fitsc-field">
				<label class="fitsc-label"><?php _e( 'Auto Play', 'fitsc' ); ?></label>

				<div class="fitsc-controls">
					<input type="checkbox" ng-model="auto_play">
				</div>
			</div>
		

		<div class="fitsc-field">
			<label class="fitsc-label"><?php _e( 'Total number of items', 'fitsc' ); ?></label>

			<div class="fitsc-controls">
				<input ng-model="item_total" type="number" ng-style="{width: 16 + '%'}">
			</div>
		</div>
		<div class="fitsc-field">
			<label class="fitsc-label"><?php _e( 'Amount of items displayed at a time', 'fitsc' ); ?></label>

			<div class="fitsc-controls">
				<input ng-model="item_view" type="number" ng-style="{width: 16 + '%'}">
			</div>
		</div>
	</div>

	<div class="fitsc-preview">
		<div class="fitsc-preview-shortcode">
			<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode";
			$text .= FITSC_Helper::shortcode_atts(
				//'btn_position',
				'btn_top',
				'btn_bottom',
				'btn_sides',
				//'pag_top',
				//'pag_bottom',
				'pag_position',
				'auto_play',
				'item_view'
			);
			//$text .= "{{(btn_top||btn_bottom||btn_sides) && ( ' btn_position=\"' + icon_size + '\"' ) || ''}}";
			$text .= ']
';
			$text .= '<div ng-repeat="n in [] | range:item_total">';
			$text .= "[carousel_item][/carousel_item]
";
			//$text .= "a";
			$text .= "</div>";
			$text .= "[/$shortcode]";
			echo $text;
			?></pre>
		</div>
	</div>
