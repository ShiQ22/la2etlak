<?php
	$post ??= [];
	$fiTheme = config('larapen.core.fileinput.theme', 'bs5');
	$allowedFileFormatsJson = collect(getAllowedFileFormats())->toJson();
	
	$actionUrl =url(urlGen()->getAccountBasePath() . '/messages/posts/' . data_get($post, 'id'));
?>
<form action="<?php echo e($actionUrl); ?>" method="POST" enctype="multipart/form-data" role="form">
	<?php echo csrf_field(); ?>
	<?php echo view('honeypot::honeypot'); ?>
	<div class="modal fade" id="contactUser" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				
				<div class="modal-header px-3">
					<h4 class="modal-title fs-5 fw-bold">
						<i class="bi bi-envelope"></i> <?php echo e(t('contact_advertiser')); ?>

					</h4>
					
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo e(t('Close')); ?>"></button>
				</div>
				
				<div class="modal-body">
					<?php if(isset($errors) && $errors->any() && old('messageForm')=='1'): ?>
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
							<ul class="mb-0 list-unstyled">
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li class="lh-lg"><i class="bi bi-check-lg me-1"></i><?php echo e($error); ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					<?php endif; ?>
					
					<?php
						$authUser = auth()->check() ? auth()->user() : null;
						$isNameCanBeHidden = (!empty($authUser));
						$isEmailCanBeHidden = (!empty($authUser) && !empty($authUser->email));
						$isPhoneCanBeHidden = (!empty($authUser) && !empty($authUser->phone));
						$authFieldValue = data_get($post, 'auth_field', getAuthField());
					?>
					
					
					<?php if($isNameCanBeHidden): ?>
						<input type="hidden" name="name" value="<?php echo e($authUser->name ?? null); ?>">
					<?php else: ?>
						<?php echo $__env->make('helpers.forms.fields.text', [
							'label'       => t('Name'),
							'id'          => 'fromName',
							'name'        => 'name',
							'placeholder' => t('enter_your_name'),
							'required'    => true,
							'value'       => $authUser->name ?? null,
						], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					<?php endif; ?>
					
					
					<?php if($isEmailCanBeHidden): ?>
						<input type="hidden" name="email" value="<?php echo e($authUser->email ?? null); ?>">
					<?php else: ?>
						<?php echo $__env->make('helpers.forms.fields.email', [
							'label'       => trans('auth.email'),
							'id'          => 'fromEmail',
							'name'        => 'email',
							'required'    => ($authFieldValue == 'email'),
							'placeholder' => t('enter_your_email'),
							'value'       => $authUser->email ?? null,
							'attributes'  => ['data-valid-type' => 'email'],
							'prefix'      => '<i class="fa-regular fa-envelope"></i>',
							'suffix'      => null,
							'baseClass'   => ['wrapper' => 'mb-3 col-lg-8'],
						], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					<?php endif; ?>
					
					
					<?php if($isPhoneCanBeHidden): ?>
						<input type="hidden" name="phone" value="<?php echo e($authUser->phone ?? null); ?>">
						<input name="phone_country" type="hidden" value="<?php echo e($authUser->phone_country ?? config('country.code')); ?>">
					<?php else: ?>
						<?php
							$phoneValue = $authUser->phone ?? null;
							$phoneCountryValue = $authUser->phone_country ?? config('country.code');
							$phoneRequiredClass = ($authFieldValue == 'phone') ? ' required' : '';
						?>
						<?php echo $__env->make('helpers.forms.fields.intl-tel-input', [
							'label'       => trans('auth.phone_number'),
							'id'          => 'fromPhone',
							'name'        => 'phone',
							'required'    => ($authFieldValue == 'phone'),
							'placeholder' => trans('auth.phone_number'),
							'value'       => $phoneValue,
							'attributes'  => ['maxlength' => 60],
							'countryCode' => $phoneCountryValue,
							'baseClass'   => ['wrapper' => 'mb-3 col-lg-8'],
						], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					<?php endif; ?>
					
					
					<input name="auth_field" type="hidden" value="<?php echo e($authFieldValue); ?>">
					
					
					<?php echo $__env->make('helpers.forms.fields.textarea', [
						'label'       => t('Message') . ' <span class="text-count">(500 max)</span>',
						'id'          => 'body',
						'name'        => 'body',
						'placeholder' => t('enter_your_message'),
						'required'    => true,
						'value'       => null,
						'default'     => t('is_still_available', ['name' => data_get($post, 'contact_name', t('sir_miss'))]),
						'attributes'    => ['rows' => 5],
						'pluginOptions' => ['height' => 150],
					], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					
					
					<?php
						$catType = data_get($post, 'category.parent.type', data_get($post, 'category.type'));
					?>
					<?php if($catType == 'job-offer'): ?>
						<?php echo $__env->make('helpers.forms.fields.fileinput', [
							'label' => t('Resume'),
							'name'  => 'file_path',
						], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
						<input type="hidden" name="catType" value="<?php echo e($catType); ?>">
					<?php endif; ?>
					
					
					<?php echo $__env->make('helpers.forms.fields.captcha', ['label' => trans('auth.captcha_human_verification')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					
					<input type="hidden" name="country_code" value="<?php echo e(config('country.code')); ?>">
					<input type="hidden" name="post_id" value="<?php echo e(data_get($post, 'id')); ?>">
					<input type="hidden" name="messageForm" value="1">
				</div>
				
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary float-end"><?php echo e(t('send_message')); ?></button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(t('Cancel')); ?></button>
				</div>
			</div>
		</div>
	</div>
</form>
<?php $__env->startSection('after_styles'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		<?php if(auth()->check()): ?>
			phoneCountry = '<?php echo e(old('phone_country', ($phoneCountryValue ?? ''))); ?>';
		<?php endif; ?>
		
		onDocumentReady((event) => {
			
			<?php if($errors->any()): ?>
				<?php if($errors->any() && old('messageForm') == '1'): ?>
					const contactUserEl = document.getElementById('contactUser');
					if (contactUserEl) {
						const contactUserModal = new bootstrap.Modal(contactUserEl, {});
						contactUserModal.show();
					}
				<?php endif; ?>
			<?php endif; ?>
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/account/messenger/modal/create.blade.php ENDPATH**/ ?>