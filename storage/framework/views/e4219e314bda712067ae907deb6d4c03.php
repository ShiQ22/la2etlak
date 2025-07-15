<?php
	$autocompleteClass ??= '';
	$searchTooltip ??= '';
?>
<div class="row search-row">
	
	<div class="col-md-5 col-sm-12 px-0 search-col">
		<div class="hstack gap-0 form-control form-control-lg rounded-5 rounded-end-0 border-5 border-end-0 border-primary py-1">
			<i class="bi bi-binoculars fs-4 text-secondary"></i>
			<input class="form-control shadow-none rounded-0 border-0" name="q" placeholder="<?php echo e(t('what')); ?>" type="text" value="">
		</div>
	</div>
	
	
	<div class="col-md-5 col-sm-12 px-0 search-col">
		<div class="hstack gap-0 form-control form-control-lg rounded-5 rounded-start-0 rounded-end-0 border-5 border-start-0 border-end-0 border-primary py-1">
			<i class="bi bi-geo-alt fs-4 text-secondary"></i>
			<input class="form-control shadow-none rounded-0 border-0 <?php echo e($autocompleteClass); ?>"
			       id="locSearch"
			       name="location"
			       placeholder="<?php echo e(t('where')); ?>"
			       type="text"
			       value=""
			       data-old-value=""
			       spellcheck=false
			       autocomplete="off"
			       autocapitalize="off"
			       tabindex="1"<?php echo $searchTooltip; ?>

			>
		</div>
		<input type="hidden" id="lSearch" name="l" value="">
	</div>
	
	
	<div class="col-md-2 col-sm-12 px-0 d-grid search-col">
		<button class="btn btn-lg btn-primary bg-gradient rounded-5 rounded-start-0 border-4 border-start-0 border-primary">
			<i class="fa-solid fa-magnifying-glass"></i> <span class="fw-bold d-none d-xl-inline-block"><?php echo e(t('find')); ?></span>
		</button>
	</div>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/front/sections/home/search-form/large-screen.blade.php ENDPATH**/ ?>