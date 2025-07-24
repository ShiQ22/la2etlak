<?php if($xPanel->hasAccess('revisions') && count($entry->revisionHistory)): ?>
    <a href="<?php echo e(url($xPanel->route.'/'.$entry->getKey().'/revisions')); ?>" class="btn btn-xs btn-secondary">
        <i class="fa-solid fa-clock-rotate-left"></i> <?php echo e(trans('admin.revisions')); ?>

    </a>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/buttons/revisions.blade.php ENDPATH**/ ?>