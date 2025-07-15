<?php
	$authUser = auth()->check() ? auth()->user() : null;
	$authUserId = !empty($authUser) ? $authUser->getAuthIdentifier() : 0;
	
	$post ??= [];
	$user ??= [];
	$countPackages ??= 0;
	$countPaymentMethods ??= 0;
	
	$isPostOwner = (!empty($authUserId) && $authUserId == data_get($post, 'user_id'));
	
	// Google Maps
	$isMapEnabled = (config('settings.listing_page.show_listing_on_googlemap') == '1');
	$useGeocodingApi = (config('settings.other.google_maps_integration_type') == 'geocoding');
	$mapsJavascriptApiKey = config('services.google_maps_platform.maps_javascript_api_key');
	$mapsEmbedApiKey = config('services.google_maps_platform.maps_embed_api_key');
	$geocodingApiKey = config('services.google_maps_platform.geocoding_api_key');
	$useAsyncGeocoding = (config('settings.other.use_async_geocoding') == '1');
	
	$mapsEmbedApiKey ??= $mapsJavascriptApiKey;
	$geocodingApiKey ??= $mapsJavascriptApiKey;
	$geocodingApiKey = $useAsyncGeocoding ? $geocodingApiKey : $mapsJavascriptApiKey;
	
	$mapHeight = 250;
	$city = data_get($post, 'city', []);
	$geoMapAddress = getItemAddressForMap($city);
	
	$mapsEmbedApiUrl = getGoogleMapsEmbedApiUrl($mapsEmbedApiKey, $geoMapAddress);
	$geocodingApiUrl = getGoogleMapsApiUrl($geocodingApiKey, $useAsyncGeocoding);
	
	$linkClass = linkClass();
