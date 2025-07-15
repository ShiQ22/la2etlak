<?php
	$searchFormOptions = $searchFormOptions ?? [];
	$locationsOptions = $locationsOptions ?? [];
?>
<style>
/* === Homepage: Search Form Area === */
<?php if(!empty($searchFormOptions['height'])): ?>
	<?php
        $searchFormOptions['height'] = forceToInt($searchFormOptions['height']) . 'px';
    ?>
	#homepage .hero-wrap:not(.only-search-bar) {
		height: <?php echo e($searchFormOptions['height']); ?>;
		max-height: <?php echo e($searchFormOptions['height']); ?>;
	}
<?php endif; ?>
<?php if(!empty($searchFormOptions['background_color'])): ?>
	#homepage .hero-wrap:not(.only-search-bar) {
		background-color: <?php echo e($searchFormOptions['background_color']); ?> !important;
	}
<?php endif; ?>
<?php
	$bgImgFound = false;
	$bgImgDarken = data_get($searchFormOptions, 'background_image_darken', 0.0);
?>
<?php if(!empty(config('country.background_image_url'))): ?>
	#homepage .hero-wrap:not(.only-search-bar) {
		background-image: linear-gradient(rgba(0, 0, 0, <?php echo e($bgImgDarken); ?>),rgba(0, 0, 0, <?php echo e($bgImgDarken); ?>)),url(<?php echo e(config('country.background_image_url')); ?>);
		background-size: cover;
	}
	<?php
		$bgImgFound = true;
	?>
<?php endif; ?>
<?php if(!$bgImgFound): ?>
	<?php if(!empty($searchFormOptions['background_image_url'])): ?>
		#homepage .hero-wrap:not(.only-search-bar) {
			background-image: linear-gradient(rgba(0, 0, 0, <?php echo e($bgImgDarken); ?>),rgba(0, 0, 0, <?php echo e($bgImgDarken); ?>)),url(<?php echo e($searchFormOptions['background_image_url']); ?>);
			background-size: cover;
		}
	<?php endif; ?>
<?php endif; ?>
<?php if(!empty($searchFormOptions['big_title_color'])): ?>
	#homepage .hero-wrap:not(.only-search-bar) h1,
	#homepage .hero-wrap:not(.only-search-bar) h1.text-white {
		color: <?php echo e($searchFormOptions['big_title_color']); ?> !important;
	}
<?php endif; ?>
<?php if(!empty($searchFormOptions['sub_title_color'])): ?>
	#homepage .hero-wrap:not(.only-search-bar) h5,
	#homepage .hero-wrap:not(.only-search-bar) h5.text-white {
		color: <?php echo e($searchFormOptions['sub_title_color']); ?> !important;
	}
<?php endif; ?>
<?php if(!empty($searchFormOptions['form_border_width'])): ?>
	<?php
		$formBorderWidth = forceToInt($searchFormOptions['form_border_width']);
		$formBtnBorderWidth = abs($formBorderWidth - 1);
		$searchFormOptions['form_border_width'] = $formBorderWidth . 'px';
		$formBtnBorderWidthPx = $formBtnBorderWidth . 'px';
	?>
	#homepage .search-row .search-col:first-child div.form-control,
	#homepage .search-row .search-col div.form-control {
		border-width: <?php echo e($searchFormOptions['form_border_width']); ?> !important;
	}
	#homepage .search-row .search-col button {
		border-width: <?php echo e($formBtnBorderWidthPx); ?> !important;
	}
	
	@media (max-width: 767px) {
		.search-row .search-col:first-child div.form-control,
		.search-row .search-col div.form-control {
			border-width: <?php echo e($searchFormOptions['form_border_width']); ?> !important;
		}
		.search-row .search-col button {
			border-width: <?php echo e($formBtnBorderWidthPx); ?> !important;
		}
	}
