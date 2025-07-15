<?php
	$post ??= [];
	$titleSlug = str(data_get($post, 'title'))->slug();
	
	$price = data_get($post, 'price_formatted');
	
	$picturesSliderPath = 'front.post.show.partials.pictures-slider.';
	$defaultPicturesSlider = 'swiper-horizontal';
	$picturesSlider = $picturesSliderPath . config('settings.listing_page.pictures_slider', $defaultPicturesSlider);
?>

<?php if(view()->exists($picturesSlider)): ?>
	<?php echo $__env->make($picturesSlider, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php else: ?>
	<?php
		$defaultPicturesSlider = $picturesSliderPath . $defaultPicturesSlider;
	?>
	<?php if(view()->exists($defaultPicturesSlider)): ?>
		<?php echo $__env->make($defaultPicturesSlider, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php endif; ?>
<?php endif; ?>

<?php $__env->startSection('after_styles'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_styles'); ?>
	<link href="<?php echo e(url('assets/plugins/swipebox/1.5.2/css/swipebox.css')); ?>" rel="stylesheet"/>
	<?php if(config('lang.direction') == 'rtl'): ?>
		<style>
			html.swipebox-html {
				overflow: hidden !important;
			}
			html.swipebox-html #swipebox-overlay {
				direction: ltr;
			}
		</style>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script src="<?php echo e(url('assets/plugins/swipebox/1.5.2/js/jquery.swipebox.js')); ?>"></script>
	<script>
		onDocumentReady((event) => {
			
			let documentBody = $(document.body);
			
			
			documentBody.on('click touchend', '#swipebox-slider .current img', function() {
				let clickedEl = $(this).get(0);
				if (clickedEl === undefined || clickedEl.nodeName === undefined) {
					return false;
				}
				
				if (strToLower(clickedEl.nodeName) === 'img') {
					$('#swipebox-next').click();
				}
				
				return false;
			});
			
			
			documentBody.on('click touchend', '#swipebox-slider .current', function() {
				let clickedEl = $(this).get(0);
				if (clickedEl === undefined || clickedEl.nodeName === undefined) {
					return false;
				}
				
				if (strToLower(clickedEl.nodeName) !== 'img') {
					$('#swipebox-close').click();
				}
			});
			
		});
		
		/**
		 * Get the swipebox items
		 *
		 * @param imgSrcArray
		 * @param title
		 * @returns {*}
		 */
		function formatImgSrcArrayForSwipebox(imgSrcArray, title = 'Title') {
			return map(imgSrcArray, function(imgSrc, index) {
				return { href:imgSrc, title:title };
			});
		}
		
		/**
		 * Get full size src of all pictures
		 *
		 * @param wrapperSelector
		 * @param currentSrc
		 * @returns {*[]}
		 */
		function getFullSizeSrcOfAllImg(wrapperSelector, currentSrc) {
			let allEl = document.querySelectorAll(wrapperSelector);
			
			let imgSrcArray = [getFullSizeSrc(currentSrc)];
			
			forEach(allEl, function(el, index) {
				if (el.src !== currentSrc) {
					imgSrcArray.push(getFullSizeSrc(el.src));
				}
			});
			
			return imgSrcArray;
		}
		
		/**
		 * Get the current picture's full size source
		 *
		 * @param imgSrc
		 * @returns {*}
		 */
		function getFullSizeSrc(imgSrc) {
			const regexList = [
				/thumbnails\/(\d+)x(\d+)-/i,
				/thumb\/(\d+)x(\d+)-/i,
				/thumb-(\d+)x(\d+)-/i 
			];
			
			for (let i = 0; i < regexList.length; i++) {
				let regex = regexList[i];
				imgSrc = imgSrc.replace(regex, '');
			}
			
			return imgSrc;
		}
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/post/show/partials/pictures-slider.blade.php ENDPATH**/ ?>