<?php
	$htmlLang = getLangTag(config('app.locale'));
	$userThemePreference = currentUserThemePreference();
	
	$htmlDir = (config('lang.direction') == 'rtl') ? ' dir="rtl"' : '';
	$htmlTheme = ($userThemePreference == 'dark') ? ' theme="dark"' : '';
	$showIconOnly = false;
	
	$helpers = getViewHelpersNames(snakeCase: true);
	
	// Logo
	$logoFactoryUrl = config('larapen.media.logo-factory');
	$logoUrl = '';
	try {
        if (is_link(public_path('storage'))) {
			$logoDarkUrl = config('settings.app.logo_dark_url', $logoFactoryUrl);
			$logoLightUrl = config('settings.app.logo_light_url', $logoFactoryUrl);
			$logoUrl = $logoLightUrl;
		}
    } catch (\Throwable $e) {}
    $logoUrl = !empty($logoUrl) ? $logoUrl : $logoFactoryUrl;
	$logoWidth = (int)config('settings.upload.img_resize_logo_width', 200);
	$logoHeight = (int)config('settings.upload.img_resize_logo_height', 45);
	$logoWidth = \Illuminate\Support\Number::clamp($logoWidth, min: 150, max: 250);
	$logoHeight = \Illuminate\Support\Number::clamp($logoWidth, min: 40, max: 60);
	$logoCssSize = "max-width:{$logoWidth}px; max-height:{$logoHeight}px; width:auto; height:auto;";
    $appName = config('app.name', 'SiteName');
    $logoLabel = config('settings.app.name', $appName);
	$logoAlt = strtolower($logoLabel);
	
	// Hero Background Image
	$heroBgStyle = '';
    try {
        if (is_link(public_path('storage'))) {
            $bgImgUrl = config('settings.auth.hero_image_url');
            $heroBgStyle = 'background-image:url(' . $bgImgUrl . ');';
        }
    } catch (\Throwable $e) {}
