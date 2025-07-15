<?php if(!empty($wizardMenu)): ?>
	<div class="container mt-md-4 mt-3">
	    <div class="row">
	        <div class="col-12 mt-md-1 mt-sm-0 mt-0">
		        <ul class="nav nav-pills border border-primary rounded bg-body-tertiary p-2 fs-6 fw-bold">
			        <?php $__currentLoopData = $wizardMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				        <?php if(!$menu['included']) continue; ?>
				        <?php
				            $stepClass = $menu['class'] ?? null;
							$stepClass = !empty($stepClass) ? ' ' . $stepClass : '';
							$stepUrl = $menu['url'] ?? null;
							$stepLabel = $menu['label'] ?? '--';
				        ?>
				        <li class="nav-item">
					        <?php if(!empty($menu['url'])): ?>
								<?php if(str_contains($stepClass, 'active')): ?>
						            <a class="nav-link<?php echo e($stepClass); ?>" aria-current="page" href="<?php echo e($stepUrl); ?>">
							            <?php echo e($stepLabel); ?>

						            </a>
						        <?php else: ?>
							        <a class="nav-link<?php echo e($stepClass); ?>" href="<?php echo e($stepUrl); ?>">
								        <?php echo e($stepLabel); ?>

							        </a>
						        <?php endif; ?>
					        <?php else: ?>
						        <a class="nav-link disabled<?php echo e($stepClass); ?>">
							        <?php echo e($stepLabel); ?>

						        </a>
					        <?php endif; ?>
				        </li>
			        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		        </ul>
	        </div>
	    </div>
	</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/post/createOrEdit/multiSteps/partials/wizard.blade.php ENDPATH**/ ?>