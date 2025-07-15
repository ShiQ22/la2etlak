<?php
	$htmlLang = getLangTag(config('app.locale'));
	$htmlDir = (config('lang.direction') == 'rtl') ? ' dir="rtl"' : '';
?>
<!DOCTYPE html>
<html lang="<?php echo e($htmlLang); ?>"<?php echo $htmlDir; ?>>
<head>
	<meta charset="<?php echo e(config('larapen.core.charset', 'utf-8')); ?>">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex,nofollow">
	<meta name="googlebot" content="noindex">
	<title><?php echo $__env->yieldContent('title'); ?></title>
	
	<?php if(file_exists(public_path('manifest.json'))): ?>
		<link rel="manifest" href="<?php echo e(url()->asset('manifest.json')); ?>">
	<?php endif; ?>
	
	
	<?php if(config('lang.direction') == 'rtl'): ?>
		<link href="https://fonts.googleapis.com/css?family=Cairo|Changa" rel="stylesheet">
		<link href="<?php echo e(url(mix('dist/front/styles.rtl.css'))); ?>" rel="stylesheet">
	<?php else: ?>
		<link href="<?php echo e(url(mix('dist/front/styles.css'))); ?>" rel="stylesheet">
	<?php endif; ?>
</head>
<body class="bg-body text-body-emphasis d-flex align-items-center min-vh-100">

<div class="container text-center">
	<div class="row justify-content-center">
		<div class="col-md-8 col-lg-6">
			
			<div class="vstack gap-3">
				<div class="text-danger display-1 fw-bold border bg-body-tertiary rounded p-5">
					<?php echo $__env->yieldContent('status'); ?>
				</div>
				<h1 class="mb-0 fs-3 fw-bold text-capitalize">
					<?php echo $__env->yieldContent('title'); ?>
				</h1>
				<p class="text-secondary">
					<?php echo $__env->yieldContent('message'); ?>
				</p>
				<div class="d-flex justify-content-center">
					<a href="/" class="btn btn-primary me-1">
						<i class="bi bi-house-door me-1"></i><?php echo e(t('go_home')); ?>

					</a>
					<a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary ms-1">
						<i class="bi bi-arrow-left me-1"></i><?php echo e(t('go_back')); ?>

					</a>
				</div>
			</div>
		
		</div>
	</div>
</div>


<script src="<?php echo e(url(mix('dist/front/scripts.js'))); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\resources\views/errors/master.blade.php ENDPATH**/ ?>