<?php
	$authUser = auth()->check() ? auth()->user() : null;
	$authUserId = !empty($authUser) ? $authUser->getAuthIdentifier() : 0;
	
	$post ??= [];
?>
<div class="items-details">
	<div class="row">
		<div class="col-12">
			
			<ul class="nav nav-tabs" id="itemsDetailsTabs" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active"
							id="item-details-tab"
							data-bs-toggle="tab"
							data-bs-target="#item-details"
							type="button"
							role="tab"
							aria-controls="item-details"
							aria-selected="true"
					>
						<span class="fs-5 fw-bold"><?php echo e(t('listing_details')); ?></span>
					</button>
				</li>
				<?php if(config('plugins.reviews.installed')): ?>
					<?php
						$reviewLabel = config('plugins.reviews.name');
					?>
					<li class="nav-item" role="presentation">
						<button class="nav-link"
								id="item-<?php echo e($reviewLabel); ?>-tab"
								data-bs-toggle="tab"
								data-bs-target="#item-<?php echo e($reviewLabel); ?>"
								type="button"
								role="tab"
								aria-controls="item-<?php echo e($reviewLabel); ?>"
								aria-selected="false"
						>
							<span class="fs-5 fw-bold">
								<?php echo e(trans('reviews::messages.Reviews')); ?> (<?php echo e(data_get($post, 'rating_count', 0)); ?>)
							</span>
						</button>
					</li>
				<?php endif; ?>
			</ul>
			
			
			<div class="tab-content border border-top-0 rounded-bottom bg-body p-3 mb-3" id="itemsDetailsTabsContent">
				<div class="tab-pane show active" id="item-details" role="tabpanel" aria-labelledby="item-details-tab" tabindex="0">
					<div class="row pb-3">
						<div class="items-details-info col-md-12 col-sm-12 col-12 text-wrap from-wysiwyg">
							
							<div class="row border-bottom pb-2 mb-3">
								
								<div class="col-md-6 col-sm-6 col-6">
									<h4 class="p-0 fs-5 fw-normal">
										<span class="fw-bold"><i class="bi bi-geo-alt"></i> <?php echo e(t('location')); ?>: </span>
										<span>
											<a href="<?php echo urlGen()->city(data_get($post, 'city')); ?>" class="<?php echo e(linkClass()); ?>">
												<?php echo e(data_get($post, 'city.name')); ?>

											</a>
										</span>
									</h4>
								</div>
								
								
								<div class="col-md-6 col-sm-6 col-6 text-end">
									<h4 class="p-0 fs-5 fw-normal">
										<span class="fw-bold">
											<?php echo e(data_get($post, 'price_label')); ?>

										</span>
										<span>
											<?php echo data_get($post, 'price_formatted'); ?>

											<?php if(data_get($post, 'negotiable') == 1): ?>
												<small class="badge rounded-pill text-bg-info"> <?php echo e(t('negotiable')); ?></small>
											<?php endif; ?>
										</span>
									</h4>
								</div>
							</div>
							
							
							<div class="row">
								<div class="col-12 detail-line-content">
									<?php echo data_get($post, 'description'); ?>

								</div>
							</div>
							
							
							<?php echo $__env->make('front.post.show.partials.details.fields-values', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							
							
							<?php if(!empty(data_get($post, 'tags'))): ?>
								<div class="row mt-3">
									<div class="col-12">
										<h4 class="p-0 my-3 fs-5"><i class="bi bi-tags"></i> <?php echo e(t('Tags')); ?>:</h4>
										<?php $__currentLoopData = data_get($post, 'tags'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iTag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<span class="d-inline-block border border-inverse bg-body-tertiary rounded-1 py-1 px-2 my-1 me-1">
												<a href="<?php echo e(urlGen()->tag($iTag)); ?>" class="<?php echo e(linkClass()); ?>">
													<?php echo e($iTag); ?>

												</a>
											</span>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div>
							<?php endif; ?>
							
							
							<?php if(empty($authUserId) || $authUserId != data_get($post, 'user_id')): ?>
								<div class="row mt-4 fs-1 text-center">
									<div class="col-4">
										<?php if(!empty($authUser)): ?>
											<?php if($authUserId == data_get($post, 'user_id')): ?>
												<a href="<?php echo e(urlGen()->editPost($post)); ?>" class="<?php echo e(linkClass()); ?>">
													<i class="fa-regular fa-pen-to-square" data-bs-toggle="tooltip" title="<?php echo e(t('Edit')); ?>"></i>
												</a>
											<?php else: ?>
												<?php echo genEmailContactBtn($post, false, true); ?>

											<?php endif; ?>
										<?php else: ?>
											<?php echo genEmailContactBtn($post, false, true); ?>

										<?php endif; ?>
									</div>
									<?php if(isVerifiedPost($post)): ?>
										<div class="col-4">
											<?php
												$postId = data_get($post, 'id');
												$savedByLoggedUser = (bool)data_get($post, 'p_saved_by_logged_user');
											?>
											<a class="make-favorite <?php echo e(linkClass()); ?>" id="<?php echo e($postId); ?>" href="javascript:void(0)">
												<?php if($savedByLoggedUser): ?>
													<i class="bi bi-heart-fill" data-bs-toggle="tooltip" title="<?php echo e(t('Remove favorite')); ?>"></i>
												<?php else: ?>
													<i class="bi bi-heart" data-bs-toggle="tooltip" title="<?php echo e(t('Save listing')); ?>"></i>
												<?php endif; ?>
											</a>
										</div>
										<div class="col-4">
											<a href="<?php echo e(urlGen()->reportPost($post)); ?>" class="<?php echo e(linkClass()); ?>">
												<i class="fa-regular fa-flag" data-bs-toggle="tooltip" title="<?php echo e(t('Report abuse')); ?>"></i>
											</a>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					
					</div>
				</div>
				
				<?php if(config('plugins.reviews.installed')): ?>
					<?php if(view()->exists('reviews::comments')): ?>
						<?php echo $__env->make('reviews::comments', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
		
		<div class="col-12">
			<div class="hstack gap-3 text-start">
				<?php if(!empty($authUser)): ?>
					<?php if($authUserId == data_get($post, 'user_id')): ?>
						<a class="btn btn-secondary" href="<?php echo e(urlGen()->editPost($post)); ?>">
							<i class="fa-regular fa-pen-to-square"></i> <?php echo e(t('Edit')); ?>

						</a>
					<?php else: ?>
						<?php echo genPhoneNumberBtn($post); ?>

						<?php echo genEmailContactBtn($post); ?>

					<?php endif; ?>
				<?php else: ?>
					<?php echo genPhoneNumberBtn($post); ?>

					<?php echo genEmailContactBtn($post); ?>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		onDocumentReady((event) => {
			/*...*/
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/post/show/partials/details.blade.php ENDPATH**/ ?>