<?php
	$categories ??= [];
	$isCountPostsEnabled = (config('settings.listings_list.count_categories_listings') == '1');
	$isShowingCategoryIconEnabled = in_array(config('settings.listings_list.show_category_icon'), [2, 6, 7, 8]);
?>
<?php if(!empty($categories)): ?>
	<div class="row row-cols-lg-6 row-cols-md-4 row-cols-sm-3 row-cols-2 py-1 px-0 big-icon-category-list">
		<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php
				$catId = data_get($cat, 'id', 0);
				$catIconClass = $isShowingCategoryIconEnabled ? data_get($cat, 'icon_class', 'bi bi-folder-fill') : '';
				$catIcon = !empty($catIconClass) ? '<i class="' . $catIconClass . '" style="font-size: 3rem;"></i>' : '';
				$catName = data_get($cat, 'name', '--');
				
				$catCountPosts = $isCountPostsEnabled
					? '(' . ($countPostsPerCat[$catId]['total'] ?? 0) . ')'
					: '';
				$catDisplayName = !empty($catCountPosts) ? $catName . ' ' . $catCountPosts : $catName;
			?>
			<div class="col px-0 d-flex justify-content-center align-content-stretch">
				<div class="text-center w-100 border rounded px-3 py-4 m-1">
					<a href="<?php echo e(urlGen()->category($cat)); ?>" class="<?php echo e(linkClass()); ?>">
						<?php echo $catIcon; ?>

						<h6 class="mt-2 fw-bold"><?php echo e($catDisplayName); ?></h6>
					</a>
				</div>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/sections/home/categories/c-big-icon-list.blade.php ENDPATH**/ ?>