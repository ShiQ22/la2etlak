<?php use App\Enums\BootstrapColor; ?>


<?php
	$post ??= [];
	$catBreadcrumb ??= [];
	$topAdvertising ??= [];
	$bottomAdvertising ??= [];
?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('front.common.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php
		$paddingTopExists = true;
	?>
	
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
		<?php
			session()->forget('flash_notification.message');
		?>
	<?php endif; ?>
	
	<?php
		$withMessage = !session()->has('flash_notification');
		$resendVerificationLink = getResendVerificationLink(withMessage: $withMessage);
	?>
	<?php if(!empty($resendVerificationLink)): ?>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="alert alert-info text-center">
						<?php echo $resendVerificationLink; ?>

					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	
	<?php if(!empty(data_get($post, 'archived_at'))): ?>
		<?php echo $__env->make('front.common.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		<?php
			$paddingTopExists = true;
		?>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="alert alert-warning" role="alert">
						<?php echo t('This listing has been archived'); ?>

					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<div class="main-container">
		
		<?php if(!empty($topAdvertising)): ?>
			<?php echo $__env->make('front.layouts.partials.advertising.top', ['paddingTopExists' => $paddingTopExists ?? false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php
				$paddingTopExists = false;
			?>
		<?php endif; ?>
		
		<div class="container <?php echo e(!empty($topAdvertising) ? 'mt-3' : 'mt-2'); ?>">
			<div class="row">
				<div class="col-md-12">
					
					<nav aria-label="breadcrumb" role="navigation" class="float-start">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="<?php echo e(url('/')); ?>" class="<?php echo e(linkClass()); ?>">
									<i class="fa-solid fa-house"></i>
								</a>
							</li>
							<li class="breadcrumb-item">
								<a href="<?php echo e(url('/')); ?>" class="<?php echo e(linkClass()); ?>">
									<?php echo e(config('country.name')); ?>

								</a>
							</li>
							<?php if(is_array($catBreadcrumb) && count($catBreadcrumb) > 0): ?>
								<?php $__currentLoopData = $catBreadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li class="breadcrumb-item">
										<a href="<?php echo e($value->get('url')); ?>" class="<?php echo e(linkClass()); ?>">
											<?php echo $value->get('name'); ?>

										</a>
									</li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
							<li class="breadcrumb-item active" aria-current="page">
								<?php echo e(str(data_get($post, 'title'))->limit(70)); ?>

							</li>
						</ol>
					</nav>
					
					<div class="float-end">
						<a href="<?php echo e(rawurldecode(url()->previous())); ?>" class="<?php echo e(linkClass()); ?>">
							<i class="fa-solid fa-angles-left"></i> <?php echo e(t('back_to_results')); ?>

						</a>
					</div>
				
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="row">
				
				<div class="col-lg-9">
					<?php
						$overflowStyle = (!auth()->check() && plugin_exists('reviews')) ? 'overflow: visible;' : '';
					?>
					<div class="container border rounded bg-body-tertiary px-3 pt-2 pb-3 mb-sm-3 items-details-wrapper" style="<?php echo e($overflowStyle); ?>">
						
						<div class="clearfix">
							<h1 class="fs-3 fw-bold text-wrap float-start">
								<a href="<?php echo e(urlGen()->post($post)); ?>"
								   class="<?php echo e(linkClass()); ?>"
								   title="<?php echo e(data_get($post, 'title')); ?>"
								>
									<?php echo e(data_get($post, 'title')); ?>

									<?php echo $__env->make('front.layouts.partials.lost-found-badge', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
								</a>
								
								<?php if(data_get($post, 'featured') == 1 && !empty(data_get($post, 'payment.package'))): ?>
									<?php
										$ribbonColor = data_get($post, 'payment.package.ribbon');
										$ribbonColorClass = BootstrapColor::Text->getColorClass($ribbonColor);
										$packageShortName = data_get($post, 'payment.package.short_name');
									?>
									<i class="fa-solid fa-check-circle <?php echo e($ribbonColorClass); ?>"
									   data-bs-placement="bottom"
									   data-bs-toggle="tooltip"
									   title="<?php echo e($packageShortName); ?>"
									></i>
								<?php endif; ?>
							</h1>
							<?php if(config('settings.listing_form.show_listing_type')): ?>
								<?php if(!empty(data_get($post, 'postType'))): ?>
									<span class="badge rounded-pill text-bg-dark float-end mt-2">
										<?php echo e(data_get($post, 'postType.label')); ?>

									</span>
								<?php endif; ?>
							<?php endif; ?>
						</div>
						
						
						<div class="border-top py-2 mt-0 text-secondary d-flex justify-content-between">
							<ul class="list-inline mb-0">
								<?php if(!config('settings.listing_page.hide_date')): ?>
									<li class="list-inline-item"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
										<i class="fa-regular fa-clock"></i> <?php echo data_get($post, 'created_at_formatted'); ?>

									</li>
								<?php endif; ?>
								<li class="list-inline-item"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
									<i class="bi bi-folder"></i> <?php echo e(data_get($post, 'category.parent.name', data_get($post, 'category.name'))); ?>

								</li>
								<li class="list-inline-item"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
									<i class="bi bi-geo-alt"></i> <?php echo e(data_get($post, 'city.name')); ?>

								</li>
								<li class="list-inline-item"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
									<i class="bi bi-eye"></i> <?php echo e(data_get($post, 'visits_formatted')); ?>

								</li>
							</ul>
							<div class="text-nowrap"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
								<?php echo e(t('reference')); ?>: <?php echo e(data_get($post, 'reference')); ?>

							</div>
						</div>
						
						
						<?php echo $__env->make('front.post.show.partials.pictures-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
						
						
						<?php if(config('plugins.reviews.installed')): ?>
							<?php if(view()->exists('reviews::ratings-single')): ?>
								<?php echo $__env->make('reviews::ratings-single', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							<?php endif; ?>
						<?php endif; ?>
						
						
						<?php echo $__env->make('front.post.show.partials.details', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					</div>
				</div>
				
				
				<div class="col-lg-3">
					<?php echo $__env->make('front.post.show.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				</div>
			</div>

		</div>
		
		<?php if(config('settings.listing_page.similar_listings') == '1' || config('settings.listing_page.similar_listings') == '2'): ?>
			<?php
				$widgetType = (config('settings.listing_page.similar_listings_in_carousel') ? 'carousel' : 'normal');
			?>
			<?php echo $__env->make('front.search.partials.posts.widget.' . $widgetType, [
				'widget' => ($widgetSimilarPosts ?? null), 'firstSection' => false
			], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		<?php endif; ?>
		
		<?php echo $__env->make('front.layouts.partials.advertising.bottom', ['firstSection' => false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
		<?php if(isVerifiedPost($post)): ?>
			<?php echo $__env->make('front.layouts.partials.tools.facebook-comments', ['firstSection' => false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		<?php endif; ?>
		
	</div>
	
	<?php echo $__env->renderWhen(!auth()->check(), 'auth.login.partials.modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>
<?php $__env->stopSection(); ?>
<?php
	if (!session()->has('emailVerificationSent') && !session()->has('phoneVerificationSent')) {
		if (session()->has('message')) {
			session()->forget('message');
		}
	}
?>

<?php $__env->startSection('modal_message'); ?>
	<?php if(config('settings.listing_page.show_security_tips') == '1'): ?>
		<?php echo $__env->make('front.post.show.partials.security-tips', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php endif; ?>
	<?php if(auth()->check() || config('settings.listing_page.guest_can_contact_authors') == '1'): ?>
		<?php echo $__env->make('front.account.messenger.modal.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('before_scripts'); ?>
	<script>
		var showSecurityTips = '<?php echo e(config('settings.listing_page.show_security_tips', '0')); ?>';
	</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script>
		
        var lang = {
            labelSavePostSave: "<?php echo t('Save listing'); ?>",
            labelSavePostRemove: "<?php echo t('Remove favorite'); ?>",
            loginToSavePost: "<?php echo t('Please log in to save the Listings'); ?>",
            loginToSaveSearch: "<?php echo t('Please log in to save your search'); ?>"
        };
		
		onDocumentReady((event) => {
			
			const tooltipEls = document.querySelectorAll('[rel="tooltip"]');
			if (tooltipEls) {
				let tooltipTriggerList = [].slice.call(tooltipEls);
				let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
					return new bootstrap.Tooltip(tooltipTriggerEl)
				});
			}
			
			
			const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
			if (tabEls.length > 0) {
				tabEls.forEach((tabButton) => {
					tabButton.addEventListener('shown.bs.tab', function (e) {
						/* Save the latest tab; use cookies if you like 'em better: */
						/* localStorage.setItem('lastTab', tabButton.getAttribute('href')); */
						localStorage.setItem('lastTab', tabButton.getAttribute('data-bs-target'));
					});
				});
			}
			
			
            let lastTab = localStorage.getItem('lastTab');
            if (lastTab) {
				
				let triggerEl = document.querySelector('button[data-bs-target="' + lastTab + '"]');
				if (typeof triggerEl !== 'undefined' && triggerEl !== null) {
					let tabObj = new bootstrap.Tab(triggerEl);
					if (tabObj !== null) {
						tabObj.show();
					}
				}
            }
		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/post/show/index.blade.php ENDPATH**/ ?>