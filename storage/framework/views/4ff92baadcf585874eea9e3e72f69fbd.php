
<?php
	use Illuminate\Support\ViewErrorBag;
	
	$layout ??= 'default'; // default, horizontal
	$isHorizontal = $layout === 'horizontal';
	$colLabel ??= 'col-md-3';
    $colField ??= 'col-md-9';
	
	$wrapper ??= [];
	$viewName = 'password';
	$type = 'password';
	$label ??= null;
	$id ??= null;
	$name ??= null;
	$value ??= null;
	$default ??= null;
	$placeholder ??= null;
	$prefix ??= null;
	$suffix ??= null;
	$required ??= false;
	$hint ??= null;
	
	$wrapper = \App\Helpers\Common\Html\HtmlAttr::prepend($wrapper, 'class', 'password-field');
	
	$togglePassword ??= null; // 'link', 'icon' or null
	$inputGroupClass = null;
	if (!empty($togglePassword) && in_array($togglePassword, ['link', 'icon'])) {
		$pwdClass = 'text-muted text-decoration-none toggle-password-link';
		if ($togglePassword == 'link') {
			// labelRightContent
			$tooltip = 'data-bs-toggle="tooltip" data-bs-title="' . trans('auth.show_password') . '"';
			$labelRightContent = '<i class="fa-regular fa-eye-slash"></i> ';
			$labelRightContent .= '<a href="" class="' . $pwdClass . '" ' . $tooltip . ' data-toggle-text="true" data-ignore-guard="true">';
			$labelRightContent .= trans('auth.show');
			$labelRightContent .= '</a>';
		} else {
			$inputGroupClass = 'toggle-password-wrapper';
			$suffix = '<a href="" class="' . $pwdClass . '" data-ignore-guard="true"><i class="fa-regular fa-eye-slash"></i></a>';
		}
	}
	$inputGroupClass = !empty($inputGroupClass) ? ' ' . $inputGroupClass : '';
	
	$isAutoHintEnabled = (is_null($hint) || (is_bool($hint) && $hint));
	if ($isAutoHintEnabled) {
		$passwordTips = getPasswordTips();
		$passwordHint = collect($passwordTips)
			->map(fn ($item) => '<span class="d-block"><i class="bi bi-check2"></i> ' . $item . '</span>')
			->join("\n");
		$hint = $passwordHint;
	}
	
	$dotSepName = arrayFieldToDotNotation($name);
	$id = !empty($id) ? $id : str_replace('.', '-', $dotSepName);

	$hasInputGroup = (!empty($prefix) || !empty($suffix));
	
	// Handle error class for "input-group"
	$errors ??= new ViewErrorBag;
	$errorBag = ($errors instanceof ViewErrorBag) ? $errors : new ViewErrorBag;
	$isInvalidClass = $errorBag->has($dotSepName) ? 'is-invalid' : '';
	$isInvalidClass = !empty($isInvalidClass) ? ' ' . $isInvalidClass : '';
?>
<div <?php echo $__env->make('helpers.forms.attributes.field-wrapper', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>>
	<?php echo $__env->make('helpers.forms.partials.label', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php if($isHorizontal): ?>
		<div class="<?php echo e($colField); ?>">
			<?php endif; ?>
			
			<?php if(!empty($prefix) || !empty($suffix)): ?>
				<div class="input-group<?php echo e($inputGroupClass . $isInvalidClass); ?>">
					<?php endif; ?>
					<?php if(!empty($prefix)): ?>
						<span class="input-group-text"><?php echo $prefix; ?></span>
					<?php endif; ?>
					<input
							type="password"
							id="<?php echo e($id); ?>"
							name="<?php echo e($name); ?>"
							<?php if(!empty($placeholder)): ?>placeholder="<?php echo e($placeholder); ?>"<?php endif; ?>
							autocomplete="new-password"
							<?php echo $__env->make('helpers.forms.attributes.field', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					>
					<?php if(!empty($suffix)): ?>
						<span class="input-group-text"><?php echo $suffix; ?></span>
					<?php endif; ?>
					<?php if(!empty($prefix) || !empty($suffix)): ?>
				</div>
			<?php endif; ?>
			
			<?php echo $__env->make('helpers.forms.partials.hint', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php echo $__env->make('helpers.forms.partials.validation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			<?php if($isHorizontal): ?>
		</div>
	<?php endif; ?>
</div>
<?php echo $__env->make('helpers.forms.partials.newline', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
	$viewName = str($viewName)->replace('-', '_')->toString();
?>



<?php if (! $__env->hasRenderedOnce('d9d6a0af-47a6-4f74-a386-fa8636466b79')): $__env->markAsRenderedOnce('d9d6a0af-47a6-4f74-a386-fa8636466b79');
$__env->startPush("{$viewName}_assets_scripts"); ?>
	<script src="<?php echo e(asset('assets/auth/js/toggle-password-visibility.js')); ?>"></script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/fields/password.blade.php ENDPATH**/ ?>