<?php $__env->startSection('search'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('search'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="main-container" id="homepage">
		
		<?php if(session()->has('flash_notification')): ?>
			<?php echo $__env->make('front.common.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php
				$paddingTopExists = true;
			?>
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php echo $__env->make('flash::message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		
		<?php if(!empty($sections)): ?>
			<?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php
					$section ??= [];
					$sectionView = data_get($section, 'view');
					$sectionData = (array)data_get($section, 'data');
				?>
				<?php if(!empty($sectionView) && view()->exists($sectionView)): ?>
					<?php echo $__env->make($sectionView, [
						'sectionData'  => $sectionData,
						'firstSection' => $loop->first
					], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
		
	</div>
	
	<?php echo $__env->renderWhen(!auth()->check(), 'auth.login.partials.modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/index.blade.php ENDPATH**/ ?>