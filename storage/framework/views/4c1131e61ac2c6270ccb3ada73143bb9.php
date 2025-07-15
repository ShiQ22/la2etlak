<?php
	$sectionOptions = $latestListingsOptions ?? [];
	$sectionData ??= [];
	$widget = (array)data_get($sectionData, 'latest');
	$widgetType = (data_get($sectionOptions, 'items_in_carousel') == '1') ? 'carousel' : 'normal';
?>
<?php echo $__env->make('front.search.partials.posts.widget.' . $widgetType, [
	'widget'         => $widget,
	'sectionOptions' => $sectionOptions
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/sections/home/latest-listings.blade.php ENDPATH**/ ?>