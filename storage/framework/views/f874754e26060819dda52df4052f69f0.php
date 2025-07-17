<?php use App\Enums\BootstrapColor; ?>


<?php
	$apiResult ??= [];
	$posts = (array)data_get($apiResult, 'data');
	$totalPosts = (int)data_get($apiResult, 'meta.total', 0);
	$pagePath ??= null;
	
	$countPromotionPackages ??= 0;
	$countPaymentMethods ??= 0;
	
	$pageData = [
		'list' => [
			'icon'     => 'fa-solid fa-bullhorn',
			'title'    => t('my_listings'),
			'basePath' => urlGen()->getAccountBasePath() . '/posts/list',
		],
		'archived' => [
			'icon'     => 'bi bi-calendar-x',
			'title'    => t('archived_listings'),
			'basePath' => urlGen()->getAccountBasePath() . '/posts/archived',
		],
		'pending-approval' => [
			'icon'     => 'bi bi-hourglass-split',
			'title'    => t('pending_approval'),
			'basePath' => urlGen()->getAccountBasePath() . '/posts/pending-approval',
		],
		'saved-posts' => [
			'icon'     => 'bi bi-bookmarks',
			'title'    => t('favourite_listings'),
			'basePath' => urlGen()->getAccountBasePath() . '/saved-posts',
		],
	];
	
	$pageIcon = $pageData[$pagePath]['icon'] ?? 'fa-solid fa-bullhorn';
	$pageTitle = $pageData[$pagePath]['title'] ?? t('posts');
	$basePath = $pageData[$pagePath]['basePath'] ?? urlGen()->getAccountBasePath() . '/posts/undefined';
