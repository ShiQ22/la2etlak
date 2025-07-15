<?php
	$headerTitle ??= t('overview');
	$userName = $authUser->name ?? '--';
	$userPhotoUrl = $authUser->photo_url ?? config('larapen.media.avatar');
	$photoSize = '60px';
	$photoStyle = "max-width: $photoSize; max-height: $photoSize; width: $photoSize; height: $photoSize;";
?>
<div class="container border rounded bg-body-tertiary p-4 p-lg-3 p-md-2 mb-4">
	<div class="row d-flex align-items-center">
		<div class="col-lg-8 col-md-12 d-flex justify-content-star flex-column justify-content-center">
			<h3 class="p-0 fw-bold">
				<?php echo $headerTitle; ?>

			</h3>
			<div><?php echo Breadcrumb::render(); ?></div>
		</div>
		<div class="col-lg-4 col-md-12 d-flex justify-content-lg-end hidden-md">
			<h5 class="p-0 mb-0">
				<?php echo e($userName); ?>&nbsp;
				<img id="userImg" class="rounded-circle border" src="<?php echo e($userPhotoUrl); ?>" alt="user" style="<?php echo $photoStyle; ?>">
			</h5>
		</div>
	</div>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/front/account/partials/header.blade.php ENDPATH**/ ?>