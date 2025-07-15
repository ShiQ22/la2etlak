<?php echo $__env->make('front.common.css.skin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('front.common.css.dark', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<style>
/* === Body === */

<?php
	$isFixedTopHeader = (config('settings.style.header_fixed_top') == '1');
	
	// Logo Max Sizes
	$logoMaxWidth = config('larapen.media.resize.namedOptions.logo-max.width', 430);
	$logoMaxHeight = config('larapen.media.resize.namedOptions.logo-max.height', 80);
	if (!empty(config('settings.style.header_height'))) {
		$logoMaxHeight = forceToInt(config('settings.style.header_height'), $logoMaxHeight);
	}
	
	// Logo Sizes
	$logoWidth = forceToInt(config('settings.style.logo_width'), 216);
	$logoHeight = forceToInt(config('settings.style.logo_height'), 40);
	if (config('settings.style.logo_aspect_ratio')) {
		if ($logoHeight <= $logoWidth) {
			$logoWidth = 'auto';
			$logoHeight = $logoHeight . 'px';
		} else {
			$logoWidth = $logoWidth . 'px';
			$logoHeight = 'auto';
		}
	} else {
		$logoWidth = $logoWidth . 'px';
		$logoHeight = $logoHeight . 'px';
	}
?>
.main-logo {
	width: <?php echo e($logoWidth); ?>;
	height: <?php echo e($logoHeight); ?>;
	max-width: <?php echo e($logoMaxWidth); ?>px !important;
	max-height: <?php echo e($logoMaxHeight); ?>px !important;
}
<?php if(!empty(config('settings.style.page_width'))): ?>
	<?php
		$pageWidth = forceToInt(config('settings.style.page_width')) . 'px';
	?>
	@media (min-width: 1200px) {
		.container {
			max-width: <?php echo e($pageWidth); ?>;
		}
	}
<?php endif; ?>
<?php if(
	!empty(config('settings.style.body_background_color'))
	|| !empty(config('settings.style.body_background_image_path'))
): ?>
	body.bg-body {
	<?php if(!empty(config('settings.style.body_background_color'))): ?>
		background-color: <?php echo e(config('settings.style.body_background_color')); ?> !important;
	<?php endif; ?>
	<?php if(!empty(config('settings.style.body_background_image_url'))): ?>
		background-image: url(<?php echo e(config('settings.style.body_background_image_url')); ?>);
		background-repeat: repeat;
		<?php if(!empty(config('settings.style.body_background_image_fixed'))): ?>
			background-attachment: fixed;
		<?php endif; ?>
	<?php endif; ?>
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.body_text_color'))): ?>
	body.text-body-emphasis {
		color: <?php echo e(config('settings.style.body_text_color')); ?> !important;
	}
<?php endif; ?>

<?php if(!empty(config('settings.style.body_background_color')) || !empty(config('settings.style.body_background_image_path'))): ?>
	main {
		background-color: rgba(0, 0, 0, 0);
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.title_color'))): ?>
	.skin h1,
	.skin h2,
	.skin h3,
	.skin h4,
	.skin h5,
	.skin h6 {
		color: <?php echo e(config('settings.style.title_color')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.link_color'))): ?>
	.skin a,
	.skin .link-color {
		color: <?php echo e(config('settings.style.link_color')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.link_color_hover'))): ?>
	.skin a:hover,
	.skin a:focus {
		color: <?php echo e(config('settings.style.link_color_hover')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.progress_background_color'))): ?>
	.skin .pace .pace-progress {
		background: <?php echo e(config('settings.style.progress_background_color')); ?> none repeat scroll 0 0;
	}
<?php endif; ?>

/* === Header === */

<?php if(!empty(config('settings.style.header_height'))): ?>
	<?php
		// Default values
		$defaultHeight = 80;
		$defaultPadding = 20;
		$defaultMargin = 0;
		
		// Get known value from Settings
		$headerHeight = forceToInt(config('settings.style.header_height'));
		
		$headerBottomBorderSize = 0;
		if (!empty(config('settings.style.header_border_bottom_width'))) {
			$headerBottomBorderSize = forceToInt(config('settings.style.header_border_bottom_width'));
		}
		$wrapperPaddingTop = $headerHeight + $headerBottomBorderSize;
		
		// Calculate unknown values
		$calculatedPadding = floor(($headerHeight * $defaultPadding) / $defaultHeight);
		$calculatedMargin = floor(($headerHeight * $defaultMargin) / $defaultHeight);
		$padding = abs(($calculatedPadding - ($defaultPadding / 2)) * 2);
		$margin = abs(($calculatedMargin - ($defaultMargin / 2)) * 2);
		
		/* $wrapperPaddingTop + 4 for default margin/padding values */
		$wrapperPaddingTop = $wrapperPaddingTop + ($padding - 4);
	?>
	header .navbar {
		min-height: <?php echo e($headerHeight); ?>px;
		padding-top: <?php echo e($padding); ?>px;
		padding-bottom: <?php echo e($padding); ?>px;
	}
	<?php if($isFixedTopHeader): ?>
		main {
			
			padding-top: <?php echo e($wrapperPaddingTop); ?>px;
		}
   <?php endif; ?>
<?php endif; ?>
<?php if(!empty(config('settings.style.header_background_color'))): ?>
	header .navbar {
		background-color: <?php echo e(config('settings.style.header_background_color')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.header_border_bottom_width'))): ?>
	<?php
		$headerBottomBorderSize = forceToInt(config('settings.style.header_border_bottom_width')) . 'px';
	?>
	header .navbar {
		border-bottom-width: <?php echo e($headerBottomBorderSize); ?> !important;
		border-bottom-style: solid !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.header_border_bottom_color'))): ?>
	header .navbar {
		border-bottom-color: <?php echo e(config('settings.style.header_border_bottom_color')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.header_link_color'))): ?>
	@media (min-width: 768px) {
		header .navbar ul.navbar-nav > li > a {
			color: <?php echo e(config('settings.style.header_link_color')); ?> !important;
		}
	}
	
	header .navbar ul.navbar-nav > .open > a,
	header .navbar ul.navbar-nav > .open > a:focus,
	header .navbar ul.navbar-nav > .open > a:hover {
		color: <?php echo e(config('settings.style.header_link_color')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.header_link_color_hover'))): ?>
	@media (min-width: 768px) {
		header .navbar ul.navbar-nav > li > a:hover,
		header .navbar ul.navbar-nav > li > a:focus {
			color: <?php echo e(config('settings.style.header_link_color_hover')); ?> !important;
		}
	}
<?php endif; ?>

/* === Footer === */
<?php if(!empty(config('settings.style.footer_background_color'))): ?>
	footer > div.bg-body-tertiary {
		background: <?php echo e(config('settings.style.footer_background_color')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.footer_border_top_width'))): ?>
	<?php
		$footerBorderTopSize = forceToInt(config('settings.style.footer_border_top_width')) . 'px';
	?>
	footer > div.bg-body-tertiary {
		border-top-width: <?php echo e($footerBorderTopSize); ?> !important;
		border-top-style: solid !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.footer_border_top_color'))): ?>
	footer > div.bg-body-tertiary {
		border-top-color: <?php echo e(config('settings.style.footer_border_top_color')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.footer_text_color'))): ?>
	footer > div {
		color: <?php echo e(config('settings.style.footer_text_color')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.footer_title_color'))): ?>
	footer h1, footer h2, footer h3, footer h4, footer h5, footer h6 {
		color: <?php echo e(config('settings.style.footer_title_color')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.footer_link_color'))): ?>
	footer a.link-body-emphasis,
	footer a.link-primary {
		color: <?php echo e(config('settings.style.footer_link_color')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.footer_link_color_hover'))): ?>
	footer a.link-body-emphasis:hover,
	footer a.link-body-emphasis:focus,
	footer a.link-primary:hover,
	footer a.link-primary:focus {
		color: <?php echo e(config('settings.style.footer_link_color_hover')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.payment_icon_border_top_width'))): ?>
	<?php
		$paymentIconTopBorderSize = forceToInt(config('settings.style.payment_icon_border_top_width')) . 'px';
	?>
	.payment-method-logo {
		border-top-width: <?php echo e($paymentIconTopBorderSize); ?>;
	}
	.footer-content hr {
		border-top-width: <?php echo e($paymentIconTopBorderSize); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.payment_icon_border_top_color'))): ?>
	.payment-method-logo {
		border-top-color: <?php echo e(config('settings.style.payment_icon_border_top_color')); ?>;
	}
	.footer-content hr {
		border-top-color: <?php echo e(config('settings.style.payment_icon_border_top_color')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.payment_icon_border_bottom_width'))): ?>
	<?php
		$paymentIconBottomBorderSize = forceToInt(config('settings.style.payment_icon_border_bottom_width')) . 'px';
	?>
	.payment-method-logo {
		border-bottom-width: <?php echo e($paymentIconBottomBorderSize); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.payment_icon_border_bottom_color'))): ?>
	.payment-method-logo {
		border-bottom-color: <?php echo e(config('settings.style.payment_icon_border_bottom_color')); ?>;
	}
<?php endif; ?>

/* === Button: Add Listing === */
<?php if(!empty(config('settings.style.btn_listing_bg_top_color')) || !empty(config('settings.style.btn_listing_bg_bottom_color'))): ?>
	<?php
		$btnBackgroundTopColor = '#ffeb43';
		$btnBackgroundBottomColor = '#fcde11';
		if (!empty(config('settings.style.btn_listing_bg_top_color'))) {
			$btnBackgroundTopColor = config('settings.style.btn_listing_bg_top_color');
		}
		if (!empty(config('settings.style.btn_listing_bg_bottom_color'))) {
			$btnBackgroundBottomColor = config('settings.style.btn_listing_bg_bottom_color');
		}
	?>
	a.btn-listing,
	button.btn-listing,
	header .navbar ul.navbar-nav > li.postadd > a.btn-listing,
	#homepage a.btn-listing {
		background-image: linear-gradient(to bottom, <?php echo e($btnBackgroundTopColor); ?> 0,<?php echo e($btnBackgroundBottomColor); ?> 100%);
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.btn_listing_border_color'))): ?>
	a.btn-listing,
	button.btn-listing,
	header .navbar ul.navbar-nav > li.postadd > a.btn-listing,
	#homepage a.btn-listing {
		border-color: <?php echo e(config('settings.style.btn_listing_border_color')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.btn_listing_text_color'))): ?>
	a.btn-listing,
	button.btn-listing,
	header .navbar ul.navbar-nav > li.postadd > a.btn-listing,
	#homepage a.btn-listing {
		color: <?php echo e(config('settings.style.btn_listing_text_color')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.btn_listing_bg_top_color_hover')) || !empty(config('settings.style.btn_listing_bg_bottom_color_hover'))): ?>
	<?php
		$btnBackgroundTopColorHover = '#fff860';
		$btnBackgroundBottomColorHover = '#ffeb43';
		if (!empty(config('settings.style.btn_listing_bg_top_color_hover'))) {
			$btnBackgroundTopColorHover = config('settings.style.btn_listing_bg_top_color_hover');
		}
		if (!empty(config('settings.style.btn_listing_bg_bottom_color_hover'))) {
			$btnBackgroundBottomColorHover = config('settings.style.btn_listing_bg_bottom_color_hover');
		}
	?>
	a.btn-listing:hover,
	a.btn-listing:focus,
	button.btn-listing:hover,
	button.btn-listing:focus,
	li.postadd > a.btn-listing:hover,
	li.postadd > a.btn-listing:focus,
	#homepage a.btn-listing:hover,
	#homepage a.btn-listing:focus {
		background-image: linear-gradient(to bottom, <?php echo e($btnBackgroundTopColorHover); ?> 0,<?php echo e($btnBackgroundBottomColorHover); ?> 100%) !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.btn_listing_border_color_hover'))): ?>
	a.btn-listing:hover,
	a.btn-listing:focus,
	button.btn-listing:hover,
	button.btn-listing:focus,
	header .navbar ul.navbar-nav > li.postadd > a.btn-listing:hover,
	header .navbar ul.navbar-nav > li.postadd > a.btn-listing:focus,
	#homepage a.btn-listing:hover,
	#homepage a.btn-listing:focus {
		border-color: <?php echo e(config('settings.style.btn_listing_border_color_hover')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.btn_listing_text_color_hover'))): ?>
	a.btn-listing:hover,
	a.btn-listing:focus,
	button.btn-listing:hover,
	button.btn-listing:focus,
	header .navbar ul.navbar-nav > li.postadd > a.btn-listing:hover,
	header .navbar ul.navbar-nav > li.postadd > a.btn-listing:focus,
	#homepage a.btn-listing:hover,
	#homepage a.btn-listing:focus {
		color: <?php echo e(config('settings.style.btn_listing_text_color_hover')); ?> !important;
	}
<?php endif; ?>
</style>
<?php /**PATH C:\xampp\htdocs\resources\views/front/common/css/style.blade.php ENDPATH**/ ?>