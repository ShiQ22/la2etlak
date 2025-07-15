<?php
	use Illuminate\Support\ViewErrorBag;
	
	$layout ??= 'default'; // default, horizontal
	$isHorizontal = $layout === 'horizontal';
	$colLabel ??= 'col-md-3';
    $colField ??= 'col-md-9';
	
	$viewName ??= null;
	$name ??= '';
	$label ??= null;
	$labelClass ??= '';
	$labelRightContent ??= null;
	$required ??= false;
	
	$labelClass = !empty($labelClass) ? " $labelClass" : '';
	
	$class = $isHorizontal ? "$colLabel col-form-label d-flex justify-content-end" : 'form-label';
	$class = $class . $labelClass;
	
	$dotSepName = arrayFieldToDotNotation($name);
	$id = !empty($id) ? $id : str_replace('.', '-', $dotSepName);
	
	// Handle error class
	$errors ??= new ViewErrorBag;
	$errorBag = ($errors instanceof ViewErrorBag) ? $errors : new ViewErrorBag;
	$isInvalidClass = $errorBag->has($dotSepName) ? 'is-invalid' : '';
	
	$class .= !empty($class) ? ' ' . $isInvalidClass : $isInvalidClass;
	
	// Handle label
	if (in_array($viewName, ['checkbox', 'checkbox-switch'])) {
		$label = null;
	}
?>
<?php if(!empty($label)): ?>
	<?php if(!empty($labelRightContent)): ?>
		<?php if($isHorizontal): ?>
			<label class="<?php echo e($class); ?>" for="<?php echo e($id); ?>">
				<?php echo $label; ?><?php if($required): ?><span class="text-danger ms-1">*</span><?php endif; ?> <?php echo "($labelRightContent)"; ?>

			</label>
		<?php else: ?>
			<div class="row">
				<label class="<?php echo e($class); ?> col-6 text-start" for="<?php echo e($id); ?>">
					<?php echo $label; ?><?php if($required): ?><span class="text-danger ms-1">*</span><?php endif; ?>
				</label>
				<div class="col-6 text-end">
					<?php echo $labelRightContent; ?>

				</div>
			</div>
		<?php endif; ?>
	<?php else: ?>
		<label class="<?php echo e($class); ?>" for="<?php echo e($id); ?>">
			<?php echo $label; ?><?php if($required): ?><span class="text-danger ms-1">*</span><?php endif; ?>
		</label>
	<?php endif; ?>
<?php else: ?>
	<?php if($isHorizontal): ?>
		<label class="<?php echo e($class); ?>"></label>
	<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/partials/label.blade.php ENDPATH**/ ?>