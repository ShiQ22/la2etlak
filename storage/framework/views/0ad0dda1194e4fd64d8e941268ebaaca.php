<?php
	// Get page error title
	$titleKey = 'global.error_http_404_title';
	$title = trans($titleKey);
	if ($title === $titleKey) {
		$title = 'Page not found';
	}
	
	// Get page error message
	$messageKey = 'global.error_http_404_message';
	$message = trans($messageKey, ['url' => url('/')]);
	if ($message === $messageKey) {
		if (isset($exception) && $exception instanceof \Throwable) {
			$message = $exception->getMessage();
			$message = str_replace(base_path(), '', $message);
		}
	}
?>

<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('status', 404); ?>
<?php $__env->startSection('message'); ?>
	<?php echo $message; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/errors/404.blade.php ENDPATH**/ ?>