<?php
	$authUser ??= auth()->user();
	$lastLoginAt = $authUser->last_login_at ?? null;
	$lastLoginAtFormatted = \App\Helpers\Common\Date::format($lastLoginAt, 'datetime');
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
						'headerTitle' => '<i class="bi bi-person-lines-fill"></i> ' . trans('auth.overview')
					], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					
					<div class="container border rounded bg-body-tertiary p-4 p-lg-3 p-md-2">
						<div class="row mb-3">
							<div class="col-12">
								<h4 class="p-0">
									<?php echo e(t('Hello')); ?> <?php echo e($authUser->name); ?>!
								</h4>
								<span class="small text-secondary">
	                                <?php echo e(t('You last logged in at')); ?>: <?php echo $lastLoginAtFormatted; ?>

	                            </span>
							</div>
						</div>
						
						<?php echo $__env->make('front.account.partials.overview-stats', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/account/overview.blade.php ENDPATH**/ ?>