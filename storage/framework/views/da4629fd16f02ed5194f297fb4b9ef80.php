<?php
	
	$apiResult ??= [];
	$apiExtra ??= [];
	$count = (array)data_get($apiExtra, 'count');
	$posts = (array)data_get($apiResult, 'data');
	$totalPosts = (int)data_get($apiResult, 'meta.total', 0);
	$tags = (array)data_get($apiExtra, 'tags');
	
	$postTypes ??= [];
	$orderByOptions ??= [];
	$displayModes ??= [];
	
	$selectedDisplayMode = config('settings.listings_list.display_mode', 'grid-view');
	$hideOnlyOnXs = 'd-none d-sm-block';
	$hideInLineFromMd = 'd-none d-lg-inline-block';
?>

<?php $__env->startSection('search'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('search'); ?>
	<?php echo $__env->make('front.search.partials.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="main-container">
		
		<?php if(session()->has('flash_notification')): ?>
			<?php echo $__env->make('front.common.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php
				$paddingTopExists = true;
			?>
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php echo $__env->make('flash::message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		
		<?php echo $__env->make('front.search.partials.breadcrumbs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
		<?php if(config('settings.listings_list.show_cats_in_top')): ?>
			<?php if(!empty($cats)): ?>
				<div class="container mb-2 <?php echo e($hideOnlyOnXs); ?>">
					<div class="row p-0 m-0">
						<div class="col-12 p-0 m-0 border-top"></div>
					</div>
				</div>
			<?php endif; ?>
			<?php echo $__env->make('front.search.partials.categories', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		<?php endif; ?>
		
		<?php if(!empty($topAdvertising)): ?>
			<?php echo $__env->make('front.layouts.partials.advertising.top', ['paddingTopExists' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php
				$paddingTopExists = false;
			?>
		<?php else: ?>
			<?php
				if (isset($paddingTopExists) && $paddingTopExists) {
					$paddingTopExists = false;
				}
			?>
		<?php endif; ?>
		
		<div class="container">
			<div class="row">
				<?php
					$contentColSm = 'col-md-12';
				?>
				
				
                <?php if(config('settings.listings_list.left_sidebar')): ?>
                    <?php echo $__env->make('front.search.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					<?php
						$contentColSm = 'col-md-9';
					?>
                <?php endif; ?>
				
				
				<div class="<?php echo e($contentColSm); ?> mb-4">
					<div class="<?php echo e($selectedDisplayMode); ?><?php echo e(($contentColSm == 'col-md-12') ? ' noSideBar' : ''); ?>">
						
						<ul class="nav nav-tabs" id="postType">
							<?php
								$aClass = '';
								$spanClass = 'text-bg-secondary';
								if (config('settings.listing_form.show_listing_type')) {
									if (!request()->filled('type') || request()->query('type') == '') {
										$aClass = ' active';
										$spanClass = 'text-bg-danger';
									}
								} else {
									$aClass = ' active';
									$spanClass = 'text-bg-danger';
								}
							?>
							<li class="nav-item">
								<span class="fs-6">
									<a href="<?php echo request()->fullUrlWithoutQuery(['page', 'type']); ?>" class="nav-link<?php echo e($aClass); ?>">
										<?php echo e(t('all_listings')); ?> <span class="badge <?php echo $spanClass; ?>"><?php echo e(data_get($count, '0')); ?></span>
									</a>
								</span>
							</li>
							<?php if(config('settings.listing_form.show_listing_type')): ?>
								<?php if(!empty($postTypes)): ?>
									<?php $__currentLoopData = $postTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $postType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php
											$postTypeId = data_get($postType, 'id');
											$postTypeUrl = request()->fullUrlWithQuery(['type' => $postTypeId, 'page' => null]);
											$postTypeCount = data_get($count, $postTypeId) ?? 0;
											$isSelectedPostType = (request()->filled('type') && request()->query('type') == $postTypeId);
										?>
										<?php if($isSelectedPostType): ?>
											<li class="nav-item">
												<span class="fs-6">
													<a href="<?php echo $postTypeUrl; ?>" class="nav-link active fw-bold">
														<?php echo e(data_get($postType, 'label')); ?>

														<span class="badge text-bg-danger <?php echo e($hideInLineFromMd); ?>">
															<?php echo e($postTypeCount); ?>

														</span>
													</a>
												</span>
											</li>
										<?php else: ?>
											<li class="nav-item">
												<span class="fs-6">
													<a href="<?php echo $postTypeUrl; ?>" class="nav-link">
														<?php echo e(data_get($postType, 'label')); ?>

														<span class="badge text-bg-secondary <?php echo e($hideInLineFromMd); ?>">
															<?php echo e($postTypeCount); ?>

														</span>
													</a>
												</span>
											</li>
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							<?php endif; ?>
						</ul>
						
						
						<div class="container bg-body py-3 border border-top-0">
							<div class="row">
								<div class="col-12 d-flex align-items-center justify-content-between">
									<h4 class="mb-0 fs-6 breadcrumb-list clearfix">
										<?php echo (isset($htmlTitle)) ? $htmlTitle : ''; ?>

									</h4>
									
									<?php if(!empty(request()->all())): ?>
										<div>
											<a class="<?php echo e(linkClass()); ?>" href="<?php echo urlGen()->searchWithoutQuery(); ?>">
												<i class="bi bi-x-lg"></i> <?php echo e(t('Clear all')); ?>

											</a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						
						
						<div class="col-sm-12 px-1 py-2 bg-body-tertiary border border-top-0">
							<ul class="list-inline m-0 p-0 text-end">
								
								<?php if(config('settings.listings_list.left_sidebar')): ?>
									<li class="list-inline-item px-2 d-inline-block d-sm-inline-block d-md-none">
										<a href="#"
										   class="text-uppercase <?php echo e(linkClass()); ?> navbar-toggler"
										   data-bs-toggle="offcanvas"
										   data-bs-target="#mobileSidebar"
										   aria-controls="mobileSidebar"
										   aria-label="Toggle navigation"
										>
											<i class="fa-solid fa-bars"></i> <?php echo e(t('Filters')); ?>

										</a>
									</li>
								<?php endif; ?>
								
								
								<li class="list-inline-item px-2">
									<div class="dropdown">
										<a href="#" class="dropdown-toggle text-uppercase <?php echo e(linkClass()); ?>" data-bs-toggle="dropdown" aria-expanded="false">
											<?php echo e(t('Sort by')); ?>

										</a>
										<ul class="dropdown-menu">
											<?php if(!empty($orderByOptions)): ?>
												<?php $__currentLoopData = $orderByOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<?php if(data_get($option, 'condition')): ?>
														<?php
															$optionUrl = request()->fullUrlWithQuery((array)data_get($option, 'query'));
															
															$optionParams = urlQuery($optionUrl)->getAllParameters();
															$optionParams = collect($optionParams)->sortKeys()->toArray();
															$currentParams = urlQuery(request()->fullUrl())->getAllParameters();
															$currentParams = collect($currentParams)->sortKeys()->toArray();
															
															$activeClass = ($optionParams == $currentParams) ? ' active' : '';
														?>
														<li>
															<a href="<?php echo $optionUrl; ?>" class="dropdown-item<?php echo e($activeClass); ?>" rel="nofollow">
																<?php echo e(data_get($option, 'label')); ?>

															</a>
														</li>
													<?php endif; ?>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php endif; ?>
										</ul>
									</div>
								</li>
								
								
								<?php if(!empty($posts) && $totalPosts > 0): ?>
									<li class="list-inline-item px-2">
										<div class="d-flex justify-content-center">
											<?php if(!empty($displayModes)): ?>
												<?php $__currentLoopData = $displayModes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $displayMode => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<span class="ms-1 grid-view<?php echo e(($selectedDisplayMode == $displayMode) ? ' active' : ''); ?>">
														<?php if($selectedDisplayMode == $displayMode): ?>
															<i class="<?php echo e(data_get($value, 'icon')); ?>"></i>
														<?php else: ?>
															<?php
																$displayModeUrl = request()->fullUrlWithQuery((array)data_get($value, 'query'));
															?>
															<a href="<?php echo $displayModeUrl; ?>" class="<?php echo e(linkClass()); ?>" rel="nofollow">
																<i class="<?php echo e(data_get($value, 'icon')); ?>"></i>
															</a>
														<?php endif; ?>
													</span>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php endif; ?>
										</div>
									</li>
								<?php endif; ?>
							</ul>
						</div>
						
						
						<div class="tab-content bg-body" id="myTabContent">
							<div class="tab-pane fade show active" id="contentAll" role="tabpanel" aria-labelledby="tabAll">
								<div class="container border border-top-0 rounded-bottom px-3">
									<?php if($selectedDisplayMode == 'list-view'): ?>
										<?php echo $__env->make('front.search.partials.posts.template.list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
									<?php elseif($selectedDisplayMode == 'compact-view'): ?>
										<?php echo $__env->make('front.search.partials.posts.template.compact', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
									<?php else: ?>
										<?php echo $__env->make('front.search.partials.posts.template.grid', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
						
						
						<?php
							$keyword = request()->query('q');
							$searchCanBeSaved = (!empty($keyword) && data_get($count, '0') > 0);
						?>
						<?php if($searchCanBeSaved): ?>
							<div class="container border-bottom py-2 mt-3 border rounded fs-5 fw-bold text-center">
								<a id="saveSearch"
								   href=""
								   data-search-url="<?php echo request()->fullUrlWithoutQuery(['_token', 'location']); ?>"
								   data-results-count="<?php echo e(data_get($count, '0')); ?>"
								   class="<?php echo e(linkClass()); ?>"
								>
									<i class="bi bi-bell"></i> <?php echo e(t('Save Search')); ?>

								</a>
							</div>
						<?php endif; ?>
					</div>
					
					
					<nav class="mt-3 mb-0 pagination-sm" aria-label="">
						<?php echo $__env->make('vendor.pagination.api.bootstrap-4', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					</nav>
					
				</div>
			</div>
		</div>
		
		
		<?php echo $__env->make('front.layouts.partials.advertising.bottom', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
		
		<?php echo $__env->make('front.search.partials.call-to-action', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
		
		<?php echo $__env->make('front.search.partials.category-description', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
		
		<?php echo $__env->make('front.search.partials.tags', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
	</div>
	
	<?php echo $__env->renderWhen(!auth()->check(), 'auth.login.partials.modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal_location'); ?>
	<?php echo $__env->make('front.layouts.partials.modal.location', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script>
		onDocumentReady((event) => {
			
			const postTypeEl = document.querySelectorAll('#postType a');
			if (postTypeEl.length > 0) {
				postTypeEl.forEach((element) => {
					element.addEventListener('click', (event) => {
						event.preventDefault();
						
						let goToUrl = event.target.getAttribute('href');
						redirect(goToUrl);
					});
				});
			}
		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/search/results.blade.php ENDPATH**/ ?>