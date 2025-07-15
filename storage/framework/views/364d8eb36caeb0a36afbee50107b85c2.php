<?php
	$post ??= [];
?>
<div class="vstack gap-4">
	
	<?php if(request()->segment(1) == 'create' || request()->segment(2) == 'create'): ?>
		
		<div class="vstack gap-3 text-center">
			<i class="fa-regular fa-image fa-4x text-warning"></i>
			<h5 class="mb-0 fs-5 fw-bold">
				<?php echo e(t('create_new_listing')); ?>

			</h5>
			<p>
				<?php echo e(t('do_you_have_something_text', ['appName' => config('app.name')])); ?>

			</p>
		</div>
	<?php else: ?>
		
		<?php if(isSingleStepFormEnabled()): ?>
			
			<?php if(auth()->check()): ?>
				<?php if(auth()->user()->getAuthIdentifier() == data_get($post, 'user_id')): ?>
					<div class="card">
						<div class="card-header fw-bold text-center">
							<?php echo e(t('author_actions')); ?>

						</div>
						<div class="card-body text-center">
							<div class="d-grid">
								<a href="<?php echo e(urlGen()->post($post)); ?>" class="btn btn-secondary">
									<i class="fa-regular fa-hand-point-right"></i> <?php echo e(t('Return to the listing')); ?>

								</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			
		<?php else: ?>
			
			<?php if(auth()->check()): ?>
				<?php if(auth()->user()->getAuthIdentifier() == data_get($post, 'user_id')): ?>
					<div class="card">
						<div class="card-header fw-bold text-center">
							<?php echo e(t('author_actions')); ?>

						</div>
						<div class="card-body text-center">
							<div class="d-grid vstack gap-2">
								<a href="<?php echo e(urlGen()->post($post)); ?>" class="btn btn-secondary">
									<i class="fa-regular fa-hand-point-right"></i> <?php echo e(t('Return to the listing')); ?>

								</a>
								<a href="<?php echo e(url('posts/' . data_get($post, 'id') . '/photos')); ?>" class="btn btn-secondary">
									<i class="fa-solid fa-camera"></i> <?php echo e(t('Update Photos')); ?>

								</a>
								<?php if(isset($countPackages) && isset($countPaymentMethods) && $countPackages > 0 && $countPaymentMethods > 0): ?>
									<a href="<?php echo e(url('posts/' . data_get($post, 'id') . '/payment')); ?>" class="btn btn-success">
										<i class="fa-regular fa-circle-check"></i> <?php echo e(t('Make It Premium')); ?>

									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			
		<?php endif; ?>
	<?php endif; ?>
	
	<div class="card border-color-primary">
		<div class="card-header fw-bold bg-primary border-color-primary text-white text-uppercase text-center">
			<?php echo e(t('how_to_sell_quickly')); ?>

		</div>
		<div class="card-body text-start">
			<ul class="list-unstyled vstack gap-2">
				<li><i class="bi bi-check-lg"></i> <?php echo e(t('sell_quickly_advice_1')); ?></li>
				<li><i class="bi bi-check-lg"></i> <?php echo e(t('sell_quickly_advice_2')); ?></li>
				<li><i class="bi bi-check-lg"></i> <?php echo e(t('sell_quickly_advice_3')); ?></li>
				<li><i class="bi bi-check-lg"></i> <?php echo e(t('sell_quickly_advice_4')); ?></li>
				<li><i class="bi bi-check-lg"></i> <?php echo e(t('sell_quickly_advice_5')); ?></li>
			</ul>
		</div>
	</div>
	
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/front/post/createOrEdit/partials/right-sidebar.blade.php ENDPATH**/ ?>