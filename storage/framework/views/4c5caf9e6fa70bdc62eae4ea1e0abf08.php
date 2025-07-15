<script src="<?php echo e(asset('assets/plugins/jquery-validate/1.13.1/jquery.validate.min.js')); ?>" type="text/javascript"></script>
<?php
	$filePath = 'assets/plugins/jquery-validate/1.13.1/localization/messages_'.config('app.locale').'.min.js';
?>
<?php if(file_exists(public_path($filePath))): ?>
	<script src="<?php echo e(asset($filePath)); ?>" type="text/javascript"></script>
<?php endif; ?>
<script src="<?php echo e(asset('assets/plugins/jquery.payment/1.2.3/jquery.payment.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/js/app/package-payment.js')); ?>" type="text/javascript"></script>
<?php /**PATH C:\xampp\htdocs\resources\views/front/common/js/payment-scripts.blade.php ENDPATH**/ ?>