?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('front.common.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				<?php if(session()->has('flash_notification')): ?>
					<div class="col-12">
						<div class="row">
							<div class="col-12">
								<?php echo $__env->make('flash::message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
				<div class="col-md-3">
					<?php echo $__env->make('front.account.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				</div>

				<div class="col-md-9">
					<div class="container border rounded bg-body-tertiary p-4 p-lg-3 p-md-2">
						<h3 class="fw-bold border-bottom pb-3 mb-4">
							<i class="<?php echo e($pageIcon); ?>"></i> <?php echo e($pageTitle); ?>

						</h3>
						
						<div class="table-responsive" style="min-height: 600px;">
							<form name="listForm" action="<?php echo e(url($basePath . '/delete')); ?>" method="POST">
								<?php echo csrf_field(); ?>
								<div class="table-action">
									<div class="btn-group" role="group">
										<button type="button" class="btn btn-sm btn btn-outline-primary pb-0">
											<input type="checkbox" id="checkAll" class="from-check-all">
										</button>
										<button type="button" class="btn btn-sm btn btn-primary from-check-all">
											<?php echo e(t('Select')); ?>: <?php echo e(t('All')); ?>

										</button>
									</div>
									
									<button type="submit" class="btn btn-sm btn btn-danger confirm-simple-action">
										<i class="fa-regular fa-trash-can"></i> <?php echo e(t('Delete')); ?>

									</button>
									
									<div class="table-search float-end col-sm-7">
										<div class="row">
											<label class="col-5 form-label text-end"><?php echo e(t('search')); ?> <br>
												<a title="clear filter" class="clear-filter <?php echo e(linkClass()); ?>" href="#clear">
													[<?php echo e(t('clear')); ?>]
												</a>
											</label>
											<div class="col-7 px-3">
												<input type="text" class="form-control" id="filter">
											</div>
										</div>
									</div>
								</div>
								
								<table id="addManageTable"
									   class="table table-striped"
									   data-filter="#filter"
									   data-filter-text-only="true"
								>
									<thead>
									<tr>
										<th scope="col" data-type="numeric" data-sort-initial="true"></th>
										<th scope="col"><?php echo e(t('Photo')); ?></th>
										<th scope="col" data-sort-ignore="true"><?php echo e(t('listing_details')); ?></th>
										<th scope="col" data-type="numeric" class="d-md-table-cell d-sm-none d-none">--</th>
										<th scope="col"><?php echo e(t('action')); ?></th>
									</tr>
									</thead>
									<tbody>
									
									<?php if(!empty($posts) && $totalPosts > 0): ?>
										<?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php
												$postUrl = urlGen()->post($post);
												$deletingUrl = url($basePath . '/' . data_get($post, 'id') . '/delete');
												
												$isForOwnerEdition = (
													in_array($pagePath, ['list', 'pending-approval'])
													&& isset($authUser, $authUser->id)
													&& $authUser->id == data_get($post, 'user_id')
												);
												
												$isEditingAllowed = (
													$isForOwnerEdition
													&& empty(data_get($post, 'archived_at'))
												);
												$isPhotoEditingAllowed = (
													$isForOwnerEdition
													&& isMultipleStepsFormEnabled()
												);
												$isPlanPaymentAllowed = (
													$isForOwnerEdition
													&& isMultipleStepsFormEnabled()
													&& $countPromotionPackages > 0 && $countPaymentMethods > 0
												);
												$isArchivingAllowed = (
													$pagePath == 'list'
													&& isVerifiedPost($post)
													&& empty(data_get($post, 'archived_at'))
												);
												$isRepostingAllowed = (
													$pagePath == 'archived'
													&& isset($authUser, $authUser->id)
													&& $authUser->id == data_get($post, 'user_id')
													&& !empty(data_get($post, 'archived_at'))
												);
												
												$editingUrl = urlGen()->editPost($post);
												$photoEditingUrl = url('posts/' . data_get($post, 'id') . '/photos');
												$planPaymentUrl = url('posts/' . data_get($post, 'id') . '/payment');
												$archivingUrl = url($basePath . '/' . data_get($post, 'id') . '/offline');
												$repostingUrl = url($basePath . '/' . data_get($post, 'id') . '/repost');
											?>
											<tr>
												<td style="width:2%" class="add-img-selector">
													<div class="checkbox">
														<label><input type="checkbox" name="entries[]" value="<?php echo e(data_get($post, 'id')); ?>"></label>
													</div>
												</td>
												<td style="width:20%" class="add-img-td">
													<a href="<?php echo e($postUrl); ?>">
														<img class="img-thumbnail img-fluid" src="<?php echo e(data_get($post, 'picture.url.medium')); ?>" alt="img">
													</a>
												</td>
												<td style="width:52%" class="items-details-td">
													<div>
														<p>
															<a href="<?php echo e($postUrl); ?>"
															   class="<?php echo e(linkClass()); ?> fw-bold"
															   title="<?php echo e(data_get($post, 'title')); ?>"
															>
																<?php echo e(str(data_get($post, 'title'))->limit(40)); ?>

																<?php echo $__env->make('front.layouts.partials.lost-found-badge', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
															</a>
															<?php if(in_array($pagePath, ['list', 'archived', 'pending-approval'])): ?>
																<?php if(
																	!empty(data_get($post, 'payment'))
																	&& !empty(data_get($post, 'payment.package'))
																): ?>
																	<?php
																		$ribbonColor = data_get($post, 'payment.package.ribbon');
																		$ribbonColorClass = BootstrapColor::Badge->getColorClass($ribbonColor);
																		$packageShortName = data_get($post, 'payment.package.short_name');
																		$packageInfo = '';
																		if (data_get($post, 'featured') != 1) {
																			$ribbonColorClass = 'text-bg-secondary';
																			$packageInfo = ' (' . t('expired') . ')';
																		}
																	?>
																	<span class="badge rounded-pill <?php echo e($ribbonColorClass); ?>"
																	      data-bs-toggle="tooltip"
																	      data-bs-placement="bottom"
																	      title="<?php echo e($packageShortName . $packageInfo); ?>"
																	>
																		<?php echo e($packageShortName); ?>

																	</span>
																<?php endif; ?>
															<?php endif; ?>
														</p>
														<?php
															$listingDates = getListingDates($post, $pagePath);
														?>
														<?php if(!empty($listingDates)): ?>
															<?php $__currentLoopData = $listingDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $labeledDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																<p class="mb-1">
																	<i class="fa-regular fa-clock"
																	   data-bs-toggle="tooltip"
																	   data-bs-placement="bottom"
																	   title="<?php echo e($label); ?>"
																	></i>&nbsp;<?php echo $labeledDate; ?>

																</p>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														<?php endif; ?>
														<p class="mb-1">
															<i class="fa-regular fa-eye"
															   data-bs-toggle="tooltip"
															   data-bs-placement="bottom"
															   title="<?php echo e(t('Visitors')); ?>"
															></i> <?php echo e(data_get($post, 'visits_formatted') ?? 0); ?>

															
															<i class="bi bi-geo-alt"
															   data-bs-toggle="tooltip"
															   data-bs-placement="bottom"
															   title="<?php echo e(t('Located In')); ?>"
															></i> <?php echo e(data_get($post, 'city.name') ?? '-'); ?>

															
															<img src="<?php echo e(data_get($post, 'country_flag_url')); ?>" alt=""
															     data-bs-toggle="tooltip"
															     title="<?php echo e(data_get($post, 'country.name')); ?>"
															>
														</p>
													</div>
												</td>
												<td style="width:16%" class="price-td d-md-table-cell d-sm-none d-none">
													<div class="fw-bold">
														<?php echo data_get($post, 'price_formatted'); ?>

													</div>
												</td>
												<td style="width:10%" class="action-td">
													<div>
														<div class="btn-group">
															<button type="button"
															        class="btn btn btn-outline-primary dropdown-toggle"
															        data-bs-toggle="dropdown"
															        aria-expanded="false"
															>
																<?php echo e(t('action')); ?>

															</button>
															<ul class="dropdown-menu">
																<?php if($isEditingAllowed): ?>
																	<li>
																		<a class="dropdown-item" href="<?php echo e($editingUrl); ?>">
																			<i class="fa-regular fa-pen-to-square"></i> <?php echo e(t('Edit')); ?>

																		</a>
																	</li>
																<?php endif; ?>
																<?php if($isPhotoEditingAllowed): ?>
																	<li>
																		<a class="dropdown-item" href="<?php echo e($photoEditingUrl); ?>">
																			<i class="bi bi-camera"></i> <?php echo e(t('Update Photos')); ?>

																		</a>
																	</li>
																<?php endif; ?>
																<?php if($isPlanPaymentAllowed): ?>
																	<li>
																		<a class="dropdown-item" href="<?php echo e($planPaymentUrl); ?>">
																			<i class="fa-regular fa-circle-check"></i> <?php echo e(t('Make It Premium')); ?>

																		</a>
																	</li>
																<?php endif; ?>
																<?php if($isArchivingAllowed): ?>
																	<li>
																		<a class="dropdown-item confirm-simple-action" href="<?php echo e($archivingUrl); ?>">
																			<i class="fa-solid fa-eye-slash"></i> <?php echo e(t('put_it_offline')); ?>

																		</a>
																	</li>
																<?php endif; ?>
																<?php if($isRepostingAllowed): ?>
																	<li>
																		<a class="dropdown-item confirm-simple-action" href="<?php echo e($repostingUrl); ?>">
																			<i class="fa-solid fa-recycle"></i> <?php echo e(t('re_post_it')); ?>

																		</a>
																	</li>
																<?php endif; ?>
																<li>
																	<a class="dropdown-item confirm-simple-action text-danger"
																	   href="<?php echo e($deletingUrl); ?>"
																	>
																		<i class="fa-regular fa-trash-can"></i> <?php echo e(t('Delete')); ?>

																	</a>
																</li>
															</ul>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
									</tbody>
								</table>
							</form>
						</div>
						
						<nav>
							<?php echo $__env->make('vendor.pagination.api.bootstrap-4', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
						</nav>
						
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script src="<?php echo e(url('assets/plugins/footable-jquery/2.0.1.4/footable.js?v=2-0-1')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/footable-jquery/2.0.1.4/footable.filter.js?v=2-0-1')); ?>" type="text/javascript"></script>
	<script type="text/javascript">
		onDocumentReady((event) => {
			$('#addManageTable').footable().bind('footable_filtering', function (e) {
				let selected = $('.filter-status').find(':selected').text();
				if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				}
			});
			
			/* Clear Filter OnClick */
			const clearFilterEl = document.querySelector(".clear-filter");
			if (clearFilterEl) {
				clearFilterEl.addEventListener("click", (event) => {
					event.preventDefault();
					
					const filterStatusEl = document.querySelector(".filter-status");
					if (filterStatusEl) {
						filterStatusEl.value = '';
					}
					
					$('table.demo').trigger('footable_clear_filter');
				});
			}
			
			/* Check All OnClick */
			const checkAllEls = document.querySelectorAll('.from-check-all');
			if (checkAllEls.length > 0) {
				checkAllEls.forEach(checkEl => {
					checkEl.addEventListener('click', (event) => checkAllBoxes(event.target));
				});
			}
		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/account/posts.blade.php ENDPATH**/ ?>