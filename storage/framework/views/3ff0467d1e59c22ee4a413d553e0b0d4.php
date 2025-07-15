<?php
	$modalSize ??= 'modal-xl';
	$itemClass ??= '';
	
	$countries ??= collect();
	$countryFlagShape = config('settings.localization.country_flag_shape');
	
	// Languages Selection Modal vars
	$showCountryFlagNextLang = (config('settings.localization.show_country_flag') == 'in_next_lang');
	// Check if the Multi-Countries selection is enabled
	$multiCountryIsEnabled = false;
	if ($showCountryFlagNextLang) {
		if (!empty(config('country.code'))) {
			if ($countries->count() > 1) {
				$multiCountryIsEnabled = true;
			}
		}
	}
?>

<div class="modal fade" id="selectCountry" tabindex="-1" aria-labelledby="selectCountryLabel" aria-hidden="true">
	<div class="modal-dialog <?php echo e($modalSize); ?> modal-dialog-scrollable">
		<div class="modal-content">
			
			<div class="modal-header px-3">
				<h4 class="modal-title fs-5 fw-bold" id="selectCountryLabel">
					<i class="bi bi-geo-alt"></i> <?php echo e(t('select_country')); ?>

				</h4>
				
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo e(t('Close')); ?>"></button>
			</div>
			
			
			
			<div class="modal-body" style="max-height: 495px; min-height: 140px;">
				<div id="modalCountryList" class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-2 px-lg-1 px-md-1 px-sm-3 px-3">
					
					<?php if($countries->isNotEmpty()): ?>
						<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col d-flex align-items-center my-1 <?php echo e($itemClass); ?>">
								<?php
									$countryUrl = dmUrl($country, '/', true, !config('plugins.domainmapping.installed'));
									$countryName = $country->get('name');
									$countryNameLimited = str($countryName)->limit(21)->toString();
								?>
								<?php if($countryFlagShape == 'rectangle'): ?>
									<img src="<?php echo e(url('images/blank.gif') . getPictureVersion()); ?>"
										 class="flag flag-<?php echo e($country->get('icode')); ?> me-2"
									     alt="<?php echo e($countryNameLimited); ?>"
									>
								<?php else: ?>
									<img src="<?php echo e($country->get('flag16_url')); ?>"
									     class="me-2"
									     alt="<?php echo e($countryNameLimited); ?>"
									>
								<?php endif; ?>
								<a href="<?php echo e($countryUrl); ?>"
								   class="link-primary text-decoration-none"
								   data-bs-toggle="tooltip"
								   data-bs-custom-class="modal-tooltip"
								   title="<?php echo e($countryName); ?>"
								>
									<?php echo e($countryNameLimited); ?>

								</a>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
					
				</div>
			</div>
			
			<?php if($showCountryFlagNextLang && $multiCountryIsEnabled): ?>
				<div class="modal-footer auth-login-register">
					<button class="btn btn-sm btn-primary rounded-pill px-4" data-bs-target="#selectLanguage" data-bs-toggle="modal">
						<i class="bi bi-translate"></i>  <?php echo e(mb_ucfirst(trans('admin.languages'))); ?>

					</button>
				</div>
			<?php endif; ?>
			
		</div>
	</div>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/front/layouts/partials/modal/countries.blade.php ENDPATH**/ ?>