?>
<!DOCTYPE html>
<html lang="<?php echo e($htmlLang); ?>"<?php echo $htmlDir . $htmlTheme; ?> data-bs-theme="dark">
<head>
	<meta charset="<?php echo e(config('larapen.core.charset', 'utf-8')); ?>"/>
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
	<link href="<?php echo e(config('settings.app.favicon_url')); ?>" rel="icon"/>
	<title><?php echo MetaTag::get('title'); ?></title>
	<?php echo MetaTag::tag('description'); ?><?php echo MetaTag::tag('keywords'); ?>

	<link rel="canonical" href="<?php echo e(request()->fullUrl()); ?>"/>
	
	
	<base target="_top"/>
	
	<?php echo $__env->yieldContent('before_styles'); ?>
	
	
	<?php if(config('lang.direction') == 'rtl'): ?>
		<link href="https://fonts.googleapis.com/css?family=Cairo|Changa" rel="stylesheet">
		<link href="<?php echo e(url(mix('dist/auth/styles.rtl.css'))); ?>" rel="stylesheet">
	<?php else: ?>
		<link href="<?php echo e(url(mix('dist/auth/styles.css'))); ?>" rel="stylesheet">
	<?php endif; ?>
	
	
	<?php
		$skinQs = request()->filled('skin') ? '?skin=' . request()->query('skin') : null;
		$styleCssUrl = url('auth/common/css/skin.css') . $skinQs . getPictureVersion(!empty($skinQs));
	?>
	<link href="<?php echo e($styleCssUrl); ?>" rel="stylesheet">
	
	<?php echo $__env->yieldContent('after_styles'); ?>
	
	<?php if(!empty($helpers)): ?>
		<?php $__currentLoopData = $helpers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $helper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php echo $__env->yieldPushContent($helper . '_styles'); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>
	
	<?php echo $__env->make('front.common.js.document', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php if(!empty($helpers)): ?>
		<?php $__currentLoopData = $helpers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $helper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php echo $__env->yieldPushContent($helper . '_head_scripts'); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>
</head>
<body>




<div id="main-wrapper" class="auth-login-register">
	<div class="container-fluid px-0">
		<div class="row g-0 min-vh-100">
			
			
			<div class="col-md-6">
				<div class="hero-wrap d-flex align-items-start h-100">
					<div class="hero-mask opacity-8 bg-primary"></div>
					<div class="hero-bg hero-bg-scroll" style="<?php echo $heroBgStyle; ?>"></div>
					<div class="hero-content w-100 min-vh-100 d-flex flex-column">
						<div class="row g-0">
							<div class="col-11 col-sm-10 col-md-10 col-lg-9 mx-auto">
								<div class="logo mt-5 mb-5 mb-md-0">
									<a class="d-flex" href="<?php echo e(url('/')); ?>" title="<?php echo $logoLabel; ?>">
										<img src="<?php echo e($logoUrl); ?>"
										     alt="<?php echo e($logoAlt); ?>"
										     data-bs-placement="bottom"
										     data-bs-toggle="tooltip"
										     title="<?php echo $logoLabel; ?>"
										     style="<?php echo $logoCssSize; ?>"
										>
									</a>
								</div>
							</div>
						</div>
						<div class="row g-0 my-auto">
							<div class="col-11 col-sm-10 col-md-10 col-lg-9 mx-auto">
								<?php
									$defaultCoverTitle = trans('auth.default_cover_title', ['appName' => config('app.name')]);
									$defaultCoverDescription = trans('auth.default_cover_description');
								?>
								<h1 class="text-11 text-white mb-4">
									<?php echo $coverTitle ?? $defaultCoverTitle; ?>

								</h1>
								<p class="text-4 text-white lh-base mb-5">
									<?php echo $coverDescription ?? $defaultCoverDescription; ?>

								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="col-md-6 d-flex">
				<div class="container my-auto py-5">
					<div class="row g-0">
						
						<?php
							$hasNotifications = (
								(isset($errors) && $errors->any())
								|| session()->has('flash_notification')
								|| session()->has('resendEmailVerificationData')
								|| session()->has('resendPhoneVerificationData')
								|| session()->has('status')
								|| session()->has('email')
								|| session()->has('phone')
								|| session()->has('login')
								|| session()->has('code')
							);
						?>
						
						<?php if(isset($errors) && $errors->any()): ?>
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-11 col-xxl-10 mx-auto">
								<div class="alert alert-danger">
									<?php if(request()->segment(2) == 'register'): ?>
										<h5 class="fw-bold text-danger-emphasis mb-3">
											<?php echo e(trans('auth.validation_errors_title')); ?>

										</h5>
									<?php endif; ?>
									<ul class="mb-0 list-unstyled">
										<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<li class="lh-lg"><i class="bi bi-check-lg me-1"></i><?php echo $error; ?></li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</ul>
								</div>
							</div>
						<?php endif; ?>
						
						<?php if(session()->has('flash_notification')): ?>
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-11 col-xxl-10 mx-auto">
								<?php echo $__env->make('flash::message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							</div>
						<?php endif; ?>
						
						<?php echo $__env->yieldContent('notifications'); ?>
						
						<?php if($hasNotifications): ?>
							<div class="col-12 mx-auto mb-4">&nbsp;</div>
						<?php endif; ?>
						
						<?php echo $__env->yieldContent('content'); ?>
						
						<?php echo $__env->make('auth.layouts.partials.select-language', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					
					</div>
				</div>
			</div>
		
		</div>
	</div>
</div>

<?php $__env->startSection('modal'); ?>
<?php echo $__env->yieldSection(); ?>
<?php echo $__env->make('front.layouts.partials.modal.countries', ['modalSize' => 'modal-xl'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('front.common.js.init', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
	var countryCode = '<?php echo e(config('country.code', 0)); ?>';
	
	
	var isSettingsAppDarkModeEnabled = <?php echo e(isSettingsAppDarkModeEnabled() ? 'true' : 'false'); ?>;
	var isSettingsAppSystemThemeEnabled = <?php echo e(isSettingsAppSystemThemeEnabled() ? 'true' : 'false'); ?>;
	var userThemePreference = <?php echo !empty($userThemePreference) ? "'$userThemePreference'" : 'null'; ?>;
	var showIconOnly = <?php echo e($showIconOnly ? 'true' : 'false'); ?>;
	
	
	var defaultAuthField = '<?php echo e(old('auth_field', getAuthField())); ?>';
	var phoneCountry = '<?php echo e(config('country.code')); ?>';
</script>

<?php echo $__env->yieldContent('before_scripts'); ?>


<?php echo $__env->make('auth.layouts.js.translations', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<script src="<?php echo e(url(mix('dist/auth/scripts.js'))); ?>"></script>

<?php echo $__env->yieldContent('after_scripts'); ?>

<?php if(!empty($helpers)): ?>
	<?php $__currentLoopData = $helpers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $helper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php echo $__env->yieldPushContent($helper . '_scripts'); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\resources\views/auth/layouts/master.blade.php ENDPATH**/ ?>