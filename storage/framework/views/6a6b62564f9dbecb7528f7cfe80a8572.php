<?php
	$layout ??= 'default'; // default, horizontal
	$isHorizontal = $layout === 'horizontal';
	
	$newline ??= false;
?>
<?php if($newline && !$isHorizontal): ?>
	
	<div class="w-100"></div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/partials/newline.blade.php ENDPATH**/ ?>