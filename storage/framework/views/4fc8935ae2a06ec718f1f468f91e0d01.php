
<?php
	use Illuminate\Support\ViewErrorBag;
	
	$layout ??= 'default'; // default, horizontal
	$isHorizontal = $layout === 'horizontal';
	$colLabel ??= 'col-md-3';
    $colField ??= 'col-md-9';
	
	$viewName = 'select2-tagging';
	$type = 'select';
	$label ??= null;
	$id ??= null;
	$name ??= null;
	$value ??= [];
	$default ??= [];
	$placeholder ??= null;
	$required ??= false;
	$hint ??= null;
	$attributes ??= [];
	
	$options ??= [];
	$allowsMultiple ??= true;
	
	$defaultTagsLimit = (int)config('settings.listing_form.tags_limit', 15);
	$defaultTagsMinLength = (int)config('settings.listing_form.tags_min_length', 2);
	$defaultTagsMaxLength = (int)config('settings.listing_form.tags_max_length', 30);
	
	// Available themes (path => key)
	$themes = [
		'bootstrap5' => 'bootstrap-5',
		'bootstrap4' => 'bootstrap4',
		'bootstrap3' => 'bootstrap',
	];
	$dir = $pluginOptions['dir'] ?? config('lang.direction');
	$isRtlDirection = ($dir == 'rtl');
	$language = $pluginOptions['language'] ?? app()->getLocale();
	
	$pluginOptions ??= [];
	
	$tagsLimit = $pluginOptions['tagsLimit'] ?? $defaultTagsLimit;
	$tagsMinLength = $pluginOptions['tagsMinLength'] ?? $defaultTagsMinLength;
	$tagsMaxLength = $pluginOptions['tagsMaxLength'] ?? $defaultTagsMaxLength;
	$tokenSeparators = $pluginOptions['tokenSeparators'] ?? [',', ';', ':', '/', '\\', '#'];
	$invalidChars = $pluginOptions['invalidChars'] ?? [',', ';', '_', '/', '\\', '#'];
	$theme = $pluginOptions['theme'] ?? config('larapen.core.select2.theme', 'bootstrap5');
	$themeKey = $themes[$theme] ?? null;
	
	$name = $allowsMultiple ? $name . '[]' : $name;
	$multipleAttr = $allowsMultiple ? ' multiple' : '';
	
	$rootWildcardName = arrayFieldToDotNotation($name, true);
	$rootName = rtrim($rootWildcardName, '.*');
	$dotSepName = arrayFieldToDotNotation($name);
	$id = !empty($id) ? $id : str_replace('.', '-', $dotSepName);
	
	$errors ??= new ViewErrorBag;
	$errorBag = ($errors instanceof ViewErrorBag) ? $errors : new ViewErrorBag;
	$isInvalidClass = $errorBag->has($dotSepName) ? 'is-invalid' : '';
	
	$value = $value ?? ($default ?? []);
	$value = old($dotSepName, $options);
	
	$hint = str_replace('{limit}', $tagsLimit, $hint);
	$hint = str_replace('{min}', $tagsMinLength, $hint);
	$hint = str_replace('{max}', $tagsMaxLength, $hint);
	
	$attributes = \App\Helpers\Common\Html\HtmlAttr::append($attributes, 'class', 'select2-tagging');
