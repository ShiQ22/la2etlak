
<?php
	$field ??= [];
	
	$field['allows_multiple'] ??= false;
	
	$name = $field['name'];
	$name = $field['allows_multiple'] ? $name . '[]' : $name;
	
	$field['options'] ??= [];
	$field['rules'] ??= [];
	
	$varName = str_replace('[]', '', $name);
	$varName = str_replace('][', '.', $varName);
	$varName = str_replace('[', '.', $varName);
	$varName = str_replace(']', '', $varName);
	
	$fieldRules = $field['rules'][$varName] ?? [];
	$fieldRules = is_string($fieldRules) ? explode('|', $fieldRules) : $fieldRules;
	$fieldRules = is_array($fieldRules) ? $fieldRules : [];
	
	$required = in_array('required', $fieldRules) ? true : '';
	
	$multipleAttr = $field['allows_multiple'] ? ' multiple' : '';
	
	$tags = old('tags', $field['options'] ?? []);
?>
<div <?php echo $__env->make('admin.panel.inc.field_wrapper_attributes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> >
    <label class="form-label fw-bolder">
	    <?php echo $field['label']; ?>

	    <?php if(isset($field['required']) && $field['required']): ?>
		    <span class="text-danger">*</span>
	    <?php endif; ?>
    </label>
    <?php echo $__env->make('admin.panel.fields.inc.translatable_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<select name="<?php echo e($name); ?>" style="width: 100%"
			<?php echo $__env->make('admin.panel.inc.field_attributes', ['default_class' =>  'form-select select2_tagging_from_array'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php echo $multipleAttr; ?>

	>
		<?php if(!empty($tags)): ?>
			<?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option selected="selected"><?php echo e($value); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
    </select>
    
    
    <?php if(isset($field['hint'])): ?>
        <div class="form-text"><?php echo $field['hint']; ?></div>
    <?php endif; ?>
</div>





<?php if($xPanel->checkIfFieldIsFirstOfItsType($field, $fields)): ?>
    
    
    <?php $__env->startPush('crud_fields_styles'); ?>
		
		<link href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo e(asset('assets/plugins/select2-bootstrap3-theme/0.1.0-beta.10/select2-bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <?php $__env->stopPush(); ?>
    
    
    <?php $__env->startPush('crud_fields_scripts'); ?>
    
    <script src="<?php echo e(asset('assets/plugins/select2/js/select2.js')); ?>"></script>
    <script>
	    onDocumentReady((event) => {
			
			$('.select2_tagging_from_array').each(function (i, obj) {
				if (!$(obj).hasClass("select2-hidden-accessible"))
				{
					$(obj).select2({
						theme: 'bootstrap'
					});
				}
			});
			
			
			<?php
				$tagsLimit = (int)config('settings.listing_form.tags_limit', 15);
				$tagsMinLength = (int)config('settings.listing_form.tags_min_length', 2);
				$tagsMaxLength = (int)config('settings.listing_form.tags_max_length', 30);
			?>
			let selectTagging = $('.select2_tagging_from_array').select2({
				theme: 'bootstrap',
				tags: true,
				maximumSelectionLength: <?php echo e($tagsLimit); ?>,
				tokenSeparators: [',', ';', ':', '/', '\\', '#'],
				createTag: function (params) {
					var term = $.trim(params.term);
					
					
					let invalidCharsArray = [',', ';', '_', '/', '\\', '#'];
					let arrayLength = invalidCharsArray.length;
					for (let i = 0; i < arrayLength; i++) {
						let invalidChar = invalidCharsArray[i];
						if (term.indexOf(invalidChar) !== -1) {
							return null;
						}
					}
					
					
					
					if (term === '') {
						return null;
					}
					
					
					if (term.length < <?php echo e($tagsMinLength); ?> || term.length > <?php echo e($tagsMaxLength); ?>) {
						return null;
					}
					
					return {
						id: term,
						text: term
					}
				}
			});
			
			
			selectTagging.on('change', function(e) {
				if ($(this).val().length > <?php echo e($tagsLimit); ?>) {
					$(this).val($(this).val().slice(0, <?php echo e($tagsLimit); ?>));
				}
			});
			
			
			<?php if($errors->has($varName . '.*')): ?>
				$('select[name^="<?php echo e($varName); ?>"]').closest('div').addClass('is-invalid');
			<?php endif; ?>
		});
    </script>
    <?php $__env->stopPush(); ?>

<?php endif; ?>


<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/fields/select2_tagging_from_array.blade.php ENDPATH**/ ?>