<div class="fitsc-config">
	<div class="fitsc-field" ng-init="type = ''">
		<label class="fitsc-label"><?php _e( 'Type', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<!-- <label>
				<input ng-model="type" type="radio" name="type" value="">
				<?php _e( 'One Button', 'fitsc' ); ?>
			</label> -->
			<!-- <label>
				<input ng-model="type" type="radio" name="type" value="two-buttons">
				<?php _e( 'Two Buttons', 'fitsc' ); ?>
			</label> -->
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Heading', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="heading" type="text">
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Text', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<textarea ng-model="text"></textarea>
		</div>
	</div>
	<h3><?php _e( 'Edit Button', 'fitsc' ); ?></h3>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Text', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="button1_text" type="text">
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Link', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<input ng-model="button1_link" type="text">
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Color', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<?php FITSC_Helper::color_schemes( 'button1_color' );  ?>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Link Target', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<select ng-model="button1_target">
				<?php
				FITSC_Helper::options( array(
					''       => __( 'Default', 'fitsc' ),
					'_blank' => __( 'New window/tab', 'fitsc' ),
				) );
				?>
			</select>
		</div>
	</div>
	<div class="fitsc-field">
		<label class="fitsc-label"><?php _e( 'Nofollow', 'fitsc' ); ?></label>
		<div class="fitsc-controls">
			<?php FITSC_Helper::checkbox_angular( 'button1_nofollow' ); ?>
		</div>
	</div>
	<div ng-show="type == 'two-buttons'">
		<h3><?php _e( 'Edit Secondary Button', 'fitsc' ); ?></h3>
		<div class="fitsc-field">
			<label class="fitsc-label"><?php _e( 'Text', 'fitsc' ); ?></label>
			<div class="fitsc-controls">
				<input ng-model="button2_text" type="text">
			</div>
		</div>
		<div class="fitsc-field">
			<label class="fitsc-label"><?php _e( 'Link', 'fitsc' ); ?></label>
			<div class="fitsc-controls">
				<input ng-model="button2_link" type="text">
			</div>
		</div>
		<div class="fitsc-field">
			<label class="fitsc-label"><?php _e( 'Color', 'fitsc' ); ?></label>
			<div class="fitsc-controls">
				<?php FITSC_Helper::color_schemes( 'button2_color' );  ?>
			</div>
		</div>
		<div class="fitsc-field">
			<label class="fitsc-label"><?php _e( 'Link Target', 'fitsc' ); ?></label>
			<div class="fitsc-controls">
				<select ng-model="button2_target">
					<?php
					FITSC_Helper::options( array(
						''       => __( 'Default', 'fitsc' ),
						'_blank' => __( 'New window/tab', 'fitsc' ),
					) );
					?>
				</select>
			</div>
		</div>
		<div class="fitsc-field">
			<label class="fitsc-label"><?php _e( 'Nofollow', 'fitsc' ); ?></label>
			<div class="fitsc-controls">
				<?php FITSC_Helper::checkbox_angular( 'button2_nofollow' ); ?>
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
				'heading',
				'text',
				'button1_text',
				'button1_link',
				'button1_color',
				'button1_target',
				'button1_nofollow',
				'button2_text',
				'button2_link',
				'button2_color',
				'button2_target',
				'button2_nofollow'
			);
			$text .= ']';
			echo $text;
		?></pre>
	</div>
</div>
