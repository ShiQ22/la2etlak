<?php
	$widget ??= [];
	$posts = (array)data_get($widget, 'posts');
	$totalPosts = (int)data_get($widget, 'totalPosts', 0);
	
	$sectionOptions ??= [];
	$hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' d-none d-md-block' : '';
	
	$isFromHome ??= false;
	
	$gridClass = config('settings.listings_list.display_mode', 'grid-view');
?>
<?php if($totalPosts > 0): ?>
	<?php echo $__env->make('front.sections.spacer', ['hideOnMobile' => $hideOnMobile], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<div class="container<?php echo e($hideOnMobile); ?>">
		<div class="card">
			<div class="card-header border-bottom-0">
				<h4 class="mb-0 float-start fw-lighter">
					<?php echo data_get($widget, 'title'); ?>

					
				</h4>
				<h5 class="mb-0 float-end mt-1 fs-6 fw-lighter text-uppercase">
					<a href="<?php echo e(data_get($widget, 'link')); ?>" class="<?php echo e(linkClass()); ?>">
						<?php echo e(t('View more')); ?> <i class="fa-solid fa-bars"></i>
					</a>
				</h5>
			</div>
			
			<div class="card-body rounded py-0">
				<?php if(config('settings.listings_list.display_mode') == 'make-list'): ?>
					<?php echo $__env->make('front.search.partials.posts.template.list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				<?php elseif(config('settings.listings_list.display_mode') == 'make-compact'): ?>
					<?php echo $__env->make('front.search.partials.posts.template.compact', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				<?php else: ?>
					<?php echo $__env->make('front.search.partials.posts.template.grid', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				<?php endif; ?>
				<?php if(data_get($sectionOptions, 'show_view_more_btn') == '1'): ?>
					<div class="row border-top pt-3 mt-0 mb-3">
						<div class="col-12 text-center">
							<a href="<?php echo e(urlGen()->searchWithoutQuery()); ?>" class="btn btn-primary">
								<i class="bi bi-box-arrow-in-right"></i> <?php echo e(t('View more')); ?>

							</a>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php $__env->startSection('after_scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/posts/widget/normal.blade.php ENDPATH**/ ?>