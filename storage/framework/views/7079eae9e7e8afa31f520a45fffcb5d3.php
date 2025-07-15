<?php
	$sectionOptions = $searchFormOptions ?? [];
	$sectionData ??= [];
	
	// Get Search Form Options
	$enableFormAreaCustomization = data_get($sectionOptions, 'enable_extended_form_area') ?? '0';
	$hideTitles = data_get($sectionOptions, 'hide_titles') ?? '0';
	
	$headerTitle = data_get($sectionOptions, 'title_' . config('app.locale'));
	$headerTitle = (!empty($headerTitle)) ? replaceGlobalPatterns($headerTitle) : null;
	
	$headerSubTitle = data_get($sectionOptions, 'sub_title_' . config('app.locale'));
	$headerSubTitle = (!empty($headerSubTitle)) ? replaceGlobalPatterns($headerSubTitle) : null;
	
	$parallax = data_get($sectionOptions, 'parallax') ?? '0';
	$hideForm = data_get($sectionOptions, 'hide_form') ?? '0';
	
	$isAutocompleteEnabled = (config('settings.listings_list.enable_cities_autocompletion') == '1');
	$autocompleteClass = $isAutocompleteEnabled ? ' autocomplete-enabled' : '';
	
	$statesSearchTip = t('states_search_tip', ['prefix' => t('area'), 'suffix' => t('state_name')]);
	$displayStatesSearchTip = config('settings.listings_list.display_states_search_tip');
	$searchTooltip = $displayStatesSearchTip
		? ' data-bs-placement="top" data-bs-toggle="tooltipHover" title="' . $statesSearchTip . '"'
		: '';
	
	$hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' d-none d-md-block' : '';
?>
<?php if(isset($enableFormAreaCustomization) && $enableFormAreaCustomization == '1'): ?>
	
	<?php if(isset($firstSection) && !$firstSection): ?>
		<div class="p-0 mt-lg-4 mt-md-3 mt-3"></div>
	<?php endif; ?>
	
	<?php
		$parallaxClass = ($parallax == '1') ? ' parallax' : '';
	?>
	<div class="hero-wrap bg-secondary d-flex align-items-center<?php echo e($hideOnMobile . $parallaxClass); ?>">
		<div class="container text-center">
			
			<?php if($hideTitles != '1'): ?>
				<h1 class="text-uppercase fw-bold text-white text-shadow">
					<?php echo e($headerTitle); ?>

				</h1>
				<h5 class="fs-4 lead text-white text-shadow mb-3">
					<?php echo $headerSubTitle; ?>

				</h5>
			<?php endif; ?>
			
			<?php if($hideForm != '1'): ?>
				<div class="row d-flex justify-content-center">
					<div class="col-9">
						<form id="searchForm"
						      name="search"
						      action="<?php echo e(urlGen()->searchWithoutQuery()); ?>"
						      method="GET"
						      data-csrf-token="<?php echo e(csrf_token()); ?>"
						>
							
							<div class="w-100 d-none d-md-inline-block">
								<?php echo $__env->make('front.sections.home.search-form.large-screen', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							</div>
							
							<div class="w-100 d-sm-inline-block d-md-none">
								<?php echo $__env->make('front.sections.home.search-form.small-screen', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							</div>
						</form>
					</div>
				</div>
			<?php endif; ?>
			
		</div>
	</div>
	
<?php else: ?>
	
	<?php echo $__env->make('front.sections.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<div class="d-flex align-items-center only-search-bar<?php echo e($hideOnMobile); ?>">
		<div class="container text-center">
			
			<?php if($hideForm != '1'): ?>
				<div class="row d-flex justify-content-center px-2">
					<div class="col-12">
						<form id="search"
						      name="search"
						      action="<?php echo e(urlGen()->searchWithoutQuery()); ?>"
						      method="GET"
						      data-csrf-token="<?php echo e(csrf_token()); ?>"
						>
							
							<div class="w-100 d-none d-md-inline-block">
								<?php echo $__env->make('front.sections.home.search-form.large-screen', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							</div>
							
							<div class="w-100 d-sm-inline-block d-md-none">
								<?php echo $__env->make('front.sections.home.search-form.small-screen', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							</div>
						</form>
					</div>
				</div>
			<?php endif; ?>
			
		</div>
	</div>
	
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/sections/home/search-form.blade.php ENDPATH**/ ?>