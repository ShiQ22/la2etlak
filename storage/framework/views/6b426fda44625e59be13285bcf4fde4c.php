<?php
	$authUser ??= auth()->user();
?>
<?php $__env->startSection('search'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('search'); ?>
	<?php echo $__env->make('front.pages.contact.intro', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('front.common.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row clearfix">
				
				<?php if(isset($errors) && $errors->any()): ?>
					<div class="col-12">
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
							<h5><strong><?php echo e(t('validation_errors_title')); ?></strong></h5>
							<ul>
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><?php echo $error; ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					</div>
				<?php endif; ?>

				<?php if(session()->has('flash_notification')): ?>
					<div class="col-12">
						<div class="row">
							<div class="col-12">
								<?php echo $__env->make('flash::message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
				<div class="col-md-12">
					<div class="container border rounded bg-body-tertiary p-4 p-lg-3 p-md-2">
						<h3 class="fw-bold border-bottom pb-3 mb-4">
							<?php echo e(t('Contact Us')); ?>

						</h3>
						<div class="row d-flex justify-content-center">
							<div class="col-md-12">
								<form action="<?php echo e(urlGen()->contact()); ?>" method="post" class="<?php echo e(unsavedFormGuard()); ?> needs-validation">
									<?php echo csrf_field(); ?>
									<?php echo view('honeypot::honeypot'); ?>
									
									<fieldset>
										<div class="row">
											
											<?php echo $__env->make('helpers.forms.fields.text', [
												'label'       => t('Name'),
												'name'        => 'name',
												'placeholder' => t('enter_your_name'),
												'required'    => true,
												'value'       => $authUser->name ?? null,
												'baseClass'   => ['wrapper' => 'mb-3 col-md-6'],
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
											
											
											<?php echo $__env->make('helpers.forms.fields.text', [
												'label'       => t('company_name'),
												'name'        => 'company_name',
												'placeholder' => t('company_name'),
												'value'       => null,
												'baseClass'   => ['wrapper' => 'mb-3 col-md-6'],
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
											
											
											<?php echo $__env->make('helpers.forms.fields.email', [
												'label'       => trans('auth.email'),
												'id'          => 'contactEmail',
												'name'        => 'email',
												'placeholder' => trans('auth.email_address'),
												'required'    => true,
												'value'       => $authUser->email ?? null,
												'attributes'  => ['data-valid-type' => 'email'],
												'baseClass'   => ['wrapper' => 'mb-3 col-md-6'],
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
											
											
											<?php echo $__env->make('helpers.forms.fields.tel', [
												'label'       => trans('auth.phone_number'),
												'name'        => 'phone',
												'placeholder' => trans('auth.phone_number'),
												'required'    => true,
												'value'       => $authUser->phone ?? null,
												'baseClass'   => ['wrapper' => 'mb-3 col-md-6'],
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
											
											
											<?php echo $__env->make('helpers.forms.fields.textarea', [
												'label'         => t('Message'),
												'name'          => 'message',
												'placeholder'   => t('enter_your_message'),
												'required'      => true,
												'value'         => null,
												'attributes'    => ['rows' => 7],
												'pluginOptions' => ['height' => 200]
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
											
											
											<?php echo $__env->make('helpers.forms.fields.captcha', ['label' => trans('auth.captcha_human_verification')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
											
											
											<div class="row mb-3 mt-4">
												<div class="col-md-6 text-start">
													<button type="submit" class="btn btn-primary btn-lg btn-block">
														<?php echo e(t('submit')); ?>

													</button>
												</div>
											</div>
										</div>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php echo $__env->renderWhen(!auth()->check(), 'auth.login.partials.modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script>
		onDocumentReady((event) => {
			formValidate("form", formValidateOptions);
		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/pages/contact.blade.php ENDPATH**/ ?>