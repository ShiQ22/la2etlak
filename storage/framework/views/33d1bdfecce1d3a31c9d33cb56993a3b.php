<?php if($xPanel->buttons->where('stack', $stack)->count()): ?>
	<?php $__currentLoopData = $xPanel->buttons->where('stack', $stack); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $button): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	  <?php if($button->type == 'model_function'): ?>
		<?php if($stack == 'line'): ?>
			<?php echo $entry->{$button->content}($entry); ?>

		<?php else: ?>
			<?php echo $xPanel->model->{$button->content}($xPanel); ?>

		<?php endif; ?>
	  <?php else: ?>
		<?php echo $__env->make($button->content, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	  <?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/inc/button_stack.blade.php ENDPATH**/ ?>