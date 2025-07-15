<?php
	$sectionOptions = $categoriesOptions ?? [];
	$sectionData ??= [];
	$categories = (array)data_get($sectionData, 'categories');
	$subCategories = (array)data_get($sectionData, 'subCategories');
	$countPostsPerCat = (array)data_get($sectionData, 'countPostsPerCat');
	$countPostsPerCat = collect($countPostsPerCat)->keyBy('id')->toArray();
	
	$hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' d-none d-md-block' : '';
	
	$catDisplayType = data_get($sectionOptions, 'cat_display_type');
	$maxSubCats = (int)data_get($sectionOptions, 'max_sub_cats');
?>

<?php echo $__env->make('front.sections.spacer', ['hideOnMobile' => $hideOnMobile], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="container<?php echo e($hideOnMobile); ?>">
	<div class="card">
		
		<div class="card-header border-bottom-0">
			<h4 class="mb-0 float-start fw-lighter">
				<?php echo e(t('Browse by')); ?> <span class="fw-bold"><?php echo e(t('category')); ?></span>
			</h4>
			<h5 class="mb-0 float-end mt-1 fs-6 fw-lighter text-uppercase">
				<a href="<?php echo e(urlGen()->sitemap()); ?>" class="<?php echo e(linkClass()); ?>">
					<?php echo e(t('View more')); ?> <i class="fa-solid fa-bars"></i>
				</a>
			</h5>
		</div>
		<div class="card-body rounded py-0">
			<?php if($catDisplayType == 'c_picture_list'): ?>
				
				<?php echo $__env->make('front.sections.home.categories.c-picture-list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			<?php elseif($catDisplayType == 'c_bigIcon_list'): ?>
				
				<?php echo $__env->make('front.sections.home.categories.c-big-icon-list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			<?php elseif(in_array($catDisplayType, ['cc_normal_list', 'cc_normal_list_s'])): ?>
				
				<?php echo $__env->make('front.sections.home.categories.cc-normal-list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			<?php elseif(in_array($catDisplayType, ['c_normal_list', 'c_border_list'])): ?>
				
				<?php echo $__env->make('front.sections.home.categories.c-normal-list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			<?php else: ?>
				
				
				<?php echo $__env->make('front.sections.home.categories.c-big-icon-list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			<?php endif; ?>
		</div>
	
	</div>
</div>

<?php $__env->startSection('before_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('before_scripts'); ?>
	<?php if($maxSubCats >= 0): ?>
		<script>
			var maxSubCats = <?php echo e($maxSubCats); ?>;
		</script>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		onDocumentReady((event) => {
			
			
			const elements = document.querySelectorAll('.big-icon-category-list a h6, .picture-category-list a h6');
			if (elements.length) {
				const animation = 'animate__pulse';
				
				elements.forEach((element) => {
					element.addEventListener('mouseover', (event) => {
						event.target.classList.add('animate__animated', animation);
					});
					element.addEventListener("mouseout", (event) => {
						event.target.classList.remove('animate__animated', animation);
					});
				})
			}
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/sections/home/categories.blade.php ENDPATH**/ ?>