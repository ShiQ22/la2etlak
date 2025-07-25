<?php
	$titleSlug ??= '';
?>

<div class="gallery-container">
	<?php if(!empty($price)): ?>
	 
	<?php endif; ?>
	<div class="swiper main-gallery">
		<div class="swiper-wrapper">
			<?php $__empty_1 = true; $__currentLoopData = $pictures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
				<div class="swiper-slide">
					<?php
						$src = data_get($image, 'url.large');
						$webpSrc = data_get($image, 'url.webp.large');
						$alt = $titleSlug . '-big-' . $key;
						echo generateImageHtml($src, $alt, $webpSrc);
					?>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
				<div class="swiper-slide">
					<img src="<?php echo e(thumbParam(config('larapen.media.picture'))->url()); ?>" alt="img" class="default-picture">
				</div>
			<?php endif; ?>
		</div>
		<div class="swiper-button-next"></div>
		<div class="swiper-button-prev"></div>
	</div>
	<div class="swiper thumbs-gallery">
		<div class="swiper-wrapper">
			<?php $__empty_1 = true; $__currentLoopData = $pictures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
				<div class="swiper-slide">
					<?php
						$src = data_get($image, 'url.small');
						$webpSrc = data_get($image, 'url.webp.small');
						$alt = $titleSlug . '-small-' . $key;
						echo generateImageHtml($src, $alt, $webpSrc);
					?>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
				<div class="swiper-slide">
					<img src="<?php echo e(thumbParam(config('larapen.media.picture'))->setOption('picture-sm')->url()); ?>"
					     alt="img"
					     class="default-picture"
					>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php $__env->startSection('after_styles'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_styles'); ?>
	<link href="<?php echo e(url('assets/plugins/swiper/7.4.1/swiper-bundle.min.css')); ?>" rel="stylesheet"/>
	<link href="<?php echo e(url('assets/plugins/swiper/7.4.1/swiper-horizontal-thumbs.css')); ?>" rel="stylesheet"/>
	<?php if(config('lang.direction') == 'rtl'): ?>
		<link href="<?php echo e(url('assets/plugins/swiper/7.4.1/swiper-horizontal-thumbs-rtl.css')); ?>" rel="stylesheet"/>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script src="<?php echo e(url('assets/plugins/swiper/7.4.1/swiper-bundle.min.js')); ?>"></script>
	<script>
		onDocumentReady((event) => {
			let thumbsGalleryOptions = {
				slidesPerView: 2,
				spaceBetween: 5,
				freeMode: true,
				watchSlidesProgress: true,
				/* Responsive breakpoints */
				breakpoints: {
					/* when window width is >= 320px */
					320: {
						slidesPerView: 3
					},
					/* when window width is >= 576px */
					576: {
						slidesPerView: 4
					},
					/* when window width is >= 768px */
					768: {
						slidesPerView: 5
					},
					/* when window width is >= 992px */
					992: {
						slidesPerView: 6
					},
				},
				centerInsufficientSlides: true,
				direction: 'horizontal',
			};
			let thumbsGallery = new Swiper('.thumbs-gallery', thumbsGalleryOptions);
			
			let mainGalleryOptions = {
				speed: 300,
				loop: true,
				spaceBetween: 10,
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
				thumbs: {
					swiper: thumbsGallery,
				},
				autoHeight: true,
				grabCursor: true,
			};
			let mainGallery = new Swiper('.main-gallery', mainGalleryOptions);
			
			mainGallery.on('click', function (swiper, event) {
				/* console.log(swiper); */
				if (typeof swiper.clickedSlide === 'undefined') {
					return false;
				}
				
				let imgEl = swiper.clickedSlide.querySelector('img');
				if (typeof imgEl === 'undefined' || typeof imgEl.src === 'undefined') {
					return false;
				}
				
				let currentSrc = imgEl.src;
				let imgTitle = "<?php echo e(data_get($post, 'title')); ?>";
				
				let wrapperSelector = '.main-gallery .swiper-slide:not(.swiper-slide-duplicate) img:not(.default-picture)';
				let imgSrcArray = getFullSizeSrcOfAllImg(wrapperSelector, currentSrc);
				if (imgSrcArray === undefined || imgSrcArray.length === 0) {
					return false;
				}
				
				
				let swipeboxItems = formatImgSrcArrayForSwipebox(imgSrcArray, imgTitle);
				let swipeboxOptions = {
					hideBarsDelay: (1000 * 60 * 5),
					loopAtEnd: false
				};
				$.swipebox(swipeboxItems, swipeboxOptions);
			});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/post/show/partials/pictures-slider/swiper-horizontal.blade.php ENDPATH**/ ?>