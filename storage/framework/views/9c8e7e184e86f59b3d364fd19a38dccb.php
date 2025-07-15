
<input
type="hidden"
name="<?php echo e($field['name']); ?>"
value="<?php echo e(old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' ))); ?>"
<?php echo $__env->make('admin.panel.inc.field_attributes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
><?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/fields/hidden.blade.php ENDPATH**/ ?>