
<?php
	$field ??= [];
	
	$entityModel = !empty($xPanel) ? $xPanel->model : null;
	$isNullAllowed = is_null($entityModel) || $entityModel::isColumnNullable($field['name']);
	$possibleEnumValues = $entityModel::getPossibleEnumValues($field['name']);
	
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
    <select name="<?php echo e($field['name']); ?>"
        <?php echo $__env->make('admin.panel.inc.field_attributes', ['default_class' =>  'form-select'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    >
        <?php if($isNullAllowed): ?>
            <option value="">-</option>
        <?php endif; ?>
		<?php if(count($possibleEnumValues)): ?>
			<?php $__currentLoopData = $possibleEnumValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $possibleValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		        <?php
			        $selectedAttr = ($possibleValue == $fieldValue) ? ' selected' : '';
		        ?>
				<option value="<?php echo e($possibleValue); ?>"<?php echo $selectedAttr; ?>><?php echo e($possibleValue); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</select>
	
    
    <?php if(isset($field['hint'])): ?>
        <div class="form-text"><?php echo $field['hint']; ?></div>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/fields/enum.blade.php ENDPATH**/ ?>