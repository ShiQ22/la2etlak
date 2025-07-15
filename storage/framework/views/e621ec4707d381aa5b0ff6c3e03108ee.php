<?php if($xPanel->hasAccess('delete')): ?>
	<a href="<?php echo e(url($xPanel->route.'/'.$entry->getKey())); ?>" class="btn btn-xs btn-danger" data-button-type="delete">
		<i class="fa-regular fa-trash-can"></i> <?php echo e(trans('admin.delete')); ?>

	</a>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/buttons/delete.blade.php ENDPATH**/ ?>