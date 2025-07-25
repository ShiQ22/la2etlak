<?php
	$apiResult ??= [];
	$from = (int)data_get($apiResult, 'meta.from', 0);
	$to = (int)data_get($apiResult, 'meta.to', 0);
	$totalEntries = (int)data_get($apiResult, 'meta.total', 0);
?>
<?php if($totalEntries > 0): ?>
	<span class="text-muted count-message">
		<strong>
			<?php echo e($from); ?>

		</strong> - <strong>
			<?php echo e($to); ?>

		</strong> <?php echo e(t('of')); ?> <strong>
			<?php echo e($totalEntries); ?>

		</strong>
	</span>
	<?php echo $__env->make('front.account.messenger.threads.pagination', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/account/messenger/threads/links.blade.php ENDPATH**/ ?>