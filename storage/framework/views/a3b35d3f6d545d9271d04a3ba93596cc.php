<?php
	use App\Enums\BootstrapColor;
	use Illuminate\Support\Number;
	
	$posts ??= [];
	$totalPosts ??= 0;
	
	$city ??= null;
	$cat ??= null;
	
	$defaultCols = 4;
	$lgCols = (int)config('settings.listings_list.grid_view_cols', $defaultCols);
	$lgCols = Number::clamp($lgCols, min: 2, max: 4);
	$mdCols = ($lgCols >= 3) ? 3 : $lgCols;
	$smCols = ($lgCols >= 2) ? 2 : $lgCols;
?>
<?php if(!empty($posts) && $totalPosts > 0): ?>
	<div class="row row-cols-lg-<?php echo e($lgCols); ?> row-cols-md-<?php echo e($mdCols); ?> row-cols-<?php echo e($smCols); ?> py-1 grid-view">
		<?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="col item-list d-flex align-items-center px-0 my-1">
				<div class="h-100 w-100 border rounded p-2 pt-1 mx-1 hover-shadow">
					<?php
						$picturePath = data_get($post, 'picture.file_path');
						$pictureAttr = [
							'class' => 'lazyload img-fluid w-100 h-auto rounded',
							//'style' => 'max-width: 300px; max-height: 200px; width: auto; height: 200px;',
						];
						
						$postUrl = urlGen()->post($post);
						$parentCatUrl = null;
						if (!empty(data_get($post, 'category.parent'))) {
							$parentCatUrl = urlGen()->category(data_get($post, 'category.parent'), null, $city);
						}
						$catUrl = urlGen()->category(data_get($post, 'category'), null, $city);
						$locationUrl = urlGen()->city(data_get($post, 'city'), null, $cat);
					?>
					
					<div class="row h-100 d-flex flex-column justify-content-between">
						<div class="col-12 p-0 mx-0">
							<div class="row">
								
								<div class="col-12 d-flex justify-content-center p-0 main-image">
									<div class="container mx-2 position-relative">
										<?php if(data_get($post, 'featured') == 1): ?>
											<?php if(!empty(data_get($post, 'payment.package'))): ?>
												<?php if(data_get($post, 'payment.package.ribbon') != ''): ?>
													<?php
														$ribbonColor = data_get($post, 'payment.package.ribbon');
														$ribbonColorClass = BootstrapColor::Badge->getColorClass($ribbonColor);
														$packageShortName = data_get($post, 'payment.package.short_name');
													?>
													<span class="badge rounded-pill <?php echo e($ribbonColorClass); ?> position-absolute mt-2 ms-2">
														<?php echo e($packageShortName); ?>

													</span>
												<?php endif; ?>
											<?php endif; ?>
										<?php endif; ?>
										
										<div class="position-absolute top-0 end-0 mt-2 me-3 bg-body-secondary opacity-75 rounded px-1">
											<i class="fa-solid fa-camera"></i> <?php echo e(data_get($post, 'count_pictures')); ?>

										</div>
										
										<a href="<?php echo e($postUrl); ?>">
											<?php
												$src = data_get($post, 'picture.url.medium');
												$webpSrc = data_get($post, 'picture.url.webp.medium');
												$alt = str(data_get($post, 'title'))->slug();
												echo generateImageHtml($src, $alt, $webpSrc, $pictureAttr);
											?>
										</a>
									</div>
								</div>
								
								
								<div class="col-12 mt-3">
									<div class="px-3">
										
										<h5 class="fs-5 fw-normal px-0">
											<a href="<?php echo e($postUrl); ?>" class="<?php echo e(linkClass('body-emphasis')); ?>">
												<?php echo e(str(data_get($post, 'title'))->limit(70)); ?>

											</a>
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
															<div class="list-inline-item">
																<span class="badge rounded-pill text-bg-secondary fw-normal"
																      data-bs-toggle="tooltip"
																      data-bs-placement="bottom"
																      title="<?php echo e(data_get($post, 'postType.label')); ?>"
																>
																	<?php echo e(strtoupper(mb_substr(data_get($post, 'postType.label'), 0, 1))); ?>

																</span>
															</div>
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
									</div>
								</div>
							</div>
						</div>
						
						
						<div class="col-12">
							<div class="row">
								
								<?php if(config('plugins.reviews.installed')): ?>
									<?php if(view()->exists('reviews::ratings-list')): ?>
										<div class="col-12 px-3 text-center mb-2">
											<?php echo $__env->make('reviews::ratings-list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										</div>
									<?php endif; ?>
								<?php endif; ?>
								
								<div class="col-12 text-end">
									<h5 class="fs-4 fw-bold">
										<?php echo data_get($post, 'price_formatted'); ?>

									</h5>
								</div>
								
								<div class="col-12 text-end">
									<?php if(!empty(data_get($post, 'payment.package'))): ?>
										<?php if(data_get($post, 'payment.package.has_badge') == 1): ?>
											<a class="btn btn-danger btn-xs small me-1 make-favorite">
												<i class="fa-solid fa-certificate"></i> <span><?php echo e(data_get($post, 'payment.package.short_name')); ?></span>
											</a>
										<?php endif; ?>
									<?php endif; ?>
									<?php
										$postId = data_get($post, 'id');
										$savedByLoggedUser = (bool)data_get($post, 'p_saved_by_logged_user');
									?>
									<?php if($savedByLoggedUser): ?>
										<a class="btn btn-success btn-xs small make-favorite" id="<?php echo e($postId); ?>">
											<i class="bi bi-heart-fill small"></i> <span><?php echo e(t('Saved')); ?></span>
										</a>
									<?php else: ?>
										<a class="btn btn-outline-secondary btn-xs small make-favorite" id="<?php echo e($postId); ?>">
											<i class="bi bi-heart small"></i> <span><?php echo e(t('Save')); ?></span>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
<?php else: ?>
	<div class="py-5 text-center w-100">
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
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/posts/template/grid.blade.php ENDPATH**/ ?>