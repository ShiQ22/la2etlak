<?php
	$startNowUrl = !doesGuestHaveAbilityToCreateListings() ? urlGen()->signInModal() : urlGen()->addPost();
?>
<div class="container mb-4">
	<div class="card bg-body-tertiary border text-secondary p-3">
		<div class="card-body text-center">
			<h3 class="fs-3 fw-bold">
				<?php echo e(t('do_you_have_anything')); ?>

			</h3>
			<h5 class="fs-5 mb-4">
				<?php echo e(t('sell_products_and_services_online_for_free')); ?>

			</h5>
			<a href="<?php echo $startNowUrl; ?>" class="btn btn-border btn-post btn-listing">
				<?php echo e(t('start_now')); ?>

			</a>
		</div>
	</div>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/call-to-action.blade.php ENDPATH**/ ?>