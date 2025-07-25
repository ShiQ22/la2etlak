<?php
	$thread ??= [];
	$messages ??= [];
	$totalMessages = (int)($totalMessages ?? 0);
?>
<?php if(!empty($messages) && $totalMessages > 0): ?>
	<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php echo $__env->make('front.account.messenger.messages.message', [
			'thread'  => $thread,
			'message' => $message,
		], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/account/messenger/messages/messages.blade.php ENDPATH**/ ?>