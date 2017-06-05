<div class="fitsc-config">
	<div class="fitsc-field" ng-init="style=''" ng-hide="true">
		<label class="fitsc-label"><?php _e( 'Style', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<select ng-model="style">
				<?php
				FITSC_Helper::options( array(
					''       => __( 'Default', 'fitsc' )
				) );
				?>
			</select>
		</div>
	</div>
	<!-- <div class="fitsc-field" ng-show="style == '1'">
		<label class="fitsc-label"><?php _e( 'Image Url', 'fitsc' ); ?></label>

		<div class="fitsc-controls">
			<input ng-model="img_url" type="text" style="width: 100%;padding: 3px;margin: 0;">
		</div>
	</div> -->
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Box Border', 'fitsc' ); ?></label>

		<div class="fitsc-controls">
			<input ng-model="box_border" type="number" ng-style="{width: 16 + '%'}"> px
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Box Border Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="box_border_color" type="text" colorpicker>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Box Background Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="box_bg_color" type="text" colorpicker>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Title', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="title" type="text" ng-init="title = 'This is an icon box.'">
			<select ng-model="title_size">
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
			</select>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Title Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="title_color" type="text" colorpicker>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Title Background Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="title_bg_color" type="text" colorpicker>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Title Padding', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="title_padding" type="number" ng-style="{width: 16 + '%'}">
			<select ng-model="title_padding_unit">
				<?php
				FITSC_Helper::options( array(
					''  => 'px'
				) );
				?>
			</select>
		</div>
	</div>
	<div class="fitsc-field" ng-init"text='Icon Box Description'">
		<label class="fitsc-label"><?php _e( 'Description', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<!-- <input ng-model="text" ng-init="text = '<?php _e( 'Write a short description, that will describe the title or something informational and useful.', 'fitsc' ); ?>'" type="text"> -->
			<textarea ng-model="text" placeholder="Write a short description, that will describe the title or something informational and useful." ng-init="data='Templated in'">Icon Box Description</textarea>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Description Padding', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="desc_padding" type="number" ng-style="{width: 16 + '%'}">
			<select ng-model="desc_padding_unit">
				<?php
				FITSC_Helper::options( array(
					''  => 'px'
				) );
				?>
			</select>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Box Link', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="link" type="text" ng-init="link = ''">
			<span class="wp_themeSkin"><span class="mce_link mceIcon"></span></span>
		</div>
	</div>
	<div class="fitsc-field" ng-init="icon_position='top'">
		<label class="fitsc-label"><?php _e( 'Icon Position', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<select ng-model="icon_position">
				<?php
				FITSC_Helper::options( array(
					'top'       => __( 'Top', 'fitsc' ),
					'left' => __( 'Left', 'fitsc' ),
					'right' => __( 'Right', 'fitsc' ),
				) );
				?>
			</select>
		</div>
	</div>
	<div class="fitsc-field" ng-show="style == ''" ng-init="icon_type=''">
		<label class="fitsc-label"><?php _e( 'Icon Type', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<select ng-model="icon_type">
				<?php
				FITSC_Helper::options( array(
					'' => __( 'Font Awesome Icon', 'fitsc' ),
					'custom'      => __( 'Custom', 'fitsc' ),
				) );
				?>
			</select>
		</div>
	</div>
	<div class="fitsc-field" ng-show="style == '' && icon_type == ''" ng-init="icon='fa fa-star-o'">
		<label class="fitsc-label"><?php _e( 'Icon', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<?php FITSC_Helper::icons( 'icon' );  ?>
		</div>
	</div>
	<div class="fitsc-field" ng-show="icon_type == 'custom'">
		<label class="fitsc-label"><?php _e( 'Icon Url', 'fitsc' ); ?></label>

		<div class="fitsc-controls">
			<input ng-model="icon_url" type="text" style="width: 90%;">
			<button ng-model="image_upload_button" image-upload class="button">Upload</button>
		</div>
	</div>
	<div class="fitsc-field" ng-show="icon_type == ''">
		<label class="fitsc-label"><?php _e( 'Icon Size', 'fitsc' ); ?></label>

		<div class="fitsc-controls">
				<input ng-model="icon_size" type="number" ng-style="{width: 16 + '%'}">
				<select ng-model="icon_size_unit">
					<?php
					FITSC_Helper::options( array(
						''  => 'px'
					) );
					?>
				</select>
		</div>
	</div>
	<div class="fitsc-field">
		<!-- <label class="fitsc-label"><?php _e( 'Height', 'fitsc' ); ?></label> -->

		<div class="fitsc-controls">
			Width: <input ng-model="icon_width" type="text">
			 Height: <input ng-model="icon_height" type="text">
			 <select ng-model="icon_wh_unit">
				<?php
				FITSC_Helper::options( array(
					'' => __( 'px', 'fitsc' ),
				) );
				?>
			</select>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Icon Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="icon_color" type="text" colorpicker>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Icon Background Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="icon_bg_color" type="text" colorpicker>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Icon Border', 'fitsc' ); ?></label>

		<div class="fitsc-controls">
			<input ng-model="icon_border" type="number" ng-style="{width: 16 + '%'}"> px
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Icon Border Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="icon_border_color" type="text" colorpicker>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Icon Border Radius', 'fitsc' ); ?></label>

		<div class="fitsc-controls">
			<input ng-model="icon_radius" type="number" ng-style="{width: 16 + '%'}">
				<select ng-model="icon_radius_unit">
					<?php
					FITSC_Helper::options( array(
						''  => __( 'px', 'fitsc' ),
						'%' => __( '%', 'fitsc' ),
					) );
					?>
				</select>
		</div>
	</div>
	<!-- icon outer 

	.icon_box .ib_icon {
	display: table;
	margin: 0 auto;
	padding: 7px;
	border-radius: 50%;
	background: #ccc;
	border: 1px #ccc solid;
	}
	-->
	<div class="fitsc-field" ng-show="style == ''" ng-init="icon_effect=''">
		<label class="fitsc-label"><?php _e( 'Icon Effect', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<select ng-model="icon_effect">
				<?php
				FITSC_Helper::options( array(
					'' => __( 'None', 'fitsc' ),
					'random' => __( 'Random', 'fitsc' ),
					'first'      => __( 'First', 'fitsc' ),
					'second' => __( 'Second', 'fitsc' ),
					'third' => __( 'Third', 'fitsc' ),
					'fourth' => __( 'Fourth', 'fitsc' )
					// ,'fifth' => __( 'Fifth', 'fitsc' ),
					// 'sixth' => __( 'Sixth', 'fitsc' ),
					// 'seventh' => __( 'Seventh', 'fitsc' ),
					// 'eighth' => __( 'Eighth', 'fitsc' )
				) );
				?>
			</select>
		</div>
	</div>
	<div class="fitsc-field" ng-show="icon_effect!=''">
		<label class="fitsc-label"><?php _e( 'Effect Icon Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="icon_eff_color" type="text" colorpicker>
		</div>
	</div>
</div>

<div class="fitsc-preview">
	<div class="fitsc-preview-shortcode">
		<h4 class="fitsc-heading"><?php _e( 'Shortcode Preview', 'fitsc' ); ?></h4>
		<pre class="fitsc-preview-content fitsc-shortcode"><?php
			$text = "[$shortcode";
			$text .= FITSC_Helper::shortcode_atts(
				'style',
				'box_border',
				'box_border_color',
				'box_bg_color',
				'title',
				'title_size',
				'title_color',
				'title_bg_color',
				'title_padding',
				'link',
				'icon_type',
				'icon_width',
				'icon_height',

				'icon_margin',
				'icon_padding',

				'desc_padding',
				'icon_color',
				'icon_bg_color',
				'icon_border',
				'icon_border_color',
				'icon_radius',
				'icon_position',
				'icon_effect'
			);
			$text .= "{{!icon_type && icon_size && ( ' icon_size=\"' + icon_size + '\"' ) || ''}}";
			// $text .= "{{icon_type && ( ' icon_width=\"' + icon_width + '\"' ) || ''}}";
			// $text .= "{{icon_type && ( ' icon_height=\"' + icon_height + '\"' ) || ''}}";

			$text .= "{{icon_effect && icon_eff_color && ( ' icon_eff_color=\"' + icon_eff_color + '\"' ) || ''}}";

			$text .= "{{style && ( ' img_url=\"' + img_url + '\"' ) || ''}}";

			$text .= "{{(icon_type && icon_url && ( ' icon_url=\"' + icon_url + '\"' ) || '') || (!icon_type && icon && icon != 'fa' && ( ' icon=\"' + icon + '\"' ) || '')}}";

			$text .= "]{{text}}[/$shortcode]";
			echo $text;
			?></pre>
	</div>
</div>
