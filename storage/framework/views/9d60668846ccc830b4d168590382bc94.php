<?php
	$postInput ??= [];
	$post ??= [];
	$admin ??= [];
	
	$isSingleStepCreateForm = (isSingleStepFormEnabled() && request()->segment(1) == 'create');
	$isSingleStepEditForm = (isSingleStepFormEnabled() && request()->segment(1) == 'edit');
	
	$langCode ??= null;
	$langCode = $langCode ?? config('app.locale', session('langCode'));
	$langDirection = config('lang.direction');
	$isRtl = $pluginOptions['rtl'] ?? (($langDirection == 'rtl') ? 'true' : 'false');
	
	$picturesLimit ??= 0;
	$picturesLimit = is_numeric($picturesLimit) ? $picturesLimit : 0;
	$picturesLimit = ($picturesLimit > 0) ? $picturesLimit : 1;
	
	$pictures = [];
	if ($isSingleStepEditForm) {
		$pictures = data_get($post, 'pictures', []);
		$pictures = collect($pictures)->slice(0, (int)$picturesLimit)->all();
	}
	
	$postId = data_get($post, 'id') ?? '';
	$postTypeId = data_get($post, 'post_type_id') ?? data_get($postInput, 'post_type_id', 0);
	$countryCode = data_get($post, 'country_code') ?? data_get($postInput, 'country_code', config('country.code', 0));
	
	$adminType = config('country.admin_type', 0);
	
	$selectedAdminCode = data_get($postInput, 'admin_code', 0);
	$selectedAdminCode = data_get($admin, 'code', $selectedAdminCode);
	
	$cityId = data_get($postInput, 'city_id');
	$cityId = data_get($post, 'city_id', $cityId);
	
	$s2Themes = [
		'bootstrap5' => 'bootstrap-5',
		'bootstrap4' => 'bootstrap4',
		'bootstrap3' => 'bootstrap',
	];
	$s2Theme = config('larapen.core.select2.theme', 'bootstrap5');
	$s2ThemeKey = $s2Themes[$s2Theme] ?? null;
	
	$fiTheme = config('larapen.core.fileinput.theme', 'bs5');
	$fiFileLoadingMessage ??= t('loading_wd');
	$serverAllowedImageFormatsJson = collect(getServerAllowedImageFormats())->toJson();
	
	$errors ??= getEmptyViewErrors();
	$errors = ($errors instanceof \Illuminate\Support\Collection) ? $errors : collect($errors->toArray());
	$errorsJson = addslashes($errors->toJson());
	
	$cfOldInput = data_get($postInput, 'cf');
	$cfOldInput = session()->getOldInput('cf', $cfOldInput);
	$cfOldInputJson = addslashes(collect($cfOldInput)->toJson());
?>
<?php $__env->startSection('modal_location'); ?>
	<?php echo $__env->make('front.layouts.partials.modal.location', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>


<?php if (! $__env->hasRenderedOnce('ab42f7c2-c09c-43d2-aa4b-1044257d2c77')): $__env->markAsRenderedOnce('ab42f7c2-c09c-43d2-aa4b-1044257d2c77');
$__env->startPush("select2_assets_styles"); ?>
	<link href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css"/>
	<?php if($s2Theme == 'bootstrap5'): ?>
		<link href="<?php echo e(asset('assets/plugins/select2-bootstrap5-theme/1.3.0/select2-bootstrap-5-theme.min.css')); ?>" rel="stylesheet" type="text/css"/>
		<?php if($isRtl == 'true'): ?>
			<link href="<?php echo e(asset('assets/plugins/select2-bootstrap5-theme/1.3.0/select2-bootstrap-5-theme.rtl.min.css')); ?>" rel="stylesheet" type="text/css"/>
		<?php endif; ?>
	<?php elseif($s2Theme == 'bootstrap4'): ?>
		<link href="<?php echo e(asset('assets/plugins/select2-bootstrap4-theme/1.5.2/select2-bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css"/>
	<?php elseif($s2Theme == 'bootstrap3'): ?>
		<link href="<?php echo e(asset('assets/plugins/select2-bootstrap3-theme/0.1.0-beta.10/select2-bootstrap.min.css')); ?>" rel="stylesheet" type="text/css"/>
	<?php else: ?>
		<link href="<?php echo e(asset('assets/plugins/select2/css/custom.css')); ?>" rel="stylesheet" type="text/css"/>
	<?php endif; ?>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('eba52c66-1fa5-40ee-8af2-313b35b7d6f9')): $__env->markAsRenderedOnce('eba52c66-1fa5-40ee-8af2-313b35b7d6f9');
