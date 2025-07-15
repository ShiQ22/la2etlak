<?php
	$packages ??= collect();
	$paymentMethods ??= collect();
	
	$selectedPackage ??= null;
	$currentPackagePrice = $selectedPackage->price ?? 0;
	$noPackageOrPremiumOneSelected ??= true;
?>
<?php if($paymentMethods->count() > 0 && $noPackageOrPremiumOneSelected): ?>
	<?php if(!empty($selectedPackage)): ?>
		
		<div class="col-12 fw-bold fs-5 border-bottom py-2 my-5 mb-4">
			<i class="fa-solid fa-wallet"></i> <?php echo e(t('Payment')); ?>

		</div>
		
		<div class="col-md-12 mb-4">
			<div class="container bg-body rounded p-2">
				
				<div class="row">
					<div class="col-sm-12">
						
						<div class="form-group mb-0">
							<fieldset>
								<?php echo $__env->make('front.payment.packages.selected', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							</fieldset>
						</div>
					
					</div>
				</div>
				
			</div>
		</div>
		
	<?php else: ?>
	
		<?php if($packages->count() > 0): ?>
			<div class="col-12 fw-bold fs-5 border-bottom py-2 my-5 mb-4">
				<i class="fa-solid fa-tags"></i> <?php echo e(t('Packages')); ?>

			</div>
			
			<div class="col-md-12 mb-4">
				<div class="container bg-body rounded p-2">
					
					<div class="row">
						<div class="col-sm-12">
							<fieldset>
								<?php echo $__env->make('front.payment.packages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							</fieldset>
						</div>
					</div>
					
				</div>
			</div>
		<?php endif; ?>
		
	<?php endif; ?>
<?php endif; ?>

<?php $__env->startSection('after_styles'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		const packageType = 'promotion';
		const formType = 'singleStep';
		const isCreationFormPage = <?php echo e(request()->segment(1) == 'create' ? 'true' : 'false'); ?>;
	</script>
	<?php echo $__env->make('front.common.js.payment-js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/post/createOrEdit/singleStep/partials/packages.blade.php ENDPATH**/ ?>