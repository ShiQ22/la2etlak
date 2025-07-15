<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['breadcrumbs']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['breadcrumbs']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<nav aria-label="breadcrumb">
	<?php if(config('breadcrumbs.style') === 'bootstrap'): ?>
		<ol class="breadcrumb pb-0 mb-0">
			<?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<li class="breadcrumb-item<?php echo e($loop->last ? ' active' : ''); ?>"
				    <?php if($loop->last): ?> aria-current="page" <?php endif; ?>>
					<?php if($item['url'] && !$loop->last): ?>
						<a href="<?php echo e($item['url']); ?>" class="link-primary text-decoration-none"><?php echo e($item['title']); ?></a>
					<?php else: ?>
						<?php echo e($item['title']); ?>

					<?php endif; ?>
				</li>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ol>
	<?php else: ?>
		<ol class="breadcrumb">
			<?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($item['url'] && !$loop->last): ?>
					<li class="breadcrumb-item">
						<a href="<?php echo e($item['url']); ?>" class="link-primary text-decoration-none"><?php echo e($item['title']); ?></a>
					</li>
				<?php else: ?>
					<li class="breadcrumb-item active" aria-current="page">
						<?php echo e($item['title']); ?>

					</li>
				<?php endif; ?>
				<?php if(!$loop->last): ?>
					<span class="breadcrumb-separator"><?php echo e(config('breadcrumbs.separator')); ?></span>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ol>
	<?php endif; ?>
</nav>

<?php if(config('breadcrumbs.style') === 'custom' && config('breadcrumbs.css')): ?>
	<link rel="stylesheet" href="<?php echo e(config('breadcrumbs.css')); ?>">
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\vendor\mayeulak\breadcrumbs\src/../resources/views/breadcrumb.blade.php ENDPATH**/ ?>