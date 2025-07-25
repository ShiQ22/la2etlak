<?php
	use App\Enums\BootstrapColor;
	
	$posts ??= [];
	$totalPosts ??= 0;
	
	$city ??= null;
	$cat ??= null;
?>
<?php if(!empty($posts) && $totalPosts > 0): ?>
	<div class="container px-0 pt-3 compact-view">
		<?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php
				$postUrl = urlGen()->post($post);
				$parentCatUrl = null;
				if (!empty(data_get($post, 'category.parent'))) {
					$parentCatUrl = urlGen()->category(data_get($post, 'category.parent'), null, $city);
				}
				$catUrl = urlGen()->category(data_get($post, 'category'), null, $city);
				$locationUrl = urlGen()->city(data_get($post, 'city'), null, $cat);
				
				$borderBottom = !$loop->last ? ' border-bottom pb-3' : '';
			?>
			<div class="row<?php echo e($borderBottom); ?> mb-3 d-flex align-items-stretch item-list item-list">
				<div class="col-sm-9 col-12">
					<div class="items-details">
						
						<h5 class="fs-5 fw-normal px-0">
							<?php if(data_get($post, 'featured') == 1): ?>
								<?php if(!empty(data_get($post, 'payment.package'))): ?>
									<?php if(data_get($post, 'payment.package.ribbon') != ''): ?>
										<?php
											$ribbonColor = data_get($post, 'payment.package.ribbon');
											$ribbonColorClass = BootstrapColor::Badge->getColorClass($ribbonColor);
											$packageShortName = data_get($post, 'payment.package.short_name');
										?>
										<span class="badge rounded-pill <?php echo e($ribbonColorClass); ?>">
											<?php echo e($packageShortName); ?>

										</span>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>
							
							<a href="<?php echo e($postUrl); ?>" class="link-body-emphasis text-decoration-none">
								<?php echo e(str(data_get($post, 'title'))->limit(70)); ?>

							</a>
							<?php echo $__env->make('front.layouts.partials.lost-found-badge', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
						</h5>
						
						
						<?php
							$showPostInfo = (
								(!config('settings.listings_list.hide_post_type') && config('settings.listing_form.show_listing_type'))
								|| !config('settings.listings_list.hide_date')
								|| !config('settings.listings_list.hide_category')
								|| !config('settings.listings_list.hide_location')
							);
						?>
						<?php if($showPostInfo): ?>
							<div class="container px-0 text-secondary">
								<ul class="list-inline mb-0">
									<?php if(
										!config('settings.listings_list.hide_post_type')
										&& config('settings.listing_form.show_listing_type')
									): ?>
										<?php if(!empty(data_get($post, 'postType'))): ?>
											<li class="list-inline-item">
												<span class="badge rounded-pill text-bg-secondary fw-normal"
												      data-bs-toggle="tooltip"
												      data-bs-placement="bottom"
												      title="<?php echo e(data_get($post, 'postType.label')); ?>"
												>
													<?php echo e(strtoupper(mb_substr(data_get($post, 'postType.label'), 0, 1))); ?>

												</span>
											</li>
										<?php endif; ?>
									<?php endif; ?>
									<?php if(!config('settings.listings_list.hide_date')): ?>
										<li class="list-inline-item"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
											<i class="fa-regular fa-clock"></i> <?php echo data_get($post, 'created_at_formatted'); ?>

										</li>
									<?php endif; ?>
									<?php if(!config('settings.listings_list.hide_category')): ?>
										<li class="list-inline-item"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
											<i class="bi bi-folder"></i>&nbsp;
											<?php if(!empty(data_get($post, 'category.parent'))): ?>
												<a href="<?php echo $parentCatUrl; ?>" class="<?php echo e(linkClass()); ?>">
													<?php echo e(data_get($post, 'category.parent.name')); ?>

												</a>&nbsp;&raquo;&nbsp;
											<?php endif; ?>
											<a href="<?php echo $catUrl; ?>" class="<?php echo e(linkClass()); ?>">
												<?php echo e(data_get($post, 'category.name')); ?>

											</a>
										</li>
									<?php endif; ?>
									<?php if(!config('settings.listings_list.hide_location')): ?>
										<li class="list-inline-item"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
											<i class="bi bi-geo-alt"></i>&nbsp;
											<a href="<?php echo $locationUrl; ?>" class="<?php echo e(linkClass()); ?>">
												<?php echo e(data_get($post, 'city.name')); ?>

											</a> <?php echo e(data_get($post, 'distance_info')); ?>

										</li>
									<?php endif; ?>
								</ul>
							</div>
						<?php endif; ?>
						
						
						<?php if(config('plugins.reviews.installed')): ?>
							<?php if(view()->exists('reviews::ratings-list')): ?>
								<?php echo $__env->make('reviews::ratings-list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="col-sm-3 col-12 text-end text-nowrap d-flex flex-column justify-content-between">
    
    <div>
        <?php if(!empty(data_get($post, 'payment.package'))): ?>
            <?php if(data_get($post, 'payment.package.has_badge') == 1): ?>
                <a class="btn btn-danger btn-xs small make-favorite">
                    <i class="fa-solid fa-certificate"></i> <span><?php echo e(data_get($post, 'payment.package.short_name')); ?></span>
                </a>&nbsp;
            <?php endif; ?>
        <?php endif; ?>
        <?php
            $postId = data_get($post, 'id');
            $savedByLoggedUser = (bool)data_get($post, 'p_saved_by_logged_user');
        ?>
        <?php if($savedByLoggedUser): ?>
            <a class="btn btn-success btn-xs small make-favorite" id="<?php echo e($postId); ?>">
                <i class="bi bi-heart-fill"></i> <span><?php echo e(t('Saved')); ?></span>
            </a>
        <?php else: ?>
            <a class="btn btn-outline-secondary btn-xs small make-favorite" id="<?php echo e($postId); ?>">
                <i class="bi bi-heart"></i> <span><?php echo e(t('Save')); ?></span>
            </a>
        <?php endif; ?>
    </div>
</div>

			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
<?php else: ?>
	<div class="p-4" style="width: 100%;">
		<?php echo e(t('no_result_refine_your_search')); ?>

	</div>
<?php endif; ?>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		
		var lang = {
			labelSavePostSave: "<?php echo t('Save listing'); ?>",
			labelSavePostRemove: "<?php echo t('Remove favorite'); ?>",
			loginToSavePost: "<?php echo t('Please log in to save the Listings'); ?>",
			loginToSaveSearch: "<?php echo t('Please log in to save your search'); ?>"
		};
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/posts/template/compact.blade.php ENDPATH**/ ?>