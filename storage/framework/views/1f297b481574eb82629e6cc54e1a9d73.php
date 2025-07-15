<form action="<?php echo e(urlGen()->signIn()); ?>" method="POST" role="form">
	<?php echo csrf_field(); ?>
	<div class="modal fade" id="quickLogin" tabindex="-1" aria-labelledby="quickLoginLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				
				<div class="modal-header px-3">
					<h4 class="modal-title fs-5 fw-bold" id="quickLoginLabel">
						<i class="fa-solid fa-right-to-bracket"></i> <?php echo e(trans('auth.log_in')); ?>

					</h4>
					
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo e(t('Close')); ?>"></button>
				</div>
				
				<div class="modal-body">
					<div class="row">
						<div class="col-12">
							<input type="hidden" name="language_code" value="<?php echo e(config('app.locale')); ?>">
							
							<?php if(isset($errors) && $errors->any() && old('quickLoginForm')=='1'): ?>
								<div class="alert alert-danger alert-dismissible">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
									<ul class="mb-0 list-unstyled">
										<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<li class="lh-lg"><i class="bi bi-check-lg me-1"></i><?php echo $error; ?></li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</ul>
								</div>
							<?php endif; ?>
							
							<?php echo $__env->make('auth.login.partials.social', ['socialCol' => 12, 'page' => 'modal'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							<?php
								$mtAuth = !socialLogin()->isEnabled() ? ' mt-3' : '';
							?>
							
							
							
							<?php
								$labelRight = '';
								if (isPhoneAsAuthFieldEnabled()) {
									$labelRight .= '<a href="" class="link-primary text-decoration-none auth-field" data-auth-field="phone" data-ignore-guard="true">';
									$labelRight .= trans('auth.login_with_phone');
									$labelRight .= '</a>';
								}
								$emailValue = session()->has('email') ? session('email') : null;
							?>
							<?php echo $__env->make('helpers.forms.fields.text', [
								'label'             => trans('auth.email'),
								'labelRightContent' => $labelRight,
								'id'                => 'mEmail',
								'name'              => 'email',
								'required'          => (getAuthField() == 'email'),
								'placeholder'       => trans('auth.email_or_username'),
								'value'             => $emailValue,
								'prefix'            => '<i class="bi bi-person"></i>',
								'wrapper'           => ['class' => 'auth-field-item' . $mtAuth],
							], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							
							
							<?php if(isPhoneAsAuthFieldEnabled()): ?>
								<?php
									$labelRight = '<a href="" class="link-primary text-decoration-none auth-field" data-auth-field="email" data-ignore-guard="true">';
									$labelRight .= trans('auth.login_with_email');
									$labelRight .= '</a>';
									
									$phoneValue = session()->has('phone') ? session('phone') : null;
									$phoneCountryValue = config('country.code');
								?>
								<?php echo $__env->make('helpers.forms.fields.intl-tel-input', [
									'label'             => trans('auth.phone_number'),
									'labelRightContent' => $labelRight,
									'id'                => 'mPhone',
									'name'              => 'phone',
									'required'          => (getAuthField() == 'phone'),
									'placeholder'       => null,
									'value'             => $phoneValue,
									'attributes'        => ['class' => 'form-control m-phone'],
									'countryCode'       => $phoneCountryValue,
									'independentJs'     => true,
									'wrapper'           => ['class' => 'auth-field-item' . $mtAuth],
								], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							<?php endif; ?>
							
							
							<input name="auth_field" type="hidden" value="<?php echo e(old('auth_field', getAuthField())); ?>">
							
							
							<?php echo $__env->make('helpers.forms.fields.password', [
								'label'          => trans('auth.password'),
								'id'             => 'mPassword',
								'name'           => 'password',
								'placeholder'    => trans('auth.password'),
								'required'       => true,
								'value'          => null,
								'prefix'         => '<i class="bi bi-asterisk"></i>',
								'togglePassword' => 'icon',
								'hint'           => false,
							], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							
							
							<?php
								$labelRight = '<a href="' . urlGen()->passwordForgot() . '" class="' . linkClass() . '">';
								$labelRight .= trans('auth.forgot_password');
								$labelRight .= '</a>';
								$labelRight .= '<br>';
								$labelRight .= '<a href="' . urlGen()->signUp() . '" class="' . linkClass() . '">';
								$labelRight .= trans('auth.create_account');
								$labelRight .= '</a>';
							?>
							<?php echo $__env->make('helpers.forms.fields.checkbox', [
								'label'             => trans('auth.remember_me'),
								'labelRightContent' => $labelRight,
								'id'                => 'rememberMe2',
								'name'              => 'remember',
								'value'             => null,
								'wrapper'           => ['class' => 'mt-4'],
							], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							
							
							<?php echo $__env->make('helpers.forms.fields.captcha', ['label' => trans('auth.captcha_human_verification')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							
							<input type="hidden" name="quickLoginForm" value="1">
							
						</div>
					</div>
				</div>
				
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary float-end"><?php echo e(trans('auth.log_in')); ?></button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(t('Cancel')); ?></button>
				</div>
			</div>
		</div>
	</div>
</form>
<?php /**PATH C:\xampp\htdocs\resources\views/auth/login/partials/modal.blade.php ENDPATH**/ ?>