?>
<div <?php echo $__env->make('helpers.forms.attributes.field-wrapper', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>>
	<?php echo $__env->make('helpers.forms.partials.label', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php if($isHorizontal): ?>
		<div class="<?php echo e($colField); ?>">
			<?php endif; ?>
			
			<select
					name="<?php echo e($name); ?>"
					<?php if(!empty($placeholder)): ?>data-placeholder="<?php echo e($placeholder); ?>"<?php endif; ?>
					style="width: 100%"
					<?php echo $__env->make('helpers.forms.attributes.field', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					<?php echo $multipleAttr; ?>

			>
				<?php if(!empty($value) && is_array($value)): ?>
					<?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option selected="selected"><?php echo e($label); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>
			</select>
			
			<?php echo $__env->make('helpers.forms.partials.hint', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php echo $__env->make('helpers.forms.partials.validation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			<?php if($isHorizontal): ?>
		</div>
	<?php endif; ?>
</div>
<?php echo $__env->make('helpers.forms.partials.newline', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
	$viewName = str($viewName)->replace('-', '_')->toString();
	$pluginBasePath = 'assets/plugins/select2/';
	$pluginFullPath = public_path($pluginBasePath);
?>



<?php if (! $__env->hasRenderedOnce('e7f5fceb-832d-4706-ac0c-e81f5f03ea7f')): $__env->markAsRenderedOnce('e7f5fceb-832d-4706-ac0c-e81f5f03ea7f');
$__env->startPush("select2_assets_styles"); ?>
	<link href="<?php echo e(asset($pluginBasePath . 'css/select2.min.css')); ?>" rel="stylesheet" type="text/css"/>
	<?php if($theme == 'bootstrap5'): ?>
		<link href="<?php echo e(asset('assets/plugins/select2-bootstrap5-theme/1.3.0/select2-bootstrap-5-theme.min.css')); ?>" rel="stylesheet" type="text/css"/>
		<?php if($isRtlDirection): ?>
			<link href="<?php echo e(asset('assets/plugins/select2-bootstrap5-theme/1.3.0/select2-bootstrap-5-theme.rtl.min.css')); ?>" rel="stylesheet" type="text/css"/>
		<?php endif; ?>
	<?php elseif($theme == 'bootstrap4'): ?>
		<link href="<?php echo e(asset('assets/plugins/select2-bootstrap4-theme/1.5.2/select2-bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css"/>
	<?php elseif($theme == 'bootstrap3'): ?>
		<link href="<?php echo e(asset('assets/plugins/select2-bootstrap3-theme/0.1.0-beta.10/select2-bootstrap.min.css')); ?>" rel="stylesheet" type="text/css"/>
	<?php else: ?>
		<link href="<?php echo e(asset('assets/plugins/select2/css/custom.css')); ?>" rel="stylesheet" type="text/css"/>
	<?php endif; ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('3fbbaab1-4955-4fef-9c3b-f0fafabfcbb8')): $__env->markAsRenderedOnce('3fbbaab1-4955-4fef-9c3b-f0fafabfcbb8');
$__env->startPush("select2_assets_scripts"); ?>
	<script src="<?php echo e(asset($pluginBasePath . 'js/select2.full.min.js')); ?>"></script>
	<?php
		$localeFilesBasePath = $pluginBasePath . 'js/i18n/';
		$localeFilesFullPath = public_path($localeFilesBasePath);
		
		$foundLocale = '';
		if (file_exists($localeFilesFullPath . getLangTag($language) . '.js')) {
			$foundLocale = getLangTag($language);
		}
		if (empty($foundLocale)) {
			if (file_exists($localeFilesFullPath . strtolower($language) . '.js')) {
				$foundLocale = strtolower($language);
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


<?php $__env->startPush("{$viewName}_helper_scripts"); ?>
	<script>
		onDocumentReady((event) => {
			const lang = '<?php echo e($foundLocale); ?>';
			const dir = '<?php echo e($dir); ?>';
			const theme = <?php echo !empty($themeKey) ? "'{$themeKey}'" : 'undefined'; ?>;
			const rootName = '<?php echo e($rootName); ?>';
			const fieldName = '<?php echo e($dotSepName); ?>';
			const tagsMinLength = <?php echo e($tagsMinLength); ?>;
			const tagsMaxLength = <?php echo e($tagsMaxLength); ?>;
			const tagsLimit = <?php echo e($tagsLimit); ?>;
			const tokenSeparators = <?php echo Illuminate\Support\Js::from($tokenSeparators); ?>;
			const invalidChars = <?php echo Illuminate\Support\Js::from($invalidChars); ?>;
			
			const options1 = {
				lang: lang, 
				dir: dir,
			};
			
			if (typeof langLayout !== 'undefined' && typeof langLayout.select2 !== 'undefined') {
				options1.language = langLayout.select2;
			}
			if (typeof theme !== 'undefined') {
				options1.theme = theme;
			}
			
			const tagsEl = $('.select2-tagging');
			if (tagsEl.length) {
				tagsEl.each((index, element) => {
					if (!$(element).hasClass('select2-hidden-accessible')) {
						if (typeof theme !== 'undefined') {
							if (theme === 'bootstrap-5') {
								const widthOption = $(element).hasClass('w-100') ? '100%' : 'style';
								const width = $(element).data('width');
								options1.width = width ? width : widthOption;
								options1.placeholder = $(element).data('placeholder');
							}
						}
						
						$(element).select2(options1);
						
						/* Indicate that the value of this field has changed */
						$(element).on('select2:select', (e) => {
							element.dispatchEvent(new Event('input', {bubbles: true}));
						});
					}
				});
				
				const options2 = {
					lang: lang, 
					dir: dir,
					tags: true,
					maximumSelectionLength: tagsLimit,
					tokenSeparators: tokenSeparators,
					createTag: (params) => {
						const term = $.trim(params.term);
						
						
						let arrayLength = invalidChars.length;
						for (let i = 0; i < arrayLength; i++) {
							let invalidChar = invalidChars[i];
							if (term.indexOf(invalidChar) !== -1) {
								return null;
							}
						}
						
						
						
						if (term === '') {
							return null;
						}
						
						
						if (term.length < tagsMinLength || term.length > tagsMaxLength) {
							return null;
						}
						
						return {
							id: term,
							text: term
						}
					}
				};
				
				if (typeof langLayout !== 'undefined' && typeof langLayout.select2 !== 'undefined') {
					options2.language = langLayout.select2;
				}
				if (typeof theme !== 'undefined') {
					options2.theme = theme;
				}
				
				
				const selectTagging = tagsEl.select2(options2);
				
				
				selectTagging.on('change', e => {
					const currEl = e.target;
					if ($(currEl).val().length > tagsLimit) {
						$(currEl).val($(currEl).val().slice(0, tagsLimit));
					}
				});
			}
			
			
			<?php if($errorBag->has($rootWildcardName)): ?>
				const rootNameEl = $(`select[name^="${rootName}"]`);
				if (rootNameEl.length) {
					rootNameEl.closest('div').addClass('is-invalid');
					rootNameEl.next('.select2.select2-container').addClass('is-invalid');
				}
			<?php endif; ?>
		});
	</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/fields/select2-tagging.blade.php ENDPATH**/ ?>