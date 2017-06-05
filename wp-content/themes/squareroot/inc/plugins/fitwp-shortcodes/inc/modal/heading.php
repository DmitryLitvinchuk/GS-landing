<div class="fitsc-config">
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Heading', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<select ng-model="style">
				<?php
				FITSC_Helper::options( array(
					'' => __( 'Style 1', 'fitsc' ),
					'2'      => __( 'Style 2', 'fitsc' ),
					'3'      => __( 'Style 3', 'fitsc' ),
					'4'      => __( 'Style 4', 'fitsc' ),
					'5'      => __( 'Style 5', 'fitsc' )
				) );
				?>
			</select>
		</div>
	</div>
	<div class="fitsc-field">
		<img ng-show="style==''" src="<?php echo FITSC_URL;?>/img/heading_1.jpg">
		<img ng-show="style=='2'" src="<?php echo FITSC_URL;?>/img/heading_2.jpg">
		<img ng-show="style=='3'" src="<?php echo FITSC_URL;?>/img/heading_3.jpg">
		<img ng-show="style=='4'" src="<?php echo FITSC_URL;?>/img/heading_4.jpg">
		<img ng-show="style=='5'" src="<?php echo FITSC_URL;?>/img/heading_5.jpg">
	</div>
	<div class="fitsc-field" ng-init="style = ''"  ng-show="style=='' || style=='4'">
		<label class="fitsc-label"><?php _e( 'Title', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="title" type="text" ng-init="title = ''">
			<!-- <select ng-model="size_title">
				<?php
				FITSC_Helper::options( array(
					'1' => __( 'h1', 'fitsc' ),
					''      => __( 'h2', 'fitsc' ),
					'3'      => __( 'h3', 'fitsc' ),
					'4'      => __( 'h4', 'fitsc' ),
					'5'      => __( 'h5', 'fitsc' ),
					'6'      => __( 'h6', 'fitsc' )
				) );
				?>
			</select> -->
			
		</div>
	</div>
	<div class="fitsc-field" ng-init="style = ''">
		<label class="fitsc-label"><?php _e( 'Title Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="tit_color" type="text" colorpicker>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label" ng-show="style=='' || style=='4'"><?php _e( 'Description', 'fitsc' ); ?></label>
		<label class="fitsc-label" ng-show="style=='2' || style=='3' || style=='5'"><?php _e( 'Title', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="text" ng-init="text = '<?php _e( '', 'fitsc' ); ?>'" type="text">
			<!-- <select ng-model="size_des">
				<?php
				FITSC_Helper::options( array(
					'1' => __( 'h1', 'fitsc' ),
					'2'      => __( 'h2', 'fitsc' ),
					''      => __( 'h3', 'fitsc' ),
					'4'      => __( 'h4', 'fitsc' ),
					'5'      => __( 'h5', 'fitsc' ),
					'6'      => __( 'h6', 'fitsc' )
				) );
				?>
			</select> -->
			

		</div>
	</div>
	<div class="fitsc-field" ng-show="style=='' || style=='4'">
		<label class="fitsc-label"><?php _e( 'Description Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="des_color" type="text" colorpicker>
		</div>
	</div>
</div>

<div class="fitsc-preview">
	<div class="fitsc-preview-shortcode">
		<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode";
			$text .= FITSC_Helper::shortcode_atts(
				'style'
				//'title'
				
			);
			$text .= "{{(style == '' || style == '4') && title && ( ' title=\"' + title + '\"' ) || ''}}";

			$text .= "{{size_title && title && ( ' size_tit=\"' + size_title + '\"' ) || ''}}";
			// $text .= "{{tit_color && title && ( ' tit_color=\"' + tit_color + '\"' ) || ''}}";
			// $text .= "{{tit_color && style == '5' && ( ' tit_color=\"' + tit_color + '\"' ) || ''}}";
			$text .= "{{tit_color && ( ' tit_color=\"' + tit_color + '\"' ) || ''}}";

			$text .= "{{(style == '' || style == '4') && size_des && text && ( ' size_des=\"' + size_des + '\"' ) || ''}}";
			$text .= "{{(style == '' || style == '4') && des_color && des_color && ( ' des_color=\"' + des_color + '\"' ) || ''}}";

			$text .= "]";
			$text .= "{{(style == '2' || style == '3' || style == '5') && text && ( '' + text + '' ) || ''}}";
			$text .= "{{(style == '' || style == '4') && text && ( '' + text + '' ) || ''}}";
			$text .= "[/$shortcode]";
			echo $text;
			?></pre>
	</div>
</div>
