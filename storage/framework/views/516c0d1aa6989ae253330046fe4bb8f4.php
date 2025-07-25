
<div <?php echo $__env->make('admin.panel.inc.field_wrapper_attributes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> >
    <label class="form-label fw-bolder">
	    <?php echo $field['label']; ?>

	    <?php if(isset($field['required']) && $field['required']): ?>
		    <span class="text-danger">*</span>
	    <?php endif; ?>
    </label>
	<?php echo $__env->make('admin.panel.fields.inc.translatable_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php if(isset($field['prefix']) || isset($field['suffix'])): ?> <div class="input-group"> <?php endif; ?>
	<?php if(isset($field['prefix'])): ?> <span class="input-group-text"><?php echo $field['prefix']; ?></span> <?php endif; ?>
    <input
    	type="email"
    	name="<?php echo e($field['name']); ?>"
        value="<?php echo e(old($field['name'], $field['value'] ?? ($field['default'] ?? ''))); ?>"
        <?php echo $__env->make('admin.panel.inc.field_attributes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	>
	<?php if(isset($field['suffix'])): ?> <span class="input-group-text"><?php echo $field['suffix']; ?></span>> <?php endif; ?>
	<?php if(isset($field['prefix']) || isset($field['suffix'])): ?> </div> <?php endif; ?>
	
    
    <?php if(isset($field['hint'])): ?>
        <div class="form-text"><?php echo $field['hint']; ?></div>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/fields/email.blade.php ENDPATH**/ ?>