<?php
	use App\Helpers\Common\Num;
	use Illuminate\Support\Collection;
	
	$accountMenu ??= collect();
	$accountMenu = ($accountMenu instanceof Collection) ? $accountMenu : collect();
	
	// Links CSS Class
	$linkClass = linkClass('body-emphasis');
?>
<aside>
	<div class="container border rounded bg-body-tertiary p-4 p-lg-3 p-md-2 mb-sm-3 vstack gap-4">
		<?php if($accountMenu->isNotEmpty()): ?>
			<?php $__currentLoopData = $accountMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php
					$collapseId = str($group)->slug();
				?>
				<div class="">
					<h5 class="border-0 fw-bold clearfix">
						<?php echo e($group); ?>&nbsp;
						<a href="#<?php echo e($collapseId); ?>"
						   data-bs-toggle="collapse"
						   aria-expanded="false"
						   aria-controls="<?php echo e($collapseId); ?>"
						   class="float-end <?php echo e($linkClass); ?>"
						>
							<i class="fa-solid fa-angle-down"></i>
						</a>
					</h5>
					<?php if(!empty($menu)): ?>
						<div class="collapse show" id="<?php echo e($collapseId); ?>">
							<ul class="list-group">
								<?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										$activeClass = $item['isActive'] ? 'active' : '';
										$activeAttr = $item['isActive'] ? ' aria-current="true"' : '';
										$activeLinkClass = $item['isActive'] ? 'text-white' : 'link-body-emphasis';
									?>
									<li class="list-group-item d-flex justify-content-between align-items-center <?php echo e($activeClass); ?>"<?php echo $activeAttr; ?>>
										<a href="<?php echo e($item['url']); ?>" class="<?php echo e($activeLinkClass); ?> text-decoration-none">
											<i class="<?php echo e($item['icon']); ?>"></i> <?php echo e($item['name']); ?>

										</a>
										<?php if(!empty($item['countVar'])): ?>
											<span class="badge rounded-pill text-bg-secondary<?php echo e($item['cssClass'] ?? ''); ?>">
												<?php echo e(Num::short($item['countVar'])); ?>

											</span>
										<?php endif; ?>
									</li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</div>
</aside>
<?php /**PATH C:\xampp\htdocs\resources\views/front/account/partials/sidebar.blade.php ENDPATH**/ ?>