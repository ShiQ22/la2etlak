
<?php
	$layout ??= 'default'; // default, horizontal
	$isHorizontal = $layout === 'horizontal';
	$colLabel ??= 'col-md-3';
    $colField ??= 'col-md-9';
	
	$viewName = 'checkbox';
	$type = 'checkbox';
	$label ??= null;
	$id ??= null;
	$name ??= null;
	$value ??= null;
	$default ??= null;
	$required ??= false;
	$hint ??= null;
	
	$switch ??= false;
	$reverse ??= false;
	$checkLabelClass ??= '';
	$checkLabelClass .= !empty($label) ? (!empty($checkLabelClass) ? ' fw-normal' : 'fw-normal') : '';
	$checkLabelClass = !empty($checkLabelClass) ? " $checkLabelClass" : '';
	$labelRightContent ??= null;
	$attributes ??= [];
	
	$dotSepName = arrayFieldToDotNotation($name);
	$id = !empty($id) ? $id : str_replace('.', '-', $dotSepName);
	
	$value = $value ?? ($default ?? null);
	$value = old($dotSepName, $value);
	
	$isFieldChecked = str_ends_with($name, '_at') ? !empty($value) : ((int)$value === 1 && $value !== '0');
	
	$attrStr = '';
	$attrStr = (!empty($value) && $isFieldChecked) ? 'checked="checked"' : '';
	if (!empty($attributes)) {
		foreach ($attributes as $attribute => $value) {
			$value = ($attribute == 'class') ? "form-check-input $value" : $value;
			$attrStr .= !empty($attrStr) ? ' ' : '';
			$attrStr .= $attribute . '="' . $value . '"';
		}
	} else {
		$attrStr .= !empty($attrStr) ? ' ' : '';
		$attrStr .= 'class="form-check-input"';
	}
?>
<div <?php echo $__env->make('helpers.forms.attributes.field-wrapper', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>>
	<?php echo $__env->make('helpers.forms.partials.label', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php if($isHorizontal): ?>
		<div class="<?php echo e($colField); ?>">
			<?php endif; ?>
			
			<?php
				$switchClass = $switch ? ' form-switch' : '';
				$reverseClass = $reverse ? ' form-check-reverse' : '';
				$horizontalClass = $isHorizontal ? ' mt-2' : '';
			?>
			<?php if(!empty($labelRightContent)): ?>
				<div class="row">
					<div class="col text-start">
						<div class="form-check<?php echo e($switchClass . $reverseClass . $horizontalClass); ?>">
							<input type="hidden" name="<?php echo e($name); ?>" value="0">
							<input type="checkbox" id="<?php echo e($id); ?>" name="<?php echo e($name); ?>" value="1"<?php echo $attrStr; ?>>
							<label class="form-check-label<?php echo e($checkLabelClass); ?>" for="<?php echo e($id); ?>">
								<?php echo $label; ?>

							</label>
							
							<?php echo $__env->make('helpers.forms.partials.hint', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							<?php echo $__env->make('helpers.forms.partials.validation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
						</div>
					</div>
					<div class="col-6 text-end">
						<?php echo $labelRightContent; ?>

					</div>
				</div>
			<?php else: ?>
				<div class="form-check<?php echo e($switchClass . $reverseClass . $horizontalClass); ?>">
					<input type="hidden" name="<?php echo e($name); ?>" value="0">
					<input type="checkbox" id="<?php echo e($id); ?>" name="<?php echo e($name); ?>" value="1"<?php echo $attrStr; ?>>
					<label class="form-check-label<?php echo e($checkLabelClass); ?>" for="<?php echo e($id); ?>">
						<?php echo $label; ?>

					</label>
					
					<?php echo $__env->make('helpers.forms.partials.hint', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					<?php echo $__env->make('helpers.forms.partials.validation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				</div>
			<?php endif; ?>
			
			<?php if($isHorizontal): ?>
		</div>
	<?php endif; ?>
</div>
<?php echo $__env->make('helpers.forms.partials.newline', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/fields/checkbox.blade.php ENDPATH**/ ?>