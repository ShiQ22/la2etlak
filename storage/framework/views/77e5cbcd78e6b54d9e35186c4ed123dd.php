<?php
	// Google Maps
	$useGeocodingApi = (config('settings.other.google_maps_integration_type') == 'geocoding');
	$mapsJavascriptApiKey = config('services.google_maps_platform.maps_javascript_api_key');
	$mapsEmbedApiKey = config('services.google_maps_platform.maps_embed_api_key');
	$geocodingApiKey = config('services.google_maps_platform.geocoding_api_key');
	$useAsyncGeocoding = (config('settings.other.use_async_geocoding') == '1');
	
	$mapsEmbedApiKey ??= $mapsJavascriptApiKey;
	$geocodingApiKey ??= $mapsJavascriptApiKey;
	$geocodingApiKey = $useAsyncGeocoding ? $geocodingApiKey : $mapsJavascriptApiKey;
	
	$mapHeight = 400;
	$city ??= [];
	$geoMapAddress = getItemAddressForMap($city);
	
	$mapsEmbedApiUrl = getGoogleMapsEmbedApiUrl($mapsEmbedApiKey, $geoMapAddress);
	$geocodingApiUrl = getGoogleMapsApiUrl($geocodingApiKey, $useAsyncGeocoding);
?>

<?php if(!empty($geocodingApiKey)): ?>
	<div class="container-fluid px-0" style="height: <?php echo e($mapHeight); ?>px;">
		<?php if($useGeocodingApi): ?>
			<div id="googleMaps" style="width: 100%; height: <?php echo e($mapHeight); ?>px;"></div>
		<?php else: ?>
			<iframe
					id="googleMaps"
					width="100%"
					height="<?php echo e($mapHeight); ?>"
					style="border:0;"
					loading="lazy"
					title="<?php echo e($geoMapAddress); ?>"
					aria-label="<?php echo e($geoMapAddress); ?>"
					src="<?php echo e($mapsEmbedApiUrl); ?>"
			></iframe>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<?php if($useGeocodingApi): ?>
		
		<?php if(!empty($geocodingApiUrl)): ?>
			<script async defer src="<?php echo e($geocodingApiUrl); ?>"></script>
		<?php endif; ?>
		
		
		<script>
			var geocodingApiKey = '<?php echo e($geocodingApiKey); ?>';
			var locationAddress = '<?php echo e($geoMapAddress); ?>';
			var locationMapElId = 'googleMaps';
			var locationMapId = '<?php echo e(generateUniqueCode(16)); ?>';
		</script>
		<?php if($useAsyncGeocoding): ?>
			<script src="<?php echo e(url('assets/js/app/google-maps-async.js')); ?>"></script>
		<?php else: ?>
			<script src="<?php echo e(url('assets/js/app/google-maps.js')); ?>"></script>
		<?php endif; ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/pages/contact/intro.blade.php ENDPATH**/ ?>