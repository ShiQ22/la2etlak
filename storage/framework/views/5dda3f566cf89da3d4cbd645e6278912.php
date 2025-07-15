<div class="modal fade" id="maintenanceMode">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?php echo e(trans('admin.Maintenance Mode')); ?></h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo e(t('Close')); ?>"></button>
			</div>
			
			<form role="form" method="POST" action="<?php echo e(urlGen()->adminUrl('actions/maintenance/down')); ?>">
				<?php echo csrf_field(); ?>

				
				<div class="modal-body">
					
					<?php if(isset($errors) && $errors->any() && old('maintenanceForm')=='1'): ?>
						<div class="alert alert-danger ms-0 me-0 mb-5">
							<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php echo e($error); ?><br>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					<?php endif; ?>
					
					<?php
						if (isset($errors)) {
							$messageHasError = $errors->has('message');
							$messageRowError = $messageHasError ? ' has-danger' : '';
							$messageFieldError = $messageHasError ? ' form-control-danger' : '';
							$messageError = $errors->first('message');
						}
					?>
					<div class="form-group required<?php echo e($messageRowError ?? ''); ?>">
						<label for="message" class="control-label">
							<?php echo e(t('Message')); ?> <span class="text-count">(<?php echo e(t('number_max', ['number' => 500])); ?>)</span>
						</label>
						<textarea id="message"
						          name="message"
						          class="form-control required<?php echo e($messageFieldError ?? ''); ?>"
						          placeholder="<?php echo e(trans('admin.Be right back')); ?>"
						          rows="3"
						><?php echo e(old('message')); ?></textarea>
					</div>
					<?php if(isset($messageHasError) && $messageHasError): ?>
						<div class="invalid-feedback"><?php echo e($messageError ?? ''); ?></div>
					<?php endif; ?>
					
					<input type="hidden" name="maintenanceForm" value="1">
				</div>
				
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"><?php echo e(trans('admin.Put in Maintenance Mode')); ?></button>
					<button type="button" class="btn btn-light float-start" data-bs-dismiss="modal"><?php echo e(t('Close')); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/layouts/partials/maintenance.blade.php ENDPATH**/ ?>