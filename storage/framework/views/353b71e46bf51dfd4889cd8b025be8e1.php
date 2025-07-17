


<?php
	use App\Helpers\Services\Referrer;
	use Illuminate\Support\ViewErrorBag;
	
	$layout ??= 'default'; // default, horizontal
	$isHorizontal = $layout === 'horizontal';
	$colLabel ??= 'col-md-3';
    $colField ??= 'col-md-9';
	
	$viewName = 'intl-tel-input';
	$type = 'tel'; // intl_tel_input
	$label ??= null;
	$id ??= null;
	$name ??= null;
	$value ??= null;
	$default ??= null;
	$placeholder ??= null;
	$suffix ??= null;
	$required ??= false;
	$hint ??= null;
	$attributes ??= [];
	
	$independentJs ??= false;
	$pluginOptions ??= [];
	
	$phoneHiddenInput = 'phone_intl';
	$countryHiddenInput = 'phone_country';
	
	$i18n = $pluginOptions['i18n'] ?? Referrer::getItiParameterData('i18n');
	$countrySearch = $pluginOptions['countrySearch'] ?? 'true';
	$hiddenInput = $pluginOptions['hiddenInput'] ?? ['phone' => $phoneHiddenInput, 'country' => $countryHiddenInput];
	$defaultInitialCountry = 'us';
	$initialCountry = $pluginOptions['countryCode'] ?? config('country.code');
	$initialCountry = !empty($initialCountry) ? $initialCountry : $defaultInitialCountry;
	$onlyCountries = $pluginOptions['onlyCountries'] ?? Referrer::getItiParameterData('onlyCountries');
	$countryOrder = $pluginOptions['countryOrder'] ?? [];
	$separateDialCode = $pluginOptions['separateDialCode'] ?? 'true';
	
	$phoneHiddenInput = $hiddenInput['phone'] ?? $phoneHiddenInput;
	$countryHiddenInput = $hiddenInput['country'] ?? $countryHiddenInput;
	
	$dotSepName = arrayFieldToDotNotation($name);
	$id = !empty($id) ? $id : str_replace('.', '-', $dotSepName);
	$id = $independentJs ? 'iti_' . $id : $id;
	$dotSepCountryHiddenInput = arrayFieldToDotNotation($countryHiddenInput);
	
	$value = $value ?? ($default ?? null);
	$initialCountry = old($dotSepCountryHiddenInput, $initialCountry);
	$value = old($dotSepName, $value);
	$value = phoneE164($value, $initialCountry);
	
	$hasInputGroup = (!empty($prefix) || !empty($suffix));
	
	// Handle error class for "input-group"
	$errors ??= new ViewErrorBag;
	$errorBag = ($errors instanceof ViewErrorBag) ? $errors : new ViewErrorBag;
	$isInvalidClass = $errorBag->has($dotSepName) ? 'is-invalid' : '';
	
	$itiClass = !$independentJs ? 'iti-phone-number' : '';
	$attributes = \App\Helpers\Common\Html\HtmlAttr::append($attributes, 'class', $itiClass);
