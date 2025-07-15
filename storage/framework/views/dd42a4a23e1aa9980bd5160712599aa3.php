<?php
	$captchaType = config('settings.security.captcha');
	$isCaptchaEnabled = !empty($captchaType);
	
	// Get all variables available in the current view, then
	// Filter out Laravel's internal variables if needed
	$allVars = get_defined_vars();
	$bladeInternalVars = ['__data', '__path', '__env', 'app', 'errors'];
	$passedParams = array_diff_key($allVars, array_flip($bladeInternalVars));
	
	// Verify the field label
	$label = $passedParams['label'] ?? '';
	$label = (is_string($label) && !empty($label)) ? $label : null;
	$passedParams['label'] = $label;
	if (!empty($label)) {
		$passedParams['required'] = true;
	}
?>
<?php if($isCaptchaEnabled): ?>
	<?php if($captchaType == 'recaptcha'): ?>
		<?php echo $__env->make('helpers.forms.fields.recaptcha', $passedParams, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php endif; ?>
	<?php if(in_array($captchaType, ['default', 'math', 'flat', 'mini', 'inverse', 'custom'])): ?>
		<?php echo $__env->make('helpers.forms.fields.simple-captcha', $passedParams, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/fields/captcha.blade.php ENDPATH**/ ?>