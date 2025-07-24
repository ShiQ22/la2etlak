<?php
    $currentType = request()->query('type', '');
?>

<div class="mb-3">
    <h5 class="border-bottom pb-2"><?php echo e(t('Listing Type')); ?></h5>
    <ul class="list-unstyled mb-0">
        <li>
            <a href="<?php echo e(request()->fullUrlWithQuery(['type' => ''])); ?>"
               class="<?php echo e($currentType === '' ? 'fw-bold' : ''); ?>">
                <?php echo e(t('All')); ?>

            </a>
        </li>
        <li>
            <a href="<?php echo e(request()->fullUrlWithQuery(['type' => 'lost'])); ?>"
               class="<?php echo e($currentType === 'lost' ? 'fw-bold text-danger' : ''); ?>">
                <?php echo e(t('Lost')); ?>

            </a>
        </li>
        <li>
            <a href="<?php echo e(request()->fullUrlWithQuery(['type' => 'found'])); ?>"
               class="<?php echo e($currentType === 'found' ? 'fw-bold text-success' : ''); ?>">
                <?php echo e(t('Found')); ?>

            </a>
        </li>
    </ul>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/front/search/partials/sidebar/type.blade.php ENDPATH**/ ?>