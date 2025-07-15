<?php
	$title = t('Internal Server Error');
	
	$isDebugEnabled = config('app.debug');
	$defaultErrorMessage = t('An internal server error has occurred');
	$extractedMessage = null;
	
	if (isset($exception) && $exception instanceof \Throwable) {
		$extractedMessage = $exception->getMessage();
		$extractedMessage = str_replace(base_path(), '', $extractedMessage);
		
		if (!empty($extractedMessage) && $isDebugEnabled) {
			if (method_exists($exception, 'getFile')) {
				$filePath = $exception->getFile();
				$filePath = str_replace(base_path(), '', $filePath);
				$extractedMessage .= "\n" . 'In the: <code>' . $filePath . '</code> file';
				if (method_exists($exception, 'getLine')) {
					$extractedMessage .= ' at line: <code>' . $exception->getLine() . '</code>';
				}
			}
			$extractedMessage = nl2br($extractedMessage);
		}
	}
	
	$message = !empty($extractedMessage) ? $extractedMessage : $defaultErrorMessage;
?>

<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('status', 401); ?>
<?php $__env->startSection('message'); ?>
	<?php echo $message; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/errors/500.blade.php ENDPATH**/ ?>