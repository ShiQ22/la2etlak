
<?php
	$field ??= [];
	
	$field['allows_null'] ??= false;
	$field['allows_multiple'] ??= false;
	
	$name = $field['name'];
	$name = $field['allows_multiple'] ? $name . '[]' : $name;
	
	$field['options'] ??= [];
	
	$multipleAttr = $field['allows_multiple'] ? ' multiple' : '';
	
	$fieldValue = $field['value'] ?? ($field['default'] ?? null);
	$fieldValue = old($field['name'], $fieldValue);
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
			<?php echo $__env->make('admin.panel.inc.field_attributes', ['default_class' => 'form-select select2_from_skins'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php echo $multipleAttr; ?>

	>
		<?php if($field['allows_null']): ?>
			<option value="">-</option>
		<?php endif; ?>
		<?php if(!empty($field['options'])): ?>
			<?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php
					$selectedAttr = ($key == $fieldValue || (is_array($fieldValue) && in_array($key, $fieldValue))) ? ' selected' : '';
				?>
				<option value="<?php echo e($key); ?>"<?php echo $selectedAttr; ?>><?php echo $value; ?></option>
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
		var skins = jQuery.parseJSON('<?php echo $field['skins']; ?>');
		
		onDocumentReady((event) => {
			// trigger select2 for each untriggered select2 box
			$('.select2_from_skins').each(function (i, obj) {
				if (!$(obj).hasClass("select2-hidden-accessible")) {
					$(obj).select2({
						theme: "bootstrap",
						templateResult: formatColor,
						templateSelection: formatColor
					});
				}
			});
		});
		
		function formatColor(color) {
			if (!color.id) {
				return color.text;
			}
			
			let hex = '#000000';
			if (
				typeof skins[color.id] !== 'undefined'
				&& typeof skins[color.id].color !== 'undefined'
				&& skins[color.id].color != null
			) {
				hex = skins[color.id].color;
			}
			if (color.id === 'default') {
				hex = '#CCCCCC';
			}
			
			const colorIcon = `<div class="d-inline-block me-2" style="width: 30px; height: 20px; background-color: ${hex};"></div>`;
			const colorText = color.text;
			const formattedValue = `<div style="display: flex; align-items: center;">${colorIcon}${colorText}</div>`;
			
			return $(formattedValue);
		}
	</script>
	<?php $__env->stopPush(); ?>

<?php endif; ?>


<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/fields/select2_from_skins.blade.php ENDPATH**/ ?>