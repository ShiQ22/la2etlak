<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('front.common.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				<?php echo $__env->make('front.post.partials.notification', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				
				<div class="col-xl-12">
					
					<?php if(session()->has('message')): ?>
						<div class="container border rounded bg-body-tertiary p-4 p-lg-3 p-md-2 mb-sm-3">
							<div class="row">
								<div class="col-12">
									<div class="alert alert-success mb-0" role="alert">
										<h2 class="p-0 mb-3">
											<i class="fa-regular fa-circle-check"></i> <?php echo e(t('congratulations')); ?>

										</h2>
										<p class="mb-0">
											<?php echo e(session('message')); ?> <a href="<?php echo e(url('/')); ?>"><?php echo e(t('Homepage')); ?></a>
										</p>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					
				</div>
			</div>
		</div>
	</div>
	
	<?php echo $__env->renderWhen(!auth()->check(), 'auth.login.partials.modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>
<?php $__env->stopSection(); ?>
<?php
	if (!session()->has('resendEmailVerificationData') && !session()->has('resendPhoneVerificationData')) {
		if (session()->has('message')) {
			session()->forget('message');
		}
	}
?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/post/createOrEdit/singleStep/finish.blade.php ENDPATH**/ ?>