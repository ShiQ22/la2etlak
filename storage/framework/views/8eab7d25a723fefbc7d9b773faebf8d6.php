<?php $__env->startSection('notifications'); ?>
	<?php
		$withMessage = !session()->has('flash_notification');
		$resendVerificationLink = getResendVerificationLink(withMessage: $withMessage);
	?>
	<?php if(!empty($resendVerificationLink)): ?>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-11 col-xxl-10 mx-auto">
			<div class="alert alert-info text-center">
				<?php echo $resendVerificationLink; ?>

			</div>
		</div>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-11 col-xxl-10 mx-auto">
		<?php
			// $mbAuth = socialLogin()->isEnabled() ? ' mb-4' : ' mb-4';
			$mbAuth = ' mb-4';
		?>
		<div class="row d-flex justify-content-center">
			<div class="col-12 col-sm-12 col-md-12 col-lg-11 col-xl-10 col-xxl-8">
				<h3 class="fw-600<?php echo e($mbAuth); ?>"><?php echo e(trans('auth.sign_in')); ?></h3>
			</div>
		</div>
		
		<?php echo $__env->make('auth.login.partials.social', ['page' => 'login', 'position' => 'top'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
		<div class="row d-flex justify-content-center">
			<div class="col-12 col-sm-12 col-md-12 col-lg-11 col-xl-10 col-xxl-8">
				<p class="text-muted mb-4"><?php echo e(getLoginDescription()); ?></p>
				
				<form id="loginForm" action="<?php echo e(url()->current()); ?>" method="post" role="form">
					<?php echo csrf_field(); ?>
					<?php echo view('honeypot::honeypot'); ?>
					
					<input type="hidden" name="country" value="<?php echo e(config('country.code')); ?>">
					
					
					<?php
						$labelRight = '';
						if (isPhoneAsAuthFieldEnabled()) {
							$labelRight .= '<a href="" class="auth-field" data-auth-field="phone">';
							$labelRight .= trans('auth.login_with_phone');
							$labelRight .= '</a>';
						}
						$emailValue = session()->has('email') ? session('email') : null;
					?>
					<?php echo $__env->make('helpers.forms.fields.text', [
						'label'             => trans('auth.email'),
						'labelRightContent' => $labelRight,
						'id'                => 'email',
						'name'              => 'email',
						'required'          => (getAuthField() == 'email'),
						'placeholder'       => trans('auth.email_or_username'),
						'value'             => $emailValue,
						'wrapper'           => ['class' => 'auth-field-item'],
					], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					
					
					<?php if(isPhoneAsAuthFieldEnabled()): ?>
						<?php
							$labelRight = '<a href="" class="auth-field" data-auth-field="email">';
							$labelRight .= trans('auth.login_with_email');
							$labelRight .= '</a>';
							
							$phoneValue = session()->has('phone') ? session('phone') : null;
							$phoneCountryValue = config('country.code');
						?>
						<?php echo $__env->make('helpers.forms.fields.intl-tel-input', [
							'label'             => trans('auth.phone_number'),
							'labelRightContent' => $labelRight,
							'id'                => 'phone',
							'name'              => 'phone',
							'required'          => (getAuthField() == 'phone'),
							'placeholder'       => null,
							'value'             => $phoneValue,
							'countryCode'       => $phoneCountryValue,
							'wrapper'           => ['class' => 'auth-field-item'],
						], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					<?php endif; ?>
					
					
					<input name="auth_field" type="hidden" value="<?php echo e(old('auth_field', getAuthField())); ?>">
					
					
					<?php echo $__env->make('helpers.forms.fields.password', [
						'label'          => trans('auth.password'),
						'name'           => 'password',
						'placeholder'    => trans('auth.password'),
						'required'       => true,
						'value'          => null,
						'togglePassword' => 'link',
						'hint'           => false,
					], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					
					
					<?php
						$labelRight = '<a href="' . urlGen()->passwordForgot() . '">';
						$labelRight .= trans('auth.forgot_password');
						$labelRight .= '</a>';
					?>
					<?php echo $__env->make('helpers.forms.fields.checkbox', [
						'label'             => trans('auth.remember_me'),
						'labelRightContent' => $labelRight,
						'id'                => 'rememberMe',
						'name'              => 'remember',
						'value'             => null,
						'wrapper'           => ['class' => 'mt-4'],
					], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					
					
					<?php echo $__env->make('helpers.forms.fields.captcha', ['label' => trans('auth.captcha_human_verification')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					
					
					<div class="d-grid my-4">
						<button type="submit" id="loginBtn" class="btn btn-primary btn-block"><?php echo e(trans('auth.log_in')); ?></button>
					</div>
				
				</form>
			</div>
		</div>
		
		<p class="text-center text-muted mb-0">
			<?php echo e(trans('auth.dont_have_account')); ?> <a href="<?php echo e(urlGen()->signUp()); ?>"><?php echo e(trans('auth.create_account')); ?></a>
		</p>
	
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/auth/login/index.blade.php ENDPATH**/ ?>