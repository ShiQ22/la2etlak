<?php
	$isPriceFilterCanBeDisplayed = (!empty($cat) && data_get($cat, 'type') != 'not-salable');
	$prefixId ??= '';
	
	// Clear Filter Button
	$clearFilterBtn = urlGen()->getPriceFilterClearLink($cat ?? null, $city ?? null);
?>
<?php if($isPriceFilterCanBeDisplayed): ?>
	
	<div class="container p-0 vstack gap-2">
		<h5 class="border-bottom pb-2 d-flex justify-content-between">
			<span class="fw-bold">
				<?php echo e((!in_array(data_get($cat, 'type'), ['job-offer', 'job-search'])) ? t('price_range') : t('salary_range')); ?>

			</span> <?php echo $clearFilterBtn; ?>

		</h5>
		<div>
			<form action="<?php echo e(request()->url()); ?>" method="GET" role="form">
				<?php $__currentLoopData = request()->except(['page', 'minPrice', 'maxPrice', '_token']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if(is_array($value)): ?>
						<?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(is_array($v)): ?>
								<?php $__currentLoopData = $v; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ik => $iv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if(is_array($iv)) continue; ?>
									<input type="hidden" name="<?php echo e($key.'['.$k.']['.$ik.']'); ?>" value="<?php echo e($iv); ?>">
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?>
								<input type="hidden" name="<?php echo e($key.'['.$k.']'); ?>" value="<?php echo e($v); ?>">
							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php else: ?>
						<input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
					<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<div class="row px-0 gx-1 gy-1">
					<div class="col-12 mb-3 number-range-slider price-range" id="<?php echo e($prefixId); ?>priceRangeSlider"></div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<input type="number"
						       min="0"
						       id="<?php echo e($prefixId); ?>minPrice"
						       name="minPrice"
						       class="form-control"
						       placeholder="<?php echo e(t('Min')); ?>"
						       value="<?php echo e(request()->query('minPrice')); ?>"
						>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<input type="number"
						       min="0"
						       id="<?php echo e($prefixId); ?>maxPrice"
						       name="maxPrice"
						       class="form-control"
						       placeholder="<?php echo e(t('Max')); ?>"
						       value="<?php echo e(request()->query('maxPrice')); ?>"
						>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12 d-grid">
						<button class="btn btn-secondary" type="submit"><?php echo e(t('go')); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php endif; ?>



<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<?php if($isPriceFilterCanBeDisplayed): ?>
		<link href="<?php echo e(url('assets/plugins/noUiSlider/15.5.0/nouislider.css')); ?>" rel="stylesheet">
		<style>
			/* Hide Arrows From Input Number */
			/* Chrome, Safari, Edge, Opera */
			.number-range-slider-wrapper input::-webkit-outer-spin-button,
			.number-range-slider-wrapper input::-webkit-inner-spin-button {
				-webkit-appearance: none;
				margin: 0;
			}
			/* Firefox */
			.number-range-slider-wrapper input[type=number] {
				-moz-appearance: textfield;
			}
		</style>
	<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<?php if($isPriceFilterCanBeDisplayed): ?>
		<script src="<?php echo e(url('assets/plugins/noUiSlider/15.5.0/nouislider.js')); ?>"></script>
		<?php
			$minPrice = (int)config('settings.listings_list.min_price', 0);
			$maxPrice = (int)config('settings.listings_list.max_price', 10000);
			$priceSliderStep = (int)config('settings.listings_list.price_slider_step', 50);
			
			$startPrice = (int)request()->query('minPrice', $minPrice);
			$endPrice = (int)request()->query('maxPrice', $maxPrice);
		?>
		<script>
			onDocumentReady((event) => {
				const prefixId = '<?php echo e($prefixId); ?>';
				let minPrice = <?php echo e($minPrice); ?>;
				let maxPrice = <?php echo e($maxPrice); ?>;
				let priceSliderStep = <?php echo e($priceSliderStep); ?>;
				
				
				let startPrice = <?php echo e($startPrice); ?>;
				let endPrice = <?php echo e($endPrice); ?>;
				
				let priceRangeSliderEl = document.getElementById(`${prefixId}priceRangeSlider`);
				noUiSlider.create(priceRangeSliderEl, {
					connect: true,
					start: [startPrice, endPrice],
					step: priceSliderStep,
					keyboardSupport: true,     			 /* Default true */
					keyboardDefaultStep: 5,    			 /* Default 10 */
					keyboardPageMultiplier: 5, 			 /* Default 5 */
					keyboardMultiplier: priceSliderStep, /* Default 1 */
					range: {
						'min': minPrice,
						'max': maxPrice
					}
				});
				
				let minPriceEl = document.getElementById(`${prefixId}minPrice`);
				let maxPriceEl = document.getElementById(`${prefixId}maxPrice`);
				
				priceRangeSliderEl.noUiSlider.on('update', (values, handle) => {
					let value = values[handle];
					
					if (handle) {
						maxPriceEl.value = Math.round(value);
					} else {
						minPriceEl.value = Math.round(value);
					}
				});
				minPriceEl.addEventListener('change', (e) => {
					priceRangeSliderEl.noUiSlider.set([e.target.value, null]);
				});
				maxPriceEl.addEventListener('change', (e) => {
					if (e.target.value <= maxPrice) {
						priceRangeSliderEl.noUiSlider.set([null, e.target.value]);
					}
				});
			});
		</script>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/sidebar/price.blade.php ENDPATH**/ ?>