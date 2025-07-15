<?php
	$showOnLargeScreensOnly = ' d-none d-md-block';
	$showOnMobileOnly = ' d-block d-sm-block d-md-none'; // overflow-y-auto
	
	$isPriceFilterCanBeDisplayed = (!empty($cat) && data_get($cat, 'type') != 'not-salable');
?>

<div class="col-md-3 pb-4<?php echo e($showOnLargeScreensOnly); ?>" id="leftSidebar">
	<aside>
		<div class="card">
			<div class="card-body vstack gap-4 text-wrap">
				
				<?php
					$prefixId = '';
				?>
				<?php echo $__env->make('front.search.partials.sidebar.fields', ['prefixId' => $prefixId], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				<?php echo $__env->make('front.search.partials.sidebar.categories', ['prefixId' => $prefixId], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	            <?php echo $__env->make('front.search.partials.sidebar.cities', ['prefixId' => $prefixId], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				<?php if(!config('settings.listings_list.hide_date')): ?>
					<?php echo $__env->make('front.search.partials.sidebar.date', ['prefixId' => $prefixId], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				<?php endif; ?>
				<?php echo $__env->make('front.search.partials.sidebar.price', ['prefixId' => $prefixId], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				
			</div>
		</div>
	</aside>
</div>


<div class="offcanvas offcanvas-start px-0" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
	<div class="offcanvas-header bg-body-secondary">
		<h5 class="offcanvas-title fw-bold" id="mobileSidebarLabel">
			<?php echo e(t('Filters')); ?>

		</h5>
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body vh-200 overflow-y-auto">
		<div class="card<?php echo e($showOnMobileOnly); ?>">
			<div class="card-body vstack gap-4 text-wrap">
				
				<?php
					$prefixId = 'm-';
				?>
				<?php echo $__env->make('front.search.partials.sidebar.fields', ['prefixId' => $prefixId], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				<?php echo $__env->make('front.search.partials.sidebar.categories', ['prefixId' => $prefixId], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				<?php echo $__env->make('front.search.partials.sidebar.cities', ['prefixId' => $prefixId], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				<?php if(!config('settings.listings_list.hide_date')): ?>
					<?php echo $__env->make('front.search.partials.sidebar.date', ['prefixId' => $prefixId], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				<?php endif; ?>
				<?php echo $__env->make('front.search.partials.sidebar.price', ['prefixId' => $prefixId], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			</div>
		</div>
	</div>
</div>

<?php $__env->startSection('after_scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
    <script>
        var baseUrl = '<?php echo e(request()->url()); ?>';
    </script>
    
    
    <script>
	    onDocumentReady((event) => {
		    const postedDateEls = document.querySelectorAll('input[type=radio][name=postedDate]');
		    if (postedDateEls.length > 0) {
			    postedDateEls.forEach((element) => {
				    element.addEventListener('click', (e) => {
					    const queryStringEl = document.querySelector('input[type=hidden][name=postedQueryString]');
					    
					    if (queryStringEl) {
						    let queryString = queryStringEl.value;
						    queryString += (queryString !== '') ? '&' : '';
						    queryString = queryString + 'postedDate=' + e.target.value;
						    
						    let searchUrl = baseUrl + '?' + queryString;
						    redirect(searchUrl);
					    }
				    });
			    });
		    }
	    });
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/sidebar.blade.php ENDPATH**/ ?>