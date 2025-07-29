<?php
	$city ??= null;
	$admin ??= null;
	
	$adminType = config('country.admin_type', 0);
	$adminCode = data_get($city, 'subadmin' . $adminType . '_code') ?? data_get($admin, 'code') ?? 0;
?>

<div class="modal fade" id="browseCategories" tabindex="-1" aria-labelledby="categoriesModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div class="modal-content">
			
			<div class="modal-header px-3">
				<h4 class="modal-title fs-5 fw-bold" id="categoriesModalLabel">
					<i class="bi bi-folder-check"></i> <?php echo e(t('select_a_category')); ?>

				</h4>
				
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo e(t('Close')); ?>"></button>
			</div>
			
			<div class="modal-body">
				<div class="p-0 m-0" id="selectCats"></div>
			</div>
			<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
    <?php echo e(t('Cancel')); ?>

  </button>
  <button type="button" class="btn btn-primary" id="catsDoneBtn">
    <?php echo e(t('Done')); ?>

  </button>
</div>

			
		</div>
	</div>
</div>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		var editLabel = '<?php echo e(t('Edit')); ?>';
		
		
		var defaultAdminType = '<?php echo e($adminType); ?>';
		var defaultAdminCode = '<?php echo e($adminCode); ?>';
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/post/createOrEdit/partials/category-modal.blade.php ENDPATH**/ ?>