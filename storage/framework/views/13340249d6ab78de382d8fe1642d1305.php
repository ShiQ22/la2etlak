<?php if(isset($errors) && $errors->any()): ?>
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
            <h5 class="fw-bold text-danger-emphasis mb-3">
                <?php echo e(t('validation_errors_title')); ?>

            </h5>
            <ul class="mb-0 list-unstyled">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="lh-lg"><i class="bi bi-check-lg me-1"></i><?php echo $error; ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<?php
    $withMessage = !session()->has('flash_notification');
	$resendVerificationLink = getResendVerificationLink(withMessage: $withMessage);
?>

<?php if(session()->has('flash_notification')): ?>
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                <?php echo $__env->make('flash::message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if(!empty($resendVerificationLink)): ?>
    <div class="col-12">
        <div class="alert alert-info text-center">
            <?php echo $resendVerificationLink; ?>

        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/post/partials/notification.blade.php ENDPATH**/ ?>