$__env->startPush("select2_assets_scripts"); ?>
	<script src="<?php echo e(asset('assets/plugins/select2/js/select2.full.min.js')); ?>"></script>
	<?php
		$localeFilesBasePath = 'assets/plugins/select2/js/i18n/';
		$localeFilesFullPath = public_path($localeFilesBasePath);
		
		$foundLocale = '';
		if (file_exists($localeFilesFullPath . getLangTag($langCode) . '.js')) {
			$foundLocale = getLangTag($langCode);
		}
		if (empty($foundLocale)) {
			if (file_exists($localeFilesFullPath . strtolower($langCode) . '.js')) {
				$foundLocale = strtolower($langCode);
			}
		}
		if (empty($foundLocale)) {
			$foundLocale = 'en';
		}
	?>
	<?php if($foundLocale != 'en'): ?>
		<script src="<?php echo e(asset($localeFilesBasePath . $foundLocale . '.js')); ?>"></script>
	<?php endif; ?>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('f548a47f-fa94-4386-9345-b6103587d3ed')): $__env->markAsRenderedOnce('f548a47f-fa94-4386-9345-b6103587d3ed');
$__env->startPush("fileinput_assets_styles"); ?>
	<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css')); ?>" rel="stylesheet">
	<?php if($isRtl == 'true'): ?>
		<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css')); ?>" rel="stylesheet">
	<?php endif; ?>
	<?php if(str_starts_with($fiTheme, 'explorer')): ?>
		<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/' . $fiTheme . '/theme.min.css')); ?>" rel="stylesheet">
	<?php endif; ?>
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
		.file-loading:before {
			content: " <?php echo e($fiFileLoadingMessage); ?>";
		}
	</style>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('f0d8bd79-600e-43d6-b2b9-8d86efdd16c9')): $__env->markAsRenderedOnce('f0d8bd79-600e-43d6-b2b9-8d86efdd16c9');
$__env->startPush("fileinput_assets_scripts"); ?>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js')); ?>" type="text/javascript"></script>
	<?php if(file_exists(public_path('assets/plugins/bootstrap-fileinput/themes/' . $fiTheme . '/theme.js'))): ?>
		<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/' . $fiTheme . '/theme.js')); ?>" type="text/javascript"></script>
	<?php endif; ?>
	<script src="<?php echo e(url('common/js/fileinput/locales/' . $langCode . '.js')); ?>" type="text/javascript"></script>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('66eecd1c-0f85-49dc-aa74-fc44e1ad5a04')): $__env->markAsRenderedOnce('66eecd1c-0f85-49dc-aa74-fc44e1ad5a04');
$__env->startPush("momentjs_assets_scripts"); ?>
	<script src="<?php echo e(url('assets/plugins/momentjs/2.30.1/moment.min.js')); ?>" type="text/javascript"></script>
	<?php
		$localeFilesBasePath = 'assets/plugins/momentjs/2.30.1/locale/';
		$localeFilesFullPath = public_path($localeFilesBasePath);
		
		$foundLocale = '';
		if (file_exists($localeFilesFullPath . getLangTag($langCode) . '.js')) {
			$foundLocale = getLangTag($langCode);
		}
		if (empty($foundLocale)) {
			if (file_exists($localeFilesFullPath . strtolower($langCode) . '.js')) {
				$foundLocale = strtolower($langCode);
			}
		}
		if (empty($foundLocale)) {
			$foundLocale = 'en';
		}
	?>
	<?php if($foundLocale != 'en'): ?>
		<script charset="UTF-8" src="<?php echo e(asset($localeFilesBasePath . $foundLocale . '.min.js')); ?>"></script>
	<?php endif; ?>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('bab02aca-bd1a-4bb8-b1f6-bd8eecd833f9')): $__env->markAsRenderedOnce('bab02aca-bd1a-4bb8-b1f6-bd8eecd833f9');
