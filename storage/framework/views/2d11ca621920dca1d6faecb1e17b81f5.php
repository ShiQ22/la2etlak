<?php
	$hint ??= null;
	$hintClass ??= '';
	
	$hintClass = !empty($hintClass) ? " $hintClass" : '';
?>
<?php if(!empty($hint)): ?>
	<div class="form-text<?php echo e($hintClass); ?>"><?php echo $hint; ?></div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/partials/hint.blade.php ENDPATH**/ ?>