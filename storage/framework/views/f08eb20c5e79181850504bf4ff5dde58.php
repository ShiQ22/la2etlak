<?php
	$bcTab ??= [];
	$admin ??= null;
	$city ??= null;
	
	$adminType = config('country.admin_type', 0);
	$relAdminType = (in_array($adminType, ['1', '2'])) ? $adminType : 1;
	$adminCode = data_get($city, 'subadmin' . $relAdminType . '_code') ?? data_get($admin, 'code') ?? 0;
	
	// Search base URL
	$searchWithoutQuery = urlGen()->searchWithoutQuery();
	$filterBy = request()->query('filterBy');
	if (!empty($filterBy)) {
		$searchWithoutQuery .=  (str_contains($searchWithoutQuery, '?')) ? '&' : '?';
		$searchWithoutQuery .= 'filterBy=' . $filterBy;
	}
	
	$linkClass = linkClass();
?>
<div class="container">
	<nav aria-label="breadcrumb" role="navigation" class="search-breadcrumb">
		<ol class="breadcrumb mb-0 py-3">
			<li class="breadcrumb-item">
				<a href="<?php echo e(url('/')); ?>" class="<?php echo e($linkClass); ?>">
					<i class="fa-solid fa-house"></i>
				</a>
			</li>
			<li class="breadcrumb-item">
				<a href="<?php echo e($searchWithoutQuery); ?>" class="<?php echo e($linkClass); ?>">
					<?php echo e(config('country.name')); ?>

				</a>
			</li>
			<?php if(is_array($bcTab) && count($bcTab) > 0): ?>
				<?php $__currentLoopData = $bcTab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if($value->has('position') && $value->get('position') > count($bcTab)+1): ?>
						<li class="breadcrumb-item active">
							<?php echo $value->get('name'); ?>

							<?php if(!empty($adminCode)): ?>
								&nbsp;<a href="#browseLocations"
								   class="<?php echo e($linkClass); ?>"
								   data-bs-toggle="modal"
								   data-admin-code="<?php echo e($adminCode); ?>"
								   data-city-id="<?php echo e(data_get($city, 'id', 0)); ?>"
								>
									<i class="bi bi-chevron-down"></i>
								</a>
							<?php endif; ?>
						</li>
					<?php else: ?>
						<li class="breadcrumb-item">
							<a href="<?php echo e($value->get('url')); ?>" class="<?php echo e($linkClass); ?>">
								<?php echo $value->get('name'); ?>

							</a>
						</li>
					<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
		</ol>
	</nav>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/breadcrumbs.blade.php ENDPATH**/ ?>