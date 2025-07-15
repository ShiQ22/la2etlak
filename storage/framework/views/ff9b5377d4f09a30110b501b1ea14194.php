
<div <?php echo $__env->make('admin.panel.inc.field_wrapper_attributes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> >
    <label class="form-label fw-bolder">
        <?php echo $field['label']; ?>

        <?php if(isset($field['required']) && $field['required']): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <?php echo $__env->make('admin.panel.fields.inc.translatable_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="input-group">
        <?php
            $default = $field['value'] ?? ($field['default'] ?? '' );
        ?>
        <input
                type="text"
                name="<?php echo e($field['name']); ?>"
                value="<?php echo e(old($field['name'], $default)); ?>" data-coloris
                <?php echo $__env->make('admin.panel.inc.field_attributes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        >
    </div>
    
    <?php if(isset($field['hint'])): ?>
        <div class="form-text"><?php echo $field['hint']; ?></div>
    <?php endif; ?>
</div>




<?php if($xPanel->checkIfFieldIsFirstOfItsType($field, $fields)): ?>

    
    <?php $__env->startPush('crud_fields_styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/coloris/0.24.0/coloris.min.css')); ?>" />
        <style>
            .coloris {
                /* display: flex; /* Buggy in v0.24.0 */
                /* flex-wrap: wrap; /* Buggy in v0.24.0 */
                flex-shrink: 0;
                margin-bottom: 30px;
            }
            
            .coloris input {
                width: 100%;
                height: 32px;
                padding: 0 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-family: inherit;
                font-size: inherit;
                font-weight: inherit;
                box-sizing: border-box;
            }
            
            .clr-field  {
                width: 100%;
            }
            
            .square .clr-field button,
            .circle .clr-field button {
                width: 22px;
                height: 22px;
                left: 5px;
                right: auto;
                border-radius: 5px;
            }
    
            .square .clr-field input,
            .circle .clr-field input {
                padding-left: 36px;
            }
    
            .circle .clr-field button {
                border-radius: 50%;
            }
    
            .full .clr-field button {
                width: 100%;
                height: 100%;
                border-radius: 5px;
            }
        </style>
    <?php $__env->stopPush(); ?>

    
    <?php $__env->startPush('crud_fields_scripts'); ?>
        <script type="text/javascript" src="<?php echo e(asset('assets/plugins/coloris/0.24.0/coloris.min.js')); ?>"></script>
    <?php $__env->stopPush(); ?>

<?php endif; ?>

<?php $__env->startPush('crud_fields_scripts'); ?>
<script type="text/javascript">
    onDocumentReady((event) => {
        /* https://github.com/mdbassit/Coloris */
        let defaultConfig = {
            theme: 'pill',
            themeMode: 'dark',
            formatToggle: true,
            closeButton: true,
            clearButton: true,
        };
        let config = {};
        <?php if(isset($field['colorpicker_options'])): ?>
                config = <?php echo json_encode($field['colorpicker_options']); ?>;
        <?php endif; ?>
        document.querySelector('[name="<?php echo e($field['name']); ?>"]').addEventListener('click', e => {
            Coloris(!isEmpty(config) ? config : defaultConfig);
        });
    });
</script>
<?php $__env->stopPush(); ?>



<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/fields/color_picker.blade.php ENDPATH**/ ?>