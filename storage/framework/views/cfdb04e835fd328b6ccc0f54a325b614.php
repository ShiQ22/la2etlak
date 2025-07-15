<?php if($xPanel->hasAccess('show')): ?>
	<a href="<?php echo e(url($xPanel->route.'/'.$entry->getKey())); ?>" class="btn btn-xs btn-secondary"><i class="fa-regular fa-eye"></i> <?php echo e(trans('admin.preview')); ?></a>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/buttons/preview.blade.php ENDPATH**/ ?>