<div ng-controller="Block">

	<div class="fitsc-config">
		<div ng-repeat="block in blocks">
			<h3><?php _e( 'Edit Accordion', 'fitsc' ); ?></h3>

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
		</div>

		<a ng-click="add()" href="#" class="button"><?php _e( 'Add Accordion', 'fitsc' ); ?></a>
	</div>

	<div class="fitsc-preview">
		<div class="fitsc-preview-shortcode">
			<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode]";
			$text .= '<div ng-repeat="block in blocks">';
			$text .= '[accordion title="{{block.title}}"]{{block.content}}[/accordion]';
			$text .= '</div>';
			$text .= "[/$shortcode]";
			echo $text;
			?></pre>
		</div>
	</div>

</div>