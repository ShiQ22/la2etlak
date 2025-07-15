<?php
	$sectionOptions = $locationsOptions ?? [];
	$sectionData ??= [];
	$cities = (array)data_get($sectionData, 'cities');
	
	// Get Admin Map's values
	$locCanBeShown = (data_get($sectionOptions, 'show_cities') == '1');
	$locColumns = (int)(data_get($sectionOptions, 'items_cols') ?? 3);
	$locCountListingsPerCity = (config('settings.listings_list.count_cities_listings'));
	$mapCanBeShown = (
		file_exists(config('larapen.core.maps.path') . config('country.icode') . '.svg')
		&& data_get($sectionOptions, 'enable_map') == '1'
	);
	
	$showListingBtn = (data_get($sectionOptions, 'show_listing_btn') == '1');
	
	$hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' d-none d-md-block' : '';
?>
<?php if($locCanBeShown || $mapCanBeShown): ?>
	<?php echo $__env->make('front.sections.spacer', ['hideOnMobile' => $hideOnMobile], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<div class="container<?php echo e($hideOnMobile); ?> location-card">
		<div class="card bg-body-tertiary">
			<div class="card-body rounded p-4 p-lg-3 pb-lg-4 p-md-2">
				
				<div class="row">
					<?php if(!$mapCanBeShown): ?>
						<div class="row">
							<div class="col-xl-12 col-sm-12">
								<h4 class="pb-3 px-0 fw-bold text-nowrap">
									<i class="bi bi-geo-alt"></i>&nbsp;<?php echo e(t('Choose a city')); ?>

								</h4>
							</div>
						</div>
					<?php endif; ?>
					
					<?php
						$leftClassCol = '';
						$rightClassCol = '';
						$rowCol = 'row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1'; // Cities Columns
						
						if ($locCanBeShown && $mapCanBeShown) {
							// Display the Cities & the Map
							$leftClassCol = 'col-lg-8 col-md-12';
							$rightClassCol = 'col-lg-3 col-md-12 mt-3 mt-xl-0 mt-lg-0';
							$rowCol = 'row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-1';
							
							if ($locColumns == 2) {
								$leftClassCol = 'col-md-6 col-sm-12';
								$rightClassCol = 'col-md-5 col-sm-12';
								$rowCol = 'row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-1';
							}
							if ($locColumns == 1) {
								$leftClassCol = 'col-md-3 col-sm-12';
								$rightClassCol = 'col-md-8 col-sm-12';
								$rowCol = 'row-cols-lg-1 row-cols-md-1 row-cols-sm-1 row-cols-1';
							}
						} else {
							if ($locCanBeShown && !$mapCanBeShown) {
								// Display the Cities & Hide the Map
								$leftClassCol = 'col-xl-12';
							}
							if (!$locCanBeShown && $mapCanBeShown) {
								// Display the Map & Hide the Cities
								$rightClassCol = 'col-xl-12';
							}
						}
					?>
					<?php if($locCanBeShown): ?>
						<div class="<?php echo e($leftClassCol); ?> m-0 p-0">
							<?php if(!empty($cities)): ?>
								<?php if($mapCanBeShown): ?>
									<h4 class="pt-1 pb-3 px-3 fw-bold text-nowrap">
										<i class="bi bi-geo-alt"></i>&nbsp;<?php echo e(t('Choose a city or region')); ?>

									</h4>
								<?php endif; ?>
								<div class="row px-4">
									<div class="col-xl-12">
										<div id="cityList" class="row <?php echo e($rowCol); ?>">
											<?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<div class="col mb-2">
													<?php if(data_get($city, 'id') == 0): ?>
														<a href="#browseLocations"
														   class="<?php echo e(linkClass('body-emphasis')); ?>"
														   data-bs-toggle="modal"
														   data-admin-code="0"
														   data-city-id="0"
														>
															<?php echo data_get($city, 'name'); ?>

														</a>
													<?php else: ?>
														<a href="<?php echo e(urlGen()->city($city)); ?>" class="<?php echo e(linkClass('body-emphasis')); ?>">
															<?php echo e(data_get($city, 'name')); ?>

														</a>
														<?php if($locCountListingsPerCity): ?>
															&nbsp;(<?php echo e(data_get($city, 'posts_count') ?? 0); ?>)
														<?php endif; ?>
													<?php endif; ?>
												</div>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</div>
									</div>
									
									<?php if($showListingBtn): ?>
										<?php
											[$createListingLinkUrl, $createListingLinkAttr] = getCreateListingLinkInfo();
										?>
										<div class="col-xl-12 text-center pt-5">
											<a class="btn btn-lg btn-listing ps-4 pe-4"
											   href="<?php echo e($createListingLinkUrl); ?>"<?php echo $createListingLinkAttr; ?>

											   style="text-transform: none;"
											>
												<i class="fa-regular fa-pen-to-square"></i> <?php echo e(t('create_listing')); ?>

											</a>
										</div>
									<?php endif; ?>
			
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					
					<?php echo $__env->make('front.sections.home.locations.svgmap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				</div>
				
			</div>
		</div>
	</div>
<?php endif; ?>

<?php $__env->startSection('modal_location'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('modal_location'); ?>
	<?php if($locCanBeShown || $mapCanBeShown): ?>
		<?php echo $__env->make('front.layouts.partials.modal.location', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		const citiesColumns = <?php echo e($locColumns); ?>;
		onDocumentReady((event) => {
			
			const cityListReorder = new BsRowColumnsReorder('#cityList', {defaultColumns: citiesColumns});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/sections/home/locations.blade.php ENDPATH**/ ?>