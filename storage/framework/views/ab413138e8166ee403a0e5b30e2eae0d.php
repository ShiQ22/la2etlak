
<?php
	use Illuminate\Support\ViewErrorBag;
	
	$layout ??= 'default'; // default, horizontal
	$isHorizontal = $layout === 'horizontal';
	$colLabel ??= 'col-md-3';
    $colField ??= 'col-md-9';
	
	$viewName = 'select2';
	$type = 'select'; // select2
	$label ??= null;
	$id ??= null;
	$name ??= null;
	$value ??= null;
	$default ??= null;
	$placeholder ??= null;
	$required ??= false;
	$hint ??= null;
	$attributes ??= [];
	
	$options ??= [];
	$optionValueName ??= 'value';
	$optionTextName ??= 'text';
	$largeSize = 30;
	$largeOptions ??= (is_array($options) && count($options) >= $largeSize);
	$allowsMultiple ??= false;
	
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
	
	$theme = $pluginOptions['theme'] ?? config('larapen.core.select2.theme', 'bootstrap5');
	$themeKey = $themes[$theme] ?? null;
	
	$name = $allowsMultiple ? $name . '[]' : $name;
	$multipleAttr = $allowsMultiple ? ' multiple' : '';
	
	$dotSepName = arrayFieldToDotNotation($name);
	$id = !empty($id) ? $id : str_replace('.', '_', $dotSepName);
	
	$errors ??= new ViewErrorBag;
	$errorBag = ($errors instanceof ViewErrorBag) ? $errors : new ViewErrorBag;
	$isInvalidClass = $errorBag->has($dotSepName) ? 'is-invalid' : '';
	
	$value = $value ?? ($default ?? null);
	$value = old($dotSepName, $value);
	
	$select2Class = $largeOptions ? 'select2-from-large-array' : 'select2-from-array';
	$attributes = \App\Helpers\Common\Html\HtmlAttr::append($attributes, 'class', $select2Class);
?>
<div <?php echo $__env->make('helpers.forms.attributes.field-wrapper', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>>
	<?php echo $__env->make('helpers.forms.partials.label', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php if($isHorizontal): ?>
		<div class="<?php echo e($colField); ?>">
			<?php endif; ?>
			
			<select
					id="<?php echo e($id); ?>"
					name="<?php echo e($name); ?>"
					<?php if(!empty($placeholder)): ?>data-placeholder="<?php echo e($placeholder); ?>"<?php endif; ?>
					style="width: 100%"
					<?php echo $__env->make('helpers.forms.attributes.field', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					<?php echo $multipleAttr; ?>

			>
				<?php if(!empty($placeholder)): ?>
					<option value="" <?php if(empty($value)): echo 'selected'; endif; ?>>
						<?php echo e($placeholder); ?>

					</option>
				<?php endif; ?>
				<?php if(!empty($options) && is_array($options)): ?>
					<?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$optionValue = $option[$optionValueName] ?? null;
							$optionText = $option[$optionTextName] ?? null;
							$optionAttrs = $option['attributes'] ?? [];
							$optionAttrsStr = \App\Helpers\Common\Arr::toAttributes($optionAttrs);
							$optionAttrsStr = !empty($optionAttrsStr) ? ' ' . $optionAttrsStr : '';
							
							$isSelected = (
								$optionValue == $value ||
								(is_array($value) && in_array($optionValue, $value))
							);
						?>
						<option value="<?php echo e($optionValue); ?>"<?php echo $optionAttrsStr; ?> <?php if($isSelected): echo 'selected'; endif; ?>>
							<?php echo $optionText; ?>

						</option>
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



<?php if (! $__env->hasRenderedOnce('1034b96f-67df-4821-ba56-e345d9382380')): $__env->markAsRenderedOnce('1034b96f-67df-4821-ba56-e345d9382380');
$__env->startPush("{$viewName}_assets_styles"); ?>
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

<?php if (! $__env->hasRenderedOnce('241507c2-7008-41ae-9735-03c0bc69b6a0')): $__env->markAsRenderedOnce('241507c2-7008-41ae-9735-03c0bc69b6a0');
$__env->startPush("{$viewName}_assets_scripts"); ?>
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


<?php if (! $__env->hasRenderedOnce('cc761a53-9b6b-4b90-b951-3c85f0139c97')): $__env->markAsRenderedOnce('cc761a53-9b6b-4b90-b951-3c85f0139c97');
$__env->startPush("select2_basic_assets_scripts"); ?>
	<script>
		onDocumentReady((event) => {
			const lang = '<?php echo e($foundLocale); ?>';
			const dir = '<?php echo e($dir); ?>';
			const theme = <?php echo !empty($themeKey) ? "'{$themeKey}'" : 'undefined'; ?>;
			const select2Els = $('.select2-from-array');
			const largeSelect2Els = $('.select2-from-large-array');
			
			
			const options = {
				lang: lang, 
				dir: dir,
				width: '100%',
				dropdownAutoWidth: 'true',
				minimumResultsForSearch: Infinity, 
			};
			
			if (typeof langLayout !== 'undefined' && typeof langLayout.select2 !== 'undefined') {
				options.language = langLayout.select2;
			}
			if (typeof theme !== 'undefined') {
				options.theme = theme;
			}
			
			/* Non-searchable select boxes */
			if (select2Els.length) {
				select2Els.each((index, element) => {
					if (!$(element).hasClass('select2-hidden-accessible')) {
						if (typeof theme !== 'undefined') {
							if (theme === 'bootstrap-5') {
								let widthOption = $(element).hasClass('w-100') ? '100%' : 'style';
								options.width = $(element).data('width') ? $(element).data('width') : widthOption;
								options.placeholder = $(element).data('placeholder');
							}
						}
						
						$(element).select2(options);
						
						/* Indicate that the value of this field has changed */
						$(element).on('select2:select', (e) => {
							element.dispatchEvent(new Event('input', {bubbles: true}));
						});
					}
				});
			}
			
			/* Searchable select boxes */
			if (largeSelect2Els.length) {
				largeSelect2Els.each((index, element) => {
					if (!$(element).hasClass('select2-hidden-accessible')) {
						if (typeof theme !== 'undefined') {
							if (theme === 'bootstrap-5') {
								const widthOption = $(element).hasClass('w-100') ? '100%' : 'style';
								const width = $(element).data('width');
								options.width = width ? width : widthOption;
								options.placeholder = $(element).data('placeholder');
							}
						}
						
						delete options.minimumResultsForSearch;
						$(element).select2(options);
						
						/* Indicate that the value of this field has changed */
						$(element).on('select2:select', (e) => {
							element.dispatchEvent(new Event('input', {bubbles: true}));
						});
					}
				});
			}
		});
	</script>
<?php $__env->stopPush(); endif; ?>

<?php $__env->startPush("{$viewName}_helper_scripts"); ?>
	<script>
		onDocumentReady((event) => {
			
			<?php if($errorBag->has($dotSepName)): ?>
				$('select[name="<?php echo e($name); ?>"]').closest('div').addClass('is-invalid');
			<?php endif; ?>
		});
	</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/fields/select2.blade.php ENDPATH**/ ?>