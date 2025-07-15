
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			
			<div class="modal-header px-3">
				<h4 class="modal-title fs-5 fw-bold" id="errorModalLabel">
					<?php echo e(t('error_found')); ?>

				</h4>
				
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo e(t('Close')); ?>"></button>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div id="errorModalBody" class="col-12">
						...
					</div>
				</div>
			</div>
			
			<div class='modal-footer'>
				<button type="button" class="btn btn-primary" data-bs-dismiss="modal"><?php echo e(t('Close')); ?></button>
			</div>
			
		</div>
	</div>
</div>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/layouts/partials/modal/error.blade.php ENDPATH**/ ?>