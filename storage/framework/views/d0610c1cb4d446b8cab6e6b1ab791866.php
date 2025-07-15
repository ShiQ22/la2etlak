<?php
	$prefixId ??= '';
	
	// Clear Filter Button
	$clearFilterBtn = urlGen()->getDateFilterClearLink($cat ?? null, $city ?? null);
?>

<div class="container p-0 vstack gap-2">
	<h5 class="border-bottom pb-2 d-flex justify-content-between">
		<span class="fw-bold"><?php echo e(t('Date Posted')); ?></span> <?php echo $clearFilterBtn; ?>

	</h5>
	<ul class="mb-0 list-unstyled ps-1">
		<?php if(!empty($periodList)): ?>
			<?php $__currentLoopData = $periodList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<li class="p-1">
					<input type="radio"
					       name="postedDate"
					       value="<?php echo e($key); ?>"
					       id="<?php echo e($prefixId); ?>postedDate_<?php echo e($key); ?>" <?php echo e((request()->query('postedDate')==$key) ? 'checked="checked"' : ''); ?>

					>
					<label for="postedDate_<?php echo e($key); ?>" class="fw-normal"><?php echo e($value); ?></label>
				</li>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
		<input type="hidden"
		       id="postedQueryString"
		       name="postedQueryString"
		       value="<?php echo e(\App\Helpers\Common\Arr::query(request()->except(['page', 'postedDate']))); ?>"
		>
	</ul>
</div>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/sidebar/date.blade.php ENDPATH**/ ?>