$__env->startPush("daterangepicker_date_assets_styles"); ?>
	<link href="<?php echo e(url('assets/plugins/daterangepicker/3.1/daterangepicker.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('2beec102-e471-4815-84fb-a42ecd4f0945')): $__env->markAsRenderedOnce('2beec102-e471-4815-84fb-a42ecd4f0945');
$__env->startPush("daterangepicker_date_assets_scripts"); ?>
	<script src="<?php echo e(url('assets/plugins/daterangepicker/3.1/daterangepicker.js')); ?>" type="text/javascript"></script>
<?php $__env->stopPush(); endif; ?>

<?php $__env->startPush('before_helpers_scripts_stack'); ?>
	<?php echo $__env->make('front.common.js.payment-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<script>
		/* Translation */
		var lang = {
			'select': {
				'country': "<?php echo e(t('select_a_country')); ?>",
				'admin': "<?php echo e(t('select_a_location')); ?>",
				'city': "<?php echo e(t('select_a_city')); ?>"
			},
			'price': "<?php echo e(t('price')); ?>",
			'salary': "<?php echo e(t('Salary')); ?>",
			'nextStepBtnLabel': {
				'next': "<?php echo e(t('Next')); ?>",
				'submit': "<?php echo e(t('Update')); ?>"
			}
		};
		
		var stepParam = 0;
		
		/* Category */
		var categoryWasSelected = false;
		<?php if($errors->isNotEmpty() || !empty($postId)): ?>
			categoryWasSelected = true;
		<?php endif; ?>
		/* Custom Fields */
		var errors = '<?php echo $errorsJson; ?>';
		var oldInput = '<?php echo $cfOldInputJson; ?>';
		var postId = '<?php echo e($postId); ?>';
		
		/* Permanent Posts */
		var permanentPostsEnabled = '<?php echo e(config('settings.listing_form.permanent_listings_enabled', 0)); ?>';
		var postTypeId = '<?php echo e(old('post_type_id', $postTypeId)); ?>';
		
		/* Locations */
		var countryCode = '<?php echo e(old('country_code', $countryCode)); ?>';
		var adminType = '<?php echo e($adminType); ?>';
		var selectedAdminCode = '<?php echo e(old('admin_code', $selectedAdminCode)); ?>';
		var cityId = '<?php echo e(old('city_id', $cityId)); ?>';
		
		/* Packages */
		var packageIsEnabled = false;
		<?php if(isset($packages, $paymentMethods) && $packages->count() > 0 && $paymentMethods->count() > 0): ?>
			packageIsEnabled = true;
		<?php endif; ?>
	</script>
	
	<script src="<?php echo e(url('assets/js/app/d.modal.category.js') . vTime()); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('after_helpers_scripts_stack'); ?>
	<script>
		var select2Lang = '<?php echo e($foundLocale); ?>';
		var select2Dir = '<?php echo e($langDirection); ?>';
		var select2Theme = <?php echo !empty($s2ThemeKey) ? "'{$s2ThemeKey}'" : 'undefined'; ?>;
	</script>
	<?php if(config('settings.listing_form.city_selection') == 'select'): ?>
		<script src="<?php echo e(url('assets/js/app/d.select.location.js') . vTime()); ?>"></script>
	<?php else: ?>
		<script src="<?php echo e(url('assets/js/app/browse.locations.js') . vTime()); ?>"></script>
		<script src="<?php echo e(url('assets/js/app/d.modal.location.js') . vTime()); ?>"></script>
	<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/post/createOrEdit/partials/form-assets.blade.php ENDPATH**/ ?>