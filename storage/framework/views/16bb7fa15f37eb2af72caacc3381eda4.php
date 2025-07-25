<?php
	$thread ??= [];
	$isLastThread ??= false;
	
	$userName = data_get($thread, 'p_creator.name');
	$avatarUrl = url(data_get($thread, 'p_creator.photo_url', ''));
	$userIsOnline = isUserOnline(data_get($thread, 'p_creator')) ? 'online text-success' : 'offline text-secondary';
	
	$msgUri = urlGen()->getAccountBasePath() . '/messages/' . data_get($thread, 'id');
	$msgSubject = data_get($thread, 'subject');
	$msgBody = str(data_get($thread, 'latest_message.body') ?? '')->limit(125);
	$msgCreatedAt = data_get($thread, 'created_at_formatted', data_get($thread, 'created_at')); // not sent
	$isImportant = data_get($thread, 'p_is_important');
	$isUnread = data_get($thread, 'p_is_unread');
	
	$borderBottom = !$isLastThread ? ' border-bottom pb-2' : '';
	$unreadClass = $isUnread ? ' bg-warning-subtle fw-bold' : '';
?>
<div class="row hstack gap-0<?php echo e($unreadClass . $borderBottom); ?> mb-2">
	<div class="col-auto">
		<input type="checkbox" name="entries[]" value="<?php echo e(data_get($thread, 'id')); ?>">
	</div>
	
	<div class="col-2">
		<a href="<?php echo e(url($msgUri)); ?>" class="list-box-user">
			<img src="<?php echo e($avatarUrl); ?>" class="img-fluid object-fit-fill border rounded" alt="<?php echo e($userName); ?>">
		</a>
	</div>
	
	<div class="col-8">
		<a href="<?php echo e(url($msgUri)); ?>" class="list-box-content <?php echo e(linkClass('body-emphasis')); ?>">
			<h5 class="fs-5 fw-bold mt-0"><?php echo e($msgSubject); ?></h5>
			<span class="fs-6">
				<i class="fa-solid fa-circle <?php echo e($userIsOnline); ?>"></i> <?php echo e($userName); ?>

			</span>
			<div class="">
				<?php echo e($msgBody); ?>

			</div>
			<div class="text-muted"><?php echo e($msgCreatedAt); ?></div>
		</a>
	</div>
	
	<div class="col-1 ms-auto list-box-action">
		<div class="row d-flex flex-column text-end">
			<div class="col-12">
				<?php if($isImportant): ?>
					<a href="<?php echo e(url($msgUri . '/actions?type=markAsNotImportant')); ?>"
					   data-bs-toggle="tooltip"
					   data-bs-placement="top"
					   class="markAsNotImportant <?php echo e(linkClass()); ?>"
					   title="<?php echo e(t('Mark as not important')); ?>"
					>
						<i class="fa-solid fa-star"></i>
					</a>
				<?php else: ?>
					<a href="<?php echo e(url($msgUri . '/actions?type=markAsImportant')); ?>"
					   data-bs-toggle="tooltip"
					   data-bs-placement="top"
					   class="markAsImportant <?php echo e(linkClass()); ?>"
					   title="<?php echo e(t('Mark as important')); ?>"
					>
						<i class="fa-regular fa-star"></i>
					</a>
				<?php endif; ?>
			</div>
			<div class="col-12">
				<a href="<?php echo e(url($msgUri . '/delete')); ?>"
				   data-bs-toggle="tooltip"
				   data-bs-placement="top"
				   class="<?php echo e(linkClass('danger')); ?>"
				   title="<?php echo e(t('Delete')); ?>"
				>
					<i class="fa-solid fa-trash"></i>
				</a>
			</div>
			<div class="col-12">
				<?php if($isUnread): ?>
					<a href="<?php echo e(url($msgUri . '/actions?type=markAsRead')); ?>"
					   data-bs-toggle="tooltip"
					   data-bs-placement="top"
					   class="markAsRead <?php echo e(linkClass()); ?>"
					   title="<?php echo e(t('Mark as read')); ?>"
					>
						<i class="fa-solid fa-envelope"></i>
					</a>
				<?php else: ?>
					<a href="<?php echo e(url($msgUri . '/actions?type=markAsUnread')); ?>"
					   data-bs-toggle="tooltip"
					   data-bs-placement="top"
					   class="markAsRead <?php echo e(linkClass()); ?>"
					   title="<?php echo e(t('Mark as unread')); ?>"
					>
						<i class="fa-solid fa-envelope-open"></i>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/front/account/messenger/threads/thread.blade.php ENDPATH**/ ?>