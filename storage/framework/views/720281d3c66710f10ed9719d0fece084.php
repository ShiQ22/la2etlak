<?php
	$sectionOptions = $statsOptions ?? [];
	$sectionData ??= [];
	$stats = (array)data_get($sectionData, 'count');
	
	$iconPosts = $sectionOptions['icon_count_listings'] ?? 'bi bi-megaphone';
	$iconUsers = $sectionOptions['icon_count_users'] ?? 'bi bi-people';
	$iconLocations = $sectionOptions['icon_count_locations'] ?? 'bi bi-geo-alt';
	$prefixPosts = $sectionOptions['prefix_count_listings'] ?? '';
	$suffixPosts = $sectionOptions['suffix_count_listings'] ?? '';
	$prefixUsers = $sectionOptions['prefix_count_users'] ?? '';
	$suffixUsers = $sectionOptions['suffix_count_users'] ?? '';
	$prefixLocations = $sectionOptions['prefix_count_locations'] ?? '';
	$suffixLocations = $sectionOptions['suffix_count_locations'] ?? '';
	$disableCounterUp = $sectionOptions['disable_counter_up'] ?? false;
	$counterUpDelay = $sectionOptions['counter_up_delay'] ?? 10;
	$counterUpTime = $sectionOptions['counter_up_time'] ?? 2000;
	$hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' d-none d-md-block' : '';
	
	$statItems = [
		'listings' => [
			'icon'   => $iconPosts,
			'count'  => (int)data_get($stats, 'posts'),
			'prefix' => $prefixPosts,
			'suffix' => $suffixPosts,
			'label'  => t('classified_ads'),
		],
		'users' => [
			'icon'   => $iconUsers,
			'count'  => (int)data_get($stats, 'users'),
			'prefix' => $prefixUsers,
			'suffix' => $suffixUsers,
			'label'  => t('Trusted Sellers'),
		],
		'locations' => [
			'icon'   => $iconLocations,
			'count'  => (int)data_get($stats, 'locations'),
			'prefix' => $prefixLocations,
			'suffix' => $suffixLocations,
			'label'  => t('locations'),
		],
	];
?>

<?php echo $__env->make('front.sections.spacer', ['hideOnMobile' => $hideOnMobile], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="container<?php echo e($hideOnMobile); ?>">
	<div class="card border-0 bg-body-tertiary">
		<div class="card-body text-secondary">
			
			<div class="row">
				<?php $__currentLoopData = $statItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$icon = $item['icon'];
						$count = $item['count'];
						$prefix = $item['prefix'];
						$suffix = $item['suffix'];
						$label = $item['label'];
					?>
					<div class="col-sm-4 col-12">
						<div class="d-flex align-items-center justify-content-md-center justify-content-sm-start">
							<div class="text-end">
								<i class="<?php echo e($icon); ?> fs-1"></i>
							</div>
							<div class="ms-3 text-start">
								<h5 class="fs-1 fw-bold m-0">
									<?php if(!empty($prefix)): ?><span><?php echo e($prefix); ?></span><?php endif; ?>
									<span class="counter"><?php echo e($count); ?></span>
									<?php if(!empty($suffix)): ?><span><?php echo e($suffix); ?></span><?php endif; ?>
								</h5>
								<div class="fs-5"><?php echo e($label); ?></div>
							</div>
						</div>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
			
		</div>
	</div>
</div>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<?php if(!isset($disableCounterUp) || !$disableCounterUp): ?>
		<script>
			onDocumentReady((event) => {
				const counterUp = window.counterUp.default;
				const counterEl = document.querySelector('.counter');
				if (counterEl) {
					counterUp(counterEl, {
						duration: <?php echo e($counterUpTime); ?>,
						delay: <?php echo e($counterUpDelay); ?>

					});
				}
			});
		</script>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/sections/home/stats.blade.php ENDPATH**/ ?>