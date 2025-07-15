<?php
	$hideOnlyOnXs = 'd-none d-sm-block';
	$linkClass = linkClass();
?>
<?php if(!empty($cat) || !empty($cats)): ?>
<div class="container mb-3 <?php echo e($hideOnlyOnXs); ?>">
	<?php if(!empty($cat)): ?>
		<?php if(!empty(data_get($cat, 'children'))): ?>
			<div class="row row-cols-lg-4 row-cols-md-3 row-cols-2 p-2 g-2" id="categoryBadge">
				<?php $__currentLoopData = data_get($cat, 'children'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="col">
						<a href="<?php echo e(urlGen()->category($iSubCat, null, $city ?? null)); ?>" class="<?php echo e($linkClass); ?>">
							<?php if(in_array(config('settings.listings_list.show_category_icon'), [3, 5, 7, 8])): ?>
								<i class="<?php echo e(data_get($iSubCat, 'icon_class') ?? 'bi bi-folder-fill'); ?>"></i>
							<?php endif; ?>
							<?php echo e(data_get($iSubCat, 'name')); ?>

						</a>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		<?php else: ?>
			<?php if(!empty(data_get($cat, 'parent.children'))): ?>
				<div class="row row-cols-lg-4 row-cols-md-3 row-cols-2 p-2 g-2" id="categoryBadge">
					<?php $__currentLoopData = data_get($cat, 'parent.children'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="col">
							<?php if(data_get($iSubCat, 'id') == data_get($cat, 'id')): ?>
								<span class="fw-bold">
									<?php if(in_array(config('settings.listings_list.show_category_icon'), [3, 5, 7, 8])): ?>
										<i class="<?php echo e(data_get($iSubCat, 'icon_class') ?? 'bi bi-folder-fill'); ?>"></i>
									<?php endif; ?>
									<?php echo e(data_get($iSubCat, 'name')); ?>

								</span>
							<?php else: ?>
								<a href="<?php echo e(urlGen()->category($iSubCat, null, $city ?? null)); ?>" class="<?php echo e($linkClass); ?>">
									<?php if(in_array(config('settings.listings_list.show_category_icon'), [3, 5, 7, 8])): ?>
										<i class="<?php echo e(data_get($iSubCat, 'icon_class') ?? 'bi bi-folder-fill'); ?>"></i>
									<?php endif; ?>
									<?php echo e(data_get($iSubCat, 'name')); ?>

								</a>
							<?php endif; ?>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			<?php else: ?>
				
				<?php echo $__env->make('front.search.partials.categories-root', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				
			<?php endif; ?>
		<?php endif; ?>
	<?php else: ?>
		
		<?php echo $__env->make('front.search.partials.categories-root', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
	<?php endif; ?>
</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/categories.blade.php ENDPATH**/ ?>