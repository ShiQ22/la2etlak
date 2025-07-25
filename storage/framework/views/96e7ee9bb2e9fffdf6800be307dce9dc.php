<?php if(!empty($threads) && $totalThreads > 0): ?>
	<?php $__currentLoopData = $threads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thread): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php
			$isLastThread = $loop->last;
		?>
		<?php echo $__env->make('front.account.messenger.threads.thread', [
			'thread'       => $thread,
			'isLastThread' => $isLastThread,
		], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
	<?php echo $__env->make('front.account.messenger.threads.no-threads', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/account/messenger/threads/threads.blade.php ENDPATH**/ ?>