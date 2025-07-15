<?php
	$cat ??= [];
?>
<?php if(!empty(data_get($cat, 'description'))): ?>
	<?php if(!(bool)data_get($cat, 'hide_description')): ?>
		<div class="container mb-3">
			<div class="card border-light text-dark bg-body-tertiary mb-3">
				<div class="card-body">
					<?php echo data_get($cat, 'description'); ?>

				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/category-description.blade.php ENDPATH**/ ?>