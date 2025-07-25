<?php
	$widget ??= [];
	$posts = (array)data_get($widget, 'posts');
	$totalPosts = (int)data_get($widget, 'totalPosts', 0);
	
	$sectionOptions ??= [];
	$hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' d-none d-md-block' : '';
	$carouselEl = 'carousel-' . createRandomString(6);
	
	$isFromHome ??= false;
	
	$isReviewsAddonInstalled = config('plugins.reviews.installed');
	$itemHeight = $isReviewsAddonInstalled ? 340 : 320;
	$itemStyle = ' style="height:' . $itemHeight . 'px;"';
	$titleClass = $isReviewsAddonInstalled ? ' fs-6 fw-bold' : ' fs-5';
	$titleLimit = $isReviewsAddonInstalled ? 48 : 42;
?>
<?php if($totalPosts > 0): ?>
	<?php if($isFromHome): ?>
		<?php echo $__env->make('front.sections.spacer', ['hideOnMobile' => $hideOnMobile], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php endif; ?>
	<div class="container<?php echo e($hideOnMobile); ?>">
		<div class="card">
			<div class="card-header border-bottom-0">
				<h4 class="mb-0 float-start fw-lighter">
					<?php echo data_get($widget, 'title'); ?>

				</h4>
				<h5 class="mb-0 float-end mt-1 fs-6 fw-lighter text-uppercase">
					<a href="<?php echo e(data_get($widget, 'link')); ?>" class="<?php echo e(linkClass()); ?>">
						<?php echo e(t('View more')); ?> <i class="fa-solid fa-bars"></i>
					</a>
				</h5>
			</div>
			
			<div class="card-body rounded p-3">
				<div class="m-0 featured-list-slider <?php echo e($carouselEl); ?> owl-carousel owl-theme">
					<?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$postUrl = urlGen()->post($post);
						?>
						<div class="card me-2 p-0 d-flex justify-content-between flex-column item hover-bg-tertiary"<?php echo $itemStyle; ?>>
							
							<div class="w-100 m-0 position-relative item-carousel-thumb">
								<div class="position-absolute top-0 end-0 mt-2 me-2 bg-body-secondary opacity-75 rounded px-1">
									<i class="fa-solid fa-camera"></i> <?php echo e(data_get($post, 'count_pictures')); ?>

								</div>
								<a href="<?php echo e($postUrl); ?>" class="<?php echo e(linkClass('body-emphasis')); ?>">
									<?php
										$src = data_get($post, 'picture.url.medium');
										$webpSrc = data_get($post, 'picture.url.webp.medium');
										$alt = str(data_get($post, 'title'))->slug();
										$attr = ['class' => 'lazyload img-fluid rounded-top'];
										echo generateImageHtml($src, $alt, $webpSrc, $attr);
									?>
								</a>
							</div>
							
							<div class="card-body h-100 d-flex justify-content-between flex-column">
								
								<h6 class="mb-0<?php echo e($titleClass); ?> px-0 text-center text-break">
									<a href="<?php echo e($postUrl); ?>" class="<?php echo e(linkClass()); ?>">
										<?php echo e(str(data_get($post, 'title'))->limit($titleLimit)); ?>

									</a>
									<?php echo $__env->make('front.layouts.partials.lost-found-badge', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
								</h6>
								
								<div class="d-flex flex-column">
									
									<?php if($isReviewsAddonInstalled): ?>
										<div class="text-center">
											<?php if(view()->exists('reviews::ratings-list')): ?>
												<?php echo $__env->make('reviews::ratings-list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
											<?php endif; ?>
										</div>
									<?php endif; ?>
									
									
								</div>
							</div>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php $__env->startSection('after_style'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_style'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		onDocumentReady((event) => {
			
			let isRTLEnabled = (document.documentElement.getAttribute('dir') === 'rtl');
			
			
			
			let carouselItems = <?php echo e($totalPosts ?? 0); ?>;
			let carouselAutoplay = <?php echo e(data_get($sectionOptions, 'autoplay') ?? 'false'); ?>;
			let carouselAutoplayTimeout = <?php echo e((int)(data_get($sectionOptions, 'autoplay_timeout') ?? 1500)); ?>;
			let carouselLang = {
				'navText': {
					'prev': "<?php echo e(t('prev')); ?>",
					'next': "<?php echo e(t('next')); ?>"
				}
			};
			
			
			let carouselObject = $('.featured-list-slider.<?php echo e($carouselEl); ?>');
			let responsiveObject = {
				0: {
					items: 1,
					nav: true
				},
				576: {
					items: 2,
					nav: false
				},
				768: {
					items: 3,
					nav: false
				},
				992: {
					items: 5,
					nav: false,
					loop: (carouselItems > 5)
				}
			};
			carouselObject.owlCarousel({
				rtl: isRTLEnabled,
				nav: false,
				navText: [carouselLang.navText.prev, carouselLang.navText.next],
				loop: true,
				responsiveClass: true,
				responsive: responsiveObject,
				autoWidth: true,
				autoplay: carouselAutoplay,
				autoplayTimeout: carouselAutoplayTimeout,
				autoplayHoverPause: true
			});
			
			
			
			const elements = document.querySelectorAll('.featured-list-slider .card-body > h6');
			if (elements.length) {
				const animation = 'animate__pulse';
				
				elements.forEach((element) => {
					element.addEventListener('mouseover', (event) => {
						event.target.classList.add('animate__animated', animation);
					});
					element.addEventListener("mouseout", (event) => {
						event.target.classList.remove('animate__animated', animation);
					});
				})
			}
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/posts/widget/carousel.blade.php ENDPATH**/ ?>