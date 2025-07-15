<?php
	$customFields ??= [];
	$prefixId ??= '';
?>
<?php if(!empty($customFields)): ?>
	<div>
	<form action="<?php echo e(request()->url()); ?>" method="GET" class="cf-form" role="form">
		<div class="container p-0 vstack gap-3">
			<?php
				$disabledFieldsTypes = ['file', 'video'];
				$clearFilterBtn = '';
				$firstFieldFound = false;
			?>
			<?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(in_array(data_get($field, 'type'), $disabledFieldsTypes) || data_get($field, 'use_as_filter') != 1) continue; ?>
				<?php
					// Fields parameters
					$fieldId = $prefixId . 'cf.' . data_get($field, 'id');
					$fieldName = 'cf[' . data_get($field, 'id') . ']';
					$fieldOld = 'cf.' . data_get($field, 'id');
					
					// Get the default value
					$defaultValue = request()->filled($fieldOld)
						? request()->input($fieldOld)
						: data_get($field, 'default_value');
					
					// Field Query String
					$fieldQueryStringId = 'cf' . data_get($field, 'id') . 'QueryString';
					$fieldQueryStringName = str_replace('.', '', $fieldQueryStringId);
					$fieldQueryStringValue = \App\Helpers\Common\Arr::query(request()->except(['page', $fieldId]));
					$fieldQueryString = '<input type="hidden" '
						. 'id="' . $prefixId . $fieldQueryStringId . '" '
						. 'name="' . $fieldQueryStringName . '" '
						. 'value="' . $fieldQueryStringValue . '"'
						. '>';
					
					// Clear Filter Button
					$clearFilterBtn = urlGen()->getCustomFieldFilterClearLink($fieldOld, $cat ?? null, $city ?? null);
				?>
				
				<?php if(in_array(data_get($field, 'type'), ['text', 'textarea', 'url', 'number'])): ?>
					
					
					<div class="container p-0 vstack gap-2">
						<h5 class="border-bottom pb-2 d-flex justify-content-between">
							<span class="fw-bold"><?php echo e(data_get($field, 'name')); ?></span> <?php echo $clearFilterBtn; ?>

						</h5>
						<div class="row px-0 gx-1 gy-1">
							<?php if(data_get($field, 'type') == 'number'): ?>
								<?php echo $__env->make('helpers.forms.fields.number', [
									'id'          => $fieldId,
									'name'        => $fieldName,
									'placeholder' => data_get($field, 'name'),
									'required'    => true,
									'value'       => strip_tags($defaultValue),
									'attributes'  => ['autocomplete' => 'off'],
									'baseClass'   => ['wrapper' => 'col-lg-9 col-md-12 col-sm-12'],
								], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							<?php else: ?>
								<?php echo $__env->make('helpers.forms.fields.text', [
									'id'          => $fieldId,
									'name'        => $fieldName,
									'placeholder' => data_get($field, 'name'),
									'required'    => true,
									'value'       => strip_tags($defaultValue),
									'baseClass'   => ['wrapper' => 'col-lg-9 col-md-12 col-sm-12'],
								], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							<?php endif; ?>
							<div class="col-lg-3 col-md-12 col-sm-12 d-grid">
								<button class="btn btn-secondary" type="submit"><?php echo e(t('go')); ?></button>
							</div>
						</div>
						<?php echo $fieldQueryString; ?>

					</div>
				
				<?php endif; ?>
				<?php if(data_get($field, 'type') == 'checkbox'): ?>
					
					
					<div class="container p-0 vstack gap-2">
						<h5 class="border-bottom pb-2 d-flex justify-content-between">
							<span class="fw-bold"><?php echo e(data_get($field, 'name')); ?></span> <?php echo $clearFilterBtn; ?>

						</h5>
						<div>
							<?php echo $__env->make('helpers.forms.fields.checkbox', [
								'label'     => data_get($field, 'name'),
								'id'        => $fieldId,
								'name'      => $fieldName,
								'switch'    => true,
								'value'     => $defaultValue,
								'baseClass' => ['wrapper' => 'col-md-12'],
							], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
						</div>
						<?php echo $fieldQueryString; ?>

					</div>
				
				<?php endif; ?>
				<?php if(data_get($field, 'type') == 'checkbox_multiple'): ?>
					<?php
						$checklistOptions = data_get($field, 'options');
					?>
					<?php if(!empty($checklistOptions) && is_array($checklistOptions)): ?>
						
						<div class="container p-0 vstack gap-2">
							<h5 class="border-bottom pb-2 d-flex justify-content-between">
								<span class="fw-bold"><?php echo e(data_get($field, 'name')); ?></span> <?php echo $clearFilterBtn; ?>

							</h5>
							<?php
								$modelFieldId = data_get($field, 'id');
								$modelDefaultValue = data_get($field, 'default_value');
								
								$checkedBoxes = request()->input($fieldOld, []);
								$oldInput = request()->all();
								
								$checkboxes = collect($checklistOptions)
									->mapWithKeys(function($option) use (
										$fieldId, $fieldName, $checkedBoxes, $oldInput, $modelFieldId
									) {
										$optionId = $option['id'] ?? null;
										
										// Get the checkbox attributes value
										$checkboxLabel = $option['value'] ?? null;
										$checkboxId = $fieldId . '.' . $optionId;
										$checkboxName = $fieldName . '[' . $optionId . ']';
										$checkboxValue = is_array($checkedBoxes)
											? ($checkedBoxes[$optionId] ?? null)
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
								
								$cmFieldStyle = (is_array($checklistOptions) && count($checklistOptions) > 12)
									? ' style="height: 250px; overflow-y: scroll;"'
									: '';
							?>
							<div<?php echo $cmFieldStyle; ?>>
								<?php echo $__env->make('helpers.forms.fields.checklist', [
									'switch'     => true,
									'id'         => $fieldId,
									'name'       => $fieldName,
									'checkboxes' => $checkboxes,
									'col'        => 12,
									'value'      => $defaultValue,
									'baseClass'  => ['wrapper' => 'col-md-12'],
								], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
								<?php $__currentLoopData = $checkboxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionId => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										// Field Query String
										$fieldQueryStringId = 'cf' . $modelFieldId . $optionId . 'QueryString';
										$fieldQueryStringName = str_replace('.', '', $fieldQueryStringId);
										$fieldQueryStringValue = \App\Helpers\Common\Arr::query(request()->except(['page', $fieldId . '.' . $optionId]));
									?>
									<input type="hidden"
									       id="<?php echo e($prefixId . $fieldQueryStringId); ?>"
									       name="<?php echo e($fieldQueryStringName); ?>"
									       value="<?php echo e($fieldQueryStringValue); ?>"
									>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
					<?php endif; ?>
				
				<?php endif; ?>
				<?php if(data_get($field, 'type') == 'radio'): ?>
					
					<?php if(!empty(data_get($field, 'options'))): ?>
						
						<div class="container p-0 vstack gap-2">
							<h5 class="border-bottom pb-2 d-flex justify-content-between">
								<span class="fw-bold"><?php echo e(data_get($field, 'name')); ?></span> <?php echo $clearFilterBtn; ?>

							</h5>
							<?php
								$radioOptions = data_get($field, 'options');
								$rFieldStyle = (is_array($radioOptions) && count($radioOptions) > 12)
									? ' style="height: 250px; overflow-y: scroll;"'
									: '';
							?>
							<div<?php echo $rFieldStyle; ?>>
								<?php echo $__env->make('helpers.forms.fields.radio', [
									'id'              => $fieldId . '-',
									'protectedId'     => true,
									'name'            => $fieldName,
									'options'         => $radioOptions,
									'optionValueName' => 'id',
									'optionTextName'  => 'value',
									'value'           => $defaultValue,
									'baseClass'       => ['wrapper' => 'col-md-12'],
								], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							</div>
							<?php echo $fieldQueryString; ?>

						</div>
					<?php endif; ?>
					
				<?php endif; ?>
				<?php if(data_get($field, 'type') == 'select'): ?>
				
					
					<div class="container p-0 vstack gap-2">
						<h5 class="border-bottom pb-2 d-flex justify-content-between">
							<span class="fw-bold"><?php echo e(data_get($field, 'name')); ?></span> <?php echo $clearFilterBtn; ?>

						</h5>
						<div>
							<?php echo $__env->make('helpers.forms.fields.select2', [
								'id'              => $fieldId,
								'name'            => $fieldName,
								'options'         => data_get($field, 'options'),
								'optionValueName' => 'id',
								'optionTextName'  => 'value',
								'placeholder'     => t('Select'),
								'value'           => $defaultValue,
							], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
						</div>
						<?php echo $fieldQueryString; ?>

					</div>
				
				<?php endif; ?>
				<?php if(in_array(data_get($field, 'type'), ['date', 'date_time', 'date_range'])): ?>
					<?php
						$fieldType = data_get($field, 'type', 'date');
						$fieldTypeMap = [
							'date'       => 'daterangepicker-date',
							'date_time'  => 'daterangepicker-datetime',
							'date_range' => 'daterangepicker-daterange',
						];
						$dateFieldComponent = $fieldTypeMap[$fieldType] ?? 'daterangepicker-date';
					?>
					<?php if(view()->exists("helpers.forms.fields.{$dateFieldComponent}")): ?>
						
						<div class="container p-0 vstack gap-2">
							<h5 class="border-bottom pb-2 d-flex justify-content-between">
								<span class="fw-bold"><?php echo e(data_get($field, 'name')); ?></span> <?php echo $clearFilterBtn; ?>

							</h5>
							<div class="row px-1 gx-1 gy-1">
								<?php echo $__env->make("helpers.forms.fields.{$dateFieldComponent}", [
									'id'            => $fieldId,
									'name'          => $fieldName,
									'placeholder'   => data_get($field, 'name'),
									'value'         => strip_tags($defaultValue),
									// 'referenceDate' => date('Y-m-d'),
									'attributes'    => ['autocomplete' => 'off'],
									'baseClass'     => ['wrapper' => 'col-lg-9 col-md-12 col-sm-12'],
								], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
								<div class="col-lg-3 col-md-12 col-sm-12 d-grid">
									<button class="btn btn-secondary" type="submit"><?php echo e(t('go')); ?></button>
								</div>
							</div>
							<?php echo $fieldQueryString; ?>

						</div>
					<?php endif; ?>
				
				<?php endif; ?>
				
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</form>
	</div>
<?php endif; ?>

<?php $__env->startSection('after_styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		onDocumentReady((event) => {
			const prefixId = '<?php echo e($prefixId); ?>';
			const cfFormEl = $('#leftSidebar form.cf-form, #mobileSidebar form.cf-form');
			
			/* Select */
			cfFormEl.find('select').change(function() {
				/* Get full field's ID */
				let fullFieldId = $(this).attr('id');
				
				/* Get full field's ID without dots */
				let jsFullFieldId = fullFieldId.split('.').join('');
				
				/* Get real field's ID (i.e. Without the custom field prefix (cf.)) */
				let fieldId;
				const tmp = fullFieldId.split('.');
				if (typeof tmp[1] !== 'undefined') {
					fieldId = tmp[1];
				} else {
					return false;
				}
				
				/* Get saved QueryString */
				const fieldQueryStringSelector = `#${prefixId}${jsFullFieldId}QueryString`;
				let fieldQueryString = $(fieldQueryStringSelector).val();
				
				if (typeof fieldQueryString === 'undefined') {
					fieldQueryString = '';
				}
				
				/* Add the field's value to the QueryString */
				if (fieldQueryString !== '') {
					fieldQueryString = `${fieldQueryString}&`;
				}
				fieldQueryString = `${fieldQueryString}cf[${fieldId}]=` + $(this).val();
				
				/* Redirect to the new search URL */
				const searchUrl = `${baseUrl}?${fieldQueryString}`;
				redirect(searchUrl);
			});
			
			/* Radio & Checkbox */
			cfFormEl.find('input[type=radio], input[type=checkbox]').click(function() {
				/* Get full field's ID */
				let fullFieldId = $(this).attr('id');
				
				/* Get the field's ID without the option's value|ID (that is after the dash (-)) */
				fullFieldId = fullFieldId.split('-')[0];
				
				/* Get full field's ID without dots */
				let jsFullFieldId = fullFieldId.split('.').join('');
				
				/* Get real field's ID (i.e. Without the custom field prefix (cf.)) */
				let fieldId;
				let fieldOptionId;
				const tmp = fullFieldId.split('.');
				if (typeof tmp[1] !== 'undefined') {
					fieldId = tmp[1];
					if (typeof tmp[2] !== 'undefined') {
						fieldOptionId = tmp[2];
					}
				} else {
					return false;
				}
				
				/* Get saved QueryString */
				const fieldQueryStringSelector = `#${prefixId}${jsFullFieldId}QueryString`;
				let fieldQueryString = $(fieldQueryStringSelector).val();
				
				if (typeof fieldQueryString === 'undefined') {
					fieldQueryString = '';
				}
				
				/* Check if field is checked */
				if (
					$(this).prop('checked') === true
					|| $(this).prop('checked') === 1
					|| $(this).prop('checked') === '1'
				) {
					/* Add the field's value to the QueryString */
					if (fieldQueryString !== '') {
						fieldQueryString = fieldQueryString + '&';
					}
					if (typeof fieldOptionId !== 'undefined') {
						fieldQueryString = `${fieldQueryString}cf[${fieldId}][${fieldOptionId}]=` + rawurlencode($(this).val());
					} else {
						fieldQueryString = `${fieldQueryString}cf[${fieldId}]=` + $(this).val();
					}
				}
				
				/* Redirect to the new search URL */
				const searchUrl = `${baseUrl}?${fieldQueryString}`;
				redirect(searchUrl);
			});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/sidebar/fields.blade.php ENDPATH**/ ?>