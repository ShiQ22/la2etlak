<?php
	$userStats ??= [];
	
	$countPendingApprovalPosts = (int)data_get($userStats, 'posts.pendingApproval', 0);
	$countArchivedPosts = (int)data_get($userStats, 'posts.archived', 0);
	$countPosts = (int)data_get($userStats, 'posts.published', 0);
	// $countPosts = $countPosts + $countPendingApprovalPosts + $countArchivedPosts;
	$postsVisits = (int)data_get($userStats, 'posts.visits', 0);
	$countFavoritePosts = (int)data_get($userStats, 'posts.favourite', 0);
	$countThreads = (int)data_get($userStats, 'threads.all', 0);
	
	$circleSize = '65px';
	$circleClass = 'bg-primary rounded-circle d-flex align-items-center justify-content-center';
	$circleStyle = "max-width: $circleSize; max-height: $circleSize; width: $circleSize; height: $circleSize;";
	
	$statsData = [
		'activePosts' => [
			'icon'      => 'fa-solid fa-bullhorn',
			'countItem' => \App\Helpers\Common\Num::short($countPosts),
			'label'     => trans_choice('global.count_active_posts', getPlural($countPosts), [], config('app.locale')),
			'url'       => url(urlGen()->getAccountBasePath() . '/posts/list'),
		],
		'postsVisits' => [
			'icon'      => 'fa-regular fa-eye',
			'countItem' => \App\Helpers\Common\Num::short($postsVisits),
			'label'     => trans_choice('global.count_visits', getPlural($postsVisits), [], config('app.locale')),
			'url'       => url(urlGen()->getAccountBasePath() . '/posts/list'),
		],
		'favoritePosts' => [
			'icon'      => 'fa-solid fa-envelope',
			'countItem' => \App\Helpers\Common\Num::short($countFavoritePosts),
			'label'     => trans_choice('global.count_favorites', getPlural($countFavoritePosts), [], config('app.locale')),
			'url'       => url(urlGen()->getAccountBasePath() . '/saved-posts'),
		],
		'messages' => [
			'icon'      => 'fa-solid fa-envelope',
			'countItem' => \App\Helpers\Common\Num::short($countThreads),
			'label'     => trans_choice('global.count_mails', getPlural($countThreads), [], config('app.locale')),
			'url'       => url(urlGen()->getAccountBasePath() . '/messages'),
		],
		'pendingApprovalPosts' => [
			'icon'      => 'bi bi-hourglass-split',
			'countItem' => \App\Helpers\Common\Num::short($countPendingApprovalPosts),
			'label'     => trans_choice('global.count_pending_approval_posts', getPlural($countPendingApprovalPosts), [], config('app.locale')),
			'url'       => url(urlGen()->getAccountBasePath() . '/posts/pending-approval'),
		],
		'archivedPosts' => [
			'icon'      => 'fa-solid fa-calendar-xmark',
			'countItem' => \App\Helpers\Common\Num::short($countArchivedPosts),
			'label'     => trans_choice('global.count_archived_posts', getPlural($countArchivedPosts), [], config('app.locale')),
			'url'       => url(urlGen()->getAccountBasePath() . '/posts/archived'),
		],
	];
?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title mb-0">
			<?php echo e(t('account_stats')); ?>

		</h5>
	</div>
	<div class="card-body">
		
		<div class="container px-0 text-center">
			<div class="row g-3">
				
				<?php $__currentLoopData = $statsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="col-6">
						<div class="container border rounded bg-light-subtle p-2 m-0">
							<div class="row">
								<div class="col-12 d-flex justify-content-center mb-2">
									<div class="<?php echo e($circleClass); ?>" style="<?php echo $circleStyle; ?>">
										<a href="<?php echo e($item['url']); ?>" class="<?php echo e(linkClass()); ?>">
											<i class="<?php echo e($item['icon']); ?> fs-2 text-white"></i>
										</a>
									</div>
								</div>
								<div class="col-12">
									<a href="<?php echo e($item['url']); ?>" class="<?php echo e(linkClass()); ?>">
										<?php echo e($item['countItem']); ?> <?php echo e($item['label']); ?>

									</a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				
			</div>
		
		</div>
	
	</div>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/front/account/partials/overview-stats.blade.php ENDPATH**/ ?>