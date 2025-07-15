<?php
	use Illuminate\Support\ViewErrorBag;
	
	$name ??= 'field';
	$showError ??= false;
	$errors ??= new ViewErrorBag;
	$errorBag = ($errors instanceof ViewErrorBag) ? $errors : new ViewErrorBag;
	$errorClass ??= '';
	
	$errorClass = !empty($errorClass) ? " $errorClass" : '';
?>
<?php if($showError && $errorBag->has($name)): ?>
	<div class="invalid-feedback<?php echo e($errorClass); ?>"><?php echo e($errorBag->first($name)); ?></div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/partials/validation.blade.php ENDPATH**/ ?>