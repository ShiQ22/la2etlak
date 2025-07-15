<?php
	$tags ??= [];
?>
<?php if(config('settings.listings_list.show_listings_tags')): ?>
	<?php if(!empty($tags)): ?>
		<div class="container">
			<div class="card mb-3">
				<div class="card-body">
					<h3 class="card-title">
						<i class="fa-solid fa-tags"></i> <?php echo e(t('Tags')); ?>:
					</h3>
					<?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iTag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<span class="d-inline-block border border-inverse bg-body-tertiary rounded-1 py-1 px-2 my-1 me-1">
							<a href="<?php echo e(urlGen()->tag($iTag)); ?>" class="<?php echo e(linkClass()); ?>">
								<?php echo e($iTag); ?>

							</a>
						</span>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/tags.blade.php ENDPATH**/ ?>