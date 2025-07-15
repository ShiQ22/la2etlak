
<?php if(!empty($cats)): ?>
	<?php
		$countPostsPerCat ??= [];
		$linkClass = linkClass();
	?>
	<div id="catsList">
		<div class="container p-0 vstack gap-2">
			<h5 class="border-bottom pb-2 d-flex justify-content-between">
				<span class="fw-bold"><?php echo e(t('all_categories')); ?></span> <?php echo $clearFilterBtn ?? ''; ?>

			</h5>
			<ul class="mb-0 list-unstyled">
				<?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li class="py-1">
						<?php if(isset($cat) && data_get($iCat, 'id') == data_get($cat, 'id')): ?>
							<span class="fw-bold">
								<?php if(in_array(config('settings.listings_list.show_category_icon'), [4, 5, 6, 8])): ?>
									<i class="<?php echo e(data_get($iCat, 'icon_class') ?? 'bi bi-folder-fill'); ?>"></i>
								<?php endif; ?>
								<?php echo e(data_get($iCat, 'name')); ?>

								<?php if(config('settings.listings_list.count_categories_listings')): ?>
									&nbsp;<span class="fw-normal">(<?php echo e($countPostsPerCat[data_get($iCat, 'id')]['total'] ?? 0); ?>)</span>
								<?php endif; ?>
							</span>
						<?php else: ?>
							<a href="<?php echo e(urlGen()->category($iCat, null, $city ?? null)); ?>"
							   class="<?php echo e($linkClass); ?>"
							   title="<?php echo e(data_get($iCat, 'name')); ?>"
							>
								<span>
									<?php if(in_array(config('settings.listings_list.show_category_icon'), [4, 5, 6, 8])): ?>
										<i class="<?php echo e(data_get($iCat, 'icon_class') ?? 'bi bi-folder-fill'); ?>"></i>
									<?php endif; ?>
									<?php echo e(data_get($iCat, 'name')); ?>

								</span>
								<?php if(config('settings.listings_list.count_categories_listings')): ?>
									&nbsp;<span class="fw-normal">(<?php echo e($countPostsPerCat[data_get($iCat, 'id')]['total'] ?? 0); ?>)</span>
								<?php endif; ?>
							</a>
						<?php endif; ?>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
	</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/sidebar/categories/root.blade.php ENDPATH**/ ?>