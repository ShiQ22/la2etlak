<?php
	$customFields ??= [];
?>
<?php if(!empty($customFields)): ?>
	<div class="row gx-1 gy-1 mt-3">
		<div class="col-12">
			<div class="row mb-3">
				<div class="col-12">
					<h4 class="p-0 fs-5">
						<i class="bi bi-journal-plus"></i> <?php echo e(t('Additional Details')); ?>

					</h4>
				</div>
			</div>
		</div>
		
		<div class="col-12">
			<div class="row gx-1 gy-1">
				<?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$fieldType = data_get($field, 'type');
						$fieldName = data_get($field, 'name');
						$fieldValue = data_get($field, 'value');
					?>
					<?php if(is_array($fieldValue)): ?>
						<?php if(count($fieldValue) > 0): ?>
							<div class="col-12">
								<div class="row bg-body-tertiary rounded py-2 mx-0">
									<div class="col-12 mb-2 fw-bolder"><?php echo e($fieldName); ?>:</div>
									<div class="row">
										<?php $__currentLoopData = $fieldValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valueItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<div class="col-sm-4 col-6 py-2">
												<i class="fa-solid fa-check"></i> <?php echo e($valueItem); ?>

											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div>
							</div>
						<?php endif; ?>
					<?php else: ?>
						<?php if(is_string($fieldValue) || is_numeric($fieldValue) || is_bool($fieldValue)): ?>
							<?php if($fieldType == 'file'): ?>
								<div class="col-12">
									<div class="row bg-body-tertiary rounded py-2 mx-0">
										<div class="col-6 fw-bolder"><?php echo e($fieldName); ?></div>
										<div class="col-6 text-sm-end text-start">
											<a class="btn btn-secondary" href="<?php echo e($fieldValue); ?>" target="_blank">
												<i class="fa-solid fa-paperclip"></i> <?php echo e(t('Download')); ?>

											</a>
										</div>
									</div>
								</div>
							<?php elseif($fieldType == 'video'): ?>
								<div class="col-12">
									<div class="row bg-body-tertiary rounded py-2 mx-0">
										<div class="col-12 fw-bolder"><?php echo e($fieldName); ?>:</div>
										<div class="col-12 d-flex justify-content-center embed-responsive embed-responsive-16by9">
											<?php echo $fieldValue; ?>

										</div>
									</div>
								</div>
							<?php else: ?>
								<div class="col-sm-6 col-12">
									<div class="row bg-body-tertiary rounded py-2 mx-0">
										<div class="col-6 fw-bolder"><?php echo e($fieldName); ?></div>
										<div class="col-6 text-sm-end text-start">
											<?php echo $fieldValue; ?>

										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/post/show/partials/details/fields-values.blade.php ENDPATH**/ ?>