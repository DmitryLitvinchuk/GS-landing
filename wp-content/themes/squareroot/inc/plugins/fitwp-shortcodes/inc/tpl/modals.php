<div id="fitsc-modals" ng-app="fitsc">
	<div class="fitsc-modal" id="fitsc-modal" ng-controller="Base">
		<div class="fitsc-modal-header">
			<a href="#" class="fitsc-modal-close" id="fitsc-close">&times;</a>

			<h2><?php _e( 'Insert Shortcode', 'fitsc' ); ?></h2>
		</div>
		<div class="fitsc-modal-body" id="fitsc-modal-body"></div>
		<div class="fitsc-modal-footer">
			<button class="button button-primary button-large" id="fitsc-insert"><i class="fa fa-cloud-download"></i><?php _e( 'Insert', 'fitsc' ); ?></button>
		</div>
		<img class="fitsc-loading" id="fitsc-loading" src="<?php echo FITSC_URL; ?>img/loading.gif">
	</div>
</div>