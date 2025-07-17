<?php
	$authUserIsAdmin ??= true;
	$providers ??= [];
?>
<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('front.common.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<?php echo $__env->make('front.account.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				</div>
				
				<div class="col-md-9">
					
					<?php echo $__env->make('flash::message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					
					<?php if(isset($errors) && $errors->any()): ?>
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
							<h5><strong><?php echo e(t('validation_errors_title')); ?></strong></h5>
							<ul>
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><?php echo $error; ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					<?php endif; ?>
					
					<?php echo $__env->make('front.account.partials.header', [
						'headerTitle' => '<i class="bi bi-plugin"></i> ' . trans('auth.linked_accounts')
					], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					
					<div class="container border rounded bg-body-tertiary p-4 p-lg-3 p-md-2">
						<p><?php echo trans('auth.connected_accounts_hint'); ?></p>
						<div class="row gy-3">
							<?php echo $__env->make('front.account.partials.linked-accounts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/account/linked-accounts.blade.php ENDPATH**/ ?>