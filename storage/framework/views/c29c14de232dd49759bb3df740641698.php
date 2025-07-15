<?php
	$countPostsPerCat ??= [];
	
	// Clear Filter Button
	$clearFilterBtn = urlGen()->getCategoryFilterClearLink($cat ?? null, $city ?? null);
	
	// Links CSS Class
	$linkClass = linkClass();
?>
<?php if(!empty($cat)): ?>
	<?php
		$catParentUrl = urlGen()->parentCategory(data_get($cat, 'parent') ?? null, $city ?? null);
	?>
	
	
	<div id="subCatsList">
		<?php if(!empty(data_get($cat, 'children'))): ?>
			
			<div class="container p-0 vstack gap-2">
				<h5 class="border-bottom pb-2 d-flex justify-content-between mb-0">
					<span class="fw-bold">
						<?php if(!empty(data_get($cat, 'parent'))): ?>
							<a href="<?php echo e(urlGen()->category(data_get($cat, 'parent'), null, $city ?? null)); ?>"
							   class="<?php echo e($linkClass); ?>"
							>
								<i class="fa-solid fa-reply"></i> <?php echo e(data_get($cat, 'parent.name')); ?>

							</a>
						<?php else: ?>
							<a href="<?php echo e($catParentUrl); ?>" class="<?php echo e($linkClass); ?>">
								<i class="fa-solid fa-reply"></i> <?php echo e(t('all_categories')); ?>

							</a>
						<?php endif; ?>
					</span> <?php echo $clearFilterBtn; ?>

				</h5>
				<ul class="mb-0 list-unstyled">
					<li class="py-1">
						<div class="border-bottom pb-2 mb-3">
							<span class="fs-5">
								<?php if(in_array(config('settings.listings_list.show_category_icon'), [4, 5, 6, 8])): ?>
									<i class="<?php echo e(data_get($cat, 'icon_class') ?? 'bi bi-folder-fill'); ?>"></i>
								<?php endif; ?>
								<?php echo e(data_get($cat, 'name')); ?>

							</span>
							<?php if(config('settings.listings_list.count_categories_listings')): ?>
								&nbsp;<span class="fw-normal">(<?php echo e($countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0); ?>)</span>
							<?php endif; ?>
						</div>
						<ul class="mb-0 ps-2 list-unstyled long-list">
							<?php $__currentLoopData = data_get($cat, 'children'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li class="py-1">
									<a href="<?php echo e(urlGen()->category($iSubCat, null, $city ?? null)); ?>"
									   class="<?php echo e($linkClass); ?>"
									   title="<?php echo e(data_get($iSubCat, 'name')); ?>"
									>
										<?php if(in_array(config('settings.listings_list.show_category_icon'), [4, 5, 6, 8])): ?>
											<i class="<?php echo e(data_get($iSubCat, 'icon_class') ?? 'bi bi-folder-fill'); ?>"></i>
										<?php endif; ?>
										<?php echo e(str(data_get($iSubCat, 'name'))->limit(100)); ?>

										<?php if(config('settings.listings_list.count_categories_listings')): ?>
											&nbsp;<span class="fw-normal">(<?php echo e($countPostsPerCat[data_get($iSubCat, 'id')]['total'] ?? 0); ?>)</span>
										<?php endif; ?>
									</a>
								</li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
					</li>
				</ul>
			</div>
			
		<?php else: ?>
			
			<?php if(!empty(data_get($cat, 'parent.children'))): ?>
				<div class="container p-0 vstack gap-2">
					<h5 class="border-bottom pb-2 d-flex justify-content-between">
						<span class="fw-bold">
							<?php if(!empty(data_get($cat, 'parent.parent'))): ?>
								<a href="<?php echo e(urlGen()->category(data_get($cat, 'parent.parent'), null, $city ?? null)); ?>"
								   class="<?php echo e($linkClass); ?>"
								>
									<i class="fa-solid fa-reply"></i> <?php echo e(data_get($cat, 'parent.parent.name')); ?>

								</a>
							<?php elseif(!empty(data_get($cat, 'parent'))): ?>
								<a href="<?php echo e(urlGen()->category(data_get($cat, 'parent'), null, $city ?? null)); ?>"
								   class="<?php echo e($linkClass); ?>"
								>
									<i class="fa-solid fa-reply"></i> <?php echo e(data_get($cat, 'name')); ?>

								</a>
							<?php else: ?>
								<a href="<?php echo e($catParentUrl); ?>" class="<?php echo e($linkClass); ?>">
									<i class="fa-solid fa-reply"></i> <?php echo e(t('all_categories')); ?>

								</a>
							<?php endif; ?>
						</span> <?php echo $clearFilterBtn; ?>

					</h5>
					<ul class="mb-0 list-unstyled">
						<?php $__currentLoopData = data_get($cat, 'parent.children'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li class="py-1">
								<?php if(data_get($iSubCat, 'id') == data_get($cat, 'id')): ?>
									<span class="fw-bold">
										<?php if(in_array(config('settings.listings_list.show_category_icon'), [4, 5, 6, 8])): ?>
											<i class="<?php echo e(data_get($iSubCat, 'icon_class') ?? 'bi bi-folder-fill'); ?>"></i>
										<?php endif; ?>
										<?php echo e(str(data_get($iSubCat, 'name'))->limit(100)); ?>

										<?php if(config('settings.listings_list.count_categories_listings')): ?>
											&nbsp;<span class="fw-normal">(<?php echo e($countPostsPerCat[data_get($iSubCat, 'id')]['total'] ?? 0); ?>)</span>
										<?php endif; ?>
									</span>
								<?php else: ?>
									<a href="<?php echo e(urlGen()->category($iSubCat, null, $city ?? null)); ?>"
									   class="<?php echo e($linkClass); ?>"
									   title="<?php echo e(data_get($iSubCat, 'name')); ?>"
									>
										<?php if(in_array(config('settings.listings_list.show_category_icon'), [4, 5, 6, 8])): ?>
											<i class="<?php echo e(data_get($iSubCat, 'icon_class') ?? 'bi bi-folder-fill'); ?>"></i>
										<?php endif; ?>
										<?php echo e(str(data_get($iSubCat, 'name'))->limit(100)); ?>

										<?php if(config('settings.listings_list.count_categories_listings')): ?>
											&nbsp;<span class="fw-normal">(<?php echo e($countPostsPerCat[data_get($iSubCat, 'id')]['total'] ?? 0); ?>)</span>
										<?php endif; ?>
									</a>
								<?php endif; ?>
							</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				</div>
			<?php else: ?>
				
				<?php echo $__env->make('front.search.partials.sidebar.categories.root', ['countPostsPerCat' => $countPostsPerCat], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			<?php endif; ?>
			
		<?php endif; ?>
	</div>
	
<?php else: ?>
	
	<?php echo $__env->make('front.search.partials.sidebar.categories.root', ['countPostsPerCat' => $countPostsPerCat], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/sidebar/categories.blade.php ENDPATH**/ ?>