?>
<div <?php echo $__env->make('helpers.forms.attributes.field-wrapper', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>>
	<?php echo $__env->make('helpers.forms.partials.label', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php if($isHorizontal): ?>
		<div class="<?php echo e($colField); ?>">
			<?php endif; ?>
			
			<?php if(!empty($suffix)): ?>
				<div class="input-group <?php echo e($isInvalidClass); ?>">
					<?php endif; ?>
					<input
							type="tel"
							id="<?php echo e($id); ?>"
							name="<?php echo e($name); ?>"
							value="<?php echo e($value); ?>"
							autocomplete="off"
							<?php echo $__env->make('helpers.forms.attributes.field', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					>
					<?php if(!empty($suffix)): ?>
						<span class="input-group-text iti-group-text"><?php echo $suffix; ?></span>
					<?php endif; ?>
					<?php if(!empty($suffix)): ?>
				</div>
			<?php endif; ?>
			
			<input name="<?php echo e($countryHiddenInput); ?>" type="hidden" value="<?php echo e($initialCountry); ?>">
			
			<?php echo $__env->make('helpers.forms.partials.hint', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php echo $__env->make('helpers.forms.partials.validation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			<?php if($isHorizontal): ?>
		</div>
	<?php endif; ?>
</div>
<?php echo $__env->make('helpers.forms.partials.newline', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
	$viewName = str($viewName)->replace('-', '_')->toString();
?>



<?php if (! $__env->hasRenderedOnce('1f3789ad-96b4-420f-b698-5dd5f85fdad8')): $__env->markAsRenderedOnce('1f3789ad-96b4-420f-b698-5dd5f85fdad8');
$__env->startPush("{$viewName}_assets_styles"); ?>
	<link href="<?php echo e(asset('assets/plugins/intl-tel-input/25.3.1/css/intlTelInput.css')); ?>" rel="stylesheet" type="text/css"/>
	<link href="<?php echo e(asset('assets/plugins/intl-tel-input/25.3.1/css/custom.css')); ?>" rel="stylesheet" type="text/css"/>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('176a1b31-478a-49aa-9f94-7d2167a04e73')): $__env->markAsRenderedOnce('176a1b31-478a-49aa-9f94-7d2167a04e73');
$__env->startPush("{$viewName}_assets_scripts"); ?>
	<script src="<?php echo e(asset('assets/plugins/intl-tel-input/25.3.1/js/intlTelInput.js')); ?>"></script>
	<script src="<?php echo e(asset('assets/plugins/intl-tel-input/25.3.1/js/custom.js')); ?>" defer></script>
<?php $__env->stopPush(); endif; ?>


<?php if($independentJs): ?>
	<?php $__env->startPush("{$viewName}_helper_scripts"); ?>
		<script>
			onDocumentReady((event) => {
				const itiElSelector = '<?php echo e($id); ?>';
				const itiEl = document.getElementById(itiElSelector);
				
				if (itiEl) {
					// 'intl-tel-input' options
					const options = {
						i18n: <?php echo json_encode($i18n); ?>,
						countrySearch: <?php echo e($countrySearch); ?>,
						hiddenInput: (telInputName) => ({
							phone: '<?php echo e($phoneHiddenInput); ?>',
							country: '<?php echo e($countryHiddenInput); ?>'
						}),
						initialCountry: '<?php echo e($initialCountry); ?>',
						onlyCountries: <?php echo json_encode($onlyCountries); ?>,
						countryOrder: [],
						separateDialCode: <?php echo e($separateDialCode); ?>,
					};
					
					// Initialization
					const iti = applyIntlTelInput(itiEl, options);
				}
			});
		</script>
	<?php $__env->stopPush(); ?>
<?php else: ?>
	<?php if (! $__env->hasRenderedOnce('0c70b306-3af2-424c-bd17-9b244cbe392d')): $__env->markAsRenderedOnce('0c70b306-3af2-424c-bd17-9b244cbe392d');
$__env->startPush("shared_iti_assets_scripts"); ?>
		<script>
			onDocumentReady((event) => {
				const itiElsSelector = 'input.iti-phone-number:not([type=hidden])';
				const itiEls = document.querySelectorAll(itiElsSelector);
				
				if (itiEls.length) {
					// The 'intl-tel-input' options
					const options = {
						i18n: <?php echo json_encode($i18n); ?>,
						countrySearch: <?php echo e($countrySearch); ?>,
						hiddenInput: (telInputName) => ({
							phone: '<?php echo e($phoneHiddenInput); ?>',
							country: '<?php echo e($countryHiddenInput); ?>'
						}),
						initialCountry: '<?php echo e($initialCountry); ?>',
						onlyCountries: <?php echo json_encode($onlyCountries); ?>,
						countryOrder: [],
						separateDialCode: <?php echo e($separateDialCode); ?>,
					};
					
					// Initialization (Multiple)
					let iti;
					itiEls.forEach((element) => {
						iti = applyIntlTelInput(element, options);
					});
				}
			});
		</script>
	<?php $__env->stopPush(); endif; ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/fields/intl-tel-input.blade.php ENDPATH**/ ?>