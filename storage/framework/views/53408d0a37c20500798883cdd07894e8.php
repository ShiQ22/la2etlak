<?php
	$catDisplayType ??= 'c_bigIcon_list';
	
	$apiResult ??= [];
	$totalCategories = (int)data_get($apiResult, 'meta.total', 0);
	$areCategoriesPageable = (!empty(data_get($apiResult, 'links.prev')) || !empty(data_get($apiResult, 'links.next')));
	
	$categories ??= [];
	$category ??= null;
	$hasChildren ??= false;
	$selectedId ??= 0; /* The selected category ID */
	
	$selectionUrl = url('browsing/categories/select');
	
	// Links CSS Class
	$linkClass = linkClass();
?>
<?php if(!$hasChildren): ?>
	
	
	
	<?php if(!empty($category)): ?>
		<?php
			$_catId = data_get($category, 'id');
			$_catName = data_get($category, 'name');
		?>
		<?php if(!empty(data_get($category, 'children'))): ?>
			<?php
				$_catSelectionUrl = urlQuery($selectionUrl)->setParameters(['parentId' => $_catId])->toString();
			?>
			<a href="#browseCategories"
			   data-bs-toggle="modal"
			   class="modal-cat-link open-selection-url <?php echo e($linkClass); ?>"
			   data-selection-url="<?php echo e($_catSelectionUrl); ?>"
			>
				<?php echo e($_catName); ?>

			</a>
		<?php else: ?>
			<?php
				$_catParentId = data_get($category, 'parent.id', 0);
				$_catSelectionUrl = urlQuery($selectionUrl)->setParameters(['parentId' => $_catParentId])->toString();
			?>
			<?php echo e($_catName); ?>&nbsp;
			[ <a href="#browseCategories"
				 data-bs-toggle="modal"
				 class="modal-cat-link open-selection-url <?php echo e($linkClass); ?>"
				 data-selection-url="<?php echo e($_catSelectionUrl); ?>"
			><i class="fa-regular fa-pen-to-square"></i> <?php echo e(t('Edit')); ?></a> ]
		<?php endif; ?>
	<?php else: ?>
		<a href="#browseCategories"
		   data-bs-toggle="modal"
		   class="modal-cat-link open-selection-url <?php echo e($linkClass); ?>"
		   data-selection-url="<?php echo e($selectionUrl); ?>"
		>
			<?php echo e(t('select_a_category')); ?>

		</a>
	<?php endif; ?>
	