<?php endif; ?>
<?php
	if (!empty($searchFormOptions['form_border_radius'])) {
		$formBorderRadius = forceToInt($searchFormOptions['form_border_radius']);
		
		// Based on default radius
		$fieldsBorderRadius = (int)round((($formBorderRadius * 18) / 24));
		
		// Based on the default radius & default border width
		if (!empty($searchFormOptions['form_border_width'])) {
			$formBorderWidth = forceToInt($searchFormOptions['form_border_width']);
			
			// Get the difference between the default wrapper & the fields radius, based on the default border width
			$borderRadiusDiff = (24 - 18) / 5;
			
			// Apply the diff. obtained above to the customized wrapper radius to get the fields radius
			$fieldsBorderRadius = (int)round(($formBorderRadius - $borderRadiusDiff));
		}
	} else {
		$formBorderRadius = 24;
		$fieldsBorderRadius = 24;
	}
	
	$formBorderRadiusOut = getFormBorderRadiusCSS($formBorderRadius, $fieldsBorderRadius);
?>

<?php echo $formBorderRadiusOut; ?>


<?php if(!empty($searchFormOptions['form_border_color'])): ?>
	#homepage .search-row .search-col:first-child div.form-control,
	#homepage .search-row .search-col div.form-control,
	#homepage .search-row .search-col button {
		border-color: <?php echo e($searchFormOptions['form_border_color']); ?> !important;
	}
	
	@media (max-width: 767px) {
		#homepage .search-row .search-col:first-child div.form-control,
		#homepage .search-row .search-col div.form-control,
		#homepage .search-row .search-col button {
			border-color: <?php echo e($searchFormOptions['form_border_color']); ?> !important;
		}
	}
<?php endif; ?>
<?php if(!empty($searchFormOptions['form_btn_background_color'])): ?>
	.skin #homepage .search-row .search-col button {
		background-color: <?php echo e($searchFormOptions['form_btn_background_color']); ?> !important;
		border-color: <?php echo e($searchFormOptions['form_btn_background_color']); ?> !important;
	}
<?php endif; ?>
<?php if(!empty($searchFormOptions['form_btn_text_color'])): ?>
	.skin #homepage .search-row .search-col button {
		color: <?php echo e($searchFormOptions['form_btn_text_color']); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.page_width'))): ?>
	<?php
		$pageWidth = forceToInt(config('settings.style.page_width')) . 'px';
	?>
	@media (min-width: 1200px) {
		#homepage .hero-wrap.only-search-bar .container {
			max-width: <?php echo e($pageWidth); ?>;
		}
	}
<?php endif; ?>

/* === Homepage: Locations & SVG Map === */
<?php if(!empty($locationsOptions['background_color'])): ?>
	#homepage .location-card .card.bg-body-tertiary {
		background-color: <?php echo e($locationsOptions['background_color']); ?> !important;
	}
<?php endif; ?>
<?php if(!empty($locationsOptions['border_width'])): ?>
	<?php
		$locationsOptions['border_width'] = forceToInt($locationsOptions['border_width']) . 'px';
	?>
	#homepage .location-card .card {
		border-width: <?php echo e($locationsOptions['border_width']); ?>;
	}
<?php endif; ?>
<?php if(!empty($locationsOptions['border_color'])): ?>
	#homepage .location-card .card {
		border-color: <?php echo e($locationsOptions['border_color']); ?>;
	}
<?php endif; ?>
<?php if(!empty($locationsOptions['text_color'])): ?>
	#homepage .location-card .card,
	#homepage .location-card .card p,
	#homepage .location-card .card h1,
	#homepage .location-card .card h2,
	#homepage .location-card .card h3,
	#homepage .location-card .card h4,
	#homepage .location-card .card h5 {
		color: <?php echo e($locationsOptions['text_color']); ?>;
	}
<?php endif; ?>
<?php if(!empty($locationsOptions['link_color'])): ?>
	#homepage .location-card .card a:not(.btn),
	#homepage .location-card .card a.link-body-emphasis {
		color: <?php echo e($locationsOptions['link_color']); ?> !important;
	}
<?php endif; ?>
<?php if(!empty($locationsOptions['link_color_hover'])): ?>
	#homepage .location-card .card a:not(.btn):hover,
	#homepage .location-card .card a:not(.btn):focus,
	#homepage .location-card .card a.link-body-emphasis:hover,
	#homepage .location-card .card a.link-body-emphasis:focus {
		color: <?php echo e($locationsOptions['link_color_hover']); ?> !important;
	}
<?php endif; ?>
</style>
<?php /**PATH C:\xampp\htdocs\resources\views/front/common/css/homepage.blade.php ENDPATH**/ ?>