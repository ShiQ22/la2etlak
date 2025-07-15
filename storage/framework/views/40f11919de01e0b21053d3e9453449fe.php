
<?php
	use App\Helpers\Common\Arr;
	
	$layout ??= 'default'; // default, horizontal
	$isHorizontal = $layout === 'horizontal';
	$colLabel ??= 'col-md-3';
    $colField ??= 'col-md-9';
	
	$viewName = 'radio';
	$type = 'radio';
	$label ??= null;
	$id ??= null;
	$protectedId ??= false;
	$name ??= null;
	$value ??= null;
	$default ??= null;
	$required ??= false;
	$hint ??= null;
	$attributes ??= [];
	
	$reverse ??= false;
	$checkLabelClass ??= '';
	$checkLabelClass .= !empty($label) ? (!empty($checkLabelClass) ? ' fw-normal' : 'fw-normal') : '';
	$checkLabelClass = !empty($checkLabelClass) ? " $checkLabelClass" : '';
	$options ??= [];
	$optionValueName ??= 'value';
	$optionTextName ??= 'text';
	$inline ??= false;
	
	$dotSepName = arrayFieldToDotNotation($name);
	if (!$protectedId) {
		$id = !empty($id) ? $id : str_replace('.', '-', $dotSepName);
	}
	
	$value = $value ?? ($default ?? null);
	$value = old($name, $value);
?>
<div <?php echo $__env->make('helpers.forms.attributes.field-wrapper', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>>
	<?php echo $__env->make('helpers.forms.partials.label', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php if($isHorizontal): ?>
		<div class="<?php echo e($colField); ?>">
			<?php endif; ?>
			
			<?php if(!empty($options) && is_array($options)): ?>
				<?php if($inline && !$isHorizontal): ?><br><?php endif; ?>
				
				<?php
					$reverseClass = $reverse ? ' form-check-reverse' : '';
					$inlineClass = ($inline && !$reverse) ? ' form-check-inline' : '';
					$optionPointer = 0
				?>
				<?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$optionPointer++;
						
						$optionValue = $option[$optionValueName] ?? null;
						$optionText = $option[$optionTextName] ?? null;
						$optionAttrs = $option['attributes'] ?? [];
						$optionAttrsStr = Arr::toAttributes($optionAttrs);
						$optionAttrsStr = !empty($optionAttrsStr) ? ' ' . $optionAttrsStr : '';
						
						$radioId = $id . $optionValue;
					?>
					
					<div class="form-check<?php echo e($inlineClass . $reverseClass); ?><?php echo e($isHorizontal ? ' mt-2' : ''); ?>">
						<input
								type="radio"
								id="<?php echo e($radioId); ?>"
								name="<?php echo e($name); ?>"
								value="<?php echo e($optionValue); ?>"<?php echo $optionAttrsStr; ?>

								<?php if($optionValue == $value): echo 'checked'; endif; ?>
								<?php echo $__env->make('helpers.forms.attributes.field', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
						>
						<label class="form-check-label<?php echo e($checkLabelClass); ?>" for="<?php echo e($radioId); ?>">
							<?php echo $optionText; ?>

						</label>
					</div>
				
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
			
			<?php echo $__env->make('helpers.forms.partials.hint', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php echo $__env->make('helpers.forms.partials.validation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			<?php if($isHorizontal): ?>
		</div>
	<?php endif; ?>
</div>
<?php echo $__env->make('helpers.forms.partials.newline', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/fields/radio.blade.php ENDPATH**/ ?>