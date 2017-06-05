var FITSCApp = angular.module( 'fitsc', [] );

FITSCApp.filter('range', function() {
  return function(val, range) {
  	if (!range){
  		return 0;
  	}
    range = parseInt(range);
    for (var i=0; i<range; i++)
      val.push(i);
    return val;
  };
});

// Color picker directive
FITSCApp.directive( 'colorpicker', function ()
{
	return {
		restrict: 'A',
		require : 'ngModel',
		link    : function ( scope, element, attrs, ngModelCtrl )
		{
			jQuery( function ()
			{
				//alert('color');
				element.wpColorPicker( {
					change: function ( e, ui )
					{
						ngModelCtrl.$setViewValue( ui.color.toString() );
						scope.$apply();
					}
				} );
			} );
		}
	}
} );

FITSCApp.directive( 'imageUpload', function ()
{
	return {
		restrict: 'A',
		require : 'ngModel',
		link    : function ( scope, element, attrs, ngModelCtrl )
		{
			jQuery( function ()
			{
				jQuery(element).click(function() {
					var frame;
					if ( !frame )
					{
						frame = wp.media( {
							className: 'media-frame rwmb-media-frame',
							multiple : false,
							title    : 'Insert Image',
							library  : {
								type: 'image'
							}
						} );
					}
					frame.open();
					frame.off( 'select' );
					frame.on( 'select', function()
					{
				        var media_attachment = frame.state().get('selection').first().toJSON();
				        var input = jQuery(element).prev();
				        input.val(media_attachment.url);
				        input.trigger('input');
					});
				});
			} );
		}
	}
} );

// Base Controller
FITSCApp.controller( 'Base', function ( $scope, $http, $compile )
{
	// Ajax load modal content for shortcode configuration
	window.fitscModal = function ( id )
	{
		// If previous modal is the same, do nothing
		if ( typeof FITSC.current != 'undefined' && FITSC.current == id )
			return;

		var modal = jQuery( '#fitsc-modal-body' ),
			loading = jQuery( '#fitsc-loading' );

		loading.show();
		modal.addClass( 'fitsc-opaque' );

		$http.get( ajaxurl, {
			params: {
				action: 'fitsc_get_modal',
				nonce : FITSC.nonceGetModal,
				shortcode: id
			}
		} ).success( function ( r )
		{
			loading.hide();
			modal.html( $compile( r )( $scope ) ).removeClass( 'fitsc-opaque' );

			// Save current shortcode modal ID
			FITSC.current = id;
		} );
	};

	// Load icons
	$http.get( ajaxurl, {
		params: {
			action: 'fitsc_get_icons',
			nonce : FITSC.nonceGetIcons
		}
	} ).success( function ( r )
	{
		if ( r.success )
			$scope.icons = r.data;
	} );

	// Load social icons
	$http.get( ajaxurl, {
		params: {
			action: 'fitsc_get_socials',
			nonce : FITSC.nonceGetSocials
		}
	} ).success( function ( r )
	{
		if ( r.success )
			$scope.socials = r.data;
	} );
} );

// Controller for tabs, accordions, toggles
FITSCApp.controller( 'Block', function ( $scope )
{
	$scope.counter = 1;
	$scope.blocks = [
		{id: 1, title: '', content: '', icon: ''}
	];
	$scope.add = function ()
	{
		$scope.counter++;
		$scope.blocks.push( {id: $scope.counter, title: '', content: '', icon: ''} );
	}
} );

// Controller for column
// FITSCApp.controller( 'Column', function ( $scope )
// {
// 	$scope.grids = [2, 3, 4, 5, 12];
// 	$scope.spans = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
// 	$scope.pushes = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

// 	$scope.grid = 4;
// 	$scope.span = 1;
// 	$scope.push = 0;

// 	$scope.filterSpan = function ( item )
// 	{
// 		return item <= $scope.grid;
// 	};
// 	$scope.filterPush = function ( item )
// 	{
// 		return item <= $scope.grid - $scope.span;
// 	};
// } );

// Controller for map
FITSCApp.controller( 'Map', function ( $scope, $filter )
{
	$scope.controls = FITSC.mapControls;
	$scope.selected = function ()
	{
		var checked = $filter( 'filter' )( $scope.controls, {checked: true} );
		for ( var i = 0, l = checked.length, s = []; i < l; i++ )
		{
			s.push( checked[i].value );
		}
		return s.join( ',' );
	}

	$scope.type = '';
	$scope.width = 100;
	$scope.width_unit = '%';
	$scope.height = 400;
	$scope.height_unit = 'px';
	$scope.zoom = 8;
} );
