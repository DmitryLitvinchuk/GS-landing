<div ng-controller="Block">

	<div class="fitsc-config">
		<div class="fitsc-field" ng-init="type = ''">
			<label class="fitsc-label"><?php _e( 'Type', 'fitsc' ); ?></label>

			<div class="fitsc-controls">
				<label>
					<input ng-model="type" type="radio" name="type" value="">
					<?php _e( 'Horizontal', 'fitsc' ); ?>
				</label> <label>
					<input ng-model="type" type="radio" name="type" value="vertical">
					<?php _e( 'Vertical', 'fitsc' ); ?>
				</label>
			</div>
		</div>
		<div ng-repeat="block in blocks">
			<h3><?php _e( 'Edit Tab', 'fitsc' ); ?></h3>

			<div class="fitsc-field">
				<label class="fitsc-label"><?php _e( 'Title', 'fitsc' ); ?></label>

				<div class="fitsc-controls">
					<input ng-model="block.title" type="text">
				</div>
			</div>
			<div class="fitsc-field">
				<label class="fitsc-label"><?php _e( 'Content', 'fitsc' ); ?></label>

				<div class="fitsc-controls">
					<textarea ng-model="block.content"></textarea>
				</div>
			</div>
			<div class="fitsc-field">
				<label class="fitsc-label"><?php _e( 'Icon', 'fitsc' ); ?></label>

				<div class="fitsc-controls">
					<input ng-model="search" type="text" placeholder="<?php _e( 'Search Icon', 'fitsc' ); ?>">

					<div class="fitsc-icons">
						<label class="fitsc-icon" ng-repeat="icon in icons | filter: search">
							<i class="{{icon.class}}"></i>
							<input ng-model="block.icon" type="radio" name="icon_{{block.id}}" value="{{icon.class}}" class="hidden">
						</label>
					</div>
				</div>
			</div>
		</div>

		<a ng-click="add()" href="#" class="button">Add Tab</a>
	</div>

	<div class="fitsc-preview">
		<div class="fitsc-preview-shortcode">
			<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode";
			$text .= FITSC_Helper::shortcode_atts( 'type' );
			$text .= ']';
			$text .= '<div ng-repeat="block in blocks">';
			$text .= '[tab title="{{block.title}}" icon="{{block.icon}}"]{{block.content}}[/tab]';
			$text .= '</div>';
			$text .= "[/$shortcode]";
			echo $text;
			?></pre>
		</div>
	</div>

</div>