<?php
	$langCode ??= ($languageCode ?? null);
	$langCode = $langCode ?? config('app.locale', session('langCode'));
	$langDirection = config('lang.direction');
	$isRtl = $pluginOptions['rtl'] ?? (($langDirection == 'rtl') ? 'true' : 'false');
	
	$fields ??= [];
	$errors ??= [];
	$oldInput ??= [];
	
	$fiTheme = config('larapen.core.fileinput.theme', 'bs5');
	$fiFileLoadingMessage ??= t('loading_wd');
	$serverAllowedImageFormatsJson = collect(getServerAllowedImageFormats())->toJson();
?>
<?php if(!empty($fields)): ?>
	<?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php
			$modelFieldId = data_get($field, 'id');
			$modelFieldType = data_get($field, 'type');
			$modelDefaultValue = data_get($field, 'default_value');
			
			// Fields parameters
			$fieldId = 'cf.' . $modelFieldId;
			$fieldName = 'cf[' . $modelFieldId . ']';
			$fieldOld = 'cf.' . $modelFieldId;
			
			// Errors & Required CSS
			$requiredClass = (data_get($field, 'required') == 1) ? 'required' : '';
			$errorClass = (isset($errors[$fieldOld])) ? ' is-invalid' : '';
			
			// Get the default value
			$defaultValue = $oldInput[$modelFieldId] ?? $modelDefaultValue;
			
			// Get field other attributes
			$fieldOptions = data_get($field, 'options') ?? [];
			$fieldOptions = is_array($fieldOptions) ? $fieldOptions : [];
		?>
		
		<?php if($modelFieldType == 'checkbox'): ?>
			
			
			<?php echo $__env->make('helpers.forms.fields.checkbox', [
				'label'          => data_get($field, 'name') . '-aa',
				'id'             => $fieldId,
				'name'           => $fieldName,
				'required'       => (data_get($field, 'required') == 1),
				'value'          => $defaultValue,
				'hint'           => data_get($field, 'help'),
				'isInvalidClass' => $errorClass,
			], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
		<?php elseif($modelFieldType == 'checkbox_multiple'): ?>
			
			<?php if(!empty($fieldOptions)): ?>
				
				<?php
					$checkedBoxes = $modelDefaultValue;
					
					$checkboxes = collect($fieldOptions)
						->mapWithKeys(function($option) use (
							$fieldId, $fieldName, $checkedBoxes, $oldInput, $modelFieldId
						) {
							$optionId = $option['id'] ?? null;
							
							// Get the checkbox attributes value
							$checkboxLabel = $option['value'] ?? null;
							$checkboxId = $fieldId . '_' . $optionId;
							$checkboxName = $fieldName . '[' . $optionId . ']';
							$checkboxValue = is_array($checkedBoxes)
								? ($checkedBoxes[$optionId]['id'] ?? null)
								: $checkedBoxes;
							$checkboxValue = $oldInput[$modelFieldId][$optionId] ?? $checkboxValue;
							
							return [
								$optionId => [
									'label'   => $checkboxLabel,
									'id'      => $checkboxId,
									'name'    => $checkboxName,
									'value'   => $checkboxValue,
									'checked' => ($checkboxValue == $optionId),
								],
							];
						})->toArray();
					
					$defaultValue = collect($defaultValue)->pluck('id', 'id')->toArray();
				?>
				<?php echo $__env->make('helpers.forms.fields.checklist', [
					'label'          => data_get($field, 'name'),
					'id'             => $fieldId,
					'name'           => $fieldName,
					'required'       => (data_get($field, 'required') == 1),
					'checkboxes'     => $checkboxes,
					'col'            => 12,
					'value'          => $defaultValue,
					'hint'           => data_get($field, 'help'),
					'isInvalidClass' => $errorClass,
				], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php endif; ?>
			
		<?php elseif($modelFieldType == 'file'): ?>
			
			
			<?php
				$fileHint =  data_get($field, 'help')
					. '<br>' . t('file_types', ['file_types' => getAllowedFileFormatsHint()], 'global', $langCode);
			?>
			<?php echo $__env->make('helpers.forms.fields.fileinput', [
				'label'    => data_get($field, 'name'),
				'id'       => $fieldId,
				'name'     => $fieldName,
				'required' => (data_get($field, 'required') == 1),
				'value'    => [
					'key'  => 1,
					'path' => $modelDefaultValue,
					'url'  => privateFileUrl($modelDefaultValue, null),
				],
				'hint'           => $fileHint,
				'downloadable'   => true,
				'isInvalidClass' => $errorClass,
			], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
		<?php elseif($modelFieldType == 'radio'): ?>
			
			<?php if(!empty($fieldOptions)): ?>
				
				<?php echo $__env->make('helpers.forms.fields.radio', [
					'label'           => data_get($field, 'name'),
					'name'            => $fieldName,
					'inline'          => true,
					'required'        => (data_get($field, 'required') == 1),
					'options'         => $fieldOptions,
					'optionValueName' => 'id',
					'optionTextName'  => 'value',
					'value'           => $defaultValue,
					'hint'            => data_get($field, 'help'),
					'isInvalidClass'  => $errorClass,
				], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php endif; ?>
		
		<?php elseif($modelFieldType == 'select'): ?>
			
			
			<?php echo $__env->make('helpers.forms.fields.select2', [
				'label'           => data_get($field, 'name'),
				'id'              => $fieldId,
				'name'            => $fieldName,
				'required'        => (data_get($field, 'required') == 1),
				'placeholder'     => t('Select', [], 'global', $langCode),
				'options'         => $fieldOptions,
				'optionValueName' => 'id',
				'optionTextName'  => 'value',
				'value'           => $defaultValue,
				'hint'            => data_get($field, 'help'),
				'isInvalidClass'  => $errorClass,
			], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
		<?php elseif($modelFieldType == 'textarea'): ?>
			
			
			<?php
				$textAreaAttributes = ['rows' => 10];
				$fieldMax = (int)data_get($field, 'max');
				if (!empty($fieldMax)) {
					$textAreaAttributes['maxlength'] = $fieldMax;
				}
			?>
			<?php echo $__env->make('helpers.forms.fields.textarea', [
				'label'       => data_get($field, 'name'),
				'id'          => $fieldId,
				'name'        => $fieldName,
				'placeholder' => data_get($field, 'name'),
				'required'    => (data_get($field, 'required') == 1),
				'value'       => $defaultValue,
				'attributes'  => $textAreaAttributes,
				'hint'        => data_get($field, 'help'),
				'isInvalidClass' => $errorClass,
			], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
		<?php elseif($modelFieldType == 'url'): ?>
			
			
			<?php echo $__env->make('helpers.forms.fields.url', [
				'label'       => data_get($field, 'name'),
				'id'          => $fieldId,
				'name'        => $fieldName,
				'placeholder' => data_get($field, 'name'),
				'required'    => (data_get($field, 'required') == 1),
				'value'       => $defaultValue,
				'hint'        => data_get($field, 'help'),
				'isInvalidClass' => $errorClass,
			], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
		<?php elseif($modelFieldType == 'number'): ?>
			
			
			<?php
				$numberAttributes = [];
				$fieldMax = (int)data_get($field, 'max');
				if (!empty($fieldMax)) {
					$numberAttributes['max'] = $fieldMax;
				}
			?>
			<?php echo $__env->make('helpers.forms.fields.number', [
				'label'       => data_get($field, 'name'),
				'id'          => $fieldId,
				'name'        => $fieldName,
				'placeholder' => data_get($field, 'name'),
				'required'    => (data_get($field, 'required') == 1),
				'value'       => $defaultValue,
				'attributes'  => $numberAttributes,
				'hint'        => data_get($field, 'help'),
				'isInvalidClass' => $errorClass,
			], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
		<?php elseif($modelFieldType == 'date'): ?>
			
			
			<?php echo $__env->make('helpers.forms.fields.daterangepicker-date', [
				'label'       => data_get($field, 'name'),
				'id'          => $fieldId,
				'name'        => $fieldName,
				'placeholder' => data_get($field, 'name'),
				'required'    => (data_get($field, 'required') == 1),
				'value'       => $defaultValue,
				'hint'        => data_get($field, 'help'),
				'isInvalidClass' => $errorClass,
			], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
		<?php elseif($modelFieldType == 'date_time'): ?>
			
			
			<?php echo $__env->make('helpers.forms.fields.daterangepicker-datetime', [
				'label'       => data_get($field, 'name'),
				'id'          => $fieldId,
				'name'        => $fieldName,
				'placeholder' => data_get($field, 'name'),
				'required'    => (data_get($field, 'required') == 1),
				'value'       => $defaultValue,
				'hint'        => data_get($field, 'help'),
				'isInvalidClass' => $errorClass,
			], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
		<?php elseif($modelFieldType == 'date_range'): ?>
			
			
			<?php echo $__env->make('helpers.forms.fields.daterangepicker-daterange', [
				'label'       => data_get($field, 'name'),
				'id'          => $fieldId,
				'name'        => $fieldName,
				'placeholder' => data_get($field, 'name'),
				'required'    => (data_get($field, 'required') == 1),
				'value'       => $defaultValue,
				'hint'        => data_get($field, 'help'),
				'isInvalidClass' => $errorClass,
			], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
		<?php else: ?>
			
			
			<?php
				$textAttributes = [];
				$fieldMax = (int)data_get($field, 'max');
				if (!empty($fieldMax)) {
					$textAttributes['maxlength'] = $fieldMax;
				}
			?>
			<?php echo $__env->make('helpers.forms.fields.text', [
				'label'       => data_get($field, 'name'),
				'id'          => $fieldId,
				'name'        => $fieldName,
				'placeholder' => data_get($field, 'name'),
				'required'    => (data_get($field, 'required') == 1),
				'value'       => $defaultValue,
				'attributes'  => $textAttributes,
				'hint'        => data_get($field, 'help'),
				'isInvalidClass' => $errorClass,
			], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
		<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<script>
	
	onDocumentReady((event) => {
		const lang = '<?php echo e($langCode); ?>';
		const dir = '<?php echo e($langDirection); ?>';
		const theme = 'bootstrap-5';
		const select2Els = $('#cfContainer .select2-from-array');
		const largeSelect2Els = $('#cfContainer .select2-from-large-array');
		
		const options = {
			lang: lang, 
			dir: dir,
			width: '100%',
			dropdownAutoWidth: 'true',
			minimumResultsForSearch: Infinity, /* Hiding the search box */
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
	
	
	onDocumentReady((event) => {
		var fiOptions = {};
		fiOptions.theme = '<?php echo e($fiTheme); ?>';
		fiOptions.language = '<?php echo e($langCode); ?>';
		fiOptions.rtl = <?php echo e($isRtl); ?>;
		fiOptions.showUpload = false;
		fiOptions.showRemove = false;
		fiOptions.showCancel = true;
		fiOptions.showPreview = false;
		fiOptions.dropZoneEnabled = false;
		fiOptions.browseOnZoneClick = false;
		
		const $fileInputEl = $('#cfContainer .file');
		$fileInputEl.fileinput(fiOptions);
	});
	
	
	onDocumentReady((event) => {
		/*
		 * Custom Fields Date Picker
		 * https://www.daterangepicker.com/#options
		 */
		
		let dateEl = $('#cfContainer .be-select-date');
		dateEl.daterangepicker({
			autoUpdateInput: false,
			autoApply: true,
			showDropdowns: true,
			minYear: parseInt(moment().format('YYYY')) - 100,
			maxYear: parseInt(moment().format('YYYY')) + 20,
			locale: {
				format: '<?php echo e(t('datepicker_format')); ?>',
				applyLabel: "<?php echo e(t('datepicker_applyLabel')); ?>",
				cancelLabel: "<?php echo e(t('datepicker_cancelLabel')); ?>",
				fromLabel: "<?php echo e(t('datepicker_fromLabel')); ?>",
				toLabel: "<?php echo e(t('datepicker_toLabel')); ?>",
				customRangeLabel: "<?php echo e(t('datepicker_customRangeLabel')); ?>",
				weekLabel: "<?php echo e(t('datepicker_weekLabel')); ?>",
				daysOfWeek: [
					"<?php echo e(t('datepicker_sunday')); ?>",
					"<?php echo e(t('datepicker_monday')); ?>",
					"<?php echo e(t('datepicker_tuesday')); ?>",
					"<?php echo e(t('datepicker_wednesday')); ?>",
					"<?php echo e(t('datepicker_thursday')); ?>",
					"<?php echo e(t('datepicker_friday')); ?>",
					"<?php echo e(t('datepicker_saturday')); ?>"
				],
				monthNames: [
					"<?php echo e(t('January')); ?>",
					"<?php echo e(t('February')); ?>",
					"<?php echo e(t('March')); ?>",
					"<?php echo e(t('April')); ?>",
					"<?php echo e(t('May')); ?>",
					"<?php echo e(t('June')); ?>",
					"<?php echo e(t('July')); ?>",
					"<?php echo e(t('August')); ?>",
					"<?php echo e(t('September')); ?>",
					"<?php echo e(t('October')); ?>",
					"<?php echo e(t('November')); ?>",
					"<?php echo e(t('December')); ?>"
				],
				firstDay: 1
			},
			singleDatePicker: true,
			startDate: moment().format('<?php echo e(t('datepicker_format')); ?>')
		});
		dateEl.on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('<?php echo e(t('datepicker_format')); ?>'));
		});
		
		
		let dateTimeEl = $('#cfContainer .be-select-datetime');
		dateTimeEl.daterangepicker({
			autoUpdateInput: false,
			autoApply: true,
			showDropdowns: false,
			minYear: parseInt(moment().format('YYYY')) - 100,
			maxYear: parseInt(moment().format('YYYY')) + 20,
			locale: {
				format: '<?php echo e(t('datepicker_format_datetime')); ?>',
				applyLabel: "<?php echo e(t('datepicker_applyLabel')); ?>",
				cancelLabel: "<?php echo e(t('datepicker_cancelLabel')); ?>",
				fromLabel: "<?php echo e(t('datepicker_fromLabel')); ?>",
				toLabel: "<?php echo e(t('datepicker_toLabel')); ?>",
				customRangeLabel: "<?php echo e(t('datepicker_customRangeLabel')); ?>",
				weekLabel: "<?php echo e(t('datepicker_weekLabel')); ?>",
				daysOfWeek: [
					"<?php echo e(t('datepicker_sunday')); ?>",
					"<?php echo e(t('datepicker_monday')); ?>",
					"<?php echo e(t('datepicker_tuesday')); ?>",
					"<?php echo e(t('datepicker_wednesday')); ?>",
					"<?php echo e(t('datepicker_thursday')); ?>",
					"<?php echo e(t('datepicker_friday')); ?>",
					"<?php echo e(t('datepicker_saturday')); ?>"
				],
				monthNames: [
					"<?php echo e(t('January')); ?>",
					"<?php echo e(t('February')); ?>",
					"<?php echo e(t('March')); ?>",
					"<?php echo e(t('April')); ?>",
					"<?php echo e(t('May')); ?>",
					"<?php echo e(t('June')); ?>",
					"<?php echo e(t('July')); ?>",
					"<?php echo e(t('August')); ?>",
					"<?php echo e(t('September')); ?>",
					"<?php echo e(t('October')); ?>",
					"<?php echo e(t('November')); ?>",
					"<?php echo e(t('December')); ?>"
				],
				firstDay: 1
			},
			singleDatePicker: true,
			timePicker: true,
			timePicker24Hour: true,
			startDate: moment().format('<?php echo e(t('datepicker_format_datetime')); ?>')
		});
		dateTimeEl.on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('<?php echo e(t('datepicker_format_datetime')); ?>'));
		});
		
		
		let dateRangeEl = $('#cfContainer .be-select-daterange');
		dateRangeEl.daterangepicker({
			autoUpdateInput: false,
			autoApply: true,
			showDropdowns: false,
			minYear: parseInt(moment().format('YYYY')) - 100,
			maxYear: parseInt(moment().format('YYYY')) + 20,
			locale: {
				format: '<?php echo e(t('datepicker_format')); ?>',
				applyLabel: "<?php echo e(t('datepicker_applyLabel')); ?>",
				cancelLabel: "<?php echo e(t('datepicker_cancelLabel')); ?>",
				fromLabel: "<?php echo e(t('datepicker_fromLabel')); ?>",
				toLabel: "<?php echo e(t('datepicker_toLabel')); ?>",
				customRangeLabel: "<?php echo e(t('datepicker_customRangeLabel')); ?>",
				weekLabel: "<?php echo e(t('datepicker_weekLabel')); ?>",
				daysOfWeek: [
					"<?php echo e(t('datepicker_sunday')); ?>",
					"<?php echo e(t('datepicker_monday')); ?>",
					"<?php echo e(t('datepicker_tuesday')); ?>",
					"<?php echo e(t('datepicker_wednesday')); ?>",
					"<?php echo e(t('datepicker_thursday')); ?>",
					"<?php echo e(t('datepicker_friday')); ?>",
					"<?php echo e(t('datepicker_saturday')); ?>"
				],
				monthNames: [
					"<?php echo e(t('January')); ?>",
					"<?php echo e(t('February')); ?>",
					"<?php echo e(t('March')); ?>",
					"<?php echo e(t('April')); ?>",
					"<?php echo e(t('May')); ?>",
					"<?php echo e(t('June')); ?>",
					"<?php echo e(t('July')); ?>",
					"<?php echo e(t('August')); ?>",
					"<?php echo e(t('September')); ?>",
					"<?php echo e(t('October')); ?>",
					"<?php echo e(t('November')); ?>",
					"<?php echo e(t('December')); ?>"
				],
				firstDay: 1
			},
			startDate: moment().format('<?php echo e(t('datepicker_format')); ?>'),
			endDate: moment().add(1, 'days').format('<?php echo e(t('datepicker_format')); ?>')
		});
		dateRangeEl.on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('<?php echo e(t('datepicker_format')); ?>') + ' - ' + picker.endDate.format('<?php echo e(t('datepicker_format')); ?>'));
		});
	});
</script>
<?php /**PATH C:\xampp\htdocs\resources\views/front/post/createOrEdit/partials/fields.blade.php ENDPATH**/ ?>