<?php else: ?>
	
	

	<?php if(!empty($category)): ?>
		<?php
			$_parentId = data_get($category, 'parent.id', 0);
			$_url = urlQuery($selectionUrl)->setParameters(['parentId' => $_parentId])->toString();
			$_id = data_get($category, 'id');
			$_name = data_get($category, 'name');
		?>
		<p>
			<a href="<?php echo $_url; ?>" class="btn btn-primary btn-sm modal-cat-link" data-ignore-guard="true">
				<i class="fa-solid fa-reply"></i> <?php echo e(t('go_to_parent_categories')); ?>

			</a>&nbsp;
			<strong><?php echo e($_name); ?></strong>
		</p>
	<?php endif; ?>
	
	<?php if(!empty($categories)): ?>
		<div class="container">
			<?php if($catDisplayType == 'c_picture_list'): ?>
				
				<div id="modalCategoryList" class="row row-cols-lg-6 row-cols-md-4 row-cols-sm-3 row-cols-2 py-1 px-0">
					<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$_id = data_get($cat, 'id');
							$_hasChildren = (!empty(data_get($cat, 'children'))) ? 1 : 0;
							$_parentId = data_get($cat, 'parent.id', 0);
							$_hasLink = ($_id != $selectedId || $_hasChildren == 1);
							$_type = data_get($cat, 'type');
							$_imageUrl = data_get($cat, 'image_url');
							$_name = data_get($cat, 'name');
							$_url = urlQuery($selectionUrl)->setParameters(['parentId' => $_id])->toString();
						?>
						<div class="col px-0 d-flex justify-content-center align-content-stretch">
							<div class="text-center justify-content-center w-100 border rounded px-3 py-2 m-1">
								<?php if($_hasLink): ?>
									<a href="<?php echo $_url; ?>"
									   class="modal-cat-link <?php echo e($linkClass); ?>"
									   data-parent-id="<?php echo e($_parentId); ?>"
									   data-id="<?php echo e($_id); ?>"
									   data-has-children="<?php echo e($_hasChildren); ?>"
									   data-type="<?php echo e($_type); ?>"
									>
								<?php endif; ?>
								<img src="<?php echo e($_imageUrl); ?>" class="lazyload img-fluid" alt="<?php echo e($_name); ?>">
								<h6 class="mt-2 fw-bold<?php echo e(!$_hasLink ? ' text-secondary' : ''); ?>">
									<?php echo e($_name); ?>

								</h6>
								<?php if($_hasLink): ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			
			<?php elseif($catDisplayType == 'c_bigIcon_list'): ?>
			
				<div id="modalCategoryList" class="row row-cols-lg-6 row-cols-md-4 row-cols-sm-3 row-cols-2 py-0 px-0">
					<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$_id = data_get($cat, 'id');
							$_hasChildren = (!empty(data_get($cat, 'children'))) ? 1 : 0;
							$_parentId = data_get($cat, 'parent.id', 0);
							$_hasLink = ($_id != $selectedId || $_hasChildren == 1);
							$_type = data_get($cat, 'type');
							$_iconClass = data_get($cat, 'icon_class');
							$_name = data_get($cat, 'name');
							$_url = urlQuery($selectionUrl)->setParameters(['parentId' => $_id])->toString();
						?>
						<div class="col px-0 d-flex justify-content-center align-content-stretch">
							<div class="text-center justify-content-center w-100 border rounded px-3 py-2 m-1">
								<?php if($_hasLink): ?>
									<a href="<?php echo $_url; ?>"
									   class="modal-cat-link <?php echo e($linkClass); ?>"
									   data-parent-id="<?php echo e($_parentId); ?>"
									   data-id="<?php echo e($_id); ?>"
									   data-has-children="<?php echo e($_hasChildren); ?>"
									   data-type="<?php echo e($_type); ?>"
									>
								<?php endif; ?>
									<?php if(in_array(config('settings.listings_list.show_category_icon'), [2, 6, 7, 8])): ?>
										<i class="<?php echo e($_iconClass ?? 'bi bi-folder-fill'); ?>" style="font-size: 3rem;"></i>
									<?php endif; ?>
									<h6 class="mt-2 fw-bold<?php echo e(!$_hasLink ? ' text-secondary' : ''); ?>">
										<?php echo e($_name); ?>

									</h6>
								<?php if($_hasLink): ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
				
			<?php else: ?>
				
				<?php
					$isShowingCategoryIconEnabled = in_array(config('settings.listings_list.show_category_icon'), [2, 6, 7, 8]);
					
					$listTypes = ['c_border_list' => 'border-bottom pb-2'];
					$borderBottom = $listTypes[$catDisplayType] ?? '';
					$borderBottom = !empty($borderBottom) ? ' ' . $borderBottom : '';
				?>
				<ul id="modalCategoryList" class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-1 my-4 list-unstyled">
					<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$_catId = data_get($cat, 'id', 0);
							$_catIconClass = $isShowingCategoryIconEnabled ? data_get($cat, 'icon_class', 'fa-solid fa-check') : '';
							$_catIcon = !empty($_catIconClass) ? '<i class="' . $_catIconClass . '"></i> ' : '';
							$_catName = data_get($cat, 'name', '--');
							$_catType = data_get($cat, 'type');
							
							$_hasChildren = !empty(data_get($cat, 'children')) ? 1 : 0;
							$_parentId = data_get($cat, 'parent.id', 0);
							$_hasLink = ($_catId != $selectedId || $_hasChildren == 1);
							$_hasLinkClass = !$_hasLink ? ' text-secondary fw-bold' : '';
							
							$_url = urlQuery($selectionUrl)->setParameters(['parentId' => $_catId])->toString();
						?>
						<li class="col<?php echo e($_hasLinkClass); ?> my-2 px-2 d-flex justify-content-center align-content-stretch">
							<div class="w-100<?php echo e($borderBottom); ?>">
								<?php echo $_catIcon; ?>

								<?php if($_hasLink): ?>
									<a href="<?php echo $_url; ?>"
									   class="modal-cat-link <?php echo e($linkClass); ?>"
									   data-parent-id="<?php echo e($_parentId); ?>"
									   data-id="<?php echo e($_catId); ?>"
									   data-has-children="<?php echo e($_hasChildren); ?>"
									   data-type="<?php echo e($_catType); ?>"
									>
								<?php endif; ?>
									<?php echo e($_catName); ?>

								<?php if($_hasLink): ?>
									</a>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			
			<?php endif; ?>
		</div>
		<?php if($totalCategories > 0 && $areCategoriesPageable): ?>
			<br>
			<?php echo $__env->make('vendor.pagination.api.bootstrap-4', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		<?php endif; ?>
	<?php else: ?>
		<?php echo e($apiMessage ?? t('no_categories_found')); ?>

	<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/post/createOrEdit/partials/category/select.blade.php ENDPATH**/ ?>