
<div <?php echo $__env->make('admin.panel.inc.field_wrapper_attributes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> >
    <label class="form-label fw-bolder">
        <?php echo $field['label']; ?>

        <?php if(isset($field['required']) && $field['required']): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <?php echo $__env->make('admin.panel.fields.inc.translatable_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <textarea
    	id="tinymce-<?php echo e($field['name']); ?>"
        name="<?php echo e($field['name']); ?>"
        <?php echo $__env->make('admin.panel.inc.field_attributes', ['default_class' =>  'form-control tinymce'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        ><?php echo e(old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' ))); ?></textarea>

    
    <?php if(isset($field['hint'])): ?>
        <div class="form-text"><?php echo $field['hint']; ?></div>
    <?php endif; ?>
</div>





<?php if($xPanel->checkIfFieldIsFirstOfItsType($field, $fields)): ?>

    
    <?php $__env->startPush('crud_fields_styles'); ?>
    <?php $__env->stopPush(); ?>

    
    <?php $__env->startPush('crud_fields_scripts'); ?>
    
    <script src="<?php echo e(asset('assets/plugins/tinymce/tinymce.min.js')); ?>"></script>
    <?php
    $editorI18n = \Lang::get('tinymce', [], config('app.locale'));
    $editorI18nJson = '';
    if (!empty($editorI18n)) {
        $editorI18nJson = collect($editorI18n)->toJson();
        // Convert UTF-8 HTML to ANSI
        $editorI18nJson = convertUTF8HtmlToAnsi($editorI18nJson);
    }
    ?>
    <script type="text/javascript">
    tinymce.init({
        selector: "textarea.tinymce",
        language: '<?php echo e((!empty($editorI18nJson)) ? config('app.locale') : 'en'); ?>',
        directionality: '<?php echo e((config('lang.direction') == 'rtl') ? 'rtl' : 'ltr'); ?>',
        height: 400,
        menubar: false,
        statusbar: false,
        plugins: 'lists link table code',
        toolbar: 'undo redo | bold italic underline | forecolor backcolor | bullist numlist blockquote table | link unlink | alignleft aligncenter alignright | outdent indent | fontsizeselect | code',
     });
    <?php if(!empty($editorI18nJson)): ?>
        tinymce.addI18n('<?php echo e(config('app.locale')); ?>', <?php echo $editorI18nJson; ?>);
    <?php endif; ?>
    </script>
    <?php $__env->stopPush(); ?>

<?php endif; ?>


<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/fields/tinymce.blade.php ENDPATH**/ ?>