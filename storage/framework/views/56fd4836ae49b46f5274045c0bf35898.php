
<?php
	$layout ??= 'default'; // default, horizontal
	$isHorizontal = $layout === 'horizontal';
	$colLabel ??= 'col-md-3';
    $colField ??= 'col-md-9';
	
	$viewName = 'checklist';
	$type = 'checkbox'; // checklist
	$label ??= null;
	$id ??= null;
	$name ??= null;
	$value ??= [];
	$default ??= null;
	$required ??= false;
	$hint ??= null;
	
	$switch ??= false;
	$reverse ??= false;
	$checkLabelClass ??= '';
	$checkLabelClass .= !empty($label) ? (!empty($checkLabelClass) ? ' fw-normal' : 'fw-normal') : '';
	$checkLabelClass = !empty($checkLabelClass) ? " $checkLabelClass" : '';
	$checkboxes ??= [];
	$checkboxesKeyName ??= null; // 'id'
	$checkboxesLabelName ??= null; // 'name'
	$col ??= 4;
	$col = (is_integer($col) && $col >= 1 && $col <= 12) ? $col : 4;
	
	$dotSepName = arrayFieldToDotNotation($name);
	$id = !empty($id) ? $id : str_replace('.', '-', $dotSepName);
	
	$value = old($dotSepName, $value);
	$value = collect($value);
	
	$attrStr = '';
?>
<div <?php echo $__env->make('helpers.forms.attributes.field-wrapper', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>>
	<?php echo $__env->make('helpers.forms.partials.label', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php if($isHorizontal): ?>
		<div class="<?php echo e($colField); ?>">
			<?php endif; ?>
			
			<?php
				$switchClass = $switch ? ' form-switch' : '';
				$reverseClass = $reverse ? ' form-check-reverse' : '';
			?>
			<div class="row">
				<?php $__currentLoopData = $checkboxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $checkbox): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$checkboxId = data_get($checkbox, 'id');
						$checkboxName = data_get($checkbox, 'name');
						$checkboxName = (!str_contains($checkboxName, '[') || !str_contains($checkboxName, ']'))
							? str_replace(['[', ']'], '', $checkboxName) . '[]'
							: $checkboxName;
						$checkboxLabel = data_get($checkbox, 'label');
						$checkboxValue = $key;
						
						$isChecked = (
							in_array($checkboxValue, $value->toArray()) ||
							(
								!empty($checkboxesKeyName) &&
								in_array($checkboxValue, $value->pluck($checkboxesKeyName, $checkboxesKeyName)->toArray())
							)
						);
						
						$checkboxDotSepName = arrayFieldToDotNotation($checkboxName);
						$checkboxId = !empty($checkboxId) ? $checkboxId : str_replace('.', '-', $checkboxDotSepName);
					?>
					<div class="col-md-<?php echo e($col); ?> my-0 py-0">
						<div class="form-check<?php echo e($switchClass . $reverseClass); ?>">
							<input
									type="checkbox"
									id="<?php echo e($checkboxId); ?>"
									name="<?php echo e($checkboxName); ?>"
									value="<?php echo e($checkboxValue); ?>"
									class="form-check-input" <?php if($isChecked): echo 'checked'; endif; ?>
							>
							<label class="form-check-label fw-normal<?php echo e($checkLabelClass); ?>" for="<?php echo e($checkboxId); ?>">
								<?php echo $checkboxLabel; ?>

							</label>
						</div>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
			
			<?php echo $__env->make('helpers.forms.partials.hint', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php echo $__env->make('helpers.forms.partials.validation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			<?php if($isHorizontal): ?>
		</div>
	<?php endif; ?>
</div>
<?php echo $__env->make('helpers.forms.partials.newline', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/fields/checklist.blade.php ENDPATH**/ ?>