
<?php
    $phoneError = (isset($errors) && $errors->has('phone')) ? ' is-invalid' : '';
	$phoneValue = $field['value'] ?? ($field['default'] ?? '');
	$phoneCountryValue = $field['phone_country'] ?? 'us';
	$phoneValue = phoneE164($phoneValue, $phoneCountryValue);
	$phoneValueOld = phoneE164(old($field['name'], $phoneValue), old('phone_country', $phoneCountryValue));
?>
<div <?php echo $__env->make('admin.panel.inc.field_wrapper_attributes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> >
    <label class="form-label fw-bolder">
        <?php echo $field['label']; ?>

        <?php if(isset($field['required']) && $field['required']): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <?php echo $__env->make('admin.panel.fields.inc.translatable_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <?php if(isset($field['suffix'])): ?> <div class="input-group"> <?php endif; ?>
    <input
        type="tel"
        name="<?php echo e($field['name']); ?>"
        value="<?php echo e($phoneValueOld); ?>"
        <?php echo $__env->make('admin.panel.inc.field_attributes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    >
    <?php if(isset($field['suffix'])): ?> <span class="input-group-text iti-group-text"><?php echo $field['suffix']; ?></span> <?php endif; ?>
    <?php if(isset($field['suffix'])): ?> </div> <?php endif; ?>
    
    <input name="phone_country" type="hidden" value="<?php echo e(old('phone_country', $phoneCountryValue)); ?>">
    
    
    <?php if(isset($field['hint'])): ?>
        <div class="form-text"><?php echo $field['hint']; ?></div>
    <?php endif; ?>
</div>

<?php if($xPanel->checkIfFieldIsFirstOfItsType($field, $fields)): ?>
    <?php $__env->startPush('crud_fields_scripts'); ?>
        <script>
            if (typeof phoneCountry === 'undefined') {
                var phoneCountry;
            }
            phoneCountry = '<?php echo e($phoneCountryValue); ?>';
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>


<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/fields/intl_tel_input.blade.php ENDPATH**/ ?>