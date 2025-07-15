<form role="form" novalidate>
    
    <?php if($errors->any()): ?>
		<div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
			<h4 class="alert-heading"><?php echo e(trans('admin.please_fix')); ?></h4>
			<ul>
				<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li><?php echo $error; ?></li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
    <?php endif; ?>

    
	<div class="card mb-0">
		<div class="row">
			<?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo $__env->make('admin.panel.fields.' . $field['type'], ['field' => $field], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				
				
				<?php if(array_key_exists('newline', $field)): ?>
					<?php if(is_bool($field['newline']) && $field['newline']): ?>
						<div style="clear: both; margin: 0; padding: 0;"></div>
					<?php endif; ?>
					<?php if(isset($form)): ?>
						<?php if(is_string($field['newline']) && $field['newline'] == $form): ?>
							<div style="clear: both; margin: 0; padding: 0;"></div>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>

</form>



<?php $__env->startSection('after_styles'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_styles'); ?>
	
    <!-- CRUD FORM CONTENT - crud_fields_styles stack -->
    <?php echo $__env->yieldPushContent('crud_fields_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	
    <!-- CRUD FORM CONTENT - crud_fields_scripts stack -->
    <?php echo $__env->yieldPushContent('crud_fields_scripts'); ?>

    <script>
	    onDocumentReady((event) => {
			// Save button has multiple actions: save and exit, save and edit, save and new
			const saveActions = $('#saveActions');
		    const crudForm = saveActions.parents('form');
		    const saveActionField = $('[name="save_action"]');
			
			saveActions.on('click', '.dropdown-menu a', function() {
				const saveAction = $(this).data('value');
				saveActionField.val(saveAction);
				crudForm.submit();
			});
			
            // Ctrl+S and Cmd+S trigger Save button click
            $(document).keydown(function(e) {
                if (
					((e.which === 115 || e.which === '115') || (e.which === 83 || e.which === '83'))
	                && (e.ctrlKey || e.metaKey)
                )
                {
                    e.preventDefault();
                    // alert("Ctrl-s pressed");
                    $("button[type=submit]").trigger('click');
                    return false;
                }
                return true;
            });

            <?php if($xPanel->autoFocusOnFirstField): ?>
                // Focus on first field
	            <?php
	                $focusField = \Illuminate\Support\Arr::first($fields, function($field) {
	                    return isset($field['auto_focus']) && $field['auto_focus'] == true;
	                })
	            ?>
				
	            <?php if($focusField): ?>
	                window.focusField = $('[name="<?php echo e($focusField['name']); ?>"]').eq(0);
	            <?php else: ?>
	                const focusField = $('form').find('input, textarea, select').not('[type="hidden"]').eq(0);
	            <?php endif; ?>
				
			    const fieldOffset = focusField.offset().top;
			    const scrollTolerance = $(window).height() / 2;
				
	            focusField.trigger('focus');
				
	            if (fieldOffset > scrollTolerance) {
	                $('html, body').animate({scrollTop: (fieldOffset - 30)});
	            }
            <?php endif; ?>
        });
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/form_content.blade.php ENDPATH**/ ?>