
<?php
	$htmlLang = getLangTag(config('app.locale'));
	$userThemePreference = currentUserThemePreference();
	
	$htmlDir = (config('lang.direction') == 'rtl') ? ' dir="rtl"' : '';
	$htmlTheme = ($userThemePreference == 'dark') ? ' theme="dark"' : '';
	$showIconOnly = true;
	
	$helpers = getViewHelpersNames(snakeCase: true);
	$plugins = array_keys((array)config('plugins'));
?>
<!DOCTYPE html>
<html lang="<?php echo e($htmlLang); ?>"<?php echo $htmlDir . $htmlTheme; ?>>
<head>
	<meta charset="<?php echo e(config('larapen.core.charset', 'utf-8')); ?>">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<?php echo $__env->make('front.common.meta-robots', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?php echo e(config('settings.app.favicon_url')); ?>">
	<title><?php echo MetaTag::get('title'); ?></title>
	<?php echo MetaTag::tag('description'); ?><?php echo MetaTag::tag('keywords'); ?>

	<link rel="canonical" href="<?php echo e(request()->fullUrl()); ?>"/>
	
	<base target="_top"/>
	<?php if(isset($post)): ?>
		<?php if(isVerifiedPost($post)): ?>
			<?php if(config('services.facebook.client_id')): ?>
				<meta property="fb:app_id" content="<?php echo e(config('services.facebook.client_id')); ?>" />
			<?php endif; ?>
			<?php echo $og->renderTags(); ?>

			<?php echo MetaTag::twitterCard(); ?>

		<?php endif; ?>
	<?php else: ?>
		<?php if(config('services.facebook.client_id')): ?>
			<meta property="fb:app_id" content="<?php echo e(config('services.facebook.client_id')); ?>" />
		<?php endif; ?>
		<?php echo $og->renderTags(); ?>

		<?php echo MetaTag::twitterCard(); ?>

	<?php endif; ?>
	<?php echo $__env->make('feed::links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php echo seoSiteVerification(); ?>

	
	<?php if(file_exists(public_path('manifest.json'))): ?>
		<link rel="manifest" href="<?php echo e(url()->asset('manifest.json')); ?>">
	<?php endif; ?>
	
    <?php echo $__env->yieldContent('before_styles'); ?>
	
	
	<?php if(config('lang.direction') == 'rtl'): ?>
		<link href="https://fonts.googleapis.com/css?family=Cairo|Changa" rel="stylesheet">
		<link href="<?php echo e(url(mix('dist/front/styles.rtl.css'))); ?>" rel="stylesheet">
	<?php else: ?>
		<link href="<?php echo e(url(mix('dist/front/styles.css'))); ?>" rel="stylesheet">
	<?php endif; ?>
	
	
	<?php if(config('plugins.detectadsblocker.installed')): ?>
		<link href="<?php echo e(url('plugins/detectadsblocker/assets/css/style.css') . getPictureVersion()); ?>" rel="stylesheet">
	<?php endif; ?>
	
	
	<?php
		$skinQs = request()->filled('skin') ? '?skin=' . request()->query('skin') : null;
		if (request()->filled('display')) {
			$skinQs .= !empty($skinQs) ? '&' : '?';
			$skinQs .= 'display=' . request()->query('display');
		}
		$styleCssUrl = url('common/css/style.css') . $skinQs . getPictureVersion(!empty($skinQs));
	?>
	<link href="<?php echo e($styleCssUrl); ?>" rel="stylesheet">
	
	
	<?php
		$homeStyle = '';
		if (isset($searchFormOptions) && is_array($searchFormOptions)) {
			$homeStyle = view('front.common.css.homepage', ['searchFormOptions', $searchFormOptions])->render();
		}
	?>
	<?php echo $homeStyle; ?>

	
	
	<link href="<?php echo e(url()->asset('dist/front/custom.css') . getPictureVersion()); ?>" rel="stylesheet">
	
    <?php echo $__env->yieldContent('after_styles'); ?>
	
	<?php echo $__env->yieldPushContent('before_helpers_styles_stack'); ?>
	
	<?php if(!empty($helpers)): ?>
		<?php $__currentLoopData = $helpers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $helper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php echo $__env->yieldPushContent($helper . '_styles'); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>
	
	<?php echo $__env->yieldPushContent('after_helpers_styles_stack'); ?>
	
	<?php if(!empty($plugins)): ?>
		<?php $__currentLoopData = $plugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php echo $__env->yieldContent($plugin . '_styles'); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>
    
    <?php if(config('settings.style.custom_css')): ?>
		<?php echo printCss(config('settings.style.custom_css')) . "\n"; ?>

    <?php endif; ?>
	
	<?php if(config('settings.other.js_code')): ?>
		<?php echo printJs(config('settings.other.js_code')) . "\n"; ?>

	<?php endif; ?>
	
	
 
	<script>
		paceOptions = {
			elements: true
		};
	</script>
	<script src="<?php echo e(url()->asset('assets/plugins/pace-js/1.2.4/pace.min.js')); ?>"></script>
	<link href="<?php echo e(url()->asset('assets/plugins/pace-js/1.2.4/pace-theme-default.min.css')); ?>" rel="stylesheet">
	
	<?php if(!empty($helpers)): ?>
		<?php $__currentLoopData = $helpers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $helper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php echo $__env->yieldPushContent($helper . '_head_scripts'); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>
</head>
<body class="bg-body text-body-emphasis skin">
<?php $__env->startSection('header'); ?>
	<?php echo $__env->make('front.layouts.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->yieldSection(); ?>

<main>
	<?php $__env->startSection('search'); ?>
	<?php echo $__env->yieldSection(); ?>
	
	<?php $__env->startSection('wizard'); ?>
	<?php echo $__env->yieldSection(); ?>
	
	<?php if(isset($siteCountryInfo)): ?>
		<div class="p-0 mt-lg-4 mt-md-3 mt-3"></div>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="alert alert-warning alert-dismissible mb-3">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
						<?php echo $siteCountryInfo; ?>

					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<?php echo $__env->yieldContent('content'); ?>
	
	<?php $__env->startSection('info'); ?>
	<?php echo $__env->yieldSection(); ?>
	
	<?php echo $__env->make('front.layouts.partials.advertising.auto', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php $__env->startSection('modal_location'); ?>
	<?php echo $__env->yieldSection(); ?>
	<?php $__env->startSection('modal_languages'); ?>
	<?php echo $__env->yieldSection(); ?>
	<?php $__env->startSection('modal_abuse'); ?>
	<?php echo $__env->yieldSection(); ?>
	<?php $__env->startSection('modal_message'); ?>
	<?php echo $__env->yieldSection(); ?>
	
	<?php echo $__env->make('front.layouts.partials.modal.countries', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php echo $__env->make('front.layouts.partials.modal.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php echo $__env->make('cookie-consent::index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php if(config('plugins.detectadsblocker.installed')): ?>
		<?php if(view()->exists('detectadsblocker::modal')): ?>
			<?php echo $__env->make('detectadsblocker::modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		<?php endif; ?>
	<?php endif; ?>
</main>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('front.layouts.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->yieldSection(); ?>

<?php echo $__env->make('front.common.js.init', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
	var countryCode = '<?php echo e(config('country.code', 0)); ?>';
	var timerNewMessagesChecking = <?php echo e((int)config('settings.other.timer_new_messages_checking', 0)); ?>;
	
	
	var isSettingsAppDarkModeEnabled = <?php echo e(isSettingsAppDarkModeEnabled() ? 'true' : 'false'); ?>;
	var isSettingsAppSystemThemeEnabled = <?php echo e(isSettingsAppSystemThemeEnabled() ? 'true' : 'false'); ?>;
	var userThemePreference = <?php echo !empty($userThemePreference) ? "'$userThemePreference'" : 'null'; ?>;
	var showIconOnly = <?php echo e($showIconOnly ? 'true' : 'false'); ?>;
	
	
	var defaultAuthField = '<?php echo e(old('auth_field', getAuthField())); ?>';
	var phoneCountry = '<?php echo e(config('country.code')); ?>';
	
	
	var fakeLocationsResults = "<?php echo e(config('settings.listings_list.fake_locations_results', 0)); ?>";
</script>

<?php echo $__env->yieldContent('before_scripts'); ?>


<?php if(view()->exists('auth.layouts.js.translations')): ?>
	<?php echo $__env->make('auth.layouts.js.translations', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<script src="<?php echo e(url(mix('dist/front/scripts.js'))); ?>"></script>


<?php if(config('settings.optimization.lazy_loading_activation') == 1): ?>
	<script src="<?php echo e(url('assets/plugins/lazysizes/lazysizes.min.js')); ?>" async=""></script>
<?php endif; ?>


<?php if(config('plugins.detectadsblocker.installed')): ?>
	<script src="<?php echo e(url('plugins/detectadsblocker/assets/js/script.js') . getPictureVersion()); ?>"></script>
<?php endif; ?>

<script>
	onDocumentReady((event) => {
		
		SocialShare.init({width: 640, height: 480});
		
		
		<?php if(isset($errors) && $errors->any()): ?>
			<?php if($errors->any() && old('quickLoginForm')=='1'): ?>
				
				openLoginModal();
			<?php endif; ?>
		<?php endif; ?>
		
		
		const modalCountryListReorder = new BsRowColumnsReorder('#modalCountryList', {defaultColumns: 4});
	});
</script>

<?php echo $__env->yieldContent('after_scripts'); ?>

<?php echo $__env->yieldPushContent('before_helpers_scripts_stack'); ?>

<?php if(!empty($helpers)): ?>
	<?php $__currentLoopData = $helpers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $helper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php echo $__env->yieldPushContent($helper . '_scripts'); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php echo $__env->yieldPushContent('after_helpers_scripts_stack'); ?>

<?php if(!empty($plugins)): ?>
	<?php $__currentLoopData = $plugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php echo $__env->yieldContent($plugin . '_scripts'); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if(config('settings.footer.tracking_code')): ?>
	<?php echo printJs(config('settings.footer.tracking_code')) . "\n"; ?>

<?php endif; ?>

    <?php echo $__env->make('front.layouts.partials.listing-type-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\resources\views/front/layouts/master.blade.php ENDPATH**/ ?>