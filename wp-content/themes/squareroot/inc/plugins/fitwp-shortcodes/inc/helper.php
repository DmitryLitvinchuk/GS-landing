<?php
class FITSC_Helper
{
	/**
	 * Show select options
	 *
	 * @param array $options List of options, in format $k => $v
	 *
	 * @return void
	 */
	static function options( $options )
	{
		foreach ( $options as $k => $v )
		{
			printf( '<option value="%s">%s</option>', $k, $v );
		}
	}

	/**
	 * Show angularjs checkbox
	 *
	 * @param string $name Angular model name
	 * @param bool   $checked
	 *
	 * @return void
	 */
	static function checkbox_angular( $name, $checked = false )
	{
		printf(
			'<input type="checkbox" ng-model="%1$s" ng-true-value="1" ng-false-value="" ng-init="%1$s = \'%2$s\'">',
			$name,
			$checked ? 1 : ''
		);
	}

	/**
	 * Display shortcode attributes
	 *
	 * @return string
	 */
	static function shortcode_atts()
	{
		$atts = func_get_args();
		$text = '';
		foreach ( $atts as $att )
		{
			$text .= sprintf( '{{%1$s && (\' %1$s="\' + %1$s + \'"\') || \'\'}}', $att );
		}
		return $text;
	}

	/**
	 * Display color schemes
	 *
	 * @param string $model_name
	 *
	 * @return string
	 */
	static function color_schemes( $model_name )
	{
		echo '<div class="fitsc-color-shemes">';

		$colors = array(
			'rosy',
			'pink',
			'pink-dark',
			'red',
			'magenta',
			'orange',
			'orange-dark',
			'yellow',
			'green-light',
			'green-lime',
			'green',
			'blue',
			'blue-dark',
			'indigo',
			'violet',
			'cappuccino',
			'brown',
			'brown-dark',
			'gray',
			'gray-dark',
			'black',
			'white',
		);
		foreach ( $colors as $color )
		{
			printf(
				'<label class="fitsc-color-scheme fitsc-background-%1$s">
					<input ng-model="%2$s" type="radio" name="%2$s" value="%1$s">
				</label>',
				$color,
				$model_name
			);
		}
		echo '</div>';
	}

	/**
	 * Display icons
	 *
	 * @param string $model_name
	 *
	 * @return string
	 */
	static function icons( $model_name )
	{
		$name = uniqid();
		printf( '
			<input ng-model="search" type="text" placeholder="%s">
			<div class="fitsc-icons">
				<label class="fitsc-icon" ng-repeat="i in icons | filter: search">
					<i class="{{i.class}}"></i>
					<input ng-model="$parent.%s" type="radio" name="%s" value="{{i.class}}" class="hidden">
				</label>
			</div>',
			__( 'Search Icon', 'fitsc' ),
			$model_name,
			$name
		);
	}
}
