<div class="fitsc-config">
	<div class="fitsc-field" ng-init="columns=''">
		<label class="fitsc-label"><?php _e( 'Columns', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<select ng-model="columns">
				<?php
FITSC_Helper::options( array(
'' => __( '1/1', 'fitsc' ),

'2' => __( '1/2 + 1/2', 'fitsc' ),
					
'3' => __( '1/3 + 1/3 + 1/3', 'fitsc' ),
					
'4' => __( '1/4 + 1/4 + 1/4 + 1/4', 'fitsc' ),

//'4' => __( '5', 'fitsc' ),
'6' => __( '1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6', 'fitsc' ),
					
'7' => __( '2/3 + 1/3', 'fitsc' ),
					
'8' => __( '1/4 + 3/4', 'fitsc' ),
					
'9' => __( '1/4 + 1/2 + 1/4', 'fitsc' ),
					
'10' => __( '5/6 + 1/6', 'fitsc' ),
					
'11' => __( '1/6 + 4/6 + 1/6', 'fitsc' ),
					
'12' => __( '1/6 + 1/6 + 1/6 + 1/2', 'fitsc' ),
));
				?>
			</select>
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
			// $text = "{{columns=='' && ( '[column width=&quot;1/1&quot;";
			// $text .= "{{extra_class}}";
			// $text .="]Your content here[/column]') || columns}}";
			$text = "{{columns=='' && extra_class == '' && ('[column width=&quot;1/1&quot;]Your content here[/column]') || ''}}";
			$text .= "{{columns=='' && extra_class && ('[column width=&quot;1/1&quot; extra_class=\"' + extra_class+ '\"]Your content here[/column]') || ''}}";

			$text .= "{{columns=='2' && extra_class=='' && ('";
			$text .= "[column width=&quot;1/2&quot;]Column Content[/column]
[column width=&quot;1/2&quot;]Column Content[/column]";
			$text .= "') || '' }}";
			$text .= "{{columns=='2' && extra_class && ('";
			$text .= "[column width=&quot;1/2&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/2&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]";
			$text .= "') || ''}}";

			$text .= "{{columns=='3' && extra_class=='' && ('";
			$text .= "[column width=&quot;1/3&quot;]Column Content[/column]
[column width=&quot;1/3&quot;]Column Content[/column]
[column width=&quot;1/3&quot;]Column Content[/column]";
			$text .= "') || '' }}";
			$text .= "{{columns=='3' && extra_class && ('";
			$text .= "[column width=&quot;1/3&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/3&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/3&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]";
			$text .= "') || ''}}";

			$text .= "{{columns=='4' && extra_class=='' && ('";
			$text .= "[column width=&quot;1/4&quot;]Column Content[/column]
[column width=&quot;1/4&quot;]Column Content[/column]
[column width=&quot;1/4&quot;]Column Content[/column]
[column width=&quot;1/4&quot;]Column Content[/column]";
			$text .= "') || '' }}";
			$text .= "{{columns=='4' && extra_class && ('";
			$text .= "[column width=&quot;1/4&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/4&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/4&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/4&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]";
			$text .= "') || ''}}";
			
			$text .= "{{columns=='6' && extra_class=='' && ('";
			$text .= "[column width=&quot;1/6&quot;]Column Content[/column]
[column width=&quot;1/6&quot;]Column Content[/column]
[column width=&quot;1/6&quot;]Column Content[/column]
[column width=&quot;1/6&quot;]Column Content[/column]
[column width=&quot;1/6&quot;]Column Content[/column]
[column width=&quot;1/6&quot;]Column Content[/column]";
			$text .= "') || '' }}";
			$text .= "{{columns=='6' && extra_class && ('";
			$text .= "[column width=&quot;1/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]";
			$text .= "') || ''}}";

			$text .= "{{columns=='7' && extra_class=='' && ('";
			$text .= "[column width=&quot;2/3&quot;]Column Content[/column]
[column width=&quot;1/3&quot;]Column Content[/column]";
			$text .= "') || '' }}";
			$text .= "{{columns=='7' && extra_class && ('";
			$text .= "[column width=&quot;2/3&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/3&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]";
			$text .= "') || ''}}";

			$text .= "{{columns=='8' && extra_class=='' && ('";
			$text .= "[column width=&quot;1/4&quot;]Column Content[/column]
[column width=&quot;3/4&quot;]Column Content[/column]";
			$text .= "') || '' }}";
			$text .= "{{columns=='8' && extra_class && ('";
			$text .= "[column width=&quot;1/4&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;3/4&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]";
			$text .= "') || ''}}";
			
			$text .= "{{columns=='9' && extra_class=='' && ('";
			$text .= "[column width=&quot;1/4&quot;]Column Content[/column]
[column width=&quot;1/2&quot;]Column Content[/column]
[column width=&quot;1/4&quot;]Column Content[/column]";
			$text .= "') || '' }}";
			$text .= "{{columns=='9' && extra_class && ('";
			$text .= "[column width=&quot;1/4&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/2&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/4&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]";
			$text .= "') || ''}}";

			$text .= "{{columns=='10' && extra_class=='' && ('";
			$text .= "[column width=&quot;5/6&quot;]Column Content[/column]
[column width=&quot;1/6&quot;]Column Content[/column]";
			$text .= "') || '' }}";
			$text .= "{{columns=='10' && extra_class && ('";
			$text .= "[column width=&quot;5/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]";
			$text .= "') || ''}}";

			$text .= "{{columns=='11' && extra_class=='' && ('";
			$text .= "[column width=&quot;1/6&quot;]Column Content[/column]
[column width=&quot;4/6&quot;]Column Content[/column]
[column width=&quot;1/6&quot;]Column Content[/column]";
			$text .= "') || '' }}";
			$text .= "{{columns=='11' && extra_class && ('";
			$text .= "[column width=&quot;1/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;4/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]";
			$text .= "') || ''}}";

			$text .= "{{columns=='12' && extra_class=='' && ('";
			$text .= "[column width=&quot;1/6&quot;]Column Content[/column]
[column width=&quot;1/6&quot;]Column Content[/column]
[column width=&quot;1/6&quot;]Column Content[/column]
[column width=&quot;1/2&quot;]Column Content[/column]";
			$text .= "') || '' }}";
			$text .= "{{columns=='12' && extra_class && ('";
			$text .= "[column width=&quot;1/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/6&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]
[column width=&quot;1/2&quot; extra_class=\"' + extra_class+ '\"]Column Content[/column]";
			$text .= "') || ''}}";
			echo $text;
			?></pre>
	</div>
</div>
