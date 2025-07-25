<?php
	$stats ??= [];
	$countThreadsWithNewMessage = (int)data_get($stats, 'threads.withNewMessage'); // not sent
	
	$navLinks = [
		'inbox' => [
			'label'    => t('inbox'),
			'url'      => url(urlGen()->getAccountBasePath() . '/messages'),
			'isActive' => (!request()->has('filter') || request()->query('filter')==''),
		],
		'unread' => [
			'label'    => t('unread'),
			'url'      => url(urlGen()->getAccountBasePath() . '/messages?filter=unread'),
			'isActive' => (request()->query('filter')=='unread'),
		],
		'started' => [
			'label'    => t('started'),
			'url'      => url(urlGen()->getAccountBasePath() . '/messages?filter=started'),
			'isActive' => (request()->query('filter')=='started'),
		],
		'important' => [
			'label'    => t('important'),
			'url'      => url(urlGen()->getAccountBasePath() . '/messages?filter=important'),
			'isActive' => (request()->query('filter')=='important'),
		],
	];
?>
<div class="col-md-3 col-lg-2">
	<ul class="nav nav-pills nav-justified inbox-nav">
		<?php $__currentLoopData = $navLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php
				$activeClass = $item['isActive'] ? ' active' : '';
				$linkUrl = $item['url'];
				$linkLabel = $item['label'];
				$activeLinkClass = $item['isActive'] ? 'text-white' : 'link-primary';
			
				$hasBadge = ($key == 'inbox');
				$badgeColor = ' ' . ($item['isActive'] ? 'text-bg-light' : 'text-bg-primary');
				$badgeVisibility = ($countThreadsWithNewMessage <= 0) ? ' d-none' : '';
				$badgeVisibility = '';
			?>
			<li class="nav-item">
				<a class="nav-link<?php echo e($activeClass); ?>" href="<?php echo e($linkUrl); ?>">
					<?php echo e($linkLabel); ?>

					<?php if($hasBadge): ?>
						<span class="count-threads-with-new-messages count badge rounded-pill <?php echo e($badgeColor . $badgeVisibility); ?>">
							<?php echo e(\App\Helpers\Common\Num::short($countThreadsWithNewMessage)); ?>

						</span>
					<?php endif; ?>
				</a>
			</li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</ul>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/front/account/messenger/partials/sidebar.blade.php ENDPATH**/ ?>