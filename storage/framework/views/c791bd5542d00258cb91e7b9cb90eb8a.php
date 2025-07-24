
<?php
	$field ??= [];
	
	$entityModel = $field['value'] ?? null;
	$listingsPicturesLimit = (int)config('settings.listing_form.pictures_limit');
	$disk = \Illuminate\Support\Facades\Storage::disk($field['disk']);
?>
<div <?php echo $__env->make('admin.panel.inc.field_wrapper_attributes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> >

	<input type="hidden" name="edit_url" value="<?php echo e(request()->url()); ?>">
	<label class="form-label fw-bolder"><?php echo e($field['label']); ?></label>
	<?php echo $__env->make('admin.panel.fields.inc.translatable_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

	<div class="d-block text-center">
	<?php if(!empty($entityModel) && !$entityModel->isEmpty()): ?>
		<?php $__currentLoopData = $entityModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entityEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="mx-2 my-4 d-inline-block" id="picture<?php echo e($entityEntry->id); ?>">
				<img src="<?php echo e($disk->url($entityEntry->{$field['attribute']})); ?>" style="width:320px; height:auto;">
				<div class="mt-2 text-center">
					<a href="<?php echo e(urlGen()->adminUrl('pictures/' . $entityEntry->id . '/edit')); ?>" class="btn btn-xs btn-secondary">
						<i class="fa-regular fa-pen-to-square"></i> <?php echo e(trans('admin.Edit')); ?>

					</a>&nbsp;
					<a href="<?php echo e(urlGen()->adminUrl('pictures/' . $entityEntry->id)); ?>"
					   class="btn btn-xs btn-danger"
					   data-button-type="delete"
					   data-id="<?php echo e($entityEntry->id); ?>"
					>
						<i class="fa-regular fa-trash-can"></i> <?php echo e(trans('admin.Delete')); ?>

					</a>
				</div>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($entityModel->count() < $listingsPicturesLimit): ?>
            <hr class="border-0 bg-secondary"><br>
            <a href="<?php echo e(urlGen()->adminUrl('pictures/create?post_id=' . request()->segment(3))); ?>" class="btn btn-xs btn-secondary">
				<i class="fa-regular fa-pen-to-square"></i> <?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.picture')); ?>

			</a>
			<br><br>
        <?php endif; ?>
	<?php else: ?>
		<br><?php echo e(trans('admin.No pictures found')); ?><br><br>
        <a href="<?php echo e(urlGen()->adminUrl('pictures/create?post_id=' . request()->segment(3))); ?>" class="btn btn-xs btn-secondary">
			<i class="fa-regular fa-pen-to-square"></i> <?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.picture')); ?>

		</a>
		<br><br>
	<?php endif; ?>
	</div>
	<div style="clear: both;"></div>

</div>

<?php if($xPanel->checkIfFieldIsFirstOfItsType($field, $fields)): ?>
    <?php $__env->startPush('crud_fields_scripts'); ?>
    <script>
	    onDocumentReady((event) => {
			$("[data-button-type=delete]").click(function (e) {
				e.preventDefault(); /* does not go through with the link. */
				
				var $this = $(this);
				
				Swal.fire({
					position: 'top',
					text: langLayout.confirm.message.question,
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: langLayout.confirm.button.yes,
					cancelButtonText: langLayout.confirm.button.no
				}).then((result) => {
					if (result.isConfirmed) {
						$.post({
							type: 'DELETE',
							url: $this.attr('href'),
							success: function (result) {
								$('#picture' + $this.data('id')).remove();
								
								pnAlert(langLayout.confirm.message.success, 'success');
							}
						});
					} else if (result.dismiss === Swal.DismissReason.cancel) {
						pnAlert(langLayout.confirm.message.cancel, 'info');
					}
				});
			});
		});
    </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/fields/read_images.blade.php ENDPATH**/ ?>