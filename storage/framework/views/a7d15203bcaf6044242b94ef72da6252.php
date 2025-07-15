<?php
	$commentsAreDisabledByUser ??= false;
	$areCommentsActivated = (
		config('settings.listing_page.activation_facebook_comments')
		&& config('services.facebook.client_id')
		&& !$commentsAreDisabledByUser
	);
	$fbClientId = config('services.facebook.client_id');
	$locale = config('lang.iso_locale', 'en_US');
	
	$userThemePreference ??= 'light';
?>
<?php if($areCommentsActivated): ?>
	<?php echo $__env->make('front.sections.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<div class="container mb-4 mt-4">
		<div id="fb-root"></div>
		<script>
			(function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/<?php echo e($locale); ?>/sdk.js#xfbml=1&version=v19.0&appId=<?php echo e($fbClientId); ?>";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<div
				class="fb-comments"
				data-href="<?php echo e(request()->url()); ?>"
				data-width="100%"
				data-numposts="5"
				data-colorscheme="<?php echo e($userThemePreference); ?>"
		></div>
	</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/layouts/partials/tools/facebook-comments.blade.php ENDPATH**/ ?>