<?php
	// Clear Filter Button
	$clearFilterBtn = urlGen()->getCityFilterClearLink($cat ?? null, $city ?? null);
	
	/*
	 * Check if the City Model exists in the Cities eloquent collection
	 * If it doesn't exist in the collection,
	 * Then, add it into the Cities eloquent collection
	 */
	if (isset($cities, $city) && !collect($cities)->contains($city)) {
		collect($cities)->push($city)->toArray();
	}
	
	// Links CSS Class
	$linkClass = linkClass();
?>

<div class="container p-0 vstack gap-2">
	<h5 class="border-bottom pb-2 d-flex justify-content-between">
		<span class="fw-bold"><?php echo e(t('locations')); ?></span> <?php echo $clearFilterBtn; ?>

	</h5>
	<div>
		<ul class="mb-0 list-unstyled long-list">
			<?php if(!empty($cities)): ?>
				<?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iCity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li class="py-1">
						<?php if(
							(
								isset($city)
								&& data_get($city, 'id') == data_get($iCity, 'id')
							)
							|| request()->input('l') == data_get($iCity, 'id')
							): ?>
							<span class="fw-bold">
								<?php echo e(data_get($iCity, 'name')); ?>

								<?php if(config('settings.listings_list.count_cities_listings')): ?>
									&nbsp;<span class="fw-normal">(<?php echo e(data_get($iCity, 'posts_count') ?? 0); ?>)</span>
								<?php endif; ?>
							</span>
						<?php else: ?>
							<a href="<?php echo urlGen()->city($iCity, null, $cat ?? null); ?>"
							   class="<?php echo e($linkClass); ?>"
							   title="<?php echo e(data_get($iCity, 'name')); ?>"
							>
								<?php echo e(data_get($iCity, 'name')); ?>

								<?php if(config('settings.listings_list.count_cities_listings')): ?>
									&nbsp;<span class="fw-normal">(<?php echo e(data_get($iCity, 'posts_count') ?? 0); ?>)</span>
								<?php endif; ?>
							</a>
						<?php endif; ?>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
		</ul>
	</div>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/sidebar/cities.blade.php ENDPATH**/ ?>