?>
<aside class="vstack gap-4">
	<div class="card">
		<?php if($isPostOwner): ?>
			<div class="card-header fw-bold">
				<?php echo e(t('Manage Listing')); ?>

			</div>
		<?php endif; ?>
		<div class="card-body">
			
			<?php if(!$isPostOwner): ?>
				<div class="container p-0 border-bottom pb-3 mb-3">
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo e(data_get($post, 'user_photo_url')); ?>" class="img-fluid rounded" alt="<?php echo e(data_get($post, 'contact_name')); ?>">
						</div>
						<div class="col-md-8 vstack gap-1">
							<small class="text-secondary"><?php echo e(t('Posted by')); ?></small>
							<span class="fs-6 fw-bold">
							<?php if(!empty($user)): ?>
								<a href="<?php echo e(urlGen()->user($user)); ?>" class="<?php echo e($linkClass); ?>">
									<?php echo e(data_get($post, 'contact_name')); ?>

								</a>
								<?php else: ?>
									<?php echo e(data_get($post, 'contact_name')); ?>

								<?php endif; ?>
							</span>
							
							<?php if(config('plugins.reviews.installed')): ?>
								<?php if(view()->exists('reviews::ratings-user')): ?>
									<?php echo $__env->make('reviews::ratings-user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
			
			
			<?php
				$evActionClass = 'border-top-0';
			?>
			<?php if(!$isPostOwner): ?>
				<div class="container p-0 mb-3 text-secondary small">
					<div class="row my-2">
						<div class="col-6 text-start">
							<i class="bi bi-geo-alt"></i> <?php echo e(t('location')); ?>

						</div>
						<div class="col-6 text-end">
							<a href="<?php echo urlGen()->city(data_get($post, 'city')); ?>" class="<?php echo e($linkClass); ?>">
								<?php echo e(data_get($post, 'city.name')); ?>

							</a>
						</div>
					</div>
					<?php if(!config('settings.listing_page.hide_date')): ?>
						<?php if(!empty($user) && !empty(data_get($user, 'created_at_formatted'))): ?>
							<div class="row my-2">
								<div class="col-6 text-start">
									<i class="bi bi-person-check"></i> <?php echo e(t('Joined')); ?>

								</div>
								<div class="col-6 text-end">
									<span><?php echo data_get($user, 'created_at_formatted'); ?></span>
								</div>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<?php
					$evActionClass = 'border-top pt-3';
				?>
			<?php endif; ?>
			
			
			<div class="container p-0 <?php echo e($evActionClass); ?> d-grid gap-2">
				
				<?php if(!empty($authUser)): ?>
					<?php if($isPostOwner): ?>
						
						<a href="<?php echo e(urlGen()->editPost($post)); ?>" class="btn btn-secondary">
							<i class="fa-regular fa-pen-to-square"></i> <?php echo e(t('Update the details')); ?>

						</a>
						<?php if(isMultipleStepsFormEnabled()): ?>
							<a href="<?php echo e(url('posts/' . data_get($post, 'id') . '/photos')); ?>" class="btn btn-secondary">
								<i class="fa-solid fa-camera"></i> <?php echo e(t('Update Photos')); ?>

							</a>
							<?php if($countPackages > 0 && $countPaymentMethods > 0): ?>
								<a href="<?php echo e(url('posts/' . data_get($post, 'id') . '/payment')); ?>" class="btn btn-success">
									<i class="fa-regular fa-circle-check"></i> <?php echo e(t('Make It Premium')); ?>

								</a>
							<?php endif; ?>
						<?php endif; ?>
						<?php if(empty(data_get($post, 'archived_at')) && isVerifiedPost($post)): ?>
							<a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/posts/list/' . data_get($post, 'id') . '/offline')); ?>"
							   class="btn btn-warning confirm-simple-action"
							>
								<i class="fa-solid fa-eye-slash"></i> <?php echo e(t('put_it_offline')); ?>

							</a>
						<?php endif; ?>
						<?php if(!empty(data_get($post, 'archived_at'))): ?>
							<a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/posts/archived/' . data_get($post, 'id') . '/repost')); ?>"
							   class="btn btn-info confirm-simple-action"
							>
								<i class="fa-solid fa-recycle"></i> <?php echo e(t('re_post_it')); ?>

							</a>
						<?php endif; ?>
					<?php else: ?>
						
						<?php echo genPhoneNumberBtn($post, true); ?>

						<?php echo genEmailContactBtn($post, true); ?>

					<?php endif; ?>
					
					
					<?php
						try {
							if (doesUserHavePermission($authUser, \App\Models\Permission::getStaffPermissions())) {
								$btnUrl = urlGen()->adminUrl('blacklists/add') . '?';
								$btnQs = (!empty(data_get($post, 'email'))) ? 'email=' . data_get($post, 'email') : '';
								$btnQs = (!empty($btnQs)) ? $btnQs . '&' : $btnQs;
								$btnQs = (!empty(data_get($post, 'phone'))) ? $btnQs . 'phone=' . data_get($post, 'phone') : $btnQs;
								$btnUrl = $btnUrl . $btnQs;
								
								if (!isDemoDomain($btnUrl)) {
									$btnText = trans('admin.ban_the_user');
									$btnHint = $btnText;
									if (!empty(data_get($post, 'email')) && !empty(data_get($post, 'phone'))) {
										$btnHint = trans('admin.ban_the_user_email_and_phone', [
											'email' => data_get($post, 'email'),
											'phone' => data_get($post, 'phone'),
										]);
									} else {
										if (!empty(data_get($post, 'email'))) {
											$btnHint = trans('admin.ban_the_user_email', ['email' => data_get($post, 'email')]);
										}
										if (!empty(data_get($post, 'phone'))) {
											$btnHint = trans('admin.ban_the_user_phone', ['phone' => data_get($post, 'phone')]);
										}
									}
									$tooltip = ' data-bs-toggle="tooltip" data-bs-placement="bottom" title="' . $btnHint . '"';
									
									$btnOut = '<a href="'. $btnUrl .'" class="btn btn-outline-danger confirm-simple-action"'. $tooltip .'>';
									$btnOut .= $btnText;
									$btnOut .= '</a>';
									
									echo $btnOut;
								}
							}
						} catch (\Throwable $e) {}
					?>
				<?php else: ?>
					
					<?php echo genPhoneNumberBtn($post, true); ?>

					<?php echo genEmailContactBtn($post, true); ?>

				<?php endif; ?>
			</div>
		</div>
	</div>
	
	
	<?php if($isMapEnabled): ?>
		<div class="card">
			<div class="card-header fw-bold">
				<?php echo e(t('location_map')); ?>

			</div>
			<div class="card-body text-start p-0">
				<div class="posts-googlemaps">
					<?php if($useGeocodingApi): ?>
						<div id="googleMaps" style="width: 100%; height: <?php echo e($mapHeight); ?>px;"></div>
					<?php else: ?>
						<iframe id="googleMaps"
						        width="100%"
						        height="<?php echo e($mapHeight); ?>"
						        src="<?php echo e($mapsEmbedApiUrl); ?>"
						        loading="lazy"
						        style="border:0;"
						        allowfullscreen
						></iframe>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	
	<?php if(isVerifiedPost($post)): ?>
		<?php echo $__env->make('front.layouts.partials.social.horizontal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php endif; ?>
	
	
	<?php
		$tips = [
			t('Meet seller at a public place'),
			t('Check the item before you buy'),
			t('Pay only after collecting the item'),
		];
	?>
	<div class="card">
		<div class="card-header fw-bold">
			<?php echo e(t('Safety Tips for Buyers')); ?>

		</div>
		<div class="card-body text-start">
			<ul class="list-unstyled">
				<?php $__currentLoopData = $tips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li><i class="bi bi-check-lg"></i> <?php echo e($tip); ?></li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
			<?php
				$tipsLinkAttributes = getUrlPageByType('tips');
			?>
			<?php if(!str_contains($tipsLinkAttributes, 'href="#"') && !str_contains($tipsLinkAttributes, 'href=""')): ?>
				<p>
					<a class="float-end <?php echo e($linkClass); ?>" <?php echo $tipsLinkAttributes; ?>>
						<?php echo e(t('Know more')); ?> <i class="fa-solid fa-angles-right"></i>
					</a>
				</p>
			<?php endif; ?>
		</div>
	</div>
</aside>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<?php if($isMapEnabled): ?>
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
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/post/show/partials/sidebar.blade.php ENDPATH**/ ?>