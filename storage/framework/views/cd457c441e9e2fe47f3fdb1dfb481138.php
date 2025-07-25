
<div <?php echo $__env->make('admin.panel.inc.field_wrapper_attributes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> >
    <label class="form-label fw-bolder">
	    <?php echo $field['label']; ?>

	    <?php if(isset($field['required']) && $field['required']): ?>
		    <span class="text-danger">*</span>
	    <?php endif; ?>
    </label>
	<?php echo $__env->make('admin.panel.fields.inc.translatable_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <textarea
    	name="<?php echo e($field['name']); ?>"
        <?php echo $__env->make('admin.panel.inc.field_attributes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    	><?php echo e(old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' ))); ?></textarea>

    
    <?php if(isset($field['hint'])): ?>
        <div class="form-text"><?php echo $field['hint']; ?></div>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/fields/textarea.blade.php ENDPATH**/ ?>