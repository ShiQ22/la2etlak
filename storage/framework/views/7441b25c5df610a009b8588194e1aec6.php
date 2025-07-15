<?php
	$hideOnMobile ??= '';
	$spaceClass = 'p-0 mt-lg-4 mt-md-3 mt-3';
?>
<?php if(isset($paddingTopExists)): ?>
	<?php if(isset($firstSection) && !$firstSection): ?>
		<div class="<?php echo e($spaceClass . $hideOnMobile); ?>"></div>
	<?php else: ?>
		<?php if(!$paddingTopExists): ?>
			<div class="<?php echo e($spaceClass . $hideOnMobile); ?>"></div>
		<?php endif; ?>
	<?php endif; ?>
<?php else: ?>
	<div class="<?php echo e($spaceClass . $hideOnMobile); ?>"></div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/sections/spacer.blade.php ENDPATH**/ ?>